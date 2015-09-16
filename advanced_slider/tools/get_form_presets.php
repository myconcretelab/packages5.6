<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('advanced_slider_presets','advanced_slider');
$as = BlockType::getByHandle('advanced_slider');
$in = Loader::helper('concrete/interface');
$form = Loader::helper('form');

if (intval($_REQUEST['pID']) > 0) {
    $preset = AdvancedSliderPresets::getByID(intval($_REQUEST['pID']));
    $advanced_options = explode(',',$preset['options']);
    $title = $preset['title'];
    $pID = $preset['effectPresetID'];
    $statut = "Update";
} else {
    $a = AdvancedSliderPresets::getRandomValues();
    $advanced_options = explode(',',$a['options']);
    $title = '';
    $statut = "Save";
    $pID = $_REQUEST['pID'];
}

Loader::packageElement('form_presets','advanced_slider',array('advanced_options'=>$advanced_options,
                                                              'title'=>$title,
                                                              'pID'=>$pID,
                                                              'statut'=>$statut,
                                                              'as'=>$as,
                                                              'in'=>$in,
                                                              'form'=>$form
                                                              ));
exit;
