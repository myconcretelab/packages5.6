<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

Loader::model('product/model', 'core_commerce');
Loader::model('order/product', 'core_commerce');
Loader::model('cart', 'core_commerce');
$jh = Loader::helper('json');

$cart = CoreCommerceCart::get();
$quantity = $cart->getTotalProducts();

echo $jh->encode($quantity);
?>
