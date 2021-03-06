jQuery.log = function(message) {
  if(window.console) {
     console.debug(message);
  } else {
     alert(message);
  }
};
// Ceci pour essayer d'eviter le dedoublement d'pappel sur Supermint ??
var done = new Array();

jQuery.fn.easyTabs = function() {
      var options = (typeof arguments[0] != 'object') ? {} : arguments[0];
        
      var ref = jQuery(this);
      var ID = ref.attr('id');
      if ($.inArray(ID,done) > -1 ) return;
      // On ajoute l'activé au tableau des activés.
      done.push(ID);  

      var wrapperNav = ref.children(':first');
      var _tabs = ref.children().children();
      
      var nav = $('<ul></ul>').prependTo(wrapperNav);
      nav
	.addClass('ccm-easyTabs-nav')
	.append(this.easyTabs_fillNav(options));
      

      ref
	      .addClass('easyTabs-wrapper')
	      .children('.ccm-layout-table')
		      .addClass('ccm-easyTabs-wrapper');
      
      wrapperNav
	      .addClass('ccm-easyTabs-navigation')
	      .children('.ccm-layout-cell').remove();
      
      _tabs
	      .addClass('ccm-easyTabs-container')
	      .hide();
	      
     // _tabs.first()
	//      .addClass('ccm-easyTabs-container-active').show();
      
      _tabs.children(':not(.ccm-spacer)')
	      .addClass('ccm-easyTabs-content');
  
      nav.tabs("#" + ID + "> div > div", {
	event: 'click',
	effect: 'fade',
	history: options.history
        }
      );
      
  

};

jQuery.fn.easyTabs_fillNav = function(o) {
    var li ="";
    var id = '';
    for(j=0 ; j < o.titles.length ; j++) {
      id = o.titles[j].replace(/\s+/g,"_").toLowerCase() + '_tab';
      li 
      += '<li>'
      + (o.history
	 ? '<a id="t' + (j+1) + '" href="#' + id + '">' + o.titles[j] + '</a>'
	 : '<span>' + o.titles[j] + '</span>' )
      + ( o.images[j]
	? '<div class="ccm-easySlides-image ccm-easytabs-image"><img src="' + o.images[j] + '" /></div>'
	: "" ) 
      +  '</li>'
      
    }
    return li;
};

/*!
 * jQuery Tools v1.2.6 - The missing UI library for the Web
 * 
 * toolbox/toolbox.history.js
 * tabs/tabs.js
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/
 * 
 */
(function(a){var b,c,d,e;a.tools=a.tools||{version:"v1.2.6"},a.tools.history={init:function(g){e||(a.browser.msie&&a.browser.version<"8"?c||(c=a("<iframe/>").attr("src","javascript:false;").hide().get(0),a("body").prepend(c),setInterval(function(){var d=c.contentWindow.document,e=d.location.hash;b!==e&&a(window).trigger("hash",e)},100),f(location.hash||"#")):setInterval(function(){var c=location.hash;c!==b&&a(window).trigger("hash",c)},100),d=d?d.add(g):g,g.click(function(b){var d=a(this).attr("href");c&&f(d);if(d.slice(0,1)!="#"){location.href="#"+d;return b.preventDefault()}}),e=!0)}};function f(a){if(a){var b=c.contentWindow.document;b.open().close(),b.location.hash=a}}a(window).bind("hash",function(c,e){e?d.filter(function(){var b=a(this).attr("href");return b==e||b==e.replace("#","")}).trigger("history",[e]):d.eq(0).trigger("history",[e]),b=e}),a.fn.history=function(b){a.tools.history.init(this);return this.bind("history",b)}})(jQuery);
(function(a){a.tools=a.tools||{version:"v1.2.6"},a.tools.tabs={conf:{tabs:"a",current:"current",onBeforeClick:null,onClick:null,effect:"default",initialIndex:0,event:"click",rotate:!1,slideUpSpeed:400,slideDownSpeed:400,history:!1},addEffect:function(a,c){b[a]=c}};var b={"default":function(a,b){this.getPanes().hide().eq(a).show(),b.call()},fade:function(a,b){var c=this.getConf(),d=c.fadeOutSpeed,e=this.getPanes();d?e.fadeOut(d):e.hide(),e.eq(a).fadeIn(c.fadeInSpeed,b)},slide:function(a,b){var c=this.getConf();this.getPanes().slideUp(c.slideUpSpeed),this.getPanes().eq(a).slideDown(c.slideDownSpeed,b)},ajax:function(a,b){this.getPanes().eq(0).load(this.getTabs().eq(a).attr("href"),b)}},c,d;a.tools.tabs.addEffect("horizontal",function(b,e){if(!c){var f=this.getPanes().eq(b),g=this.getCurrentPane();d||(d=this.getPanes().eq(0).width()),c=!0,f.show(),g.animate({width:0},{step:function(a){f.css("width",d-a)},complete:function(){a(this).hide(),e.call(),c=!1}}),g.length||(e.call(),c=!1)}});function e(c,d,e){var f=this,g=c.add(this),h=c.find(e.tabs),i=d.jquery?d:c.children(d),j;h.length||(h=c.children()),i.length||(i=c.parent().find(d)),i.length||(i=a(d)),a.extend(this,{click:function(c,d){var i=h.eq(c);typeof c=="string"&&c.replace("#","")&&(i=h.filter("[href*="+c.replace("#","")+"]"),c=Math.max(h.index(i),0));if(e.rotate){var k=h.length-1;if(c<0)return f.click(k,d);if(c>k)return f.click(0,d)}if(!i.length){if(j>=0)return f;c=e.initialIndex,i=h.eq(c)}if(c===j)return f;d=d||a.Event(),d.type="onBeforeClick",g.trigger(d,[c]);if(!d.isDefaultPrevented()){b[e.effect].call(f,c,function(){j=c,d.type="onClick",g.trigger(d,[c])}),h.removeClass(e.current),i.addClass(e.current);return f}},getConf:function(){return e},getTabs:function(){return h},getPanes:function(){return i},getCurrentPane:function(){return i.eq(j)},getCurrentTab:function(){return h.eq(j)},getIndex:function(){return j},next:function(){return f.click(j+1)},prev:function(){return f.click(j-1)},destroy:function(){h.unbind(e.event).removeClass(e.current),i.find("a[href^=#]").unbind("click.T");return f}}),a.each("onBeforeClick,onClick".split(","),function(b,c){a.isFunction(e[c])&&a(f).bind(c,e[c]),f[c]=function(b){b&&a(f).bind(c,b);return f}}),e.history&&a.fn.history&&(a.tools.history.init(h),e.event="history"),h.each(function(b){a(this).bind(e.event,function(a){f.click(b,a);return a.preventDefault()})}),i.find("a[href^=#]").bind("click.T",function(b){f.click(a(this).attr("href"),b)}),location.hash&&e.tabs=="a"&&c.find("[href="+location.hash+"]").length?f.click(location.hash):(e.initialIndex===0||e.initialIndex>0)&&f.click(e.initialIndex)}a.fn.tabs=function(b,c){var d=this.data("tabs");d&&(d.destroy(),this.removeData("tabs")),a.isFunction(c)&&(c={onBeforeClick:c}),c=a.extend({},a.tools.tabs.conf,c),this.each(function(){d=new e(a(this),b,c),a(this).data("tabs",d)});return c.api?d:this}})(jQuery);
