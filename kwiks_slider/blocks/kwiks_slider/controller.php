<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

class KwiksSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btKwiksSLider';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	protected $btWrapperClass = 'ccm-ui';
	
	
	

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
		
	
	public function getBlockTypeDescription() {
		return t("The most awesome jQuery Image Slider.");
	}
	
	public function getBlockTypeName() {
		return t("Kwiks Slider");
	}
	
	function add () {
		$this->set_form_utilities();
		$this->set('max', 80);
		$this->set('width', 960);
		$this->set('spacing', 5);
		$this->set('event', 'mouseover');
		$this->set('duration', 800);
		$this->set('defaultKwick', 0);
		$this->set('options', array('homogenize_height'));
		$this->set('link', "#");		
	}
	function edit () {
		$this->set_form_utilities();
	}
	
	private function set_form_utilities () {
		$th = Loader::helper('concrete/urls');
		$html = Loader::helper('html');

		Loader::model('stack/list');
		$stm = new StackList();
		$this->set('_stacks', $stm->get());

		$this->set('ah', Loader::helper('concrete/interface'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));

		$this->set('tools_url', $th->getToolsURL('options', 'kwiks_slider'));
		
		Loader::model('file_set');
		Loader::model('file_attributes');
		$this->set('s1', FileSet::getMySets());		

		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'kwiks_slider'));
		$this->set('get_images_options_tool', $th->getToolsURL('get_images_options', 'kwiks_slider'));
		$this->set('get_blocks_list_url', $th->getToolsURL('get_blocks_list', 'kwiks_slider'));

		$this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));
		//$this->addHeaderItem($html->javascript($this->get_block_url() . '/form.js'));

		$this->set('options', explode(',',$this->options));
		
		$this->set('c', Page::getCurrentPage());
		
		

		
	}
	
	public function on_page_view() {
		if ($this->content_type == 'stacks' && is_array($blocks = $this->getBlocksFromStackID($this->stID))) :
			foreach($blocks as $b) {
				$bp = new Permissions($b);
				if ($bp->canRead()) {
					$btc = $b->getInstance();
					if('Controller' != get_class($btc)){
						$btc->outputAutoHeaderItems();
					}
					$btc->runTask('on_page_view', array($view));
				}
			}						
		endif ;

	}
	
	
	function view() {
		$c = Page::getCurrentPage();

		$this->set('options', explode(',',$this->options));
		$this->set('c', $c);

		if ($c->isEditMode()) return;
		
		$percent = ($this->width * $this->max) / 100;
		
		if ($this->content_type == 'stacks' ) {
			$c = Page::getCurrentPage();
			$cp = new Permissions($c);
			if ($cp->canReadVersions()) {
				$blocks =  $this->getBlocksFromStackID($this->stID);
			} else {
				$blocks =  $this->getBlocksFromStackID($this->stID, 'ACTIVE' );
			}
			$this->set('blocks',$blocks);
			$this->set('elementWidth', ($this->width - ( (count($blocks) -1 ) * $this->spacing ) ) / count($blocks) );
			
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
	
			
//			$nb_images = count($data);
//			$close = 100 - $this->max;
//			$percent_close = ($this->width * $close) / 100;
//			var_dump($percent_close);
//			$real_width = $percent - ($percent_close * ( $nb_images - 1 ) );
			// 
			$linkPageID = explode(',',$this->linkPageID);
			$fileLink = explode(',',$this->fileLink);
			$linkType = explode(',',$this->linkType);
			$linkAdress = explode('|||',$this->linkAdress);
			
			foreach ($data as $d){
				$file = File::getByID($d['fID']);
				$img = $i->getThumbnail($file,$percent,10000); // Seul la largeur nous importe
					
				if ($linkPageID[array_search($d['fID'],$fileLink)] && $linkType[array_search($d['fID'],$fileLink)] == 'page' ){ // Si il y a un ID de page pour ce fichier et que le type de lien demandŽ est 'page'
					$page = Page::getByID($linkPageID[array_search($d['fID'],$fileLink)]);
					$v[$cc]['link'] = $nv->getLinkToCollection($page);
				} elseif ($linkAdress[array_search($d['fID'],$fileLink)] && $linkType[array_search($d['fID'],$fileLink)] == 'url' ){ // Si il y a une URL pour ce fichier et que le type de lien demandŽ est 'url'
					$v[$cc]['link'] = $linkAdress[array_search($d['fID'],$fileLink)];
				}
				
				$v[$cc]['alt'] =	$file->getTitle();			
				$v[$cc]['width'] = 	$img->width ;
				$v[$cc]['height'] = 	$img->height ;
				$v[$cc]['src'] = 	$img->src;
				$cc ++;
			}
			$this->set('kwicks_pics',$v);	
			$this->set('elementWidth', ($this->width - ( (count($data) -1 ) * $this->spacing ) ) / count($data) );
		}
		$this->set('percent', $percent);
		
		$this->render('view_' . $this->content_type );
	
	}
	
	function delete(){
	}

	function getBlocksFromStackID ($stID, $cvID = 'RECENT') {
		$stack = Stack::getByID($stID, $cvID);
		$p = new Permissions($stack);
		if ($p->canRead()) {
			$blocks = $stack->getBlocks();
			foreach($blocks as $b) {
				$bp = new Permissions($b);
				if ($bp->canRead()) {
					$btc[] = $b;//->getInstance();
					
				}
			}
			return $btc;
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
		$data['max'] 		= 	(is_numeric($data['max']) && $data['max'] >= 0) ? $data['max'] : $this->max_default;
		$data['min'] 		= 	(is_numeric($data['min']) && $data['min'] >= 0) ? $data['min'] : $this->min_default;
		$data['duration'] 	= 	(is_numeric($data['duration']) && $data['duration'] >= 0) ? $data['duration'] : $this->duration_default;
		$data['spacing'] 	= 	(is_numeric($data['spacing']) ) ? $data['spacing'] : $this->spacing_default;
		$data['defaultKwick'] 	= 	(is_numeric($data['defaultKwick']) ) ? $data['defaultKwick'] : $this->defaultKwick_default;
		if ($data['max'] > 100) $data['max'] = 100;

		if (is_array($data['options']))
			$data['options'] 	= 	implode(',',$data['options']);

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
			
		} elseif ($data['content_type'] == 'stacks') {
			
		}
		parent::save($data);

	}
	function get_block_url() {
		$th = Loader::helper('concrete/urls'); 
		return $th->getBlockTypeAssetsURL(BlockType::getByHandle('kwiks_slider'));

	}


}
?>
