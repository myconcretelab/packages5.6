function activateFancybox (selector) {
	$(selector).on('click', function (e) {
		e.preventDefault();
		var trigger = this;
		var t = $(trigger);
		// Les lien des <a> des produits en ajax sont mise dans des balise data pour eviter les clics sur les produits avnt que le javascript soit initié.
		if (t.attr('href') == "#")
			var link = t.data('href');
		else
			var link = t.attr('href');
		
	    $.fancybox([{	    	
	    	href : link
	    	}],{
	    	type:'ajax',
	    	padding:30,
	    	openEffect	: 'elastic',
	    	closeEffect	: 'elastic',
	    	helpers : {
	    		title : {
	    			type : 'inside'
	    		},
	    		overlay : {
	    			showEarly  : false
	    		}
	    	},
	    	beforeLoad :function () {
	    		t.addClass('load');
	    		
	    	}, 
	    	afterLoad : function (current) {
	    	},
	    	afterShow  : function() {
				$('.fancybox-wrap').contents().find('.image').imagesLoaded( function (images) {
					$(this).animate({opacity:1});
				});  
	        	$('.popup').addClass('loaded');
	        		t.removeClass('load');
	    	}
	    });	
    });	
}


$(document).ready(function(){

	$('.ajax').click(function(e){
		e.preventDefault();
		$.get($(this).attr('href'));
	});
	if (typeof(navigationOptions) == "object")
		$('#nav_tabs').boxNav('.submenu_panes',navigationOptions);
	// Le breadcrumb
	$("#jquery_breadcrumb").rcrumbs();
	 // les sliders
	 $('.bxslider').each(function(){
	 	e = $(this);
		var options = {
			mode:e.data('mode') ? e.data('mode') : 'horizontal',
		 	adaptiveHeight: true,
		 	slideMargin:30,
		 	controls : e.data('controls') ? false : true, // Active d'office
		 	nextText:'<i class="fa fa-angle-right"></i>',
		 	prevText:'<i class="fa fa-angle-left"></i>',
		 	pager:e.data('pagercustom') ? true : false,
		 	pagerCustom:e.data('pagercustom') ? e.data('pagercustom') : null,
		 	//pagerType:'short',
		 	video : e.data('video') ? true : false,
		 	carousel : e.data('carousel') ? true : false,
		 	minSlides : e.data('minslides') ? e.data('minslides') : 1,
		 	maxSlides : e.data('maxslides') ? e.data('maxslides') : 1,
		 	slideWidth : e.data('slidewidth') ? e.data('slidewidth') : 0,
		 	onSliderLoad : function (currentIndex) {
				 // Lightbox
				e.add($(e.data('dependency'))).addClass('loaded');
			 	if (typeof (bxSlideronSliderLoad) === 'function') bxSlideronSliderLoad(currentIndex);
		 		var f = e.data('callback');
		 		if (typeof(window[f]) === "function" )
				 	window[f](currentIndex);				 
		 	},
		 	onSlideAfter : function ($slideElement, oldIndex, newIndex) {
		 		if ($slideElement.data('rangeprice') && typeof(jQuery().ionRangeSlider) === 'function')
		 			$('.price_range').ionRangeSlider('update');
		 	}
		 };
		 e.bxSlider(options);
	 });
	
	 /*  
	 	Cette fonction a ete cree pour gerer des callback sur les requetes ajax
	 	callback sur le trigger et sur l'element chargé.
	 */
	
	activateFancybox ('._fancybox');
	
	/* --- Initiateur normal pour la gestion automatique --- */
	
	$('.fancybox').fancybox();

	/* --- Product panes <form> --- */

	$('.product-nav-pane').each(function(){
		var t = $(this);
		var f = t.find('.nav-pane-product-form');
		var c = t.find('input:checkbox');
		var a = t.find('input:checkbox:checked').size();
		t.find('.nav-pane-product-a').click(function(){
			// On decoche tout dans la maison
			c.attr('checked', false);
			// On check le input au dessus de lui
			t.find($(this).data('check')).attr('checked', true);
			// et on envoi le formulaire
			f.submit();
		})
		// On affiche le submit au click ou si plus de 1 checkbow est selectionné
		c.click(function(){
			a = t.find('input:checkbox:checked').size();
			// Si il y a au moins un checked
			if(a > 0) t.find('.nav-pane-product-submit').css('visibility','visible');
			// Sinon on cache
			else t.find('.nav-pane-product-submit').css('visibility','hidden');
		});
		if(a > 1) t.find('.nav-pane-product-submit').css('visibility','visible');
	});

	/* --- Des faux lien qui sont en fait des radio et qui soumettent le formulaire au clic-- */

	$('.fake-radio').click(function(e) {
		e.preventDefault();
		$(this).parents('form').submit();
	});
	$('.fake-radio-url').click(function(e) {
		document.location = $(this).find('input').val();
	});

	$( '#top_nav .meganizr li:has(ul)' ).doubleTapToGo();

	/* --- ImageZoom --- */
	$('.ImageZoom').each(function(){
		var t = $(this);
		var o = {
			type:'follow',
			zoomSize: [400,400],
			smoothMove:false
		};
		if (t.data('large')) o.bigImageSrc = t.data('large');
		t.ImageZoom(o);
	});

	 // Le footer
	 set_footer_height();

	 // Fixer le probleme des video sous le menu
	 if (FIX_IFRAME_ZINDEX) {
	    $('iframe').each(function(){
	          var url = $(this).attr("src");
	          var char = "?";
	          if (typeof url === 'string') {
		          if(url.indexOf("?") != -1){
		                  var char = "&";
		           }
		          $(this).attr("src",url+char+"wmode=transparent");
		      }
	    });	 
	}
	//	Mobile nav
	$('nav#mobile_nav').mmenu({counters	: false},
							  { 
								   pageSelector: "#pagewrapper"
								  //menuWrapperSelector:''
							  });
	
});

 
window.onload = function() {$('body').addClass('loaded')};




function set_footer_height () {
	// Si dans certain cas, le body est plus petit que la fenetre, le footer étant fixé dans le bas, cela crée des soucis visiuel
	if ($(window).height() > $('body').height() ) $('body').css('min-height',$(window).height());
	
	if(CCM_EDIT_MODE) return;
	// Si le contenu est trop petit par rapport a la taille de la fenetre, on l'agrandit
	if ($(window).height() > ($('#middle').height() + $('#top').height() + $('#bottom').height())) {
		$('#middle:not(.unbordered)').css('min-height', $(window).height() - $('#top').height() - $('#bottom').height() - $('#footer-note-wrapper').height()) ;
	}
	
	// Si il y a des element dans une des colonnes du footer, on regle la pushfooter
	$('.footer-item').each(function(){
		if($(this).children().size()) {
			// log($('#footer').innerHeight());
			$('#footerpush').css('min-height', $('#footer').innerHeight());
			return;
		}
	});

}

function is_int(value){ 
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      return true;
  } else { 
      return false;
  } 
}

/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
;(function( $, window, document, undefined )
{
	$.fn.doubleTapToGo = function( params )
	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function()
		{
			var curItem = false;

			$( this ).on( 'click', function( e )
			{
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] )
				{
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e )
			{
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};
})( jQuery, window, document );

(function(){var e,t,n,r,i,s,o,u,a,f;if(!(window.console&&window.console.log)){return}s=function(){var e;e=[];o(arguments).forEach(function(t){if(typeof t==="string"){return e=e.concat(a(t))}else{return e.push(t)}});return f.apply(window,e)};f=function(){return console.log.apply(console,o(arguments))};o=function(e){return Array.prototype.slice.call(e)};e=[{regex:/\*([^\*)]+)\*/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["font-style: italic",""]}},{regex:/\_([^\_)]+)\_/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["font-weight: bold",""]}},{regex:/\`([^\`)]+)\`/,replacer:function(e,t){return"%c"+t+"%c"},styles:function(){return["background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1)",""]}},{regex:/\[c\=\"([^\")]+)\"\]([^\[)]+)\[c\]/,replacer:function(e,t,n){return"%c"+n+"%c"},styles:function(e){return[e[1],""]}}];n=function(t){var n;n=false;e.forEach(function(e){if(e.regex.test(t)){return n=true}});return n};t=function(t){var n;n=[];e.forEach(function(e){var r;r=t.match(e.regex);if(r){return n.push({format:e,match:r})}});return n.sort(function(e,t){return e.match.index-t.match.index})};a=function(e){var r,i,s;s=[];while(n(e)){i=t(e);r=i[0];e=e.replace(r.format.regex,r.format.replacer);s=s.concat(r.format.styles(r.match))}return[e].concat(s)};i=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};r=function(){return/MSIE/.test(navigator.userAgent)};u=function(){var e;e=navigator.userAgent.match(/AppleWebKit\/(\d+)\.(\d+)(\.|\+|\s)/);if(!e){return false}return 537.38>=parseInt(e[1],10)+parseInt(e[2],10)/100};if(i()&&!u()||r()){window.log=f}else{window.log=s}window.log.l=f}).call(this)