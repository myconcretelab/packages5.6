<?php      defined('C5_EXECUTE') or die(_("Access Denied."));
$hh = 0;
?>

        <ul class='c5-roundabout-handler' id='roundabout_<?php   echo $bID?>_handler'>
<?php    foreach ($rg as $img) : ?>
		
		<?php   $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
                <li>
                        <?php    if ($img['isLink']):?><a href='<?php   echo $img['link']?>'><?php    endif?>
                        <?php if ($img['title']) : ?>
				<span><?php   echo $img['title']?><br />
				<?php if ($img['desc']) : ?>
					<i><?php   echo $img['desc']?></i> 
				<?php endif ?>
				</span>
			<?php endif ?>
                        <img src='<?php   echo $img['src']?>' width='<?php   echo $img['width']?>' height='<?php   echo $img['height']?>' title='<?php   echo $img['desc']?>' alt='<?php   echo $img['title']?>'  />
                        <?php    if ($img['isLink']):?></a><?php    endif?>
                </li>
<?php    endforeach ?>
        </ul>

<div style="clear:both">&nbsp;</div>

<style>
.roundabout-moveable-item {
        width:<?php   echo $width?>px;
        height:<?php   echo $height?>px;
	background:#ffffff;
}
.roundabout-holder {
	height:<?php  echo $height?>px;
	}
#roundabout_<?php   echo $bID?>_handler li img {
	width: 100%;
	height: 100%;
	}

</style>
<script type="text/javascript">

$(document).ready(function() {
   $('#roundabout_<?php   echo $bID?>_handler').roundabout({
      shape:      "<?php   echo $shape ? $shape : 'lazySusan'?>",
      duration:    <?php   echo $duration?>, 
      minOpacity:  <?php   echo $minOpacity?>,
      minScale:    <?php   echo $minScale?>,
      easing:     "<?php   echo $easing?>",
      reflect:     true,
      maxZ :       <?php   echo ( is_array($rg) ? count($rg) : count($scrapbookBlocks) ) + 4?>,
      minZ:4
   });
});

</script>
<!--
-->