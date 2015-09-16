<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('stack/model');
// Cette requete peut prendre plus d'une demi seconde !
$navItems = $controller->getNavItems();

$time_start = microtime(true);
$prepare_start = microtime(true);
$i = 0;
// Les options
Loader::model('theme_super_mint_options', 'theme_super_mint');
$o = new ThemeSuperMintOptions(Page::getCurrentPage());

// Reglage ecommerce
$pc = array();
$h = Loader::helper('super_mint_theme', 'theme_super_mint');
// On verifie si le package ecommerce existe
$is_ecommerce =  $h->is_ecommerce;
if ($is_ecommerce) :
	Loader::model('sm_page_product_category','theme_super_mint');
	$pc = SmPageProductCategory::getAll();
else :
	$pc = array();
endif;

// $n est un tableau represantant toutes les cID,
// Peut être utile si il faut gagner de la performance..
foreach ($navItems as $navItem) {
	if ($navItem->level == 1) :
		$l1 = $navItem->cID;
		$navItem->childrens = $navItem->cObj->getCollectionChildrenArray();
	elseif ($navItem->level == 2 ) :
		$l2 = $navItem->cID;
		$n[$l1][$navItem->cID] = array();
		$navItem->childrens = $navItem->cObj->getCollectionChildrenArray();
		$subNavItems[$navItem->cID] = $navItem;
	elseif ($navItem->level == 3 ) :
		$n[$l1][$l2][$navItem->cID] = array();
		$subsubNavItems[$navItem->cID] = $navItem;
	endif;
	// $nObj est plat et contiendra tous les $ni
	// classé par cID.
	// Il suffira de parcourir le tableau $n et de recherher les cID dans $nObj
	// Cela gagnera 0,04s de performance en evitant d'apeller getCollectionChildrenArray()
	$nObj[$navItem->cID] = $navItem;
}


// On commence La recherche de classes et de stacks

foreach ($navItems as $niKey => $ni) :

	$classes = array();
	$style = array();
	$col_width = 230;
	if (!$is_ecommerce) $pc[$ni->cID] = new stdClass();

	if ($ni->cObj->getAttribute('main_page_color'))
		$style[] = 'border-bottom-color:' . $ni->cObj->getAttribute('main_page_color');

	if ($ni->isCurrent || $ni->inPath)
		$classes[] = 'active';

	/* ---- STACKS -------
	 * On teste si il y a un stack *
	 * Le stack doit etre nomé de la manière suivante *
	 * mega_menu_{cID} ou mega_menu_{page-handle}
	 */

	if ($ni->level == 1) :

		// Maintenant on va voir si il y a des bloc autorisé dans un stack relatif.
		// Si oui on les definis dans $ni->blocks
		$relatedStack = Stack::getByName('mega_menu_' . $ni->cID);
		// On essaie avec le nom
		$relatedStack = $relatedStack ? $relatedStack : Stack::getByName('mega_menu_' . $ni->cObj->getCollectionHandle());
		$blocksOk = array();
		if ($relatedStack) {
			$p = new Permissions($relatedStack);
			if (!$p->canRead()) :
				$relatedStack = false;
			else :
				$blocks = $relatedStack->getBlocks();
				foreach($blocks as $b) :
					$bp = new Permissions($b);
					if ($bp->canRead()) $blocksOk[] = $b;
				endforeach;
			endif;
			if(count($blocksOk)) $ni->blocks = $blocksOk;

		}

		// Maintenant on va déterminer les classes pour le dropdown
		if(count($blocksOk) || array_key_exists($ni->cID, $pc)) :
			// On prend la valeur de l'option
			$ni->full_width_mega = $o->full_width_mega;
			// On ecrase cette valeur avec celle definie dans la page ecommerce
			if ($pc[$ni->cID]->full_width_mega == 'full')
				$ni->full_width_mega = true;
			elseif ($pc[$ni->cID]->full_width_mega == 'align') 
				$ni->full_width_mega = false;
			// Si on desire que le mega menu s'ouvre sur toute la largeur du menu
			if ($ni->full_width_mega) {
				$classes[] = 'mzr-drop mzr-full-width';
			// Ou alors on le place sous le menu supérieur
			} else {
				$classes[] = 'mzr-drop';
				//$style[] = 'width:' . intval(200 * count($blocksOk)) . 'px';
				$ni->mega_menu_width = intval($col_width * count($blocksOk));
			}
		// C'est un dropdown normal
		elseif ($ni->hasSubmenu) :
			$classes[]  = 'mzr-drop mzr-levels';				
		endif;
	endif;
	$ni->classes = implode(" ", $classes);
	$ni->style = implode(";", $style);
endforeach;

foreach ($navItems as $niKey => $ni) :
	/* 
	 * Maintenant on imprime les sous menu dans une variable $ni->sub
	 */

	if (array_key_exists($ni->cID, $pc ) && count($pc[$ni->cID]->categories)) :
		ob_start();
		Loader::PackageElement("navigation/productCategories", 'theme_super_mint', array(
			'ni' => $ni,
			'pc' => $pc[$ni->cID],
			'o' => $o,
			'h' => $h
		));
		$ni->sub = ob_get_clean();
	// Ensuite on regarde si un stack à été prévu en temps que sous menu.
	elseif ($ni->blocks) :
		ob_start();
		Loader::PackageElement("navigation/stack", 'theme_super_mint', array(
			'ni' => $ni,
			'o' => $o
		));							
		$ni->sub = ob_get_clean();
	// On charge le template 'drop'	
	elseif ($ni->hasSubmenu && $ni->level == 1) :
		ob_start();
		Loader::PackageElement("navigation/drop", 'theme_super_mint', array(
			'navItems'=> $navItems,
			'niKey' => $niKey, 
			'subNavItems' => $subNavItems,
			'subsubNavItems' => $subsubNavItems,
			'o' => $o
			));
		$ni->sub = ob_get_clean();
	endif;

endforeach;

?><!-- Prepared nav in <?php echo  microtime(true) - $prepare_start ?>s  -->
<div id="top_nav" class="top_nav_meganizr top_nav">
	<ul class="meganizr mzr-class mzr-fade mzr-responsive nav container" >
<?php
foreach ($navItems as $k=>$ni) :
	
	if($ni->level != 1 ) continue;
	
	echo '<li class="' . $ni->classes . '">'; //opens a nav item
	// L'url est remplacé par # si il y a un sous mennu
	// C'est malheureusement la condition sine qua non pour que le menu fonctionne en mode mobile
	//if ($ni->hasSubmenu || $ni->blocks || array_key_exists($ni->cID, $pc ))
	//	echo '<a style="' . $ni->style . '">' . $ni->name . '<a href="' .   $ni->url . '" target="' . $ni->target . '"> <i class="fa fa-angle-right"></i></a></span>';
	//else
		echo '<a href="' .   $ni->url . '" target="' . $ni->target . '" style="' . $ni->style . '">' . $ni->name . '</a>';
	
	if($ni->sub) echo $ni->sub;
	
	echo '</li>';
	
	// Si le menu est selectionnŽ ou un de ses enfant
	if ($ni->isCurrent || $ni->inPath) {
		// On recupere lequel est selectionnŽ ou enfant
		$selected_item_index = $i;
	}
	$i ++;
	
endforeach?>
	
<?php
if($o->display_searchbox) :
	$p = Page::getByID($o->display_searchbox);
	if (is_object($p)) :
 ?>
	<li class="search-in-nav">
	<form action="<?php  echo  Loader::helper('navigation')->getCollectionURL($p)?>" id="expand-search">
	   <input type="search" class="span3" id="search-keywords" name="query"/>
	   <!-- <input type="submit" id="search-go" name="go" value="go"/> -->
	</form>
	</li>
	<?php endif ?>		
<?php endif ?>		
	</ul>
</div>