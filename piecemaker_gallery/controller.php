<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class PiecemakerGalleryPackage extends Package {

	protected $pkgHandle = 'piecemaker_gallery';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '2.0.4';
	
	public function getPackageDescription() {
		return t("The version 2.0 of the famous 3D flash gallery.");
	}
	
	public function getPackageName() {
		return t("Piecemaker Gallery");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('piecemaker_gallery', $pkg);
 
	}

}