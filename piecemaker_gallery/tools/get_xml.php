<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

$b = Block::getByID($_REQUEST['bID']);
if( !is_object($b)) { die(t('Invalid Paremeters')); } 

$block = $b->getInstance();
$gallery = $block->getGallery();
if(!is_array($gallery)) { die(t('Invalid Gallery')); } 

Loader::model('piecemaker_gallery_presets','piecemaker_gallery');
$tex = Loader::helper('textile','piecemaker_gallery');

if ($block->check_gallery_data_compatible()) {
    // Si les informations n'ont pas ŽtŽ mise a jour avec l'Ždition 2.0
    $options = explode( ',', $block->options);
    $transitions = $block->get_transitions_options_array();
} else {
    $options = array_values($block->default_settings);
    $transitions[] = implode(',',array_values(PiecemakerGalleryPresets::getDefaultOptionsValues()));
}
Loader::packageElement('gallery_xml','piecemaker_gallery',array('block'=> $block,
                                                                'gallery'=>$gallery,
                                                                'options'=>$options,
                                                                'transitions'=>$transitions,
                                                                'tex'=>$tex
                                                                ));
exit;
