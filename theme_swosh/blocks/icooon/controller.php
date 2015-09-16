<?php  
defined('C5_EXECUTE') or die("Access Denied.");

class IcooonBlockController extends BlockController {
	
	protected $btName = 'Icooon';
	protected $btDescription = '';
	protected $btTable = 'btIcooon';
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;
	protected $btCacheBlockOutputLifetime = 300;
	

	public function on_page_view () {
		
		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$blockURL = $bv->getBlockURL();
		$html = Loader::helper('html');            
		$this->addHeaderItem(  $html->css($blockURL . '/font-awesome.min.css'));		
		/* Font-awesome 4.0 doesn't support IE7 */
		//$this->addHeaderItem('<!--[if IE 7]><link rel=\'stylesheet\' href=\'' . $blockURL . '/css/font-awesome-ie7.min.css\'><![endif]-->');
		
	}
	public function add () {
		$this->set('form', Loader::helper('form'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('fc', Loader::helper('form/color'));
		$this->set('mainColor', '#585f63');
		$this->set('secondColor', '#ffffff');
		$this->set('iconName', '');

	}

	public function edit () {
		$this->set('form', Loader::helper('form'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('fc', Loader::helper('form/color'));
	}



	public function getJavaScriptStrings() {
		return array(
			'icon-required' => t('You must pick a icon.'),
			'title-required' => t('You must write a beautiful title.')
		);
	}

	public function view () {
		switch ($this->iconSize) {
			case 'l':
				$s = 'fa-lg"';
				break;
			case 'xl':
				$s = 'fa-2x';
				break;
			case 'xxl':
				$s = 'fa-3x';
				break;
			case 'h':
				$s = 'fa-4x';
				break;
			case 'xh':
				$s = 'fa-5x';
				break;
			default:
				$s ='';
				break;
		}
		
		if ($this->Linkurl) :
			$this->set('linkTo',$this->Linkurl);
		elseif ($this->pageLinkID) :
			$p = Page::getByID($this->pageLinkID);
			$nh = Loader::helper('navigation');
			$this->set('linkTo',$nh->getCollectionURL($p));
		endif;

		$this->set('mainColor', $this->mainColor ? $this->mainColor : '#585f63');
		$this->set('secondColor', $this->secondColor ? $this->secondColor : '#ffffff');

		$this->set('size',$s);
	}

	function save ($data) {
		$data['titleText'] = htmlentities($data['titleText']);
		$data['contentText'] = htmlentities($data['contentText']);
		parent::save($data);
	}

}
