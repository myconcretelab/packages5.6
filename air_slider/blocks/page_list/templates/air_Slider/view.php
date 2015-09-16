<?php 

defined('C5_EXECUTE') or die("Access Denied.");


/*************************************
  CUSTOMIZE Air Slider HERE
***************************************/

$image_resizing = false;    // Enable if you want to resize & crop with the size below
$image_width    = 960;     // the width od the image
$image_height   = 350;    // The Height of the image

$gallery_width  = 960;      // the width od the slider
$gallery_height = 350;    // The Height of the slider

$display_title  = true ; // IF YOU WANT TO SEE TITTLE
$display_desc   = true ;  // IF YOU WANT TO SEE DESCRIPTION
$link_text      = 'Read on >';  // THE BUTTON'S TEXT

$arrowInside    = false;    // Left/right navigation inside of the gallery_width container
$auto_play      = true;     //
$duration       = 5000;
$anim_duration  = 1000;
$easing         = 'easeInOutExpo';



/*******************************
  END CUSTOMIZE Air Slider 
********************************/

$time_start = microtime(true);

$c = Page::getCurrentPage();

if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:366px; background:rgba(100,223,223,.2)">
    <div style="padding: 180px 0px 0px 0px; color:rgba(200,200,200,.6)">
        <?php       echo t('Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php

else :

$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('image');
$count = 0;


$showRss = false;
if ($controller->rss) {
    $showRss = true;
    $rssUrl = $controller->getRssUrl($b);
    $rssTitle = $th->entities($controller->rssTitle);
    $btID = $b->getBlockTypeID();
    $bt = BlockType::getByID($btID);
    $rssIconSrc = Loader::helper('concrete/urls')->getBlockTypeAssetsURL($bt, 'rss.png');
    $rssInvisibleLink = '<link href="'.BASE_URL.$rssUrl.'" rel="alternate" type="application/rss+xml" title="'.$rssTitle.'" />';
    $translatedRssIconAlt = t('RSS Icon');
    $translatedRssIconTitle = t('RSS Feed');
}

$showPagination = false;
if ($paginate && $num > 0 && is_object($pl)) {
    $description = $pl->getSummary();
    if ($description->pages > 1) {
        $showPagination = true;
        $paginator = $pl->getPagination();
    }
}


/******************************************************************************
* DESIGNERS: CUSTOMIZE THE PAGE LIST HTML STARTING HERE...
*/

?>
<div id="airslider_<?php echo $bID ?>" class="airslider">
    <div class="background"></div>
   <div class="image"></div>
    
    <ul>
<?php  foreach ($pages as $n => $page):
    
    // Prepare data for each page being listed...

    $pageObj = Page::getByID($page->getCollectionID(), 1)->getVersionObject();
    $title = $th->entities($page->getCollectionName());
    $url = $nh->getLinkToCollection($page);
    $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
    $target = empty($target) ? '_self' : $target;

    $description = $page->getCollectionDescription();
    if ($controller->truncateSummaries) {
        $description = $th->shorten($description, $controller->truncateChars); //Concrete5.4.2.1 and lower
        //$description = $th->shortenTextWord($description, $controller->truncateChars); //Concrete5.4.2.2 and higher
    }

    $description = $th->entities($description);
    
    //Other useful page data...
    $date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
    $img = $page->getAttribute('page_thumbnail');

    if (is_object($img)) {
        if ($image_resizing) :
            $thumb['thumb'] = $ih->getThumbnail($img,$image_width, $image_height, true);
        else :
            $ize = @getimagesize($img->getPath());
            $thumb['thumb'] = $ih->getThumbnail($img,$ize[0], $ize[1]);
        endif;

        $caption_align = $img->getAttribute('caption_alignment') ? $img->getAttribute('caption_alignment') : $caption_align = 'L';
        $caption_align = $caption_align == 'L' ? 'left' : 'right';

        if ( ! $img->getAttribute('common_color_1'))
            AirSliderPackage::check_main_colors($img);                

        $thumb['color_1'] = $img->getAttribute('common_color_1');
        $colors[] =  $thumb['color_1'];
        
    } else {
        // All page without thumbnail are ignored
         continue;
    }   

    $hex = str_replace('#', '', $thumb['color1']);

    $c_r = hexdec(substr($hex, 0, 2));
    $c_g = hexdec(substr($hex, 2, 2));
    $c_b = hexdec(substr($hex, 4, 2));

    $text_color_class =  (((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000) > 130) ? 'darktext' : 'whitetext' ;
        ?>

        <li id="air_slider_banner_<?php echo $k + 1 ?>" class="<?php echo $caption_align ?>" data-background="<?php echo  $thumb['thumb']->src ?>" data-background-color="<?php echo $thumb['color_1']; ?>">
        
            <div class="text <?php echo $caption_align ?> <?php echo $text_color_class ?>">
                <?php if ($display_title) : ?><h2 class="<?php echo $text_color_class ?>"><?php echo $title ?></h2><?php endif ?>
                <?php if ($display_desc && $description ) : ?><?php echo $description ?><?php endif ?>
                <?php if ($url) : ?><a href="<?php echo $url ?>" class="button"><?php echo $link_text ?></a><?php endif?>
            </div>
        </li>



    <?php  endforeach; ?>
    </ul>
    <div class="navigation">
        <a href="javascript:void()" class="previous-slide"></a>
        <a href="javascript:void()" class="next-slide"></a>
    </div>
</div>

<?php  /* The rest of the template is for the RSS icon and pagination links, which generally don't need to be changed. */ ?>

    <?php  if ($showRss): ?>
        <div class="ccm-page-list-rss-icon">
            <a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo $translatedRssIconAlt; ?>" title="<?php  echo $translatedRssIconTitle; ?>" /></a>
        </div>
        <?php  echo $rssInvisibleLink ?>
    <?php  endif; ?>
 

<?php  if ($showPagination): ?>
    <div id="pagination">
        <div class="ccm-spacer"></div>
        <div class="ccm-pagination">
            <span class="ccm-page-left"><?php  echo $paginator->getPrevious('&laquo; Previous') ?></span>
            <?php  echo $paginator->getPages() ?>
            <span class="ccm-page-right"><?php  echo $paginator->getNext('Next &raquo;') ?></span>
        </div>
    </div>
<?php  endif; ?>
<div class="clear"></div>
<script>
    $(function () {
        var airslider_<?php echo $bID ?> = $('#airslider_<?php echo $bID ?>').airslider({
            width :<?php echo $gallery_width ?> ,
            auto_play : <?php echo $autoPlay ? 'true' : 'false'?>,
            duration: <?php echo $duration ?>,
            anim_duration: <?php echo $anim_duration ?>,
            anim_easing: '<?php echo $easing ?>'
        });
    });
</script>
<style type="text/css">
    #airslider_<?php echo $bID ?>, #airslider_<?php echo $bID ?> .background { height: <?php echo $gallery_height ?>px; background-color: <?php echo $colors[0] ?> }
    #airslider_<?php echo $bID ?> .image { height: <?php echo $gallery_height ?>px }
    #airslider_<?php echo $bID ?> .next-slide, #airslider_<?php echo $bID ?> .previous-slide { top: <?php echo $gallery_height / 2 ?>px }
    #airslider_<?php echo $bID ?> li , #airslider_<?php echo $bID ?> .navigation{ height: <?php echo $gallery_height ?>px; width: <?php echo $gallery_width ?>px }
    <?php if ($arrowInside) : ?>
    #airslider_<?php echo $bID ?> .next-slide { right: 10px } #airslider_<?php echo $bID ?> .previous-slide { left: 10px }
    <?php endif ?>
</style>

<?php $time_end = microtime(true);
$time = $time_end - $time_start;
?>
<!-- Slider Generated in <?php echo $time ?> secs -->
 <?php endif ?>



<?php
 
 ?>




