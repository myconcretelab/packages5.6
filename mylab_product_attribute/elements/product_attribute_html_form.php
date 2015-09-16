<? defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div id="<?php echo $inputName ?>_productAttachmentRow<?php echo $product->getProductID()?>" class="ccm-file-selected-wrapper product-selected-wrapper" style="display: block; margin-top:5px">	
	<input name="<?php echo $inputName ?>[]" type="hidden" value="<?php echo $product->getProductID() ?>" style="float:right" />
	<a href="javascript:void(0)" style="float: right; margin-top: -8px;" onclick="removeProduct('#<?php echo $inputName ?>_productAttachmentRow<?php echo $product->getProductID()?>')">
		<img src="<?php echo ASSETS_URL_IMAGES ?>/icons/remove.png" style="margin:12px 0 0 3px">
	</a>
	<div class="ccm-file-selected-thumbnail">
		<?php $product->outputThumbnail(40,40) ?>
	</div>
	<div class="ccm-file-selected-data">
		<div><?php echo $product->getProductName() ?></div>
	</div>
	<div class="additional-data" style="float:left">
		<?php echo $additionalData ?>
	</div>	
	<div class="ccm-spacer">&nbsp;</div>
</div>