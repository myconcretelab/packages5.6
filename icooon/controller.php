<?php  

defined('C5_EXECUTE') or die(_("Access Denied."));

class IcooonPackage extends Package {

	protected $pkgHandle = 'icooon';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.2';
	
	public function getPackageDescription() {
		return t("A block to display icons in many sexy way");
	}
	
	public function getPackageName() {
		return t("Icooon !");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('icooon', $pkg);
 
	}

	public function upgradeCoreData() {
		$db = Loader::db();

		if ($this->pkgVersion < '1.2') :
			$db->execute("UPDATE btIcooon SET iconName = replace(iconName, 'icon-', 'fa fa-')");	
		endif;

	   	parent::upgradeCoreData();
	}	

}