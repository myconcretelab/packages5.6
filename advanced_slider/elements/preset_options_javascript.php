<?php      defined("C5_EXECUTE") or die(_("Access Denied."));

Loader::model("advanced_slider_presets","advanced_slider");

$preset_array = $pID == -1 ? AdvancedSliderPresets::getRandomValues() : AdvancedSliderPresets::getByID($pID);
//$defaultvalues = AdvancedSliderPresets::getDefaultValues();
$preset_options = explode(",",$preset_array["options"]);
$imagePID =explode(",", $block->imagePID);
if($preset_options[0] != '' ) :
?>

<?php      if ($preset_options[0] != "random") : ?>effectType:"<?php      echo $preset_options[0]?>",<?php  echo "\r\t"; endif?>
<?php      if ($preset_options[1] != "random") : ?>slicePattern:"<?php      echo $preset_options[1]?>",<?php  echo "\r\t";     endif?>
<?php      if ($preset_options[2] != "default") : ?>slicePoint:"<?php      echo $preset_options[2]?>",<?php  echo "\r\t";     endif?>
<?php      if ($preset_options[3] != "default") : ?>sliceStartPosition:"<?php      echo $preset_options[3]?>",<?php  echo "\r\t";     endif?>
<?php      if ($preset_options[4] != "default") : ?>captionShowEffect:"<?php      echo $preset_options[4]?>",<?php    echo "\r\t";   endif?>
<?php      if ($preset_options[5] != "default") : ?>sliceDelay:<?php      echo $preset_options[5]?>,<?php   echo "\r\t";    endif?>
<?php      if ($preset_options[6] != "default") : ?>sliceDuration:<?php      echo $preset_options[6]?>,<?php   echo "\r\t";    endif?>
<?php      if ($preset_options[7] != "default") : ?>horizontalSlices:<?php      echo $preset_options[7]?>,<?php    echo "\r\t";   endif?>
<?php      if ($preset_options[8] != "default") : ?>verticalSlices:<?php      echo $preset_options[8]?>,<?php   echo "\r\t";    endif?>
<?php      if ($preset_options[9] != "default") : ?>sliceStartRatio:<?php      echo $preset_options[9]?>,<?php    echo "\r\t";   endif?>
<?php      if ($preset_options[11] != "default") : ?>captionPosition:"<?php      echo $preset_options[11]?>",<?php    echo "\r\t";   endif?>
<?php      if (isset($preset_options[12]) && $preset_options[12] != "default") : ?>slideDirection:"<?php      echo $preset_options[12]?>",<?php    echo "\r\t";   endif?>
<?php      if (isset($preset_options[13]) && $preset_options[13] != "default") : ?>sliceEffectType:"<?php      echo $preset_options[13]?>",<?php    echo "\r\t";   endif?>
sliceFade:<?php      echo in_array("sliceFade",$preset_options) ? "true" : "false"?>,
	sliceEffectType:"fade",
	fadePreviousSlide:true,
	slideMask:<?php      echo in_array("slideMask",$preset_options) ? "true" : "false"?>
	
	<?php  endif ?>