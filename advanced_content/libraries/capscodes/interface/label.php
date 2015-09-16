<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeLabel  extends CapsuleCodeHelper {
	
	public $samplecontent = 'label text';
	public $connotation = "default";
	public $type = "label";

	function get_capscode () {
		return t('[label 
						connotation="-s:|default|info|success|warning|important|inverse| #Choose the apparence to change label\'s connotation#"
						type = "-s:|label|badge #Badges have round corners#"
						]
						[/label]');
	}
	
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Boutton text'));
		return $default[$option];

	}

	function build_html () {
		$class = '';

		if ($this->connotation != 'default')
			$class .= ' label-' . $this->connotation;

			$class .= ' label-' . $this->type;
		
		$output = '<span class="label ' . $class . '">';
		$output .= $this->content;
		$output .= '</span>';
		
		return $output;

	}
}