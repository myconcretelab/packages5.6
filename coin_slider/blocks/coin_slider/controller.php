<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class CoinSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btCoinSLider';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	public $effect_default		= 'random';
	public $spw_default		= 7;
	public $sph_default		= 5;
	public $delay_default		= 3000;
	public $sDelay_default		= 30;
	public $opacity_default		= 0.7;
	public $titleSpeed_default	= 500;
	public $navigation_default	= true;
	public $links_default		= true;
	public $hoverPause_default	= true;
	

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
		
	public function on_page_view() {
		
	}
	
	public function getBlockTypeDescription() {
		return t("The image slider with unique effects");
	}
	
	public function getBlockTypeName() {
		return t("Coin Slider");
	}
	public function getJavaScriptStrings() {
	return array(
		'fsID-required' => t('You must enter a fileset.'),
	);
	}
	
	function view() {
		
	}
	
	function delete(){
	}
	
	public function getGallery() {
		if($this->bID) {
			// Check compatibility with Concrete 5.4.1
			if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			} else {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
			}
			if (!is_array($data)) return false;
			Loader::model('file');
			$nv = Loader::helper('navigation');
			$i = Loader::helper('image');
			
			$v = array();
			$cc = 0;
			if ($this->link == 'multipages') {
				$pla = explode(',',$this->linkPageID);
				$pli = explode(',',$this->fileLink);
			}
			
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
			  $s = @getimagesize($img->getPath());
			  // this test take some time if you want to improve speed, delete from here
			  $fv = $img->getExtension();
			  Loader::library('file/types');
			  $ft = FileTypeList::getType($fv);
			  if ($ft->type == 1) {
			  // to here
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
				$v[$cc]['title'] =	$this->getFileFieldValue($img,$this->fsTitle);
				$v[$cc]['alt'] =	$img->getTitle();			
				$v[$cc]['width'] = 	$s[0] ;
				$v[$cc]['height'] = 	$s[1] ;
				$v[$cc]['src'] = 	$i->getThumbnail($img,$s[0],$s[1])->src;
				$cc ++;
			  }
			}
			return $v;
			
		} else {
			return false;
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
		$data['spw'] = 		(is_numeric($data['spw']) && $data['spw'] > 0 && $data['spw'] < 30) ? $data['spw'] : $this->spw_default;
		$data['sph'] = 		(is_numeric($data['sph']) && $data['sph'] > 0 && $data['sph'] < 30) ? $data['sph'] : $this->sph_default;

		$data['delay'] = 	(is_numeric($data['delay']) && $data['delay'] > 0 ) ? $data['delay'] : $this->delay_default;
		$data['pauseTime'] = 	(is_numeric($data['pauseTime']) && $data['pauseTime'] > 0) ? $data['pauseTime'] : $this->pauseTime_default;
		$data['sDelay'] = 	(is_numeric($data['sDelay']) && $data['sDelay'] > 0) ? $data['sDelay'] : $this->sDelay_default;
		$data['opacity'] = 	(is_numeric($data['opacity']) && $data['opacity'] > 0) ? $data['opacity'] : $this->opacity_default;
		$data['titleSpeed'] = 	(is_numeric($data['titleSpeed']) && $data['titleSpeed'] > 0) ? $data['titleSpeed'] : $this->titleSpeed_default;
		
		$data['linkPageID'] = 	is_array($data['linkPageID']) ? implode(',',$data['linkPageID']) : $data['linkPageID'];
		$data['fileLink'] = 	is_array($data['fileLink']) ? implode(',',$data['fileLink']) : $data['fileLink'];
		//var_dump($data['options']);
		$data['options'] = 	is_array($data['options']) ? implode(',',$data['options']) : $data['options'];
		parent::save($data);

	}


}
?>
