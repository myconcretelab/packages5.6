<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="icooon-box icooon-box_content">
	<h3 class="icooon-box_icon">
	<span class="fa-stack fa-1x">
	  <i class="fa fa-circle fa-stack-2x" style="color:<?php echo $mainColor?>;"></i>
	  <i class="<?php echo $iconName ?> fa-inverse fa-stack-1x icooon" style="color:<?php echo $secondColor?>;"></i>
	</span>	
	</h3>
	<h3 class="icooon-box_content_title"  style="color:<?php echo $mainColor?>;"><?php echo $titleText ?></h3>
	<p><?php echo $contentText ?></p>
	<?php if (isset($linkTo)) : ?> <a href="<?php echo $linkTo ?>" class="button button-flat-primary"><?php echo $textLink ?> <i class="icon-arrow-right"></i></a><?php endif ?>
</div>


