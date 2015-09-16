<?php           defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('file/types');
Loader::model('file');
$al             = Loader::helper('concrete/asset_library');
$db             = Loader::db();
$ih             = Loader::helper('image');
$pageSelector   = Loader::helper('form/page_selector');

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}

// En mode Ždition, si l'utilisateur change de fileset, il faut rŽinitialiser les preset ainsi que les liens

if ($_REQUEST['fsID'] == $bi->fsID) {
    // Sinon, on prends toutes les donnŽes de la DB
    $linkPageID = explode(',',$bi->linkPageID);
    $fileLink = explode(',',$bi->fileLink);
    $pID = explode(',',$bi->imagePID);    
} else {
    // Si le fileset est diffŽrent que celui enregistrŽ
    $linkPageID = $fileLink = $pID = array();
}

$vals = array($_REQUEST['fsID']);
$sql = 'SELECT fID FROM FileSetFiles WHERE fsID=?';
$files = $db->getAll($sql,$vals);

Loader::packageElement('images_links_preset','advanced_slider',array('al'=>$al,
                                                                     'db'=>$db,
                                                                     'ih'=>$ih,
                                                                     'pageSelector'=>$pageSelector,
                                                                     'linkPageID'=>$linkPageID,
                                                                     'fileLink'=>$fileLink,
                                                                     'pID'=>$pID,
                                                                     'vals'=>$vals,
                                                                     '$sql'=>$sql,
                                                                     'files'=>$files
                                                                     ));
exit;
