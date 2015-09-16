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

	/*** Range ***/
	$(".range-input-wrap :range").rangeinput();

	/*** Chosen select ***/
	//$(".chzn-select").chosen();

	/*** Preset select ***/
	$('#preset_id').change(function() {
		$('#preset_to_edit').submit();	
	});

	/*** Font management ***/
	$('.font_selector').chosen().change(function(e,i) {
		
		var t = $(this); 
		var id = t.attr('id');
		var val = t.val();
		
		if (!val) return;

		var wrapper = t.parent().find('#' + id + '_details_wrapper');
		console.log(wrapper);
		wrapper.load(FONT_DETAILS_TOOLS_URL,{
			font:val,
			variantName : t.data('variant'),
			subsetName : t.data('subset'),
			inputType : t.data('itype')
		});

	});
});


