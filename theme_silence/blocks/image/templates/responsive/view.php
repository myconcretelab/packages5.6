<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$pattern = '/(width|height)="[0-9]*"/i';
// On retire toutes info de taille
$responsive = preg_replace($pattern, "", $controller->getContentAndGenerate());
echo $responsive;
?>