<?php   defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php   $c = Page::getCurrentPage(); if ($c->isEditMode()) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'Content Slider<br />Content disabled in edit mode.')) ?>
<?php elseif ( !isset($blocks) ) : ?>
<?php Loader::packageElement('square_mode','content_slider',array('message'=>'No tabs to display.')) ?>
<?php else : ?>

<div class='content_lateral_slider_wrap content_lateral_slider_wrap_<?php echo $bID ?>'>
	<ul class="content_slider content_lateral_slider" id="content_slider_<?php echo $bID ?>">
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
	<ul id="content_slider_lateral_controls_<?php echo $bID ?>" class="controls lateral_controls">
		<!-- Loop for controls -->
		<?php foreach($blocks as $k=>$t) : ?>
		<li class="control <?php echo $k == 0 ? 'active' :'' ?> control_<?php echo $k?>">
			<h2><?php echo $blockTitle[$k]  ?></h2>
			<p><?php echo $blockDescription[$k] ?></p>
			<?php if ($thumbs[$k]) : // Aditional picture ?>
			<img src="<?php echo $thumbs[$k]?>" alt="<?php echo $thumbs[$k]?>" />
			<?php endif ?>
		</li>
		<?php endforeach ?>    
		<!-- End Loop for controls -->
	</ul>
</div>


<?php endif ?>

<style type="text/css">
.content_lateral_slider_wrap_<?php echo $bID ?> {
    height:<?php echo $height ?>px;
    width:<? echo $width + 220 ?>px;;
}
ul#content_slider_<?php echo $bID ?> {	
    height:<?php echo $height ?>px;
    width:<?php echo $width ?>px;
}
#content_slider_lateral_controls_<?php echo $bID ?> {
    height:<?php echo $height ?>px;
}
</style>

<script type="text/javascript">
    /* <?php echo $bID ?> is used here to have UNIQUE variable. If you need only one slider per page, no need to use <?php echo $bID ?> */
    var NEXT_ELEMENT_STRING_ID_<?php echo $bID ?> = null;
    var PREV_ELEMENT_STRING_ID_<?php echo $bID ?> = null;
    var CONTROL_ELEMENT_STRING_ID_<?php echo $bID ?> = '#content_slider_lateral_controls_<?php echo $bID ?>';
    // Don't remove: Used by init_javascript.php
    var BLOCK_ID_<?php echo $bID ?> = <?php echo $bID ?>;
    var GALLERY_WIDTH_<?php echo $bID ?> = <?php echo $width ?>;
    var GALLERY_HEIGHT_<?php echo $bID ?> = <?php echo $height ?>;
    
        // run when the slider is ready
    $.fn.onUltimateSliderReady_<?php echo $bID ?> = function(opts) {        
         $ul_<?php echo $bID ?> = $('#content_slider_lateral_controls_<?php echo $bID ?>' );
         $height_<?php echo $bID ?> = $('li:first-child', $ul_<?php echo $bID ?>).height();
        //console.log($height);
         $animation_nav_<?php echo $bID ?> = $('<li></li>').appendTo($ul_<?php echo $bID ?>).addClass('nav_animation');
         jQuery.easing.def = "easeInOutSine";
    }
    // When slide start to change (click or diaporama)
    var ON_START_SLIDE_FUNCTION_<?php echo $bID ?> = function (n) {
        $animation_nav_<?php echo $bID ?>.stop(true).animate({top:n * $height_<?php echo $bID ?>});
    }
    
</script>
