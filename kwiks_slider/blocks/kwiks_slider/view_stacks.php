<?php defined('C5_EXECUTE') or die(_("Access Denied."));

?>

<ul class="kwicks" id="kwicks-<?php echo $bID?>">
		<?php foreach($blocks as $k=>$b) : ?>
		<li class="kwicks-element-<?php echo $k?>" data-width="<?php echo $elementWidth ?>">
			<div class="inner-kwicks">
				<div class="kwicks-padding">
					<?php $bv = new BlockView() ?>
					<?php echo  $bv->render($b, 'view') ?>
				</div>
			</div>
		</li>
		<?php endforeach ?>    	
</ul>

<div style="clear:both">&nbsp;</div>

<style>
ul#kwicks-<?php echo $bID?> {
	width:<?php echo $width?>px;
}
ul#kwicks-<?php echo $bID?> li {
	width : <?php echo $elementWidth ?>px;
}
ul#kwicks-<?php echo $bID?> li .inner-kwicks {
	width:<?php echo $percent ?>px;
}
</style>

<script type="text/javascript">
	$(document).ready(function() {

		var _kwicks = $('ul#kwicks-<?php  echo $bID?>');
		var maxHeight = 0;

		
		<?php if (in_array('homogenize_height', $options)) : ?>
			_kwicks.children().each(function (e) {
				//console.log( $(this).height());
				maxHeight = $(this).height() > maxHeight ? $(this).height() : maxHeight;
			});
			_kwicks.children().height(maxHeight);
		<?php endif ?>


		_kwicks.kwicks({
			max:<?php echo $percent ?>,
			spacing:<?=$spacing?>,
			easing: '<?=$easing?>',
			duration:<?=$duration?>,
			<?=$defaultKwick ? "sticky : true, defaultKwick :" . ($defaultKwick - 1) .',' : '' ?> 
			event : '<?=$event?>',
			height:maxHeight
			
		});
	});
</script>