<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$productsName = array();
foreach ($products as $product) 
	$productsName[] = $product->getProductName();
echo implode(', ', $productsName);