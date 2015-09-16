<?php defined('C5_EXECUTE') or die(_("Access Denied."));

if (Page::getCurrentPage()->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:<?php echo $height  ?>px">
    <div style="padding: <?php echo $height / 2 ?>px 0px 0px 0px;">
        <?php       echo t('Blade Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php       elseif (!is_array($gallery)) : ?>
    <div style="padding: 30px 0px 0px 0px" class="alert-message block-message error">
        <?php       echo t('Error, no pictures found !')?>
    </div>
<?php else : ?>    


<div class="cj-banner" 

    data-width="<?php echo $width ?>"
    data-height="<?php echo $height ?>" 
    data-cols="<?php echo $cols ?>" 
    data-rows="<?php echo $rows ?>" 
    data-autoPlay="<?php echo in_array('autoPlay', $options) ? 'true' : 'false' ?>" 
    data-randomizeSlides="<?php echo in_array('randomizeSlides', $options) ? 'true' : 'false' ?>"
    data-thumbSpacing="<?php echo $thumbSpacing ?>" 
    data-slideDelay="<?php echo $slideDelay ?>" 
    data-useArrows="<?php echo in_array('useArrows', $options) ? 'true' : 'false' ?>" 
    data-arrowPadding="<?php echo $arrowPadding ?>"
    data-transitionType="<?php echo $transitionType ?>" 
    data-linkTarget="self"	
>

	<ul>
<?php foreach ($gallery as $k => $image) : ?>
    	<li title="<?php echo $image['src'] ?>">

            <!-- "class" options are "align-left" and "align-right", thsese are the text-align options -->
            <!-- "title" attribute is optional.  If added it will link the entire slide to the url entered -->
        	<ul class="align-<?php echo $image['caption_align'] ?>" <?php if ($image['link']) : ?>title="<?php echo $link ?>"<?php endif?>>
            	<?php if (in_array('display_title', $options)) : ?><li class="20x140" style="background-color: <?php echo $image['color1']; ?>; color: #<?php echo ( $controller->color_tool($image['color1']) > 130 ) ? '333333' : 'eeeeee' ?>"><?php echo $image['title'] ?></li><?php endif ?>
                <?php if (in_array('display_desc', $options) && $image['desc'] ) : ?><li class="20x195" style="background-color: <?php echo $image['color2']; ?>; color: #<?php echo ( $controller->color_tool($image['color2']) > 130 ) ? '333333' : 'eeeeee' ?>"><?php echo $image['desc'] ?></li><?php endif ?>
            </ul>
        </li>
<? endforeach; ?>
	</ul>
</div>
<?php endif ?>