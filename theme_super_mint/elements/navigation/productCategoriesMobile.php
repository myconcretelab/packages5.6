<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$start = microtime(true);
$nh = Loader::helper('navigation');

$o->numResults = 10;
$display_empty_categories = $pc->display_empty_categories == 'default' ? $o->__display_empty_categories('e_commerce') : $pc->display_empty_categories;

foreach($pc->categories as $akID => $akObj) :
	$display_options = array();
	// On regarde d'abord si les options de la categories contiennent des produits
	foreach ($pc->options[$akID] as $oObj ):
		// Si on demande de n'afficher que les categ AVEC produits
		$countProduct = $pc->containsProducts($oObj->ID, $akID);
		
		// Si il n'y a pas de produits, on passe
		if(!$countProduct && !$display_empty_categories) continue;
		
		if($pc->category_result_page) :
			// On va voir si on peut determiner ce menu comme selectionne
			ob_start();
			//var_dump($_GET['akID'][$akID]['atSelectOptionID']);
			?><li class="<?php echo in_array($oObj->ID, $pc->active_oID) ?  'mm-selected' : '' ?>">
			<input id="option<?php echo $oObj->ID ?>" type="checkbox" name="akID[<?php echo  $akObj->akID ?>][atSelectOptionID][]" value="<?php echo $oObj->ID ?>" class="pc_check" style="display:none">
			<a href="#" <?php echo $active ?>data-check="#option<?php echo $oObj->ID ?>" class="nav-pane-product-a"><?php echo $oObj->value ?><?php if($pc->show_product_count_on_nav) : echo ' (' . $countProduct .')'; endif ?></a>
			</li>
			<?php 
			$display_options[] = ob_get_clean();
		endif;
	endforeach;
	// Si il n'y a pas de categories et qu'on ne demande pas d'afficher les categ vides
	if (!count($display_options) && !$display_empty_categories) continue;
	
	// On va tester si une page existe en dessous de celle ci 
	// avec comme handle le nom de la categorie
	// On transforme les underscore en tiret
	// marque_produit devient marque-produit
	$headCatPath = $ni->cObj->cPath . '/' . str_replace('_', '-', $akObj->akHandle);
	$headCatPage = Page::getByPath($headCatPath);
	$headCatTag = '';
	// On test si elle existe
	if ($headCatPage->cID && $pc->display_title) :
		$l = $nh->getLinkToCollection($headCatPage);
		$n = $pc->akObj->akName;
		$headCatTag = "<a href='$l'>$n</a>";
	elseif ($pc->display_title[$akID] && $pc->ak_title[$akID]) :
		$headCatTag = "<a>{$pc->ak_title[$akID]}</a>";
	elseif ($pc->display_title[$akID]) :
		$headCatTag = "<a>$akObj->akName</a>";
	else :
		$headCatTag = "<a>$akObj->akName</a>";
	endif;

	if(count($display_options)) : 
		ob_start();
		?>
		<em class="Counter"><?php echo count($display_options) ?></em>
		<?php echo $headCatTag ?>
		<div style="padding:0" class="product-nav-pane">
			<form id="" class="nav-pane-product-form" method="GET" action="<?php echo $nh->getLinkToCollection(Page::getByID($pc->category_result_page)) ?>">
			<input type="hidden" value="<?php echo $akID  ?>" name="selectedSearchField[]">
			<input type="hidden" name="search" value="1" />
			<input type="hidden" name="numResults" value="<?php echo $o->numResults ?>">
			<input type="hidden" name="pcID" value="<?php echo $pc->category_result_page ?>">
			<ul class="List">
			<?php foreach ($display_options as $li) echo $li; ?>
			</ul>
		</form>
		</div>
		
		<?php 
		$layout['columns'][$akID] = ob_get_clean();
		/*
		<input type="hidden" name="keywords" value="">
		<input type="hidden" name="price_from" value="">
		<input type="hidden" name="price_to" value="">
		<input type="hidden" name="searchField" value="">
		*/

	endif;
endforeach;

echo '<ul>';
	if (isset($layout['columns'])):
		foreach ($layout['columns'] as $akID => $columns) {
			echo '<li class="'  . ($akID == $pc->active_akID ? 'mm-selected' : '') . '">';
			echo $columns;
		 	echo '</li>';
		 	$k ++;
		}
	endif;		
	$t =  microtime(true) - $start;
echo '</ul>' ?>
<!-- /mobile pane  <?php echo $ni->name .",  Generated in $t s-->\n"?>
