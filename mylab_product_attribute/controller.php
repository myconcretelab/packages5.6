<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));


class MylabProductAttributePackage extends Package {

	protected $pkgHandle = 'mylab_product_attribute';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.3';  
	
	public function getPackageDescription() { 
		return t("A custom attribute for simple or multiple ecommerce product");
	}
	
	public function getPackageName() {
		return t("Product Attribute"); 
	}
		
	public function install() {

		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		$db = Loader::db(); 
		$pkg = parent::install();		
		
		// install block		
		BlockType::installBlockTypeFromPackage('related_products', $pkg);	

		//install new products attribute type  
		$productAttribute = AttributeType::getByHandle('corecommerce_product');
		if(!is_object($productAttribute) || !intval($productAttribute->getAttributeTypeID()) ) { 
			$productAttribute = AttributeType::add('corecommerce_product', t('Core commerce Product'), $pkg); 			  
		} 
		
		//check that the product attribute type is associate with products
		$ccProductAttributeCat = AttributeKeyCategory::getByHandle('core_commerce_product');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $productAttribute->getAttributeTypeID(), $ccProductAttributeCat->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $ccProductAttributeCat->associateAttributeKeyType($productAttribute);		  
		
		// Creer une attribut nommé related_products   			
		$args = array('akHandle' => 'related_products', 'akName' => t('Related products'), 'akIsSearchable' => false,'akIsSearchableIndexed'=>false,'poakIsRequired'=>false);
		$related_products = CoreCommerceProductAttributeKey::add('corecommerce_product', $args);

	}

}

?>