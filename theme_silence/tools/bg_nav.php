<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Silence theme
 * @category Tools
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */


header('content-type: image/png');  


$id = implode('',($_GET)) . '_nav';
$cachefile = DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';

if (!file_exists($cachefile)) {
    
    $path = Package::getByHandle('theme_silence')->getPackagePath();
    
    $level = $_GET['level'] ? $_GET['level'] : '1';
    $form = 'level_' . $level;
    
    $shadow = imagecreatefrompng ($path . '/images/navigation/nav-shadow-' . $level . '.png');
    imageAlphaBlending($shadow, true);
    imageSaveAlpha($shadow, true);
    
    $image = imagecreatetruecolor(220, 850);
    imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));
    
    $bg_width = imagesx($shadow);  
    $bg_height = imagesy($shadow);  
    $color_height = 255;
    
    $hex = $_GET['color'] ? $_GET['color'] : '522455';
    $background = imagecolorallocatealpha($image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
    
    $level_1 = array(13,13,
                    31,13,
                    38,6,
                    45,13,
                    203,13,
                    203,814,
                    13,814,
                    13,13
                    );
    
    $level_2 = array(13,13,
                    203,13,
                    203,813,
                    13,813,
                    13,44, // start
                    6,37,
                    13,30,
                    13,13
                    );
    
    imagefilledpolygon($image , $$form , 8 , $background);
    
    imagecopymerge($shadow,$image , 0, 0, 0, 0, $bg_width, $bg_height,100);  
    
    if ($light_type = $_GET['light']) {
        $light = imagecreatefrompng ($path . '/images/navigation/' . $light_type . '_' . $_GET['level'] . '.png');
        imagecopy( $shadow, $light, 0, 0, 0, 0, $bg_width, imagesy($light));  
    }
        

    imagepng($shadow, $cachefile);  
    imagedestroy($image);  
    imagedestroy($bg);


}

//////////////////////////////////////////////////////////////////////////////

$fp = fopen($cachefile, 'rb'); # stream the image directly from the cachefile

header("Content-Length: " . filesize($cachefile));
header("Connection: close"); // limit the 15sec keep-alive session for Chrome

fpassthru($fp);

exit;
  
//////////////////////////////////////////////////////////////////////////////





?>