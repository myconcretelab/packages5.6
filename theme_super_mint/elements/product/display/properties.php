<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="prop-list">

<?php  
$tmp = array();
foreach($properties as $property) {
	$tmp[] = $property->handle;	
}
$hasBothPrices = false;
if (in_array('displayDiscount', $tmp) && in_array('displayPrice', $tmp)) {
	$hasBothPrices = true;
}

foreach($properties as $property) { 

	?>
	
	<?php  if ($property->handle == 'displayName') {
		if ($linkToProductPage) {
			$linksTo = Page::getByID($product->getProductCollectionID());
			$link_before = '<a href="' . Loader::helper('navigation')->getLinkToCollection($linksTo) . '">';
			$link_after = '</a>';
		}		
	?>		
	
		<h4><?php echo $link_before.$product->getProductName().$link_after?></h4>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayPrice' && (!$hasBothPrices)) { ?>		
		<div class="price"><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => false)); ?></div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayDiscount') { ?>		

		<div class="price"><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => true)); ?></div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayDescription') { ?>		
	
		<div class="desc">
		<?php echo $product->getProductDescription()?>
		</div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayDimensions') { ?>		
	
		<div>
		<strong><?php echo t('Dimensions')?></strong><br/>
		<div class="dimensions">
			<?php echo $product->getProductDimensionLength()?>x<?php echo $product->getProductDimensionWidth()?>x<?php echo $product->getProductDimensionHeight()?> <?php echo $product->getProductDimensionUnits()?>
		</div>
		</div>
	
	<?php  } ?>
	
	<?php  if ($property->handle == 'displayQuantityInStock') { ?>		
		<div class="stock">			
		<?php echo t('# In Stock : ')?>
		<strong>
		<?php echo $product->getProductQuantity()?>
		</strong>
		</div>
	
	<?php  } ?>
	
	<?php  if ($property->type == 'attribute') { 
		$dak = CoreCommerceProductAttributeKey::getByID($property->akID);
		$av = $product->getAttributeValueObject($dak);
		if (is_object($av))  : ob_start(); echo $av->getValue('display'); $v = trim(ob_get_clean()); else: $v = false; endif;
		if ($v) { ?>
		<strong><?php echo $dak->getAttributeKeyName()?> : </strong>
		<?php echo $v?>
			
	
		<?php  }
		
	} ?>
	
	<div class="ccm-spacer">&nbsp;</div>

<?php  } ?>
</div>