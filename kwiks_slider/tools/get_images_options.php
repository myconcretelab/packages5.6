<?php         defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('file/types');
Loader::model('file');
$al             = Loader::helper('concrete/asset_library');
$db             = Loader::db();
$ih             = Loader::helper('image');
$pageSelector   = Loader::helper('form/page_selector');
Loader::model('file_attributes');

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}

// En mode Ždition, si l'utilisateur change de fileset, il faut rŽinitialiser les preset ainsi que les liens

if ($_REQUEST['fsID'] == $bi->fsID) {
    // Sinon, on prends toutes les donnŽes de la DB
    $linkPageID = explode(',',$bi->linkPageID);
    $fileLink = explode(',',$bi->fileLink);
    $linkType = explode(',',$bi->linkType);
    $linkAdress = explode('|||',$bi->linkAdress);
    $fsTitle = $bi->fsTitle;
    $fsDescription = $bi->fsDescription;
} else {
    // Si le fileset est diffŽrent que celui enregistrŽ
    $linkPageID = $fileLink = $pID = $linkType =  array();
}

if ($db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
        $files = $db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($_REQUEST['fsID']) );				
} else {
        $files = $db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($_REQUEST['fsID']) );				
}

Loader::packageElement('images_links_preset','kwiks_slider',array('al'=>$al,
                                                                     'db'=>$db,
                                                                     'ih'=>$ih,
                                                                     'pageSelector'=>$pageSelector,
                                                                     'linkPageID'=>$linkPageID,
                                                                     'fileLink'=>$fileLink,
                                                                     'linkAdress'=>$linkAdress,
                                                                     'linkType'=>$linkType,
                                                                     'vals'=>$vals,
                                                                     '$sql'=>$sql,
                                                                     'files'=>$files,
                                                                     'fileAttributes' => FileAttributeKey::getList()
                                                                     ));
exit;
