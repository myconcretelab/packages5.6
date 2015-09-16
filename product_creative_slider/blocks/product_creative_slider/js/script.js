
$(document).ready(function(){
	 $('.pcs_slider').each(function(){
	 	var e = $(this);
	 	// SI l'element a déjà été initié on annule
	 	if (e.parent().hasClass('bx-viewport')) return;
		var options = {
			mode:e.data('mode') ? e.data('mode') : 'fade',
			// slideSelector : 'div.pcs_container',
		 	adaptiveHeight: true,
		 	slideMargin:30,
		 	controls : e.data('controls') ? false : true,
		 	nextText:'<i class="pcsicon-right"></i>',
		 	prevText:'<i class="pcsicon-left"></i>',
			
			auto : e.data('auto') ? true : false,
			pause : e.data('pause') ? e.data('pause') : 4000,
			autoControls: e.data('diapocontrols') ? false : true,
			startText:'<i class="pcsicon-play"></i>',
			stopText:'<i class="pcsicon-pause"></i>',
			autoControlsCombine : true,
			autoHover : true,
		 	
		 	pager:e.data('pagerposition') != 'none' ? true : false,
		 	pagerCustom:e.data('pagercustom') ? e.data('pagercustom') : null,
		 	//pagerType:'short',
		 	video : e.data('video') ? true : false,
		 	carousel : e.data('carousel') ? true : false,
		 	minSlides : e.data('minslides') ? e.data('minslides') : 1,
		 	maxSlides : e.data('maxslides') ? e.data('maxslides') : 1,
		 	slideWidth : e.data('slidewidth') ? e.data('slidewidth') : 0,
		 	onSliderLoad : function (currentIndex) {			
		 		var f = e.data('callback');
		 		if (typeof(window[f]) == "function" )
				 	window[f](currentIndex);
				e.addClass('loaded');
		 	}
		 };
		 e.bxSlider(options);
	 });

});
