<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$ih = Loader::helper('image');
$productsName = array();
foreach ($products as $product) :
	$productsName[] = 	'<a href="' . View::url(Page::getByID($product->getProductCollectionID())->getCollectionPath()) . '" class="related-product-link">' . 
						'<span class="hint--top" data-hint="' .  $product->getProductName() . '">' .
						'<img src="' . $ih->getThumbnail($product->getProductThumbnailImageObject(),50,50, true)->src . '" title="' .  $product->getProductName() . '"/>' .
						'</span>' .
						'</a>';
endforeach;
echo implode('&nbsp;&nbsp;', $productsName);
?>