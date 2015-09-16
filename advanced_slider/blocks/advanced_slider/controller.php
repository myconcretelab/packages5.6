<?php           
defined('C5_EXECUTE') or die(_("Access Denied."));

class AdvancedSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btAdvancedSlider';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "550";
	
	public $sliceEffectType = array ('fade', 'scale', 'width', 'height', 'random');
	public $slideDirection = array('autoHorizontal', 'autoVertical', 'rightToLeft', 'leftToRight', 'topToBottom' , 'bottomToTop');
	public $effectType = array('fade', 'slide', 'slice', 'radom');
	public $slicePattern = array('randomPattern', 'topToBottom', 'bottomToTop', 'leftToRight', 'rightToLeft', 'topLeftToBottomRight', 'topRightToBottomLeft', 'bottomLeftToTopRight', 'bottomRightToTopLeft', 'horizontalMarginToCenter', 'horizontalCenterToMargin', 'marginToCenter', 'verticalCenterToMargin', 'skipOneTopToBottom', 'skipOneBottomToTop', 'skipOneLeftToRight', 'skipOneRightToLeft', 'skipOneHorizontal', 'skipOneVertical', 'spiralMarginToCenterCW', 'spiralMarginToCenterCCW', 'spiralCenterToMarginCW', 'spiralCenterToMarginCCW', 'random');
	public $slicePoint = array('leftTop', 'leftCenter', 'leftBottom', 'centerTop', 'centerCenter', 'centerBottom', 'rightTop', 'rightCenter', 'rightBottom', 'random');
	public $slideStartPosition = array('left', 'right', 'top', 'bottom', 'leftTop', 'rightTop', 'leftBottom', 'horizontalAlternate', 'verticalAlternate', 'random', 'default');
	public $captionShowEffect = array( 'fade','slide', 'default');
	public $thumbnailsTypes = array('tooltip','scroller','none');
	public $thumbnailOrientations = array('horizontal','vertical');
	public $presets = array();
	
	public function __construct($obj = null) {


		$customBlockPath = DIR_BASE . '/' . DIRNAME_BLOCKS . '/advanced_slider';


		$this->skins = $this->get_dirs(dirname(__FILE__) . '/skins/');
		if (is_dir($customBlockPath . '/skins')) {
			if ( $customSkins = $this->get_dirs( $customBlockPath . '/skins' )) {
				foreach ($customSkins as $k) :
					$this->skins[] = $k;
				endforeach;
			}
		}
		
		$this->scrollbarSkins = $this->get_dirs(dirname(__FILE__) . '/scrollbar_skins/');
		if (is_dir($customBlockPath . '/scrollbar_skins')) {
			if ( $customSkins = $this->get_dirs( $customBlockPath . '/scrollbar_skins' )) {
				foreach ($customSkins as $k) :
					$this->scrollbarSkins[] = $k;
				endforeach;
			}
		}
		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
			
	public function getBlockTypeDescription() {
		return t("The new generation slider. Create your own animations");
	}
	
	public function getBlockTypeName() {
		return t("Advanced Slider");
	}
	
	public function getJavaScriptStrings() {
		return array(
			'fsID-required' => t('You must enter a fileset.'),
			'globalImagePID-required' => t('You must enter a Global transition effect.')
		);
	}
	
	function add () {
		$this->set('fsID', 0);
		$this->set_tools_urls();
		$this->set_helpers();

		//Defaults for new blocks
		$this->set('options',array('slideshow','slideshowControls','timerAnimation','navigationArrows','hideNavigationArrows','navigationButtons','navigationButtonsCenter','showThumbnails'));
		$this->set('width', 600);
		$this->set('height', 300);
		$this->set('gallery_width', '100%');
		$this->set('gallery_height', '100%');
		$this->set('slideshowDelay', 3000);
		$this->set('slidesPreloaded', 0);
		$this->set('aspectRatio', '-1');
		$this->set('scaleType', 'proportionalFit');

	}
		
	function edit() {
		$this->set_tools_urls();
		$this->set_helpers();
		$this->set('options',explode(',',$this->options));		
	}
	
	private function set_tools_urls() {
		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'advanced_slider'));
		$this->set('get_presets_dialog_tool', $th->getToolsURL('get_dialog_presets', 'advanced_slider'));
		$this->set('get_presets_form_tool', $th->getToolsURL('get_form_presets', 'advanced_slider'));
		$this->set('get_presets_options_tool', $th->getToolsURL('get_options_presets', 'advanced_slider'));
		$this->set('get_images_options_tool', $th->getToolsURL('get_images_options', 'advanced_slider'));
		$this->set('save_presets_tool', $th->getToolsURL('save_preset', 'advanced_slider'));
		$this->set('delete_presets_tool', $th->getToolsURL('delete_preset', 'advanced_slider'));
	}
	
	private function set_helpers() {
		Loader::model('file_attributes');
		$this->set('ah', Loader::helper('concrete/interface'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('fileAttributes', FileAttributeKey::getList());

		$th = Loader::helper('concrete/urls'); 
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('advanced_slider')));
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
	

	function delete(){
	}

	public function on_page_view() {
		// Check if update is already done
		if (!$this->skin) {
			$this->skin = 'round';
			$this->scrollbarSkin = 'scrollbar-1';
		}
		//end check 
		$html = Loader::helper('html');
		$th = Loader::helper('concrete/urls');

		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$blockPath = $bv->getBlockPath();
		$blockUrl = $bv->getBlockURL();

		$page = Page::getCurrentPage();

		$javascript = $th->getToolsURL('get_javascript', 'advanced_slider');
		
		if (is_file($bv->getBlockPath() . '/skins/' . $this->skin . '/' . $this->skin . '.css' ))
			$this->addHeaderItem($html->css($blockUrl. '/skins/' . $this->skin . '/' . $this->skin . '.css' ));
		else
			$this->addHeaderItem($html->css(BASE_URL . DIRNAME_BLOCKS . '/advanced_slider/skins/' . $this->skin . '/' . $this->skin . '.css' ));

		if (is_file($bv->getBlockPath() . '/scrollbar_skins/' . $this->scrollbarSkin . '/' . $this->scrollbarSkin . '.css' ))
			$this->addHeaderItem($html->css($blockUrl . '/scrollbar_skins/' . $this->scrollbarSkin . '/' . $this->scrollbarSkin . '.css' ));
		else
			$this->addHeaderItem($html->css(BASE_URL . DIRNAME_BLOCKS . '/advanced_slider/scrollbar_skins/' . $this->scrollbarSkin . '/' . $this->scrollbarSkin . '.css' ));


		$this->addHeaderItem($html->javascript($javascript . '?cID=' . $page->cID . "&bID=" . $this->bID ));

		$this->addHeaderItem('<!--[if IE]><script src="' . $blockUrl. '/additional_js/excanvas.compiled.js"></script><![endif]-->');
	
		

	}

	function view() {
		
		$th = Loader::helper('concrete/urls'); 
		$this->set('tex', Loader::helper('textile','advanced_slider'));
		$this->set('helperUrls',$th);
		$this->set('options',explode(',',$this->options));
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('advanced_slider')));


		if($this->bID) {
			// Check compatibility with Concrete 5.4.1
			if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			} else {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
			}
			Loader::model('file');
			Loader::library('file/types');
			$nv = 		Loader::helper('navigation');
			$i = 		Loader::helper('advanced_image','advanced_slider');
			$options = 	explode(',',$this->options);
			
			$v = array();
			$cc = 0;
			$linkPageID = explode(',',$this->linkPageID);
			$fileLink = explode(',',$this->fileLink);
						
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
			  $s = @getimagesize($img->getPath());
			  $fv = $img->getExtension();
			  $ft = FileTypeList::getType($fv);
			  if ($ft->type == 1) {
				
				$page = Page::getByID($linkPageID[array_search($d['fID'],$fileLink)]);
				if($page->cID) {
					$v[$cc]['isLink'] = true;
					$v[$cc]['link'] = $nv->getLinkToCollection($page);
				} elseif ($img->getAttribute('link_url') ) {
					$v[$cc]['isLink'] = true;
					$v[$cc]['link'] = $img->getAttribute('link_url');
					
				} else {
					$v[$cc]['isLink'] = false;
				}      
				$v[$cc]['desc'] = 	$this->getFileFieldValue($img,$this->caption);
				$v[$cc]['alt'] =	$img->getTitle();			
				$thumb =		$i->getThumbnail($img,80,50, array('crop'=>true));
				$v[$cc]['thumb'] = 	$thumb->src;				
				if (in_array('resize', $options) && $this->width && $this->height) :
					$thb = 			$i->getThumbnail($img,$this->width,$this->height,array('crop' =>  in_array('crop', $options) ));
					$v[$cc]['src'] = 	$thb->src;				
					$v[$cc]['width'] = 	$thb->width ;
					$v[$cc]['height'] = 	$thb->height;
				else :
					$v[$cc]['src'] = 	$img->getRelativePath(); //$src->src;								
					$v[$cc]['width'] = 	$s[0] ;
					$v[$cc]['height'] = 	$s[1] ;
				endif;
				$cc ++;
			  }
			}
			$this->set('gallery', $v);
		} else {
			$this->set('gallery', 'Error');
		}		
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
	function save ($data) {
		
		// some check
		$data['options'] = 	is_array($data['options']) ? implode(',',$data['options']) : '';		
		$data['imagePID'] = 	is_array($data['imagePID']) ? implode(',',$data['imagePID']) : $data['imagePID'];		
		$data['linkPageID'] = 	is_array($data['linkPageID']) ? implode(',',$data['linkPageID']) : $data['linkPageID'];
		$data['fileLink'] = 	is_array($data['fileLink']) ? implode(',',$data['fileLink']) : $data['fileLink'];
		parent::save($data);

	}
	
	
	public function php2js ($var) {
	    if (is_array($var)) {
		$res = "[";
		$array = array();
		foreach ($var as $a_var) {
		    $array[] = $this->php2js($a_var);
		}
		return "[" . join(",", $array) . "]";
	    }
	    elseif (is_bool($var)) {
		return $var ? "true" : "false";
	    }
	    elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
		return $var;
	    }
	    elseif (is_string($var)) {
		return "\"" . addslashes(stripslashes($var)) . "\"";
	    }
	    return FALSE;
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
	
	function dump(&$var, $info = FALSE) {
		$scope = false;
		$prefix = 'unique';
		$suffix = 'value';
		
		if($scope) $vals = $scope;
		else $vals = $GLOBALS;
		
		$old = $var;
		$var = $new = $prefix.rand().$suffix; $vname = FALSE;
		foreach($vals as $key => $val) if($val === $new) $vname = $key;
		$var = $old;
		
		echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 10px; line-height: 13px;'>";
		if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
		$this->do_dump($var, '$'.$vname);
		echo "</pre>";
	}
	
////////////////////////////////////////////////////////
// Function:         do_dump
// Inspired from:     PHP.net Contributions
// Description: Better GI than print_r or var_dump

	function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)	{
		$do_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
		$reference = $reference.$var_name;
		$keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';
		
		if (is_array($var) && isset($var[$keyvar]))
		{
		    $real_var = &$var[$keyvar];
		    $real_name = &$var[$keyname];
		    $type = ucfirst(gettype($real_var));
		    echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
		}
		else
		{
		    $var = array($keyvar => $var, $keyname => $reference);
		    $avar = &$var[$keyvar];
		
		    $type = ucfirst(gettype($avar));
		    if($type == "String") $type_color = "<span style='color:green'>";
		    elseif($type == "Integer") $type_color = "<span style='color:red'>";
		    elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
		    elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
		    elseif($type == "NULL") $type_color = "<span style='color:black'>";
		
		    if(is_array($avar))
		    {
			$count = count($avar);
			echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
			$keys = array_keys($avar);
			foreach($keys as $name)
			{
			    $value = &$avar[$name];
			    $this->do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
			}
			echo "$indent)<br>";
		    }
		    elseif(is_object($avar))
		    {
			echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
			foreach($avar as $name=>$value) $this->do_dump($value, "$name", $indent.$do_dump_indent, $reference);
			echo "$indent)<br>";
		    }
		    elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		    elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
		    elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		    elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
		    elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
		    else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";
		
		    $var = $var[$keyvar];
		}
	}


}
?>
