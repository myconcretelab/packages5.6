<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class ImageProcessingHelper {

    public function image_create_alpha ($width, $height) {
      // Create a normal image and apply required settings
      $img = imagecreatetruecolor($width, $height);
      imagealphablending($img, false);
      imagesavealpha($img, true);
      
      // Apply the transparent background
      $trans = imagecolorallocatealpha($img, 0, 0, 0, 127);
      for ($x = 0; $x < $width; $x++)
      {
        for ($y = 0; $y < $height; $y++)
        {
          imagesetpixel($img, $x, $y, $trans);
        }
      }
      
      return $img;
    }
    
    function add_transparency ($image, $percent) {
      $x = imagesx($image);
      $y = imagesy($image);
      
      $image2 = $this->image_create_alpha($x, $y);
      imagecopy($image2, $image, 0, 0, 0, 0, $x, $y);
      
      imagesavealpha($image2, true);
      
      if ($percent>0) {
        for ($ii=0;$ii<$x;$ii++) {
          for ($jj=0;$jj<$y;$jj++) {
            $c = imagecolorat($image2, $ii, $jj);
            $r = ($c >> 16) & 0xFF;
            $g = ($c >> 8) & 0xFF;
            $b = $c & 0xFF;
            $alpha = ($c >> 24) & 0xFF;
            $c = imagecolorallocatealpha($image2, $r, $g, $b, $alpha+($percent/100*(127-$alpha)));
            imagesetpixel($image2, $ii, $jj, $c);
          }
        }
      }
      
      return $image2;
    }

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
    
}
