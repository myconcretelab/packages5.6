<?php        

defined('C5_EXECUTE') or die(_("Access Denied."));

class ThemeSilencePackage extends Package {

	protected $pkgHandle = 'theme_silence';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '1.7.3';
	
	public function getPackageDescription() {
		return t("The next generation theme with lot of new features");
	}
	
	public function getPackageName() {
		return t("Silence Theme");
	}
	
	public function install() {
		
		$pkg = parent::install();
		
		$db = Loader::db();
		$fh = Loader::helper('theme_file', $pkg->getPackageHandle());
		Loader::library("file/importer");
		Loader::model("file_set");
		Loader::model('collection_attributes');
		Loader::model('collection_types');		
		Loader::model('theme_options', $pkg->getPackageHandle());

		$options = new ThemeOptions();
		$options->install_db();

		PageTheme::add('silence', $pkg);
				
		$pt = CollectionType::getByHandle('headered');
		if(!is_object($pt)) {
			$data['ctHandle'] = 'headered';
			$data['ctName'] = t('Page with header');
			$data['ctIcon'] = 'main.png';
			
			$tcpt = CollectionType::add($data, $pkg);
		}
		
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
		
		
		
		// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail', 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));

		// install preset list attribute type
		$att = AttributeType::getByHandle('preset_list');
		if(!is_object($att) || !intval($att->getAttributeTypeID()) ) { 
			$att = AttributeType::add('preset_list', t('Preset List'), $pkg); 			  
		} 

		//check that the preset list attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $att->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($att);		  

		// install preset list attribute
		$ift = AttributeType::getByHandle('preset_list');
		$optionsPresetAttr = CollectionAttributeKey::getByHandle('theme_preset_options');
		if( !is_object($optionsPresetAttr) )
			CollectionAttributeKey::add($ift, array('akHandle' => 'theme_preset_options', 'akName' => t('Theme preset Options'), 'akIsSearchable' => false));


		Loader::model('single_page');
		$def = SinglePage::add('/dashboard/theme_options', $pkg);
		$def->update(array('cName'=>'Theme Silence', 'cDescription'=>t('Manage your Silence Theme options')));
		SinglePage::add('/dashboard/theme_options/theme_options', $pkg);
		SinglePage::add('/dashboard/theme_options/types_and_colors', $pkg);
		SinglePage::add('/dashboard/theme_options/page_list', $pkg);
		SinglePage::add('/dashboard/theme_options/background', $pkg);
		SinglePage::add('/dashboard/theme_options/options_presets', $pkg);

		/* Install patterns - titles left - titles right into filemanger
		  Remplis le filemanager avec 50 images dont l'utilisateur n'a rien ˆ faire..

		$packagePath = $pkg->getPackagePath();
	
		$instal_files = array();
	        $instal_files[] = array('option_name' => 'THEME_PATTERNS_FSID', 'fileset' =>'Theme patterns', 'files_path' => $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/patterns/'), 'path' => $packagePath . '/' . DIRNAME_IMAGES . '/patterns/');
	        $instal_files[] = array('option_name' => 'THEME_LEFT_SIDEBAR_FSID', 'fileset' =>'Theme left sidebar', 'files_path' => $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/left_sidebar_title/'), 'path' => $packagePath . '/' . DIRNAME_IMAGES . '/left_sidebar_title/');
	        $instal_files[] = array('option_name' => 'THEME_RIGHT_SIDEBAR_FSID', 'fileset' =>'Theme right sidebar', 'files_path' => $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/right_sidebar_title/'), 'path' => $packagePath . '/' . DIRNAME_IMAGES . '/right_sidebar_title/');
	        $instal_files[] = array('option_name' => 'THEME_BUTTONS_FSID', 'fileset' =>'Theme buttons', 'files_path' => $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/buttons/'), 'path' => $packagePath . '/' . DIRNAME_IMAGES . '/buttons/');

		foreach ($instal_files as $f):
			$fsn = $f['fileset'];
			foreach ($f['files_path'] as $fileHandle => $fileName) :
				$info = $this->create_image($f['path'] . $fileHandle . '.png' , $fsn, $fileName);				
			endforeach;
			if (is_array($info))
                                Config::save( $f['option_name'], $info['fsID']); // Use Config make more sens for me
				//$options->save_options( array($f['option_name'] => $info['fsID'] ), 0);		
		endforeach;

		*/
				
		// create some directory to extend theme ressources
		/*
		if (!is_dir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_patterns'))
			mkdir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_patterns');
		if (!is_dir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_buttons'))
			mkdir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_buttons');
		if (!is_dir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_left_sidebar_title'))
			mkdir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_left_sidebar_title');
		if (!is_dir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_right_sidebar_title'))
			mkdir(DIR_BASE . '/' . DIRNAME_IMAGES . '/' . 'theme_right_sidebar_title');
		*/
	}
	
	public function upgradeCoreData() {
		$db = Loader::db();

		// On ajoute les nouvelles options pour tous les presets
		if ($this->pkgVersion < '1.7') :
			// On ajoute les options
			Loader::model('theme_options', 'theme_silence');
			$options = new ThemeOptions();
			$list = $options->get_presets_list();
			if ($list) :
				foreach($list as $p) :
					$options->save_options(array(
						'bg_top_height_large' => 250,
						'bg_top_height_medium' => 250,
						'bg_top_height_small' => 250,
						'bg_top_height_mobile_xsmall' => 250
						),$p['pID']);
				endforeach;
			endif;
		endif;
	   	parent::upgradeCoreData();
	}
	
	
}