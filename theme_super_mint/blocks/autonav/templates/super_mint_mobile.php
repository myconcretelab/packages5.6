<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$time_start = microtime(true);
Loader::model('stack/model');
// Cette requete peut prendre plus d'une demi seconde !
$navItems = $controller->getNavItems();


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
}


// On commence La recherche de classes et de stacks

foreach ($navItems as $niKey => $ni) :
	$classes = array();
	$style = array();
	$col_width = 230;
	if (!$is_ecommerce) $pc[$ni->cID] = new stdClass();

	if ($ni->isCurrent || $ni->inPath)
		$classes[] = 'mm-selected';

	/* ---- STACKS -------
	 * On teste si il y a un stack *
	 * Le stack doit etre nomé de la manière suivante *
	 * mega_menu_{cID} ou mega_menu_{page-handle}
	 */

	if ($ni->level == 1) :

		$relatedStack = Stack::getByName('mega_menu_' . $ni->cID);
		// On essaie avec le nom
		$relatedStack = $relatedStack ? $relatedStack : Stack::getByName('mega_menu_' . $ni->cObj->getCollectionHandle());
		if ($relatedStack) {
			$p = new Permissions($relatedStack);
			if (!$p->canRead()) $relatedStack = false;
		}

		if ($relatedStack) :
			$blocksOk = array();
			$blocks = $relatedStack->getBlocks();
			foreach($blocks as $b) :
				$bp = new Permissions($b);
				if ($bp->canRead()) $blocksOk[] = $b;
			endforeach;		
			if(count($blocksOk) || array_key_exists($ni->cID, $pc)) :
				$ni->blocks = $blocksOk;
			endif;
		// C'est un dropdown normal
		elseif ($ni->hasSubmenu) :
			$classes[]  = '';				
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
		Loader::PackageElement("navigation/productCategoriesMobile", 'theme_super_mint', array(
			'ni' => $ni,
			'pc' => $pc[$ni->cID],
			'o' => $o,
			'h' => $h
		));
		$ni->sub = ob_get_clean();
	// Ensuite on regarde si un stack à été prévu en temps que sous menu.
	elseif ($ni->blocks) :

		ob_start();
		Loader::PackageElement("navigation/stackMobile", 'theme_super_mint', array(
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



?>

	<nav id="mobile_nav" class="mm-menu">
		<ul>
<?php
foreach ($navItems as $k=>$ni) :
	
	if($ni->level != 1 ) continue;
	if ($ni->cObj->vObj->cvHandle == 'search') continue; 
	
	echo '<li class="' . $ni->classes . '">'; //opens a nav item
	// L'url est remplacé par # si il y a un sous mennu
	// C'est malheureusement la condition sine qua non pour que le menu fonctionne en mode mobile
	echo '<a href="' .  $ni->url . '" target="' . $ni->target . '" style="' . $ni->style . '">' . $ni->name . '</a>';

	if($ni->sub) echo $ni->sub;
	
	echo '</li>';
	
	// Si le menu est selectionnŽ ou un de ses enfant
	if ($ni->isCurrent || $ni->inPath) {
		// On recupere lequel est selectionnŽ ou enfant
		$selected_item_index = $i;
	}
	$i ++;
	
endforeach ?>
	</ul>
</nav>

<script>
$(function() {
	$('nav#mobile_nav .nav-pane-product-a').click(function(e){
		var t = $(this);
		//t.parents('form').submit();
	});
});

</script>
<!-- Prepared mobile nav in <?php echo  microtime(true) - $prepare_start  ?>s  generated in <?php echo  microtime(true) - $time_start ?> -->