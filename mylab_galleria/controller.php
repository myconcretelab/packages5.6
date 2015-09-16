<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
class MylabGalleriaPackage extends Package {

	protected $pkgHandle = 'mylab_galleria';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.2.2';
	
	public function getPackageDescription() {
		return t("Provide a full options Jquery Galleria block. Ideal for photos or pictures gallery");
	}
	
	public function getPackageName() {
		return t("Jquery Galleria");
	} 
	
	public function install() {
		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage('mylab_galleria', $pkg);
	}
}