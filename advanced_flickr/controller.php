<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

class AdvancedFlickrPackage extends Package {

	protected $pkgHandle = 'advanced_flickr';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t('Adds a Flickr Gallery.');
	}
	
	public function getPackageName() {
		return t('Advanced Flickr');
	}
	
	public function install() {
		$pkg = parent::install();
		// install block		
		BlockType::installBlockTypeFromPackage('advanced_flickr', $pkg);
	}

	
}