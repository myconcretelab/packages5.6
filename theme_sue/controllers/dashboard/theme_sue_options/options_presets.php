<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardThemeSueOptionsOptionsPresetsController extends DashboardBaseController {
	
	public $helpers = array('form'); //makes form helper available to the single_page
	
	function __construct() {
		Loader::model('theme_sue_options', 'theme_sue');
		$this->poh = new ThemeSueOptions;

		$u = new User();
		$this->uID = $u->getUserID();
	}

	function view() {


		
		$this->set('poh',$this->poh);
		$this->set('list',  $this->poh->get_presets_list());
		
		$this->set('ih', Loader::helper("concrete/interface"));

		// Include all css file from package/css
		Loader::helper('theme_file', 'theme_sue');
		$path = Package::getByHandle('theme_sue')->getPackagePath();
		$html = Loader::helper('html');
		$css_files = ThemeFileHelper::dir_walk($path . '/css/', array('css'));
		if (is_array($css_files)) :
			foreach ($css_files as $css) :
				$this->addHeaderItem($html->css($css, 'theme_sue'));
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
			$this->poh->reset_options($pID);
			$this->set('message', t('Preset reseted with starting values'));
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
	
}
