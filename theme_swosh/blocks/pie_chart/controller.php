<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
class PieChartBlockController extends BlockController {
	
	protected $btTable = "btPieChart";
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "500";

	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;
	protected $btCacheBlockOutputLifetime = 300;


	public function getBlockTypeName() {
		return t('Flat Pie Chart');
	}

	public function getBlockTypeDescription() {
		return t('Render simple pie charts for single values. ');
	}

	public function on_page_view () {
		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$blockURL = $bv->getBlockURL();
		$html = Loader::helper('html');            
		$this->addHeaderItem('<!--[if IE 7]><script src=\'' . $blockURL . '/excanvas.js\'></script><![endif]-->');		
	}
	
	public function add () {
		// Default values
		$this->set('value',75);	
		$this->set('text','75%');
		$this->set('fontSize',20);			
		$this->set('barColor','#18aedf');
		$this->set('trackColor','#f2f2f2');
		$this->set('scaleColor','#dfe0e0');
		$this->set('lineCap','butt');
		$this->set('lineWidth',3);
		$this->set('rotate',0);
		$this->set('animate',0);		
		$this->set('size',200);		
		$this->set('track',1);		
		$this->set('scale',1);		

		$this->setHelpers();
		$this->set('foo', '');
	}
	
	public function edit () {
		$this->setHelpers();
	}
	
	private function setHelpers () {
		$this->set('form', Loader::helper('form'));
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$this->set('fc', Loader::helper('form/color'));


	}
	public function view () {

	}
	private function set_block_tool($tool_name){
		$urls = Loader::helper('concrete/urls');
		$bt = BlockType::getByHandle($this->btHandle);
		$this->set ($tool_name, $urls->getBlockTypeToolsURL($bt).'/'.$tool_name);
	}

	public function save($data) {
	 	parent::save($data);

	}

}
