<?php 
$bt_ns = BlockType::getByHandle('nivo_slider');
$bt_ns->controller->fsID = 1; // ID of your fileset
$bt_ns->controller->effect = 'random'; // choose from : sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft, fold, fade, random
$bt_ns->controller->slices = 10;
$bt_ns->controller->animSpeed = 500;
$bt_ns->controller->pauseTime = 3000;
$bt_ns->controller->startSlide = 0; 
$bt_ns->controller->options('pauseOnHover','directionNav','directionNavHide','controlNav', 'controlNav', 'controlNumbers', 'keyboardNav', 'randomize'); // remove option from string to disable them
$bt_ns->render('view');
?>