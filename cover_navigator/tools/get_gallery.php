<?php   defined('C5_EXECUTE') or die(_("Access Denied."));

if ($_REQUEST['bID']) {
    $b = Block::getByID($_REQUEST['bID']);
    if(!is_object($b)) { die(t('Invalid Paremeters')); } 
    $bp = new Permissions($b);
    if(!$bp->canRead()) { die(t('Permission Denied')); }
    $block = $b->getInstance();
} else {
    echo "Loading problem : no bID";
}

Loader::packageElement('gallery','cover_navigator',array('covers' => $block->retrieve_clients(),
                                                        'i' => Loader::helper('image'),
                                                        'bID'=> $_REQUEST['bID']
                                                         ));

exit;
