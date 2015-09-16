<?php           

defined('C5_EXECUTE') or die(_("Access Denied."));

class AdvancedSliderPackage extends Package {

	protected $pkgHandle = 'advanced_slider';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.0.1';
	
	public function getPackageDescription() {
		return t("The new Generation responsive slider. Create your own animations");
	}
	
	public function getPackageName() {
		return t("Advanced Slider");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('advanced_slider', $pkg);
 
	}

}