<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeVimeo extends CapsuleCodeHelper {

	public $width = 640;
	public $height = 390;
	public $id = '50048114';
	public $hiddenOnEditMode = true;
	


	function get_capscode () {

		return t('[vimeo
							id = "-t #Required, the id of the video#"
							][/vimeo]');

	}
	
	function build_html () {
	
		if (!strlen($this->id)) return;

		$output = '<iframe src="http://player.vimeo.com/video/' . $this->id . '" 
					width="WIDTH" 
					height="HEIGHT" 
					frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

		return $output;
		
	}
}
