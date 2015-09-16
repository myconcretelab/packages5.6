<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));

class StacksAttributePackage extends Package {

	protected $pkgHandle = 'stacks_attribute';
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '0.9.0';
	
	public function getPackageDescription() {
		return t("Add a stacks attribute to your C5 installation!");
	}
	
	public function getPackageName() {
		return t("Stacks attribute");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		$db = Loader::db();

		//install fileset attribute type  
		$stacksAttrType = AttributeType::getByHandle('stacks');
		if(!is_object($stacksAttrType) || !intval($stacksAttrType->getAttributeTypeID()) ) { 
			$stacksAttrType = AttributeType::add('stacks', t('Stacks'), $pkg); 			  
		} 

		//check that the fileset attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $stacksAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($stacksAttrType);		  
		
	}

}