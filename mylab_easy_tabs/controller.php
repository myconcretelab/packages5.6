<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabEasyTabsPackage extends Package {

	protected $pkgHandle = 'mylab_easy_tabs';
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '1.7.2';
	
	public function getPackageDescription() {
		return t("Transform easily your C5 Layout into tabs");
	}
	
	public function getPackageName() {
		return t("Easy tabs");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('mylab_easy_tabs', $pkg);
 
	}

}