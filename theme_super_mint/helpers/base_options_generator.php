<?php 

/**
 * @package SuperMint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

defined('C5_EXECUTE') or die("Access Denied.");

class BaseOptionsGeneratorHelper {

	var $generator;

	function __construct () {
		$this->generator = Loader::helper('form');
	}

	function text($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"size" => "10",
			"class"=> "",
		), $item));
		$class = $class?' class="'.$class.'"':'';
		
		echo "<input type='text' name='$id' size='$size' value='$value' class='$class' />";

	}
	
	function textarea($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"rows" => "7",
			"cols" => "10",
			"class"=> "code",
		), $item));
		$class = $class?' class="'.$class.'"':'';
		
		echo "<textarea name='$id' id='$id' cols='$cols' rows='$rows' class='$class' style='width:100%; font-family: Monaco, monospace;'>$value</textarea>";
	}
	
	function select($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"chosen" => false,
			"target" => NULL,
			"options" => array(),
			"class"=> "",
		), $item));
	
		echo $this->generator->select($id,$options,$value);		
	}

	function range($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"min" => NULL,
			"max" => NULL,
			"step" => NULL,
			"unit" => NULL,
		), $item));
		
		echo '<div class="range-input-wrap" ><input name="' . $id . '" id="' . $id . '" type="range" value="'.$value;
		
		if (!is_null($min)) {
			echo '" min="' . $min;
		}
		if (!is_null($max)) {
			echo '" max="' . $max;
		}
		if (!is_null($step)) {
			echo '" step="' . $step;
		}
		echo '" />';
		if (!is_null($unit)) {
			echo '<span>' . $unit . '</span>';
		}
		echo '<br /></div>';
		
	}
	
	function measurement($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"min" => NULL,
			"max" => NULL,
			"step" => NULL,
			"units" => array('px','%','em','pt'),
			'default_unit' => 'px',
			"poh" => "", 
			"pID" => "" 

		), $item));
		//$value_unit = $default_unit;

		//var_dump($poh->get_option_value('p_size_range',$pID));
		//var_dump($value);
		if(is_numeric($value)){
			$value_range = $value;
		}else{
			$value_range=0;
		}
		if (is_array($units) && count($units)>1) {
			foreach($units as $unit){
				if(strpos($value, $unit)!==false){
					$value_unit = $unit;
					$value_range = str_replace($unit, '',$value);
				}
			}
		}
		if(empty($value_unit)){
			$value_unit = $default_unit;
		}
		echo '<div class="measurement-wrap" >';
		echo '<input type="hidden" id="' . $id . '" name="' . $id . '" value="' . $value . '" />';
		echo '<span class="range-input-wrap"><input name="' . $id . '_range" id="' . $id . '_range" type="range" value="'.$value_range;
		
		if (!is_null($min)) {
			echo '" min="' . $min;
		}
		if (!is_null($max)) {
			echo '" max="' . $max;
		}
		if (!is_null($step)) {
			echo '" step="' . $step;
		}
		echo '" /></span>';
		echo '<span class="measurement-unit-wrap">';
		if (is_array($units) && count($units)>1) {
			echo '<select name="' . $id . '_unit" id="' . $id . '_unit">';
			foreach($units as $unit) {
				echo '<option value="' . $unit . '"';
				if ($unit == $value_unit) {
					echo ' selected="selected"';
				}
				echo '>' . $unit . '</option>';
			}
			echo '</select>';
		}else{
			echo '<span style="display:-inline-block; margin-left:10px; line-height:25px; text-ident:10px">' . $units[0] . '</span>';
		}
		echo '</span>';
		echo '<br /></div>';
	}
	
	/**
	 * displays a color input
	 */
	function color($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"size" => "10",
			"class" => "",
		), $item));
		
		$class = $class?' class="'.$class.'"':'';
		
		echo '<div class="color-input-wrap"><input'.$class.' name="' . $id . '" id="' . $id . '" type="color" data-hex="true" size="' . $size . '" value="' . $value . '" /></div>';
		
	}
	
	/**
	 * displays a toggle button
	 */
	function toggle($item) {
		/*
		 value 'une_option_specifique'
		 id 'options'
		*/
		//print_r($item);
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"array"=> true, // Doit toujours etre sur true 
			"activated"=> true
		), $item));
		
		$checked = '';
		if ($activated === 'true' || $activated === true) {
			$checked = 'checked="checked"';
		}
		$name = $array ? $value . '_toggle' . '[]' : $value; 		
		echo '<input type="checkbox" class="toggle-button" name="' . $name . '" value="' . $id . '" ' . $checked . ' />';
		echo '<input type="hidden" name="' . $name . '" value="|"/>';
	}
	
	/**
	 * displays a page selector
	 */
	function page($item) {
		extract($this->option_atts(array(
			"id" => "",
			"value" => false,
			"quick"=> false
		), $item));
			
		$sph = Loader::helper('form/page_selector');
		if ($quick) :
			echo  $sph->quickSelect($id, $value); // prints out the home page and makes it selectable.		
		else :
			echo  $sph->selectPage($id, $value); // prints out the home page and makes it selectable.
		endif;
	}
	/**
	 * displays a file selector
	 */
	function file($item) {
		extract($this->option_atts(array(
			"name"=>t('Choose File'),
			"id" => "",
			"value" => false,
			"type"=> false // image video text audio doc app
		), $item));

		$value = $value ?  File::getByID($value) :$value ;
			
		$al = Loader::helper('concrete/asset_library');

		if (!$type) :
			echo  $al->file($id, $id, $name, $value); 		
		else :
			echo  $al->$type($id, $id, $name, $value); 	
		endif;
	}

	/**
	 * displays a toggle button
	 */
	function tritoggle($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
		), $item));
		
		switch($value) {
			case "true": 
				$value = 'true';
				break;
			case "false":
				$value = 'false';
				break;
			case "":
				$value = 'default';
				break;
		}
		echo '<select class="tri-toggle-button" name="' . $id . '" id="' . $id . '" >';
		echo '<option value="true"';
		if($value == 'true'){
			echo 'selected="selected"';
		}
		echo '>On</option>';
		echo '<option value="false"';
		if($value == 'false'){
			echo 'selected="selected"';
		}
		echo '>Off</option>';
		echo '<option value="default"';
		if($value == 'default'){
			echo 'selected="selected"';
		}
		echo '>default</option>';
		echo '</select>';
	}
	/**
	 * displays a font chooser
	 */
	function font($item) {
		extract($this->option_atts(array(
			"id" => "",
			"default" => "",
			"value" => "",
			"inputType" => "select",
			"poh" => "", // Je le mentionne car j'en ai besoin
			"pID" => "" // idem :-)
		), $item));

		$fontList = Cache::get('fontList', 'googlefontList');
		
		if (!$fontList) {
			$fontList = Loader::helper('json')->decode (Loader::helper('file')->getContents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAsT5OzRSuWghytRLmwLagJ4BCl49qC1kM'));
			Cache::set('fontList', 'googlefontList', $fontList, 604800);
		}

		if (!$fontList)	echo '<p>' . t('Sorry we can\'t connect to Google Fonts, perhaps you are not connected to Internet ?') . '<p>';

		// Il n'y a pas encore de gestion d'erreur
		
		/*
		 * p_subset
		 * p_font
		 * p_variants
		 * 
		*/
		
		$fontName = $id . '_font';
		$subsetName = $id . '_subset';
		$variantName = $id . '_variants';
		// La police choisie pour ce preset (si il y en a une)
		$choose = str_replace('+', ' ', $poh->get_option_value($fontName,$pID));
		$choose = ($choose === '0' || $choose == '') ? str_replace('+', ' ', $default) : $choose;
		
		$selected_variants = explode(',', $poh->get_option_value($variantName,$pID));
		$selected_subsets = explode(',', $poh->get_option_value($subsetName,$pID));		

		// Si on est dans un choix par defaut, on ajoute les variant det subset de base
		if (!$selected_variants && !$selected_subsets && $default) {
			$selected_variants[] = 'regular';
			$selected_subsets[] = 'latin' ;
		} 
		echo '<select name="' . $fontName . '" data-placeholder="Choose a Font..." style="width:350px;"  class="font_selector chzn-select" id="' . $fontName . '" data-subset="' . $subsetName . '" data-variant="' . $variantName . '" data-itype="' . $inputType . '">';
		echo '<option value="0">' . t('- Theme default font -') . '</option>';
		// On tourne dans toutes les polices (320)
		foreach ($fontList->items as $key => $fontObj) :
			$selected = $fontObj->family == $choose  ? 'selected' : false;
			// Si une police à déjà été chargé pour cette option, on retient ses infos
			// Pour les details
			if ($selected) {
				$variants = $fontObj->variants;
				$subsets = $fontObj->subsets;
			} 
			echo '<option value="' . str_replace(' ', '+', $fontObj->family) . '" ' . $selected . '>' . $fontObj->family . '</option>';
		endforeach;
		echo '</select>';

		// La boit a infos
		echo '<div id="' . $fontName . '_details_wrapper">';
			// Si il y a des infos chargées, on remplis la boite
			if ($variants || $subsets) Loader::packageElement('font_details','theme_super_mint',array(
				// Le type d'input
				'inputType' => $inputType,
				// La police choisie
				'font' => $choose,
				// Les tableaux des options disponibles
				'variants' => $variants, 
				'subsets' => $subsets,
				// LE nom des inputs
				'subsetName' => $subsetName,
				'variantName' => $variantName, 
				// Les options selectionee
				'selected_subsets' => $selected_subsets,
				'selected_variants' => $selected_variants

				));
		echo '</div>';
	}
	
	function option_atts($pairs, $atts){
		$atts = (array)$atts;
		$out = array();
		foreach($pairs as $name => $default) {
			if ( array_key_exists($name, $atts) )
				$out[$name] = $atts[$name];
			else
				$out[$name] = $default;
		}
		return $out;
	}
}

