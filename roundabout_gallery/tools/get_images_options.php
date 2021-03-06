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

// En mode �dition, si l'utilisateur change de fileset, il faut r�initialiser les preset ainsi que les liens

if ($_REQUEST['fsID'] == $bi->fsID) {
    // Sinon, on prends toutes les donn�es de la DB
    $linkPageID = explode(',',$bi->linkPageID);
    $fileLink = explode(',',$bi->fileLink);
    $linkType = explode(',',$bi->linkType);
    $linkAdress = explode('|||',$bi->linkAdress);
    $fsTitle = $bi->fsTitle;
    $fsDescription = $bi->fsDescription;
} else {
    // Si le fileset est diff�rent que celui enregistr�
    $linkPageID = $fileLink = $pID = $linkType =  array();
}

$vals = array($_REQUEST['fsID']);
$sql = 'SELECT fID FROM FileSetFiles WHERE fsID=?';
$files = $db->getAll($sql,$vals);



Loader::packageElement('images_links_preset','roundabout_gallery',array('al'=>$al,
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
                                                                     'fileAttributes' => FileAttributeKey::getList(),
                                                                     'fsTitle'=>$fsTitle,
                                                                     'fsDescription'=>$fsDescription
                                                                     ));
exit;
