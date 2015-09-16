<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardThemeSuperMintOptionsOptionsPresetsController extends DashboardBaseController {
	
	public $helpers = array('form'); //makes form helper available to the single_page
	
	function __construct() {
		Loader::model('theme_super_mint_options', 'theme_super_mint');
		$this->poh = new ThemeSuperMintOptions;

		$u = new User();
		$this->uID = $u->getUserID();
	}

	function view() {
		
		$this->set('poh',$this->poh);
		$this->set('list',  $this->poh->get_presets_list());
		
		$this->set('ih', Loader::helper("concrete/interface"));

		Loader::helper('theme_file', 'theme_super_mint');
		$path = Package::getByHandle('theme_super_mint')->getPackagePath();
		$js_files = ThemeFileHelper::dir_walk($path . '/js/', array('js'));
		$css_files = ThemeFileHelper::dir_walk($path . '/css/', array('css'));
		
				
		// Include all js file from package/js
		$html = Loader::helper('html');

		if (is_array($js_files)) :
			foreach ($js_files as $js) :
				$this->addHeaderItem($html->javascript($js, 'theme_super_mint'));
			endforeach;
		endif;
		
		// Include all css file from package/css
		if (is_array($css_files)) :
			foreach ($css_files as $css) :
				$this->addHeaderItem($html->css($css, 'theme_super_mint'));
			endforeach;
		endif;
		
		
	}
	
	function save_preset() {
		if ($_POST['name'] != '') :
			$this->poh->save_preset( htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') , $this->uID, $_POST['preset_id']);
			$this->set('message', t('Preset created !'));
			$this->view();
		else:
			$this->error->add(t('Error, the name is empty'));
//			$this->set('message', );
			$this->view();		
		endif;

		$this->view();
	}
	function edit_preset() {
		if ($pID = $this->retrieve_id('preset_to_delete_')) {
			$this->poh->delete_preset($pID);
			$this->set('message', t('Preset deleted !'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('preset_to_rename_')) {
			if ($_POST['rename_' . $pID] == '') {
				$this->error->add(t('Error, the name is empty'));
				$this->view();
				return;
			}
			$this->poh->rename_preset($_POST['rename_' . $pID] , $pID);
			$this->set('message', t('Preset renamed !'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('set_as_default_')) {
			$this->poh->set_default_pID($pID);
			$title = $this->poh->get_preset_title($pID);
			$this->set('message', t('Preset set as default'));
			$this->view();
		}
		if ($pID = $this->retrieve_id('preset_to_reset_')) {
			$success = $this->poh->reset_options($pID);
			if (!$success['error'])
				$this->set('message', 'Preset reseted with starting values');
			else 
				$this->error->add('Reset error : ' . $success['message']);
			$this->view();
		}
		$this->view();
		
	}
	
	function retrieve_id ($expr) {
		$expression = '/^' . $expr . '(.+)$/';
		$unextracted_rows = array_merge(array(),preg_grep($expression, array_keys($_POST)));
		preg_match($expression, $unextracted_rows[0], $row_matches);
		return $row_matches[1];
		
	}

	function import_preset () {
		
		$uploadfile = DIR_FILES_UPLOADED_STANDARD . '/' . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			$success = $this->poh->importXML_preset($uploadfile);
			if (!$success['error'])
				$this->set('message', 'Preset imported successfully');
			else 
				$this->error->add('File error : ' . $success['message']);

			$this->view();


		} else {
			$this->error->add(t('Error the file doesn\'t work : ' . $uploadfile . print_r($_FILES)));
			$this->view();
		}



	}
	
}
