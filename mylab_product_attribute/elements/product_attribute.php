<? defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div id="ak<?php echo $akID ?>_productAttachmentRow<?php echo $product->getProductID()?>" class="ccm-file-selected-wrapper product-selected-wrapper" style="display: block; margin-top:5px">	
	<input name="akID[<?php echo $akID ?>][pID][]" type="hidden" value="<?php echo $product->getProductID() ?>" style="float:right" />
	<a href="javascript:void(0)" style="float: right; margin-top: -8px;" onclick="removeProduct('#ak<?php echo $akID ?>_productAttachmentRow<?php echo $product->getProductID()?>')">
		<img src="<?php echo ASSETS_URL_IMAGES ?>/icons/remove.png" style="margin:12px 0 0 3px">
	</a>
	<div class="ccm-file-selected-thumbnail">
		<?php $product->outputThumbnail(40,40) ?>
	</div>
	<div class="ccm-file-selected-data">
		<div><?php echo $product->getProductName() ?></div>
	</div>		
	<div class="ccm-spacer">&nbsp;</div>
</div>