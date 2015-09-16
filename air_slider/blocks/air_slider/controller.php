<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

	class AirSliderBlockController extends BlockController {
		
		var $pobj;
		
		protected $btTable = 'btAirSlider';
		protected $btInterfaceWidth = "450";
		protected $btInterfaceHeight = "500";
		protected $btWrapperClass = 'ccm-ui';
	
		var $anim_easing	= array(
					'easeInOutExpo' => 'easeInOutExpo',
					'linear'=>'linear',
					'easeInCubic'=>'easeInCubic',
					'easeOutCubic'=>'easeOutCubic',
					'easeInOutCubic'=>'easeInOutCubic',
					'easeInBack'=>'easeInBack',
					'easeOutBack'=>'easeOutBack',
					'easeInOutBack'=>'easeInOutBack',
					'easeInElastic'=>'easeInElastic',
					'easeOutElastic'=>'easeOutElastic',
					'easeInOutElastic'=>'easeInOutElastic',
					'easeInBounce'=>'easeInBounce',
					'easeOutBounce'=>'easeOutBounce',
					'easeInOutBounce'=>'easeInOutBounce'
					);		

		public function getBlockTypeName() {
			return t("Air Slider");
		}

		public function getBlockTypeDescription() {
			return t("Air SLider is a flexible jQuery banner rotator that makes an impression. Easy to customize with several options including 5 unique transition.");
		}
		
	function add () {
		$this->set('gallery_width',960);
		$this->set('gallery_height',400);
		$this->set('anim_duration',1000);
		$this->set('duration',5000);
		$this->set('default_link_text',t('Go !'));

		$this->set('options', array('autoPlay','useArrows', 'display_title', 'display_desc','resize'));

		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'air_slider'));
	}

	function edit () {
		$th = Loader::helper('concrete/urls'); 
		$this->set('get_filesets_url', $th->getToolsURL('get_fileset_select_options', 'air_slider'));
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
		
		$this->set('helperUrls', Loader::helper('concrete/urls'));
		$this->set('options',explode(',',$this->options));
		$this->set('tex', Loader::helper('textile','air_slider'));

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
				
				if ($img->getAttribute('link_url') )
					$v[$cc]['link'] = $img->getAttribute('link_url');
				else
					$v[$cc]['link'] = false;
				
				if ($img->getAttribute('link_text') ) 
					$v[$cc]['link_text'] = $img->getAttribute('link_text');
				else
					$v[$cc]['link_text'] = $this->default_link_text != '' ? $this->default_link_text : t('Go');
					
				$v[$cc]['title'] 	= 	$this->getFileFieldValue($img,'title');
				$v[$cc]['desc'] 	= 	$this->getFileFieldValue($img,'description');
				
				if ( ! $img->getAttribute('common_color_1'))
					AirSliderPackage::check_main_colors($img);

				$v[$cc]['color1']	=   $img->getAttribute('common_color_1') ;	

				$v[$cc]['caption_align']	=	$this->get_caption_align($img);	

				if (in_array('resize', $options) && $this->gallery_width && $this->gallery_height) :
					$thb 				= 	$i->getThumbnail($img,$this->gallery_width,$this->gallery_height,true);
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