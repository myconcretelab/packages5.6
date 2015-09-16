function ccmValidateBlockForm() {
  
    if ($(document.forms['ccm-block-form'].elements['mID[]']).size() == 0){
        ccm_addError(ccm_t('gallery-required'));
    };
    for ( i=0 ; i < $(document.forms['ccm-block-form'].elements['mID[]']).size(); i++){
        if (i==0) {
            id = $(document.forms['ccm-block-form'].elements['mID[]']).val();
        } else {
            id = $(document.forms['ccm-block-form'].elements['mID[]'][i]).val();            
        }
        media = $(document.forms['ccm-block-form'].elements['type_'+id]).val();
        // In Chrome Mac, media is a object!  I Can't verify the value !
        media_value =  $(document.forms['ccm-block-form'].elements['media_'+id]).val();
        
        // Check for a valid Url
        if (media == "youtube" || media == "vimeo" || media == "iframe"){
            if(!isUrl(media_value)) {
                $(document.forms['ccm-block-form'].elements['media_'+id]).addClass('wrong');
                ccm_addError(ccm_t('url-valid'));
            }
        }
        // Check for the empty File
        if (media_value == 0) {
            $(document.forms['ccm-block-form'].elements['media_'+id]).parent().addClass('wrong');
            ccm_addError(ccm_t('file-required'));
        }
        // Check for the height and Width 
        if (media == 'iframe') {
            media_width = parseInt($(document.forms['ccm-block-form'].elements['width_'+id]).val());
            media_height = parseInt($(document.forms['ccm-block-form'].elements['height_'+id]).val());

            if (isNaN(media_width)) {
                 ccm_addError(ccm_t('dimension-required'));
                 $(document.forms['ccm-block-form'].elements['width_'+id]).addClass('wrong');
            }
            if (isNaN(media_height)) {
                 ccm_addError(ccm_t('dimension-required'));
                 $(document.forms['ccm-block-form'].elements['height_'+id]).addClass('wrong');
            }
        } 
    }
}

$(document).ready(function() {
    $("#ccm-multimedia-tabs a").click(function() {
	$("li.ccm-nav-active").removeClass('ccm-nav-active');
	$("#" + ccm_fpActiveTab + "-tab").hide();
	ccm_fpActiveTab = $(this).attr('id');
	$(this).parent().addClass("ccm-nav-active");
	$("#" + ccm_fpActiveTab + "-tab").show();
    });
    
    
    $('.ccm-input-text').click(function(){
	$(this).val('');
    });    
    // Sortable Elements
    $("#media-available, #media-gallery").sortable({
	connectWith: '.connectedSortable',
	handle: 'a'
    }).disableSelection();    
    $( "#media-gallery" ).bind( "sortreceive", function(event, ui) {
	var li = ui.item;
	var type = li.text();
	type = type.toLowerCase();
	addMedia(li,type);  
	$('#media-available li:first-child').clone().appendTo('#media-available').find('span').text(type);
    }); 
    
    $( "#media-available" ).bind( "sortreceive", function(event, ui) {
      $(event.originalTarget).parents('li').remove();
    });

})

var refreshAttributesList = function () {
        select = $('select.attributes');
	$.ajax({
            url:FILE_ATTRIBUTES_OPTIONS_URL,
            dataType: 'html',
            success:
                function(response) {
                    select.each(function() {
                        // Keep the same value as before refresh Or get it from title attribute
                        $this = $(this);
                        // Si le titre est defini et qu'aucune valeur n'est encore choisie
                        if ($this.attr('title') != '') {
                            val = $this.attr('title');
                        } else {
                            // L'utilisateur a dŽjˆ choisi une valeur (diffŽrente que celle dŽfnie par la balise titre)
                            val = $this.val();                            
                        }
                        $this.html(response);
			$this.prepend('<option value="0">Select a Attribute</option>');
                        $this.val(val);
                    })
                }
        });
}

var addMedia = function (li,type,data) {
  if(!data){data = "&edit=false"};
   $.get(FORM_TOOL_URL + '?bID=' + BLOCK_ID + '&type=' + type + data, function(data) {
    $(".media-content",li)
      .append(data)
      .hide()
      .fadeIn()
      .addClass('media');
     $(li)
     .find('a.btn')
	.after('<img src="' + BLOCK_URL + '/images/moin.png" onclick="toggleThis(this)" alt="collapse" align="right" class="media-asset" />')
	.after('<img src="' + BLOCK_URL + '/images/trash.png" onclick="deleteThis(this)" alt="trash" align="right" class="media-asset" />');
    refreshAttributesList();
   }); 
};
var setjQuerySlider = function ($name,$min,$max,$value,$step) {
    $step = ($step == undefined) ? 1 : $step;
    
     $('#range-'+$name).slider({
            value:$value,
            min: $min,
            max: $max,
            step:$step,
            slide: function( event, ui ) {
		$('input#'+$name).val(ui.value);
	    }
    });
    $('input#'+$name).val($('#range-'+$name).slider( "value" ) );
    
}


var toggleThis = function (t){
    // Todo : Find a simpler way to change url
    open = $(t).parent().find('.media-content').is(':visible');
    url = $(t).attr('src');
    if (open) {
        url = url.replace('moin','plus');
    } else {
        url = url.replace('plus','moin');
    }	
    $(t).parent().find('.media-content').slideToggle('slow');
    $(t).attr('src', url);
}
var toggleAll = function () {
    $('#media-gallery div.media-content').slideToggle('slow');
}
var deleteThis = function (t){
    $(t).parent('li').remove();
}


var toggleCustomTitle = function (value) {
	if (value == "customTitle") {
		$("#ccm-customTitle").css('display','block');
	} else {
		$("#ccm-customTitle").hide();
	}
}



var toggleCustomDescription = function (value) {
	if (value == "customDescription") {
		$("#ccm-customDescription").css('display','block');
	} else {
		$("#ccm-customDescription").hide();
	}
}


var var_dump = function (obj) {
	if(typeof obj == "object") {
		return "Type: "+typeof(obj)+((obj.constructor) ? "\nConstructor: "+obj.constructor : "")+"\nValue: " + obj;
	} else {
		return "Type: "+typeof(obj)+"\nValue: "+obj;
	}
}


var isUrl = function (s) {
	var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	if(!regexp.test(s)){
		return false;
	} else {
		return true;
	}
}


/*---------------
 * jQuery iToggle Plugin by Engage Interactive
 * Examples and documentation at: http://labs.engageinteractive.co.uk/itoggle/
 * Copyright (c) 2009 Engage Interactive
 * Version: 1.0 (10-JUN-2009)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Requires: jQuery v1.3 or later
---------------*/
	$.fn.iToggle = function(options) {
		clickEnabled = true;
		
		var defaults = {
			type: 'checkbox',
			keepLabel: true,
			easing: false,
			speed: 200,
			onClick: function(){},
			onClickOn: function(){},
			onClickOff: function(){},
			onSlide: function(){},
			onSlideOn: function(){},
			onSlideOff: function(){}
		},
		settings = $.extend({}, defaults, options);
		
		this.each(function(){
			var $this = $(this);

			if($this.attr('tagName') == 'INPUT'){
				var id=$this.attr('id');
				label(settings.keepLabel, id);
				$this.addClass('iT_checkbox').before('<label class="itoggle" for="'+id+'"><span></span></label>');
				if($this.attr('checked')){
					$this.prev('label').addClass('iTon');
				}else{
					$this.prev('label').addClass('iToff');
				}

			}else{
                            
				$this.children('input:'+settings.type).each(function(){
					var id = $(this).attr('id');
					label(settings.keepLabel, id);
					$(this).addClass('iT_checkbox').before('<label class="itoggle" for="'+id+'"><span></span></label>');
					if($(this).attr('checked')){
						$(this).prev('label').addClass('iTon');
					}else{
						$(this).prev('label').addClass('iToff');
					}
					if(settings.type == 'radio'){
						$(this).prev('label').addClass('iT_radio');
					}
				});
			}
		});
		
		function label(e, id){
			if(e == true){
				if(settings.type == 'radio'){
					$('label[for='+id+']').addClass('ilabel_radio');
				}else{
					$('label[for='+id+']').addClass('ilabel');
				}
			}else{
				$('label[for='+id+']').remove();
			}
		}

		$('label.itoggle').click(function(){
			if(clickEnabled == true){
				clickEnabled = false;
				if($(this).hasClass('iT_radio')){
					if($(this).hasClass('iTon')){
						clickEnabled = true;
					}else{
						slide($(this), true);
					}
				}else{
					slide($(this));
				}
			}
			return false;
		});
		$('label.ilabel').click(function(){
			if(clickEnabled == true){
				clickEnabled = false;
				slide($(this).next('label.itoggle'));
			}
			return false;
		});
		
		function slide($object, radio){
			settings.onClick.call($object); //Generic click callback for click at any state
			h=$object.innerHeight();
			t=$object.attr('for');
			if($object.hasClass('iTon')){
				settings.onClickOff.call($object); //Click that turns the toggle to off position
				$object.animate({backgroundPosition:'100% -'+h+'px'}, settings.speed, settings.easing, function(){
					$object.removeClass('iTon').addClass('iToff');
					clickEnabled = true;
					settings.onSlide.call(this); //Generic callback after the slide has finnished
					settings.onSlideOff.call(this); //Callback after the slide turns the toggle off
				});
				$('input#'+t).removeAttr('checked');
			}else{
				settings.onClickOn.call($object);
				$object.animate({backgroundPosition:'0% -'+h+'px'}, settings.speed, settings.easing, function(){
					$object.removeClass('iToff').addClass('iTon');
					clickEnabled = true;
					settings.onSlide.call(this); //Generic callback after the slide has finnished
					settings.onSlideOn.call(this); //Callback after the slide turns the toggle on
				});
				$('input#'+t).attr('checked','checked');
			}
			if(radio == true){
				name = $('#'+t).attr('name');
				slide($object.siblings('label[for]'));
			}
		}

	};
