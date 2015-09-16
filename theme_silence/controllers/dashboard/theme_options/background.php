<?php         
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_options');

class DashboardThemeOptionsBackgroundController extends DashboardThemeOptionsController {

    function view() {
        
        parent::view();

        if (!is_dir(DIR_FILES_CACHE . '/theme_silence')) {
            if (!mkdir(DIR_FILES_CACHE . '/theme_silence')) {
		$this->error->add(t('Warning! Your directory "files/cache" is not writtable by the server. Some backgrounds will be invisible ! '));                
            }
        }
        
        $fh = Loader::helper('theme_file', 'theme_silence');
        $packagePath = Package::getByHandle('theme_silence')->getPackagePath();

        $pattern_list = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_patterns/');
        if (!$pattern_list) {
            $pattern_list = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/patterns/');
            
        }
        $this->set('pattern_list', $pattern_list);

    }
    
    function save_options() {

        $fh = Loader::helper('theme_file', 'theme_silence');

        if (is_dir(DIR_FILES_CACHE . '/theme_silence')) {
            $fh->rrmdir ( DIR_FILES_CACHE . '/theme_silence' );
        }
        
        parent::save_options($_POST);
    }

}
