<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class DeepitSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btDeepitSlider';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "550";
	
	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}

	public function getBlockTypeName() {
		return t("Deepit Slider");
	}
		
	public function getBlockTypeDescription() {
		return t("The most awesome jQuery Image Slider.");
	}

	public function add() {
		$this->set('animSpeed', 1200);
		$this->set('pauseTime', 2200);
		$this->set('options', array('liquidLayout','arrowsNav','arrowsNavHide','listNav'));
		$this->set('width', 100);
		$this->set('height', 100);		
	}

	public function edit () {
		$this->set('options', explode(',',$this->options));
		if ($this->layer_files && $this->layer_files !='no') :
		       $this->set('layer_files', explode(',',$this->layer_files));
		       $this->set('offsets', explode(',',$this->offsets));
		       $this->set('directions', explode(',',$this->directions));
		endif;
	}
	
	public function getJavaScriptStrings() {
		return array(
			'fsID-required' => t('You must enter a fileset.'),
			'layerFile-required' => t('You must Choose a file for layer')
		);
	}

	public function on_page_view() {
		
	}

	function view() {
		if($this->bID) {
			// Check compatibility with Concrete 5.4.1
			if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			} else {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
			}
			if (!is_array($data)) return false;
			Loader::model('file');
			$nv = 		Loader::helper('navigation');
			$i = 		Loader::helper('image');
			$options = 	explode(',',$this->options);

			
			$v = array();
			$cc = 0;
			if ($this->link == 'multipages') {
				$pla = explode(',',$this->linkPageID);
				$pli = explode(',',$this->fileLink);
			}
			
			
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
			  $s = @getimagesize($img->getPath());
			  $fv = $img->getExtension();
			  Loader::library('file/types');
			  $ft = FileTypeList::getType($fv);
			  if ($ft->type == 1) {
				if( (bool) $this->link) {
					$v[$cc]['isLink'] = true; 
					switch ($this->link) {
						case 'image' :
						      $v[$cc]['link'] = $img->getRelativePath();
						break;
						case 'page' :
							$page = Page::getByID($this->linkPageID);
							$v[$cc]['link'] = $nv->getLinkToCollection($page);
						break;
						case 'multipages':
							$page = Page::getByID($pla[array_search($d['fID'],$pli)]);
							if($page->cID)
								$v[$cc]['link'] = $nv->getLinkToCollection($page);
							else
								$v[$cc]['isLink'] = false;
						break;
				      
				      }
				}
				$v[$cc]['desc'] = 	$this->getFileFieldValue($img,$this->caption);
				$v[$cc]['alt'] =	$img->getTitle();			
				$thumb =		$i->getThumbnail($img,60,60);
				$v[$cc]['thumb'] = 	$thumb->src;				
				if (in_array('resize', $options) && $this->width && $this->height) :
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
			$this->set('gal',$v);
			
		} else {
			$this->set('gal',false);
		}		
		
		$this->set('options', explode(',',$this->options));
		$this->set('hh', 0);
		if ($this->layer_files && $this->layer_files !='no') :
			$this->set('layer_files', explode(',',$this->layer_files));
			$this->set('offsets', explode(',',$this->offsets));
			$this->set('directions', explode(',',$this->directions));
		endif;

		
	}
	
	function delete(){
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
		if (is_array($data['layerID'])) :		
			foreach ($data['layerID'] as $n=>$o) :
				$layer_file[] = $data['layer_'.$o];
				$offset[] = $data['offset_'.$o];
				$direction[] = isset($data['direction_'.$o]) ? 'ltr' : 'rtl';
			endforeach;
			$data['layer_files'] = 	is_array($layer_file ) ? implode(',',$layer_file) : $layer_file ;	
			$data['directions'] = 	is_array($direction) ? implode(',',$direction) : $direction ;	
			$data['offsets'] = 	is_array($offset) ? implode(',',$offset) : $offset;	
		else:
			$data['layer_files'] = 'no';
		endif;
		$data['options'] = 	is_array($data['options']) ? implode(',',$data['options']) : '';		
		//$data['offset'] = 	is_array($data['offset']) ? implode(',',$data['offset']) : $data['offset'];
		$data['linkPageID'] = 	is_array($data['linkPageID']) ? implode(',',$data['linkPageID']) : $data['linkPageID'];
		$data['fileLink'] = 	is_array($data['fileLink']) ? implode(',',$data['fileLink']) : $data['fileLink'];
		//print_r($data);
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
	    // autres cas: objets, on ne les gre pas
	    return FALSE;
	}



}
?>
