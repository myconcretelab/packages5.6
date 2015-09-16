<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<ul class="mmb-imageNav" id="mmb-imageNav_<?php echo $bID?>" style="padding-left: 0pt;">
<?php

$tooltip = false;	
// For each media in the list
foreach($types as $key=>$type) :
	// Get a array with two level.
	$mediaInfos = $controller->get_media_infos($type,$medias[$key],$titles[$key],$descs[$key],$widths[$key],$heights[$key]);
	// If it's a fileset, they a more than one media.
	//$this->controller->dump($mediaInfos);
	foreach($mediaInfos as $k=>$mi) :?>
	<? // Tester si l'utilisateur veut afficher toutes les images de son fileset ou seulement la premire.
	if ($type == 'fileset') {
		$display = 'fileset';
		if ( in_array('one', explode('_', $media_options[$key])) ) {
			$display = 'one';
			if ($k > 0) {
				$display = 'none';
			} 
		} else { $display = true; }
	} else { $display = true; }
	if ($display === 'one' || $display === 'none') {
		$title_gallery = 'Fileset_' . $key; 
	} else {
		$title_gallery = 'MB';
	}
	?>
	<?php if ($display !== 'none') :  ?>
	<li class="mmb-item-<?php echo $type?> mmb-item">
		<a href="<?php echo $mi['box_mediaURL']?>" rel="prettyPhoto<?php echo  $notAGallery ? '' : '[' . $title_gallery . '_' . $bID . ']'?>">
			<span><img src="<?php echo $glass->src?>" alt="" /></span>
			<?php echo $mi['img']?>
		</a>

		<?php
		$ti = in_array('show_title',$options) ;
		$de = in_array('show_desc',$options) ;
		// ObligŽ de faire comme a, sinon, parfois a plantait !! 
		if ($ti || $de) :
		$tooltip = true;
		?>		
		<div class="tooltip">
			<?php if (in_array('show_title',$options)): ?><h4 class="mmb-tooltip-title"><?php echo $mi['title'] != '' ? $mi['title']  : t('no title') ?></h4><?php endif ?>	
			<?php if (in_array('show_desc',$options)): ?><p class="mmb-tooltip-title"><?php echo $mi['desc'] != '' ? $mi['desc']  : t('no desc') ?></p><?php endif ?>	
		</div>
		<?php endif ?>	
	</li>
	<?php else : ?>
		<a style="display:none" href="<?php echo $mi['box_mediaURL']?>" rel="prettyPhoto<?php echo  $notAGallery ? '' : '[' . $title_gallery . '_' . $bID . ']'?>">&nbsp;</a>	
	<?php endif ?>
	<?php  endforeach ?>
<?php  endforeach ?>

</ul>
<div style="clear:both">&nbsp;</div>
<style>
#mmb-imageNav_<?php echo $bID?> li {
	width: <?php echo $thumb_size  ?>px;	
	height: <?php echo $thumb_size ?>px;
}

</style>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){

<?php if ($tooltip) : ?>	
/*
	$("#mmb-imageNav_<?php echo $bID?> .mmb-item > a").tooltip({
		// use the "slide" effect
			effect: 'slide',
			relative:true
		}).dynamic ({
		});
*/
<?php endif ?>
	
	$("#mmb-imageNav_<?php echo $bID?> a").prettyPhoto({
		// Setting available from administration panel : 
		slideshow: <?php echo $slideshow ? $slideshow : 'false'?>,
		autoplay_slideshow: <?php echo (in_array('autoplay_slideshow',$options) && $slideshow) ? 'true': 'false'?>,
		show_title: <?php echo in_array('show_lightbox_title',$options) ? 'true' : 'false' ?>, 
		allow_resize: <?php echo in_array('allow_resize',$options) ? 'true' : 'false' ?>,
		overlay_gallery: <?php echo in_array('overlay_gallery',$options) ? 'true' : 'false' ?>,
		theme:'<?php echo $template_options?>',
		// Customize yourself : 
		animation_speed: 'fast', /* fast/slow/normal */
		keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
		opacity: 0.80, /* Value between 0 and 1 */
		default_width: 500,
		default_height: 344,
		counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
		hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
		wmode: 'opaque', /* Set the flash wmode attribute */
		autoplay: true, /* Automatically start videos: True/False */
		modal: false /* If set to true, only the close button will close the window */
	});
});

</script>	
