

jQuery(window).load(function() { // Load est utilisé car sinon la largeur des polices ne correspond pas.


});

jQuery(document).ready(function(){

	if (IS_EDIT_MODE ) return;

	if (IS_MOBILE ) {

		$('#mobile_nav').change(function(){
			document.location.href = $(this).val();
		})

		make_columns ();


	} else {	

		init_nav ();

		make_height () ;

	}
	make_slider (); 
	
    // Ajouter un span à chaque .section
    jQuery('.section').wrapInner('<span />');
    jQuery('#sidebar h3').addClass('section').wrapInner('<span />');
    
    // Vérifier si la sidebar est remplie. Si pas lui ajouter un contenu transparent evitant l'écrasement de sa largeur
    if (! jQuery('#sidebar').children().size() ) jQuery('#sidebar').html('<hr class="space" />')

    // add padding to 'padding' class
jQuery('.padding').wrapInner('<div class="padding-inner"></div>')

    // Ajouter de span ds les boutons
    jQuery('.butn').each(function () {

    	$this = jQuery(this).is('a') ? jQuery(this) : jQuery(this).find('a').addClass('butn') ;

    	if(!$this.children().size()) {
    		$this.wrapInner('<span />').after('<div class="clear"></div>');
    	};
    });
    
    $('#search-keywords').focus(function() {
    	$(this).val('');
    });
       //console.timeEnd('test 1');

   });

$('.simple_controls').each(function() {
	var $t = $(this);
	var $p = $t.parent();
	var $pw = $p.width();
	$t.css('left', ($pw / 2) - ($t.width() /2) + 'px');

});



function init_nav () {
	$onLoadSelected = jQuery('#main-nav>ul>li.nav-path-selected').add('#main-nav>ul>li.nav-selected');
 //   console.log('init nav');

 sf_animation = {opacity:'show',top:'show'};
 sf_speed = 150;

 if ( jQuery.browser.msie && (parseInt(jQuery.browser.version, 10) == 6 || parseInt(jQuery.browser.version, 10) == 7 || parseInt(jQuery.browser.version, 10) == 8) ) {
 	sf_animation = {height:'show'};
 	sf_speed = 0;

 };

 jQuery('#main-nav>ul').addClass('sue-main-nav').superfish({
 	animation:sf_animation,
 	speed:sf_speed,
 	delay:200,
 	disableHI:true
 });    
}

function make_height () {
	jQuery('div:regex(class,height-[0-9])').each(function() {
		reg = new RegExp("height-([0-9]+)","gi");
		height = reg.exec(jQuery(this).attr('class'));
		height =  height[0].replace(/height-/i,'');
		jQuery(this).height(parseInt(height)).addClass('height-resized');
	});

}


function make_columns () {
	if (DYNAMIC_COLUMNS) {
		$('.ccm-layout-wrapper').each(function () {

			if ( jQuery.browser.msie && (parseInt(jQuery.browser.version, 10) == 6 || parseInt(jQuery.browser.version, 10) == 7) ) return;

			var wr = $(this);

	    // Attention confli possible si ce script s'execute avant celui des accordions...
	    if (wr.is('.accordion-wrapper') || wr.is('.easyTabs-wrapper') || wr.is('ccm-easySlides-wrapper') || wr.is('multi-skins-tabs')) return;
	    
	    var ccm_layout = 	wr.children('.ccm-layout');
	    var ccm_layout_row = ccm_layout.children('.ccm-layout-row');
	    var ccm_layout_col = ccm_layout_row.children('.ccm-layout-col');
	    
	    ccm_layout.add(ccm_layout_row).add(ccm_layout_col).removeAttr('class').removeAttr('style');
	    
	    ccm_layout_row.addClass('row');
	    
	    if (ccm_layout_col.children().is('.ccm-layout-col-spacing')) ccm_layout_col.children().attr('class','');
	    
	    // le nombre d'éléments colonne pour ce wrapper
	    var ncol = (ccm_layout_col.size());

	    if (ncol > 1 && is_int(12/ncol)) {

		// La taille en css
		var col_size = 12 / ncol;

		// Debut de la boucle
		ccm_layout_col.each(function(index) {

			var $col = $(this);
			var last = index == (ncol -1);

			if (last) {
				$col.attr('style','').attr('class','last col_' + col_size);
			} else {
				$col.attr('style','').attr('class','col_' + col_size);
			}
		});
	}
});
}

}


function make_slider () {


	SLIDER_SETTINGS = {

		banner_height : 366,
		banner_width : 960,
	    //after_slide : function(c) {console.log(c)},
	    desktop_drag : true,
	    background_move : false,
	    //image_background : "fmslideshow_assets/bg2.png",

	    slideShow : false,
	    slideShow_delayTime : 2.5,
	    
	    image_sprite:THEME_PATH + '/images/slider/sprite.png',
	    image_loader:THEME_PATH + '/images/slider/loader_img.png',

	    
	    buttons_type : 0,
	    button_nextPrevious_type : 0,
	    
	    button_nextPrevious_type : 1,
	    button_next_align: 'BR',
	    button_previous_align: 'BL',
	    buttons_spacing: '-40,0'
	};


	$('.jq_fmslideshow').each(function(){
		$t = $(this);
		if ($t.attr('rel')) {
			var banner_width = $t.width();
			SLIDER_SETTINGS.banner_width = banner_width;
			jQuery.extend( SLIDER_SETTINGS, eval('SLIDER_CUSTOM_SETTINGS_' + $t.attr('rel')) );
		}
		$t.fmslideshow(SLIDER_SETTINGS);
	});
}









function isset () {
    // http://kevin.vanzonneveld.net
    var a = arguments,
    l = a.length,
    i = 0,
    undef;

    if (l === 0) {
    	throw new Error('Empty isset');
    }

    while (i !== l) {
    	if (a[i] === undef || a[i] === null) {
    		return false;
    	}
    	i++;
    }
    return true;
}


var easy_accordion_ready = function (t,b){ // t = titles, b = boxes
    jQuery(t).each(function(){ // Chaque titres
    	jQuery(this).prepend('<span></span>');
    });
}

/*
    jQuery regex from http://www.jquery.info/spip.php?article91
    
    */
    jQuery.expr[':'].regex = function(elem, index, match) {
    	if (match) {
    		var matchParams = match[3].split(','),validLabels = /^(data|css):/,attr = {method: matchParams[0].match(validLabels) ? matchParams[0].split(':')[0] : 'attr',property: matchParams.shift().replace(validLabels,'')},regexFlags = 'ig';
    		regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    		return regex.test(jQuery(elem)[attr.method](attr.property));
    	}
    }