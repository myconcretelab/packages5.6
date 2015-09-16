<?php      

defined('C5_EXECUTE') or die(_("Access Denied."));

class DeepitSliderPackage extends Package {

	protected $pkgHandle = 'deepit_slider';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0.2';
	
	public function getPackageDescription() {
		return t("Slide your picture with depth!");
	}
	
	public function getPackageName() {
		return t("Deepit Slider");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('deepit_slider', $pkg);
 
	}

}