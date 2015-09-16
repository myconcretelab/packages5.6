<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeAlert  extends CapsuleCodeHelper {
	
	public $samplecontent = 'Alert text';
	public $connotation = "default";
	public $size = "default";

	function get_capscode () {
		return t('[alert 
						connotation="-s:|default|success|error|information #Choose the apparence to change an alert\'s connotation#"
						size = "-s:|default|large #For longer messages choose large#"
						]
						[/alert]');
	}

	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Alert text'));
		return $default[$option];

	}	

	function build_html () {
		$class = '';

		if ($this->connotation != 'default')
			$class .= ' alert-' . $this->connotation;
		if ($this->size != 'default')
			$class .= ' alert-block';
		
		$output = '<div class="alert ' . $class . '">';
		$output .= '<button type="button" class="close" data-dismiss="alert">×</button>';
		$output .= $this->content;
		$output .= '</div>';
		
		return '<div class="'.$this->code.'_container' . $alignment . '">' . $output . '</div>';

	}
}