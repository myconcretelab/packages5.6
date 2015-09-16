<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$variables = array();
Loader::model('file');
Loader::model('file_set');
srand();
$variables['al'] = Loader::helper('concrete/asset_library');
$variables['ch'] = Loader::helper('form/color'); 
$variables['ph']= Loader::helper('form/page_selector');
$variables['myFileSet'] = FileSet::getMySets();
$variables['type'] = $_GET['type'] ;
$variables['uniqueID'] = $_GET['uniqueID'];
$variables['capsID'] = $_GET['capsID'];

Loader::packageElement('form_media','advanced_content',$variables);
exit;