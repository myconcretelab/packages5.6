<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$ih = Loader::helper('image');
$productsName = array();
foreach ($products as $product) 
	$productsName[] = 	'<a href="' . View::url(Page::getByID($product->getProductCollectionID())->getCollectionPath()) . '" class="related-product-link">' . 
						'<img src="' . $ih->getThumbnail($product->getProductThumbnailImageObject(),50,50)->src . '" title="' .  $product->getProductName() . '"/>' .
						'&nbsp;<small>' .  $product->getProductName() . '</small>' .
						'</a>';
echo implode('&nbsp;&nbsp;', $productsName);