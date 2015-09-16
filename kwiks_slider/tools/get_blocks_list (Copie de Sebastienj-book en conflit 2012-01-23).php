<?php defined('C5_EXECUTE') or die(_("Access Denied."));

if ($_REQUEST['bID']) {
    $b = Block::getByID($_REQUEST['bID']);
    if(!is_object($b)) { die(t('Invalid Paremeters')); } 
    $bp = new Permissions($b);
    if(!$bp->canRead()) { die(t('Permission Denied')); }

    $block = $b->getInstance();

}
$uh = Loader::helper('concrete/urls');

Loader::block('kwiks_slider');
$blocks = KwiksSliderBlockController::getBlocksFromStackID($_REQUEST['stID']);

Loader::packageElement('blocks_form','kwiks_slider',array('bID' => $_REQUEST['bID'],
                                                            'stID'=>$_REQUEST['stID'],
                                                            'blocks' => $blocks,
                                                            'al'=> Loader::helper('concrete/asset_library'),
                                                            'pckgUrl'=>$uh->getBlockTypeAssetsURL(BlockType::getByHandle('kwiks_slider'))
                                                            )
                       );
exit;
