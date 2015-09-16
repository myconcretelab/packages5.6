<?php        defined('C5_EXECUTE') or die("Access Denied.");

class FullPageTypeController extends Controller {	
	function on_before_render ()  {
		$this->set('t' , Loader::helper('mylab_theme', 'theme_silence'));
	}
	
	function view () {

	}
	
}
?>