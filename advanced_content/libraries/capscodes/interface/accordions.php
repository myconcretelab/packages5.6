<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeAccordions extends CapsuleCodeHelper {

 	//public $samplecontent = 'Content of the accordion here';
	//public $title ="accordion title";
	public $initialaccordion = 0;

	function get_capscode () {

		return t('[accordions 
							initialaccordion= "-n _Initial accordion_ #Wich accordions open at when page loaded (zero = first accordion)#"
							]
							[accordion 
							title="-r -t _Title_ #The title of the accordion#" 
							][/accordion][/accordions]');
	}

	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Content of the accordion here'),
							'title' => t('accordion title')
							);
		return $default[$option];

	}

	
	function build_html () {
		if (!count($this->enclosing_tag)) {
			return $this->content;
		} else {

			$rand = rand(0,999);
			$output = '<div class="accordion" id="accordions_' . $rand . '">';

			foreach ($this->enclosing_tag as $key => $tag) {
				
				$active = $key == $this->initialaccordion ? 'in' : '';
				$title = isset($tag['title']) ? $tag['title'] : t('Title ') . $key;
				$id = str_replace(" ", "_", trim($title)) . $rand;

				$output .= '<div class="accordion-group">';
				$output .= '<div class="accordion-heading">';
				$output .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions_' . $rand . '" href="#' . $id . '">' . $title . '</a>';
				$output .= '</div><!-- .accordion-heading -->';

				$output .= '<div id="' . $id . '" class="accordion-body collapse ' . $active . '">';
				$output .= '<div class="accordion-inner">';
				$output .= $tag['content'];
				$output .= '</div><!-- .accordion-inner -->';
				$output .= '</div><!-- .accordion-body -->';
				$output .= '</div><!-- .accordion-group -->';
			}

			$output .= '</div><!-- .accordion -->';

			return  $output;
		}
		
	}
}
