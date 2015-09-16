/*
  mcolorpicker
  Version: 1.0 r35
  
  Copyright (c) 2010 Meta100 LLC.
  http://www.meta100.com/
  
  Licensed under the MIT license 
  http://www.opensource.org/licenses/mit-license.php 
*/

// After this script loads set:
// To use manually call like any other jQuery plugin
// $('input.foo').mcolorpicker({options})
// options:
// imageFolder - Change to move image location.
// swatches - Initial colors in the swatch, must an array of 10 colors.
// hex - true or false
// init:
// $.fn.mcolorpicker.init.enhancedSwatches - Turn of saving and loading of swatch to cookies.
// $.fn.mcolorpicker.init.allowTransparency - Turn off transperancy as a color option.
// $.fn.mcolorpicker.init.showLogo - Turn on/off the meta100 logo (You don't really want to turn it off, do you?).

(function($){

  var $o;

  $.fn.mcolorpicker = function(options) {

    $o = $.extend($.fn.mcolorpicker.defaults, options);  

    // Add trailing slash to imageFolder if needed:
    if ($o.imageFolder.charAt($o.imageFolder.size) != '/') $o.imageFolder = $o.imageFolder + '/';

    if ($o.swatches.length < 10) $o.swatches = $.fn.mcolorpicker.defaults.swatches
    if ($("div#mcolorpicker").length < 1) $.fn.mcolorpicker.drawPicker();

    if ($('#css_disabled_color_picker').length < 1) $('head').prepend('<style id="css_disabled_color_picker" type="text/css">.mcolorpicker[disabled] + span, .mcolorpicker[disabled="disabled"] + span, .mcolorpicker[disabled="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;}</style>');

    $('.mcolorpicker').live('keyup', function () {

      try {
  
        $(this).css({
          'background-color': $(this).val()
        }).css({
          'color': $.fn.mcolorpicker.textColor($(this).css('background-color'))
        }).trigger('change');
      } catch (r) {}
    });

    $('.mcolorpickerTrigger').live('click', function () {

      $.fn.mcolorpicker.colorShow($(this).attr('id').replace('icp_', ''));
    });

    this.each(function () {

      $.fn.mcolorpicker.drawPickerTriggers($(this));
    });

    return this;
  };

  $.fn.mcolorpicker.currentColor = false;
  $.fn.mcolorpicker.currentValue = false;
  $.fn.mcolorpicker.color = false;

  $.fn.mcolorpicker.init = {
    replace: '[type=color]',
    index: 0,
    enhancedSwatches: true,
    allowTransparency: true,
  	checkRedraw: 'DOMUpdated', // Change to 'ajaxSuccess' for ajax only or false if not needed
  	liveEvents: false,
    showLogo: false
  };

  $.fn.mcolorpicker.defaults = {
    imageFolder: CCM_REL + '/packages' + '/theme_super_mint' + "/images/mcolorpicker/",
    swatches: [
      "#ffffff",
      "#ffff00",
      "#00ff00",
      "#00ffff",
      "#0000ff",
      "#ff00ff",
      "#ff0000",
      "#4c2b11",
      "#3b3b3b",
      "#000000"
    ]
  };

  $.fn.mcolorpicker.liveEvents = function() {

    $.fn.mcolorpicker.init.liveEvents = true;

    if ($.fn.mcolorpicker.init.checkRedraw && $.fn.mcolorpicker.init.replace) {

      $(document).bind($.fn.mcolorpicker.init.checkRedraw + '.mcolorpicker', function () {

        $('input[data-mcolorpicker!="true"]').filter(function() {
    
          return ($.fn.mcolorpicker.init.replace == '[type=color]')? this.getAttribute("type") == 'color': $(this).is($.fn.mcolorpicker.init.replace);
        }).mcolorpicker();
      });
    }
  };

  $.fn.mcolorpicker.drawPickerTriggers = function ($t) {

    if ($t[0].nodeName.toLowerCase() != 'input') return false;

    var id = $t.attr('id') || 'color_' + $.fn.mcolorpicker.init.index++,
        hidden = false;

    $t.attr('id', id);
  
    if ($t.attr('text') == 'hidden' || $t.attr('data-text') == 'hidden') hidden = true;

    var color = $t.val(),
        width = ($t.width() > 0)? $t.width(): parseInt($t.css('width'), 10),
        height = ($t.height())? $t.height(): parseInt($t.css('height'), 10),
        flt = $t.css('float'),
        image = (color == 'transparent')? "url('" + $o.imageFolder + "/grid.gif')": '',
        colorPicker = '';

    $('body').append('<span id="color_work_area"></span>');
    $('span#color_work_area').append($t.clone(true));
    colorPicker = $('span#color_work_area').html().replace(/type="color"/gi, '').replace(/input /gi, (hidden)? 'input type="hidden"': 'input type="text"');
    $('span#color_work_area').html('').remove();
    $t.after(
      (hidden)? '<span style="cursor:pointer;border:1px solid black;float:' + flt + ';width:' + width + 'px;height:' + height + 'px;" id="icp_' + id + '">&nbsp;</span>': ''
    ).after(colorPicker).remove();   

    if (hidden) {

      $('#icp_' + id).css({
        'background-color': color,
        'background-image': image,
        'display': 'inline-block'
      }).attr(
        'class', $('#' + id).attr('class')
      ).addClass(
        'mcolorpickerTrigger'
      );
    } else {

      $('#' + id).css({
        'background-color': color,
        'background-image': image
      }).css({
        'color': $.fn.mcolorpicker.textColor($('#' + id).css('background-color'))
      }).after(
        '<span style="cursor:pointer;" id="icp_' + id + '" class="mcolorpickerTrigger"><img src="' + $o.imageFolder + 'color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>'
      ).addClass('mcolorpickerInput');
    }

    $('#icp_' + id).attr('data-mcolorpicker', 'true');

    $('#' + id).addClass('mcolorpicker');

    return $('#' + id);
  };

  $.fn.mcolorpicker.drawPicker = function () {

    $(document.createElement("div")).attr(
      "id","mcolorpicker"
    ).css(
      'display','none'
    ).html(
      '<div id="mcolorpickerWrapper"><div id="mcolorpickerImg" class="mColor"></div><div id="mcolorpickerImgGray" class="mColor"></div><div id="mcolorpickerSwatches"><div class="mClear"></div></div><div id="mcolorpickerFooter"><input type="text" size="8" id="mcolorpickerInput"/></div></div>'
    ).appendTo("body");

    $(document.createElement("div")).attr("id","mcolorpickerBg").css({
      'display': 'none'
    }).appendTo("body");

    for (n = 9; n > -1; n--) {

      $(document.createElement("div")).attr({
        'id': 'cell' + n,
        'class': "mPastColor" + ((n > 0)? ' mNoLeftBorder': '')
      }).html(
        '&nbsp;'
      ).prependTo("#mcolorpickerSwatches");
    }

    $('#mcolorpicker').css({
      'border':'1px solid #ccc',
      'color':'#fff',
      'z-index':999998,
      'width':'194px',
      'height':'184px',
      'font-size':'12px',
      'font-family':'times'
    });

    $('.mPastColor').css({
      'height':'18px',
      'width':'18px',
      'border':'1px solid #000',
      'float':'left'
    });

    $('#colorPreview').css({
      'height':'50px'
    });

    $('.mNoLeftBorder').css({
      'border-left':0
    });

    $('.mClear').css({
      'clear':'both'
    });

    $('#mcolorpickerWrapper').css({
      'position':'relative',
      'border':'solid 1px gray',
      'z-index':999999
    });
    
    $('#mcolorpickerImg').css({
      'height':'128px',
      'width':'192px',
      'border':0,
      'cursor':'crosshair',
      'background-image':"url('" + $o.imageFolder + "colorpicker.png')"
    });

    $('#mcolorpickerImgGray').css({
      'height':'8px',
      'width':'192px',
      'border':0,
      'cursor':'crosshair',
      'background-image':"url('" + $o.imageFolder + "graybar.jpg')"
    });
    
    $('#mcolorpickerInput').css({
      'border':'solid 1px gray',
      'font-size':'10pt',
      'margin':'3px',
      'width':'80px'
    });
    
    $('#mcolorpickerImgGrid').css({
      'border':0,
      'height':'20px',
      'width':'20px',
      'vertical-align':'text-bottom'
    });
    
    $('#mcolorpickerSwatches').css({
      'border-right':'1px solid #000'
    });
    
    $('#mcolorpickerFooter').css({
      'background-image':"url('" + $o.imageFolder + "grid.gif')",
      'position': 'relative',
      'height':'26px'
    });

    if ($.fn.mcolorpicker.init.allowTransparency) $('#mcolorpickerFooter').prepend('<span id="mcolorpickerTransparent" class="mColor" style="font-size:16px;color:#000;padding-right:30px;padding-top:3px;cursor:pointer;overflow:hidden;float:right;">transparent</span>');
    if ($.fn.mcolorpicker.init.showLogo) $('#mcolorpickerFooter').prepend('<a href="http://meta100.com/" title="Meta100 - Designing Fun" alt="Meta100 - Designing Fun" style="float:right;" target="_blank"><img src="' +  $o.imageFolder + 'meta100.png" title="Meta100 - Designing Fun" alt="Meta100 - Designing Fun" style="border:0;border-left:1px solid #aaa;right:0;position:absolute;"/></a>');

    $("#mcolorpickerBg").click($.fn.mcolorpicker.closePicker);
  
    var swatch = $.fn.mcolorpicker.getCookie('swatches'),
        i = 0;

    if (typeof swatch == 'string') swatch = swatch.split('||');
    if (swatch == null || $.fn.mcolorpicker.init.enhancedSwatches || swatch.length < 10) swatch = $o.swatches;

    $(".mPastColor").each(function() {

      $(this).css('background-color', swatch[i++].toLowerCase());
    });
  };

  $.fn.mcolorpicker.closePicker = function () {

    $(".mColor, .mPastColor, #mcolorpickerInput, #mcolorpickerWrapper").unbind();
    $("#mcolorpickerBg").hide();
    $("#mcolorpicker").fadeOut()
  };

  $.fn.mcolorpicker.colorShow = function (id) {
    var $e = $("#icp_" + id);
        pos = $e.offset(),
        $i = $("#" + id);
        hex = $i.attr('data-hex') == 'true' || $i.attr('hex') == 'true' || $o.hex,
        pickerTop = pos.top + $e.outerHeight(),
        pickerLeft = pos.left,
        $d = $(document),
        $m = $("#mcolorpicker");

    if ($i.attr('disabled')) return false;

                // KEEP COLOR PICKER IN VIEWPORT
                if (pickerTop + $m.height() > $d.height()) pickerTop = pos.top - $m.height();
                if (pickerLeft + $m.width() > $d.width()) pickerLeft = pos.left - $m.width() + $e.outerWidth();
  
    $m.css({
      'top':(pickerTop) + "px",
      'left':(pickerLeft) + "px",
      'position':'absolute'
    }).fadeIn("fast");
  
    $("#mcolorpickerBg").css({
      'z-index':999990,
      'background':'black',
      'opacity': .01,
      'position':'absolute',
      'top':0,
      'left':0,
      'width': parseInt($d.width(), 10) + 'px',
      'height': parseInt($d.height(), 10) + 'px'
    }).show();
  
    var def = $i.val();
  
    $('#colorPreview span').text(def);
    $('#colorPreview').css('background', def);
    $('#color').val(def);
  
    if ($('#' + id).attr('data-text')) $.fn.mcolorpicker.currentColor = $e.css('background-color');
    else $.fn.mcolorpicker.currentColor = $i.css('background-color');

    if (hex) $.fn.mcolorpicker.currentColor = $.fn.mcolorpicker.RGBtoHex($.fn.mcolorpicker.currentColor);

    $("#mcolorpickerInput").val($.fn.mcolorpicker.currentColor);
  
    $('.mColor, .mPastColor').bind('mousemove', function(e) {
  
      var offset = $(this).offset();

      $.fn.mcolorpicker.color = $(this).css("background-color");

      if ($(this).hasClass('mPastColor') && hex) $.fn.mcolorpicker.color = $.fn.mcolorpicker.RGBtoHex($.fn.mcolorpicker.color);
      else if ($(this).hasClass('mPastColor') && !hex) $.fn.mcolorpicker.color = $.fn.mcolorpicker.hexToRGB($.fn.mcolorpicker.color);
      else if ($(this).attr('id') == 'mcolorpickerTransparent') $.fn.mcolorpicker.color = 'transparent';
      else if (!$(this).hasClass('mPastColor')) $.fn.mcolorpicker.color = $.fn.mcolorpicker.whichColor(e.pageX - offset.left, e.pageY - offset.top + (($(this).attr('id') == 'mcolorpickerImgGray')? 128: 0), hex);

      $.fn.mcolorpicker.setInputColor(id, $.fn.mcolorpicker.color);
    }).click(function() {
  
      $.fn.mcolorpicker.colorPicked(id);
    });
  
    $('#mcolorpickerInput').bind('keyup', function (e) {
  
      try {
  
        $.fn.mcolorpicker.color = $('#mcolorpickerInput').val();
        $.fn.mcolorpicker.setInputColor(id, $.fn.mcolorpicker.color);
    
        if (e.which == 13) $.fn.mcolorpicker.colorPicked(id);
      } catch (r) {}

    }).bind('blur', function () {
  
      $.fn.mcolorpicker.setInputColor(id, $.fn.mcolorpicker.currentColor);
    });
  
    $('#mcolorpickerWrapper').bind('mouseleave', function () {
  
      $.fn.mcolorpicker.setInputColor(id, $.fn.mcolorpicker.currentColor);
    });
  };

  $.fn.mcolorpicker.setInputColor = function (id, color) {
  
    var image = (color == 'transparent')? "url('" + $o.imageFolder + "grid.gif')": '',
        textColor = $.fn.mcolorpicker.textColor(color);
  
    if ($('#' + id).attr('data-text') || $('#' + id).attr('text')) $("#icp_" + id).css({'background-color': color, 'background-image': image});
    $("#" + id).val(color).css({'background-color': color, 'background-image': image, 'color' : textColor}).trigger('change');
    $("#mcolorpickerInput").val(color);
  };

  $.fn.mcolorpicker.textColor = function (val) {
  
    if (typeof val == 'undefined' || val == 'transparent') return "black";
    val = $.fn.mcolorpicker.RGBtoHex(val);
    return (parseInt(val.substr(1, 2), 16) + parseInt(val.substr(3, 2), 16) + parseInt(val.substr(5, 2), 16) < 400)? 'white': 'black';
  };

  $.fn.mcolorpicker.setCookie = function (name, value, days) {
  
    var cookie_string = name + "=" + escape(value),
      expires = new Date();
      expires.setDate(expires.getDate() + days);
    cookie_string += "; expires=" + expires.toGMTString();
   
    document.cookie = cookie_string;
  };

  $.fn.mcolorpicker.getCookie = function (name) {
  
    var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
  
    if (results) return (unescape(results[2]));
    else return null;
  };

  $.fn.mcolorpicker.colorPicked = function (id) {
  
    $.fn.mcolorpicker.closePicker();
  
    if ($.fn.mcolorpicker.init.enhancedSwatches) $.fn.mcolorpicker.addToSwatch();
  
    $("#" + id).trigger('colorpicked');
  };

  $.fn.mcolorpicker.addToSwatch = function (color) {
  
    var swatch = []
        i = 0;
 
    if (typeof color == 'string') $.fn.mcolorpicker.color = color.toLowerCase();
  
    $.fn.mcolorpicker.currentValue = $.fn.mcolorpicker.currentColor = $.fn.mcolorpicker.color;
  
    if ($.fn.mcolorpicker.color != 'transparent') swatch[0] = $.fn.mcolorpicker.color.toLowerCase();
  
    $('.mPastColor').each(function() {
  
      $.fn.mcolorpicker.color = $(this).css('background-color').toLowerCase();

      if ($.fn.mcolorpicker.color != swatch[0] && $.fn.mcolorpicker.RGBtoHex($.fn.mcolorpicker.color) != swatch[0] && $.fn.mcolorpicker.hexToRGB($.fn.mcolorpicker.color) != swatch[0] && swatch.length < 10) swatch[swatch.length] = $.fn.mcolorpicker.color;
  
      $(this).css('background-color', swatch[i++])
    });

    if ($.fn.mcolorpicker.init.enhancedSwatches) $.fn.mcolorpicker.setCookie('swatches', swatch.join('||'), 365);
  };

  $.fn.mcolorpicker.whichColor = function (x, y, hex) {
  
    var colorR = colorG = colorB = 255;
    
    if (x < 32) {
  
      colorG = x * 8;
      colorB = 0;
    } else if (x < 64) {
  
      colorR = 256 - (x - 32 ) * 8;
      colorB = 0;
    } else if (x < 96) {
  
      colorR = 0;
      colorB = (x - 64) * 8;
    } else if (x < 128) {
  
      colorR = 0;
      colorG = 256 - (x - 96) * 8;
    } else if (x < 160) {
  
      colorR = (x - 128) * 8;
      colorG = 0;
    } else {
  
      colorG = 0;
      colorB = 256 - (x - 160) * 8;
    }
  
    if (y < 64) {
  
      colorR += (256 - colorR) * (64 - y) / 64;
      colorG += (256 - colorG) * (64 - y) / 64;
      colorB += (256 - colorB) * (64 - y) / 64;
    } else if (y <= 128) {
  
      colorR -= colorR * (y - 64) / 64;
      colorG -= colorG * (y - 64) / 64;
      colorB -= colorB * (y - 64) / 64;
    } else if (y > 128) {
  
      colorR = colorG = colorB = 256 - ( x / 192 * 256 );
    }

    colorR = Math.round(Math.min(colorR, 255));
    colorG = Math.round(Math.min(colorG, 255));
    colorB = Math.round(Math.min(colorB, 255));

    if (hex) {

      colorR = colorR.toString(16);
      colorG = colorG.toString(16);
      colorB = colorB.toString(16);
      
      if (colorR.length < 2) colorR = 0 + colorR;
      if (colorG.length < 2) colorG = 0 + colorG;
      if (colorB.length < 2) colorB = 0 + colorB;

      return "#" + colorR + colorG + colorB;
    }
    
    return "rgb(" + colorR + ', ' + colorG + ', ' + colorB + ')';
  };

  $.fn.mcolorpicker.RGBtoHex = function (color) {

    color = color.toLowerCase();

    if (typeof color == 'undefined') return '';
    if (color.indexOf('#') > -1 && color.length > 6) return color;
    if (color.indexOf('rgb') < 0) return color;

    if (color.indexOf('#') > -1) {

      return '#' + color.substr(1, 1) + color.substr(1, 1) + color.substr(2, 1) + color.substr(2, 1) + color.substr(3, 1) + color.substr(3, 1);
    }

    var hexArray = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"],
        decToHex = "#",
        code1 = 0;
  
    color = color.replace(/[^0-9,]/g, '').split(",");

    for (var n = 0; n < color.length; n++) {

      code1 = Math.floor(color[n] / 16);
      decToHex += hexArray[code1] + hexArray[color[n] - code1 * 16];
    }
  
    return decToHex;
  };

  $.fn.mcolorpicker.hexToRGB = function (color) {

    color = color.toLowerCase();
  
    if (typeof color == 'undefined') return '';
    if (color.indexOf('rgb') > -1) return color;
    if (color.indexOf('#') < 0) return color;

    var c = color.replace('#', '');

    if (c.length < 6) c = c.substr(0, 1) + c.substr(0, 1) + c.substr(1, 1) + c.substr(1, 1) + c.substr(2, 1) + c.substr(2, 1);

    return 'rgb(' + parseInt(c.substr(0, 2), 16) + ', ' + parseInt(c.substr(2, 2), 16) + ', ' + parseInt(c.substr(4, 2), 16) + ')';
  };

  $(document).ready(function () {
	if(typeof(theme_admin_assets_uri) !== 'undefined') {
		$.fn.mcolorpicker.defaults.imageFolder = CCM_REL + '/packages' + '/theme_super_mint' + "/images/mcolorpicker/";
	}
	
    if ($.fn.mcolorpicker.init.replace) {

      $('input[data-mcolorpicker!="true"]').filter(function() {
    
        return ($.fn.mcolorpicker.init.replace == '[type=color]')? this.getAttribute("type") == 'color': $(this).is($.fn.mcolorpicker.init.replace);
      }).mcolorpicker();

      $.fn.mcolorpicker.liveEvents();
    }
  });
})(jQuery);