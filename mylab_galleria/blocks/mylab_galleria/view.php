<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
if (Page::getCurrentPage()->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:<?php echo $height ?>px; background-color:<?php echo $myColor?>; width:<?php echo $width?>px">
	<div style="padding: <?php echo ($height / 2 ) ?>px 0px 0px 0px">
		<?php       echo t('Jquery Galleria<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php       else : ?>

<?php  if (is_array($gal)) : ?>
<div class='c5-galleria'>
        <ul id='galleria_<?php    echo $bID?>_handler' class="c5Galleria galleria_<?php    echo $bID?>">
                <?php     foreach ($gal as $g) : ?>
                        <li>
                                <a  <?php  if ($g['lightbox_src']) : ?> rel="<?php  echo $g["lightbox_src"]?>"  <?php  endif ?> href="<?php  echo $g["src"]?>">                        
                               
                                        <img src='<?php    echo $g["thumb_src"]?>' width='<?php    echo $g["width"]?>' height='<?php    echo $g["height"]?>' title='<?php    echo $g["title"]?>' alt='<?php    echo $g["desc"]?>' 
                                        rel='<?php    echo $g["desc"]?>' style="display:none"/>
                                </a>
                        </li>
                <?php     endforeach; ?>
        </ul>
</div>

<?php  endif ?>

<?php if ($theme == 'classic') ?>

<style type="text/css">
        .galleria-container {
                background:<?php echo $myColor ?>;
        }
</style>

<script type="text/javascript">

$(document).ready(function(){

                Galleria.loadTheme('<?php    echo $this->controller->get_theme_relative_path() ?>');

                
                $('ul#galleria_<?php    echo $bID?>_handler').galleria({
                        <?php    echo $width > 0 ? "width:$width,\n" : " "?>
                        <?php    echo $height > 0 ? "height:$height,\n" : " "?>
                        <?php if ($slideShow) : ?> autoplay:<?php echo $slideShowSpeed ? $slideShowSpeed : 3000 ?>,<?php endif ?>
                        history :               <?php    echo $history ? "true":"false"?>,
                        carousel :              true<?php    //$carousel ? "true":"false"?>,
                        carousel_follow :       <?php    echo $carouselFollow ? "true":"false"?>,
                        carousel_speed :        <?php    echo $carouselSpeed?>,
                        carousel_steps :        '<?php    echo $carouselSteps?>',
                        image_crop :            <?php    echo $imageCrop ? "true":"false"?>,
                        image_margin :          <?php    echo $imageMargin?>,
                        max_scale_ratio :       <?php    echo $maxScaleRatio ? $maxScaleRatio : '0'?>,
                        popup_links :           <?php    echo $popupLinks ? "true":"false"?>,
                        preload :               <?php    echo $preload ? "true":"false"?>,
                        thumbnails :            <?php    echo $thumbnails ? "true":"false"?>,
                        thumb_crop  :           <?php    echo $thumbCrop ? "true":"false"?>,
                        thumb_margin :          <?php    echo $thumb_margin ? $thumb_margin :'0' ?>,
                        transition :            '<?php    echo $transition?>',
                        transition_speed :      <?php    echo $transitionSpeed?>,
                        slide_show  :           <?php    echo $slideShow ? "true":"false"?>,
                        slide_show_speed :      <?php    echo $slideShowSpeed ? $slideShowSpeed : '3000' ?>,
                        lightbox:               <?php    echo $lightbox ? "true":"false"?>,
                        imagePan:               <?php    echo $imagePan ? "true":"false"?>  
        });
});

</script>

<?php  endif ?>