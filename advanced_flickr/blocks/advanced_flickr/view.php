<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<ul class="adv-flickr-nav">
  <li></li>
</ul>
<div class="adv-flickr-gallery">
  <div class="bulle"></div>
  <a href="#" class="arrow-left" onclick="slideToLeft(); return false">&nbsp;</a>
<div id="adv-flickr-wrapper-<?=$bID?>" class="adv-flickr-wrapper">
  <div id="adv-flickr-slider-<?=$bID?>" class="adv-flickr-slider">
    
    <div id="photo-tags" class="adv-flickr-slide">
    <? $controller->makeTagCloud(); ?>
    </div>

    <div id="photo-collection" class="adv-flickr-slide">
    </div>
    
    <div id="photo-sets" class="adv-flickr-slide">
    </div>
    
  </div>
</div>
</div>

<script>
var CurrentSlideIndex   = 0;
var callerIndex         = 0;
var $wrapper            = $('#adv-flickr-wrapper-<?=$bID?>');
var $slider             =  $wrapper.children('.adv-flickr-slider');
var $galleryPanels      = $slider.children();
var numberOfSlides      = $galleryPanels.length;
var $galleryWidth       = $wrapper.width();

// Set this width on each element with '.adv-flickr-slide' class
$galleryPanels.css('width',$galleryWidth+'px');
// ...and multiply this width with the nb of panels
$slider.css('width',($galleryWidth * ($galleryPanels.length + 1 ) + 'px'));

function log(s) {
  console.log(s);
}

function slide (witch) {
    callerIndex = CurrentSlideIndex;
    CurrentSlideIndex = $galleryPanels.index(witch);
    $wrapper.scrollTo(witch ,400,{onAfter:function(){
        // If we come back from photos pages, we need to remove all pages
        if (callerIndex > CurrentSlideIndex && witch.is('#photo-sets')) {
          // clean the photo Pages
          $('.photos-page, .clearfix', $slider).remove();
          // Remove pages's item from the list 
          $galleryPanels = $galleryPanels.not('.photos-page');
        }
      destinationPanelHeight = (witch.height() < 100) ? 100 : witch.height(); // Min height don't work;
      $wrapper.animate({height:witch.height()},'slow');
    }
    });
}
function slideToLeft() {
  if (CurrentSlideIndex > 0 ) {
    slide ($($galleryPanels[CurrentSlideIndex-1]));
  } else {
    // Already at the first slide
  }
  return false;
}

function getPhotoCollection () {
  showIconLoad('load');
  $.get('<?= str_replace("&amp;","&",$this->action('outputCollections')) ?>',function(data){
  showIconLoad('normal');
    $slider.children('#photo-collection').html(data).find('a').hoverIntent(function(){
      b = $(this).find('div').clone();
      p = $(this).position();
      $('.bulle')
          .html(b)
          .css({'bottom':(p.top+100),'left':p.left})
          .animate({bottom:(p.top+90),opacity: "show"},'slow');
      
      }, function() {
        $('.bulle').hide();  
      });
    slide ($slider.children('#photo-collection'));
  return false;
  });
}

function getPhotosets (psIDs) {
  showIconLoad('load');
  $.get('<?= str_replace("&amp;","&",$this->action('outputPhotosets')) ?>',{"psIDs":psIDs},function(data){
  showIconLoad('normal');
    $slider.children('#photo-sets').html(data).find('a').hoverIntent(function(){
      b = $(this).find('div').clone();
      p = $(this).position();
      $('.bulle')
          .html(b)
          .css({'bottom':(p.top+100),'left':p.left})
          .animate({bottom:(p.top+90),opacity: "show"},'slow');
      
      }, function() {
        $('.bulle').css('display','none');  
      });
    slide ($slider.children('#photo-sets'));
  });
  return false;
}

function getPhotosetsPhotos (psID,page) {
  showIconLoad('load');
  container = 'photos_page_' + page;
  $container = $('#photos_page_' + page);
  if ($container.size() != 0) {
    // The photo container already exist
    if ($container.children('.photo-th').size() > 0) {
      // they are already photo inside
      showIconLoad('normal');
      slide( $container );
    }
  } else {
    // create the photo container
    $container = $('<div></div>')
                          .attr('id',container)
                          .addClass('adv-flickr-slide photos-page')
                          .css({'width':$galleryWidth})
                          .appendTo($slider);
    $container.after('<div style="clear:both" class="clearfix"></div>');
    // Add this container to the list
   $galleryPanels = $galleryPanels.add($container);
  }
  $.get('<?= str_replace("&amp;","&",$this->action('outputPhotosetsPhotos')) ?>',{"psID":psID, 'page':page},function(data){
    $container.html(data);
    showIconLoad('normal');
    slide( $container); // If page 1 -> 2+1 = 3 ...
    $container.children("a.photo-th").prettyPhoto({overlay_gallery:false});
  });
  //return false;
}
function searchPhotos (type, data){
    showIconLoad('load');
  $.get('<?= str_replace("&amp;","&",$this->action('searchPhotos')) ?>',{"type":type, 'data':data},function(data){
   showIconLoad('normal');
   $('#photos').html(data);
    slide($slider.children('#photo-collection'));
    $("#adv-flickr-wrapper-<?=$bID?> #photos a").prettyPhoto({overlay_gallery:false});
  });
  return false;
}
function showIconLoad (statut) {
  switch(statut) {
    case 'load':
      $('.arrow-left').css('background-image','url(<?=$this->getBlockUrl()?>/images/loader.gif)');
      break;
    case 'normal':
      $('.arrow-left').css('background-image','url(<?=$this->getBlockUrl()?>/images/arrow-left.png)');
      break;    
  }
}
getPhotoCollection();

</script>