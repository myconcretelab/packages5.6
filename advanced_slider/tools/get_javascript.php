<?php      header("Content-type: text/javascript");
defined('C5_EXECUTE') or die(_("Access Denied."));

//@ini_set('zlib.output_compression_level', 1);
//@ob_start('ob_gzhandler');

$c = Page::getByID($_REQUEST['cID']);
$b = Block::getByID($_REQUEST['bID']);
$path = BlockType::getByHandle('advanced_slider')->getBlockTypePath();

$canView = true;

if(!is_object($c) || !is_object($b)) { die(t('Invalid Paremeters')); } 

/* @todo : Verifier pourquoi quand le block se trouve ds le scrabboock, il ne recoit pas de permission $bp->canRead() = false
        $cp = new Permissions($c);
        $bp = new Permissions($b);
        if(!$cp->canRead()) { die(t('Permission Denied')); } 
        if(!$bp->canRead()) { die(t('Permission Denied')); }
*/

Loader::model('advanced_slider_presets','advanced_slider');

$block = $b->getInstance();

$options = explode(',',$block->options);
$imagePID =explode(',', $block->imagePID);

// Chercher dans le tableau des preset spŽcifique aux images,
// des ID diffŽrents du preset global & de zero
// afin de gŽrer l'affichage ou non de la virgule entre les presets

foreach($imagePID as $k=>$p) {
        if ($p != $block->globalImagePID && $p != 0) $useful[] = $k; 
}

Loader::packageElement('advanced_javascript','advanced_slider',array('options'=>$options,
                                                                     'imagePID'=>$imagePID,
                                                                     'block'=>$block,
                                                                     'bID'=>$_REQUEST['bID'],
                                                                     'useful'=>$useful
                                                                     ));

echo file_get_contents($path . '/additional_js/jquery.easing.1.3.min.js');
echo file_get_contents($path . '/additional_js/jquery.mousewheel.min.js');
//echo file_get_contents($path . '/additional_js/jquery.prettyPhoto.custom.min.js');
//echo file_get_contents($path . '/additional_js/jquery.touchSwipe.min.js');
echo file_get_contents($path . '/additional_js/jquery.transition.min.js');
//echo file_get_contents($path . '/additional_js/jquery.videoController.min.js');
//echo file_get_contents($path . '/additional_js/video.min.js');
// froogaloop.min.js VImeo
echo file_get_contents($path . '/additional_js/jquery.advancedSlider.min.js');

exit;
