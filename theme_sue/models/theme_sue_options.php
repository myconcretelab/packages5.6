<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Sue theme Options
 * @category Model
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class ThemeSueOptions extends Object {
	
	var $cObj;

	function __construct () {
		
		$this->db = Loader::db();
		
		$this->config = new Config();
		$pkg = Package::getByHandle("theme_sue");
		$this->config->setPackageObject($pkg);
		
	}
	function set_collection_object($c) {
		$this->cObj = $c;
	}
	function set_toggle_option_name($name) {
		$this->option_name = $name;
	}

	function get_presets_list() {
		$all = $this->db->getAll("SELECT pID, name, creator FROM SueThemePreset");
		if(is_array($all)) return $all; else return false;
	}
	function get_preset_by_id ($pID) {
		$row = $this->db->getRow("SELECT pID, name, creator FROM SueThemePreset WHERE pID=?", array($pID));
		if(is_array($row)) return $row; else return false;
	}
	
	function get_preset_id_by_name ($name) {
		$row = $this->db->getRow("SELECT pID FROM SueThemePreset WHERE name=?", array($name));
		if(is_array($row)) return $row['pID']; else return false;
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
		
		$this->db->query("INSERT INTO SueThemePreset (name,creator,active) VALUES (?,?,?)", array($name, $uID, $active));

		if ($based_on) :
			// Recupere le nouvel ID
			$pID = $this->db->Insert_ID();
			// Duplique toutes les options qui ont comme presetID $based_on et leur donne un nouvel ID base sur celui qui vient d'etre crŽŽ
			$this->db->query("INSERT INTO SueThemeSueOptionsPreset (option_key, option_value, pID)
					  SELECT option_key, option_value, ?
					  FROM SueThemeSueOptionsPreset
					  WHERE pID=?",
					  array($pID, $based_on ));
		endif;
		
	}
	function delete_preset ($pID) {
		/* Ne fonctione pas quand les options d'un preset sont vides
		$this->db->query("DELETE SueThemeSueOptionsPreset, SueThemePreset
				  FROM SueThemeSueOptionsPreset, SueThemePreset
				  WHERE SueThemeSueOptionsPreset.pID = SueThemePreset.pID 
				  AND SueThemePreset.pID = ?
				  ", array($pID));
		*/
		
		$this->db->query("DELETE SueThemeSueOptionsPreset FROM SueThemeSueOptionsPreset WHERE pID = ?", array($pID));
		$this->db->query("DELETE SueThemePreset FROM  SueThemePreset WHERE pID = ?", array($pID));
		
		if ($pID == $this->get_default_pID()) $this->set_default_pID(1);
		
	}
	
	function rename_preset ($name, $pID) {
		$this->db->query("UPDATE SueThemePreset
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

	/*******************************
	 * Options
	 * *****************************/

	function get_options_from_preset_ID ($pID) {
		$all = $this->db->getAll("SELECT option_key, option_value FROM SueThemeSueOptionsPreset WHERE pID=?", array($pID));
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
		$value = $this->db->getOne("SELECT option_value FROM SueThemeSueOptionsPreset WHERE option_key=? AND pID = ?", array($key,$pID));
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SueThemeSueOptionsPreset WHERE option_key=? AND pID = ?", array($key,$this->get_default_pID()));			
		}
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SueThemeSueOptionsPreset WHERE option_key=? AND pID = ?", array($key,1));			
		}

		return $value;
	}
	
	
	function save_options ($data, $pID) {

		foreach ($data as $k=>$v):
			if ( $this->db->GetOne("SELECT * FROM SueThemeSueOptionsPreset WHERE option_key = ? AND pID= ?", array($k, $pID))) :
				$this->db->query("UPDATE SueThemeSueOptionsPreset
						SET option_value=?
						WHERE option_key = ? AND pID= ?",
						array( $v, $k, $pID));
			 else :
				$this->db->query("INSERT INTO SueThemeSueOptionsPreset
						(option_key, option_value, pID)
						VALUES(?,?,?)
						", array( $k, $v, $pID));				
			 endif;
		endforeach;
		
		//Cache::delete('sue_style',false );
		Cache::flush();
	}
	
	public function __get($name) {
		return call_user_func_array(array($this, $name),array());

	}
	
	public function __call($n,$a) {
		
		if (substr($n,0,1) != '_')  return;
		else $n = substr($n,1);
		
		if (method_exists($this, $n)) {
			$this->$n($a[0]);
			return;
		}

		$page = isset($a[1]) ? $a[1] : $this->cObj ;
		$cpID = false;

		if (is_object($page)) :
			if (get_class($page) == 'Page') {
				$cpID = $page->getAttribute('sue_theme_preset_options'); // getCollectionAttributeValue;
			};
		endif;

		$pID = $cpID ? $cpID : $this->get_default_pID();
		
		$value = Cache::get('sue_option_' . $n , $pID );

		if (!$value) :
			if (substr($n,0,1) == '_') :
				if (is_string($a[0])) : // le deuxime parametre peut etre un autre nom de tableau que 'options'
				    $array = explode(',', $this->get_option_value($a[0],$pID));
				elseif (isset($this->option_name)) :
				    $array = explode(',', $this->get_option_value($this->option_name,$pID));
				else :
				    $array = explode(',', $this->get_option_value('options',$pID));
				endif;
				$value = in_array(substr($n,1),$array);
			else :
				$value = $this->get_option_value($n,$pID);
			endif;
		endif;
	
		Cache::set('sue_option_' . $n,$pID , $value );
		
		if (isset($a[1]) ) echo $value;
			else return $value;
	}
	
	/*******************************
	 * Options Reset & install
	 * *****************************/
	
	function reset_options ($pID) {

		$name = $this->get_preset_title($pID);
		$this->save_options($this->get_default_values_array($name), $pID);
	}
	
	function install_db ($theme = null) {

		$user = new User();
		$defaultvalues = $this->get_default_values_array();
		$i = 1 ;

		foreach ($defaultvalues as $name => $valuearray) {
			$this->save_preset($name, $user->getUserID(),false, true);
			$this->save_options($this->get_default_values_array($name), $i);
			$i++;
		}
		if (!$theme) $theme = 'Plain_blue';
		$this->set_default_pID($this->get_preset_id_by_name($theme));
		
	}
	
	function print_db () {
		$query =  "SELECT option_key, option_value FROM SueThemeSueOptionsPreset";
		$result = Loader::db()->getAll($query);
		
		foreach ($result as $r) {
			echo "'" . $r['option_key'] . "' => '" . $r['option_value'] . "',\n";
		}
		
	}
	
	function get_default_values_array ($default = null) {
		$defaultdb = array (
			'Turquoise' => array(
	  			'options' => 'display_page_title,|,display_page_desc,|,display_breadcrumb,|,display_searchbox,|,hide_searchbox_on_mobile,|,|,dynamic_columns,|,display_footer,|','display_footer_column' => '3','colors' => 'header_color_enabled,|,typo_color_enabled,|,top_nav_color_enabled,|','h_link_color' => '#64dfdf','h_hover_color' => '#64dfdf','h_visited_color' => '#64dfdf','h1_color' => '#0C3F3F','h2_color' => '#0C3F3F','h3_color' => '#0C3F3F','h4_color' => '#0C3F3F','h5_color' => '#0C3F3F','p_color' => '#A7B7B7','a_color' => '#64dfdf','a_hover_color' => '#687E8C','a_visited_color' => '#1AFDFD','bg_left_sidebar_title' => 'blue_dark','left_sidebar_title_color' => '#eee','left_sidebar_title_link_color' => '#eef','bg_right_sidebar_title' => 'blue_dark','right_sidebar_title_color' => '#eee','right_sidebar_title_link_color' => '#eef','bg_button' => 'button_blue','bg_button_hover' => 'button_black','button_text_color' => '#ffffff','button_text_hover_color' => '#ffffff','nav_first_level_color' => '#ffffff','nav_second_level_color' => '#eee','nav_third_level_color' => '#eee','nav_selected_color' => '#697073','nav_background_selected_color' => '#eee','page_list' => 'display_meta_creator,page_list_description,page_list_title,display_meta_creator_link,display_meta_tag,display_meta_comments,display_meta_date,page_list_read_more_button,page_list_read_more,page_list_crop,page_list_1_two_column,page_list_1_title,page_list_1_description,page_list_1_shadow,page_list_1_bullets,page_list_1_arrows,page_list_1_autoscroll,page_list_navi_title,page_list_navi_description,page_list_navi_bullets,page_list_navi_arrows,page_list_navi_autoscroll,sort_category,sort_alphabetical','page_list_read_more_text' => 'Read More','jpg_quality' => '90','page_list_1_image_width' => '960','page_list_1_image_height' => '366','page_list_1_interval' => '1010','page_list_1_scroll_speed' => '400','page_list_navi_interval' => '3000','page_list_navi_scroll_speed' => '400','bg_top_color' => '#464f5c','bg_top_pattern' => 'square_light','bg_top_height' => '250','bg_top_custom' => '0','bg_top_shadow' => '7_bottom','background' => 'bg_top_light','bg_body_color' => '#ffffff','bg_body_pattern' => 'solar','bg_body_custom' => '0','bg_main_color' => '#ffffff','bg_sidebar_color' => '#f8f9f8','bg_nav_color' => '#64dfdf','bg_second_nav_color' => '#64dfdf','bg_nav_light' => 'ultra_light','bg_footer_color' => '#464f5c','bg_footer_page_color' => '#464f5c','bg_footer_pattern' => 'square_light','bg_footer_custom' => '0','bg_footer_shadow' => '7_top','bg_main_nav_color' => '#64dfdf','ccm-submit-saved' => 'Save !','main_color' => '#64dfdf','bg_header_color' => '#ffffff','button_bg_color' => '#A7B7B7','button_bg_hover_color' => '#64dfdf','slider' => 'page_list_read_more,|,page_list_crop,|,background_animation,|,page_list_1_title,|,page_list_1_meta,|,page_list_1_description,|,page_list_1_bullets,|,page_list_1_arrows,|,page_list_1_autoscroll,|,page_list_3_title,|,page_list_3_description,|,page_list_3_bullets,|,|,page_list_3_slideshow,|,easy_slider_bullets,|,easy_slider_arrows,|,easy_slider_autoscroll,|','sliders_read_more_text' => 'Go','background_file' => '0','page_list_3_interval' => '1000','page_list_3_scroll_speed' => '550','page_list_3_image_height' => '320','easy_slider_interval' => '1000','easy_slider_scroll_speed' => '400','button_style' => '0'
			),
			'Plain_blue' => array(
			  'options'=> 'display_page_title,|,display_page_desc,|,display_breadcrumb,|,display_searchbox,|,hide_searchbox_on_mobile,|,|,enable_mobile,|,display_footer,|','display_footer_column'=> '3','colors'=> 'header_color_enabled,|,typo_color_enabled,|,top_nav_color_enabled,|','h_link_color'=> '#75b1bc','h_hover_color'=> '#75b1bc','h_visited_color'=> '#75b1bc','h1_color'=> '#45494c','h2_color'=> '#45494c','h3_color'=> '#45494c','h4_color'=> '#45494c','h5_color'=> '#45494c','p_color'=> '#45494c','a_color'=> '#75b1bc','a_hover_color'=> '#64dfdf','a_visited_color'=> '#75b1bc','bg_left_sidebar_title'=> 'blue_dark','left_sidebar_title_color'=> '#eee','left_sidebar_title_link_color'=> '#eef','bg_right_sidebar_title'=> 'blue_dark','right_sidebar_title_color'=> '#eee','right_sidebar_title_link_color'=> '#eef','bg_button'=> 'button_blue','bg_button_hover'=> 'button_black','button_text_color'=> '#ffffff','button_text_hover_color'=> '#ffffff','nav_first_level_color'=> '#dfe9ec','nav_second_level_color'=> '#dfe9ec','nav_third_level_color'=> '#dfe9ec','nav_selected_color'=> '#45494c','nav_background_selected_color'=> '#dfe9ec','page_list'=> 'display_meta_creator,page_list_description,page_list_title,display_meta_creator_link,display_meta_tag,display_meta_comments,display_meta_date,page_list_read_more_button,page_list_read_more,page_list_crop,page_list_1_two_column,page_list_1_title,page_list_1_description,page_list_1_shadow,page_list_1_bullets,page_list_1_arrows,page_list_1_autoscroll,page_list_navi_title,page_list_navi_description,page_list_navi_bullets,page_list_navi_arrows,page_list_navi_autoscroll,sort_category,sort_alphabetical','page_list_read_more_text'=> 'Read More','jpg_quality'=> '90','page_list_1_image_width'=> '960','page_list_1_image_height'=> '250','page_list_1_interval'=> '1010','page_list_1_scroll_speed'=> '400','page_list_navi_interval'=> '3000','page_list_navi_scroll_speed'=> '400','bg_top_color'=> '#464f5c','bg_top_pattern'=> 'square_light','bg_top_height'=> '250','bg_top_custom'=> '0','bg_top_shadow'=> '7_bottom','background'=> 'bg_top_light','bg_body_color'=> '#dfe9ec','bg_body_pattern'=> 'solar','bg_body_custom'=> '0','bg_main_color'=> '#ffffff','bg_sidebar_color'=> '#f8f9f8','bg_nav_color'=> '#64dfdf','bg_second_nav_color'=> '#64dfdf','bg_nav_light'=> 'ultra_light','bg_footer_color'=> '#464f5c','bg_footer_page_color'=> '#464f5c','bg_footer_pattern'=> 'square_light','bg_footer_custom'=> '0','bg_footer_shadow'=> '7_top','bg_main_nav_color'=> '#64dfdf','ccm-submit-saved'=> 'Save !','main_color'=> '#75b1bc','bg_header_color'=> '#45494c','button_bg_color'=> '#A7B7B7','button_bg_hover_color'=> '#75b1bc','slider'=> 'page_list_read_more,|,page_list_crop,|,background_animation,|,page_list_1_title,|,page_list_1_meta,|,page_list_1_description,|,page_list_1_bullets,|,page_list_1_arrows,|,page_list_1_autoscroll,|,page_list_3_title,|,page_list_3_description,|,page_list_3_bullets,|,|,page_list_3_slideshow,|,easy_slider_bullets,|,easy_slider_arrows,|,easy_slider_autoscroll,|','sliders_read_more_text'=> 'Go','background_file'=> '0','page_list_3_interval'=> '1000','page_list_3_scroll_speed'=> '100','page_list_3_image_height'=> '320','easy_slider_interval'=> '1000','easy_slider_scroll_speed'=> '400','button_style'=> '0','h_footer_color'=> '#dfe9ec','p_footer_color'=> '#dfe9ec', 'bg_plain_color' =>'#ffffff'
			),
			'Black' => array(
			  'options' => 'display_page_title,|,display_page_desc,|,display_breadcrumb,|,display_searchbox,|,hide_searchbox_on_mobile,|,|,dynamic_columns,|,display_footer,|','display_footer_column' => '3','colors' => 'header_color_enabled,|,typo_color_enabled,|,top_nav_color_enabled,|','h_link_color' => '#558188','h_hover_color' => '#78b7ba','h_visited_color' => '#78b7ba','h1_color' => '#C5C4C4','h2_color' => '#C5C4C4','h3_color' => '#C5C4C4','h4_color' => '#C5C4C4','h5_color' => '#C5C4C4','p_color' => '#e3e3e3','a_color' => '#619499','a_hover_color' => '#78b7ba','a_visited_color' => '#619499','bg_left_sidebar_title' => 'blue_dark','left_sidebar_title_color' => '#eee','left_sidebar_title_link_color' => '#eef','bg_right_sidebar_title' => 'blue_dark','right_sidebar_title_color' => '#eee','right_sidebar_title_link_color' => '#eef','bg_button' => 'button_blue','bg_button_hover' => 'button_black','button_text_color' => '#697073','button_text_hover_color' => '#697073','nav_first_level_color' => '#e3e3e3','nav_second_level_color' => '#e3e3e3','nav_third_level_color' => '#e3e3e3','nav_selected_color' => '#ffffff','nav_background_selected_color' => '#eee','page_list' => 'display_meta_creator,page_list_description,page_list_title,display_meta_creator_link,display_meta_tag,display_meta_comments,display_meta_date,page_list_read_more_button,page_list_read_more,page_list_crop,page_list_1_two_column,page_list_1_title,page_list_1_description,page_list_1_shadow,page_list_1_bullets,page_list_1_arrows,page_list_1_autoscroll,page_list_navi_title,page_list_navi_description,page_list_navi_bullets,page_list_navi_arrows,page_list_navi_autoscroll,sort_category,sort_alphabetical','page_list_read_more_text' => 'Read More','jpg_quality' => '90','page_list_1_image_width' => '960','page_list_1_image_height' => '366','page_list_1_interval' => '1010','page_list_1_scroll_speed' => '400','page_list_navi_interval' => '3000','page_list_navi_scroll_speed' => '400','bg_top_color' => '#464f5c','bg_top_pattern' => 'square_light','bg_top_height' => '250','bg_top_custom' => '0','bg_top_shadow' => '7_bottom','background' => 'bg_top_light','bg_body_color' => '#2F2B2B','bg_body_pattern' => 'points_for_black','bg_body_custom' => '0','bg_main_color' => '#ffffff','bg_sidebar_color' => '#f8f9f8','bg_nav_color' => '#64dfdf','bg_second_nav_color' => '#64dfdf','bg_nav_light' => 'ultra_light','bg_footer_color' => '#464f5c','bg_footer_page_color' => '#464f5c','bg_footer_pattern' => 'square_light','bg_footer_custom' => '0','bg_footer_shadow' => '7_top','bg_main_nav_color' => '#64dfdf','ccm-submit-saved' => 'Save !','main_color' => '#575556','bg_header_color' => '#2F2B2B','button_bg_color' => '#bbbbbb','button_bg_hover_color' => '#dddddd','slider' => 'page_list_read_more,|,page_list_crop,|,background_animation,|,page_list_1_title,|,page_list_1_meta,|,page_list_1_description,|,page_list_1_bullets,|,page_list_1_arrows,|,page_list_1_autoscroll,|,page_list_3_title,|,page_list_3_description,|,page_list_3_bullets,|,|,page_list_3_slideshow,|,easy_slider_bullets,|,easy_slider_arrows,|,easy_slider_autoscroll,|','sliders_read_more_text' => 'Go','background_file' => '0','page_list_3_interval' => '1000','page_list_3_scroll_speed' => '550','page_list_3_image_height' => '320','easy_slider_interval' => '1000','easy_slider_scroll_speed' => '400','button_style' => '0','bg_plain_color' => '#3b3b3b','h_footer_color' => '#558188','p_footer_color' => '#bbbbbb'
			)
		);

		if ($default && is_array($defaultdb[$default])) {
			return $defaultdb[$default]; 
		} else {
			return $defaultdb;}
		}
	

}

