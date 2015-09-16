<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="callout-icooon row">
	<div class="span2 offset1">
		<h3 class=""><i class="<?php  echo $iconName ?> <?php  echo $size ?>"></i></h3>
	</div>
	<div class="span5">
		<h2><?php  echo html_entity_decode($titleText) ?></h2>
		<p><?php  echo html_entity_decode($contentText) ?> </p>
	</div>
	<?php  if (isset($linkTo)) : ?>
	<div class="span3 icooon-link">
		<span class="button-wrap"><a href="<?php  echo $linkTo ?>" class="button button-pill button-primary"><?php  echo html_entity_decode($textLink) ?></a></span>
	</div>
	<?php  endif ?>
</div>
