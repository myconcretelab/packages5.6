<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$uh = Loader::helper('urls', 'core_commerce');
$ih = Loader::helper('image');
if(!isset($pkg)) {
	$pkg = Package::getByHandle('core_commerce');
}
$c = Page::getCurrentPage();

$link_before = '';
$link_after = '';

if ($product->getProductCollectionID()>0 && $displayLinkToFullPage && $GLOBALS['c']->getCollectionID() != $product->getProductCollectionID()) {
	$linksTo = Page::getByID($product->getProductCollectionID());
	if ($linksTo->cID>0) {
		$linkToProductPage = true;
		$link_before = '<a href="'.$this->url($linksTo->getCollectionPath()).'" class="ccm-productListImage">';
		$link_after = '</a>';
   } 
}
if(!strlen($link_before)){
   $link_before = '<span class="ccm-productListImage">';
   $link_after = '</span>';
}


// setup the image objects
if (!is_object($primaryImage)) {
	if($primaryImage != '') {
		$primaryImage = $product->getFileObjectFromImageOption($primaryImage);
	} else {
		$primaryImage = $product->getProductThumbnailImageObject();
	}
}

if(is_string($primaryHoverImage)) {
	$primaryHoverImage = $product->getFileObjectFromImageOption($primaryHoverImage);
}
if(is_string($overlayCalloutImage)) {
	$overlayCalloutImage = $product->getFileObjectFromImageOption($overlayCalloutImage);
} else {
	// legacy support
	$overlayCalloutImage = $product->getProductFullImageObject();
}


if ($displayImage) { 
	$pi = $primaryImage;
	if (is_object($pi)) {
		if($imageMaxWidth<=0) {$imageMaxWidth = 200;} 
		if($imageMaxHeight<=0) {$imageMaxHeight = 200;} 
		$thumb = $ih->getThumbnail($pi, $imageMaxWidth, $imageMaxHeight, true);
		$img = '<img src="' . $thumb->src . '" ';
		$himg = '';
		if (is_object($primaryHoverImage)) {
			$hthumb = $ih->getThumbnail($primaryHoverImage, $imageMaxWidth, $imageMaxHeight, true);
			if (is_object($hthumb)) {
				$img .= 'class="ccm-productListDefaultImage"';
				$himg = "<img src='{$hthumb->src}' width='{$thumb->width}' height='{$thumb->height}' class='ccm-productListHoverImage' />";
			}
		}
		$img .= ' />';
		if (!$useOverlaysL) {
			$img = $link_before.$img.$himg.$link_after;
		}
	}
	
	if ($useOverlaysL) {
		$images = $product->getAdditionalProductImages();
		if (is_object($images[0])) { // load up first image for the lightbox
			$fi = $images[0];
			if($overlayLightboxImageMaxWidth<=0) {$overlayLightboxImageMaxWidth = 600; }
			if($overlayLightboxImageMaxHeight<=0) {$overlayLightboxImageMaxHeight = 600; }
			$resized = $ih->getThumbnail($fi, $overlayLightboxImageMaxWidth, $overlayLightboxImageMaxHeight, true);
			$img = '<a href="' . $resized->src .'" class="ccm-core-commerce-add-to-cart-lightbox-image" title="' . $fi->getTitle() . '">' . $img . '</a>';
		}
	}
}

$form = Loader::helper('form');
if (!$valign) {
	$valign = 'top';
}
if (!$halign) {
	$halign = 'left';
}
?>

<style>
.ccm-productListImage > img.ccm-productListDefaultImage, .ccm-productListImage:hover > img.ccm-productListHoverImage {
	display:block;
}
.ccm-productListImage > img.ccm-productListHoverImage, .ccm-productListImage:hover > img.ccm-productListDefaultImage {
	display:none;
}
</style>
<div class="ccm-core-commerce-add-to-cart">
<form method="post" id="ccm-core-commerce-add-to-cart-form-<?php echo $id?>" action="<?php echo $this->url('/cart', 'update')?>">
<input type="hidden" name="rcID" value="<?php echo $c->getCollectionID()?>" />

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<?php  if ($displayImage && $imagePosition == 'T') { ?>
<tr>
	<td valign="<?php echo $valign?>" align="<?php echo $halign?>" class="ccm-core-commerce-add-to-cart-thumbnail-top">
		<div class="ccm-core-commerce-add-to-cart-image"><?php echo $img?></div>
	</td>
</tr>
<?php  } ?>
<tr>
	<?php  if ($displayImage && $imagePosition == 'L') { ?>
	<td valign="<?php echo $valign?>" align="<?php echo $halign?>" class="ccm-core-commerce-add-to-cart-thumbnail-left">
		<div class="ccm-core-commerce-add-to-cart-image"><?php echo $img?></div>
	</td>
	<?php  } ?>
	<td valign="top" class="ccm-core-commerce-add-to-cart-prop" align="<?php echo $halign?>" >
<?php 
		Loader::model('product/display_property', 'core_commerce'); 
		$list = new CoreCommerceProductDisplayPropertyList();
		$list->setPropertyOrder($propertyOrder);
		$displayProperties = $list->get();
		$attributesP = $controller->getAttributes('P', false);
		$properties = array();
		foreach($displayProperties as $property) { ?>
			<?php 
			$show = false;
			
			if ($property->type == 'fixed') {
				$show = ${$property->handle . 'P'} || ${'display' . $property->plHandle . 'P'};
			} else {
				$show = in_array($property->akID, $attributesP);
			}
			if ($show) { 
				$properties[] = $property;
			}

		}
		
		Loader::element('product/display/properties', array('linkToProductPage' => $linkToProductPage, 'properties' => $properties, 'product' => $product), 'theme_super_mint');

		if ($displayAddToCart) { ?>
			<table cellspacing="0" cellpadding="0" border="0">
			<?php 
			$attribs = $product->getProductConfigurableAttributes();			
			foreach($attribs as $at) { ?>
			<tr>
				<td valign="top" style="padding-right: 10px"><?php echo $at->render("label")?><?php  if ($at->isProductOptionAttributeKeyRequired()) { ?> <span class="ccm-required">*</span><?php  } ?></td>
				<td valign="top"><?php echo $at->render('form');?></td>
			</tr>
			
			<?php  } 
			
			if ($displayQuantity) { ?>
			<tr>
				<td valign="top" style="padding-right: 10px"><?php echo $form->label('quantity', t('Quantity'))?> <span class="ccm-required">*</span></td>
				<td valign="top">
				<?php  if ($product->productIsPhysicalGood()) { ?>
					<?php echo $form->text("quantity", 1, array("style" => "width: 20px"));?>
				<?php  } else { ?>
					<?php echo $form->hidden("quantity", 1);?>
					1
				<?php  } ?>
				</td>
			</tr>
			<?php  } ?>
			</table>
			<div class="add-to-btn">
				<?php  if ($product->isProductEnabled()) { ?>
					<?php echo $form->submit('submit', $addToCartText, array('class'=>'button button-flat')); ?>
					<img src="<?php echo ASSETS_URL_IMAGES?>/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" />

				<?php  } else { ?>
					<strong><?php echo t('This product is unavailable.')?></strong>
				<?php  } ?>
			</div>
			<?php  
			if($pkg->config('WISHLISTS_ENABLED')) {?>
				<div class="add-to-btn">
					<?php  echo $form->button('submit-wishlist',t("Add To Wishlist"), array('class'=>'ccm-core-commerce-add-to-wishlist-button button button-flat-primary'));?>
				</div>
			<?php  }
			if($pkg->config('GIFT_REGISTRIES_ENABLED')) {?>
				<div class="add-to-btn">
					<?php  echo $form->button('submit-registry',t("Add To Gift Registry"), array('class'=>'ccm-core-commerce-add-to-registry-button button button-flat-primary'));?>
				</div>
			<?php  } ?>
				<?php echo $form->hidden('productID', $product->getProductID()); ?>
		<?php  } ?>
		
	</td>
	<?php  if ($displayImage && $imagePosition == 'R') { ?>
	<td valign="<?php echo $valign?>" class="ccm-core-commerce-add-to-cart-thumbnail-right">
		<div class="ccm-core-commerce-add-to-cart-image"><?php echo $img?></div>
	</td>
	<?php  } ?>
</tr>
<?php  if ($displayImage && $imagePosition == 'B') { ?>
<tr>
	<td valign="<?php echo $valign?>" class="ccm-core-commerce-add-to-cart-thumbnail-bottom">
		<div class="ccm-core-commerce-add-to-cart-image"><?php echo $img?></div>
	</td>
</tr>
<?php  } ?>
</table>
<?php  if ($useOverlaysC) { ?>
	<div class="ccm-core-commerce-add-to-cart-callout">
		<div class="ccm-core-commerce-add-to-cart-callout-inner">
		<div class="ccm-core-commerce-add-to-cart-callout-image">
			<?php 
			if(is_object($overlayCalloutImage)) {
				$im = Loader::helper('image');
				if($overlayCalloutImageMaxWidth<=0) {
					$overlayCalloutImageMaxWidth = 300;
				}
				if($overlayCalloutImageMaxHeight<=0) {
					$overlayCalloutImageMaxHeight = 300;
				}
				$im->outputThumbnail($overlayCalloutImage, $overlayCalloutImageMaxWidth, $overlayCalloutImageMaxHeight);
			}
			
			?>
			</div>
			<?php 
		
			$attributesC = $controller->getAttributes('C', false);
			$properties = array();
			foreach($displayProperties as $property) { ?>
				<?php 
				$show = false;
				
				if ($property->type == 'fixed') {
				$show = ${$property->handle . 'C'} || ${'display' . $property->plHandle . 'C'};
				} else {
					$show = in_array($property->akID, $attributesC);
				}
				if ($show) { 
					$properties[] = $property;
				}	
			}
			
			Loader::element('product/display/properties', array('linkToProductPage' => $linkToProductPage, 'properties' => $properties, 'product' => $product), 'theme_super_mint');
	
			?>	
		</div>
	</div>
<?php  }

if ($useOverlaysL) {
	for ($i = 1; $i < count($images); $i++ ) {
		$f = $images[$i];
		$resized = $ih->getThumbnail($f, $overlayLightboxImageMaxWidth, $overlayLightboxImageMaxHeight);
		?>
		<a style="display: none" href="<?php echo $resized->src?>" title="<?php echo $f->getTitle()?>" class="ccm-core-commerce-add-to-cart-lightbox-image">&nbsp;</a>
	<?php  } ?>	
	<div class="ccm-core-commerce-add-to-cart-lightbox-caption">
		<?php 
			$attributesL = $controller->getAttributes('L', false);
			$properties = array();
			foreach($displayProperties as $property) { ?>
				<?php 
				$show = false;
				
				if ($property->type == 'fixed') {
				$show = ${$property->handle . 'L'} || ${'display' . $property->plHandle . 'L'};
				} else {
					$show = in_array($property->akID, $attributesL);
				}
				if ($show) { 
					$properties[] = $property;
				}	
			}
			
			Loader::element('product/display/properties', array('linkToProductPage' => $linkToProductPage, 'properties' => $properties, 'product' => $product), 'theme_super_mint');
		?>		
	</div>
	<?php 
}

?>
</form>
</div>

<?php  if (!$c->isEditMode()) { ?>
<script type="text/javascript">
	$(function() {
		ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php echo $id?>', '<?php echo $uh->getToolsURL('cart_dialog')?>');
		<?php  if($pkg->config('WISHLISTS_ENABLED')) { ?>
			ccm_coreCommerceRegisterAddToWishList('ccm-core-commerce-add-to-cart-form-<?php echo $id?>', '<?php echo $uh->getToolsURL('wishlist/add_to_wishlist')?>?rcID=<?php  echo Page::getCurrentPage()->getCollectionID()?>');
			ccm_coreCommerceRegisterAddToRegistry('ccm-core-commerce-add-to-cart-form-<?php echo $id?>', '<?php echo $uh->getToolsURL('wishlist/add_to_registry')?>?rcID=<?php  echo Page::getCurrentPage()->getCollectionID()?>');
		<?php  } ?>
		<?php  if ($useOverlaysC) { ?>
			ccm_coreCommerceRegisterCallout('ccm-core-commerce-add-to-cart-form-<?php echo $id?>');
		<?php  } ?>
		<?php  if ($useOverlaysL) { ?>
			$('#ccm-core-commerce-add-to-cart-form-<?php echo $id?> .ccm-core-commerce-add-to-cart-lightbox-image').lightBox({
				imageLoading: '<?php  echo ASSETS_URL_IMAGES?>/throbber_white_32.gif',
				imageBtnPrev: '<?php  echo $lightboxURL?>/images/lightbox-btn-prev.gif',	
				imageBtnNext: '<?php  echo $lightboxURL?>/images/lightbox-btn-next.gif',			
				imageBtnClose: '<?php  echo $lightboxURL?>/images/lightbox-btn-close.gif',	
				imageBlank:	'<?php  echo $lightboxURL?>/images/lightbox-blank.gif',   
				imageCaptionAdditional: '#ccm-core-commerce-add-to-cart-form-<?php echo $id?> .ccm-core-commerce-add-to-cart-lightbox-caption'
			});
		<?php  } ?>
		
	});
</script>
<?php  } ?>
