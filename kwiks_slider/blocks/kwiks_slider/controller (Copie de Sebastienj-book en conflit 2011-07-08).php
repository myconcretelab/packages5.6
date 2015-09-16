<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class KwiksSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btKwiksSLider';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	
	

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
		
	public function on_page_view() {
		
	}
	
	public function getBlockTypeDescription() {
		return t("The most awesome jQuery Image Slider.");
	}
	
	public function getBlockTypeName() {
		return t("Kwiks Slider");
	}
	public function getJavaScriptStrings() {
	return array(
		'fsID-required' => t('You must enter a fileset.'),
	);
	}
	
	function add () {
		$this->set_form_utilities();
		$this->set('max', 400);
		$this->set('min', 10);
		$this->set('spacing', 2);
		$this->set('event', 'mouseover');
		$this->set('duration', 800);
		$this->set('defaultKwick', 0);
		$this->set('minmax', 'min');
		$this->set('link', "#");		
	}
	function edit () {
		$this->set_form_utilities();
	}
	
	private function set_form_utilities () {
		$url = Loader::helper('concrete/urls');
		$html = Loader::helper('html');
		$scrapbookHelper = Loader::helper('concrete/scrapbook');
		$th = Loader::helper('concrete/urls'); 

		$this->set('ah', Loader::helper('concrete/interface'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));

		$th = Loader::helper('concrete/urls'); 
		$this->set('tools_url', $th->getToolsURL('options', 'kwiks_slider'));
		
		Loader::model('file_set');
		Loader::model('file_attributes');
		$this->set('s1', FileSet::getMySets());		

		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'kwiks_slider'));
		$this->set('get_images_options_tool', $th->getToolsURL('get_images_options', 'kwiks_slider'));
		$this->set('get_blocks_list_url', $th->getToolsURL('get_blocks_list', 'kwiks_slider'));
		$this->set('scrapbookHelper', $scrapbookHelper);
		$this->set('availableScrapbooks',$scrapbookHelper->getAvailableScrapbooks());				

		$this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));
		$this->addHeaderItem($html->javascript($this->get_block_url() . '/engage.itoggle-min.js'));

		
	}
	function view() {
		if ($this->content_type == 'scrapbook' ) {
			$scrapbookHelper=Loader::helper('concrete/scrapbook');
			$html = Loader::helper('html');
			
			$gsp = $scrapbookHelper->getGlobalScrapbookPage();
			$this->set('kwiks_blocks', $gsp->getBlocks($this->scrapbook));		
		} else {
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
			$pla = explode(',',$this->linkPageID);
			$pli = explode(',',$this->fileLink);
			
			foreach ($data as $d){
				$img = File::getByID($d['fID']);
				$s = @getimagesize($img->getPath());
				$fv = $img->getExtension();
				Loader::library('file/types');
				$ft = FileTypeList::getType($fv);
				if ($ft->type == 1) {
					var_dump($this->linkPageID[array_search($d['fID'],$this->fileLink)]);


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
				      $v[$cc]['alt'] =	$img->getTitle();			
				      $v[$cc]['width'] = 	$s[0] ;
				      $v[$cc]['height'] = 	$s[1] ;
				      $v[$cc]['src'] = 	$i->getThumbnail($img,$s[0],$s[1])->src;
				      $cc ++;
				}
			}
			$this->set('kwiks_pics',$v);	
		}
	
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
		$data['max'] 		= 	(is_numeric($data['max']) && $data['max'] >= 0) ? $data['max'] : $this->max_default;
		$data['min'] 		= 	(is_numeric($data['min']) && $data['min'] >= 0) ? $data['min'] : $this->min_default;
		$data['duration'] 	= 	(is_numeric($data['duration']) && $data['duration'] >= 0) ? $data['duration'] : $this->duration_default;
		$data['spacing'] 	= 	(is_numeric($data['spacing']) ) ? $data['spacing'] : $this->spacing_default;
		$data['defaultKwick'] 	= 	(is_numeric($data['defaultKwick']) ) ? $data['defaultKwick'] : $this->defaultKwick_default;

		if ($data['content_type'] == 'fileset') {
			if (is_array($data['fileLink'])) {
				foreach($data['fileLink'] as $fID) :
					$link_type[] = $data['link_type_' . $fID];
					$linkPageID[] = $data['linkPageID_' . $fID];
				endforeach;
				$data['linkType'] = implode(',',$link_type);
				$data['fileLink'] = implode(',', $data['fileLink']);
				$data['linkAdress'] = implode('|||', $data['linkAdress']);
				$data['linkPageID'] = implode(',', $linkPageID);
			}
			
		} elseif ($data['content_type'] == 'scrapbook') {
			
		}
		parent::save($data);

	}
	function get_block_url() {
		// Ne fonctionne pas en add..?
/*		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());		
		return $bv->getBlockURL();
*/
		$th = Loader::helper('concrete/urls'); 
		return $th->getBlockTypeAssetsURL(BlockType::getByHandle('kwiks_slider'));

	}


}
?>
