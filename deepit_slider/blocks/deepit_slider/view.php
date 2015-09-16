<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<?php   $c = Page::getCurrentPage();
if ($c->isEditMode()) :
?>

<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php   echo t('Deepit Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php   else : ?>
<div class="deepit" id="deepit_<?php echo $bID?>">
<?php   foreach ($gal as $n=>$img) : ?>
<?php    $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
<?php     if ($img['isLink']):?><a href='<?php    echo $img['link']?>'><?php  endif ?>
<img src='<?php    echo $img['src']?>' width='<?php    echo $img['width']?>' height='<?php echo $img['height']?>' <?php  if ($title != 'blank') : ?>title='<?php echo $img['title']?>'<?php  endif ?> alt='<?php echo $img['alt']?>' <?php if($caption != 'blank')?>rel='caption_<?php echo $n.$bID?>'/>
<?php     if ($img['isLink']):?></a><?php  endif?>
<?php $thumb[] = $img['thumb'] ?>
<?php   endforeach ?>
</div>

<?php if ($captionPosition != 'none') :?>
	<?php $tex = Loader::helper('textile','deepit_slider') ?>
	<?php   foreach ($gal as $n=>$img) : ?>
		<?php if ($img['desc']) : ?>
		<div id="caption_<?php echo $n.$bID?>" class="<?php echo $captionPosition?>">
			<?php echo $caption == 'description' ? $tex->TextileThis($img['desc']) : $img['desc'] ?>		
		</div>
		<?php endif ?>
	<?php endforeach ?>
<?php endif ?>


<style>
<? if (is_array($layer_files)) : ?>
<?php foreach ($layer_files as $n=>$lf) :
	$img = File::getByID($lf);
?>
	.layer_<?php echo $n.$bID?> {
		background:url('<?php echo $img->getRelativePath();?>');
	}
<?php endforeach?>
<? endif ?>
#deepit_<?php echo $bID?> .dpit-slider-frame {
	width:<?php echo $gal[0]['width']?>px;
	height:<?php echo $gal[0]['height']?>px;
}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('#deepit_<?php echo $bID?>').deepitSlider({
			animSpeed:<?php echo $animSpeed?>,
			liquidLayout:<?php echo in_array('liquidLayout', $options) ? 'true' : 'false'?>,
			pauseTime:<?php echo $pauseTime ?>,
			arrowsNav:<?php echo in_array('arrowsNav', $options) ? 'true' : 'false'?>,
			arrowsNavHide:<?php echo in_array('arrowsNavHide', $options) ? 'true' : 'false'?>,
			listNav:<?php echo in_array('listNav', $options) ? 'true' : 'false'?>,
			<?php if (in_array('listNavThumbs', $options)) : ?>
			listNavThumbUrl:<?php echo $this->controller->php2js($thumb) ?>,
			<?php endif ?>
			autoStart: <?php echo in_array('autoStart', $options) ? 'true' : 'false'?>,
			pauseOnHover: <?php echo in_array('pauseOnHover', $options) ? 'true' : 'false'?>,
			listNavThumbs: <?php echo in_array('listNavThumbs', $options) ? 'true' : 'false'?>,
			caption: '<?php echo $captionPosition ?>',
			<? if (is_array($layer_files)) : ?>
			layers: {
			<?php foreach ($layer_files as $n=>$lf) : ?>
layer_<?php echo $n.$bID?>: {
					className: 'layer_<?php echo $n.$bID?>',
					offset: <?php echo $offsets[$n]?>,
					direction: '<?php echo $directions[$n]?>'
				}<?php echo count($layer_files) == $n+1 ? '' : ','?><?php endforeach ?>
			},
			<? endif ?>
			autoLoop: <?php echo in_array('autoLoop', $options) ? 'true' : 'false'?>
			
		});
	});
</script>
<?php    endif ?>
