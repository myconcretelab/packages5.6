<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));

class FilesetAttributePackage extends Package {

	protected $pkgHandle = 'fileset_attribute';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.1';
	
	public function getPackageDescription() {
		return t("Add a Fileset attribute to your C5 instalation!");
	}
	
	public function getPackageName() {
		return t("Fileset attribute");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		$db = Loader::db();

		//install fileset attribute type  
		$filesetAttrType = AttributeType::getByHandle('fileset');
		if(!is_object($filesetAttrType) || !intval($filesetAttrType->getAttributeTypeID()) ) { 
			$filesetAttrType = AttributeType::add('fileset', t('Fileset'), $pkg); 			  
		} 

		//check that the fileset attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $filesetAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($filesetAttrType);		  
		   
		/*		
		$filesetAttrKey=CollectionAttributeKey::getByHandle('files');
		if( !$multiFileAttrKey || !intval($multiFileAttrKey->getAttributeKeyID()) )
			$multiFileAttrKey = CollectionAttributeKey::add( $multiFileAttrType, array('akName'=>t("Images/Files"),'akHandle'=>'files','akIsSearchable'=>0), $pkg) ;//null, 'MULTIPLE_FILES');	
		*/	


		
	}

}