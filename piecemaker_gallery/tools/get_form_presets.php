<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('piecemaker_gallery_presets','piecemaker_gallery');
$as = BlockType::getByHandle('piecemaker_gallery');
$in = Loader::helper('concrete/interface');
$form = Loader::helper('form');

if (intval($_REQUEST['pID']) > 0) {
    $preset = PiecemakerGalleryPresets::getByID(intval($_REQUEST['pID']));
    $advanced_options = explode(',',$preset['options']);
    $title = $preset['title'];
    $pID = $preset['effectPresetID'];
    $statut = "Update";
} else {
    $advanced_options = array_values(PiecemakerGalleryPresets::getDefaultOptionsValues());
    $statut = "Save";
    $pID = $_REQUEST['pID'];
}

Loader::packageElement('form_presets','piecemaker_gallery', array('in'=>$in,
                                                                  'form'=>$form,
                                                                  'advanced_options'=>$advanced_options,
                                                                  'statut'=>$statut,
                                                                  'pID'=>$pID,
                                                                  'title'=>$title
                                                                  ));

exit;
