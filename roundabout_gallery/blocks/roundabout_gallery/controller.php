<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

class RoundaboutGalleryBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btRoundaboutGallery';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "500";
	protected $btWrapperClass = 'ccm-ui';
	
	public $width_default	= 450;
	public $height_default	= 300;
	
	public $shapes = array('lazySusan', 'waterWheel', 'figure8', 'square', 'conveyorBeltLeft', 'conveyorBeltRight', 'diagonalRingLeft', 'diagonalRingRight', 'rollerCoaster', 'tearDrop', 'theJuggler', 'goodbyeCruelWorld');
	public $easing_array = array ('swing', 'easeInOutExpo','easeOutBounce', 'easeOutElastic', 'easeOutBack' );
	
	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
			
	public function getBlockTypeDescription() {
		return t("Display a turntable-like interactive Gallery. Compatible with C5 Sortable Gallery package.");
	}
	
	public function getBlockTypeName() {
		return t("Roundabout Gallery");
	}
	public function getJavaScriptStrings() {
		return array(
			'fsID-required' => t('You must enter a fileset.'),
		);
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
	
	function form_utilities() {
		$url = Loader::helper('concrete/urls');
		$html = Loader::helper('html');

		Loader::model('stack/list');
		$stm = new StackList();
		$this->set('_stacks', $stm->get());
		
		Loader::model('file_set');
		Loader::model('file_attributes');

		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('af', Loader::helper('form/attribute'));
		$this->set('fileAttributes', FileAttributeKey::getList()); 
		$this->set('s1', FileSet::getMySets());
		$this->set('form', Loader::helper('form'));
		$this->set('c', Page::getCurrentPage());
		$html = Loader::helper('html');

		$this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));
		$this->addHeaderItem($html->javascript($this->get_block_url() . '/engage.itoggle-min.js'));

		$this->set('get_filesets_url', $url->getToolsURL('get_fileset_select_options', 'roundabout_gallery'));
		$this->set('get_images_options_tool', $url->getToolsURL('get_images_options', 'roundabout_gallery'));

		$this->set('get_blocks_list_url', $url->getToolsURL('get_blocks_list', 'roundabout_gallery'));
	}

	function add() {
		$this->set('shape', 'lazySusan'); // waterWheel, figure8, square, conveyorBeltLeft, conveyorBeltRight, diagonalRingLeft, diagonalRingRight, rollerCoaster, tearDrop, theJuggler, goodbyeCruelWorld
		$this->set('width', 600);
		$this->set('height', 300);
		$this->set('duration', 1200);
		$this->set('minOpacity', .4);
		$this->set('maxOpacity', 1);
		$this->set('minScale', .3);
		$this->set('maxScale', 1);
		$this->set('bearing', 0);
		$this->set('tilt', 0);
		$this->set('minZ', 100);
		$this->set('maxZ', 100);
		$this->set('maxW', 80);

		$this->set('options', array());
		$this->set('link', "#");
		$this->form_utilities();
		
	}

	function edit() {
		$this->form_utilities();
		// If upgraded but not edited..
		//if (!$this->maxW) $this->add();
	}

	function get_block_url() {
		// Ne fonctionne pas en add..?
/*		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());		
		return $bv->getBlockURL();
*/
		$th = Loader::helper('concrete/urls'); 
		return $th->getBlockTypeAssetsURL(BlockType::getByHandle('roundabout_gallery'));

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

		//$this->set('options', explode(',',$this->options));
		$this->set('c', $c);

		if ($c->isEditMode()) return;
				
		if ($this->content_type == 'stacks' ) {
			$cp = new Permissions($c);

			if ($cp->canReadVersions()) {
				$blocks =  $this->getBlocksFromStackID($this->stID);
			} else {
				$blocks =  $this->getBlocksFromStackID($this->stID, 'ACTIVE' );
			}

			$this->set('blocks',$blocks);

		} else {
			// Check compatibility with Concrete 5.4.1
			if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			} else {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
			}
			if (!is_array($data)) return false;
			Loader::model('file');
			$nv = Loader::helper('navigation');
			$i = Loader::helper('mylab_image', 'roundabout_gallery');
			
			$v = array();
			$cc = 0;
			if ($this->link == 'multipages') {
				$pla = explode(',',$this->linkPageID);
				$pli = explode(',',$this->fileLink);
			}
			
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
	
			  $fv = $img->getExtension();
			  Loader::library('file/types');
			  $ft = FileTypeList::getType($fv);
			  
			  if ($ft->type == 1) {
				$image = $i->getThumbnail($img, $this->width, $this->height, array('crop' => true));

				// Ajouter la gestion des liens !!
				if( (bool) $this->link) {
					
					$v[$cc]['isLink'] = true; 

				}
				$v[$cc]['desc'] = 	$this->fsDescription != 'none' ? $this->getFileFieldValue($img,$this->fsDescription) : NULL;
				$v[$cc]['title'] =	$this->fsTitle != 'none' ? $this->getFileFieldValue($img,$this->fsTitle) : NULL;
				$v[$cc]['width'] = 	$image->width;
				$v[$cc]['height'] = 	$image->height;
				$v[$cc]['src'] = 	$image->src;
				$cc ++;
			  }
			}
			$this->set('rg' , $v);
		}
		$this->render('view_' . $this->content_type );
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
		$data['width'] = 	(is_numeric($data['width']) && $data['width'] >= 0) ? $data['width'] : 600;
		$data['height'] = 	(is_numeric($data['height']) && $data['height'] >= 0) ? $data['height'] : 300;
		
		if ($data['content_type'] == 'fileset') {
			if (is_array($data['fileLink'])) {
				foreach($data['fileLink'] as $fID) :
					$link_type[] = $data['link_type_' . $fID];
				endforeach;
				$data['linkType'] = implode(',',$link_type);
				$data['fileLink'] = implode(',', $data['fileLink']);
				$data['linkAdress'] = implode('|||', $data['linkAdress']);
				$data['linkPageID'] = implode(',', $data['linkPageID']);
			}
			
		} elseif ($data['content_type'] == 'scrapbook') {
			
		}
		parent::save($data);

	}


}
?>
