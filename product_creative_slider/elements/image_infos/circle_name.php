<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div class="pcs_circle circle_name" style="background-color:<?php echo $slide->ImageCaptionbg ?>; margin-top:<?php echo ($slide->imageHeight / 2 ) - 100 ?>px; <?php echo $slide->imageHeight < 200 ? "width:{$slide->imageHeight}px; height:{$slide->imageHeight}px" : '' ?>">
	<div class="pcs_padding">
		<div class="pcs_center">
			<h3 class="pcs_name"><?php echo $product->getProductName() ?></h3>
		</div>		
	</div>	
</div>
