<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="callout-icooon row">
	<div class="span2 offset1">
		<h3 class=""><i class="<?php echo $iconName ?> <?php echo $size ?>"></i></h3>
	</div>
	<div class="span5">
		<h2><?php echo $titleText ?></h2>
		<p><?php echo $contentText ?> </p>
	</div>
	<?php if (isset($linkTo)) : ?>
	<div class="span3 icooon-link">
		<span class="button-wrap"><a href="<?php echo $linkTo ?>" class="button button-pill button-primary"><?php echo $textLink ?></a></span>
	</div>
	<?php endif ?>
</div>
