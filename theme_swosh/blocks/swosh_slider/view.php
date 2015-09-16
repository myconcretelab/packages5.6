<?php  defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:100px">
    <div style="padding: 30px 0px 0px 0px">
        <?php       echo t('Sliced Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php else : ?>
<div class="wrapper">
    <div id="swosh-slider" class="swosh-slider">
        <ul class="swosh-slider-large">
<?foreach ($files as $k => $file) :
    $link = false;
    $link_text = t('Go');
    
    if ($file->getAttribute('link_url') )
        $link = $file->getAttribute('link_url');
    
    if ($file->getAttribute('link_text') ) 
        $link_text = $file->getAttribute('link_text');


?>
    <li>
        <img src="<?php echo $ih->getThumbnail($file,2500,400,true)->src?>" alt="image<?php echo $k?>" />
        <div class="ei-title">
            <?php if ($title) : ?><h1><?php echo $this->controller->getFileFieldValue($file,$title)?></h1><?php endif ?>
            <?php if ($description && $this->controller->getFileFieldValue($file,$description)) : ?><h3><?php echo $this->controller->getFileFieldValue($file,$description)?></h3><?php endif ?>
            <?php if ($link) : ?><a href="<?php echo $link ?>" class="button"><?php echo $link_text ?></a><?php endif?>
        </div>
    </li>
<?php endforeach ?>

</ul><!-- swosh-slider-large -->
<ul class="swosh-slider-thumbs" style="z-index:0">
	<li class="swosh-slider-element">Current</li>
<?foreach ($files as $k => $file) :?>		
		<li><a href="#">Slide 1</a><img src="<?php echo $ih->getThumbnail($file,200,100,true)->src?>" alt="thumb01" /></li>
<?php endforeach ?>
        </ul><!-- swosh-slider-thumbs -->
    </div><!-- swosh-slider -->
 </div><!-- wrapper -->
<script type="text/javascript">	
            $(function() {
                $('#swosh-slider').swoshslider({
					easing		: 'easeOutExpo',
					titleeasing	: 'easeOutExpo',
					titlespeed	: 1200,
                    slideshow_interval : <?php echo $slideshow_interval ?>,
                    autoplay : <?php echo $autoplay ? 'true' : 'false'?>
                });
            });
</script>
 <!-- <div class="blankSeparator"></div> -->
 <?php endif ?>