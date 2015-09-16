<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
$int = Loader::helper('concrete/interface');
Loader::packageElement('dialog_presets','advanced_slider', array('int'=>$int));
exit;
