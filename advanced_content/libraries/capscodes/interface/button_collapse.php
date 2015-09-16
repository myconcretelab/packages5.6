<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeButtonCollapse extends CapsuleCodeHelper {

	public $opened = false;
	public $style = "default";
	public $size = "default";
	public $block = false;

	function get_capscode () {

		return t('[button_collapse 
						opened = "-b #if the content is open when page is loaded#"
						title="-r -t #The title of the button#"
						style="-s:|default|primary|info|success|warning|danger|inverse|link #Choose tthe apparence of the button##"
						size = "-s:|default|large|small|mini #Fancy larger or smaller buttons?#"
						block = "-b #Create block level buttons—those that span the full width of a parent#"
						]
						[/button_collapse]');
	}
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Content of the button collapse'),
							'title' => t('button title')
							);
		return $default[$option];

	}
	function build_html () {
			$rand = rand(0,999);

				$title = isset($matches[3][$i]['title']) ? $matches[3][$i]['title'] : 'Title ' . $i;
				$id = str_replace(" ", "_", trim($title)) . $rand;
				$class = '';

				if ($this->style != 'default')
					$class .= ' btn-' . $this->style;
				if ($this->size != 'default')
					$class .= ' btn-' . $this->size;
				if ($this->block)
					$class .= ' btn-block';

				$output = '<button type="button" class="btn ' . $class . '" data-toggle="collapse" data-target="#' . $id . '">';
				$output .= $this->title;
				$output .= '</button>';

				$output .= '<div id="' . $id . '" class="collapse ' . ($this->opened ? 'in' : '') . '">';
				$output .= $this->content;
				$output .= '</div>';
	
			return '<div class="'.$this->code.'_container' . $alignment . '">' . $output . '</div>';

	}
}
