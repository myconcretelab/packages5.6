<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class ThemeSuperMintPackage extends Package {

	protected $pkgHandle = 'theme_super_mint';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '2.0.8';
	
	public function getPackageDescription() {
		return t("SuperMint responsive suit eCommerce or any kind of website. ");
	}
	
	public function getPackageName() {
		return t("SuperMint Theme");
	}

	public function install() {
		
		$pkg = parent::install();
		
	// Theme options
		Loader::model('theme_super_mint_options', $pkg->getPackageHandle());
		$options = new ThemeSuperMintOptions();
		$options->install_db();

	// Add theme
		PageTheme::add('super_mint', $pkg);

	// Installing					
		$this->installOrUpgrade($pkg);
		
	}
	private function installOrUpgrade(&$pkg) {


		$db = Loader::db();
		Loader::library("file/importer");
		Loader::model('file_list');
		Loader::library('file/types');
		Loader::library('supermint_installer_utils', $this->pkgHandle);
		Loader::model('collection_types');
		Loader::model('collection_attributes');
		Loader::model('attribute/categories/file');
		Loader::model('attribute/set');
		$installer = new SupermintInstallerUtils ($pkg);

		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options', t('Theme SuperMint'), t('Manage your SuperMint Theme options'));
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/theme_options', t('Theme options'),'','icon-cog');
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/colors', t('Colors'),'','icon-pencil');
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/fonts', t('Fonts'),'','icon-font');
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/page_list', t('Page list - slider'),'','icon-th-large');
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/options_presets', t('Theme options presets'),'','icon-th-list');
		// Core commerce page
		$installer->getOrAddSinglePage('/dashboard/theme_super_mint_options/e_commerce', t('eCommerce'),'','icon-tags');


		// install block
		$installer->getOrInstallBlockType('mylab_spacer');
		$installer->getOrInstallBlockType('icooon');
		$installer->getOrInstallBlockType('team');
		$installer->getOrInstallBlockType('pie_chart');

		// Intall Page-type
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
		$pt = CollectionType::getByHandle('home');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'home';
			$data['ctName'] = t('Home Page');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
		$pt = CollectionType::getByHandle('unbordered');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'unbordered';
			$data['ctName'] = t('Unbordered');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
		$pt = CollectionType::getByHandle('home_unbordered');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'home_unbordered';
			$data['ctName'] = t('Home unbordered');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
		$pt = CollectionType::getByHandle('unbordered_left_sidebar');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'unbordered_left_sidebar';
			$data['ctName'] = t('Unbordered Left Sidebar');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
		$pt = CollectionType::getByHandle('unbordered_right_sidebar');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'unbordered_right_sidebar';
			$data['ctName'] = t('Unbordered Right Sidebar');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}
		$pt = CollectionType::getByHandle('accordion');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'accordion';
			$data['ctName'] = t('Accordion');
			$data['ctIcon'] = 'main.png';
			$ootpt = CollectionType::add($data, $pkg);
		}


		$eaku = AttributeKeyCategory::getByHandle('collection');
		$eaku->setAllowAttributeSets(AttributeKeyCategory::ASET_ALLOW_SINGLE);

		$set = AttributeSet::getByHandle('supermint_theme');
		if (!$set)
			$set = $eaku->addSet('supermint_theme',t('Supermint Theme'),$pkg, 0);
		$asID = $set->asID; 

	// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			$pageThumbAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail','asID' => $asID, 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));

	//install fileset attribute type  
		$filesetAttrType = AttributeType::getByHandle('fileset');
		if(!is_object($filesetAttrType) || !intval($filesetAttrType->getAttributeTypeID())) $filesetAttrType = AttributeType::add('fileset', t('Fileset'), $pkg); 
			
	//check that the fileset attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $filesetAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID()));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($filesetAttrType);
		
	// install page backgrounds attribute
		$ift = AttributeType::getByHandle('fileset');
		$pagebgsAttr=CollectionAttributeKey::getByHandle('page_backgrounds');
		if( !is_object($pagebgsAttr)) 	$pagebgsAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_backgrounds','asID' => $asID, 'akName' => t('Page Background slider'), 'akIsSearchable' => false));

	// install page background attribute
		$ift = AttributeType::getByHandle('image_file');
		$pagebgAttr=CollectionAttributeKey::getByHandle('page_background');
		if( !is_object($pagebgAttr)) $pagebgAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_background','asID' => $asID, 'akName' => t('Page Background'), 'akIsSearchable' => false));


	// install preset list attribute type
		$att = AttributeType::getByHandle('super_mint_preset_list');
		if(!is_object($att) || !intval($att->getAttributeTypeID()) ) { 
			$att = AttributeType::add('super_mint_preset_list', t('SuperMint Theme Preset List'), $pkg); 			  

		}

	//check that the preset list attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $att->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($att);		  

	// install preset list attribute
		$ift = AttributeType::getByHandle('super_mint_preset_list');
		$optionsPresetAttr = CollectionAttributeKey::getByHandle('super_mint_theme_preset_options');
		if( !is_object($optionsPresetAttr) )
			$optionsPresetAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'super_mint_theme_preset_options','asID' => $asID, 'akName' => t('SuperMint Theme preset Options'), 'akIsSearchable' => false));
		
		$installer->getOrInstallCollectionAttributeSelect('supermint_navigation_type',  t('Supermint Navigation Type'), array('Type 1 (L1-2 w desc)','Type 2 (L1-2-3)','Type 3 (L1-2)'), $asID);
		/*
		$select_attr_type = AttributeType::getByHandle('select'); 
		$attrKey = CollectionAttributeKey::getByHandle('supermint_navigation_type'); 
		if( !is_object($attrKey) ) {
			$attrKey = CollectionAttributeKey::add($select_attr_type, array('akHandle' => 'supermint_navigation_type', 'akName' => t('Supermint Navigation Type'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($attrKey->getAttributeKeyID(), 0, 'Type 1 (L1-2 w desc)', 0));
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($attrKey->getAttributeKeyID(), 0, 'Type 2 (L1-2-3)', 0));
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($attrKey->getAttributeKeyID(), 0, 'Type 3 (L1-2)', 0));
		}
		*/

	// Install header_slider attribute
		$checkn = AttributeType::getByHandle('boolean'); 
		$headerSlider=CollectionAttributeKey::getByHandle('easy_slider'); 
		if( !is_object($headerSlider) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'easy_slider','asID' => $asID, 'akName' => t('Header as easy Slider'),	'akIsSearchable' => false),$pkg);//->setAttributeSet($evset); 
		}

	// install Color attribute
		$colorAttrType = AttributeType::getByHandle('color');
		if(!is_object($colorAttrType) || !intval($colorAttrType->getAttributeTypeID()) ) 
			$colorAttrType = AttributeType::add('color', t('Color'), $pkg);

	//check that the color attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $colorAttrType->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($colorAttrType);		  
			
	// Create main page color attribute Key
		$colorAttrKey = CollectionAttributeKey::getByHandle('main_page_color');
		if( !is_object($colorAttrKey) )
			$colorAttrKey = CollectionAttributeKey::add( $colorAttrType, array('akName'=>t("Main page color"),'akHandle'=>'main_page_color','asID' => $asID,'akIsSearchable'=>0), $pkg);	

	// Install Icon attribute
		$checkn = AttributeType::getByHandle('text'); 
		$icon=CollectionAttributeKey::getByHandle('icon'); 
		if( !is_object($icon) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'icon', 'akName' => t('Icon'),'asID' => $asID,	'akIsSearchable' => false),$pkg);//->setAttributeSet($evset); 
		}
		$wrongPageProductCat = CollectionAttributeKey::getByHandle('pageProductCat');
		if ($wrongPageProductCat) $wrongPageProductCat->delete();
		// Install Page product page attribute
		$checkn = AttributeType::getByHandle('boolean'); 
		$pageProductCat=CollectionAttributeKey::getByHandle('page_product_cat'); 
		if( !is_object($pageProductCat) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'page_product_cat', 'akName' => t('Product page Category (eCommerce)'),'asID' => $asID, 'akIsSearchable' => false),$pkg); 
		}		

	}
		
	function precheck(){
		if( false || true ) {
			//$this->delete_package_from_db();
			
			//throw new Exception(t('SOrry you can\'t install package'));  
			//exit;
		}
	}
	function delete_package_from_db() {
		$db = Loader::db();
//		$db->execute('DELETE FROM Packages WHERE pkgHandle = "theme_super_mint"');
	}

	function uninstall(){
	      parent::uninstall();
	      $db = Loader::db();
	      $db->execute("DROP TABLE SuperMintThemeSuperMintOptionsPreset, SuperMintThemePreset");
	}

	public function upgrade() {
		$this->installOrUpgrade($this);		
		
		parent::upgrade();
	}

	public function upgradeCoreData() {
		$db = Loader::db();
		Loader::model('theme_super_mint_options', $this->getPackageHandle());
		$options = new ThemeSuperMintOptions();
		$list = $options->get_presets_list();

		if ($this->pkgVersion < '1.4.1') :
			if (BlockType::getByHandle('icooon'))
				$db->execute("UPDATE btIcooon SET iconName = replace(iconName, 'icon-', 'fa fa-')");	
			if (BlockType::getByHandle('pie_chart'))
				$db->execute("UPDATE btPieChart SET content = replace(content, 'icon-', 'fa fa-')");	
	
			$db->execute("UPDATE SuperMintThemeSuperMintOptionsPreset SET option_key = replace(option_key, '724_ratio', 'w724_ratio')");	
		endif;

		// On ajoute les nouvelles options pour tous les presets
		if ($this->pkgVersion < '1.6') :
			// On ajoute les options
			if ($list) :
				foreach($list as $p) :
					$options->save_options(array(
						'full_width_mega' => 1,
						'mega_columns_width' => 200,
						'display_title_mega_menu' => 0
						),$p['pID']);
				endforeach;
			endif;
		endif;

		if ($this->pkgVersion < '2.0') :
			$options->importXML_preset ($this->getPackagePath() . '/models/theme_presets/pink-ecommerce.mcl');
			$options->importXML_preset ($this->getPackagePath() . '/models/theme_presets/ecommerce-slide.mcl');

			$search = Page::getByPath('/search');
			$searchID = is_object($search) ? $search->getCollectionID() : 0;
			// On ajoute les options
			if ($list) :
				foreach($list as $p) :
					$options->save_options(array(
						'top_nav_hover' => '#373b3e',
						'top_nav_hover_link' => '#ffffff',
						'nav_dbl_click_event' => 'url',
						'nav_shorten_desc' => 200,
						'categories_columns_number' => '3',
						'min_price_search' => '0',
						'max_price_search' => '1000',
						'max_price_search_default' => '100',
						'min_price_search_default' => '0',
						'step_price_search' => '1',
						'bg_cart_color' => '#585f63',
						'txt_cart_color' => '#ffffff',
						'display_searchbox' => $searchID,
						//'footer_fixed' => 1,
			            'footer_credit' => '<span><i class="fa fa-magic"></i> Designed by <a href="http://www.myconcretelab.com/" rel="Concrete5 theme & addons" title="Concrete5 themes & addons by MyConcreteLab">MyConcreteLab</a></span><span class="powered-by"><i class="fa fa-cogs"></i> Powered by <a href="http://www.concrete5.org" title="concrete5 - open source content management system for PHP and MySQL">concrete5</a></span>'
						),$p['pID']);
				endforeach;
			endif;
		endif;
		
		if ($this->pkgVersion < '1.9') :

		endif;
	   	parent::upgradeCoreData();
	}

	
	
	
}