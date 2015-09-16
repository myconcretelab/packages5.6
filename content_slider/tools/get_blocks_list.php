<?php defined('C5_EXECUTE') or die(_("Access Denied."));
if ($_REQUEST['bID']) {
    $b = Block::getByID($_REQUEST['bID']);
    if(!is_object($b)) { die(t('Invalid Paremeters')); } 
    $bp = new Permissions($b);
    if(!$bp->canRead()) { die(t('Permission Denied')); }

    $block = $b->getInstance();

    if ($block->stID == $_REQUEST['stID']) :
        $blockTitle = explode ('0o0',$block->blockTitle);
        $blockDescription = explode ('0o0',$block->blockDescription);
        $files = explode(',',$block->files);
    else :
        $blockTitle = array();
        $blockDescription = array();
        $files = array();    
    endif;

} else {
    $blockDescription = array();
    $blockTitle = array();
    $files = array();
}

Loader::block('content_slider');
$blocks = ContentSliderBlockController::getBlocksFromStackID($_REQUEST['stID']);

$al = Loader::helper('concrete/asset_library');
Loader::model('file');
$img['fType'] = FileType::T_IMAGE;


Loader::packageElement('blocks_form','content_slider',array('bID' => $_REQUEST['bID'],
                                                            'stID'=>$_REQUEST['stID'],
                                                            'blocks' => $blocks,
                                                            'blockTitle'=>$blockTitle,
                                                            'blockDescription'=>$blockDescription,
                                                            'files' => $files,
                                                            'al'=> Loader::helper('concrete/asset_library'),
                                                            'img'=>$img
                                                            )
                       );
exit;
