<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_super_mint_options');

class DashboardThemeSuperMintOptionsColorsController extends DashboardThemeSuperMintOptionsController {

    function view() {
        
        parent::view();

        if (!is_dir(DIR_FILES_CACHE . '/theme_super_mint')) {
            if (!mkdir(DIR_FILES_CACHE . '/theme_super_mint')) {
		$this->error->add(t('Warning! Your directory "files/cache" is not writtable by the server. Some backgrounds will be invisible ! '));                
            }
        }
        
        $fh = Loader::helper('theme_file', 'theme_super_mint');
        $packagePath = Package::getByHandle('theme_super_mint')->getPackagePath();

        $pattern_list = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_patterns/');
        if (!$pattern_list) {
            $pattern_list = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/patterns/');
            
        }
        $this->set('pattern_list', $pattern_list);

                
    }
    function save_options() {

        $fh = Loader::helper('theme_file', 'theme_super_mint');

        if (is_dir(DIR_FILES_CACHE . '/theme_super_mint')) {
            // must delete DIR_FILES_CACHE . '/theme_super_mint' but it is forbidden by C5..
        }
        
        parent::save_options($_POST);
    }
    
}
