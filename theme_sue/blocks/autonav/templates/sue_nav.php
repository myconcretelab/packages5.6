<?php 

defined('C5_EXECUTE') or die("Access Denied.");

global $mobile;
$t = Loader::helper('sue_theme', 'theme_sue');

if ($mobile && $t->__enable_mobile)
    // Choose the mobile template   
    include_once (dirname(__FILE__) . '/mobile/view.php');
else
    // Choose the desktop template   
    include_once (dirname(__FILE__) . '/desktop/view.php');
