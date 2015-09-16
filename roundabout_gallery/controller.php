<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));

class RoundaboutGalleryPackage extends Package {

	protected $pkgHandle = 'roundabout_gallery';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.0';
	
	public function getPackageDescription() {
		return t("Provide a turntable-like interactive slider.");
	}
	
	public function getPackageName() {
		return t("Roundabout Gallery");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('roundabout_gallery', $pkg);
 
	}

}