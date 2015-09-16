var last_selected_fsid = 0;

function ccmValidateBlockForm() {
    return false;
}

$(document).ready(function () {
    $('.fire').hover(function(){$(this).fadeTo(300,0.5)}, function() {$(this).fadeTo(300,1)});
});

var addCover = function (ciID, $context) {
	var container = $('#accordion');
	var $_context = $context ? $context : $("<div id='cover-" + panelID + "' rel='' class='cover'></div>").append('<h3><a href="#">Cover</a></h3>').prependTo("#accordion");;
	panelID ++;
	$.ajax({
            type: "POST",
	    url: GET_COVER_DIALOG_URL,
            data: {'ciID':ciID, 'panelID':panelID},
	    success: function(response) {
		$_context.append('<div>' + response + '</div>');
		container.accordion('destroy');	    
		initAccordion();
	    }
	});
}

var deleteCover = function (panelID) {
	container = $('#accordion');
	ciID = $('#cover-' + panelID).attr('rel');
	if (ciID) {
	    $.ajax({
		type: "POST",
		url: GET_DELETE_COVER_URL,
		data: {'ciID':ciID},
		success: function(msg){
		    $('#cover-' + panelID).remove();
		    container.accordion('destroy');
		    initAccordion();

		}
	    });		
	} else {
	    $('#cover-' + panelID).remove();	    
	    container.accordion('destroy');
	    initAccordion();
	}
}
var addMedia = function (type, panelID, value, $context) {
	ADDRESS = eval("GET_ADD_" + type.toUpperCase() + "_URL");
	var $container = $('#medias-' + panelID );
	var $_context = $context ? $context : $container.append('<div></div>');
        $.ajax({
	    type: "POST",
	    url: ADDRESS,
	    data:{'panelID':panelID, 'value':value},
	    success: function(msg){

		$msg = $(msg);
		$msg.find('h3').prepend('<span><img src="' + BLOCK_URL + '/images/fire.png" alt="delete" onclick="deleteMedia($(this))" class="fire" /></span>&nbsp;');

		$($_context).append($msg);
		$container.accordion('resize');
	    }
        });
}
var deleteMedia = function ($fire) {
    $fire.parents('.media').fadeOut(500, function(){$(this).remove()});
}
function loadFileInfos (fID, $context) {
    var $_context = $context;
    if (fID) {
        $.ajax({
	    type: "POST",
	    url: GET_SELECTOR_DATA_URL,
	    data:{'fID':fID},
	    success: function(msg){
		if (msg) {
		    $('.ui-accordion-content .logo-infos', $_context).html(msg);
		    $('.ui-accordion-header a', $_context).text( $('.ui-accordion-content .logo-infos', $_context).find('h3').text() );
		}
	    }
        });
	
    }
}

var initAccordion = function (actived) {
    $( "#accordion h3" ).click(function( event ) {
	    if ( stop ) {
		    event.stopImmediatePropagation();
		    event.preventDefault();
		    stop = false;
	    }
    });
    $( "#accordion" )
	    .accordion({
		    header: "> div > h3",
		    autoHeight: false,
		    clearStyle: true,
	    })
	    .sortable({
		    axis: "y",
		    handle: "h3",
		    stop: function() {
			    stop = true;
		    }
    });
    $('.medias-infos').each(function() {
	$(this).sortable({axis: "y",
			 containment: $(this).parents('.ui-accordion-content')
			 })
	});
	
}

ccm_triggerSelectFile = function(fID, af) {
	if (af == null) {
		var af = ccm_alActiveAssetField;
	}
	//alert(af);
	var obj = $('#' + af + "-fm-selected");
	var dobj = $('#' + af + "-fm-display");
        loadFileInfos(fID, $(obj).parents('.cover'));
	dobj.hide();
	obj.show();
	obj.load(CCM_TOOLS_PATH + '/files/selector_data?fID=' + fID + '&ccm_file_selected_field=' + af, function() {
		/*
		$(this).find('a.ccm-file-manager-clear-asset').click(function(e) {
			var field = $(this).attr('ccm-file-manager-field');
			ccm_clearFile(e, field);
		});
		*/
		obj.attr('fID', fID);
		obj.attr('ccm-file-manager-can-view', obj.children('div').attr('ccm-file-manager-can-view'));
		obj.attr('ccm-file-manager-can-edit', obj.children('div').attr('ccm-file-manager-can-edit'));
		obj.attr('ccm-file-manager-can-admin', obj.children('div').attr('ccm-file-manager-can-admin'));
		obj.attr('ccm-file-manager-can-replace', obj.children('div').attr('ccm-file-manager-can-replace'));
		
		obj.click(function(e) {
			e.stopPropagation();
			ccm_alActivateMenu($(this),e);
		});
	});
	var vobj = $('#' + af + "-fm-value");
	vobj.attr('value', fID);
	ccm_alSetupFileProcessor();
}