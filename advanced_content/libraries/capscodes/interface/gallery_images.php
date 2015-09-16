<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeGalleryImages extends CapsuleCodeHelper {

	public $interval = 3000;
	public $slideshow = true;
	public $thumbnail_width = 64;
	public $thumbnail_height = 64;
	public $width = 0;
	public $height = 0;
	public $crop = true;
	public $fileset = 0;
	public $thumbnail_form ='default';
	public $span = 'no_span';


	function get_capscode () {

		return t('[gallery_images
							span =  "-s:|span1|span2|span3|span4|span5|span6|span7|span8|span9|span10|span11|span12|no_span #If set, the display use the responsive columns sytsem of bootstrap#"
							thumbnail_form="-s:|circle|rounded|default #Heads up! rounded & circle do not work in IE7-8 due to lack of border-radius support.#"
							slideshow= "-b #If you want a auto play button#"
							thumbnail_width ="-n #constraint the thumbnail width#"
							thumbnail_height ="-n #constraint the thumbnail height#"
							width ="-n #(otpional)constraint the image width#"
							height ="-n #(optional)constraint the image height#"
							crop ="-b #crop the image to the width and height#"
							fileset ="-fs #Optional, if a filset is set here, the images from this will be added at the end of the gallery#"
							]
							[gallery_image
							image="-i #choose a image as slide#"
							][/gallery_image][/gallery_images]');

	}
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Html content here (optional)'),
							'title' => t('button title')
							);
		return $default[$option];

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

			$thumbnail_width = intval($this->thumbnail_width) ? intval($this->thumbnail_width) : 64; 
			$thumbnail_height = intval($this->thumbnail_height) ? intval($this->thumbnail_height) : 64;

			if ($this->span != 'no_span') {
				$n = substr($this->span,4,2);
				$thumbnail_width = 90 * $n;
				$thumbnail_height = $thumbnail_width;
			}


			$rand = rand(0,999);

			$slideshow = $this->slideshow ? '<a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> ' . t('Slideshow') . '</a>' : ''; 

			$output = '<script>$(\'body\').append(\'<div id="modal-gallery_' . $rand . '" class="modal modal-gallery hide fade modal-fullscreen-stretch" tabindex="-1"><div class="modal-header"><a class="close" data-dismiss="modal">&times;</a><h3 class="modal-title"></h3></div><div class="modal-body"><div class="modal-image"></div></div><div class="modal-footer"><a class="btn btn-primary modal-next">' . t('Next') . ' <i class="icon-arrow-right icon-white"></i></a><a class="btn btn-info modal-prev"><i class="icon-arrow-left icon-white"></i>' . t('Previous') . '</a>' . $slideshow . '<a class="btn modal-download" target="_blank"><i class="icon-download"></i> ' . t('Download') . '</a></div></div>\');</script>';


			# -- Build from fileset - #

			if (intval($this->fileset)) :
				Loader::model('file_list');
				Loader::model('file_set');
				
				$fs = FileSet::getByID($this->fileset);
				$fl = new FileList();
				$fl->filterBySet($fs);
				//$fl->sortByFileSetDisplayOrder($fs);
				$files = $fl->get();
				//var_dump($this->enclosing_tag);
				end($this->enclosing_tag); 
				$last_key = key($this->enclosing_tag);
				foreach($files as $k=>$f) :
					$this->enclosing_tag[$k+$last_key+1]['image'] = $f->fID;
					$this->enclosing_tag[$k+$last_key+1]['content'] = '';
				endforeach;
			endif;

			# -- Build from image array - #

			if (count($this->enclosing_tag)) :
				$output .= '<ul class="thumbnails" id="gallery_' . $rand . '" data-toggle="modal-gallery" data-selector="div.gallery-item a" data-target="#modal-gallery_' . $rand . '">';
				foreach ($this->enclosing_tag as $key => $tag) :
					$active = $key == $initialslide ? ' active' : '';

					if (isset($tag['image'])){
						if(intval($tag['image']) > 0 ){
							$fileID = $tag['image'];
						} else {continue;}
					} else {continue;}
					
					$file = Concrete5_Model_File::getByID($fileID);
					$big = $ih->getThumbnail($file,$width,$height,(bool)$this->crop);
					$toy = $ih->getThumbnail($file,$thumbnail_width,$thumbnail_height,true);

					$output .= '<li class="' . ($this->span != 'no-span' ? $this->span : '') . '">';
					$output .= '<div class="thumbnail gallery-item">';
					$output .= '<a href="' . $big->src . '" class="">';
     				$output .= '<img src="' . $toy->src . '" class="' . ($this->thumbnail_form != 'default' ? 'img-' . $this->thumbnail_form : '') .'" />';

    				$output .= '</a>';


					if (trim($tag['content']) && $tag['content'] != $this->samplecontent)
						$output .= $tag['content'];

    				$output .= '</div>';
    				$output .= '</li>';
					//<a href="' . $big->src . '" class="" title="Banana" rel="gallery">';

					

	          		//$output .= '</ul>';
				endforeach;

			endif;
				//var_dump($matches[0]);

			$output .= '</ul><!-- .gallery_' . $rand . ' -->';


			return '<div class="'.$this->code.'_container row">' . $output . '</div>';
		}
		
	}
}
