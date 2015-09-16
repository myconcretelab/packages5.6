<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 
<?php  if (($product->getProductPrice() != $product->getProductSpecialPrice()) && $product->getProductSpecialPrice(false) > 0) { ?>
	<?php  if ($displayDiscount) { ?>
		<strike><?php echo $product->getProductDisplayPrice()?></strike> <strong><?php echo t("Now %s", $product->getProductSpecialDisplayPrice())?></strong>
	<?php  } else { ?>
		<?php echo $product->getProductSpecialDisplayPrice()?>
	<?php  } ?>
<?php  } else if ($product->productUsesTieredPricing()) { 
	$tiers = $product->getProductPricingTiers();
	?>
	<ul>
	<?php 
	foreach($tiers as $tier) { 
	?>
		<li><?php echo $tier->getTierStart()?><?php 
			if ($tier->getTierEnd() == null) { 
				print t('+');
			} else {
				print '-';
				print $tier->getTierEnd();
			}
		?>:
		<?php echo $tier->getTierDisplayPrice()?></li>
	<?php  } ?>
	</ul>

<?php  } else if ($product->getProductPrice() > 0) { ?>
	<?php echo $product->getProductDisplayPrice()?>
<?php  } ?>