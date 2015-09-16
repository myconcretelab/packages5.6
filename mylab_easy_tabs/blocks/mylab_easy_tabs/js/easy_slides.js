jQuery.log = function(message) {
  if(window.console) {
     console.debug(message);
  } else {
     alert(message);
  }
};


jQuery.fn.easySlides = function() {
      var options = (typeof arguments[0] != 'object') ? {} : arguments[0];
      //jQuery.log(options);
      var ref = jQuery(this);
      var wrapperNav = ref.children(':first');
      var tabs = ref.children().children();
      
      var nav = $('<ul></ul>').prependTo(wrapperNav);
      nav
	.addClass('ccm-easySlides-nav')
	.append(this.easySlides_fillNav(options));
      

      ref
	      .children('.ccm-layout-table')
		      .addClass('ccm-easySlides-wrapper');
      
      wrapperNav
	      .addClass('ccm-easySlides-navigation')
	      .children('.ccm-layout-cell').remove();
      
      tabs
	      .addClass('ccm-easySlides-container')
	      .hide();
	      
      tabs.first()
	      .addClass('ccm-easySlides-container-active').show();
      
      tabs.children(':not(.ccm-spacer)')
	      .addClass('ccm-easySlides-content');
			      
      nav.children('li').children('span').each(function(i) {
	      var a = jQuery(this);
	      if (i==0) {a.addClass('active-link').parent('li').addClass('active-link')}
	
	      jQuery(a).click(function(e) {
		      var aa = jQuery(this);
		      var activeTab = '.ccm-layout-row-' + aa.parent().attr("rel");
		      if (!jQuery(activeTab, ref).is(':visible')) {
			nav.find('.active-link').removeClass('active-link');
			aa.addClass('active-link').parent('li').addClass('active-link')
			actualTab = jQuery(".ccm-easySlides-container-active", ref);
			jQuery(activeTab, ref).addClass("ccm-easySlides-container-active").fadeIn('slow');
			actualTab.removeClass("ccm-easySlides-container-active").hide();        
			
		      }
		      })
      });

};

jQuery.fn.easySlides_fillNav = function(o) {
    var li ="";
    for(j=0 ; j < o.titles.length ; j++) {
      li 
      += '<li rel="' + (j+1) + '"><span>'
      + ( o.images[j]
	? '<div class="ccm-easySlides-image"><img src="' + o.images[j] + '" /></div>'
	: "" )
      + '<b>' + o.titles[j] + '</b>'
      +  '</span></li>'
      
    }
    return li;
};