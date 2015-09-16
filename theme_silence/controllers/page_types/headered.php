<?php        defined('C5_EXECUTE') or die("Access Denied.");

class HeaderedPageTypeController extends Controller {	
	
	function on_before_render ()  {
		var_dump('ok');
		$this->set('t' , Loader::helper('mylab_theme', 'theme_silence'));
		$this->set('c', Page::getCurrentPage());
	}
	
}
?>