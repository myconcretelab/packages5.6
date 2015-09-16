<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="icooon-tinybox icooon-tinybox_content padding-<?php echo $size ?>">
	<h4 class="left">
		<span class="fa-stack <?php echo $size ?>">
		  <i class="fa fa-circle fa-stack-2x" style="color:<?php echo $mainColor?>;"></i>
		  <i class="<?php echo $iconName ?> fa-inverse fa-stack-1x icooon" style="color:<?php echo $secondColor?>;"></i>
		</span>	
	</h4>
	<h4 class="icooon-tinybox_content_title"><?php echo $titleText ?></h4>
	<p>
		<?php echo $contentText ?>
		<?php if (isset($linkTo)) : ?> <a href="<?php echo $linkTo ?>" class="button button-flat-primary right"><?php echo $textLink ?> <i class="icon-arrow-right"></i></a><?php endif ?>
	</p>
	
</div>


