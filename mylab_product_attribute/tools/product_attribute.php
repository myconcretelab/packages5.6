<?php  defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('product/model', 'core_commerce');

if (!$_REQUEST['pID']) die(_("Request error"));

// Permission pour la page product
$c1 = Page::getByPath('/dashboard/core_commerce');
$cp1 = new Permissions($c1);
if (!$cp1->canRead()) die(_("Access Denied."));

$product = CoreCommerceProduct::getById($_REQUEST['pID']);

if (!is_object($product))
	die(_("This product doesn't exist"));

if($product->getProductCollectionID()) :
	$pp = new Permissions(Page::getByID($product->getProductCollectionID()));
	if (!$pp->canRead()) die(_("Access Denied."));
endif;

Loader::PackageElement('product_attribute', 'mylab_product_attribute', array('product'=>$product, 'akID'=>$_REQUEST['akID']));