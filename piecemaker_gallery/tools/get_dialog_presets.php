<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
$int = Loader::helper('concrete/interface');
Loader::packageElement('dialog_presets','piecemaker_gallery',array('int'=>$int));
exit;
