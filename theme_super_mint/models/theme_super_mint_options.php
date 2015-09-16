<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package SuperMint theme Options
 * @category Model
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class ThemeSuperMintOptions extends Object {
	
	var $cObj;

	function __construct ($c = null) {
		
		$this->db = Loader::db();
		
		$this->config = new Config();
		$pkg = Package::getByHandle("theme_super_mint");
		$this->config->setPackageObject($pkg);

		// On attribue toute les options
		$this->init($c);

		
	}

	function init ($c, $booleans = array('options','slider','fonts', 'colors')) {
		// Si on reçoit une page on regle les infos
		if ($c || $_GET['theme_preset']) : 
			$this->cObj = $c;
			$this->pID = $this->get_active_pID();
			// On attribue toute les options à cet objet
			$this->setPropertiesFromArray($this->get_options_from_preset_ID($this->pID));
		endif;
		// On atribue les nom d'options pour lesquelles les valeur sont 
		// des chaine de caractère à transformer en tableau
		foreach ($booleans as $key => $value) {
			$this->$value = explode(',', $this->$value);
		}

	
	}
	function set_collection_object($c) {
		$this->init($c);
	}
	function set_toggle_option_name($name) {
		$this->option_name = $name;
	}

	function get_presets_list() {
		$all = $this->db->getAll("SELECT pID, name, creator FROM SuperMintThemePreset");
		if(is_array($all)) return $all; else return false;
	}
	function get_preset_by_id ($pID) {
		$row = $this->db->getRow("SELECT pID, name, creator FROM SuperMintThemePreset WHERE pID=?", array($pID));
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

	function save_preset($name, $uID, $based_on = false, $active = false, $returnID = false) {
		
		$this->db->query("INSERT INTO SuperMintThemePreset (name,creator,active) VALUES (?,?,?)", array($name, $uID, $active));

		if ($returnID) return  $this->db->Insert_ID();
		if ($based_on) :
			// Recupere le nouvel ID
			$pID = $this->db->Insert_ID();
			// Duplique toutes les options qui ont comme presetID $based_on et leur donne un nouvel ID base sur celui qui vient d'etre crŽŽ
			$this->db->query("INSERT INTO SuperMintThemeSuperMintOptionsPreset (option_key, option_value, pID)
					  SELECT option_key, option_value, ?
					  FROM SuperMintThemeSuperMintOptionsPreset
					  WHERE pID=?",
					  array($pID, $based_on ));
		endif;
		
	}
	function delete_preset ($pID) {
		/* Ne fonctione pas quand les options d'un preset sont vides
		$this->db->query("DELETE SuperMintThemeSuperMintOptionsPreset, SuperMintThemePreset
				  FROM SuperMintThemeSuperMintOptionsPreset, SuperMintThemePreset
				  WHERE SuperMintThemeSuperMintOptionsPreset.pID = SuperMintThemePreset.pID 
				  AND SuperMintThemePreset.pID = ?
				  ", array($pID));
		*/
		
		$this->db->query("DELETE SuperMintThemeSuperMintOptionsPreset FROM SuperMintThemeSuperMintOptionsPreset WHERE pID = ?", array($pID));
		$this->db->query("DELETE SuperMintThemePreset FROM  SuperMintThemePreset WHERE pID = ?", array($pID));
		
		if ($pID == $this->get_default_pID()) $this->set_default_pID(1);
		
	}
	
	function rename_preset ($name, $pID) {
		$this->db->query("UPDATE SuperMintThemePreset
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
				$cpID = $page->getAttribute('super_mint_theme_preset_options'); // getCollectionAttributeValue;
			};
		endif;
		// On retourne la valeur de l'attribut, sinon le preset par défault
		return $cpID ? $cpID : $this->get_default_pID();		
	}

	/*******************************
	 * Options
	 * *****************************/

	function get_options_from_preset_ID ($pID) {
		$all = $this->db->getAll("SELECT option_key, option_value FROM SuperMintThemeSuperMintOptionsPreset WHERE pID=?", array($pID));
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
		$value = $this->db->getOne("SELECT option_value FROM SuperMintThemeSuperMintOptionsPreset WHERE option_key=? AND pID = ?", array($key,$pID));
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SuperMintThemeSuperMintOptionsPreset WHERE option_key=? AND pID = ?", array($key,$this->get_default_pID()));			
		}
		
		if (!$value) {
			$value = $this->db->getOne("SELECT option_value FROM SuperMintThemeSuperMintOptionsPreset WHERE option_key=? AND pID = ?", array($key,1));			
		}

		return $value;
	}
	
	
	function save_options ($data, $pID) {

		foreach ($data as $k=>$v):
			if ( $this->db->GetOne("SELECT * FROM SuperMintThemeSuperMintOptionsPreset WHERE option_key = ? AND pID= ?", array($k, $pID))) :
				$this->db->query("UPDATE SuperMintThemeSuperMintOptionsPreset
						SET option_value=?
						WHERE option_key = ? AND pID= ?",
						array( $v, $k, $pID));
			 else :
				$this->db->query("INSERT INTO SuperMintThemeSuperMintOptionsPreset
						(option_key, option_value, pID)
						VALUES(?,?,?)
						", array( $k, $v, $pID));				
			 endif;
		endforeach;
		
		//Cache::delete('super_mint_style',false );
		Cache::flush();
	}

	function getXML_from_pid ($pID){
		Loader::library('sm_array_to_xml','theme_super_mint');
		//http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes/
		$pkg = Package::getByHandle('theme_super_mint');
		$export = array('config' => 
			array(	'theme' => $pkg->getPackageHandle(),
					'version' => $pkg->getPackageVersion(),
					'name' => $this->get_preset_title($pID)
			));
		$export['options'] = $this->get_options_from_preset_ID($pID);
		$exportDOM = SmArrayToXml::createXML('mcl_preset', $export);
		return $exportDOM->saveHTML();
		//return SmArrayToXml::createXML('supermint_preset', $options);
	}

	function importXML_preset ($file, $pID = false) {
		Loader::library('sm_array_to_xml','theme_super_mint');
		$pkg = Package::getByHandle('theme_super_mint');
		$u = new User();
		$content = file_get_contents($file);
		// On teste si le fichier est un XML valide
		if (!$this->is_valid_xml($content)) return array ('error' => true, 'message' => t('This is not a valid preset format'));
		// On cree un STRING du fichier qu'on envoie au transformateur
		$p = SmXmlToArray::createArray($content);
		// On tyest si on a un tableau et qu'il n'est pas vide
		if (is_array($p) && count($p)) :
			// On teste les different conteneurs
			if(count($p['mcl_preset']) && count($p['mcl_preset']['config'] && count($p['mcl_preset']['options']))) :
				$pp = $p['mcl_preset'];
				if ($pkg->getPackageHandle() != $pp['config']['theme']) return array ('error' => true, 'message' => t('This preset in not compatible with this theme'));
				if (!$pID)
					// On cree un nouveau preset et recupère son ID
					$pID = $this->save_preset($pp['config']['name'], $u->getUserID(), false, false, true);
				// Si on a pu avoir un ID
				if ($pID) :
					// On sauve les options pour cet ID
					$this->save_options ($pp['options'], $pID);
					return array ('error' => false, 'message' => t('Preset imported'));
				else :
					return array ('error' => true, 'message' => t('Can’t create new preset'));
				endif;
			else :
				return array ('error' => true, 'message' => t('This file seems to be not a mcl theme preset'));
			endif;
		endif;
	

		/*

			Array
			(
			    [mcl_preset] =&gt; Array
			        (
			            [config] =&gt; Array
			                (
			                    [theme] =&gt; supermint
			                    [version] =&gt; 1.3.1
			                    [name] =&gt; 
			                )

			            [options] =&gt; Array
			                (
			                    [bg_top] =&gt; #AF7A52
			                    ...
			                    [secondary_nav_color] =&gt; #dddddd
			                )

			        )

			)
			*/		


	}

	function is_valid_xml ( $xml ) {
	    libxml_use_internal_errors( true );
	     
	    $doc = new DOMDocument('1.0', 'utf-8');
	     
	    $doc->loadXML( $xml );
	     
	    $errors = libxml_get_errors();
	     
	    return empty( $errors );
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
			    $array = explode(',', $this->$this->option_name);
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

		$path = Package::getByHandle('theme_super_mint')->getPackagePath();
		return $this->importXML_preset ($path . '/models/theme_presets/base.mcl',1);
	}
	
	function install_db () {

		Loader::helper('theme_file', 'theme_super_mint');
		$path = Package::getByHandle('theme_super_mint')->getPackagePath();
		$presets_files = ThemeFileHelper::dir_walk($path . '/models/theme_presets/', array('mcl'));

		if (is_array($presets_files) && count($presets_files)) :
			foreach ($presets_files as $p) :
				$this->importXML_preset ($path . '/models/theme_presets/' . $p);		
			endforeach;
		endif;

		$this->set_default_pID(1);
		
	}
	



}

