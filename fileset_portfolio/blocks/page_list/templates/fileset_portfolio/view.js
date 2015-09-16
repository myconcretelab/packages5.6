(function ($) {
     
     $.fn.filesetPortfolio = function () {
        $(this).each(function(){
            var  $this_list	= $(this),
                total_w		= 0,
                loaded		= 0,
        
                //preload all the images first
                $images		= $this_list.find('img'),
                total_images = $images.length;
                $images.each(function(){
                        var $img = $(this);
                        $('<img/>').load(function(){
                                ++loaded;
                                if (loaded == total_images){
                                        $this_list.data('current',0).children().each(function(){
                                                total_w	+= $(this).width();
                                        });
                                        $this_list.css('width', total_w + 'px');
        
                                        //next / prev events
                                        $this_list.parent()
                                        .siblings('.next')
                                        .bind('click',function(e){

                                                var current = $this_list.data('current');
                                                if(current == $this_list.children().length -1) return false;
                                                var	next	= ++current,
                                                ml		= -next * $this_list.children(':first').width();
        
                                                $this_list.data('current',next)
                                                .stop()
                                                .animate({
                                                        'marginLeft': ml + 'px'
                                                },400);
                                                e.preventDefault();
                                        })
                                        .end()
                                        .siblings('.prev')
                                        .bind('click',function(e){
                                                var current = $this_list.data('current');
                                                if(current == 0) return false;
                                                var	prev	= --current,
                                                ml		= -prev * $this_list.children(':first').width();
        
                                                $this_list.data('current',prev)
                                                .stop()
                                                .animate({
                                                        'marginLeft'	: ml + 'px'
                                                },400);
                                                e.preventDefault();
                                        });
                                } else {
                                        
                                }
                        }).attr('src',$img.attr('src'));
                });
        });   
    }
})(jQuery);