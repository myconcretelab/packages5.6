<?php      defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<div style="clear:both">&nbsp;</div>

<ul id="roundabout_<?php   echo $bID?>_handler">
	<!-- Loop for content -->
	<?php foreach($blocks as $k=>$b) : ?>
	<li>
		<div class="roundabout-padding">
			<?php $bv = new BlockView() ?>
			<?php echo  $bv->render($b, 'view') ?>				
		</div>
	</li>
	<?php endforeach ?>    
</ul>

<div style="clear:both">&nbsp;</div>

<style>

.roundabout-moveable-item {
        width:<?php   echo $width?>px;
        height:auto;
	background:#ffffff;
}
#roundabout_<?php   echo $bID?>_handler {
        height:<?php   echo $height?>px;
	margin:0 auto !important;
	display:block !important;
	float:none !important;
	}

.roundabout-padding {
	padding:1em;
}
</style>
<script type="text/javascript">

$(document).ready(function() {
   $('#roundabout_<?php   echo $bID?>_handler').roundabout({

   });
});

</script>
<!--
-->