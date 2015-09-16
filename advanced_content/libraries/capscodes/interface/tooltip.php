<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeTooltip extends CapsuleCodeHelper {

	public $placement = 'top';
	public $trigger = 'hover';
	public $title = 'title';
	public $tag = 'a';


	function get_capscode () {

		return t('[tooltip
					tag = "-s:|a|span|strong|i|em #choose wich tag you want to wrap the text#"
					placement="-s:|top|bottom|left|right #how to position the tooltip#"
					trigger = "-s:|click|hover|focus|manual"
					title = "-t #The text present in the tooltip#"
					][/tooltip]');

	}
	
	function build_html () {
	
		$output = '<' . $this->tag . ($this->tag == 'a' ? ' href="#"' : '') . ' rel="tooltip"';
		$output .= ' data-trigger="' . $this->trigger . '"';
		$output .= ' data-placement="' . $this->placement . '"' ;
		$output .= ' title="' . $this->title . '">';
		$output .= $this->content;
		$output .= '</' . $this->tag . '>';

		return $output;
		
	}
}
