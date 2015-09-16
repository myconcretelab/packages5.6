<?php defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('piecemaker_gallery_presets','piecemaker_gallery');
$presets = PiecemakerGalleryPresets::getList();
Loader::packageElement('options_presets','piecemaker_gallery',array('presets'=>$presets));
exit;
