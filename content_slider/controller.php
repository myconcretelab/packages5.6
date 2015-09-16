<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class ContentSliderPackage extends Package {

	protected $pkgHandle = 'content_slider';
	protected $appVersionRequired = '5.3.2';
	protected $pkgVersion = '1.2.4';
	
	public function getPackageDescription() {
		return t("Create sliders based on a C5 Stack");
	}
	
	public function getPackageName() {
		return t("Content Slider");
	}
	
	public function install() {
		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage('content_slider', $pkg);
	}




}