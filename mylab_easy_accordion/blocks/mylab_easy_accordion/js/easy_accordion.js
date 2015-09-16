jQuery.log = function(message) {
  if(window.console) {
     console.debug(message);
  } else {
     alert(message);
  }
};
// Ceci pour essayer d'eviter le dedoublement d'pappel sur Supermint ??
var done = new Array();

jQuery.fn.easyAccordion = function() {
	var options = (typeof arguments[0] != 'object') ? {} : arguments[0];
	var ref = jQuery(this);
	//if ($.inArray(ref.attr('id'),done) > -1 ) return;
	// On ajoute l'activé au tableau des activés.
	done.push(ref.attr('id'));	

	_this = this;
	var boxes = ref.children().children();
	var firstBox = ref.children().children(':first');
	jQuery('.ccm-spacer', ref).remove();
	//var initialBoxesWidth = boxes.width() > 0 ? (boxes.width()-5)+'px' : '95%' ;
	//var initialTitlesWidth = boxes.width() > 0 ? boxes.width()+'px' : '95%' ;

	if (options.classes != '' ) ref.addClass(options.classes);
	
	ref.addClass('accordion-wrapper');	
	
	titles = new Array();

	boxes
		.children('.ccm-layout-cell')
			    .addClass('ccm-easyAccordion-content')
			    .css('width','');
	boxes			    
		.addClass('ccm-easyAccordion-container')
		.each( function(j){
			// On ajoute la hauteur pour eviter un effet "jump"
			// $(this).css("height", $(this).height() ); 
			// Retiré car ne gérait pas les hauteur d'éléments dynamique tels que youtube ou flash
		    titleString = options.titles[j] == undefined ? "Title "+ (j+1) : options.titles[j] ;
		    var title = jQuery('<h3>' + titleString + '</h3>').insertBefore(this);
		    
		    
		    title
			.addClass('ccm-easyAccordion-title ccm-easyAccordion-title-'+j)
			//.css('width', initialTitlesWidth)
			//.corner('5px')
			.click(function(e){
			  if (_this.in_array(j,options.disabled)){
			    return false;
			  } else {
        		    _this.clickActions(jQuery(this),ref);
			  }
			});
      		    titles[j] = title;

		})
		.hide();

		
	if (options.open != 999 && !(this.in_array(options.open,options.disabled))) {
	  this.clickActions( titles[options.open], ref);
	}
	for (x in options.disabled) {
	  if ($(titles[options.disabled[x]]).size()){
	    this.disableClick (titles[options.disabled[x]]);
	  }
	}
  if( typeof (easy_accordion_ready) === "function") {easy_accordion_ready(titles, boxes)};
		  
};
jQuery.fn.innerWidthParent = function (parent) {
  iw = parent.innerWidth();
  iw -= parent.css('padding') == '' ? 0 : parseInt(parent.css('padding'));
  iw -= parent.css('padding-left') == '' ? 0 : parseInt(parent.css('padding-left'));
  iw -= parent.css('padding-right') == '' ? 0 : parseInt(parent.css('padding-right'));
}
jQuery.fn.clickActions = function (h, ref) {
    //jQuery.log (h);
 if (h.next('.ccm-easyAccordion-container').is(':hidden')){
      $('.ccm-easyAccordion-title', ref).removeClass('ccm-easyAccordion-title-active').next().slideUp();
      h.toggleClass('ccm-easyAccordion-title-active');
      h.next().slideDown();
    } else {
      h.removeClass('ccm-easyAccordion-title-active').next().slideUp();
      
    }
}
jQuery.fn.disableClick = function (h) {
    //h.addClass('ccm-easyAccordion-title-disabled');  
}
jQuery.fn.in_array = function  (needle, haystack, argStrict) {
    // http://kevin.vanzonneveld.net
    var key = '', strict = !!argStrict;
    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }

    return false;
}