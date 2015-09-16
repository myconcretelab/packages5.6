<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$variables = array();

$cc = loader::helper('capsule_code','advanced_content');
$variables['categories'] = $cc->get_available_caps();



Loader::packageElement('advanced_overlay','advanced_content',$variables);
exit;