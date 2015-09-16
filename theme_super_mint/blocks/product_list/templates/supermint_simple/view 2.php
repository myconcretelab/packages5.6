	<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));  

global $c;

$uh = Loader::helper('urls', 'core_commerce');
$im = Loader::helper('image');
$form = Loader::helper('form');
$h = Loader::helper('super_mint_theme', 'theme_super_mint');

Loader::model('theme_super_mint_options', 'theme_super_mint');
$o = new ThemeSuperMintOptions(Page::getCurrentPage());


$searchGrid = array(
	'advanced' => array(
		'keyword' => 'span2',
		'filters' => 'span2',
		'results' => 'span3',
		'pagination' => 'span5'
		),
	'advanced_sort' => array (
		'keyword' => 'span2',
		'filters' => 'span2',
		'results' => 'span3',
		'sort' => 'span2',
		'pagination' => 'span3'
		),
	'simple' => array (
		'keyword' => 'span3',
		'results' => 'span4',
		'pagination' => 'span5'
		),
	'simple_sort' => array (
		'keyword' => 'span2',
		'results' => 'span3',
		'sort' => 'span3',
		'pagination' => 'span4'
		)
	);

	/* -- Decider de la structure de formulaire à adopter -- */

if ($options['show_products'] || ($options['show_products'] && $_REQUEST['search'] == '1')) {
  	if ($options['search_mode'] == 'advanced') $searchGridType =  'advanced';
  	if ($options['search_mode'] == 'simple') $searchGridType =  'simple';
  	if (count($sort_columns)>0) $searchGridType .= '_sort';
	$searchGridType = $searchGrid[$searchGridType];
}
	/* -- Decider si on affiche le formulaire ou pas -- */

if ( $options['search_mode'] == 'advanced' || $options['search_mode'] == 'simple' && $o->display_simple_search == 1 ) $displayForm = 1; 

	/* -- PRoceder à l'analyse des produits à afficher -- */

if ($options['show_products'] || ($options['show_products'] && $_REQUEST['search'] == '1')) { 
	$nh = Loader::helper('navigation');
	
	$productList = $this->controller->getRequestedSearchResults();
	if ($options['hide_sold_out']) {
		$productList->displayOnlyProductsWithInventory();
	}
	$products = $productList->getPage();
	$paginator = $productList->getPagination();


	/* ------------------------------------ */
	/* ---- Le formulaire de recherche ---- */
	/* ------------------------------------ */

	if ($options['show_search_form']) :
	//extract($controller->block_args);
	$search = $controller->block_args;
	if (!is_array($_REQUEST['selectedSearchField'])) $_REQUEST['selectedSearchField'] = array();

	$uh = Loader::helper('concrete/urls');
	Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
	$searchFieldAttributes = CoreCommerceProductAttributeKey::getSearchableList();

	//filter unsopported attributes untill we fix them
	$validAttributes = array();
	foreach($searchFieldAttributes as $ak) {
		$type = $ak->getAttributeKeyType()->getAttributeTypeHandle();
		if (!in_array($type,array('text','textarea','boolean','number','select'))) continue;
		$validAttributes[] = $ak;
		$searchFields[$ak->getAttributeKeyID()] = $ak->getAttributeKeyName();
	}

	if ($baseSearchPath == "OTHER" && $searchUnderCID > 0) {
		$target = Page::getById($searchUnderCID);	
	}
	if (!$target || $target->getCollectionID() == 0) {
		$target = $c;
	}

	/* -- Maintenant que c'est calcule, on regarde si on affiche physiquement le formulaire  -- */

	if ($displayForm) :	
	?>

<form method="GET" class="product-list-core-commerce-product-advanced-search" action="<?php echo $this->url($target->getCollectionPath());?>">
	<input type="hidden" name="search" value="1" />

	<?php 
		/*************************/
		/* Search navigation *****/
		/*************************/
	 ?>
	<div class="row-fluid sm-prl-nav" id="bx-pager-<?php echo $bID ?>">
		<!-- Keyword -->
		<div class="<?php echo $searchGridType['keyword'] ?>">
			<a href="#" data-relpane="#sm-prs-keyword<?php echo $bID?>" class="relpane"><i class="fa fa-search fa-lg"></i> <?php echo t('Keyword'); ?></a>
		</div>
		<?php  if ($options['search_mode'] == 'advanced') : ?>
		<!-- Filters -->
		<div class="<?php echo $searchGridType['filters'] ?>">
			<a href="#" data-relpane="#sm-prs-filter<?php echo $bID?>" class="relpane" ><i class="fa fa-filter fa-lg"></i> <?php echo t('Filters'); ?></a>
		</div>
		<?php endif ?>
		<div class="<?php echo $searchGridType['results'] ?> sm-prs-drop">
			<a href="#" class=""><i class="fa fa-sort-numeric-asc fa-lg"></i> <?php echo t('Results Per Page')?></a>
			<ul id="sm-prs-result-ppage">
				<li><label class="fake-radio"><input type="radio" name="numResults" value="10" <?php echo $_REQUEST['numResults'] == '10' ? 'checked' : '' ?> />10</label></li>
				<li><label class="fake-radio"><input type="radio" name="numResults" value="20" <?php echo $_REQUEST['numResults'] == '20' ? 'checked' : '' ?> />20</label></li>
				<li><label class="fake-radio"><input type="radio" name="numResults" value="50" <?php echo $_REQUEST['numResults'] == '50' ? 'checked' : '' ?> />50</label></li>
				<li><label class="fake-radio"><input type="radio" name="numResults" value="100"  <?php echo $_REQUEST['numResults'] == '100' ? 'checked' : '' ?>/>100</label></li>
			</ul>
		</div>

		<?php if (count($sort_columns)>0) : ?>

		<div class="<?php echo $searchGridType['sort'] ?> sm-prs-drop">
			<a href="#" class=""><i class="fa fa-sort-amount-asc fa-lg"></i> <?php echo  t('Sort by:'); ?></a>
			<ul id="sm-prs-sort" style="width:250px">
				<?php 
				$current_col = $_REQUEST['ccm_order_by_b'. $b->bID];
				foreach ($sort_columns as $col => $name) : ?>
				<li><label class="fake-radio-url"><input type="radio" name="numResults" value="<?php echo $productList->getSortByURL($col, 'asc', $bu) ?>" <?php echo ($current_col == $col && $_REQUEST['ccm_order_dir_b'. $b->bID] == 'asc') ? "checked" : "" ?> /><?php echo $name. ' ' . t('Ascending')  ?></label></li>
				<li><label class="fake-radio"><input type="radio" name="numResults" value="<?php echo $productList->getSortByURL($col, 'desc', $bu) ?>" <?php echo ($current_col == $col && $_REQUEST['ccm_order_dir_b'. $b->bID] == 'desc') ? "checked" : "" ?> /><?php echo $name. ' ' . t('Descending')  ?></label></li>
				<?php endforeach?>				
			</ul>
		</div>
		<?php endif ?>			
		<div class="<?php echo $searchGridType['pagination'] ?>">
			<div class="pagination">	
		        <ul class="pagination">
		            <li><?php  echo $paginator->getPrevious(t('Prev'), 'a') ?></li>
		            <?php  echo $paginator->getPages('li') ?>
		            <li><?php  echo $paginator->getNext(t('Next'), 'a') ?></li>
		        </ul>
			</div>				
		</div>
		
	</div><!-- .row-fluid -->
	<?php 
		/*************************/
		/***** Search panes ******/
		/*************************/
	 ?>
	<div class="sm-pr-search-slide">
		<!-- Keywords -->
		<div id="sm-prs-keyword<?php echo $bID?>" class="relpane-slide search-field ">
			<h5><?php echo t('Keyword') ?></h5>
			<?php echo $form->text('keywords', $_REQUEST['keywords'])?>
			<div class="center">
				<input type="submit" class="button button-flat-primary" id="product-list-search-core-commerce-products" name="product-list-search-core-commerce-products" value="<?php echo t('Update results') ?>">	
			</div>
		</div>
		<?php  if ($options['search_mode'] == 'advanced') : ?>
		<!-- Filters --> 
		<div  id="sm-prs-filter<?php echo $bID?>" class="relpane-slide">
			<div class="row-fluid">
				<!-- Price Range -->
				<div class="span4 search-field">
					<h5><?php echo t('Price range') ?><span id="price-slider-count<?php echo $bID?>" class="filter_count" <?php echo $_REQUEST['price_from'] ? 'style="display:inline-block"' : ''?>><?php echo $_REQUEST['price_from'] ? ('$' . $_REQUEST['price_from'] . ' - $' . $_REQUEST['price_to']) : ''?></span></h5>
					<br>
					<div id="price-slider<?php echo $bID?>"></div>
					<input type="hidden" name="price_from" id="price_from<?php echo $bID?>" value="<?php echo $_REQUEST['price_from'] ?>" />
					<input type="hidden" name="price_to" id="price_to<?php echo $bID?>" value="<?php echo $_REQUEST['price_to'] ?>" />
				</div>
				<div class="span8">					
						<?php 
						foreach ($validAttributes as $key => $ak) :
							if ($key%$o->categories_columns_number == 0) echo'<div class="row-fluid">';
							$i = $ak->getAttributeKeyID();
							$selectedOptions = $_REQUEST['akID'][$i]['atSelectOptionID'];
							if (!is_array($selectedOptions)) $selectedOptions = $_REQUEST['akID'][$i];
							$countOptions = is_array($selectedOptions) ? count(($selectedOptions)) : false;
						?>						
						<div class="span<?php echo 12 / $o->categories_columns_number?> search-field">							
							<input type="hidden" value="<?php echo  $i ?>" class="product-list-core-commerce-product-selected-field" name="selectedSearchField[]" />
							<h5><?php echo  $ak->getAttributeKeyName()?><span class="filter_count" <?php echo $countOptions ? 'style="display:inline-block"' : ''?>><?php echo $countOptions ? $countOptions : '' ?></span></h5>
							<?php $ak->render('search')?>														
						</div>
						<?php if ( $key%$o->categories_columns_number == ($o->categories_columns_number) - 1 || ($key == count($validAttributes)-1) ) echo '</div>';
						endforeach ?>	
				</div>
				<div style="clear:both"></div>
			</div><!-- .row-fluid -->
			<div class="center">
				<input type="submit" class="button button-flat-primary" id="product-list-search-core-commerce-products" name="product-list-search-core-commerce-products" value="<?php echo t('Update results') ?>">	
			</div>
		</div><!-- .sm-prs-filter -->
		<?php endif ?>
	</div><!-- .sm-pr-search-slide -->
<?php   ?>
</form>
<?php 
	endif; // if ($displayForm)
endif;

	/* ------------------------------------ */
	/* ---- Fin formulaire de recherche --- */
	/* ------------------------------------ */

if(count($products)>0) : 
	// -- Display the Summary -- //
	$productList->displaySummary(); 
			
	/* -- Manage row number -- */
	$rpr = $h->getClosestColumnsNumber($layout['records_per_row']);
	$span = 'span' . ( 12 / $rpr);
	echo '<div id="pr-list-simple-' . $bID . '">';
	/* --Turn, turn, turn on products ! -- */
	foreach ($products as $i => $product) :
		
		if ($i%$rpr == 0) echo '<div class="row-fluid product-list-row">';
		
		$pr = $product;
		$args['product'] = $pr;
		$args['valign'] = $layout['cell_vertical_align'];
		$args['halign'] = $layout['cell_horizontal_align'];
		$args['id'] = $pr->getProductID() . '-' . $b->getBlockID();
		// Supermint Stuffs
		$args['t'] = $t;
		$args['o'] = $o;

		foreach($this->controller->getSets() as $key => $value) {
			$args[$key] = $value;
		}

		//  print out responsives divs
		
		print '<div class="' . $span . ' pr_simple">';
			Loader::element('product/display', $args, 'theme_super_mint');
		print '</div>';

		if ( $i%$rpr == ($rpr) - 1 || ($i == count($products)-1) ) echo '</div><!-- row-fluid -->';
	endforeach;
	echo "</div><!-- #pr-list-simple -->";	
	else :
		$noProductsStack = Stack::getByName('no_products_found');
		if ($noProductsStack) {
			$p = new Permissions($noProductsStack);
			if (!$p->canRead()) $noProductsStack = false;
		}
		if ($noProductsStack) :
			$blocksOk = array();
			$blocks = $noProductsStack->getBlocks();
			foreach($blocks as $b) {
				$bp = new Permissions($b);
				if ($bp->canRead()) {
					$blocksOk[] = $b;		
				}
			}		
			if(count($blocksOk)) :
				echo '<div class="row-fluid">';
				foreach ($blocksOk as $key => $block) :
					echo '<div class="span12">';
				 	$block->display();
				 	echo '</div>';
				endforeach;
				echo '</div> <!-- row-fluid -->';					
			endif;
		else :
			echo '<p>' . t('No products found') . '</p>';
		endif;
	 ?>
	<?php  endif // count($products) ?>
<?php }?>

<style>
#pr-list-simple-<?php echo $bID ?> .pr_simple {
    background-color: #fff;
}	
</style>
<script>
	$('#price-slider<?php echo $bID?>').slider({
		min:<?php echo $o->min_price_search ?>,
		max:<?php echo $o->max_price_search ?>,
		step:<?php echo $o->step_price_search ?>,
		values: [ <?php echo $_REQUEST['price_from'] ? $_REQUEST['price_from'] : $o->min_price_search_default ?>, <?php echo $_REQUEST['price_to'] ? $_REQUEST['price_to'] : $o->max_price_search_default ?> ],
		animate :true,
		slide: function( event, ui ) {
        	$( "#price-slider-count<?php echo $bID?>" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      	},
		start: function( event, ui ) {
        	if (!$( "#price-slider-count<?php echo $bID?>" ).is(':visible')) $("#price-slider-count<?php echo $bID?>" ).show();
      	},
		change: function( event, ui ) {
        	$( "#price_from<?php echo $bID?>" ).val(ui.values[ 0 ]);
        	$( "#price_to<?php echo $bID?>" ).val(ui.values[ 1 ]);
      	}
	});
</script>				
