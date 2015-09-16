<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class CoverNavigatorPackage extends Package {

	protected $pkgHandle = 'cover_navigator';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("A new Generation slider. Create your own animations");
	}
	
	public function getPackageName() {
		return t("Cover Navigator");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('cover_navigator', $pkg);
 
	}
	
	public function on_start() {
		//die('on start');
		//$pkg = Package::getByID($this->getPackageID());
		$ft = FileTypeList::getInstance();
		// ($extension, $name, $type, $customImporter = false, $inlineFileViewer = false, $editor = false, $pkgHandle = false) 
		$ft->define('youtube', t('Youtube'), FileType::T_TEXT, 'youtube', 'youtube', false, 'cover_navigator');
		//var_dump($ft);
	}

}