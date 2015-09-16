<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 
<?php 
$searchFields = array(
	'' => '** ' . t('Fields'),
	'price' => t('Price'),
   'by_quantity' => t('Quantity'),
	'date_added' => t('Created Between'),
   'enabled' => t('Product Status'),
   'sale_items' => t('Sale Items')
);
if(Loader::helper('multilingual', 'core_commerce')->isEnabled()) {
	$searchFields['language'] = t('Language');
}


$uh = Loader::helper('urls', 'core_commerce');
Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
$searchFieldAttributes = CoreCommerceProductAttributeKey::getSearchableList();
foreach($searchFieldAttributes as $ak) {
	$searchFields[$ak->getAttributeKeyID()] = $ak->getAttributeKeyDisplayHandle();
}

$form = Loader::helper('form'); ?>
	
	<div id="ccm-core-commerce-product-search-field-base-elements" style="display: none">

		<span class="ccm-search-option ccm-search-option-type-date_time"  search-field="date_added">
		<?php echo $form->text('date_from', array('style' => 'width: 86px'))?>
		<?php echo t('to')?>
		<?php echo $form->text('date_to', array('style' => 'width: 86px'))?>
		</span>

		<span class="ccm-search-option"  search-field="by_quantity">
         <span style="float:left">
         <?php echo $form->text('quantity_from', array('style' => 'width: 86px'))?>
         <?php echo t('to')?>
         <?php echo $form->text('quantity_to', array('style' => 'width: 86px'))?>
         </span>
         <span style="float:left">
         <label for="include_unlimited"><?php echo $form->checkbox('include_unlimited',1,false); ?><span style="margin-left:4px"><?php echo t('Include Unlimited')?></span></label>
         </span>
      </span>

		<span class="ccm-search-option"  search-field="enabled">
      <label><?php echo  $form->radio('product_enabled',1,1);?><span style="margin-left:4px"><?php echo t('Enabled');?></span></label>
      <label><?php echo  $form->radio('product_enabled',0,1);?><span style="margin-left:4px"><?php echo t('Not enabled');?></span></label>
		</span>

		<span class="ccm-search-option"  search-field="sale_items">
      <label><?php echo  $form->radio('on_sale',1,1);?><span style="margin-left:4px"><?php echo t('Sale Price');?></span></label>
      <label><?php echo  $form->radio('on_sale',0,1);?><span style="margin-left:4px"><?php echo t('Normal Price');?></span></label>
		</span>

		<span class="ccm-search-option"  search-field="price">
		<?php echo $form->text('price_from', array('style' => 'width: 86px'))?>
		<?php echo t('to')?>
		<?php echo $form->text('price_to', array('style' => 'width: 86px'))?>
		</span>

		<?php  if(Loader::helper('multilingual', 'core_commerce')->isEnabled()) { ?>
		<span class="ccm-search-option"  search-field="language">
			<?php 
			$languages = Loader::helper('multilingual','core_commerce')->getSectionSelectArray();
			echo $form->select('language', $languages);
			?>
		</span>
		<?php  } ?>
		<?php  foreach($searchFieldAttributes as $sfa) { 
			$sfa->render('search'); ?>
		<?php  } ?>
		
	</div>
	
	<form method="get" id="ccm-core-commerce-product-advanced-search" action="<?php echo $uh->getToolsURL('product/search_results')?>">
	<?php echo $form->hidden('mode', $mode); ?>
	<?php  print $form->hidden('searchType', $searchType); ?>
	<div class="ccm-pane-options-permanent-search">
	
		<input type="hidden" name="search" value="1" />

		<div class="span4">
		<?php echo $form->label('keywords', t('Keywords'))?>
		<div class="input">
			<?php echo $form->text('keywords', array('style'=> 'width: 130px')); ?>
		</div>
		</div>
		
		<div id="ccm-core-commerce-product-sets-search-wrapper">
		<?php 
		Loader::model('product/set', 'core_commerce');
		$s1 = CoreCommerceProductSet::getList();
		if (count($s1) > 0) { ?>
		<div class="span5" >
			<?php echo $form->label('prsID', t('In Set(s)'))?>
			<div class="input">
				<select multiple name="prsID[]" class="chosen-select">
					<optgroup label="<?php echo t('Sets')?>">
					<?php  foreach($s1 as $s) { ?>
						<option value="<?php echo $s->getProductSetID()?>"  <?php  if (is_array($_REQUEST['prsID']) && in_array($s->getProductSetID(), $_REQUEST['prsID'])) { ?> selected="selected" <?php  } ?>><?php echo $s->getProductSetName()?></option>
					<?php  } ?>
					<optgroup label="<?php echo t('Other')?>">
						<option value="-1" <?php  if (is_array($_REQUEST['prsID']) && in_array(-1, $_REQUEST['prsID'])) { ?> selected="selected" <?php  } ?>><?php echo t('Products in no sets.')?></option>
					</optgroup>
				</select>
			</div>
		</div>
		<?php  } ?>
		</div>
		
		<div class="span5">
		<?php echo $form->label('numResults', t('# Per Page'))?>
		<div class="input">
			<?php echo $form->select('numResults', array(
				'10' => '10',
				'25' => '25',
				'50' => '50',
				'100' => '100',
				'500' => '500'
			), $searchRequest['numResults'], array('style' => 'width:65px'))?>

		</div>
		<?php echo $form->submit('ccm-search-files', t('Search'), array('style' => 'margin-left: 10px'))?>
			<img src="<?php echo ASSETS_URL_IMAGES?>/loader_intelligent_search.gif" width="43" height="11" class="ccm-search-loading" id="ccm-core-commerce-product-search-loading" />

		</div>

	</div>
	<a href="javascript:void(0)" onclick="ccm_paneToggleOptions(this)" class="ccm-icon-option-<?php  if (is_array($searchRequest['selectedSearchField']) && count($searchRequest['selectedSearchField']) > 1) { ?>open<?php  } else { ?>closed<?php  } ?>"><?php echo t('Advanced Search')?></a>
	<div class="clearfix ccm-pane-options-content" <?php  if (is_array($searchRequest['selectedSearchField']) && count($searchRequest['selectedSearchField']) > 1) { ?>style="display: block" <?php  } ?>>

		<br/>
		<table class="table zebra-striped ccm-search-advanced-fields" id="ccm-core-commerce-product-search-advanced-fields">
		<tr>
			<th colspan="2" width="100%"><?php echo t('Additional Filters')?></th>
			<th style="text-align: right; white-space: nowrap"><a href="javascript:void(0)" id="ccm-core-commerce-product-search-add-option" class="ccm-advanced-search-add-field"><span class="ccm-menu-icon ccm-icon-view"></span><?php echo t('Add')?></a></th>
		</tr>
		<tr id="ccm-search-field-base">
			<td><?php echo $form->select('searchField', $searchFields);?></td>
			<td width="100%">
			<input type="hidden" value="" class="ccm-core-commerce-product-selected-field" name="selectedSearchField[]" />
			<div class="ccm-selected-field-content">
				<?php echo t('Select Search Field.')?>				
			</div></td>
			<td><a href="javascript:void(0)" class="ccm-search-remove-option"><img src="<?php echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" width="16" height="16" /></a></td>
		</tr>
		</table>

		<div id="ccm-search-fields-submit">
			<a href="<?php echo $uh->getToolsURL('customize_product_search_columns')?>" id="ccm-list-view-customize"><span class="ccm-menu-icon ccm-icon-properties"></span><?php echo t('Customize Results')?></a>
		</div>

	</div>
</form>
