<?php     

/**
 * @package Silence theme Options
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
		
		echo "<textarea name='$id' id='$id' cols='30' rows='$rows' class='$class'>$value</textarea>";
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
		), $item));
		$value_unit = $default_unit;
		if(is_numeric($value)){
			$value_range = $value;
		}else{
			$value_range=0;
		}
		foreach($units as $unit){
			if(strpos($value, $unit)!==false){
				$value_unit = $unit;
				$value_range = str_replace($unit, '',$value);
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
			echo $units[0];
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

