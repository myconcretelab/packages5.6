<?php        defined('C5_EXECUTE') or die("Access Denied.");

class RightSidebarPageTypeController extends Controller {	
	
	function view ()  {
		$this->set('t' , Loader::helper('mylab_theme', 'theme_silence'));
		$this->set('c', Page::getCurrentPage());
	}
	public function getCommentCountString($singular_format, $plural_format, $disabled_message = '') {
		$count = 0;
		$comments_enabled = false;
		
		$c = $this->getCollectionObject();
		$a = new Area('Blog Post Footer');
		$blocks = $a->getAreaBlocksArray($c);
		if(is_array($blocks) && count($blocks) > 0) {
			foreach($blocks as $b) {
				if($b->getBlockTypeHandle() == 'guestbook') {
					$controller = $b->getInstance();
					$count = $controller->getEntryCount($c->getCollectionID());
					$comments_enabled = true;
					break;// stop at the fist guestbook block found
				}	
			}
		}
		
		if($comments_enabled) {
			$format = ($count == 1 ? $singular_format : $plural_format);
			return sprintf($format, $count);
		} else {
			return $disabled_message;
		}
	}	
}
?>