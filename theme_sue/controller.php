<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class ThemeSuePackage extends Package {

	protected $pkgHandle = 'theme_sue';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '1.1.3';
	
	public function getPackageDescription() {
		return t("Sue is designed Modern and minimalist template, suit any kind of website.");
	}
	
	public function getPackageName() {
		return t("Sue Theme");
	}
	
	
	public function on_start() {
		Events::extend('on_file_add', 'ThemeSuePackage', 'check_main_colors', DIR_PACKAGES . '/' . 'theme_sue' . '/controller.php');
	//	Events::extend('on_file_version_add', 'SueThemeHelper', 'check_main_colors', DIR_PACKAGES . '/' . $this->pkgHandle . '/' . DIRNAME_HELPERS . '/sue_theme.php');
	}
	
	public function check_main_colors ($f, $fv) {

		if (!$fv) $fv = $f->getVersion();

		Loader::model('collection_attributes');
		Loader::model('attribute/categories/file');

		$path = $fv->getPath();

		list($width, $height, $type, $attr) = getimagesize($path);
		if ($width > 1200 || $height > 1200) return;

		$map = ThemeSuePackage::GetColorMap($path);

				
		$col1 = FileAttributeKey::getByHandle('common_color_1');
		$col2 = FileAttributeKey::getByHandle('common_color_2');
		$col3 = FileAttributeKey::getByHandle('common_color_3');

		$fv->setAttribute($col1, ThemeSuePackage::rvb_to_hex($map[0]));		
		$fv->setAttribute($col2, ThemeSuePackage::rvb_to_hex($map[1]));		
		$fv->setAttribute($col3, ThemeSuePackage::rvb_to_hex($map[2]));		
	}
	
	public function install($data) {
		
		$pkg = parent::install();
		
		$this->precheck();
		
		$db = Loader::db();
		$fh = Loader::helper('theme_file', $pkg->getPackageHandle());
		Loader::library("file/importer");
		Loader::model('file_list');
		Loader::library('file/types');
		Loader::model('collection_attributes');
		Loader::model('collection_types');
		Loader::model('attribute/categories/file');
		Loader::model('theme_sue_options', $pkg->getPackageHandle());

		$options = new ThemeSueOptions();

		if (is_array($data) && isset($data['theme']))  
			$options->install_db($data['theme']);
		else
			$options->install_db();		
		

		PageTheme::add('sue', $pkg);

				
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
		
		// install Color attribute
		$colorAttrType = AttributeType::getByHandle('color');
		if(!is_object($colorAttrType) || !intval($colorAttrType->getAttributeTypeID()) ) 
			$colorAttrType = AttributeType::add('color', t('Color'), $pkg);

		//check that the color attribute type is associate with files
		$fileAttrCategory = AttributeKeyCategory::getByHandle('file');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $colorAttrType->getAttributeTypeID(), $fileAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $fileAttrCategory->associateAttributeKeyType($colorAttrType);		  
			

		// Create common Color 1 attribute Key
		$colorAttrKey = FileAttributeKey::getByHandle('common_color_1');
		if( !is_object($colorAttrKey) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 1"),'akHandle'=>'common_color_1','akIsSearchable'=>0), $pkg);	
		
		// Create common Color 2 attribute Key
		$colorAttrKey = FileAttributeKey::getByHandle('common_color_2');
		if( !is_object($colorAttrKey) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 2"),'akHandle'=>'common_color_2','akIsSearchable'=>0), $pkg);	

		// Create common Color 3 attribute Key
		$colorAttrKey = FileAttributeKey::getByHandle('common_color_3');
		if( !is_object($colorAttrKey) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 3"),'akHandle'=>'common_color_3','akIsSearchable'=>0), $pkg);	


		
	// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			$pageThumbAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail', 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));

	// install preset list attribute type
		$att = AttributeType::getByHandle('sue_preset_list');
		if(!is_object($att) || !intval($att->getAttributeTypeID()) ) { 
			$att = AttributeType::add('sue_preset_list', t('Sue Theme Preset List'), $pkg); 			  

		}

	//check that the preset list attribute type is associate with pages
		$collectionAttrCategory = AttributeKeyCategory::getByHandle('collection');
		$catTypeExists = $db->getOne('SELECT count(*) FROM AttributeTypeCategories WHERE atID=? AND akCategoryID=?', array( $att->getAttributeTypeID(), $collectionAttrCategory->getAttributeKeyCategoryID() ));
		if(!$catTypeExists) $collectionAttrCategory->associateAttributeKeyType($att);		  

	// install preset list attribute
		$ift = AttributeType::getByHandle('sue_preset_list');
		$optionsPresetAttr = CollectionAttributeKey::getByHandle('sue_theme_preset_options');
		if( !is_object($optionsPresetAttr) )
			$optionsPresetAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'sue_theme_preset_options', 'akName' => t('Sue Theme preset Options'), 'akIsSearchable' => false));
	
	// Install header_slider attribute
		$checkn = AttributeType::getByHandle('boolean'); 
		$headerSlider=CollectionAttributeKey::getByHandle('easy_slider'); 
		if( !is_object($headerSlider) ) {
			CollectionAttributeKey::add($checkn, array('akHandle' => 'easy_slider', 'akName' => t('Header as easy Slider'),	'akIsSearchable' => false),$pkg);//->setAttributeSet($evset); 
		}
	
	// Install caption_alignment attribute + Options
		$pulln = AttributeType::getByHandle('select'); 
		$select_caption = CollectionAttributeKey::getByHandle('caption_alignment'); 
		if( !is_object($select_caption) ) {
			$select_caption = CollectionAttributeKey::add($pulln, array('akHandle' => 'caption_alignment', 'akName' => t('Caption Alignment'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 0, 'L', 0));
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 1, 'R', 0));
		}
	
		


		Loader::model('single_page');
		$def = SinglePage::add('/dashboard/theme_sue_options', $pkg);
		$def->update(array('cName'=>'Theme Sue', 'cDescription'=>t('Manage your Sue Theme options')));
		SinglePage::add('/dashboard/theme_sue_options/theme_options', $pkg);
		SinglePage::add('/dashboard/theme_sue_options/colors', $pkg);
		SinglePage::add('/dashboard/theme_sue_options/sliders', $pkg);
		SinglePage::add('/dashboard/theme_sue_options/options_presets', $pkg);


	// Get files to calculate her 3 common colors and put into attribute
		$fl = new FileList();
		$fl->filterByType(FileType::T_IMAGE);
		$files = $fl->get(1000, 0);
		foreach ($files as $file ) {
			$this->check_main_colors($file, $file->getVersion());
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
//		$db->execute('DELETE FROM Packages WHERE pkgHandle = "theme_sue"');
	}

	function uninstall(){
	      parent::uninstall();
	      $db = Loader::db();
	      //$db->execute("DROP TABLE SueThemeSueOptionsPreset, SueThemePreset");
	}

	function upgrade(){
	      parent::upgrade(); 
	}
	static function rvb_to_hex ($color) {

		if(!is_array($color)){$color = explode(",",$color);}

		foreach($color as $value){
			$hex_value = dechex($value); 
			if(strlen($hex_value)<2){$hex_value="0".$hex_value;}
			$hex_RGB.=$hex_value;
		}
		
		return "#" . $hex_RGB;	
	}
	public function GetPixelColor($file, $x, $y) {
		
		// Get extension
		$extension = end(explode(".", $file));
		

		switch($extension){
			case "jpeg":
			case "jpg":
				@ini_set('gd.jpeg_ignore_warning', 1);
				$image = imagecreatefromjpeg($file);
				break;
			case "gif":
				$image = imagecreatefromgif($file);
				break;
			case "png":
				$image = imagecreatefrompng($file);
				break;
		}

		// Get pixel color
		$rgb = imagecolorat($image, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		// Return pixel color
		return array($r,$g,$b);
	}
	
	/**
	 * Generate colorarray for a given image
	 *
	 * @param string $file
	 * @return array
	 */
	public function GetColorMap($file) {
		
		// Get image information
		list($width, $height, $type, $attr) = getimagesize($file);
		
		// Calculate step
		$horizontalstep = floor($width / 3);
		$verticalstep = floor($height / 3);
		
		// Get pixel colors
		$map[] = ThemeSuePackage::GetPixelColor($file, $horizontalstep, $verticalstep);
		$map[] = ThemeSuePackage::GetPixelColor($file, $horizontalstep * 2, $verticalstep);
		$map[] = ThemeSuePackage::GetPixelColor($file, $horizontalstep, $verticalstep * 2);
		$map[] = ThemeSuePackage::GetPixelColor($file, $horizontalstep * 2, $verticalstep * 2);
		
		// Return map
		return $map;
		
	}	
}