<?php    

defined('C5_EXECUTE') or die(_("Access Denied."));

class AirSliderPackage extends Package {

	protected $pkgHandle = 'air_slider';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("Air Slider is a awesome slider for your next project");
	}
	
	public function getPackageName() {
		return t("Air Slider");
	}
	
	
	public function on_start() {
		Events::extend('on_file_add', 'AirSliderPackage', 'check_main_colors', DIR_PACKAGES . '/' . 'air_slider' . '/controller.php');
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

	public function check_main_colors ($f, $fv = null) {

		if (!$fv) $fv = $f->getVersion();

		Loader::model('collection_attributes');
		Loader::model('attribute/categories/file');

		$path = $fv->getPath();

		//list($width, $height, $type, $attr) = getimagesize($path);
		//if ($width > 1200 || $height > 1200) return;

		$map = AirSliderPackage::GetColorMap($path);

				
		$col1 = FileAttributeKey::getByHandle('common_color_1');

		$fv->setAttribute($col1, AirSliderPackage::rvb_to_hex($map[0]));		
	}
	
	public function install() {
		
		$pkg = parent::install();

		// install block
		BlockType::installBlockTypeFromPackage('air_slider', $pkg);

				
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
		
	// Install link_url attribute	
		$txt = AttributeType::getByHandle('text'); 
		$link = FileAttributeKey::getByHandle('link_url'); 
		if( !is_object($link) ) {
			$link = FileAttributeKey::add($txt, array('akHandle' => 'link_url', 'akName' => t('Link Url'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
		}

	// Install Link_text attribute	
		$txt = AttributeType::getByHandle('text'); 
		$link = FileAttributeKey::getByHandle('link_text'); 
		if( !is_object($link) ) {
			$link = FileAttributeKey::add($txt, array('akHandle' => 'link_text', 'akName' => t('Link Text'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
		}
	// Install caption_alignment attribute + Options
		
		$pulln = AttributeType::getByHandle('select'); 
		$select_caption = FileAttributeKey::getByHandle('caption_alignment'); 
		if( !is_object($select_caption) ) {
			$select_caption = FileAttributeKey::add($pulln, array('akHandle' => 'caption_alignment', 'akName' => t('Caption Alignment'), 'akIsSearchable' => 0, 'akIsSearchableIndexed' => 0, 'akSelectAllowOtherValues' => false),$pkg);
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 0, 'L', 0));
			$db->Execute('insert into atSelectOptions (akID, displayOrder, value, isEndUserAdded) values (?, ?, ?, ?)', array($select_caption->getAttributeKeyID(), 1, 'R', 0));
		}
	
	// install page thumbnail attribute
		$ift = AttributeType::getByHandle('image_file');
		$pageThumbAttr=CollectionAttributeKey::getByHandle('page_thumbnail');
		if( !is_object($pageThumbAttr) )
			$pageThumbAttr = CollectionAttributeKey::add($ift, array('akHandle' => 'page_thumbnail', 'akName' => t('Page Thumbnail'), 'akIsSearchable' => false));

	// Get files to calculate her 3 common colors and put into attribute
		$fl = new FileList();
		$fl->filterByType(FileType::T_IMAGE);
		$files = $fl->get(10, 0);
		foreach ($files as $file ) {
			$fv = $file->getVersion();
			$this->check_main_colors($file, $fv);
			if (!$file->getAttribute('caption_alignment'))
				$this->attribute_aligmment($fv);
		}


		
	}

	function attribute_aligmment ($fv) {
		$ca = FileAttributeKey::getByHandle('caption_alignment');
		$fv->setAttribute($ca,'L');	

	}
	
	function delete_package_from_db() {
		$db = Loader::db();
	}

	function uninstall(){
	      parent::uninstall();
	}

	function upgrade(){
	      parent::upgrade(); 
	}

	public function GetPixelColor($file, $x, $y) {
		
		// Get extension
		$extension = end(explode(".", $file));
		

		switch($extension){
			case "jpeg":
			case "jpg":
				@ini_set('gd.jpeg_ignore_warning', 1);
				$image = @imageCreateFromJPEG($file);
				break;
			case "gif":
				$image = imagecreatefromgif($file);
				break;
			case "png":
				$image = imagecreatefrompng($file);
				break;
			default:
			return array(0,0,0); // Comment gérer l'erreur que c'est pas un format connu?
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
		$map[] = AirSliderPackage::GetPixelColor($file, $horizontalstep, $verticalstep);
		$map[] = AirSliderPackage::GetPixelColor($file, $horizontalstep * 2, $verticalstep);
		$map[] = AirSliderPackage::GetPixelColor($file, $horizontalstep, $verticalstep * 2);
		$map[] = AirSliderPackage::GetPixelColor($file, $horizontalstep * 2, $verticalstep * 2);
		
		// Return map
		return $map;
		
	}	
	
	
}