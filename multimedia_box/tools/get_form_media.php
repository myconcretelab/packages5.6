<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$variables = array();
Loader::model('file');
Loader::model('file_set');
srand();
$variables['al'] = Loader::helper('concrete/asset_library');
$variables['myFileSet'] = FileSet::getMySets();
$variables['type'] = $_GET['type'] ;
$variables['random'] = (rand());
$variables['media_options']	= array();

if ($_GET['edit'] == 'true') {
    $variables['b']             = Block::getByID($_REQUEST['bID']);
    if(!is_object($variables['b'])) { die(t('Invalid Paremeters')); } 
    $variables['mb']            = $mb = $variables['b']->getInstance();
    $media_options              = explode('0o0', $mb->media_options); // Tablifie le grand tableau des options de medias
    $variables['media_options']	= explode('_', $media_options[$_GET['place']]); // SŽpare en tableau les options pour CE media 
    $variables['place']         = $_GET['place'];
    $variables['edit']          = $_GET['edit'];
    $variables['types']	        = $types = explode('0o0', $mb->types);
    $variables['descs'] 	= explode('0o0', $mb->descs);
    $variables['medias']	= explode('0o0', $mb->medias);
    $variables['titles']	= explode('0o0', $mb->titles);
    $variables['widths']	= explode('0o0', $mb->widths);
    $variables['heights']	= explode('0o0', $mb->heights);
    if ($types[$_GET['place']] == 'image' || $types[$_GET['place']] == 'mp3' || $types[$_GET['place']] == 'quicktime' || $types[$_GET['place']] == 'flash') {
        $variables['media'] = File::getByID($variables['medias'][$_GET['place']]);
    }
}

Loader::packageElement('form_media','multimedia_box',$variables);
exit;