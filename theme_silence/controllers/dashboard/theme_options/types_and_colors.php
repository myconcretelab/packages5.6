<?php         
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_options');

class DashboardThemeOptionsTypesAndColorsController extends DashboardThemeOptionsController {

    function view() {
        
        parent::view();

        $fh = Loader::helper('theme_file', 'theme_silence');
        $packagePath = Package::getByHandle('theme_silence')->getPackagePath();

        $bg_sidebar_title = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_left_sidebar_title/');
        if (!$bg_sidebar_title) {
            $bg_sidebar_title = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/left_sidebar_title/');
            
        }
        $this->set('bg_sidebar_title', $bg_sidebar_title);

        $bg_right_sidebar_title = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_right_sidebar_title/');
        if (!$bg_right_sidebar_title) {
            $bg_right_sidebar_title = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/right_sidebar_title/');
            
        }
        $this->set('bg_right_sidebar_title', $bg_sidebar_title);

        $bg_buttons = $fh->file_dir( DIR_BASE . '/' . DIRNAME_IMAGES . '/theme_buttons/');
        if (!$bg_buttons) {
            $bg_buttons = $fh->file_dir($packagePath . '/' . DIRNAME_IMAGES . '/buttons/');
            
        }
        $this->set('bg_buttons', $bg_buttons);
                
    }
    
}
