<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 

<div id="ccm-core-commerce-product-search-results" class="ccm-file-list">

<div id="ccm-list-wrapper"><a name="ccm-core-commerce-product-list-wrapper-anchor"></a>

	<div style="margin-bottom: 10px; text-align: right">
		<a href="<?php echo View::url('/dashboard/core_commerce/products/add')?>" class="btn primary"><?php echo t("Add Product")?></a>
	</div>


<?php 
	if (!$mode) {
		$mode = $_REQUEST['mode'];
	}
	
	?>
	
	<?php 
	$txt = Loader::helper('text');
	$keywords = $_REQUEST['keywords'];
	$uh = Loader::helper('concrete/urls');
	$soargs = array();
	$soargs['searchType'] = $searchType;
	$bu = $uh->getToolsURL('search_results','mylab_product_attribute');
	
	if (count($products) > 0) { ?>	
		<table border="0" cellspacing="0" cellpadding="0" id="ccm-product-list" class="ccm-results-list">
		<tr>
			<?php  /*
			<th><input id="ccm-core-commerce-product-list-cb-all" type="checkbox" /></td>
			*/ ?>
			<th><?php  /* <select id="ccm-core-commerce-product-list-multiple-operations" disabled>
				<option value="">**</option>
				<?php  if ($mode == 'choose_multiple') { ?>
					<option value="delete"><?php echo t('Choose')?></option>			
				<?php  } ?>
			</select>*/ ?>
			&nbsp;
			</th>
			<th width="200" class="<?php echo $productList->getSearchResultsClass('prName')?>"><a href="<?php echo $productList->getSortByURL('prName', 'asc', $bu, $soargs)?>"><?php echo t('Name')?></a></th>
			<th class="<?php echo $productList->getSearchResultsClass('prCurrentPrice')?>"><a href="<?php echo $productList->getSortByURL('prCurrentPrice', 'asc', $bu, $soargs)?>"><?php echo t('Price')?></a></th>
			<th class="<?php echo $productList->getSearchResultsClass('prDateAdded')?>"><a href="<?php echo $productList->getSortByURL('prDateAdded', 'asc', $bu, $soargs)?>"><?php echo t('Date Added')?></a></th>
			<th class="<?php echo $productList->getSearchResultsClass('prStatus')?>"><a href="<?php echo $productList->getSortByURL('prStatus', 'asc', $bu, $soargs)?>"><?php echo t('Status')?></a></th>
			<?php  if (is_array($_REQUEST['prsID'])) { ?>
				<th class="<?php echo $productList->getSearchResultsClass('prspDisplayOrder')?>"><a href="<?php echo $productList->getSortByURL('prspDisplayOrder', 'asc', $bu, $soargs)?>"><?php echo t('Set Order')?></a></th>
			<?php  } ?>
			<?php  
			$slist = CoreCommerceProductAttributeKey::getColumnHeaderList();
			foreach($slist as $ak) { ?>
				<th class="<?php echo $productList->getSearchResultsClass($ak)?>"><a href="<?php echo $productList->getSortByURL($ak, 'asc', $bu, $soargs)?>"><?php echo $ak->getAttributeKeyDisplayHandle()?></a></th>
			<?php  } ?>			
		</tr>
	<?php 
		$txt = Loader::helper('text');
		foreach($products as $pr) { 
			
			if (!isset($striped) || $striped == 'ccm-list-record-alt') {
				$striped = '';
			} else if ($striped == '') { 
				$striped = 'ccm-list-record-alt';
			}

			?>
		
			<tr class="ccm-list-record <?php echo $striped?>">
			<?php  /* <td class="ccm-core-commerce-product-list-cb" style="vertical-align: middle !important"><input type="checkbox" value="<?php echo $pr->getProductID()?>" product-name="<?php echo $pr->getProductName()?>" /></td> */ ?>
			<td><div class="ccm-core-commerce-search-thumbnail thumbnail-<?php echo $pr->getProductID() ?>"><?php echo $pr->outputThumbnail()?></div></td>
			<td><a href="#<?php // echo $action?>" class="productfloat" data-pid="<?php echo $pr->getProductID() ?>" data-title="<?php echo htmlentities($pr->getProductName(), ENT_QUOTES, APP_CHARSET) ?>"><?php echo $txt->highlightSearch($pr->getProductName(), $keywords)?></a></td>
			<td>
			<?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $pr, 'displayDiscount' => false)); ?>
			</td>
			<td><?php echo date(t("m/d/Y g:i A"), strtotime($pr->getProductDateAdded()))?></td>
			<td><?php echo ($pr->getProductStatus() == 1) ? t('Enabled') : t('Disabled')?></td>
			<?php  
			$slist = CoreCommerceProductAttributeKey::getColumnHeaderList();
			foreach($slist as $ak) { ?>
				<td><?php 
				$vo = $pr->getAttributeValueObject($ak);
				if (is_object($vo)) {
					print $vo->getValue('display');
				}
				?></td>
			<?php  } ?>		
			<?php  if (is_array($_REQUEST['prsID']) && isset($pr->prspDisplayOrder)) { ?>
			<td><?php echo $pr->prspDisplayOrder?></td>
			<?php  } ?>
			</tr>
			<?php 
		}

	?>
	
	</table>
	
	

	<?php  } else { ?>
		
		<div id="ccm-list-none"><?php echo t('No products found.')?></div>
		
	
	<?php  } ?>
</div>

<?php echo $productList->displaySummary();?>

	
<?php  if ($searchType == 'DASHBOARD' ) { ?>
</div>

<div class="ccm-pane-footer">
	<?php  	$productList->displayPagingV2($bu, false, $soargs); ?>
</div>

<?php  } else { ?>
	<div class="ccm-pane-dialog-pagination">
		<?php  	$productList->displayPagingV2($bu, false, $soargs); ?>
	</div>
<?php  } ?>

<script type="text/javascript">
$(function() { 
	//ccm_coreCommerceSetupSearch(); 
	$('.productfloat').bind('click',function(){
		ccm_chooseAsset({pID:$(this).data('pid'),
						title : $(this).data('title'),
						src : $('#thumbnail-' + $(this).data('pid')).attr('src')
		}); 
		$.fn.dialog.closeTop();
		return false;
	});
	// Quand on clique sur un lien de pagination, on charge le résultat dans #search-result
	$('.ccm-pane-dialog-pagination a').on('click',function(e){
		e.preventDefault();
		$('#search-results').load($(this).attr('href'));
	})

});
</script>
