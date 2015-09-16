<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>

<?php if (isset($linkTo)) : ?> <a href="<?php echo $linkTo ?>" class="" target="_blank" class="simple_icon"><?php endif ?>
	<span class="fa-stack <?php echo $size ?>">
	  <i class="fa fa-circle fa-stack-2x" style="color:<?php echo $mainColor?>;"></i>
	  <i class="<?php echo $iconName ?> fa-inverse fa-stack-1x icooon" style="color:<?php echo $secondColor?>;"></i>
	 <?php if ($contentText) : ?><span  class="hint--top hint--top--left" data-hint="<?php echo $contentText ?>"></span><?php endif ?> 
	</span>	

<?php if (isset($linkTo)) : ?> </a><?php endif ?>
