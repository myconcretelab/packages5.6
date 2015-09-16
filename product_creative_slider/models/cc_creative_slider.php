<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package SuperMint themuthor Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class CcCreativeSlider extends Object {
	
	function __construct() {
		$this->db = Loader::db();
	}	

	function save_slider($name) {
		$this->db->query("INSERT INTO CoreCommerceCreativeSlider (name) VALUES (?)", array($name));
		$csID = $this->db->Insert_ID();
	}

	function delete_slider ($csID) {
		$this->db->query("DELETE CoreCommerceCreativeSlides FROM CoreCommerceCreativeSlides WHERE csID = ?", array($csID));
		$this->db->query("DELETE CoreCommerceCreativeSlider FROM  CoreCommerceCreativeSlider WHERE csID = ?", array($csID));
	}
	
	function rename_slider ($name, $csID) {
		$this->db->query("UPDATE CoreCommerceCreativeSlider
				 SET name = ?
				 WHERE csID = ?",
				 array( $name, $csID));
		
	}

	function getByID($csID) {
		$row = $this->db->getRow("SELECT csID, name FROM CoreCommerceCreativeSlider WHERE csID = ?",array($csID));
		if(!is_array($row)) return false;

		return $this->init($row);

	}

	/* 
		Cette fonction devrait être une classe à part entière appellée Slider List et renvoiyer un tableau d'objet slide
	*/
	function get_slider_list() {
		$all = $this->db->getAll("SELECT csID, name FROM CoreCommerceCreativeSlider");
		if(!is_array($all)) return false;
		
		$list = array();
		foreach ($all as $key => $slideProperties) {
			$list[] = $this->init($slideProperties);
		}
		return $list;
	}

	function init ($slideProperties) {
		$slidesList = new CcCreativeSlides();
		$slider = new stdClass();

		foreach ($slideProperties as $k=> $v) {
		    $slider->{$k} = $v;
		}

		// On y ajoute les slides
		$slider->slides = $slidesList->get_slides_from_csID($slider->csID);
		return $slider;
	}

	function output_presets_list ($echo = false, $selected=null, $name = 'slider_id', $before = array()) {

		$list = $this->get_slider_list ();

		if ($list) :
			$r[] = '<select name="' . $name . '" id="' . $name . '" class="' . $name . '">';
			if (count($before)) :
				foreach($before as $k=>$option ) :
					$r[] = '<option value="' . -($k) . '">' . $option . '</option>';
				endforeach;
			endif;
			foreach($list as $k=>$p) :

				$text = '';
				$select = ($p['csID'] == $selected ) ? 'selected' : '';

				$r[] = "<option value='{$p['csID']}' $select >{$p['name']}</option>";

			endforeach;
			
			$r[] = '</select>';
			$r = implode("\r" , $r);
			
			if ($echo) 	echo $r;
			else 		return $r;
		
		else:
			return false;
		endif;
		
	}

}


class CcCreativeSlides extends Object { 

	function __construct() {
		$this->db = Loader::db();
	}	

	function save_slide($data) {

		if ($data['cssID']) :
			$this->db->query("UPDATE CoreCommerceCreativeSlides
					SET specs = ?, csID = ?
					WHERE cssID= ?",
					array($data['specs'], $data['csID'], $data['cssID']));
		 elseif ($data['csID']) :
			
			$this->db->query("INSERT INTO CoreCommerceCreativeSlides (specs,csID) VALUES(?,?)", array($data['specs'],$data['csID']));				
		 endif;
		
	}
	function delete_slide ($cssID) {
		$this->db->query("DELETE CoreCommerceCreativeSlides FROM CoreCommerceCreativeSlides WHERE cssID = ?", array($cssID));
	}
	/* 
		Cette fonction devrait être une classe à part entière appellée Slider List et renvoiyer un tableau d'objet slide
	*/
	function get_slides_from_csID ($csID) {

		$all = $this->db->getAll("SELECT cssID, csID, specs  FROM CoreCommerceCreativeSlides WHERE csID = ?", array($csID));
		
		if(count($all)):
			$slides = array();
			foreach ($all as $key => $value) {
				$slides[] = $this->init($value['cssID'], Loader::helper('json')->decode($value['specs']));
			}
			return $slides;
			// Ceci n'est pas très beau mais c'est en attendant de séparer cette classe en deux objet, un pour le slide, l'autre pour la liste
		else :
		 	return false;
		endif;
	}

	function init ($cssID, $slide) {
		// Cette partie ci ne devrait pas exister et etre remplacé par 
		// $this->setPropertiesFromArray($slideProperties);
		$slide->cssID = $cssID;
		$slide->options = explode(',', $slide->options);
		$slide->structure = explode(',', $slide->structure);
		$slide->productsID = explode(',', $slide->productsID);

		// On y incorpore les produits
		Loader::model('product/model', 'core_commerce');
		$slide->products = array();
		foreach ($slide->productsID as $key => $pID) :
			$product = CoreCommerceProduct::getByID($pID);
			if (is_object($product)) $slide->products['product_' . ($key + 1)] = $product;
		endforeach;

		// On retourne le tout bel object.
		return $slide; 
	}

	function getByID ($cssID) {
		$slide = $this->db->getRow("SELECT cssID, csID, specs FROM CoreCommerceCreativeSlides WHERE cssID = ?", array($cssID));
	
		if(count($slide)) return $this->init($slide['cssID'], Loader::helper('json')->decode($slide['specs'])); else return false;

	}	
}
