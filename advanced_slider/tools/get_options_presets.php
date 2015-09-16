<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('advanced_slider_presets','advanced_slider');
$presets = AdvancedSliderPresets::getList();

Loader::packageElement('options_presets','advanced_slider', array('presets'=>$presets));

exit;
