<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>
<a href="<?php  echo $linkTo ?>" class="button button-block button-rounded button-primary button-large icooon-blk-button <?php  echo $size ?>" style="color:<?php  echo $secondColor?>;">
	 <i class="<?php  echo $iconName ?> <?php  echo $size ?> icooon" style="color:<?php  echo $secondColor?>;"></i>
	&nbsp;&nbsp;<?php  echo html_entity_decode($titleText) ?>
	<strong style="color:<?php  echo $secondColor?>;"><?php  echo html_entity_decode($contentText) ?></strong>
</a>

