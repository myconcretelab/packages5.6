(function($){	
	$.extend({
		svUltimateSlider:{
			transitions:{
				fade:{
					duration:800,
					delay:0,
					css:{opacity:0},
					columns:1,
					rows:1,
					order:'normal',
					easing:'linear',
					slide:'current'
				}
			}
		}
	});
	$.fn.svUltimateSlider = function(opts) {
		var defaults = {
				delay: 3000,
				type:'fade',
				onend:null,
				onstart:null
			};
		var settings = $.extend({}, defaults, opts);
		if(settings['transitions']){
			$.extend($.svUltimateSlider.transitions,settings.transitions);
		}
		this.each(function() {
			var $this=$(this);
			$this.attr('sv_cur',0);
			$this.attr('sv_ani',0);
			$this.attr('sv_timer',setTimeout(function(){startSwitch($this);}, settings.delay));
			$this.children('li').each(function(index){
				if(index==0){
					$(this).css({zIndex:2,position:'absolute'});
				}
				else{
					$(this).css({zIndex:0,position:'absolute'});
				}
			});	
			$(settings.prev).click(function(){
				if($this.attr('sv_ani')==0){
					var cur=$this.attr('sv_cur');
					var next=cur-1;
					if(next<0){
						next=$this.children('li').length-1;
					}	
					clearTimeout($this.attr('sv_timer'));
					startSwitch($this,next);
				}
			});
			$(settings.next).click(function(){
				if($this.attr('sv_ani')==0){
					clearTimeout($this.attr('sv_timer'));
					startSwitch($this);		
				}
			});
			$('li',$(settings.controls)).each(function(index){
				$(this).click(function(){
					if($this.attr('sv_ani')==0){
						clearTimeout($this.attr('sv_timer'));
						startSwitch($this,index);
					}
				});				
			});
			$this.hover(
				function(){
					if($this.attr('sv_ani')==0){
						clearTimeout($this.attr('sv_timer'));
					}
				},
				function(){
					if($this.attr('sv_ani')==0){
						$this.attr('sv_timer',setTimeout(function(){startSwitch($this);}, settings.delay));
					}					
				});
		});		
		var startSwitch=function($this,index){
			if($this.attr('sv_ani')==0 && $this.attr('sv_cur')!=index){
				$this.attr('sv_ani',1);
				clearTimeout($this.attr('sv_timer'));
				var cur =$this.attr('sv_cur');
				if(!isNaN(index)){
					var n = index;
				}	
				else if(cur<$this.children('li').length-1){
					var n= parseInt(cur)+1;
				}	
				else{
					var n= 0;
				}	
				doSwitch($this,n);
			}
		}
		var getTransData = function($this){
			var type;
			if($.isArray(settings.type)){
				if(isNaN($this.attr('sv_type'))){$this.attr('sv_type',0)};	
				type = settings.type[parseInt($this.attr('sv_type'))];
				if(parseInt($this.attr('sv_type'))+1>=settings.type.length){
					$this.attr('sv_type',0);
				}
				else{
					$this.attr('sv_type',parseInt($this.attr('sv_type'))+1);
				}
			}
			else{
				type=settings.type
			}			
			if(!$.svUltimateSlider.transitions[type]){
				return $.svUltimateSlider.transitions.fade;
			}
			else{
				return $.extend({}, $.svUltimateSlider.transitions.fade, $.svUltimateSlider.transitions[type]);
			}
		}		
		var cloneSlide=function($this,trans,n){
			var divs = []
				cols=trans.columns,
				rows=trans.rows;	
			
			if(trans.slide=='next'){
				var slide = $($this.children('li')[n]);
			}
			else{
				var slide = $($this.children('li')[$this.attr('sv_cur')]);
			}
			var w=($this.width()/cols);
			var h=($this.height()/rows);
			var nLi=$('<li/>')
					.css({
						width:$this.width(),
						height:$this.height(),
						overflow:'hidden',
						position:'relative',
						top:0,
						display:'block',
						zIndex:3
					});		
			for(var j=0;j<rows;j++){//rows
				for(var i=0;i<cols;i++){//columns
					divs[((j*cols)+i)]=$('<div/>')
											.css({
												width:w+1,
												height:h+1,
												overflow:'hidden',
												position:'absolute',
												left:(w*i),
												top:(h*j)
											});
					if(trans.slide=='next'){
						var css={};
						css['width']=divs[((j*cols)+i)].css('width');
						css['height']=divs[((j*cols)+i)].css('height');
						css['opacity']=1;
						css['top']=divs[((j*cols)+i)].css('top');
						css['left']=divs[((j*cols)+i)].css('left');
					
						divs[((j*cols)+i)].data('sv_cssdata',css)									
									.animate(trans.css,0);
						divs[((j*cols)+i)].data('sv_divwidth',divs[((j*cols)+i)].css('width'));
						divs[((j*cols)+i)].css({width:0});
					
					}
					var div = $('<div/>')
								.html(slide.html())
								.css({
									marginTop:-(h*j),
									marginLeft:-(w*i),
									width:w,
									height:h
								});
					divs[((j*cols)+i)].append(div);	
					nLi.append(divs[((j*cols)+i)]);
				}
			}
			return [nLi,divs];
		}
		var doTransition=function($this,divs,nLi,n,trans){
			var j=0,
				count = divs.length;
				del = trans.delay;
				tt 	= trans.duration;
			if(trans.order=='reverse'){
				divs.reverse();
			}
			for(var i = 0; i<count; i++){
										if(trans.easing==undefined || !jQuery.easing[trans.easing]){trans.easing='swing'}
										if(j<count-1){
											if(trans.order=='random'){
												j++;
												var div = divs[Math.floor(Math.random()*divs.length)];
												divs = jQuery.grep(divs, function(value) {
															return value != div;
												});
												div.delay((del*i), "svUltimateSlider")
													.queue("svUltimateSlider", function(next) {
														
														if(trans.slide=='next'){
															var ncss=$(this).data('sv_cssdata');
														}
														else{var ncss=trans.css;}
														
														if(trans.slide=='next'){
															$(this).css({width:$(this).data('sv_divwidth')});
														}
														$(this).animate(ncss,tt,trans.easing);
														next();
													})
													.dequeue("svUltimateSlider");
											}
											else{											
												divs[j++].delay((del*i), "svUltimateSlider")
													.queue("svUltimateSlider", function(next) {
														if(trans.slide=='next'){
															var ncss=$(this).data('sv_cssdata');
														}
														else{var ncss=trans.css;}
														if(trans.slide=='next'){
															$(this).css({width:$(this).data('sv_divwidth')});
														}
														$(this).animate(ncss,tt,trans.easing);
														next();
													})
													.dequeue("svUltimateSlider");
											}
										}
										else{											
											var div = (trans.order=='random')?divs[0]:divs[j++];
											clearInterval($this.attr('sv_timer'));
											div.delay((del*i), "svUltimateSlider")
													.queue("svUltimateSlider", function(next) {
														if(trans.slide=='next'){
															var ncss=$(this).data('sv_cssdata');
														}
														else{var ncss=trans.css;}
														if(trans.slide=='next'){
															$(this).css({width:$(this).data('sv_divwidth')});
														}
														$(this).animate(ncss,tt,trans.easing,function(){
																		nLi.remove();
																		$($this.children('li')[n]).css({zIndex:2});
																		$($this.children('li')[$this.attr('sv_cur')]).css({zIndex:0});
																		if(settings.onend){settings.onend(cur,n)}
																		$this.attr('sv_cur',n);
																		$this.attr('sv_timer',setTimeout(function(){startSwitch($this);}, settings.delay));
																		$this.attr('sv_ani',0);	
																	});
														next();
													})
													.dequeue("svUltimateSlider");
										}
				}
		}
		var doSwitch=function($this,n){
			if(settings.onstart){settings.onstart(cur,n);}				
			var trans=getTransData($this);
			var data = cloneSlide($this,trans,n);
			$this.append(data[0]);
			$('li',$(settings.controls)).removeClass('active');
			$($('li',$(settings.controls))[n]).addClass('active');
			if(trans.slide!='next'){
				$($this.children('li')[n]).css({zIndex:2});
				$($this.children('li')[$this.attr('sv_cur')]).css({zIndex:0});
			}
			doTransition($this,data[1],data[0],n,trans);
		}
		return this;
	}	
})(jQuery);