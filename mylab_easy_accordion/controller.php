<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabEasyAccordionPackage extends Package {

	protected $pkgHandle = 'mylab_easy_accordion';
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '1.1.3';
	
	public function getPackageDescription() {
		return t("Transform easily your C5 Layout into accordion content");
	}
	
	public function getPackageName() {
		return t("Easy Accordion");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('mylab_easy_accordion', $pkg);
 
	}

}