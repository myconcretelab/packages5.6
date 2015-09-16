<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package SuperMint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

 
class SuperMintThemeHelper {
	
	function __construct () {		
		$super_mintPckg = Package::getByHandle('theme_super_mint');
		
		$this->packageRelativePath = $super_mintPckg->getRelativePath(); //compatible  only with 5.5+
		$this->packagePath = $super_mintPckg->getPackagePath();  // compatible only with 5.5+
		$this->is_ecommerce = $this->is_ecommerce();
	}
	

	function is_ecommerce () {
		$ec = Package::getByHandle('core_commerce');
		return is_object($ec);
	}

	function get_ressource_path ($fileName, $type, $ext = 'png', $relative = false ) {
		// Si c'est un fichier 'custom'
	    if (is_numeric($fileName) ) {
			$file = File::getByID($fileName);
			if (is_object($file)) {
				return $file->getApprovedVersion()->getURL();
			}
		}

		// Relative indique une url pour les CSS, sinon, c'est un chemin pour le PHP
		if ($relative)	
			return $this->packageRelativePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		else
			return $this->packagePath . '/' . DIRNAME_IMAGES . '/' . $type . '/' . $fileName . '.' . $ext;
		
	}

	function get_ressource_relative_path ($fileName, $type, $ext = 'png') {

		return $this->get_ressource_path ($fileName, $type, $ext = 'png', true);

	}
	
	function get_footer_geometry ($footer_column) {
		$footer_column = $footer_column ? $footer_column : 3;
		$geometry = array();
		
		if (is_numeric($footer_column)) :
			for ($i = 1 ; $i < ((int)$footer_column + 1) ; $i++) :
				$geometry[$i] = array();
				$geometry[$i]['class'] = 'footer-item span' . (12 / $footer_column . ( $i == $footer_column ? ' last' : '') );
				$geometry[$i]['name'] = 'Footer_0' . $i ;
			endfor;
		else :
			switch($footer_column) :
				
				case 'half_two':
					$geometry[1] = array('class'=>'footer-item span6', 'name'=>'Footer_01');
					$geometry[2] = array('class'=>'footer-item span3', 'name'=>'Footer_02');
					$geometry[3] = array('class'=>'footer-item span3 last', 'name'=>'Footer_03');
					break;
				
				case 'half_three':
					$geometry[1] = array('class'=>'footer-item span6', 'name'=>'Footer_01');
					$geometry[2] = array('class'=>'footer-item span2', 'name'=>'Footer_02');
					$geometry[3] = array('class'=>'footer-item span2', 'name'=>'Footer_03');
					$geometry[4] = array('class'=>'footer-item span2 last', 'name'=>'Footer_04');
					break;
			endswitch;
	
		endif;
		
		return $geometry;
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

	function adjustBrightness($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Format the hex color string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Get decimal values
	    $r = hexdec(substr($hex,0,2));
	    $g = hexdec(substr($hex,2,2));
	    $b = hexdec(substr($hex,4,2));

	    // Adjust number of steps and keep it inside 0 to 255
	    $r = max(0,min(255,$r + $steps));
	    $g = max(0,min(255,$g + $steps));  
	    $b = max(0,min(255,$b + $steps));

	    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
	    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
	    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

	    return '#'.$r_hex.$g_hex.$b_hex;
	}

	function getClosestColumnsNumber ($search, $arr = array(1,2,3,4,6)) {
	   $closest = null;
	   foreach($arr as $item) {
	      if($closest == null || abs($search - $closest) > abs($item - $search)) {
	         $closest = $item;
	      }
	   }
	   return $closest;
	}
	function array_set_pointer(&$array, $value) {
	    reset($array);
	    while($val=key($array)) {
	        if($val==$value) break;
	        next($array);
	    }
	}	

}


