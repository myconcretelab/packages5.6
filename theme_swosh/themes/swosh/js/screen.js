
$(document).ready(function(){		
	$("ul.sf-menu").superfish(); 
	jQuery("#responsive-menu select").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});

	$('#tweets').tweetable({username: 'anariel77', time: true, limit: 1, replies: true, position: 'append'});

	//viewportheight : $(document).height();

});

	




