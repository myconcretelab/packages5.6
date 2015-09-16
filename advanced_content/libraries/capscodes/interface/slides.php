<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeSlides extends CapsuleCodeHelper {

	public $initialslide = 0;
	public $interval = 3000;
	public $slideshow = true;
	public $pause = true;
	public $height = 0;

/* 	Wait for the management by data attribute
							interval = "-n #The amount of time to delay between automatically cycling an item#"
							slideshow= "-b #If you want a auto play#"
							pause = "-b #Pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave.#"
*/

	function get_capscode () {
		return t('[slides
							initialslide= "-n _Initial slide_ #Wich slide open at when page loaded (zero = first tab)#"
							]
							[slide 
							height="-n _Slider Height_ #(optional) can be used to homogenize content slide (in px)#"
							][/slide][/slides]');
	}
	
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Add content here'));
		
		return $default[$option];

	}		
	function build_html () {
		if (!count($this->enclosing_tag)) {
			return $this->content;
		} else {

			$rand = rand(0,999);
			$output  = '<div class="carousel slide" id="slide_' . $rand . '">';
			$output .= '<div class="carousel-inner">';

			foreach ($this->enclosing_tag as $key => $tag) {

				$active = $key == $this->initialslide ? ' active' : '';
				$height = (isset($tag['height']) && intval($tag['height']) > 0 ) ? ( 'style="height:' . $tag['height'] . 'px"') : '';

				$output .= '<div class="item ' . $active . '" ' . $height . '>';

				$output .=  $tag['content'];

         		$output .= '</div>';
			}

			$output .= '</div><!-- .carousel-inner -->';
			$output .= '<a class="carousel-control left" href="#slide_' . $rand . '" data-slide="prev">&lsaquo;</a>';
          	$output .= '<a class="carousel-control right" href="#slide_' . $rand . '" data-slide="next">&rsaquo;</a>';
			$output .= '</div><!-- .carousel -->';

			return  $output ;
		}
		
	}
}
