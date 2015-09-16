$(document).ready(function() {
	$( ".accordion" ).accordion({autoHeight:false,collapsible: true});
	$('.toggle-button:checkbox').each(function(){
		if($(this).parents('.postbox').is('.closed')){
			var button = $(this);
				
			button.parents('.postbox').children('.hndle,.handlediv').bind('clickoutside',function(e){
				button.iphoneStyle();
			});
		}else{
			$(this).iphoneStyle({resizeHandle:false, resizeContainer:false });
		}
	});

	$('select.tri-toggle-button').each(function(){
		if($(this).parents('.postbox').is('.closed')){
			var button = $(this);
			button.parents('.postbox').children('.hndle,.handlediv').bind('clickoutside',function(e){
				button.iphoneStyleTriToggle();
			});
		}else{
			$(this).iphoneStyleTriToggle();
		}
	});
	//$(':radio').iToggle({type: 'radio'});

	/*** Range ***/
	$(".range-input-wrap :range").rangeinput();

	/*** Preset select ***/
	$('#preset_id').change(function() {
		$('#preset_to_edit').submit();	
	});

});


