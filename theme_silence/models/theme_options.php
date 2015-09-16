<?php       defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Silence theme Options
 * @category Model
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class ThemeOptions extends Object {
	
	var $cObj;

	function __construct ($c = null) {
		
		$this->db = Loader::db();
		
		$this->config = new Config();
		$pkg = Package::getByHandle("theme_silence");
		$this->config->setPackageObject($pkg);

		// On attribue toute les options
		$this->init($c);		
		
	}
	function init ($c, $booleans = array('options','colors','background','page_list')) {
		// Si on reçoit une page on regle les infos
		if ($c) : 
			$this->cObj = $c;
			$this->pID = $this->get_active_pID();
			// On attribue toute les options à cet objet
			$this->setPropertiesFromArray($this->get_options_from_preset_ID($this->pID));
		endif;
		//print_r($this);
		// On atribue les nom d'options pour lesquelles les valeur sont 
		// des chaine de caractère à transformer en tableau
		foreach ($booleans as $key => $value) {
			$this->$value = explode(',|,', $this->$value);
			// On refait un tour parce qu'il reste parfois encore des "|,"
			foreach ($this->$value as &$opt) :
				$opt = str_replace(array(',','|'), '', $opt);
				//var_dump($opt);
			endforeach;
		}


	
	}	
	function set_collection_object($c) {
		$this->cObj = $c;
	}
	function set_toggle_option_name($name) {
		$this->option_name = $name;
	}

	function get_presets_list() {
		$all = $this->db->getAll("SELECT pID, name, creator FROM SilenceThemePreset");
		if(is_array($all)) return $all; else return false;
	}
	function get_preset_by_id ($pID) {
		$row = $this->db->getRow("SELECT pID, name, creator FROM SilenceThemePreset WHERE pID=?", array($pID));
		if(is_array($row)) return $row; else return false;
	}
	
	
	function output_presets_list ($echo = false, $selected=null, $name = 'preset_id', $before = array()) {

		$list = $this->get_presets_list ();

		if ($list) :
			$r[] = '<select name="' . $name . '" id="' . $name . '" class="' . $name . '">';
			if (count($before)) :
				foreach($before as $k=>$option ) :
					$r[] = '<option value="' . -($k) . '">' . $option . '</option>';
				endforeach;
			endif;
			$default_pID = $this->get_default_pID();
			foreach($list as $k=>$p) :

				$text = ($p['pID'] == $default_pID) ? t(' (default)') : '' ;
				$select = ($p['pID'] == $selected ) ? 'selected' : '';

				$r[] = "<option value='{$p['pID']}' $select >{$p['name']}$text</option>";

			endforeach;
			
			$r[] = '</select>';
			$r = implode("\r" , $r);
			
			if ($echo) 	echo $r;
			else 		return $r;
		
		else:
			return false;
		endif;
		
	}
	
	function update () {

	}

	function save_preset($name, $uID, $based_on = false, $active = false) {
		
		$this->db->query("INSERT INTO SilenceThemePreset (name,creator,active) VALUES (?,?,?)", array($name, $uID, $active));

		if ($based_on) :
			// Recupere le nouvel ID
			$pID = $this->db->Insert_ID();
			// Duplique toutes les options qui ont comme presetID $based_on et leur donne un nouvel ID base sur celui qui vient d'etre crŽŽ
			$this->db->query("INSERT INTO SilenceThemeOptionsPreset (option_key, option_value, pID)
					  SELECT option_key, option_value, ?
					  FROM SilenceThemeOptionsPreset
					  WHERE pID=?",
					  array($pID, $based_on ));
		endif;
		
	}
	function delete_preset ($pID) {
		/* Ne fonctione pas quand les options d'un preset sont vides
		$this->db->query("DELETE SilenceThemeOptionsPreset, SilenceThemePreset
				  FROM SilenceThemeOptionsPreset, SilenceThemePreset
				  WHERE SilenceThemeOptionsPreset.pID = SilenceThemePreset.pID 
				  AND SilenceThemePreset.pID = ?
				  ", array($pID));
		*/
		
		$this->db->query("DELETE SilenceThemeOptionsPreset FROM SilenceThemeOptionsPreset WHERE pID = ?", array($pID));
		$this->db->query("DELETE SilenceThemePreset FROM  SilenceThemePreset WHERE pID = ?", array($pID));
		
		if ($pID == $this->get_default_pID()) $this->set_default_pID(1);
		
	}
	
	function rename_preset ($name, $pID) {
		$this->db->query("UPDATE SilenceThemePreset
				 SET name = ?
				 WHERE pID = ?",
				 array( $name, $pID));
		
	}
	
	function set_default_pID ($pID) {
		$this->config->save('DEFAULT_THEME_PRESET', $pID);		
	}
	function get_default_pID () {
		return $this->config->get('DEFAULT_THEME_PRESET');		
	}
	function get_default_preset_title() {
		$p = $this->get_preset_by_id($this->get_default_pID());
		return $p['name'];
	}
	function get_preset_title($pID) {
		$p = $this->get_preset_by_id($pID);
		return $p['name'];
	}
	function get_active_pID ($c = null) {
		// On regarde si il y a un get
		if ($_GET['theme_preset']) :
			// Si cet ID est valable
			if ($this->get_preset_by_id($_GET['theme_preset'])) :
				// On retourne celui-ci
				return $_GET['theme_preset'];
				endif;
		endif;
		// On regarde quell objet page prendre
		$page = $c ? $c : $this->cObj;
		// On tente de reécupérer la valeur de l'attribut
		if (is_object($page)) :
			if (get_class($page) == 'Page') {
				$cpID = $page->getAttribute('theme_preset_options'); // getCollectionAttributeValue;
			};
		endif;
		// On retourne la valeur de l'attribut, sinon le preset par défault
		return $cpID ? $cpID : $this->get_default_pID();		
	}
	/*******************************
	 * Options
	 * *****************************/

	function get_options_from_preset_ID ($pID) {
		$all = $this->db->getAll("SELECT option_key, option_value FROM SilenceThemeOptionsPreset WHERE pID=?", array($pID));
		if(is_array($all)) {
			$r = array();
			foreach($all as $o) {
				$r[$o['option_key']] = $o['option_value'];
			}
			return $r;
		}
		return false;
	}
	
	function get_option_value ($key, $pID) {
		$value = $this->db->getOne("SELECT option_value FROM SilenceThemeOptionsPreset WHERE option_key=? AND pID = ?", array($key,$pID));
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SilenceThemeOptionsPreset WHERE option_key=? AND pID = ?", array($key,$this->get_default_pID()));			
		}
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SilenceThemeOptionsPreset WHERE option_key=? AND pID = ?", array($key,1));			
		}

		return $value;
	}
	
	
	function save_options ($data, $pID) {

		foreach ($data as $k=>$v):
			if ( $this->db->GetOne("SELECT * FROM SilenceThemeOptionsPreset WHERE option_key = ? AND pID= ?", array($k, $pID))) :
				$this->db->query("UPDATE SilenceThemeOptionsPreset
						SET option_value=?
						WHERE option_key = ? AND pID= ?",
						array( $v, $k, $pID));
			 else :
				$this->db->query("INSERT INTO SilenceThemeOptionsPreset
						(option_key, option_value, pID)
						VALUES(?,?,?)
						", array( $k, $v, $pID));				
			 endif;
		endforeach;
		
		//Cache::delete('silence_style',false );
		Cache::flush();
	}
	
	public function __get($name) {
		return call_user_func_array(array($this, $name),array());

	}
	
	public function __call($n,$a) {
		// Cette fonction est depréciée. 
		// elle peut être utile pour les options en tableau qu'il faut transformer
		
		// On retire le _ qui se trouve au debut de la demande
		if (substr($n,0,1) == '_') $n = substr($n,1);
		
		// Je ne sais pas si ça sert à quelque chose ??
		if (method_exists($this, $n)) {
			$this->$n($a[0]);
			return;
		}
		// Maintenant on regarde si cette valeur est réglée pour cette objet 
		// Si oui, on la renvoie
		if (isset($this->$n)) :
			return $this->$n;
		endif;
		// Si le premier argument a déjà été transformée en tableau
		if (isset($this->$a[0]) && is_array($this->$a[0]))
			// Si c'est un tableau on revoi si la variable est ds le tableau
			return in_array($n, $this->$a[0]);
		// Sinon la valeur

		// Maintenant, si il y a encore un underscore devant, on transforme le resultat en tableau

		if (substr($n,0,1) == '_') :

			if (is_string($a[0]) && !is_array($this->$a[0])) : // le deuxieme parametre peut etre un autre nom de tableau que 'options'
			    $array = explode(',', $this->$a[0]);
			elseif (is_string($a[0]) && is_array($this->$a[0])):
				// On retourne si il est dans le tableau déjà etabli
				// Ce cas de figure devrait être impossible à réaliser
				return in_array(substr($n,1),$this->$a[0]);
			// Ancien système    
			elseif (isset($this->option_name)) :
				// La valeur de l'option (page_list par ex)
				$option_name = $this->option_name;
				// La valeur de l'option a deja ete change en tableau normalement
				if (is_array($this->$option_name)) // Mais cette ligne cause une erreur fatale ..
					return in_array(substr($n,1),$this->$option_name);
				else
					return false;
			// Si les options on déjà été transformé en tableau
			elseif (is_Array($this->options)) :
				return in_array(substr($n,1),$this->options);	
			// Sinon,; toutesfin, on transforme en tableau l'option 'options'
			else :
			    $array = explode(',', $this->options);
			endif;
			// On regarde si la variable est dans le tableau
			return in_array(substr($n,1),$array);
		endif;

		return false;
	}
	
	/*******************************
	 * Options Reset & install
	 * *****************************/
	
	function reset_options ($pID = 1) {

		$this->save_options($this->get_default_values_array(), $pID);
	}
	
	function install_db () {

		$user = new User();
		
		$this->save_preset('Base',$user->getUserID(),false, true);
		
		$this->save_options($this->get_default_values_array(), 1);
		
		$this->set_default_pID(1);
		
	}
	
	function get_default_values_array ($pID = 1) {
		return array(
			'options' => 'display_page_title,display_page_desc,display_breadcrumb,display_searchbox,header_transparent,display_main_area,display_footer,dynamic_columns',
			'display_footer_column' => '3',
			'colors' => 'header_color_enabled,typo_color_enabled,top_nav_color_enabled,top_nav_shadow_enabled',
			'h_link_color' => '#004d60',
			'h_hover_color' => '#004d60',
			'h_visited_color' => '#004d60',
			'h1_color' => '#00728F',
			'h2_color' => '#00728F',
			'h3_color' => '#00728F',
			'h4_color' => '#00728F',
			'h5_color' => '#00728F',
			'p_color' => '#545454',
			'a_color' => '#418ef4',
			'a_hover_color' => '#418ef4',
			'a_visited_color' => '#418ef4',
			'bg_left_sidebar_title' => 'blue_dark',
			'left_sidebar_title_color' => '#eee',
			'left_sidebar_title_link_color' => '#eef',
			'bg_right_sidebar_title' => 'blue_dark',
			'right_sidebar_title_color' => '#eee',
			'right_sidebar_title_link_color' => '#eef',
			'bg_button' => 'button_blue',
			'bg_button_hover' => 'button_black',
			'button_text_color' => '#eeeeee',
			'button_text_hover_color' => '#eeeeee',
			'nav_first_level_color' => '#eee',
			'nav_second_level_color' => '#eee',
			'nav_third_level_color' => '#eee',
			'nav_selected_color' => '#eee',
			'nav_background_selected_color' => '#eee',
			'page_list' => 'display_meta_creator,page_list_description,page_list_title,display_meta_creator_link,display_meta_tag,display_meta_comments,display_meta_date,page_list_read_more_button,page_list_read_more,page_list_crop,page_list_1_two_column,page_list_1_title,page_list_1_description,page_list_1_shadow,page_list_1_bullets,page_list_1_arrows,page_list_1_autoscroll,page_list_navi_title,page_list_navi_description,page_list_navi_bullets,page_list_navi_arrows,page_list_navi_autoscroll,sort_category,sort_alphabetical',
			'page_list_read_more_text' => 'Read More',
			'jpg_quality' => '90',
			'page_list_1_image_width' => '600',
			'page_list_1_image_height' => '350',
			'page_list_1_interval' => '3000',
			'page_list_1_scroll_speed' => '400',
			'page_list_navi_interval' => '3000',
			'page_list_navi_scroll_speed' => '400',
			'bg_top_color' => '#464f5c',
			'bg_top_pattern' => 'square_light',
			'bg_top_height' => '250',
			'bg_top_custom' => '0',
			'bg_top_shadow' => '7_bottom',
			'background' => 'bg_top_light',
			'bg_body_color' => '#efefef',
			'bg_body_pattern' => 'noise_light',
			'bg_body_custom' => '0',
			'bg_main_color' => '#ffffff',
			'bg_sidebar_color' => '#f8f9f8',
			'bg_nav_color' => '#464f5c',
			'bg_second_nav_color' => '#464f5c',
			'bg_nav_light' => 'ultra_light',
			'bg_footer_color' => '#464f5c',
			'bg_footer_page_color' => '#464f5c',
			'bg_footer_pattern' => 'square_light',
			'bg_footer_custom' => '0',
			'bg_footer_shadow' => '7_top'
		);
	
	}
	

}

