<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabSpacerBlockController extends BlockController {
	protected $btTable = 'btMylabSpacer';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "300"; 

	public function getBlockTypeDescription() {
		return t("Add spacers to your webpage without editing code.");
	}
		
	public function getBlockTypeName() {
		return t("Super Mint spacer");
	}
	
	public function add () {
		$this->edit_tools();
		$this->set('image','none'); 
	}

	public function edit () {
		$this->edit_tools();
	}

	public function edit_tools () {
        $fh = Loader::helper('theme_file', 'theme_super_mint');
        $th = Loader::helper('concrete/urls');
        $bt = BlockType::getByHandle('mylab_spacer');
        $path = $bt->getBlockTypePath();
        $images = $fh->file_dir($path . '/' . DIRNAME_IMAGES . '/');
        $this->set('images', $images);
	}

	public function view () {
		if ($this->image) :
			$th = Loader::helper('concrete/urls');
			$bt = BlockType::getByHandle('mylab_spacer');
			$burl = $th->getBlockTypeAssetsURL($bt);
			$this->set('iurl', $burl . '/' . DIRNAME_IMAGES . '/' . $this->image  . '.png');
			if (stripos($this->image, 'shadow',0)):
				$this->set('top',true);
			endif;
		endif;
	}

	function save($data) { 
		$args['spacerHeight'] = isset($data['spacerHeight']) ? str_replace(' ', '', $data['spacerHeight']) : '0';
		$args['image'] = $data['image'];
		parent::save($args);
	}		
	
}