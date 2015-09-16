(function($){  
  
	$.fn.deepitSlider = function(options){
		$.fn.deepitSlider.defaults = {
			animSpeed:1000,
			liquidLayout: true,			
			autoStart: false,
			pauseTime:3000,
			arrowsNav:true,
			arrowsNavHide:false,
			listNav:true,
			listNavThumbs:false,
			listNavThumbUrl:false,
			pauseOnHover: false,
			layers: false,
			autoLoop:true,
			caption:false
		};
		var settings = $.extend({}, $.fn.deepitSlider.defaults, options);
		
		var boxes = {
			frame: '<div class="dpit-slider-frame">',
			images: '<div class="dpit-slider-images">',
			image_outer: '<div class="dpit-slider-image-outer">',
			image: '<div class="dpit-slider-image">'
		};
		
		var $previous = $('<div class="dpit-slider-arrows previous"></div>');
        var $next = $('<div class="dpit-slider-arrows next"></div>');
		var $switcher = $('<ul class="switcher"></ul>');
		
        var $this = $(this);
        
        var init = {
            height: $this.height(),
            width: ($this.width()*2), // Here you can change space between picture
            images_total: $this.find('img').length,
            images_amount: $this.find('img').length
        };
        
        if(settings.layers){
        	var layers = settings.layers;
        }
        
        var current_image = 1;
	var images;
                
		var make = function()
        {
			images = $('img', $this);
			
			$.each(images, function(key, value) {
				if($(value).parent('a').length > 0){
					$(value).parent('a').addClass('img_holder').wrap(boxes.image);
				} 
				else {
					$(value).wrap(boxes.image);
				}
				
				var img_rel = $(value).attr('rel');
				if(img_rel && $('div#'+img_rel).length > 0){
					$cap = $('div#'+img_rel).addClass('dpit-slider-caption')
					if (settings.caption == 'bottom' || settings.caption == 'top') {
						$cap.css('width',$(value).width()-20);						
					} else if (settings.caption == 'left' || settings.caption == 'right') {
						$cap.css('height',$(value).height()-20);						
					}

					
					if($(value).parent('a').length > 0){
						$(value).parent('a').parent('div').append($('div#'+img_rel));
					}
					else {
						$(value).parent('div').append($('div#'+img_rel));
					}
				}
				img_rel = 0;
			});
			
			$('div.dpit-slider-image', $this).wrap(boxes.image_outer);
			$this.addClass('dpit-slider-external').wrapInner(boxes.frame);
			$('div.dpit-slider-frame',$this).wrapInner(boxes.images).after($switcher);
           
			if(settings.arrowsNav){
        		$('div.dpit-slider-frame',$this).append($previous).append($next);
        		if(settings.arrowsNavHide){
        			$('div.dpit-slider-arrows',$this).hide();
        		}
			}

            if(settings.listNav || settings.listNavThumbs){
	           if(settings.listNavThumbUrl){
	        	   $switcher.addClass('dpit-slider-listNavThumbs');
	        	   $.each(settings.listNavThumbUrl, function(key, value) {

	        		   $switcher.append('<li><img src="'+value+'" /></li>');
	        	   });
	           }
	           else {
	        	   $switcher.addClass('dpit-slider-listNav');
	        	   for(t=0;t<init.images_total;t++){
		        	   $switcher.append('<li></li>');
		           } 
	           }
	           $('li:first-child',$switcher).addClass('active');
	           $switcher.css('left', ($('div.dpit-slider-frame', this).width() - $switcher.width())/2 );
           }
           
           $('div.dpit-slider-images', $this).width( init.width * init.images_total);
           $('div.dpit-slider-image-outer', $this).width( (init.width) );
 
           if(layers){
	           $.each(layers, function(key, value) { 
	        	   var layerClass;
	        	   var o,c,d;
	          	   	$.each(value, function(key, value) { 
	          		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	          		   if(key == 'className') { c = value; }
	          		   if(key == 'direction') { d = value; }
	          	   	});
	          	   	
	          	   	$this.append('<div class="dpit-slider-layer '+c+'"></div>');
	          	   	$('div.'+c, $this).width(init.width*init.images_total).height(init.height);
	          	   	
	          	   	if(d == 'ltr') {
					   $('div.'+c, $this).css('left','0');
	          	   	} 
	          	   	if(d == 'rtl'){
					   var rtl_offset = init.width*(init.images_total-1)*o/100;
					   $('div.'+c, $this).css('left','-'+rtl_offset+'px');
	          	   	}
	          	   	
	          	   	o = c = d = 0;
	           });
            }
	    			resizeFrame(current_image-1);

        };
	
        if(settings.liquidLayout){
        	$(window).resize(function() {
	        	init.width = $this.width();
	        	
	        	$('div.dpit-slider-images', $this).width( init.width * init.images_total );
	            $('div.dpit-slider-image-outer', $this).width( init.width );
	            
	            if(layers){
		            $.each(layers, function(key, value) { 
		            	var o,c,d;
		           	   	$.each(value, function(key, value) { 
		           		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
		           		   if(key == 'className') { c = value; }
		           		   if(key == 'direction') { d = value; }
		           	   	});
		           	   	
		           	   	$('div.'+c, $this).width(init.width*init.images_total);
		           	 
		           	   	if(d == 'rtl'){
			           	   	$('div.'+c, $this).css('left', '0px');
				            $('div.'+c, $this).css('left', '-'+init.width*(init.images_total-current_image)*o/100+'px');
		           	   	}
		           	   	if(d == 'ltr') {
				            $('div.'+c, $this).css('left', '0px');
				            $('div.'+c, $this).css('left', '-'+init.width*(current_image-1)*o/100+'px');
		           	   	}
		           	   	
		           	   	o = c = d = 0;
		            });
	            }
	            
	            $('div.dpit-slider-images', $this).css('left', '0px');
	            $('div.dpit-slider-images', $this).css('left', '-'+init.width*(current_image-1)+'px');
	        });
        }
	function resizeFrame (n) {
		$frame = $('.dpit-slider-frame', $this);
		$iw = $(images[n]).width();
		$ih = $(images[n]).height();
		$fw = $frame.width();
		$fh = $frame.height();
		if ($fh != $ih) {  $frame.animate({height:$(images[n]).height()}) } ;
		if ($fw != $iw + 10 ) {  $frame.animate({width:$(images[n]).width() + 10 }) } ; // Here 10 is the padding of the image container
		//console.log($(images[n]).next('div.dpit-slider-caption'));
		//$(images[n]).next('div.dpit-slider-caption').css({width:$iw});		
		$('.switcher', $this).animate({left:(($this.width())/2) - ($('.switcher', $this).width()/2)});
	}

        $previous.bind('click', function(){
     	   if(init.images_amount < init.images_total){
     		   $this.find('div.dpit-slider-images').animate({
        		   left: '+='+init.width
        	   }, settings.animSpeed,function(){
			resizeFrame(current_image-1);
			});
     		   if(layers){
	        	   $.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   $this.find('div.'+c).animate({
	            		   left: (d && d == 'rtl') ? '-='+Math.floor(init.width*o/100) : '+='+Math.floor(init.width*o/100)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
	               });
     		   }
     		  
        	   init.images_amount++;
        	   $switcher.find('li').removeClass('active');
        	   var switcher_position = init.images_total - init.images_amount;
        	   $switcher.find('li:eq('+switcher_position+')').addClass('active');
        	   current_image--; //!!!
     	   } else {
     		   if(settings.autoLoop){
     			  $('ul.switcher li:last', $this).trigger('click');
     		   }
     		   return false;
     	   }
        });
        
        $next.bind('click', function(){ 
     	   if(init.images_amount > 1){
     		   $this.find('div.dpit-slider-images').animate({
        		   left: '-='+init.width
        	   }, settings.animSpeed,function(){
			resizeFrame(current_image-1);
			});
        	  
     		   if(layers){
	        	   $.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   Math.floor(init.width*o/100);
	            	   
	            	   $this.find('div.'+c).animate({
		        		   left: (d && d == 'rtl') ? '+='+Math.floor(init.width*o/100) : '-='+Math.floor(init.width*o/100)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
	               });
     		   }
     		   
		   
		   //console.log($(images[current_image]).width());
		   //console.log($('.dpit-slider-frame').width());
        	   init.images_amount--;
        	   current_image++; //!!!
        	   $switcher.find('li').removeClass('active');
        	   var switcher_position = init.images_total - init.images_amount;
        	   $switcher.find('li:eq('+switcher_position+')').addClass('active');
     	   } else {
     		   if(settings.autoLoop){
     			  $('ul.switcher li:first', $this).trigger('click');
     		   }
     		   return false;
     	   }
        });
        
        var timer = '';

        
        if(settings.autoStart){
        	timer = setInterval( function(){ $next.trigger('click') }, settings.pauseTime );
        }
        if(settings.pauseOnHover && settings.autoStart){
			$this.hover(function(){
				clearInterval(timer);
				timer = '';
			}, function(){
				if(timer == ''){
					timer = setInterval( function(){ $next.trigger('click') }, settings.pauseTime );
				}
			});
		}
        
        if(settings.arrowsNav && settings.arrowsNavHide){
        	$this.hover(function(){
				$('div.dpit-slider-arrows, div.dpit-slider-caption',$this).fadeIn('slow');
				
			}, function(){
				$('div.dpit-slider-arrows, div.dpit-slider-caption',$this).fadeOut('slow');
			});
        }

        $('ul.switcher li', this).live('click', function(){
        	var selected_position = $(this).prevAll().length + 1;
        	var current_position = init.images_total - init.images_amount + 1;
        	
        	$(this).parent('ul').find('li').removeClass('active');
        	$(this).addClass('active');
        	
        	var offset = current_position - selected_position;
        	
        	if(offset<0){
        		$('div.dpit-slider-images', $this).animate({
	      		   left: '-='+init.width*Math.abs(offset)
	      	   	}, settings.animSpeed, function() {
				resizeFrame(current_image-1);				
				});
        		if(layers){
		        	$.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   $('div.'+c, $this).animate({
	            		   left: (d && d == 'rtl') ? '+='+Math.floor(init.width*o/100)*Math.abs(offset) : '-='+Math.floor(init.width*o/100)*Math.abs(offset)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
		        	});
        		}
        	} else {
        		$('div.dpit-slider-images', $this).animate({
 	      		   left: '+='+init.width*Math.abs(offset)
	      	   	}, settings.animSpeed, function() {
				resizeFrame(current_image-1);				
				});
        		if(layers){
	        		$.each(layers, function(key, value) { 
	         		   var o,c,d;
	             	   $.each(value, function(key, value) { 
	             		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	             		   if(key == 'className') c = value;
	             		   if(key == 'direction') d = value;
	             	   });
	             	   
	             	   $('div.'+c, $this).animate({
	 	        		   left: (d && d == 'rtl') ? '-='+Math.floor(init.width*o/100)*Math.abs(offset) : '+='+Math.floor(init.width*o/100)*Math.abs(offset)
	 	        	   }, settings.animSpeed);
	             	   
	             	   o = c = d = 0;
	                });
        		}
        	}
        	init.images_amount = init.images_total - selected_position + 1;
        	current_image = selected_position;//!!!
        });
	
        return this.each(make);       
    };
    
})(jQuery);
//        	resizeFrame(current_image);
