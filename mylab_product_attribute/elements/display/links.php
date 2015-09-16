<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$productsName = array();
foreach ($products as $product) 
	$productsName[] = '<a href="' . View::url(Page::getByID($product->getProductCollectionID())->getCollectionPath()) . '" class="related-product-link">' . $product->getProductName() . '</a>';
echo implode(', ', $productsName);