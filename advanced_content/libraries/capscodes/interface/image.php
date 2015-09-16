<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeImage extends CapsuleCodeHelper {

	public $samplecontent = 'caption here (optional)';
	public $interval = 3000;
	public $slideshow = true;
	public $thumbnail_width = 64;
	public $thumbnail_height = 64;
	public $width = '';
	public $height = '';
	public $crop = true;
	public $fileset = 0;
	public $thumbnail_form ='polaroid';
	public $span = 'no_span';


	function get_capscode () {

		return t('[image
							span = "-s:|span1|span2|span3|span4|span5|span6|span7|span8|span9|span10|span11|span12|no_span #Use the bootstrap responsive columns system#"
							thumbnail_form="-s:|circle|rounded|polaroid #Heads up! rounded & circle do not work in IE7-8 due to lack of border-radius support.#"
							thumbnail_width ="-n #constraint the thumbnail width (used if no_span is selected below)#"
							thumbnail_height ="-n #constraint the thumbnail height (used if no_span is selected below)#"
							width ="-n #(otpional)constraint the image width#"
							height ="-n #(optional)constraint the image height#"
							crop ="-b #crop the image to the width and height#"
							align = "-s:|left|right #choose wich float you need#"
							file = "-i #the image#"
							]
							][/image]');

	}
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Caption here (optional)'));
		return $default[$option];

	}	
	function build_html () {
		if (!intval($this->file)) {
			return $this->content;
		} else {
			$ih = loader::helper('image');
			loader::model('file');
			$class= '';

			$width = intval($this->width) ? intval($this->width) : 10000; 
			$height = intval($this->height) ? intval($this->height) : 10000;

			$thumbnail_width = intval($this->thumbnail_width) ? intval($this->thumbnail_width) : 64; 
			$thumbnail_height = intval($this->thumbnail_height) ? intval($this->thumbnail_height) : 64;

			$margin = $this->align == 'left' ? 'right' : 'left';

			$rand = rand(0,999);
			$modal = '<script>$(\'body\').append(\'<div id="modal-gallery_' . $rand . '" class="modal modal-gallery hide fade modal-fullscreen-stretch" tabindex="-1"><div class="modal-header"><a class="close" data-dismiss="modal">&times;</a><h3 class="modal-title"></h3></div><div class="modal-body"><div class="modal-image"></div></div><div class="modal-footer"><a class="btn btn-primary modal-next">' . t('Next') . ' <i class="icon-arrow-right icon-white"></i></a><a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i>' . t('Previous') . '</a><a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> ' . t('Slideshow') . '</a><a class="btn modal-download" target="_blank"><i class="icon-download"></i> ' . t('Download') . '</a></div></div>\');</script>';
			
			if ($this->span != 'no-span') {
				$class = $this->span;
				$n = substr($this->span,4,2);
				$thumbnail_width = 80 * $n;
				$thumbnail_height ? $thumbnail_height : $thumbnail_width;
			}
			$file = Concrete5_Model_File::getByID($this->file);
			$big = $ih->getThumbnail($file,$width,$height,(!($this->crop === 'false')));
			$toy = $ih->getThumbnail($file,$thumbnail_width,$thumbnail_height,(!($this->crop === 'false')));

			$output = '<span data-href="' . $big->src . '" class="big-link" style="cursor:pointer">';
				$output .= '<img src="' . $toy->src . '" class="img-' . $this->thumbnail_form  . '" />';
			if (trim($this->content) && $this->content != $this->samplecontent)
				$output .= "<small>$this->content</small>";
			$output .= '</span>';

			return $modal . '<span id="gallery_' . $rand . '" data-toggle="modal-gallery" data-selector="span.big-link" class="' . $class . '" data-target="#modal-gallery_' . $rand . '" style="margin-' . $margin . ':15px" >' . $output . '</span>';
		}//style="padding:10px; float:' . $this->align . '; width:' . $thumbnail_width . 'px; display:block"
		
	}
}
