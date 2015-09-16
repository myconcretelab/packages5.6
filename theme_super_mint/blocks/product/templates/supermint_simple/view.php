<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php  
if (isset($product) && is_object($product)) { 
	$args = array();
	foreach($this->controller->getSets() as $key => $value) {
		$args[$key] = $value;
	}
	// Ajoute pour permettre d'afficher un produit dans 
	// un mega menu et le lier à sa page.
	$args['linkToProductPage'] = true;	

	$args['id'] = $b->getBlockID();
	if ($controller->hideSoldOut && $product->isSoldOut()) {
		// show nothing
	} else {
		$args['propertyOrder'] = $controller->propertyOrder;
		Loader::Element('product/display',$args, 'theme_super_mint');
	}
}
