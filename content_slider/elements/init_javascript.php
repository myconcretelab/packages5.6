<?php defined('C5_EXECUTE') or die(_("Access Denied."));

$b = Block::getByID($bID);
if(!is_object($b)) { die(t('Invalid Paremeters')); } 
$bp = new Permissions($b);
// if(!$bp->canRead()) { die(t('Permission Denied')); }
$block = $b->getInstance();
$types = ContentSliderBlockController::php2js(explode(',',$block->type));
?>

$(document).ready(function() {
    var options_<?php echo $bID ?> = {
            delay: <?php echo $block->delay ? $block->delay : 999999 ?>,
            next:NEXT_ELEMENT_STRING_ID_<?php echo $bID ?>,
            prev:PREV_ELEMENT_STRING_ID_<?php echo $bID ?>,
            controls:CONTROL_ELEMENT_STRING_ID_<?php echo $bID ?>,
            type:<?php echo $types ?>,
            onend:null,
            onstart:function (n) {
               try {
                    ON_START_SLIDE_FUNCTION_<?php echo $bID ?> (n);
                    } catch(err) {}
            } 
    };
    // Regler la taille du premier niveau des 'li' pour être compatible avec ie6
    if (GALLERY_WIDTH_<?php echo $bID ?> && GALLERY_HEIGHT_<?php echo $bID ?>) {
        $('ul#content_slider_<?php echo $bID ?> > li').css({
            width:GALLERY_WIDTH_<?php echo $bID ?>,
            height:GALLERY_HEIGHT_<?php echo $bID ?>
        });    
    }
    try {
        // onUltimateSliderReady is not always set, that's why we put in 'try'
        $('ul#content_slider_<?php echo $bID ?>').svUltimateSlider(options_<?php echo $bID ?>).onUltimateSliderReady_<?php echo $bID ?>();    
    } catch (err) {};

});

<?php


