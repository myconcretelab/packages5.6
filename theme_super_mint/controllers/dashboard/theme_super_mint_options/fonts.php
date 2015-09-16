<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_super_mint_options');

class DashboardThemeSuperMintOptionsFontsController extends DashboardThemeSuperMintOptionsController {

    function view() {
        
        parent::view();

                
    }

    function save_options() {

        parent::save_options($_POST);
    }
    
}
