<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeImageSlides extends CapsuleCodeHelper {

	// optional weighty yet welcome
	public $appVersionRequired = '5.4.2';
	public $cpsVersion = '1.0';
	public $samplecontent = ' ';
	public $link = true ;
	public $showcaption = true;
	public $initialslide = 0;
	public $interval = 3000;
	public $slideshow = true;
	public $pause = true;
	public $width = 0;
	public $height = 0;
	public $crop = false;
	public $fileset = 0;


	function get_capscode () {

		return t('[image_slides
							initialslide= "-n #Wich slide open at when page loaded (zero = first tab)#"
							showcaption = "-b #show title and description as caption#"
							link = "-b #If a url is found on a attribute called \'link_url\' the slide will be linked#"
							width ="-n #(required only if crop is true)constraint the image width#"
							height ="-n #(required only if crop is true)constraint the image height#"
							crop ="-b #crop the image to the width and height#"
							fileset ="-fs #Optional, if a filset is set here, the images from this will be added at the end of the gallery#"
							]
							[image_slide 
							image="-i #choose a image as slide#"
							][/image_slide][/image_slides]');

	}
	
	function build_html () {
		if (!count($this->enclosing_tag) && !intval($this->fileset)) {
			return $this->do_capscode($this->content);
		} else {
			$ih = loader::helper('image');
			loader::model('file');

			$stacked = $this->stackable != 'false' ? ' nav-stacked' : '';
			$alignment = $this->alignment != 'top' ? ' pull-' . $alignment : '';
			$width = intval($this->width) ? intval($this->width) : 10000; 
			$height = intval($this->height) ? intval($this->height) : 10000;

			$rand = rand(0,999);
			$output = '<div class="carousel slide" id="carousel_' . $rand . '"> <div class="carousel-inner">';


			# -- Build from fileset - #

			if (intval($this->fileset)) :
				Loader::model('file_list');
				Loader::model('file_set');
				
				$fs = FileSet::getByID($this->fileset);
				$fl = new FileList();
				$fl->filterBySet($fs);
				//$fl->sortByFileSetDisplayOrder($fs);
				$files = $fl->get();
				end($this->enclosing_tag); 
				$last_key = key($this->enclosing_tag);
				foreach($files as $k=>$f) :
					$this->enclosing_tag[$k+$last_key+1]['image'] = $f->fID;
					$this->enclosing_tag[$k+$last_key+1]['content'] = '';
				endforeach;
			endif;

			# -- Build from image array - #

			if (count($this->enclosing_tag)) :
				foreach ($this->enclosing_tag as $key => $tag) :
					$active = $key == $initialslide ? ' active' : '';

					if (isset($tag['image'])){
						if(intval($tag['image']) > 0 ){
							$fileID = $tag['image'];
						} else {continue;}
					} else {continue;}
					
					$file = Concrete5_Model_File::getByID($fileID);
					//$th = 

					$output .= '<div class="item ' . $active . '">';

					$output .= $ih->outputThumbnail($file,$width,$height,'alt',true,(bool)$this->crop);


					if ($this->showcaption && trim($tag['content']) ) {
						$output .= '<div class="carousel-caption">';
						$output .= $tag['content'];
						$output .= '</div>';
					}
	          		$output .= '</div>';
				endforeach;

			endif;

			$output .= '</div><!-- .carousel-inner -->';
			$output .= '<a class="carousel-control left" href="#carousel_' . $rand . '" data-slide="prev">&lsaquo;</a>';
          	$output .= '<a class="carousel-control right" href="#carousel_' . $rand . '" data-slide="next">&rsaquo;</a>';
			$output .= '</div><!-- .carousel -->';

			return '<div class="'.$this->code.'_container">' . $output . '</div>';
		}
		
	}
}
