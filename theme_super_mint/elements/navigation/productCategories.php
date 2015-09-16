<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$start = microtime(true);
$nh = Loader::helper('navigation');

$o->numResults = 10;
$display_empty_categories = $pc->display_empty_categories == 'default' ? $o->__display_empty_categories('e_commerce') : $pc->display_empty_categories;

//  If some block have been found on a related stack.
if ($ni->blocks) :
	/*
	 *	We will construct the layout based on blocks name
	 */
	foreach ($ni->blocks as $n => $block) :
		$block->title = $block->getBlockName() ? $block->getBlockName() : '';
		if (stripos($block->title, '-after-') === 0) :
			$block->title = str_replace('-after-', '', $block->title);
			$layout['footer'][] = $block;
		elseif (stripos($block->title, '-left-') === 0) :
			$block->title = str_replace('-left-', '', $block->title);
			$layout['left'][] = $block;
		elseif (stripos($block->title, '-right-') === 0) :
			$block->title = str_replace('-right-', '', $block->title);
			$layout['left'][] = $block;
		else :
			$layout['header'][] = $block;
		endif;
	endforeach;
endif;

foreach($pc->categories as $akID => $akObj) :
	$display_options = array();
	$akClass = $akID == $pc->active_akID ? 'active' : '';

	foreach ($pc->options[$akID] as $oObj ):
		// Si on demande de n'afficher que les categ AVEC produits
		$countProduct = $pc->containsProducts($oObj->ID, $akID);
		
		// Si il n'y a pas de produits, on passe
		if(!$countProduct && !$display_empty_categories) continue;
		
		if($pc->category_result_page) :
			ob_start();
			$oclass = in_array($oObj->ID, $pc->active_oID[$akID]) ?  'active' : '';
		?><li class="<?php echo $oclass ?>">
			<input id="option<?php echo $oObj->ID ?>" type="checkbox" name="akID[<?php echo  $akObj->akID ?>][atSelectOptionID][]" value="<?php echo $oObj->ID ?>" class="pc_check <?php if ($pc->alow_multiple_choice) :?>pc_check_visible<?php endif ?>" <?php echo $oclass ? 'checked' : '' ?>>
			<?php if (!$pc->alow_multiple_choice) :?><i class="fa fa-angle-right"></i><?php endif ?>				
			<a href="#" <?php echo $active ?>data-check="#option<?php echo $oObj->ID ?>" class="nav-pane-product-a"><?php echo $oObj->value ?><?php if($pc->show_product_count_on_nav) : echo ' (' . $countProduct .')'; endif ?></a></li><?php 
		$display_options[] = trim(ob_get_clean());
		endif;
	endforeach;
	// Si il n'y a pas de categories et qu'on ne demande pas d'afficher les categ vides
	if (!count($display_options) && !$display_empty_categories) continue;
	

	/* Ce qui suit n'a plus raison d'être vu que le premier niveau de navigation est maintenant cliquable 
	// On va tester si une page existe en dessous de celle ci 
	// avec comme handle le nom de la categorie
	// On transforme les underscore en tiret
	// marque_produit devient marque-produit
	$headCatPath = $ni->cObj->cPath . '/' . str_replace('_', '-', $akObj->akHandle);
	$headCatPage = Page::getByPath($headCatPath);

	// On test si elle existe
	if ($headCatPage->cID && $pc->display_title) :
		$l = $nh->getLinkToCollection($headCatPage);
		$n = $pc->akObj->akName;
		$headCatTag = "<li class='head-title $akClass'><a href='$l'>$n</a></li>";
	*/
	$headCatTag = '';		
	if ($pc->display_title[$akID] && $pc->ak_title[$akID]) :
		$headCatTag = "<li class='head-title $akClass'><span>{$pc->ak_title[$akID]}</span></li>";
	elseif ($pc->display_title[$akID]) :
		$headCatTag = "<li class='head-title $akClass'><span>$akObj->akName</span></li>";
	endif;

	if(count($display_options)) :
		// On ajoute le contenu dans la colonne
		$layout['columns'][$akID] = "\n<!-- A head category page can be at : $headCatPath -->";
		$layout['columns'][$akID] .= '<input type="hidden" value="' . $akID . '" name="selectedSearchField[]">';
		$layout['columns'][$akID] .= '<ul class="product_categories" style="float:left;">' ;
		$layout['columns'][$akID] .= $headCatTag;
		foreach ($display_options as $li) $layout['columns'][$akID] .= $li;
		$layout['columns'][$akID] .= '</ul>';
		/*
		<input type="hidden" name="keywords" value="">
		<input type="hidden" name="price_from" value="">
		<input type="hidden" name="price_to" value="">
		<input type="hidden" name="searchField" value="">
		*/		
	endif;
endforeach;

// petit calcul pour les colonnes
$calculated_columns_number_from_cat = $h->getClosestColumnsNumber(count($layout['columns']));
if ($pc->columns) :
	// Si le nombre de categories dépasse le nombre maximum de colonnes, on prend le nb de cat
	if ($pc->columns > $calculated_columns_number_from_cat) $columns_number = $calculated_columns_number_from_cat;
	else $columns_number = $pc->columns;
else : $columns_number = $calculated_columns_number_from_cat;
endif;
// Petit calcul du nb de colonne dans la nav
$menu_col_number = 0;
if ( (isset($layout['left'])) ) $menu_col_number++;
if ( (isset($layout['right'])) ) $menu_col_number++;
//if ( (isset($layout['columns']) ) $menu_col_number++;

?>

<div class='nav-pane product-nav-pane' data-formselector="#product_<?php echo $ni->name ?>" data-opened="onload" style="<?php if(!$ni->full_width_mega) : ?>width:<?php echo intval($columns_number * $o->mega_columns_width) + ($menu_col_number *  $o->mega_columns_width) + (($columns_number + $menu_col_number ) * 10 ) + 40?>px<?php endif ?>" > <!-- pane <?php echo $ni->name ?>-->
	<!-- <?php if ($o->__display_full_category_link('e_commerce')) : ?><a href="<?php echo $ni->url ?>" class="button button-block button-flat-primary"><?php echo t('View all ') . $ni->name ?></a><?php endif ?> -->
	<div class="padding">
		<div class="row-fluid">
<?php 

//  Left side 

if (isset($layout['left'])):
	echo '<div class="span3">';
	foreach ($layout['left'] as $block) {
		// On affiche le titre et le bloc;	
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	}
	echo '</div> <!-- span3 -->';
endif;


// central side
echo '<div class="span' . (12 - ( 3 * $menu_col_number )) . '">';

if (isset($layout['header'])):
	echo '<div class="row-fluid">';
	foreach ($layout['header'] as $n => $block) {
		// On affiche le titre et le bloc;
		echo '<div class="span12">';
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	 	echo '</div>';
	}
	echo '</div> <!-- row-fluid -->';
endif;
?>
<form id="product_<?php echo $ni->name ?>" action="<?php  echo $nh->getLinkToCollection(Page::getByID($pc->category_result_page))?>" method="GET" class="nav-pane-product-form">
	<input type="hidden" name="search" value="1" />
	<input type="hidden" name="numResults" value="<?php echo $o->num_results ?>">
	<input type="hidden" name="pcID" value="<?php echo $pc->category_result_page ?>">

<?php

	if (isset($layout['columns'])):
		$span = 'span' . (intval( 12 / $columns_number));
		$k = 0;
		// SI il y avait un header on le sépare
		if (isset($layout['header'])) echo '<hr class="dashed">';
		foreach ($layout['columns'] as $columns) {
			if ($k%$columns_number == 0) echo '<div class="row-fluid">';
			echo '<div class="' . $span . '">';
			echo $columns;
		 	echo '</div> <!-- .' . $span . '-->';
		 	if ( $k%$columns_number == ($columns_number) - 1 || ($k == count($layout['columns'])-1) ) echo '</div> <!-- row-fluid -->';
		 	$k ++;
		}
	endif;		


	$t =  microtime(true) - $start ?>
	<button class="button button-flat-primary button-block nav-pane-product-submit"><?php echo ('Display products') ?></button>
	<?php if (isset($layout['header'])) echo '<hr class="dashed">' ?>
</form>
<?php 
/*
 *	If they are blocks for the footer full width
 */

if (isset($layout['footer'])):
	echo '<div class="row-fluid">';
	foreach ($layout['footer'] as $n => $block) {
		// On affiche le titre et le bloc;
		echo '<div class="span12">';
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	 	echo '</div>';
	}
	echo '</div> <!-- row-fluid -->';
endif;
?>			</div><!-- .central column -->

<?php 

//  right side 

if (isset($layout['right'])):
	echo '<div class="span3">';
	foreach ($layout['right'] as $block) {
		// On affiche le titre et le bloc;	
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	}
	echo '</div> <!-- span3 -->';
endif;
 ?>
		</div><!-- .row-fluid -->
	</div><!-- padding -->
</div><!-- nav-pane -->
 <!-- /pane  <?php echo $ni->name .",  Generated in $t s-->\n"?>
