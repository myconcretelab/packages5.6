<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeTabs extends CapsuleCodeHelper {

	public $stackable = false;
	public $initialtab = 0;
	public $alignment = 'top';
	public $type = 'tabs';

	function get_capscode () {
		return t('[tabs 	
							initialtab= "-n _Initial tab_ #Wich tabs open at when page loaded (zero = first tab)#"
							stackable = "-b _Stackable_ #enable to to make them appear vertically stacked#"
							alignment = "-s:|left|right|top _Alignment_ #Position of tabs/pills#"
							type="-s:|tabs|pills _Type_ #the two displaying type of bootstrap tabs#" 	
							]
							[tab 
							title="-r -t _Title_ #The title of the tab#" 
							][/tab][/tabs]');
	}

	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Content of the tab here'),
							'title' => 'Tab title'
							);
		return $default[$option];

	}	
	
	function build_html () {
		if (!count($this->enclosing_tag)) {
			return $this->content;
		} else {

			$stacked = $this->stackable ? ' nav-stacked' : '';
			$alignment = $this->alignment != 'top' ? ' pull-' . $this->alignment : '';
			$output = '<ul class="nav nav-' . $this->type . $stacked . $alignment . '" id="tabs_' . rand(0,999) . '">';

			foreach ($this->enclosing_tag as $key => $tag) {
				$active = $key == $initialtab ? ' class="active"' : '';
				$title = isset($tag['title']) ? $tag['title'] : t('Title ') . $key;
				$id = str_replace(" ", "_", trim($title));
				$ids[$key] = $id; 
				$output .= '<li ' . $active . '><a href="#' . $id . '">' . $title . '</a></li>';
			 } 
			
			$output .= '</ul>';
			$output .= '<div class="tab-content">';

			foreach ($this->enclosing_tag as $key => $tag) {
				$this->do_capscode(trim($tag['content']));
				$active = $key == $initialtab ? ' active' : '';
				$output .= '<div id="' . $ids[$key] . '" class="tab-pane' . $active . '">' .  $tag['content'] . '</div>';
			}

			$alignment = ($this->alignment == 'left' || $this->alignment == 'right' ) ? ' tabbable tabs-' . $this->alignment : '';
			
			return '<div class="tabs_container ' . $alignment . '">' . $output . '</div>';
		}
		
	}
}
