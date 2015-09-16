<?php 
	defined('C5_EXECUTE') or die("Access Denied.");

	Loader::controller('/concrete/blocks/content');
	
	class AdvancedContentBlockController extends ContentBlockController {

    protected $btTable = 'btAdvancedContent';
    protected $btInterfaceWidth = "600";
    protected $btInterfaceHeight = "500";
    
		
		public function getBlockTypeDescription() {
			return t("Advanced HTML/WYSIWYG Editor Content.");
		}
		
		public function getBlockTypeName() {
			return t("Advanced Content");
		}
		
		function getContent() {
			$content = $this->translateFrom($this->content);
			return $content;				
		}

		private function set_form_utilities () {
			$url = Loader::helper('concrete/urls');
			$this->set('form_url', $url->getToolsURL('get_form','advanced_content'));
			$this->set('block_url', $url->getBlockTypeAssetsURL(BlockType::getByHandle('advanced_content')));			
		}

		function add() {
			$this->set_form_utilities ();
		}
		function edit() {
			$this->set_form_utilities ();
		}
	
	}
	
?>
