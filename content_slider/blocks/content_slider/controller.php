<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class ContentSliderBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btContentSlider';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "300";
	
	
	public $availableTypes = array('fade', 'blockfade','blockfadein','blockshrink','blockgrow','blockdrop','blockdropin','blockflyout','blockrandom','blockrandomin','rowfade','rowheightin','rowthin','rowgrowin','rowslideleft','rowslideright','rowrandom','rowrandomin','columnfade','columnthin','columndropin','columndrop','columnflyin','columnflyout','columnrandom','columnrandomin','top','bottom','left','right');
	
	
	public function getBlockTypeDescription() {
		return t("Create sliders based on a C5 Stack");
	}
	
	public function getBlockTypeName() {
		return t("Content Slider");
	}

	function add() {
		$this->set('delay',5000);
		$this->set('width',650);
		$this->set('height',250);
		$this->set('type',array('fade'));
		$this->set_form_utilities();
	}

	function edit() {
		$this->set_form_utilities();
		$type = explode(',', $this->type);
		// Detect if 'all' have been selected
		if (count($this->availableTypes) == count($type))
			$this->set('type',array('all'));
		else
			$this->set('type',$type);
			
	}
	
	private function set_form_utilities () {
		$th = Loader::helper('concrete/urls'); 

		Loader::model('stack/list');
		$stm = new StackList();
		$this->set('stacks', $stm->get());


		$this->set('get_blocks_list_url', $th->getToolsURL('get_blocks_list', 'content_slider'));
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('content_slider')));

		$this->set('form', Loader::helper('form'));
		$this->set('ah', Loader::helper('concrete/interface'));

	}
	public function on_page_view() {
		$html = Loader::helper('html');
		$th = Loader::helper('concrete/urls');

		$javascript = $th->getToolsURL('get_javascript', 'content_slider');
		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$page = Page::getCurrentPage();

		$this->addHeaderItem('<!--[if IE 6]><script src="'.$bv->getBlockURL() . '/global_javascript/jquery.pngFix.pack.js"></script><script type="text/javascript">$(document).pngFix();</script><![endif]-->' );
		$this->addHeaderItem($html->javascript($javascript . '?cID=' . $page->cID . "&bID=" . $this->bID ));

		if (is_array($blocks = $this->getBlocksFromStackID($this->stID))) :
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

	function view(){ 

		$c = Page::getCurrentPage();
		$cp = new Permissions($c);
		if ($cp->canReadVersions()) {
			$this->set('blocks', $this->getBlocksFromStackID($this->stID) );
		} else {
			$this->set('blocks', $this->getBlocksFromStackID($this->stID), 'ACTIVE' );
		}		

		$this->set('blockTitle', explode('0o0',$this->blockTitle));
		$this->set('blockDescription', explode('0o0',$this->blockDescription));
		
		$files = explode(',',$this->files);

		Loader::model('file');
		Loader::library('file/types');
		$i = Loader::helper('image');

		foreach ($files as $k=>$fID) :
			$img = File::getByID($fID);
			$s = @getimagesize($img->getPath());
			$fv = $img->getExtension();
			$ft = FileTypeList::getType($fv);
			if ($ft->type == 1) :
				$thumbs[$k] = $i->getThumbnail($img,80,80)->src;
			endif;
		endforeach;

		if (is_array($thumbs)) $this->set('thumbs', $thumbs);
	}

	function save($data) {

		foreach($data['blockTitle'] as $k=>$ot) :
			$files[] = $data['file_'.$k];
		endforeach;

		$temp = array();

		foreach($data['type'] as $type) :
			if (!in_array($type,$temp)) $temp[] = $type;  
			if ($type == 'all') {
				$temp = $this->availableTypes;
				break;
			}
		endforeach;

		$data['type'] = implode(',',$temp);
		
		$data['blockDescription'] = implode('0o0',$data['blockDescription']);
		$data['blockTitle'] = implode('0o0',$data['blockTitle']);
		$data['files'] = implode(',',$files);

		parent::save($data);
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
	
	public static function php2js ($var) {
	    if (is_array($var)) {
		$res = "[";
		$array = array();
		foreach ($var as $a_var) {
		    $array[] = ContentSliderBlockController::php2js($a_var);
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

	
}

?>