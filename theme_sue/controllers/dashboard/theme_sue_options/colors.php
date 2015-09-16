<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_sue_options');

class DashboardThemeSueOptionsColorsController extends DashboardThemeSueOptionsController {

    function view() {
        
        parent::view();

        if (!is_dir(DIR_FILES_CACHE . '/theme_sue')) {
            if (!mkdir(DIR_FILES_CACHE . '/theme_sue')) {
		$this->error->add(t('Warning! Your directory "files/cache" is not writtable by the server. Some backgrounds will be invisible ! '));                
            }
        }
        
        $fh = Loader::helper('theme_file', 'theme_sue');
        $packagePath = Package::getByHandle('theme_sue')->getPackagePath();

        $pattern_list = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_patterns/');
        if (!$pattern_list) {
            $pattern_list = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/patterns/');
            
        }
        $this->set('pattern_list', $pattern_list);

                
    }
    function save_options() {

        $fh = Loader::helper('theme_file', 'theme_sue');

        if (is_dir(DIR_FILES_CACHE . '/theme_sue')) {
            // must delete DIR_FILES_CACHE . '/theme_sue' but it is forbidden by C5..
        }
        
        parent::save_options($_POST);
    }
    
}
