<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Silence theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

 
class MylabThemeHelper {
	
	function __construct () {
		Loader::model('theme_options', 'theme_silence');
		$this->o = new ThemeOptions(Page::getCurrentPage());
		
		$silencePckg = Package::getByHandle('theme_silence');

		$this->packageRelativePath = $silencePckg->getRelativePath(); //compatible  only with 5.5+
		$this->packagePath = $silencePckg->getPackagePath();  // compatible only with 5.5+
	}
	
	function set_collection_object($c) {
		$this->o->set_collection_object($c);
	}
	function detection_mobile () {
		
		 // return true ;
		Loader::library('3rdparty/mobile_detect');
		if (class_exists('Mobile_Detect')) {
			$md = new Mobile_Detect();
			return $md->isMobile();			
		}

		if ($this->o->__disable_mobile_detection) return false;
		
		if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']))
			return true;
	
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{
			$accept = strtolower($_SERVER['HTTP_ACCEPT']);
			if (strpos($accept, 'wap') !== false)
				return true;
		}
	
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false)
				return true;
	
			if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false)
				return true;
			
			if (strpos ($_SERVER['HTTP_USER_AGENT'], 'HTC') !== false)
				return true;
		}
	
		return false;
	}
	function get_ressource_path ($fileName, $type, $ext = 'png', $relative = false ) {

		// La fonctionalitŽ d'extention du dossier images est anulŽ.
		/*
		if ($relative)	
			return $this->packageRelativePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		else
			return $this->packagePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		*/
			
		// Ancien schŽma
		
		if (file_exists( $rel = DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_' . $type . '/' . $fileName . '.' . $ext)) {
			if ($relative)
				return DIR_REL . '/' . DIRNAME_IMAGES . '/theme_' . $type . '/' . $fileName . '.' . $ext;
			else
				return $rel;
		} else {
		       	if ($relative)	
				return $this->packageRelativePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
			else
				return $this->packagePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		}
	}

	function get_ressource_relative_path ($fileName, $type, $ext = 'png') {

		return $this->get_ressource_path ($fileName, $type, $ext = 'png', true);

	}
	// Semble ne pas fonctionner si les "pretty urls" ne sont pas activŽ ?
	function output_breadcrumb ($c = null, $output = true ) {
		$c = $c ? $c : Page::getCurrentPage();
		$return = '';
		$nh = Loader::helper('navigation');
		$breadcrumb = $nh->getTrailToCollection($c); 
		krsort($breadcrumb); 
		foreach ($breadcrumb as $bcpage) {
		    $return .= '<a href="'. $nh->getCollectionURL($bcpage).'">'.$bcpage->getCollectionName().'</a>&nbsp;&gt;&nbsp;'; 
		} 
		$return .= '<span>' . $c->getCollectionName() . '</span>';
		if ($output) echo $return; else return $return;
	}
	
	function get_bg_path ($var, $tool, $arg = '') {
		return;
		$th = Loader::helper('concrete/urls');
		$var = '_' . $var;
		$color = substr($this->o->$var , 1 , 6 );
		
		$url = $th->getToolsURL ( $tool . '.php?color=' . $color . $arg, 'theme_silence');
		
		return $url;
		
	}
	
	function get_footer_geometry () {
		$footer_column = $this->o->display_footer_column;
		
		$geometry = array();
		
		if (is_numeric($footer_column)) :
			for ($i = 1 ; $i < ((int)$footer_column + 1) ; $i++) :
				$geometry[$i] = array();
				$geometry[$i]['class'] = 'col_' . (12 / $footer_column . ( $i == $footer_column ? ' last' : '') );
				$geometry[$i]['name'] = 'Footer_' . $i ;
			endfor;
		else :
			switch($footer_column) :
				
				case 'half_two':
					$geometry[1] = array('class'=>'col_6', 'name'=>'Footer_1');
					$geometry[2] = array('class'=>'col_3', 'name'=>'Footer_2');
					$geometry[3] = array('class'=>'col_3 last', 'name'=>'Footer_3');
					break;
				
				case 'half_three':
					$geometry[1] = array('class'=>'col_6', 'name'=>'Footer_1');
					$geometry[2] = array('class'=>'col_2', 'name'=>'Footer_2');
					$geometry[3] = array('class'=>'col_2', 'name'=>'Footer_3');
					$geometry[4] = array('class'=>'col_2 last', 'name'=>'Footer_4');
					break;
			endswitch;
	
		endif;
		
		return $geometry;
	}
	
	function create_image ($filePath, $fileset = false, $fileName = false) {
                
		$fi = new FileImporter();
		$newFile = $fi->import( $filePath);

		if (!is_object($newFile)) return;

		if ($fileset) :
			$fs = FileSet::createAndGetSet($fileset, FileSet::TYPE_PUBLIC);
			$fsf = $fs->addFileToSet($newFile);
		endif;
		
		return array('fID' => $newFile->getFileID(), 'fsID' => $fsf->fsID);
		
	}
	
	function get_nav_background_rel_path ($options) {
		
		$id = implode('',($options)) . '_nav';
		$cachefile = DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';
		
		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_silence/' . $id . '.png' ;
		
		} else {
		    		    
		    $level = $options['level'] ? $options['level'] : '1';
		    $form = 'level_' . $level;
		    
		    $shadow = imagecreatefrompng ($this->packagePath . '/images/navigation/nav-shadow-' . $level . '.png');
		    imageAlphaBlending($shadow, true);
		    imageSaveAlpha($shadow, true);
		    
		    $image = imagecreatetruecolor(220, 850);
		    imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));
		    
		    $bg_width = imagesx($shadow);  
		    $bg_height = imagesy($shadow);  
		    $color_height = 255;
		    
		    $hex = $options['color'] ? $options['color'] : '522455';
		    $background = imagecolorallocatealpha($image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
		    
		    $level_1 = array(13,13,
				    31,13,
				    38,6,
				    45,13,
				    203,13,
				    203,814,
				    13,814,
				    13,13
				    );
		    
		    $level_2 = array(13,13,
				    203,13,
				    203,813,
				    13,813,
				    13,44, // start
				    6,37,
				    13,30,
				    13,13
				    );
		    
		    imagefilledpolygon($image , $$form , 8 , $background);
		    
		    imagecopymerge($shadow,$image , 0, 0, 0, 0, $bg_width, $bg_height,100);  
		    
		    if ($light_type = $options['light']) {
			$light = imagecreatefrompng ($this->packagePath . '/images/navigation/' . $light_type . '_' . $options['level'] . '.png');
			imagecopy( $shadow, $light, 0, 0, 0, 0, $bg_width, imagesy($light));  
		    }
			
		
		    imagepng($shadow, $cachefile);  
		    imagedestroy($image);  
		    imagedestroy($shadow);		
		}
		
		return REL_DIR_FILES_CACHE . '/theme_silence/' . $id . '.png' ;
		
	}


	function get_pattern_relative_path ($options) {
		
		$id = implode('',($options))  . '_bg';
		$cachefile = DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';
		
		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';
		
		} else {
				
		    $pattern = $options['pattern'] ?  $options['pattern'] : 'square';
		    
		    if (is_numeric($pattern) ) {
		
			$file = File::getByID($pattern);
		
			if ($file->getExtension() != 'png') return ;
			else $bg = imagecreatefrompng ($file->getPath());
		     
		    } else {
			
			$bg = imagecreatefrompng ($this->get_ressource_path ($pattern, 'patterns'));    
		    
		    }
		    
		    $hex = $options['color'] ? $options['color'] : '554455';
		    
		    $bg_width = imagesx($bg);  
		    $bg_height = imagesy($bg);
		    
		    if ( is_numeric($options['color-height']) ) {
			
			$color_height = $options['color-height'];
			if ($color_height === '0' ) return header('content-type: image/png');
		    
			$bg_height = $color_height;
			$image = $this->imagefillfromfile($bg,$bg_width,$color_height,$hex);
		     
		    } else {
		     
			$color_height = $bg_height;
			$image = imagecreatetruecolor($bg_width, $color_height);
			$background = imagecolorallocatealpha($image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
			imagefilledrectangle($image, 0, 0, $bg_width, $color_height, $background);
			imagecopy($image, $bg, 0, 0, 0, 0, $bg_width, $bg_height);  
		     
		    }
		    
		    if ($shadow_type = $options['shadow']) {
		
			if (is_dir($custom_folder = DIR_BASE . '/images/theme_shadows/') && is_file($custom_folder . $shadow_type .'.png')) {
			    $shadow = imagecreatefrompng ($custom_folder . $shadow_type . '.png');    
			} else {
			    $shadow = imagecreatefrompng ($this->packagePath . '/images/shadows/' . $shadow_type. '.png');
			}
			
			preg_match('/(\d+)_(\w+)/',$shadow_type, $match);
			$shadow_h = imagesy($shadow);
			$shadow_y = $match[2] == 'top' ? 0 : ($bg_height - $shadow_h);    
			
			imagecopyresized($image, $shadow, 0, $shadow_y, 0, 0, $bg_width, $shadow_h, 1,$shadow_h);
			imagedestroy($shadow);
		    }
		    
		    
		    if (!is_dir(DIR_FILES_CACHE . '/theme_silence')) {
			if (!mkdir(DIR_FILES_CACHE . '/theme_silence')) return;
		    }
		    
		    imagepng($image, $cachefile);
		    //echo generated;
		    
		    imagedestroy($image);  
		    imagedestroy($bg);
		    
		}

		return REL_DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';
		
	}
	

	function imagefillfromfile($image, $width, $height,$hex) {
		$imageWidth = imagesx($image);
		$imageHeight = imagesy($image);
		$newImage = imagecreatetruecolor($width, $height);
		$background = imagecolorallocatealpha($newImage, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
		imagefilledrectangle($newImage, 0, 0, $width, $height, $background);
		
		for ($imageX = 0; $imageX < $width; $imageX += $imageWidth) {
		    for ($imageY = 0; $imageY < $height; $imageY += $imageHeight) {
			imagecopy($newImage, $image, $imageX, $imageY, 0, 0, $imageWidth, $imageHeight);
		    }
		}
		
		return($newImage);
		imagedestroy($newImage);
	    }	
	
	function hex_to_rvb ($hex) {

		if (substr($hex,0,1) == '#') $hex = substr($hex,1);
		if (strlen($hex) == 3 ) {
			$newHex = '';
			$newHex .= substr($hex,0,1) . substr($hex,0,1);
			$newHex .= substr($hex,0,2) . substr($hex,0,2);
			$newHex .= substr($hex,0,3) . substr($hex,0,3);
			$hex = $newHex;
		}

		return array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
		
	}	
//------------ Magics --------------- //	
	
	function __get ($name) {

		$arg = array();
		return call_user_func_array(array($this->o, $name), $arg);		
	}
	
	function __call($name,$arg) {

		return call_user_func_array(array($this->o, $name), $arg);
	}
}