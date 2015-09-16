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
header("Cache-Control","no-cache"); //HTTP 1.1
header("Pragma","no-cache"); //HTTP 1.0
header ("Expires", 0); //prevents caching at the proxy server

$id = implode('',($_GET))  . '_bg';
$cachefile = DIR_FILES_CACHE . '/theme_silence/' . $id . '.png';

if (!file_exists($cachefile)) {

    $path = Package::getByHandle('theme_silence')->getPackagePath();
    $h = Loader::helper('theme', 'theme_silence');

    $pattern = $_GET['pattern'] ?  $_GET['pattern'] : 'square';
    
    if (is_numeric($pattern) ) {

        $file = File::getByID($pattern);

        if ($file->getExtension() != 'png') return ;
        else $bg = imagecreatefrompng ($file->getPath());
     
    } else {
        
        $bg = imagecreatefrompng ($h->get_ressource_path ($pattern, 'patterns'));    
    
    }
    
    $hex = $_GET['color'] ? $_GET['color'] : '554455';
    
    $bg_width = imagesx($bg);  
    $bg_height = imagesy($bg);
    
    if ( is_numeric($_GET['color-height']) ) {
        
        $color_height = $_GET['color-height'];
        if ($color_height === '0' ) return header('content-type: image/png');
    
        $bg_height = $color_height;
        $image = imagefillfromfile($bg,$bg_width,$color_height,$hex);
     
    } else {
     
        $color_height = $bg_height;
        $image = imagecreatetruecolor($bg_width, $color_height);
        $background = imagecolorallocate($image, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2));
        imagefilledrectangle($image, 0, 0, $bg_width, $color_height, $background);
        imagecopy($image, $bg, 0, 0, 0, 0, $bg_width, $bg_height);  
     
    }
    
    if ($shadow_type = $_GET['shadow']) {

        if (is_dir($custom_folder = DIR_BASE . '/images/theme_shadows/') && is_file($custom_folder . $shadow_type .'.png')) {
            $shadow = imagecreatefrompng ($custom_folder . $shadow_type . '.png');    
        } else {
            $shadow = imagecreatefrompng ($path . '/images/shadows/' . $shadow_type. '.png');
        }
        
        preg_match('/(\d+)_(\w+)/',$shadow_type, $match);
        $shadow_h = imagesy($shadow);
        $shadow_y = $match[2] == 'top' ? 0 : ($bg_height - $shadow_h);    
        
        imagecopyresized($image, $shadow, 0, $shadow_y, 0, 0, $bg_width, $shadow_h, 1,$shadow_h);
        imagedestroy($shadow);
    }
    
    //$light = imagecreatetruecolor($bg_width,1);
    
    if (!is_dir(DIR_FILES_CACHE . '/theme_silence')) {
        if (!mkdir(DIR_FILES_CACHE . '/theme_silence')) return;
    }
    
    imagepng($image, $cachefile);
    //echo generated;
    
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

function imagefillfromfile($image, $width, $height,$hex) {
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        $newImage = imagecreatetruecolor($width, $height);
        $background = imagecolorallocatealpha($newImage, '0x' . substr($hex, 0, 2), '0x' . substr($hex, 2, 2), '0x' . substr($hex, 4, 2),0);
        imagefilledrectangle($newImage, 0, 0, $width, $height, $background);
        
        for ($imageX = 0; $imageX < $width; $imageX += $imageWidth) {
            for ($imageY = 0; $imageY < $height; $imageY += $imageHeight) {
                imagecopy($newImage, $image, $imageX, $imageY, 0, 0, $imageWidth, $imageHeight);
            }
        }
        
        return($newImage);
        imagedestroy($newImage);
    }
?>