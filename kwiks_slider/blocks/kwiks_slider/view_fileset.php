<?php defined('C5_EXECUTE') or die(_("Access Denied."));
$hh = $ww =  0;
?>


<ul class="kwicks" id="kwicks-<?php echo $bID?>">
<?php    foreach ($kwicks_pics as $k=>$img) :?>	
	<li class="kwicks-element-<?php echo $k?>" data-width="<?php echo $elementWidth ?>">
			<?php    $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
			<?php    $ww = $ww < $img['width'] ?  $img['width'] : $ww; ?>
			<?php     if ($img['link']):?><a href='<?php    echo $img['link']?>'><?php  endif ?>
			<img src='<?php    echo $img['src']?>' width='<?php    echo $img['width']?>' height='<?php echo $img['height']?>' <?php  if ($title != 'blank') : ?>title='<?php echo $img['title']?>'<?php  endif ?> alt='<?php echo $img['alt']?>' rel='<?php echo $img['thumb']?>'  />
			<?php     if ($img['link']):?></a><?php  endif?>
	</li>
<?php     endforeach ?>
</ul>

<div style="clear:both"></div>

<style>
ul#kwicks-<?php echo $bID?> {
	width:<?php echo $width?>px;
	height:<?php echo $hh ?>px;
}
ul#kwicks-<?php echo $bID?> li {
	width : <?php echo $elementWidth ?>px;
}
</style>

<script type="text/javascript">
	$(document).ready(function() {

		var _kwicks = $('#kwicks-<?php  echo $bID?>');
		var maxHeight = 0;

	<?php if (in_array('homogenize_height', $options)) : ?>
		_kwicks.children().css({height : '<?php echo $hh ?>px'});
	<?php endif ?>		
		_kwicks.kwicks({
			max:<?php echo $percent?>,
			spacing:<?=$spacing?>,
			easing: '<?=$easing?>',
			duration:<?=$duration?>,
			<?=$defaultKwick ? "sticky : true, defaultKwick :" . ($defaultKwick - 1) .',' : '' ?> 
			event : '<?=$event?>',
			height : <?php echo $hh ?>
			
		});
	});
</script>
