<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

	class BladeSliderBlockController extends BlockController {
		
		var $pobj;
		
		protected $btDescription = "BLADES jQuery is a flexible jQuery banner rotator that makes an impression. Easy to customize with several options including 5 unique transitions, BLADES jQuery is the type of banner that can easily headline your next project.";
		protected $btName = "Blade slider";
		protected $btTable = 'btBladeSlider';
		protected $btInterfaceWidth = "450";
		protected $btInterfaceHeight = "500";
		protected $btWrapperClass = 'ccm-ui';

	function add () {
		$this->set('width',960);
		$this->set('height',400);
		$this->set('rows',3);
		$this->set('cols',7);
		$this->set('thumbSpacing',10);
		$this->set('slideDelay',4000);
		$this->set('arrowPadding',5);
		$this->set('transitionType','whiteFlash');
		$this->set('options', array('autoPlay','useArrows', 'display_title', 'display_desc','resize'));

		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'blade_slider'));
	}

	function edit () {
		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'blade_slider'));
		$this->set('options',explode(',',$this->options));

	}
	function color_tool ($hex, $tool = 'bright') {
		// returns brightness value from 0 to 255

		// strip off any leading #
		$hex = str_replace('#', '', $hex);

		$c_r = hexdec(substr($hex, 0, 2));
		$c_g = hexdec(substr($hex, 2, 2));
		$c_b = hexdec(substr($hex, 4, 2));

		if ($tool == 'bright') {
			return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
		} elseif ($tool == 'rvb') {
			return array($c_r, $c_g, $c_b );
		}
	}	

	function view() {
		
		$this->set('tex', Loader::helper('textile','advanced_slider'));
		$this->set('helperUrls', Loader::helper('concrete/urls'));
		$this->set('options',explode(',',$this->options));

		if($this->bID) {
			$db = Loader::db();

			$data = $db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			Loader::model('file');
			Loader::library('file/types');
			$nv = 		Loader::helper('navigation');
			$i = 		Loader::helper('image');
			$options = 	explode(',',$this->options);
			
			$v = array();
			$cc = 0;
						
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
			  $s = @getimagesize($img->getPath());
			  $fv = $img->getExtension();
			  $ft = FileTypeList::getType($fv);
			  if ($ft->type == 1) {
				
				if ($img->getAttribute('link_url') ) {
					$v[$cc]['link'] = $img->getAttribute('link_url');
					
				} else {
					$v[$cc]['link'] = false;
				}      
				
				$v[$cc]['title'] 	= 	$this->getFileFieldValue($img,'title');
				$v[$cc]['desc'] 	= 	$this->getFileFieldValue($img,'description');

				$v[$cc]['color1']	=  ( $co = $img->getAttribute('common_color_1') ) ? $co : '#fcfcfc';	
				$v[$cc]['color2']	=  ( $co = $img->getAttribute('common_color_2') ) ? $co : '#cccccc';

				$v[$cc]['caption_align']	=	$this->get_caption_align($img);	

				if (in_array('resize', $options) && $this->width && $this->height) :
					$thb 				= 	$i->getThumbnail($img,$this->width,$this->height,true);
					$v[$cc]['src'] 		= 	$thb->src;				
					$v[$cc]['width'] 	= 	$thb->width ;
					$v[$cc]['height'] 	= 	$thb->height;
				else :
					$v[$cc]['src'] 		= 	$img->getRelativePath(); //$src->src;								
					$v[$cc]['width'] 	= 	$s[0] ;
					$v[$cc]['height'] 	= 	$s[1] ;
				endif;
				$cc ++;
			  }
			}
			$this->set('gallery', $v);
		} else {
			$this->set('gallery', false);
		}		
	}
	function get_caption_align($i) {
		if ($a = $i->getAttribute('caption_alignment'))
			return $a == 'L' ? 'left' : 'right';
		else
			return 'left';
	}
		
	function getFileFieldValue($f,$handle) {
		if(!is_object($f)) {
			return false;
		}
		$value = "";
		switch($handle) {
			case "title";
				$value = $f->getTitle();
			break;
			case "description";
				$value = $f->getDescription();
			break;
			case "date":
				$value = $f->getDateAdded();
			break;
			case "filename":
				$value = $f->getFileName();
			break;
			default:
				$value = $f->getAttribute($handle);
			break;
		}
		return $value;
	}
	
	function save ($data) {
		
		// some check
		$data['options'] = 	is_array($data['options']) ? implode(',',$data['options']) : '';
		parent::save($data);

	}
}

	
?>