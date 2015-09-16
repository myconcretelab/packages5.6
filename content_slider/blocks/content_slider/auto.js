function ccmValidateBlockForm() {
	if($('.blockTitle').size() == 0) {
		ccm_addError('You must choose a Scrabook with blocks inside');		
	}
}
$(document).ready(function(){
	// Add value 'all' to each type select and check if 'all' is the selected value
	$('.type select').each(function() {
		$(this).prepend('<option value="all">All</option>');
		if ($(this).attr('ccm-passed-value') == "all") {$(this).val('all')}
		});
	});
var setjQuerySlider = function ($name,$min,$max,$value,$step) {
    $value = ($value == undefined) ? parseInt($min) : parseInt($value);
    $step = ($step == undefined) ? 1 : $step;
    
     $('#range-'+$name).slider({
            value:$value,
            min: $min,
            max: $max,
            step:$step,
            slide: function( event, ui ) {
		slidejQuerySLider(ui.value,$name);
	    }
    });
     slidejQuerySLider($value, $name);    
}

var slidejQuerySLider = function ($v, $n) {
	$('input#'+$n).val($v);	    
}

var addAnimationType = function () {
	$('#array_types .type:first-child').clone().val('fade').appendTo('#array_types');
	
}
var removeAnimationType = function (type) {
	if($('#array_types .type').size() > 1 ) {
		$(type).parent().remove();	
	}
	return false;
}

var loadBlockInfos = function (stID) {
	if (stID == '') { return false };
	$.ajax({
		url: GET_BLOCK_FORM_TOOL_URL,
                data:{'bID':BLOCK_ID,'stID':stID},
		dataType: 'html',
		success: function(response) {
			$('#blocks_infos').html(response);
		}
	});
	
}