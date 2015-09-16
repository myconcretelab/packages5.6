<?php    defined('C5_EXECUTE') or die(_("Access Denied."));

$uh = Loader::helper('urls', 'core_commerce');
$ih = Loader::helper('image');

$c = Page::getCurrentPage();

$link_before = '';
$link_after = '';

if (is_object($product)) {
$id = $product->getProductID();
if ($product->getProductCollectionID()>0 && $displayLinkToFullPage && $c->getCollectionID() != $product->getProductCollectionID()) {
	$linksTo = Page::getByID($product->getProductCollectionID());
	if ($linksTo->cID>0) {
		$link_before = '<a href="'.$this->url($linksTo->getCollectionPath()).'" class="ccm-productListImage">';
		$link_after = '</a>';
	}
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
		$thumb = $ih->getThumbnail($pi, $imageMaxWidth, $imageMaxHeight);
		$img = '<img src="' . $thumb->src . '" width="' . $thumb->width . '" height="' . $thumb->height . '" data-large="' .  $ih->getThumbnail($pi,900,900)->src . '"';
		$classes[] = 'ImageZoom';
		$himg = '';
		if (is_object($primaryHoverImage)) {
			$hthumb = $ih->getThumbnail($primaryHoverImage, $imageMaxWidth, $imageMaxHeight);
			if (is_object($hthumb)) {
				$classes[] = 'ccm-productListDefaultImage';
				$himg = "<img src='{$hthumb->src}' class='ccm-productListHoverImage' />";
			} 

		}
		$img .= 'class="' . implode(' ', $classes) . '" />';
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
			$resized = $ih->getThumbnail($fi, $overlayLightboxImageMaxWidth, $overlayLightboxImageMaxHeight);
			$img = '<a href="' . $resized->src .'" class="ccm-core-commerce-add-to-cart-lightbox-image" title="' . $fi->getTitle() . '">' . $img . '</a>';
		}
	}
}

/*  ---- Myconcretelab vars ---- */
$categories_list = CoreCommerceProductAttributeKey::getList();

/*  ---- Core version vars ---- */
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

?>
<form method="post" id="ccm-core-commerce-add-to-cart-form-<?php   echo $id?>" action="<?php   echo $this->url('/cart', 'update')?>">
<input type="hidden" name="rcID" value="<?php   echo $c->getCollectionID()?>" />
<div class="row-fluid product-details">
	<!-- <div class="span2"> -->
		<?php 
		/*
		$ak = CoreCommerceProductAttributeKey::getByHandle('related_products');
		$related = $product->getAttributeValueObject($ak);
		if (is_object($related)): ?>
			<h3>Tissus assortis</h3>
			<p style="line-height:9px;"><small>Ces tissus sont de même collection,<br> ils s'harmonisent donc parfaitement</small></p>
			<?php
			echo $related->getValue('imageLinks');
			?>
			
		<?php endif ?>
		<?php 
		$add = $product->getAdditionalProductImages();
		if(count($add)) :
			$columns_number = 2;
		 ?>
		<h3>Autres vues</h3>
		<?php foreach ($add as $key => $image) : 
				$desc = $image->getDescription();
		?>
			<?php if ($key%$columns_number == 0) : ?><div class="row-fluid"><?php endif ?>
				<div class="span<?php echo 12 / $columns_number?>">
					<?php if ($desc) : ?><span class="hint--bottom hint--alternate" data-hint="<?php echo $desc ?>"><?php endif ?>
						<img src="<?php echo $ih->getThumbnail($image,250,250, true)->src ?>" alt="">
					<?php if ($desc) : ?></span><?php endif ?>
				</div>
			<?php if ( $key%$columns_number == ($columns_number) - 1 || ($key == count($add)-1) ) : ?></div><?php endif ?>
		<?php endforeach ?>	
		<?php endif ; */?>			
	<!-- </div> -->
	<div class="span6 product_image">
		<div style="position:relative"><?php   echo $img ?></div>
	</div><!-- .product_image -->
	<div class="span6 product_details">
		<h1><?php echo $link_before.$product->getProductName().$link_after?></h1>
		<p><?php echo $product->getProductDescription()?></p>
		<div class="row-fluid">
			<div class="span8">
				
				<?php Loader::packageElement('product/display/attributes_slim', 'theme_super_mint', array('properties' => $properties, 'product' => $product)); ?>		
				<!-- The informations attributes -->
				<!-- <table class="slim_table"> -->
				<?php /* foreach ($properties as $att) :
					$attValue = $product->getAttribute($att->akHandle);
					if(is_object($attValue) && is_object($attValue->current()) ) : ?>
					<tr>
						<td class="title"><?php echo  $att->akName?></td>
						<td>
							<!-- <span class="hint--top hint--alternate" data-hint="Voir tous <?php echo $attValue->current()->getSelectAttributeOptionValue();  ?>"> -->
							<strong><?php echo $attValue->current()->getSelectAttributeOptionValue();  ?></strong>
							<!-- </span> -->
						</td>
					</tr>
				<?php endif; endforeach; */?>
				<!-- </table> -->
			</div>
			<div class="span4">
				<a class="price_circle altbg"><?php echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => $displayDiscountP)); ?></a>
			</div>
		</div>
		
		<hr class="dashed">
		
		<?php    
		if ($displayAddToCart) :
			$attribs = $product->getProductConfigurableAttributes();
			if (count($attribs)) :
		?>
			<table class="slim_table">
			<?php foreach($attribs as $at) : ?>
				<tr>
					<td>
						<?php   echo $at->render("label")?><?php if ($at->isProductOptionAttributeKeyRequired()) { ?> <span class="ccm-required">*</span><?php    } ?>
					</td>
					<td>
						<?php   echo $at->render('form');?>
					</td>
				</tr>
						
			<?php endforeach;
			endif; ?>
			</table>
		<?php endif ?>
		<?php if ($displayQuantity) : ?>
			<div class="row-fluid" style="background-color:#f9f9f9">		
				<div class="span6">
					<div class="padding">
					<?php if ($product->getProductQuantity() != 999999999) : ?><small><?php   echo t('# In Stock: ')?><?php   echo $product->getProductQuantity()?></small><br><?php endif ?>
					<?php   echo $form->label('quantity', t('Quantity'))?> <span class="ccm-required">*</span>
					<?php    if ($product->productIsPhysicalGood()) { ?>
						<?php   echo $form->text("quantity", 1, array("style" => "width: 20px"));?>
					<?php    } else { ?>
						<?php   echo $form->hidden("quantity", 1);?>
						1
					<?php    } ?>
					</div><!-- .padding -->
				</div>
				<div class="span6">
					<div class="padding">
					<!-- add to cart button -->
					<?php if ($product->isProductEnabled()) { ?>
						<button type="submit" value="submit" class="button button-flat-primary  button-large"><?php echo $addToCartText ?><img src="<?php   echo ASSETS_URL_IMAGES?>/throbber_white_16.gif" width="16" height="16" class="ccm-core-commerce-add-to-cart-loader" /></button>
					<?php } else { ?>
						<strong><?php   echo t('This product is unavailable.')?></strong>
					<?php } ?>
					</div><!-- .padding -->	
				</div><!-- .span6 -->				
			</div><!-- row-fluid -->
			<?php endif // $displayQuantity?>
			<?php   echo $form->hidden('productID', $product->getProductID()); ?>
		<?php // endif ?>
	</div><!-- .product_details -->
</div><!-- main .row-fluid -->
</form>


<?php    if (!$c->isEditMode()) { ?>
<script type="text/javascript">
	$(function() {
		ccm_coreCommerceRegisterAddToCart('ccm-core-commerce-add-to-cart-form-<?php   echo $id?>', '<?php   echo $uh->getToolsURL('cart_dialog')?>');
		<?php    if ($useOverlaysC) { ?>
			ccm_coreCommerceRegisterCallout('ccm-core-commerce-add-to-cart-form-<?php   echo $id?>');
		<?php    } ?>
		<?php    if ($useOverlaysL) { ?>
			$('#ccm-core-commerce-add-to-cart-form-<?php   echo $id?> .ccm-core-commerce-add-to-cart-lightbox-image').lightBox({
				imageLoading: '<?php    echo ASSETS_URL_IMAGES?>/throbber_white_32.gif',
				imageBtnPrev: '<?php    echo $lightboxURL?>/images/lightbox-btn-prev.gif',	
				imageBtnNext: '<?php    echo $lightboxURL?>/images/lightbox-btn-next.gif',			
				imageBtnClose: '<?php    echo $lightboxURL?>/images/lightbox-btn-close.gif',	
				imageBlank:	'<?php    echo $lightboxURL?>/images/lightbox-blank.gif',   
				imageCaptionAdditional: '#ccm-core-commerce-add-to-cart-form-<?php   echo $id?> .ccm-core-commerce-add-to-cart-lightbox-caption'
			});
		<?php    } ?>
		
	});
</script>
<?php    } ?>
<?php    } ?>
