<?php    defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('file_set');
$fileSets = FileSet::getMySets();

Loader::packageElement('fileset_select_options','blade_slider',array('fileSets'=>$fileSets));
exit;
