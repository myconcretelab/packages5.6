<?php defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('file_attributes');

$fileAttributes = FileAttributeKey::getList(); 

Loader::packageElement('file_attributes_options','multimedia_box',array('fileAttributes'=>$fileAttributes));

exit;