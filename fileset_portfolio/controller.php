<?php      
defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @package Fileset Portfolio
 * @author Sebastien Jacqmin <seb@tellthem.be>
 * @copyright  Copyright (c) 2011 tellthem (http://www.tellthem.be)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class FilesetPortfolioPackage extends Package {

	protected $pkgHandle = 'fileset_portfolio';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.1';
	
	public function getPackageName() {
		return t("Fileset Portfolio");
	}
	
	public function getPackageDescription() {
		return t("Add a incredible page list template for your portfolio, blog list, market items...");
	}
	
	public function install() {
		$pkg = parent::install();
		
		Loader::model('single_page');
		Loader::model('file_version');
		$db = Loader::db();

		Loader::model('portfolio_options',$this->pkgHandle);
		PortfolioOptions::install();

		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle.'/', $pkg);
		$sp->update(array('cName'=>t("Portfolio Options"), 'cDescription'=>t("Configure Fileset Portfolio.")));
		
		$sp = SinglePage::add('/dashboard/'.$this->pkgHandle.'/options/', $pkg);
		$sp->update(array('cName'=>t("General options"), 'cDescription'=>t("Configure how display Filset Portfolio")));

		// Add a substitution file into fileManager
		Loader::library("file/importer");
		$fi = new FileImporter();
		$newFile = $fi->import( __DIR__ . '/files/projects-blank-icon.jpg');
		$newFileID = (is_object($newFile)) ? $newFile->getFileID() : 0; 
		PortfolioOptions::update(array('blankFileID' => $newFileID));
		
		
		//install fileset attribute type  
		$filesetAttrType = AttributeType::getByHandle('fileset');
		if(!is_object($filesetAttrType) || !intval($filesetAttrType->getAttributeTypeID()) ) { 
			$filesetAttrType = AttributeType::add('fileset', t('Fileset'), $pkg); 			  
		} 

		//check that the fileset attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $filesetAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($filesetAttrType);
		
		// install Folio attribute
		$folioList = CollectionAttributeKey::getByHandle('folio_group');
		if( !is_object($folioList) )
			$folioList = CollectionAttributeKey::add($filesetAttrType, array('akHandle' => 'folio_group', 'akName' => t('Portfolio Fileset'), 'akIsSearchable' => false));

		
		
	}
	
	public function uninstall() {
		parent::uninstall();
		$db = Loader::db();
		$db->Execute('DROP TABLE IF EXISTS `PortfolioOptions`');
	}
	
	public function on_start() {
	
	}

}