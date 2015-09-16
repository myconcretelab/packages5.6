<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="icooon-box icooon-box_content">
	<h3 class="icooon-box_icon">
	<span class="icon-stack">
	  <i class="icon-circle icon-stack-base <?php  echo $size ?>" style="color:<?php  echo $mainColor?>;"></i>
	  <i class="<?php  echo $iconName ?> <?php  echo $size ?> icon-light icooon" style="color:<?php  echo $secondColor?>;"></i>
	</span>	
	</h3>
	<h3 class="icooon-box_content_title"  style="color:<?php  echo $mainColor?>;"><?php  echo html_entity_decode($titleText); ?></h3>
	<p><?php  echo html_entity_decode($contentText); ?></p>
	<?php  if (isset($linkTo)) : ?> <a href="<?php  echo $linkTo ?>" class="button button-flat-primary"><?php  echo html_entity_decode($textLink) ?> <i class="icon-arrow-right"></i></a><?php  endif ?>
</div>


