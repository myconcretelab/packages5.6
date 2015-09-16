<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class BladeSliderPackage extends Package {

	protected $pkgHandle = 'blade_slider';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '0.9.1';
	
	public function getPackageDescription() {
		return t("BLADES jQuery is a flexible jQuery banner rotator that makes an impression. Easy to customize with several options including 5 unique transitions, BLADES jQuery is the type of banner that can easily headline your next project.");
	}
	
	public function getPackageName() {
		return t("Blade Jquery Slider");
	}
	
	
	public function on_start() {
		Events::extend('on_file_add', 'BladeSliderPackage', 'check_main_colors', DIR_PACKAGES . '/' . 'blade_slider' . '/controller.php');
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

	public function check_main_colors ($f, $fv) {

		Loader::library('imageprocessor', 'blade_slider');
		Loader::library('advancedprocessor', 'blade_slider');

		$path = $fv->getPath();

		$AdvancedProcessor = new AdvancedProcessor();
		$map = $AdvancedProcessor->GetColorMap($path);

				
		$col1 = FileAttributeKey::getByHandle('common_color_1');
		$col2 = FileAttributeKey::getByHandle('common_color_2');
		$col3 = FileAttributeKey::getByHandle('common_color_3');

		$fv->setAttribute($col1, BladeSliderPackage::rvb_to_hex($map[0]));		
		$fv->setAttribute($col2, BladeSliderPackage::rvb_to_hex($map[1]));		
		$fv->setAttribute($col3, BladeSliderPackage::rvb_to_hex($map[2]));		
	}
	
	public function install() {
		
		$pkg = parent::install();

		// install block
		BlockType::installBlockTypeFromPackage('blade_slider', $pkg);

				
		$db = Loader::db();
		Loader::library("file/importer");
		Loader::model('file_list');
		Loader::library('file/types');
		Loader::model('collection_attributes');
		Loader::model('collection_types');
		Loader::model('attribute/categories/file');


		
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
		if( !$colorAttrKey || !intval($colorAttrKey->getAttributeKeyID()) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 1"),'akHandle'=>'common_color_1','akIsSearchable'=>0), $pkg);	
		
		// Create common Color 2 attribute Key
		$colorAttrKey = FileAttributeKey::getByHandle('common_color_2');
		if( !$colorAttrKey || !intval($colorAttrKey->getAttributeKeyID()) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 2"),'akHandle'=>'common_color_2','akIsSearchable'=>0), $pkg);	

		// Create common Color 3 attribute Key
		$colorAttrKey = FileAttributeKey::getByHandle('common_color_3');
		if( !$colorAttrKey || !intval($colorAttrKey->getAttributeKeyID()) )
			$colorAttrKey = FileAttributeKey::add( $colorAttrType, array('akName'=>t("Common Color 3"),'akHandle'=>'common_color_3','akIsSearchable'=>0), $pkg);	


	// Install caption_alignment attribute + Options
		
		$pulln = AttributeType::getByHandle('select'); 
		$select_caption = FileAttributeKey::getByHandle('caption_alignment'); 
		if( !is_object($select_caption) ) {
			$select_caption = FileAttributeKey::add($pulln, array('akHandle' => 'caption_alignment', 'akName' => t('Caption Alignment'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 0, 'L', 0));
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 1, 'R', 0));
		}
	

	// Get files to calculate her 3 common colors and put into attribute
		$fl = new FileList();
		$fl->filterByType(FileType::T_IMAGE);
		$files = $fl->get(1000, 0);
		foreach ($files as $file ) {
			$this->check_main_colors($file, $file->getVersion());
		}


		
	}
	
	function delete_package_from_db() {
		$db = Loader::db();
//		$db->execute('DELETE FROM Packages WHERE pkgHandle = "theme_super_mint"');
	}

	function uninstall(){
	      parent::uninstall();
	      $db = Loader::db();
	      //$db->execute("DROP TABLE SuperMintThemeSuperMintOptionsPreset, SuperMintThemePreset");
	}

	function upgrade(){
	      parent::upgrade(); 
	}
	
	
}