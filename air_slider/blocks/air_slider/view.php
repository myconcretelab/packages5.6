<?php defined('C5_EXECUTE') or die(_("Access Denied."));

if (Page::getCurrentPage()->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:<?php echo $gallery_height  ?>px">
    <div style="padding: <?php echo $gallery_height / 2 ?>px 0px 0px 0px;">
        <?php       echo t('Air Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php       elseif (!is_array($gallery)) : ?>
    <div style="padding: 30px 0px 0px 0px" class="alert-message block-message error">
        <?php       echo t('Error, no pictures found !')?>
    </div>
<?php else : ?>    


<div id="airslider_<?php echo $bID ?>" class="airslider">
    <div class="background"></div>
   <div class="image"></div>
    
    <ul>
        <?php foreach ($gallery as $k => $image) : 
        $text_color_class =  $controller->color_tool($image['color1']) > 130 ? 'darktext' : 'whitetext' ;
        ?>

        <li id="air_slider_banner_<?php echo $k + 1 ?>" class="<?php echo $image['caption_align'] ?>" data-background="<?php echo $image['src'] ?>" data-background-color="<?php echo $image['color1']; ?>">
        
            <div class="text <?php echo $image['caption_align'] ?> <?php echo $text_color_class ?>">
                <?php if (in_array('display_title', $options)) : ?><h2 class="<?php echo $text_color_class ?>"><?php echo $image['title'] ?></h2><?php endif ?>
                <?php if (in_array('display_desc', $options) && $image['desc'] ) : ?><?php echo $tex->TextileThis($image['desc']) ?><?php endif ?>
                <?php if ($image['link']) : ?><a href="<?php echo $link ?>" class="button"><?php echo $image['link_text'] ?></a><?php endif?>
            </div>
        </li>
<? endforeach; ?>
</ul>
    <div class="navigation">
        <a href="javascript:void()" class="previous-slide">
        </a>
        <a href="javascript:void()" class="next-slide">
        </a>
    </div>
    <script>
        $(function () {
            var airslider_<?php echo $bID ?> = $('#airslider_<?php echo $bID ?>').airslider({
                width :<?php echo $gallery_width ?> ,
                auto_play : <?php echo in_array('autoPlay', $options) ? 'true' : 'false'?>,
                duration: <?php echo $duration ?>,
                anim_duration: <?php echo $anim_duration ?>,
                anim_easing: '<?php echo $easing ?>'
            });
        });
    </script>
    <style type="text/css">
        #airslider_<?php echo $bID ?>, #airslider_<?php echo $bID ?> .background { height: <?php echo $gallery_height ?>px; background-color: <?php echo $gallery[0]['color1'] ?> }
        #airslider_<?php echo $bID ?> .image { height: <?php echo $gallery_height ?>px }
        #airslider_<?php echo $bID ?> .next-slide, #airslider_<?php echo $bID ?> .previous-slide { top: <?php echo $gallery_height / 2 ?>px }
        #airslider_<?php echo $bID ?> li , #airslider_<?php echo $bID ?> .navigation{ height: <?php echo $gallery_height ?>px; width: <?php echo $gallery_width ?>px }
        <?php if (in_array('arrowInside', $options)) : ?>
        #airslider_<?php echo $bID ?> .next-slide { right: 10px } #airslider_<?php echo $bID ?> .previous-slide { left: 10px }
        <?php endif ?>
    </style>
</div>
<?php endif ?>