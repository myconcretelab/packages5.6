<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div class="pcs_block pcs_block_right pcs_img_caption" style="background-color:<?php echo $slide->ImageCaptionbg ?>; margin-top:<?php echo ($slide->imageHeight / 2 ) - 100 ?>px;">
	<div class="pcs_padding">
		<div class="pcs_center">
			<h3><?php echo $product->getProductName() ?></h3>
			<p class="pcs_price"><?php   echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => true)); ?></p>
		</div>		
	</div>
</div>
