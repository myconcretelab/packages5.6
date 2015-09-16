<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodePopover extends CapsuleCodeHelper {

	public $samplecontent = 'Popover content';
	public $placement = 'top';
	public $trigger = 'hover';
	public $popovers_title = 'popovers title';
	public $popovers_content = 'popovers content';
	public $tag = 'a';


	function get_capscode () {

		return t('[popover
					tag = "-s:|a|span|strong|i|em #choose wich tag you want to wrap the text#"
					placement="-s:|top|bottom|left|right #how to position the popovers#"
					trigger = "-s:|click|hover|focus|manual"
					popovers_content = "-t #The text#"
					popovers_title = "-t #The title present in the popovers#"
					][/popover]');

	}
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Popover content'),
							'popovers_title' => t('popovers title'),
							'popovers_content' => t('popovers content'),
							);
		
		return $default[$option];

	}	
	function build_html () {
	
		$output = '<' . $this->tag . ($this->tag == 'a' ? ' href="#"' : '') . ' rel="popover"';
		$output .= ' data-trigger="' . $this->trigger . '"';
		$output .= ' data-placement="' . $this->placement . '"' ;
		$output .= ' data-content="' . $this->popovers_content . '"';
		$output .= ' data-original-title="' . $this->popovers_title . '">';
		$output .= $this->content ;
		$output .= '</' . $this->tag . '>';

		return $output;
		
	}
}
