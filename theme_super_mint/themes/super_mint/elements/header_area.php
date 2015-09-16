<?php  defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div class="row">
	<div id="header" class="<?php echo $span ?>">
        <?php 
			$a = new Area($areaName);
			$a->display($c);
		?>
	</div>
</div>


