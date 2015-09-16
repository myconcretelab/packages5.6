<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabCountdownPackage extends Package {

	protected $pkgHandle = 'mylab_countdown';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("Provide a fresh Countdown");
	}
	
	public function getPackageName() {
		return t("Countdown");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('mylab_countdown', $pkg);
 
	}

}