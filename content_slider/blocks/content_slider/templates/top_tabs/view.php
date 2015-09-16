<?php   defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php   $c = Page::getCurrentPage(); if ($c->isEditMode()) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'Content Slider<br />Content disabled in edit mode.')) ?>
<?php elseif ( !isset($blocks) ) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'No tabs to display.')) ?>
<?php else : ?>

<div class='top_tab_wrap'>
	<ul id="content_slider_tabs_control_<?php echo $bID ?>" class="controls top_tabs">
		<!-- Loop for controls -->
		<?php foreach($blocks as $k=>$b) : ?>
		<li class="control <?php echo $k == 0 ? 'active first_tab' :'' ?> control_<?php echo $k ?>">
			<span><?php echo $blockTitle[$k] ?></span>
		</li>
		<?php endforeach ?>    
		<!-- End Loop for controls -->
	</ul>
	
	<div class="slides top-slides">
		<ul class="content_slider content_top_slider" id="content_slider_<?php echo $bID ?>">
		<!-- Loop for content -->
			<?php foreach($blocks as $k=>$b) : ?>
			<li>
			    <div style=" width:<? echo $width ?>px; height:<?php echo $height ?>px" class="content_slide content_slide_<?php echo $k ?>">
				<div class="inner_slide inner_slide_<?php echo $k ?>">
				    <?php $bv = new BlockView() ?>
				    <?php echo  $bv->render($b, 'view') ?>
				</div>
			    </div>
			</li>
			<?php endforeach ?>    
		<!-- End Loop for content -->
		</ul>
	</div>
</div>

<?php endif ?>

<style type="text/css">

div.top-slides ul, .top-slides, .top-slides .inner_slide {	
	height:<?php echo $height ?>px;
	width:<? echo $width ?>px;
}
.top_tab_wrap {
	width:<? echo $width + 23 ?>px;
}
</style>

<script type="text/javascript">
    var NEXT_ELEMENT_STRING_ID_<?php echo $bID ?> = null;
    var PREV_ELEMENT_STRING_ID_<?php echo $bID ?> = null;
    var CONTROL_ELEMENT_STRING_ID_<?php echo $bID ?> = '#content_slider_tabs_control_<?php echo $bID ?>';

    var GALLERY_WIDTH_<?php echo $bID ?> = <?php echo $width ?>;
    var GALLERY_HEIGHT_<?php echo $bID ?> = <?php echo $height ?>;
</script>