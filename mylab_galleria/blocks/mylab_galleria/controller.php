<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabGalleriaBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btMylabGalleria';
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	public $width_default	= 600;
	public $height_default	= 300;
	
	protected $btWrapperClass = 'ccm-ui';
	
	// Specific for the Galleria Jquery Gallery

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
		
		$this->customBlockPath = DIR_BASE . '/' . DIRNAME_BLOCKS . '/mylab_galleria';
		$this->BlockPath = DIR_BASE . '/' . DIRNAME_PACKAGES . '/mylab_galleria/' . DIRNAME_BLOCKS . '/mylab_galleria';
		
	}
			
	public function getBlockTypeDescription() {
		return t("Display a full options Galleria");
	}
	
	public function getBlockTypeName() {
		return t("Jquery Galleria");
	}

	public function add () {
		$this->set('width', $this->width_default);
		$this->set('height', $this->height_default);
		$this->set('carousel', true);
		$this->set('carouselFollow', true);
		$this->set('carouselSpeed', 200);
		$this->set('carouselSteps', 'auto');
		$this->set('imageCrop', false);
		$this->set('thumbCrop', true);
		$this->set('imageMargin', 0);
		$this->set('thumbMargin', 0);
		$this->set('maxScaleRatio', 1);
		$this->set('popupLinks', false);
		$this->set('preload', 2);
		$this->set('thumbnails', true);
		$this->set('transition', 'fade'); // flash , slide , fadeslide	
		$this->set('transitionSpeed', 400);
		$this->set('history', true);
		$this->set('slideShow', false);
		$this->set('slideShowSpeed', 3000);
		$this->set('lightboxHeight', 0);
		$this->set('lightboxWidth', 0);
		$this->set('thumbHeight', 80);
		$this->set('thumbWidth', 80);
		$this->set('myColor', '#000000');
		
		$this->edit_utilities();
		
	}
	
	function edit () {
		$this->edit_utilities();		
	}


	function edit_utilities () {
		$this->set('al', Loader::helper('concrete/asset_library'));
		$this->set('ah', Loader::helper('concrete/interface'));
		$this->set('colorh', Loader::helper('form/color'));
		$this->set('af', Loader::helper('form/attribute'));
		$this->set('form',Loader::helper('form'));
		
		Loader::model('file_set');
		Loader::model('file_attributes');
		
		$this->set('fileAttributes', FileAttributeKey::getList()); 
		$this->set('s1', FileSet::getMySets());
		$this->set('fsa', array("" => "Select a file set"));
		
		

		$this->themes = $this->get_dirs(dirname(__FILE__) . '/js/themes/');
		if (is_dir($this->customBlockPath . '/themes')) {
			if ( $customSkins = $this->get_dirs( $this->customBlockPath . '/themes/' )) {
				foreach ($customSkins as $k) :
					$this->themes[] = $k;
				endforeach;
			}
		}
		
		$this->set('themes', $this->addKeyToArray($this->themes));
	}

	public function on_page_view() {
		//$this->addHeaderItem($html->javascript('jquery.ui.js'));		
	}

	public function view() {
		// Check compatibility with Concrete 5.4.1
		if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
			$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
		} else {
			$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
		}

		Loader::model('file');
		Loader::library('file/types');
		$i = Loader::helper('mylab_image', 'mylab_galleria');
		
		$v = array();
		$cc = 0;
		if (is_array($data)) {
			foreach ($data as $k => $d) :
			
				$img = File::getByID($d['fID']);
				$fv = $img->getExtension();
				$ft = FileTypeList::getType($fv);
				if ($ft->type == 1) {
					
					if ($this->imageCropPhp) :
						// $crop is enabled if 'image pan' is disabled 
						$crop = $this->imagePan ? false : true; 
						$image = $i->getThumbnail($img, $this->width, $this->height,array('crop'=>$crop));
					else :
						$s = @getimagesize($img->getPath());
						$image = $i->getThumbnail($img, $s[0], $s[1],array('crop'=>false));				
					endif;
					
					$v[$k]['desc'] = 	$this->getFileFieldValue($img,$this->fsDescription);
					$v[$k]['title'] =	$this->getFileFieldValue($img,$this->fsTitle);
					$v[$k]['width'] = 	$image->width ;
					$v[$k]['height'] = 	$image->height;
					$v[$k]['src'] = 	$image->src;
					
					// Change this values to change thumb size
					
					$thumb = $i->getThumbnail($img, $this->thumbWidth , $this->thumbHeight ,array('crop'=>true));
					$v[$k]['thumb_src'] = 	$thumb->src;
				
					if ($this->lightbox) :
						$w = $this->lightboxWidth ? $this->lightboxWidth : $this->width;
						$h = $this->lightboxHeight ? $this->lightboxHeight : $this->height;
						$ligthboxImage = $i->getThumbnail($img, $w, $h, array('crop'=>false));
						$v[$k]['lightbox_src'] = $ligthboxImage->src;
						//var_dump($ligthboxImage);
					endif;
				}
			endforeach;
			
			$this->set('gal', $v);				
		}


	}
	
	function get_theme_relative_path () {
		if (!$this->theme) $this->theme = 'classic';

		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$blockPath = $bv->getBlockPath();
		$blockUrl = $bv->getBlockURL();
		
		if (is_file( $this->BlockPath . '/js/themes/' . $this->theme . '/galleria.' . $this->theme . '.js')) 
			return $blockUrl . '/js/themes/' . $this->theme . '/galleria.' . $this->theme . '.js';
		
		if (is_file($this->customBlockPath . '/themes/' . $this->theme . '/galleria.' . $this->theme . '.min.js'))
			return BASE_URL . DIR_REL . '/' . DIRNAME_BLOCKS . '/mylab_galleria/themes/' . $this->theme . '/galleria.' . $this->theme . '.min.js';
		
		// Si probleme, retourne le theme classic
		return $blockUrl . '/js/themes/classic/galleria.classic.js';
	}
	
	private function is_bo ($b) {
		if ($b == '0' || $b == '1' ) return true;
		else return false;
	}
	
	private function getFileFieldValue($f,$handle) {
		if(!is_object($f)) {
			return false;
		}
		$value = "";
		switch($handle) {
			case "title";
				$value = $f->getTitle();
			break;
			case "description";
				$value = $f->getDescription();
			break;
			case "date":
				$value = $f->getDateAdded();
			break;
			case "filename":
				$value = $f->getFileName();
			break;
			default:
				$value = $f->getAttribute($handle);
			break;
		}
		return $value;
}

	public function save($data) {
		$data['width'] 		= (is_numeric($data['width']) 		&& $data['width'] >= 0) 		? $data['width'] :  $this->width_default; 
		$data['height'] 	= (is_numeric($data['height']) 		&& $data['height'] >= 0) 	? $data['height'] :  $this->height_default; 
		$data['transitionSpeed']= (is_numeric($data['transitionSpeed']) && $data['transitionSpeed'] >= 0) ? $data['transitionSpeed'] : 400; 
		$data['maxScaleRatio'] 	= (is_numeric($data['maxScaleRatio']) 	&& $data['maxScaleRatio'] >= 0 && $data['maxScaleRatio'] <= 1) ? $data['maxScaleRatio'] :  1; 
		$data['carouselSpeed'] = (is_numeric($data['carouselSpeed']) 	&& $data['carouselSpeed'] >= 0) ? $data['carouselSpeed'] :  200; 
		$data['carouselSteps'] = (is_numeric($data['carouselSteps']) 	&& $data['carouselSteps'] >= 1) ? $data['carouselSteps'] :  'auto'; 
		$data['imageMargin'] = (is_numeric($data['imageMargin']) 	&& $data['imageMargin'] >= 0) ? $data['imageMargin'] :  0; 
		$data['thumbMargin'] = (is_numeric($data['thumbMargin']) 	&& $data['thumbMargin'] >= 0) ? $data['thumbMargin'] : 0; 
		$data['slideShowSpeed'] = (is_numeric($data['slideShowSpeed']) 	&& $data['slideShowSpeed'] >= 0) ? $data['slideShowSpeed'] : 3000; 
		$data['lightboxHeight'] = (is_numeric($data['lightboxHeight']) ) ? $data['lightboxHeight'] : 0; 
		$data['lightboxWidth'] = (is_numeric($data['lightboxWidth']) ) ? $data['lightboxWidth'] : 0; 
		$data['thumbHeight'] = (is_numeric($data['thumbHeight']) ) ? $data['thumbHeight'] : 80; 
		$data['thumbWidth'] = (is_numeric($data['thumbWidth']) ) ? $data['thumbWidth'] : 80; 

		
		parent::save($data);
	}
	
	function get_dirs($dir){ 
		if ($handle = opendir($dir)) {
			$dirs = array();
		    while (false !== ($entry = readdir($handle))) {
			if (is_dir($dir.'/'.$entry) && $entry != "." && $entry != "..") {
				$dirs [] =  $entry;
				
			}
		    }	

		    closedir($handle);
		    
		    return $dirs;
		}
	}
	
	public function addKeyToArray ($array) {
		if (is_array($array)) {
			$return = array();
			foreach ($array as $k) {
				$return[$k] = $k;
			}
			return $return;
		}
	}
	
}
?>
