<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::controller('/dashboard/theme_super_mint_options');

class DashboardThemeSuperMintOptionsECommerceController extends DashboardThemeSuperMintOptionsController {

    function view() {
        
        $h = Loader::helper('super_mint_theme', 'theme_super_mint');
        // On verifie si le package ecommerce existe
        if (!$h->is_ecommerce) :
            $this->error->add(t('You must install the eCommerce package to use this page'));
            $this->set('is_ecommerce',false);
            $this->set('windowName', t('eCommerce options page'));
            return;
        endif;
        
    	loader::model('sm_page_product_category', 'theme_super_mint');

    // La liste des stack dispo
        Loader::model('stack/list');
        $stm = new StackList();

        $stm->filterByUserAdded();
        //$stm->filterByGlobalAreas();

        $stacksList = $stm->get();

	// On les rends dispo pour le view
		$this->set('categories', SmPageProductCategory::get_attribute_list('object'));
		$this->set('pages', SmPageProductCategory::getAll());
        $this->set('stacksList',$stacksList);
        $this->set('is_ecommerce',true);
        $this->set('windowName', t('Manage eCommerce navigation'));

        parent::view();
    }
    function save_categories () {
        loader::model('sm_page_product_category', 'theme_super_mint');
        $js = Loader::helper('json');

        //echo '<pre>';
        //print_r($_POST); 
        //die();
        $p = $_POST; 

        foreach ($p['cID'] as $cID) :
            $data = $save = array();
            $data['category_result_page'] = $p['category_result_page'][$cID];
            // $data['stack_header'] = $p['stack_header'][$cID];
            // $data['stack_footer'] = $p['stack_footer'][$cID];
            $data['columns'] = $p['columns'][$cID];
            $data['prSet'] = $p['prSet'][$cID];
            $data['display_empty_categories'] = $p['display_empty_categories'][$cID];
            $data['full_width_mega'] = $p['full_width_mega'][$cID];
            $data['show_product_count_on_nav'] = $p['show_product_count_on_nav'][$cID];
            $data['alow_multiple_choice'] = $p['alow_multiple_choice'][$cID];

            if (is_array($p['akID'][$cID])) :
                foreach ($p['akID'][$cID] as $akID) :
                    $data['ak_title'][$akID] = $p['ak_title' . $akID][$cID];
                    $data['display_title'][$akID] = $p['display_title' . $akID][$cID];
                    foreach ($p[$akID][$cID] as $oID) :
                        // Toutes les option de ce akID de ce CID
                        $data['akID'][$akID][] = $oID;
                    endforeach;
                endforeach;
            endif;
            $save['cID'] = $cID;
            $save['specs'] = $js->encode($data);
           //print_r($save);          
           SmPageProductCategory::save($save);
        endforeach;
        //die();

        $this->view();
    }

    function save_options() {
        parent::save_options($_POST);
    }
    
    function category_ajax ($akID,$cID,$selected = array('all'),$return = false) {
    	loader::model('sm_page_product_category', 'theme_super_mint');
        $v = SmPageProductCategory::getBycID($cID);
    	$a = SmPageProductCategory::getPraparedAkFromAkID($akID);
        //print_r($a->ak);
 		if (! is_array($a->options) || ! count($a->options)) return;
        //echo '<div class="span2">';
        echo '<strong>' . t('Display title for ') . $a->ak->akName . '</strong>';
        echo  '<div class="input-prepend">
                    <span class="add-on"><input type="checkbox"  name="display_title'.  $akID . '[' . $cID . ']" ' . ($v->display_title[$akID] ? 'checked' : '') . '  /></span>
                    <input class="span2" type="text" name="ak_title'.  $akID . '[' . $cID . ']" value="' . $v->ak_title[$akID] . '" placeholder="' .  $a->ak->akName . '" style="display:inline-block" />
                </div>';
        echo '<select id="ak_'.  $akID . '_' . $cID . '" 
        		name="'.  $akID . '[' . $cID . '][]" 
        		data-placeholder="' . t('Choose options to show') . '" 
        		multiple class="chzn-select">';
		// L'option all        		
        echo '<option value="all" ' . (in_array('all', $selected) ? 'selected' : '') . '>-- All --</option>';
        // les autres options
        foreach ($a->options as $o) : 
        	echo '<option value="' . $o->ID . '" ' . (in_array($o->ID, $selected) ? 'selected' : '') . '>' . $o->value . '</option>';
        endforeach ;
        echo '</select>';
        echo '<br><br>';
        //echo '</div>';
        echo '<script> $("#ak_'.  $akID . '_' . $cID . '").chosen();</script>';

        if($return) return; else exit;
    	
    }
}
