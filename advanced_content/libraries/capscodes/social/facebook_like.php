<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeFacebookLike extends CapsuleCodeHelper {

	public $width = 450;
	public $height = 80;
	public $id = '50048114';


	function get_capscode () {

		return t('[facebook_like
					width="-n #the width of the button+text#"
					][/facebook_like]');

	}
	
	function build_html () {
	
		if (!strlen($this->id)) return;
		global $c;
		$nh = Loader::helper('navigation');
		$cpl = $nh->getCollectionURL($c);
		
		$output = '<iframe src="https://www.facebook.com/plugins/like.php?href=' . $cpl . '"
					        scrolling="no" 
					        frameborder="0"
					        style="border:none; 
					        width:' . $this->width . 'px; 
					        height:' . $this->height . 'px">
					        </iframe>';

		return '<div class="'.$this->code.'_container">' . $output . '</div>';
		
	}
}
