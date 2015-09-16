<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Sue theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

 
class SueThemeHelper {
	
	function __construct () {
		$this->image_processing = Loader::helper('image_processing', 'theme_sue');

		Loader::model('theme_sue_options', 'theme_sue');
		$this->o = new ThemeSueOptions();
		$this->set_collection_object(Page::getCurrentPage());
		
		$suePckg = Package::getByHandle('theme_sue');
		
		$this->packageRelativePath = $suePckg->getRelativePath(); //compatible  only with 5.5+
		$this->packagePath = $suePckg->getPackagePath();  // compatible only with 5.5+
		
	}
	
	function set_collection_object($c) {
		$this->o->set_collection_object($c);
	}
	function detection_mobile () {
		
		// return true ;
		
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
		if ($relative)	
			return $this->packageRelativePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		else
			return $this->packagePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		
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

	function output_breadcrumb ($c = null, $output = true ) {
		$c = $c ? $c : Page::getCurrentPage();
		$return = '';
		$nh = Loader::helper('navigation');
		$breadcrumb = $nh->getTrailToCollection($c); 
		krsort($breadcrumb); 
		foreach ($breadcrumb as $bcpage) {
		    $return .= '<a href="'.BASE_URL.DIR_REL.$bcpage->getCollectionPath().'/">'.$bcpage->getCollectionName().'</a>&nbsp;&gt;&nbsp;'; 
		} 
		$return .= '<span>' . $c->getCollectionName() . '</span>';
		if ($output) echo $return; else return $return;
	}
	
	function get_bg_path ($var, $tool, $arg = '') {
		return;
		$th = Loader::helper('concrete/urls');
		$var = '_' . $var;
		$color = substr($this->o->$var , 1 , 6 );
		
		$url = $th->getToolsURL ( $tool . '.php?color=' . $color . $arg, 'theme_sue');
		
		return $url;
		
	}
	
	function get_footer_geometry () {
		$footer_column = $this->o->_display_footer_column;
		
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
	

	
	function get_nav_background_rel_path ($options) {
		
		$id = implode('',($options)) . '_nav';
		$cachefile = DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png' ;
		
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
		    
		    $level_1 = array(13,11,
				    104,11,
				    111,4,
				    118,11,
				    208,11,
				    208,837,
				    13,837,
				    13,11
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
		
		    imagepng($shadow, $cachefile);  
		    imagedestroy($image);  
		    imagedestroy($shadow);		
		}
		
		return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png' ;
		
	}

	function get_main_nav_relative_path ($options) {
		
		$id = implode('',($options))  . '_bgmainav';
		$cachefile = DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';

		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
		} else {
				
			$png = imagecreatefrompng ($this->get_ressource_path ('main_nav', 'main_nav')); 
			$largeur_source = imagesx($png);
			$hauteur_source = imagesy($png);
			
			$hex = $options['color'] ? $options['color'] : '64dfdf';

			$polygon_image = $this->image_processing->image_create_alpha($largeur_source,$hauteur_source);
			$polygon_color = imagecolorallocate($polygon_image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2));
			
			$polygon = array(2,1,
					 981,1,
					 981,47,
					 7,47,
					 7,53,
					 2,48,
					 2,1
					 );
			
			imagefilledpolygon($polygon_image , $polygon , 6 , $polygon_color);
			imagealphablending($polygon_image, true);
			imagecopy($polygon_image,  $png, 0, 0, 0, 0, $largeur_source, $hauteur_source);
					
			if (!is_dir(DIR_FILES_CACHE . '/theme_sue')) {
			    if (!mkdir(DIR_FILES_CACHE . '/theme_sue')) return;
			}
			
			imagepng($polygon_image, $cachefile);
			imagedestroy($polygon_image);  
			imagedestroy($png);		    
		}

		return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
	}
	function get_main_nav_arrow_relative_path ($options) {
		
		$id = implode('',($options))  . '_bgmainavarrow';
		$cachefile = DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';

		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
		} else {
				
			$png = imagecreatefrompng ($this->get_ressource_path ('arrow', 'main_nav')); 
			$largeur_source = imagesx($png);
			$hauteur_source = imagesy($png);
			
			$hex = $options['color'] ? $options['color'] : '64dfdf';

			$polygon_image = $this->image_processing->image_create_alpha($largeur_source,$hauteur_source);
			$polygon_color = imagecolorallocate($polygon_image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2));
			
			$polygon = array(0,8,
					 8,0,
					 16,8,
					 16,11,
					 0,11,
					 0,8
					 );
			
			imagefilledpolygon($polygon_image , $polygon , 5 , $polygon_color);
			imagealphablending($polygon_image, true);
			imagecopy($polygon_image,  $png, 0, 0, 0, 0, $largeur_source, $hauteur_source);
					
			if (!is_dir(DIR_FILES_CACHE . '/theme_sue')) {
			    if (!mkdir(DIR_FILES_CACHE . '/theme_sue')) return;
			}
			
			imagepng($polygon_image, $cachefile);
			imagedestroy($polygon_image);  
			imagedestroy($png);		    
		}

		return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
	}

	function get_pattern_relative_path ($options) {
		
		$id = implode('',($options))  . '_bg';
		$cachefile = DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
		if (file_exists($cachefile)) {
			
			return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
		} else {
				
		    $pattern = $options['pattern'] ?  $options['pattern'] : 'solar';
		    if (is_numeric($pattern) ) {
		
			$file = File::getByID($pattern);
			$bg = @imagecreatefromstring(file_get_contents($file->getPath()));
		
			//if ($file->getExtension() != 'png') return ;
			//else $bg = imagecreatefrompng ($file->getPath());
		     
		    } else {
			
			$bg = imagecreatefrompng ($this->get_ressource_path ($pattern, 'patterns'));    
		    
		    }
		    
		    $hex = $options['color'] ? $options['color'] : '554455';
		    
		    $bg_width = imagesx($bg);  
		    $bg_height = imagesy($bg);
		    
		     
			$color_height = $bg_height;
			$image = imagecreatetruecolor($bg_width, $color_height);
			$background = imagecolorallocatealpha($image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
			imagefilledrectangle($image, 0, 0, $bg_width, $color_height, $background);
			imagecopy($image, $bg, 0, 0, 0, 0, $bg_width, $bg_height);  
		     
		    		    
		    if (!is_dir(DIR_FILES_CACHE . '/theme_sue')) {
			if (!mkdir(DIR_FILES_CACHE . '/theme_sue')) return;
		    }
		    
		    imagepng($image, $cachefile);
		    //echo generated;
		    
		    imagedestroy($image);  
		    imagedestroy($bg);
		    
		}

		return REL_DIR_FILES_CACHE . '/theme_sue/' . $id . '.png';
		
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

	function get_common_colors ($imagePath) {

		Loader::library("colors", 'theme_sue');

		$ex=new GetMostCommonColors();
		$ex->image = $imagePath;

		$colors=$ex->Get_Color();
		return array_keys($colors);
		
	}


	function get_contrast_color($hex, $c = 120, $rgb = false ) {
		
		if (!$hex) $hex =  '000000';
	
		if (substr($hex,0,1) == '#') $hex = substr($hex,1);

		if (strlen($hex) == 3 ) {
			$newHex = '';
			$newHex .= substr($hex,0,1) . substr($hex,0,1);
			$newHex .= substr($hex,0,2) . substr($hex,0,2);
			$newHex .= substr($hex,0,3) . substr($hex,0,3);
			$hex = $newHex;
		}
		
		$rgb = array(substr($hex,0,2), substr($hex,2,2), substr($hex,4,2));

		if(hexdec($rgb[0]) + hexdec($rgb[1]) + hexdec($rgb[2]) > 450){
			return '333333';
		}else{
			return 'ffffff';
			$c = -$c;
		}  
		
		for($i=0; $i < 3; $i++) :
		
		if((hexdec( $rgb[$i]) - $c ) >= 0 )  :
		
			$rgb[$i] = hexdec($rgb[$i]) - $c;
			
		//			if($rgb[$i] > 9) $rgb[$i] = 9; 
		
			$rgb[$i] = dechex($rgb[$i]);
			
			if(hexdec($rgb[$i]) <= 9) :
				$rgb[$i] = "0".$rgb[$i];
			endif;
		
		else :
		    $rgb[$i] = "00";
		endif;
		
		endfor;
		
		return $rgb[0].$rgb[1].$rgb[2];
	}

	public function check_main_colors ($fv) {

		$path = $fv->getPath();

		$colors = $this->get_common_colors($path);
		
		$col1 = FileAttributeKey::getByHandle('common_color_1');
		$col2 = FileAttributeKey::getByHandle('common_color_2');
		$col3 = FileAttributeKey::getByHandle('common_color_3');

		$fv->setAttribute($col1, '#' . $colors[0]);		
		$fv->setAttribute($col2, '#' . $colors[2]);		
		$fv->setAttribute($col3, '#' . $colors[5]);		
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


