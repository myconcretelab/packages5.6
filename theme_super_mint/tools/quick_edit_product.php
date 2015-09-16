<?php  
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('product/model', 'core_commerce');
$db = Loader::db();

$pID = $_GET['pID'];
if (!$pID) die;


$db->Execute('update CoreCommerceProducts set prStatus = ?  where productID = ?', array(0,$pID ));

$product = CoreCommerceProduct::getByID($pID);

echo 'Satut actuel du produit : ' . var_export( $product->getProductStatus());