<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class NaviBoxPackage extends Package {

	protected $pkgHandle = 'navi_box';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() { return t("Install a fun animated templates for autonav."); }

	public function getPackageName() { return t("Navi Box"); }

	public function install() { $pkg = parent::install();

		// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail', 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));
	
	
	}	
}
