<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div class="pcs_circle price_name" style="background-color:<?php echo $slide->ImageCaptionbg ?>; margin-top:<?php $m = ($slide->imageHeight / 2 ) - 100 ; echo $m > 0 ? $m : 2 ?>px; <?php $s = $slide->imageHeight - 4; echo $slide->imageHeight < 200 ? "width:{$s}px; height:{$s}px" : '' ?>">
	<div class="pcs_padding">
		<div class="pcs_center">
			<h3 class="pcs_name"><?php echo $product->getProductName() ?></h3>
			<p class="pcs_price"><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => true)); ?></p>
		</div>		
	</div>
</div>
