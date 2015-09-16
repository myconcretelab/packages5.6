<?php  defined('C5_EXECUTE') or die("Access Denied.");
	 ?>
<?php  if ($type == "box"):?>
	<div class="lined-section">
		<?php  if ($title != ''):?><h3><?php echo $title ?></h3><?php  endif; ?>
		<span></span>
	</div>	
<?php  elseif ($type == "double"):?>	
	<div class="double-lined-section">
		<?php  if ($title != ''):?><h3><?php echo $title ?></h3><?php  endif; ?>
		<span></span>
	</div>
<?php else : ?>
	<div style="height:40px;"></div>	
<?php  endif; ?>
