<?php  defined('C5_EXECUTE') or die("Access Denied.");

$sue = Loader::helper('sue_theme', 'theme_sue');
global $mobile;
if ($mobile && $sue->__enable_mobile) {
	  include_once (dirname(__FILE__) . '/slider_full_with.php');
} else {
	  include_once (dirname(__FILE__) . '/slider_3_columns.php');	
}
