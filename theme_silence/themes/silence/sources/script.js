


//-----------------  On Window Loaded  ----------------//
// ---------------------------------------------------//
jQuery(window).load(function () { // Load est utilisé car sinon la largeur des polices ne correspond pas.

    //-----------------   Main navigation  ----------------//
console.log('load');

    // Creer l'element d'animation
    $animate = jQuery('<li><div></div></li>').addClass('animate').css({
        'position': 'absolute'
    }).appendTo('#main-nav>ul');

    // Gestion de hover du top menu
    jQuery('#main-nav>ul>li').not('li.animate').bind('mouseenter touchstart', function () {
        animateTopMenu(jQuery(this));
    });

    jQuery('#main-nav>ul').bind('mouseleave', function () {
        animateTopMenu($onLoadSelected);
    });

    //-----------------   init the main navigation ----------------//

    animateTopMenu(null);

});

jQuery(document).ready(function () {

    if (RESPONSIVE)
        $('nav#mobile_nav').mmenu({},{selectedClass:'selected'});

    $( '#main-nav li:has(ul)' ).doubleTapToGo();

    if (IS_EDIT_MODE) return;

    init_nav();

    make_shadow();

    make_reflect();

    make_height();

    make_sortable();

    // add padding to 'padding' class
    jQuery('.padding').wrapInner('<div class="padding-inner"></div>');

    make_navigable();

    // Vérifier si la sidebar est remplie. Si pas lui ajouter un contenu transparent evitant l'écrasement de sa largeur
    if (!jQuery('#sidebar').children().size()) jQuery('#sidebar').html('<hr class="space" />');

    // Ajouter de span ds les boutons
    jQuery('.butn').each(function () {
        //console.log(jQuery(this).find('a').addClass('butn'));
        $this = jQuery(this).is('a') ? jQuery(this) : jQuery(this).find('a').addClass('butn');
        // Si il n'y a pas déjà un span
        if (!$this.children().size()) {
            txt = $this.html();
            $this.html('<span>' + txt + '</span>');
        };
    });

    $('#search-keywords').focus(function () {
        $(this).val('');
    });
    //console.timeEnd('test 1');

});

$('.simple_controls').each(function () {
    var $t = $(this);
    var $p = $t.parent();
    var $pw = $p.width();
    $t.css('left', ($pw / 2) - ($t.width() / 2) + 'px');

});



//---------------------- Working functions ------------------//

function make_shadow() {
    jQuery('.bottom-shadow, .bottom-shadow-transparent, .fly-shadow, .fly-shadow-transparent').each(function () {

        if (jQuery.browser.msie && (parseInt(jQuery.browser.version, 10) == 6 || parseInt(jQuery.browser.version, 10) == 7)) return;

        var $this = jQuery(this);
        var $parent = $this.parent(); // servira a verifier si le parent à un z-index

        if ($this.is('.bottom-shadow, .bottom-shadow-transparent')) classes = "WarpShadow WLarge WNormal";
        if ($this.is('.fly-shadow, .fly-shadow-transparent')) classes = "BottomShadow BSmall BNormal";

        if ($this.is('img')) { // Il faut entourer les image d'un div pour les ombres
            $img = $this;
            var wrap = jQuery($img.wrap('<div class="' + classes + '" />')).parent();
            wrap.height($img.height()).width($img.width());
            $parent = wrap.parent();
            //$parent.css('position')
            $this = wrap;

        } else if ($this.children().length == 1 && $this.children().is('img')) { // Si on a entouré l'image d'un div (qui n'est pas à la bonne taille)
            $img = $this.children('img');
            var wrap = jQuery($img.wrap('<div class="' + classes + '" />')).parent();
            wrap.height($img.height()).width($img.width());
            $parent = wrap.parent();
            //$parent.css('position')
            $this = wrap;

        } else {
            if (!$this.is('.bottom-shadow-transparent')) $this.addClass('WLarge WNormal'); // PAs beau si il n'y a pas de fond // A refaire pour le fly
            $this.addClass(classes).css('overflow', 'visible');
        }
        if (parseInt($this.width()) < 380) $this.addClass('smallBox');


        if ($parent.css('z-index') == 'auto' || !$parent.css('z-index')) {
            $parent.css({
                'z-index': 0
            });
        }
        if ($parent.css('position') == 'static') $parent.css({
            position: 'relative'
        });

    })
}

function init_nav() {
    
    $onLoadSelected = jQuery('#main-nav>ul>li.nav-path-selected').add('#main-nav>ul>li.nav-selected');

    // Definir clairement les elements du premier niveau pour une compatibilite CSS et ie6

    jQuery('#main-nav>ul, #main-nav>ul>li, #main-nav>ul>li>a, #main-nav>ul>li>a>span').addClass('first-level');
    jQuery('#main-nav>ul').addClass('silence-main-nav');
}

function make_reflect() {
    jQuery('.image-reflect-l').each(function () {
        var $this = jQuery(this);
        if ($this.is('img')) $this.reflect({
            height: 25,
            opacity: 0.3
        });
        else $this.find('img').reflect({
            height: 25,
            opacity: 0.3
        });
    });
    jQuery('.image-reflect-m').each(function () {
        var $this = jQuery(this);
        if ($this.is('img')) $this.reflect({
            height: 25,
            opacity: 0.3
        });
        else $this.find('img').reflect({
            height: 50,
            opacity: 0.3
        });
    });
    jQuery('.image-reflect-h').each(function () {
        var $this = jQuery(this);
        if ($this.is('img')) $this.reflect({
            height: 100,
            opacity: 0.5
        });
        else $this.find('img').reflect({
            height: 100,
            opacity: 0.5
        });
    });
}

function make_height() {
    jQuery('div:regex(class,height-[0-9])').each(function () {
        reg = new RegExp("height-([0-9]+)", "gi");
        height = reg.exec(jQuery(this).attr('class'));
        height = height[0].replace(/height-/i, '');
        jQuery(this).height(parseInt(height)).addClass('height-resized');
    });

}

function make_sortable() {
    jQuery('.ccm-page-list-sortable').each(function () {

        var $container = jQuery('.isotope-container', this),
            $elements = jQuery('.element', this),
            maxHeight = 0;

        $elements.each(function (index) {
            if (jQuery(this).height() > maxHeight) maxHeight = jQuery(this).height();
        });
        $elements.each(function () {
            jQuery(this).height(maxHeight + 50); // 50 est la valeur du padding .. ?
        });

        $container.isotope({
            itemSelector: '.element',
            getSortData: {
                number: function ($elem) {
                    var number = $elem.hasClass('element') ? $elem.find('.number').text() : $elem.attr('data-number');
                    return parseInt(number, 10);
                },
                alphabetical: function ($elem) {
                    var name = $elem.find('.name'),
                        itemText = name.length ? name : $elem;
                    return itemText.text();
                }
            }
        });

        var $optionSets = jQuery('.filter-panel .option-set', this);

        if ($optionSets.size()) {

            var $optionLinks = $optionSets.find('a');

            $optionLinks.click(function () {
                var $this = jQuery(this);
                // don't proceed if already selected
                if ($this.hasClass('selected')) {
                    return false;
                }
                var $optionSet = $this.parents('.option-set');
                $optionSet.find('.selected').removeClass('selected');
                $this.addClass('selected');

                var options = {},
                key = $optionSet.attr('data-option-key'),
                    value = $this.attr('data-option-value');

                value = value === 'false' ? false : value;
                options[key] = value;
                if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
                    // changes in layout modes need extra logic
                    changeLayoutMode($this, options)
                } else {
                    // otherwise, apply new options
                    $container.isotope(options, function () {
                        // Callback
                    });
                }
                return false;
            });

        }

    });
}


function make_navigable() {
    jQuery('.ccm-page-list-navigable').each(function () {

        var $navigable = jQuery(".navigable", this),
            wrapper_width = $navigable.width(),
            _interval = $navigable.data('interval'),
            _speed = $navigable.data('speed');

        if ($navigable.is('.diaporama')) var _autoplay = true;
        else var _autoplay = false;
        jQuery('.navigable-group-item', this).width(wrapper_width);

        var first_group_height = jQuery('.navigable-group-item:first-child', $navigable).height() + 30; // 30 for shadow bottom
        $navigable.height(first_group_height);

        $navigable.scrollable({
            items: '.navigable-items',
            circular: _autoplay ? true : false, // Set to true if diaporama or just for fun :-)
            speed: _speed,
            onBeforeSeek: function (e, index) {
                var element = jQuery(this.getItems()[index]),
                    current_element_height = element.height() + 30; // 30 for shadow bottom;
                if (current_element_height != 30) $navigable.animate({
                    height: current_element_height
                });
            }
        }).navigator();
        if (_autoplay) {
            $navigable.autoscroll({
                interval: _interval
            });
        }
    });

}


var easy_accordion_ready = function (t, b) { // t = titles, b = boxes
    jQuery(t).each(function () { // Chaque titres
        jQuery(this).addClass('gradient shadow').prepend('<span></span>');
    });
}

/*
    jQuery regex from http://www.jquery.info/spip.php?article91
    
*/
jQuery.expr[':'].regex = function (elem, index, match) {
    if (match) {
        var matchParams = match[3].split(','),
            validLabels = /^(data|css):/,
            attr = {
                method: matchParams[0].match(validLabels) ? matchParams[0].split(':')[0] : 'attr',
                property: matchParams.shift().replace(validLabels, '')
            }, regexFlags = 'ig';
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g, ''), regexFlags);
        return regex.test(jQuery(elem)[attr.method](attr.property));
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
                    parents   = $( e.target ).parents();

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

