<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class ThemeswoshPackage extends Package {

	protected $pkgHandle = 'theme_swosh';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '2.3.5';
	
	public function getPackageDescription() {
		return t("Swosh is designed responsive template, suit any kind of website.");
	}
	
	public function getPackageName() {
		return t("Swosh Theme");
	}
	
	
	public function install($data) {
		
		$pkg = parent::install();

		$db = Loader::db();

		// install theme
		PageTheme::add('swosh', $pkg);
 	
 		$this->installOrUpgrade($pkg);
			
	}
	public function upgrade() {
		$this->installOrUpgrade($this);
		parent::upgrade();
	}

	function installOrUpgrade($pkg) {

		if (! BlockType::getByHandle('icooon')) BlockType::installBlockTypeFromPackage('icooon', $pkg);
		if (! BlockType::getByHandle('team')) BlockType::installBlockTypeFromPackage('team', $pkg);
		if (! BlockType::getByHandle('pie_chart')) BlockType::installBlockTypeFromPackage('pie_chart', $pkg);
		if (! BlockType::getByHandle('separators')) BlockType::installBlockTypeFromPackage('separators', $pkg);
		if (! BlockType::getByHandle('swosh_slider')) BlockType::installBlockTypeFromPackage('swosh_slider', $pkg);

		$db = Loader::db();
	// install icon attribute
		$ift = AttributeType::getByHandle('image_file');
		$iconAttr=CollectionAttributeKey::getByHandle('icon');
		if( !is_object($iconAttr) )
			$iconAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'icon', 'akName' => t('Page Icon'), 'akIsSearchable' => false));
		
	// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			$pageThumbAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail', 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));

	// install page background attribute
		$ift = AttributeType::getByHandle('image_file');
		$pagebgAttr=CollectionAttributeKey::getByHandle('page_background');
		if( !is_object($pagebgAttr) )
			$pagebgAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_background', 'akName' => t('Page Background'), 'akIsSearchable' => false));

	//install fileset attribute type  
		$filesetAttrType = AttributeType::getByHandle('fileset');
		if(!is_object($filesetAttrType) || !intval($filesetAttrType->getAttributeTypeID()) ) { 
			$filesetAttrType = AttributeType::add('fileset', t('Fileset'), $pkg); 			  
		} 

	//check that the fileset attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $filesetAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($filesetAttrType);		  


	// install page backgrounds attribute
		$ift = AttributeType::getByHandle('fileset');
		$pagebgsAttr=CollectionAttributeKey::getByHandle('page_backgrounds');
		if( !is_object($pagebgsAttr) )
			$pagebgsAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_backgrounds', 'akName' => t('Page Backgrounds'), 'akIsSearchable' => false));

	// Install wrap_white_box attribute
		$checkn = AttributeType::getByHandle('boolean'); 
		$headerSlider=CollectionAttributeKey::getByHandle('wrap_white_box'); 
		if( !is_object($headerSlider) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'wrap_white_box', 'akName' => t('Separate each content on a box'),	'akIsSearchable' => false),$pkg);//->setAttributeSet($evset); 
		}
	// Install Icon attribute
		$checkn = AttributeType::getByHandle('text'); 
		$icon=CollectionAttributeKey::getByHandle('icon_font'); 
		if( !is_object($icon) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'icon_font', 'akName' => t('Icon from font-awesome'),	'akIsSearchable' => false),$pkg);//->setAttributeSet($evset); 
		}
		
		$pt = CollectionType::getByHandle('accordion');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'accordion';
			$data['ctName'] = t('Accordion');
			$data['ctIcon'] = 'template3.png';
			$thcpt = CollectionType::add($data, $pkg);
		}
								$pt = CollectionType::getByHandle('accordion');
		$pt = CollectionType::getByHandle('left_sidebar');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'left_sidebar';
			$data['ctName'] = t('Left Sidebar');
			$data['ctIcon'] = 'template1.png';
			$thcpt = CollectionType::add($data, $pkg);
		}
		
		$pt = CollectionType::getByHandle('right_sidebar');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'right_sidebar';
			$data['ctName'] = t('Right Sidebar');
			$data['ctIcon'] = 'right_sidebar.png';
			$fcpt = CollectionType::add($data, $pkg);
		}
		
		$pt = CollectionType::getByHandle('full');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'full';
			$data['ctName'] = t('Full Width');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
	}
}
