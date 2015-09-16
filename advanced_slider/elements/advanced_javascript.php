<?php      defined('C5_EXECUTE') or die(_("Access Denied."));


?>

$(document).ready(function() {
        $('#advanced_slider_<?php      echo $bID?>').advancedSlider({


        skin:'<?php      echo $block->skin ? $block->skin : 'round' ?>',
		scrollbarSkin:'<?php      echo $block->scrollbarSkin ? $block->scrollbarSkin : 'scrollbar-1' ?>',
        
        width:'<?php      echo $block->gallery_width ? $block->gallery_width : '100%' ?>',
        height:'<?php      echo $block->gallery_height ? $block->gallery_height : '100%' ?>',
        aspectRatio : <?php  echo $aspectRatio ? $aspectRatio : -1 ?>,
        scaleType : '<?php  echo $scaleType ? $scaleType : 'proportionalFit' ?>', // Indicates the scale type of the slide images. Available values are: 'insideFit', 'outsideFit', 'proportionalFit', 'exactFit' and 'noScale'.
        alignType : 'centerCenter', // Indicates the alignment of the image if its size is higher than the specified width or height. Available values are: 'leftTop', 'leftCenter', 'leftBottom', 'centerTop', 'centerCenter', 'centerBottom', 'rightTop', 'rightCenter', 'rightBottom'
        allowScaleUp : true, // Allows the image to scale up to a size larger than the original size.
        preloadNearbyImages : 2,

        slideshow:<?php      echo in_array('slideshow', $options) ? 'true' : 'false'?>,
        slideshowDelay:<?php      echo $block->slideshowDelay?>,
        slideshowControls:<?php      echo in_array('slideshowControls', $options) ? 'true' : 'false'?>,
		// slidesPreloaded:<?php      echo $block->slidesPreloaded?>,
        shuffle:<?php      echo in_array('shuffle', $options) ? 'true' : 'false'?>,
	shadow:<?php      echo in_array('shadow', $options) ? 'true' : 'false'?>,
	
	<?php      Loader::packageElement('preset_options_javascript','advanced_slider',array('bID'=>$bID,'cID'=>$cID,'pID'=> $block->globalImagePID)) ?>,
    
        slideProperties:{
        <?php      foreach($imagePID as $key=>$pID) :
                if ($pID == $block->globalImagePID || $pID == 0) continue;
                echo $key . ':' . '{';
                Loader::packageElement('preset_options_javascript','advanced_slider',array('bID'=>$bID,'cID'=>$cID,'pID'=> $pID));
                echo '}';
                echo $key == ($useful[count($useful)-1]) ? '' : ',';
                echo "\r\r\t";
        endforeach ?> },


        timerAnimation:<?php      echo in_array('timerAnimation', $options) ? 'true' : 'false'?>,
        timerFadeDuration:500,
		timerToggle:false,
		timerRadius:18,
		timerStrokeColor1:'#000000',
		timerStrokeColor2:'#FFFFFF',
		timerStrokeOpacity1:0.5,
		timerStrokeOpacity2:0.7,
		timerStrokeWidth1:8,
		timerStrokeWidth2:4,
		
		fadeInDuration:600,
		fadeOutDuration:500,
                
                slideArrows:<?php      echo in_array('navigationArrows', $options) ? 'true' : 'false'?>,
                slideArrowsToggle:<?php      echo in_array('hideNavigationArrows', $options) ? 'true' : 'false'?>,
		slideArrowsShowDuration:500,
		slideArrowsHideDuration:500,
                slideButtons:<?php      echo in_array('navigationButtons', $options) ? 'true' : 'false'?>,
		slideButtonsNumber:<?php      echo in_array('navigationButtonsNumbers', $options) ? 'true' : 'false'?>,
		slideButtonsToggle:false,
		slideButtonsShowDuration:500,
		slideButtonsHideDuration:500,
                slideButtonsCenter:<?php      echo in_array('navigationButtonsCenter', $options)? 'true' : 'false' ?>,
		slideButtonsContainerCenter:true,
		
		thumbnailType:'<?php   echo $block->thumbnailsType ? $block->thumbnailsType : 'none' ?>',
		thumbnailWidth:80,
		thumbnailHeight:50,
		thumbnailSlideAmount:10,
		thumbnailSlideDuration:300,
		thumbnailSlideEasing:'swing',
		
		fadeNavigationThumbnails:false,
		navigationThumbnailsCenter:true,
		thumbnailScrollDuration:1000,
		thumbnailScrollEasing:'swing',
		maximumVisibleThumbnails:5,
		thumbnailOrientation:'<?php   echo $block->thumbnailOrientation ? $block->thumbnailOrientation : 'horizontal' ?>',
		thumbnailTooltip:false,
		tooltipShowDuration:300,
		tooltipHideDuration:300,
		
		thumbnailCaptionPosition:'bottom',
		hideThumbnailCaption:true,
		thumbnailCaptionEffect:'slide',
		thumbnailCaptionShowDuration:500,
		thumbnailCaptionHideDuration:500,
		thumbnailCaptionEasing:'swing',
		thumbnailScrollbar:<?php      echo in_array('thumbnailScrollbar', $options) ? 'true' : 'false'?>,
		thumbnailButtons:false,
		thumbnailArrows:true,
		fadeThumbnailButtons:false,
		fadeThumbnailArrows:false,
		fadeThumbnailScrollbar:<?php      echo in_array('fadeThumbnailScrollbar', $options) ? 'true' : 'false'?>,
		scrollbarArrowScrollAmount:100,
		navigationThumbnailsHideDuration:500,
		navigationThumbnailsShowDuration:500,
		thumbnailArrowsHideDuration:500,
		thumbnailArrowsShowDuration:500,
		thumbnailButtonsHideDuration:500,
		thumbnailButtonsShowDuration:500,
		thumbnailScrollbarHideDuration:500,
		thumbnailScrollbarShowDuration:500,
		thumbnailSync:true,
		thumbnailMouseScroll:false,
		thumbnailMouseScrollEase:90,
		thumbnailMouseScrollSpeed:10,
		thumbnailMouseWheel:false,
		thumbnailMouseWheelSpeed:20,
		thumbnailMouseWheelReverse:false,
		thumbnailScrollbarEase:10,
		
		hideCaption:false,
		captionSize:70,
		captionBackgroundOpacity:0.5,
		captionBackgroundColor:'#000000',
		captionShowEffect:'slide',
		captionShowEffectDuration:500,
		captionShowEffectEasing:'swing',
		captionShowSlideDirection:'auto',
		captionHideEffect:'fade',
		captionHideEffectDuration:300,
		captionHideEffectEasing:'swing',
		captionHideSlideDirection:'auto',
		captionPosition:'bottom',
		captionLeft:50,
		captionTop:50,
		captionWidth:300,
		captionHeight:100,
		
		linkTarget:'_blank',
		slideOpen:null,
		slideClick:null,
		slideMouseOver:null,
		slideMouseOut:null,
		transitionStart:null,
		transitionComplete:null         
        });
});
