<?php  defined('C5_EXECUTE') or die("Access Denied.");

class SwoshSliderBlockController extends BlockController {
	
	protected $btName = 'Swosh Slider';
	protected $btDescription = '';
	protected $btTable = 'btSwoshSlider';
	
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "300";
	protected $btWrapperClass = 'ccm-ui';	
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;

	public $file_attr  = array('title' => 'The title',
								'description' => 'The description',
								'date' => 'The date',
								'filename' => 'The title',

	  );


	function add () {
		$this->set_helpers();
		$this->set('title', 'title');
		$this->set('description', 'description');
		$this->set('autoplay', 0);
		$this->set('slideshow_interval', 5000);
	}
		
	function edit() {
		$this->set_helpers();
		// Check for upgrade
		if(!isset($this->slideshow_interval)) $this->set('slideshow_interval', 5000);
		if(!isset($this->autoplay)) $this->set('autoplay', 0);
	}

	
	private function set_helpers() {
		Loader::model('file_attributes');
		$this->set('fileAttributes', FileAttributeKey::getList());
	}

	public function on_page_view () {
		$html = Loader::helper('html');
		$th = Loader::helper('concrete/urls');
		$bturl = $th->getBlockTypeAssetsURL(BlockType::getByHandle('swosh_slider'));
		$this->addHeaderItem($html->javascript($bturl . '/javascript/jquery.easing.1.3.js'));
		$this->addHeaderItem($html->javascript($bturl . '/javascript/jquery.swoshslider.js'));

	}


	public function view () {
		Loader::model('file_list');
		Loader::model("file_set");
		$ih = Loader::helper('image');
		if ($this->fsID) {
			$fs = FileSet::getByID($this->fsID);
			$fl = new FileList();
			$fl->filterBySet($fs);
			$fl->sortByFileSetDisplayOrder($gs);
			$files = $fl->get();

			$this->set('files', $files);
			$this->set('ih', $ih);
			if(!isset($this->slideshow_interval)) $this->set('slideshow_interval', 5000);
			if(!isset($this->autoplay)) $this->set('autoplay', 0);
		}
	}
	public function getFileFieldValue($f,$handle) {
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
			case "none":
				$value = false;
			break;
			default:
				$value = $f->getAttribute($handle);
			break;
		}
		return $value;
	}
	public function save ($data) {
		if (!is_numeric( intval($data['slideshow_interval']))) $data['slideshow_interval'] = 5000; else $data['slideshow_interval'] = intval($data['slideshow_interval']);
		//if ($data['autoplay'] != 1 && $data['autoplay'] != 0 ) $data['autoplay'] = 1;
		parent::save($data);
	}

}
