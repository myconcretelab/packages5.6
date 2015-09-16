<?php        defined('C5_EXECUTE') or die(_("Access Denied."));
if (in_array('randomize', $options)) shuffle ($gal);
?>

<?php    $c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>

<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php    echo t('Nivo Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php    else : ?>
<div style="clear:both"></div>

<div class='nivo-wrapper slider-wrapper theme-<?php  echo $theme ?>' id="nivo-<?php  echo $bID?>_wrapper">
	<div class="ribbon"></div>
	<div class='nivoSlider' id='nivo-<?php  echo $bID?>_handler'>
	<?php      foreach ($gal as $img) : ?>
					<?php     $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
					<?php     $ww = $ww < $img['width'] ?  $img['width'] : $ww; ?>
				<?php      if ($img['isLink']):?><a href='<?php     echo $img['link']?>'><?php   endif ?>
				<img src='<?php     echo $img['src']?>' width='<?php     echo $img['width']?>' height='<?php  echo $img['height']?>' <?php   if ($title != 'blank') : ?>title='<?php  echo $img['title']?>'<?php   endif ?> alt='<?php  echo $img['alt']?>' rel='<?php  echo $img['thumb']?>'  />
				<?php      if ($img['isLink']):?></a><?php   endif?>
	<?php      endforeach ?>
	</div>
</div>
<div style="clear:both"></div>

<?php     endif ?>

<style>

#nivo-<?php  echo $bID?>_wrapper{
	height:<?php    echo $hh + (in_array('controlNav',$options) ? 80 : 0) ?>px;
	width:<?php  echo $ww ?>px;
	position:relative;
	}
<?php   if (in_array('controlNavThumbs', $options) && in_array('controlNav',$options)) : ?>
#nivo-<?php  echo $bID?>_wrapper .nivo-controlNav {
	bottom:-120px; /* Change this to adapt the position of thumb */
	text-align:center;
	z-index:500;
}
#nivo-<?php  echo $bID?>_wrapper  .nivo-controlNav a {
	display:block;
	width:50px;
	height:50px;
	background:none;
	border:0;
	margin-right:10px;
	text-indent:0;
	z-index:500;
}
#nivo-<?php  echo $bID?>_wrapper .nivo-controlNav a.active {
	background-position:-18px 0;
	text-indent:0;
}

<?php   endif ?>
</style>
<script type="text/javascript">
<?php 
// $controller are used here to compatibility with theme embeding
?>
$(document).ready(function() {
	$('#nivo-<?php  echo $bID?>_handler').nivoSlider({
		effect:'<?php  echo $controller->effect?>',
		slices:<?php  echo (int) $controller->slices?>,
		animSpeed:<?php  echo (int) $controller->animSpeed?>,
		pauseTime:<?php  echo (int) $controller->pauseTime?>,
		startSlide:<?php  echo (int) $controller->startSlide?>,
		boxCols:<?php  echo (int) $controller->boxCols?>,
		boxRows:<?php  echo (int)($controller->boxRows)?>,
		directionNav:<?php  echo in_array('directionNav',$options) ? 'true' : 'false'?>, 
		directionNavHide:<?php  echo in_array('directionNavHide', $options) ? 'true' : 'false'?>,
		controlNav:<?php  echo in_array('controlNav',$options) ? 'true' : 'false'?>,
		controlNavThumbs:<?php  echo in_array('controlNavThumbs',$options) ? 'true' : 'false'?>,
		controlNavThumbsFromRel:true,
		keyboardNav:<?php  echo in_array('keyboardNav', $options) ? 'true' : 'false'?>, 
		pauseOnHover:<?php  echo in_array('pauseOnHover',$options) ? 'true' : 'false'?> 
	});
	
	// Centrer la navigation	
	$nav = $('#nivo-<?php  echo $bID?>_handler .nivo-controlNav');
	$nav.css('left', <?php  echo $ww / 2 ?> - ($nav.width() / 2 ));
});

</script>