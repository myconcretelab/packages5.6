<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));

class PiecemakerGalleryBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btPiecemakerGallery';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "450";
	

	public $default_settings = array( 'Autoplay' => 10, 'LoaderColor' => "333333", 'DropShadowAlpha' => 0.7, 'DropShadowDistance' => 25, 'DropShadowScale' => 0.95, 'MenuDistanceX' => 20, 'MenuDistanceY' => 50, 'MenuColor1' => 999999, 'MenuColor2' => "333333", 'MenuColor3' => "FFFFFF", 'ControlSize' => 100, 'ControlDistance' => 20, 'ControlColor1' => "222222", 'ControlColor2' => "FFFFFF", 'ControlsY' => "280", 'TooltipHeight' => "31", 'TooltipColor' => "222222", 'TooltipTextColor' => "FFFFFF", 'InfoWidth' => "400", 'InfoBackground' => "FFFFFF");
	
	public function getBlockTypeName() {
		return t("Piecemaker Gallery");
	}
	
	
	public function getBlockTypeDescription() {
		return t("Display a awesome 3D gallery");
	}	
	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}		

	public function on_page_view() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('swfobject.js'));
	}
	
	public function add () {
		$this->set_form_utilities();
		$this->set_tools_url();
		$this->set('options', array_values($this->default_settings));
		$this->set('transitions', array('0'));
		$this->set('width', 600);
		$this->set('height', 200);
		$this->set('awidth', 80);
		$this->set('aheight', 80);
		
	}
	public function edit() {
		if (!$this->check_gallery_data_compatible()) {
			$this->add();
		} else {
			$this->set_form_utilities();
			$this->set_tools_url();
			$this->set('options', explode(',',$this->options));
			$this->set('transitions', explode(',',$this->transitions));
			$this->set('resize', explode(',',$this->resize));			
		}
	}

	private function set_form_utilities () {
		$this->set('fh', Loader::helper('form'));
		$this->set('colorh', Loader::helper('form/color'));
		$this->set('ah', Loader::helper('concrete/interface'));
		Loader::model('file_attributes');
		$this->set('fileAttributes', FileAttributeKey::getList()); 

		$html = Loader::helper('html');
		$this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));
	}

	private function get_block_url () {
		$th = Loader::helper('concrete/urls'); 
		return $th->getBlockTypeAssetsURL(BlockType::getByHandle('piecemaker_gallery'));
		
	}
	
	public function get_transitions_options_array () {
		if (isset($this->transitions)) {
			Loader::model('piecemaker_gallery_presets','piecemaker_gallery');
			$transitions = explode(',',$this->transitions);
			foreach ($transitions as $t) {
				$temp[] = ($t == '-1') ? implode(',',PiecemakerGalleryPresets::getDefaultOptionsValues()) : PiecemakerGalleryPresets::getOptionsByID($t);
			}
			return $temp;
		} else {
			return false;
		}

	}
		
	private function set_tools_url () {
		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'piecemaker_gallery'));
		$this->set('get_presets_dialog_tool', $th->getToolsURL('get_dialog_presets', 'piecemaker_gallery'));
		$this->set('get_presets_form_tool', $th->getToolsURL('get_form_presets', 'piecemaker_gallery'));
		$this->set('get_presets_options_tool', $th->getToolsURL('get_options_presets', 'piecemaker_gallery'));
		$this->set('get_images_options_tool', $th->getToolsURL('get_images_options', 'piecemaker_gallery'));
		$this->set('save_presets_tool', $th->getToolsURL('save_preset', 'piecemaker_gallery'));
		$this->set('delete_presets_tool', $th->getToolsURL('delete_preset', 'piecemaker_gallery'));		
	}
	
	function view() {
		$th = Loader::helper('concrete/urls'); 
		$this->set('tex', Loader::helper('textile','piecemaker_gallery'));
		$this->set('helperUrls', Loader::helper('concrete/urls'));
		$this->set('get_block_asset_url',$this->get_block_url());
		$this->set('get_xml_tools_url',$th->getToolsURL('get_xml', 'piecemaker_gallery'));
		$this->set('options',explode(',',$this->options));
		$this->set('resize', explode(',',$this->resize));
	}
	
	function delete(){
	}
	
	public function check_gallery_data_compatible () {
		if (!$this->options) return false; // if the gallery is not up to date with 2.0
		else return true;
	}
	
	public function getGallery() {
		// Check compatibility with Concrete 5.4.1
		if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
			$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
		} else {
			$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
		}
		Loader::model('file');
		Loader::library('file/types');
		$nv = 		Loader::helper('navigation');
		$i = 		Loader::helper('image');
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
				$v[$cc]['link'] = $nv->getLinkToCollection($page);
			}      
			$v[$cc]['desc'] = 	$this->getFileFieldValue($img,'description');
			$v[$cc]['title'] =	$img->getTitle();			
			if ($this->active_resize == 'resize' && $this->width && $this->height) :
				$thb = 			$i->getThumbnail($img,$this->width,$this->height);
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
		return $v;
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
		case "customTitle":
			$value = $this->customTitle;
		break;
		case "customDescription":
			$value = $this->customDescription;
		break;
		default:
			$value = $f->getAttribute($handle);
		break;
	}
	return $value;
}
	function save ($data) {
		
		foreach($data['options'] as $k=>$o) :
			if ($o == "color") {
				$temp[] = str_ireplace('#','',$data['options_'.$k]);
			} else {
				$temp[] = $o;
			}
		endforeach;
		$data['options'] = implode(',',$temp);
		$data['linkPageID'] = 	is_array($data['linkPageID']) ? implode(',',$data['linkPageID']) : $data['linkPageID'];
		$data['fileLink'] = 	is_array($data['fileLink']) ? implode(',',$data['fileLink']) : $data['fileLink'];
		$data['transitions'] = implode(',',$data['transitions']);
		$data['active_resize'] = isset($data['active_resize']) ? 'resize' : '';	
		parent::save($data);

	}


}
?>
