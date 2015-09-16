<?php      

defined('C5_EXECUTE') or die(_("Access Denied."));

class AdvancedContentPackage extends Package {

	protected $pkgHandle = 'advanced_content';
	protected $appVersionRequired = '5.4.2.2';
	protected $pkgVersion = '0.9.1';
	
	public function getPackageDescription() {
		return t("Inspired by Wordpress shortcodes, two brackets to add interactive, responsive elements to your page");
	}
	
	public function getPackageName() {
		return t("Advanced Content");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('advanced_content', $pkg);
 
	}

}