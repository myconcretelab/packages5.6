<?php      

defined('C5_EXECUTE') or die(_("Access Denied."));

class CoinSliderPackage extends Package {

	protected $pkgHandle = 'coin_slider';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.12';
	
	public function getPackageDescription() {
		return t("The image slider with unique effects");
	}
	
	public function getPackageName() {
		return t("Coin Slider");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('coin_slider', $pkg);
 
	}

}