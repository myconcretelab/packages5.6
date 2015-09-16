<?php       defined('C5_EXECUTE') or die(_("Access Denied."));

$gal =  $this->controller->getGallery();
$hh = 0;
$options = explode(',',$options);
?>
<?php   $c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>

<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php   echo t('Coin Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php   else : ?>

	<div class='coinSlider' id='coin-<?php echo $bID?>_handler'>
	<?php     foreach ($gal as $img) : ?>
				<?php    $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
				<?php    $hw = $hw < $img['width'] ?  $img['width'] : $hw; ?>
				<?php     if ($img['isLink']):?><a href='<?php    echo $img['link']?>'><?php  endif ?>
				<img src='<?php    echo $img['src']?>' width='<?php    echo $img['width']?>' height='<?php echo $img['height']?>' alt='<?php echo $img['alt']?>' rel='<?php echo $img['thumb']?>'  />
				 <?php  if ($title != 'blank') : ?><span><?php echo $img['title']?></span><?php  endif ?>
				<?php     if ($img['isLink']):?></a><?php  endif?>
	<?php     endforeach ?>
	</div>

<?php    endif ?>
<style>


#coin-slider-coin-<?php echo $bID?>_handler {
	width:<?php echo $hw?>px;
	}
</style>


<script type="text/javascript">

$(document).ready(function() {
	$('#coin-<?php echo $bID?>_handler').coinslider({
		width: <?php echo $hw?>, // width of slider panel
		height: <?php echo $hh?>, // height of slider panel
		spw: 	<?php echo $spw?>, // squares per width
		sph: 	<?php echo $sph?>, // squares per height
		delay: 	<?php echo $delay?>, // delay between images in ms
		sDelay: <?php echo $sDelay?>, // delay beetwen squares in ms
		opacity: <?php echo $opacity?>, // opacity of title and navigation
		titleSpeed: <?php echo $titleSpeed?>, // speed of title appereance in ms
		effect: '<?php echo $effect=='random' ? '' : $effect?>', // random, swirl, rain, straight
		navigation: <?php echo in_array('navigation', $options) ? 'true' : 'false'?>, // prev next and buttons
		links : true, // show images as links 
		hoverPause: <?php echo in_array('hoverPause', $options) ? 'true' : 'false'?> // pause on hover
	});
});

</script>