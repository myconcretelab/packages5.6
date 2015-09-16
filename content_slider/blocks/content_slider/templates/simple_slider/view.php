<?php   defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php   $c = Page::getCurrentPage(); if ($c->isEditMode()) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'simple Slider<br />content disabled in edit mode.')) ?>
<?php elseif ( !isset($blocks) ) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'No tabs to display.')) ?>
<?php else : ?>

<div class='simple_slider_wrap'>
	<ul class="simple_slider" id="content_slider_<?php echo $bID ?>">
		<!-- Loop for content -->
		<?php foreach($blocks as $k=>$b) : ?>
		<li>
		    <div class="simple_slide simple_slide_<?php echo $k ?>">
			<div class="inner_slide inner_slide_<?php echo $k ?>">
			    <?php $bv = new BlockView() ?>
			    <?php echo  $bv->render($b, 'view') ?>
			</div>
		    </div>
		</li>
		<?php endforeach ?>    
		<!-- End loop for content -->
	</ul>
	<ul id="simple_controls_<?php echo $bID ?>" class="simple_controls">
		<!-- Loop for controls -->
		<?php foreach($blocks as $k=>$t) : ?>
		<li class="simple_control <?php echo $k == 0 ? 'active' :'' ?> simple_control_<?php echo $k ?>">
			<div><span><?php echo $blockTitle[$k] ?></span></div>
		</li>
		<?php endforeach ?>    
		<!-- End loop for controls -->
	</ul>
	<a href="#" class='simple_prev_nav simple_nav'></a>
	<a href="#" class='simple_next_nav simple_nav'></a>
</div>
<div style="height:40px">&nbsp;</div>

<?php endif ?>

<style type="text/css">

ul.simple_slider, .simple_slide, .simple_slider_wrap {
	height:<?php echo $height ?>px;
	width:<?php echo $width ?>px;
}	

</style>

<script type="text/javascript">
	var NEXT_ELEMENT_STRING_ID_<?php echo $bID ?> = '.simple_next_nav';
	var PREV_ELEMENT_STRING_ID_<?php echo $bID ?> = '.simple_prev_nav';
	var CONTROL_ELEMENT_STRING_ID_<?php echo $bID ?> = '#simple_controls_<?php echo $bID ?>';
	
	var GALLERY_WIDTH_<?php echo $bID ?> = <?php echo $width ?>;
	var GALLERY_HEIGHT_<?php echo $bID ?> = <?php echo $height ?>;
</script>