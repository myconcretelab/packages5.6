<?php       

defined('C5_EXECUTE') or die(_("Access Denied."));

class NivoSliderPackage extends Package {

	protected $pkgHandle = 'nivo_slider';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.0.1';
	
	public function getPackageDescription() {
		return t("The most awesome jQuery Image Slider");
	}
	
	public function getPackageName() {
		return t("Nivo Slider");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('nivo_slider', $pkg);
 
	}

}