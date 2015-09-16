<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="icooon-tiny padding-<?php echo str_replace('icon-', '',$size) ?>">
	<p class="tiny-icooon">
	<i class="<?php echo $iconName ?> <?php echo $size ?> fa-fw icooon"  style="color:<?php echo $mainColor?>;"></i>

		
		<strong><?php echo $titleText ?></strong> <?php echo $contentText ?> 
		<?php if (isset($linkTo)) : ?> <a href="<?php echo $linkTo ?>" class="" target="_blank" style="color:<?php echo $mainColor?>;"><?php echo $textLink ?></a><?php endif ?>
	</p>
</div>