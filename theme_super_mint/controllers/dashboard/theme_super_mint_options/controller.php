<?php   
defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @package SuperMint theme Options
 * @category Controller
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class DashboardThemeSuperMintOptionsController extends DashboardBaseController {

	function __construct() {
		Loader::model('theme_super_mint_options', 'theme_super_mint');
		$this->poh = new ThemeSuperMintOptions;
	}


	function view() {
		//$this->set('post', $_POST);
		if ($this->c->cPath == '/dashboard/theme_super_mint_options') $this->redirect('/dashboard/theme_super_mint_options/theme_options');

		$this->set('poh', $this->poh);
		Loader::helper('options_generator', 'theme_super_mint');
		
		if 	(isset($_POST['preset_id']) ) :
				$this->set('pID', $_POST['preset_id']);
		elseif 	(isset($_POST['preset_edited']) ) :
				$this->set('pID', $_POST['preset_edited']);
		else :
				$this->set('pID', $this->poh->get_default_pID());
		endif;			
			

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
	
	function save_options($POST = null) {
		Cache::flush();
		$POST = $POST ? $POST : $_POST;
		$data = array();
		foreach ($POST as $key=>$value) :
			if (is_array($value) && substr($key,-7) == '_toggle' ) :
				$data[substr_replace($key,'',-7)] = implode(',',$value); // remove and implode check box under name $key
			elseif (is_array($value)) :
				$data[$key] = implode(',',$value);
			elseif ($key == 'preset_edited') :
				$pID = $value;	// get the pID of options edited
			else :
				$data[$key] = $value;
			endif;
		endforeach;
		
		array_pop($data); // Delete the submit value
		
		if (isset($pID)):
			$this->poh->save_options($data,$pID);
			$this->set('message', t('Options saved !'));
			$this->view();
		else :
			$this->error->add(t('Unable to save options.'));
			$this->view();		
		endif;
		
	}
}