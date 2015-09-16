<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('file_set');
$fileSets = FileSet::getMySets();

Loader::packageElement('fileset_select_options','roundabout_gallery',array('fileSets'=>$fileSets));
exit;
