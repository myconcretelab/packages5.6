<?php      

defined('C5_EXECUTE') or die(_("Access Denied."));

class KwiksSliderPackage extends Package {

	protected $pkgHandle = 'kwiks_slider';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.0';
	
	public function getPackageDescription() {
		return t("The most awesome jQuery fileset & Scrapbook Slider");
	}
	
	public function getPackageName() {
		return t("Kwiks Slider");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('kwiks_slider', $pkg);
 
	}

}