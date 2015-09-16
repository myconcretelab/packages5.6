<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

$c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php        echo t('Advanced Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php        else : ?>
<div class="advanced-slider" id="advanced_slider_<?php      echo $bID?>">
	<ul class="slides">
<?php        foreach ($gallery as $n=>$img) : ?>
		 <li class="slide" data-image="<?php  echo $img['src']?>">
		 	<?php  if ($img['isLink']):?>
		 		<a href='<?php  echo $img['link']?>' target='<?php  echo $target_link?>'>
		 			  <img class="image" src="<?php  echo $block_url ?>/images/preloader.gif" alt="<?php  echo $img['title']?>"/>
		 		</a>
		 	<?php  endif ?>

		 	<img class="thumbnail" src="<?php  echo $img['thumb']?>" alt="thumb" />

		<?php      if (in_array('showCaption',$options) && $img['desc']) :?>
			<div class="caption"><?php  echo $caption == 'description' ? $tex->TextileThis($img['desc']) : $img['desc'] ?></div>
		<?php      endif ?>
	</li>
	<?php        endforeach ?>
	</ul>
</div> <!-- .#advanced_slider_<?php      echo $bID?> -->

	<?php      if (in_array('navigationButtons',$options)) : ?>
	<div style="height:50px;">&nbsp;</div>
	<?php         endif ?>
<?php         endif ?>
