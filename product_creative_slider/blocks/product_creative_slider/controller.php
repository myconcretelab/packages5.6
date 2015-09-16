<?php  defined('C5_EXECUTE') or die("Access Denied.");

class ProductCreativeSliderBlockController extends BlockController {
	
	protected $btName = 'Product Creative Slider';
	protected $btDescription = '';
	
	protected $btTable = 'btProductCreativeSlider';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "600";
	

	public function getBlockTypeDescription() {
		return t("Show creative slider from products picked");
	}
	
	public function getBlockTypeName() {
		return t("Creative Product slider");
	}	
	
	function on_start () {
		$js = Loader::helper('json');
		Loader::model('cc_creative_slider','product_creative_slider');
		$this->mSlider = new CcCreativeSlider();
		$this->mSlides = new CcCreativeSlides();
		if ($this->specs) :
			$this->specs = $js->decode($this->specs);
			$this->specs->options = explode(',',$this->specs->options);
		endif;
	}	
	
	public function add() {
		$this->addEdit();
		$specs = new stdClass ();
		$specs->speed = 500;
		$specs->pause = 5000;
		$specs->controlsSize = 10;
		$specs->pagerPosition = 'under_slider';
		$specs->pagerColor = '#ffffff';
		$specs->pagerColorActive = '#ffffff';
		$specs->controlsColor = '#373D42';
		$specs->controlsSignColor = '#f6f7f8';
		//$specs->
		$this->set('specs', $specs);
	}
	public function edit () {
		$this->addEdit();
		$this->set('specs', $this->specs);		
	}

	public function addEdit () {
		$this->set('slider_list', $this->mSlider->get_slider_list());

	}

	public function getJavaScriptStrings() {
		return array(
			'csID-required' => t('You must select a existing slider')
		);
	}
	protected function view () {

		Loader::model('product/model', 'core_commerce');
		$slider =  $this->mSlider->getByID($this->specs->csID);
		$this->set('slider', $slider);
		$this->set('slides', $slider->slides);
		// $this->slide->richContent = $this->translateFrom($this->specs->richContent);
		$this->set('specs', $this->specs);	

		$this->set('ih',Loader::helper('image'));
	}	

	function save ($data) {
		$js = Loader::helper('json');
		// Les options
		if(!is_array($data['options'])) :
			$data['options'] = '';
		else :
			$data['options'] = implode(',', $data['options']);
		endif;

		// Retirer les infos non necessaires au specifications
		unset($data['ccm-block-form-method'], $data['ccm-string-attributeHandle-required'], $data['ccm-string-product-required'], $data['processBlock'], $data['update'],$data['ccm-edit-block-submit'] );
		// On ne garde que la variable 'specs' qui sera sauvée ds la db
		$save['specs'] = $js->encode($data);
		parent::save($save);
	}


	private function set_block_tool($tool_name) {
		$tool_helper = Loader::helper('concrete/urls');
		$bt = BlockType::getByHandle($this->btHandle);
		$this->set ($tool_name, $tool_helper->getBlockTypeToolsURL($bt).'/'.$tool_name);
	}

	function translateFrom($text) {
		// old stuff. Can remove in a later version.
		$text = str_replace('href="{[CCM:BASE_URL]}', 'href="' . BASE_URL . DIR_REL, $text);
		$text = str_replace('src="{[CCM:REL_DIR_FILES_UPLOADED]}', 'src="' . BASE_URL . REL_DIR_FILES_UPLOADED, $text);

		// we have the second one below with the backslash due to a screwup in the
		// 5.1 release. Can remove in a later version.

		$text = preg_replace(
			array(
				'/{\[CCM:BASE_URL\]}/i',
				'/{CCM:BASE_URL}/i'),
			array(
				BASE_URL . DIR_REL,
				BASE_URL . DIR_REL)
			, $text);

		// now we add in support for the links

		$text = preg_replace_callback(
			'/{CCM:CID_([0-9]+)}/i',
			array('ProductCreativeSliderBlockController', 'replaceCollectionID'),
			$text);

		$text = preg_replace_callback(
			'/<img [^>]*src\s*=\s*"{CCM:FID_([0-9]+)}"[^>]*>/i',
			array('ProductCreativeSliderBlockController', 'replaceImageID'),
			$text);

		// now we add in support for the files that we view inline
		$text = preg_replace_callback(
			'/{CCM:FID_([0-9]+)}/i',
			array('ProductCreativeSliderBlockController', 'replaceFileID'),
			$text);

		// now files we download

		$text = preg_replace_callback(
			'/{CCM:FID_DL_([0-9]+)}/i',
			array('ProductCreativeSliderBlockController', 'replaceDownloadFileID'),
			$text);

		return $text;
	}

	private function replaceFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$path = File::getRelativePathFromID($fID);
			return $path;
		}
	}

	private function replaceImageID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			preg_match('/width\s*="([0-9]+)"/',$match[0],$matchWidth);
			preg_match('/height\s*="([0-9]+)"/',$match[0],$matchHeight);
			$file = File::getByID($fID);
			if (is_object($file) && (!$file->isError())) {
				$imgHelper = Loader::helper('image');
				$maxWidth = ($matchWidth[1]) ? $matchWidth[1] : $file->getAttribute('width');
				$maxHeight = ($matchHeight[1]) ? $matchHeight[1] : $file->getAttribute('height');
				if ($file->getAttribute('width') > $maxWidth || $file->getAttribute('height') > $maxHeight) {
					$thumb = $imgHelper->getThumbnail($file, $maxWidth, $maxHeight);
					return preg_replace('/{CCM:FID_([0-9]+)}/i', $thumb->src, $match[0]);
				}
			}
			return $match[0];
		}
	}

	private function replaceDownloadFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$c = Page::getCurrentPage();
			if (is_object($c)) {
				return View::url('/download_file', 'view', $fID, $c->getCollectionID());
			} else {
				return View::url('/download_file', 'view', $fID);
			}
		}
	}

	private function replaceDownloadFileIDInEditMode($match) {
		$fID = $match[1];
		if ($fID > 0) {
			return View::url('/download_file', 'view', $fID);
		}
	}

	private function replaceFileIDInEditMode($match) {
		$fID = $match[1];
		return View::url('/download_file', 'view_inline', $fID);
	}

	private function replaceCollectionID($match) {
		$cID = $match[1];
		if ($cID > 0) {
			$c = Page::getByID($cID, 'APPROVED');
			return Loader::helper("navigation")->getLinkToCollection($c);
		}
	}
}
