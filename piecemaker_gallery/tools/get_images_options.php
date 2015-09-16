<?php      defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::library('file/types');
Loader::model('file');

$db             = Loader::db();
$ih             = Loader::helper('image');
$pageSelector   = Loader::helper('form/page_selector');

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}

// Un problme se pose quand le bock est en mode Ždition :
// Si l'utilisateur change de fileset, il faut rŽinitialiser les preset ainsi que les liens
if ($_REQUEST['fsID'] == $bi->fsID) {
    // Sinon, on prends toutes les donnŽes de la DB
    $linkPageID = explode(',',$bi->linkPageID);
    $fileLink = explode(',',$bi->fileLink);
} else {
    // Si le fileset est diffŽrent que celui enregistrŽ
    $linkPageID = $fileLink = array();
}

$vals = array($_REQUEST['fsID']);
$sql = 'SELECT fID FROM FileSetFiles WHERE fsID=?';
$files = $db->getAll($sql,$vals);

Loader::packageElement('images_links_preset','piecemaker_gallery', array('files'=>$files,
                                                                         'linkPageID'=>$linkPageID,
                                                                         'fileLink'=>$fileLink,
                                                                         'ih'=>$ih,
                                                                         'pageSelector'=>$pageSelector
                                                                         
                                                                         ));
exit;
