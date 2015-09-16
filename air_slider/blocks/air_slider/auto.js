ccmValidateBlockForm = function() {
	if ($("#fsID").val() == '0') { 
		ccm_addError('please choose a Fileset');
	}

	$(".numeric").each(function(){
		if (! IsNumeric($(this).val())) { 
			ccm_addError($(this).attr('name') + ' must be a numeric value');
		}
	});
	return false;
}

$(document).ready(function() {
	$('select#fsID').change(function() {
		if (this.value == -1) {
                    openFileManager();
		}
	});
});

function IsNumeric(input)
{
    return (input - 0) == input && input.length > 0;
}

function refreshFilesetList(select_value) {
	var select = $('select#fsID');
	var value = (select_value == undefined) ? select.val() : select_value;
	last_selected_fsid = value;
	
	$.ajax({
	    url: GET_FILESETS_URL,
	    dataType: 'html',
	    success: function(response) {
		select.html(response);
		select.val(value);
		select.append('<option value="0">------</option><option value="-1">GO TO FILE MANAGER...</option>');
		//refreshImagesList();           
	    }
	});
}

function openFileManager() {
	$.fn.dialog.open({
		width: '90%',
		height: '70%',
		modal: false,
		href: CCM_TOOLS_PATH + "/files/search_dialog",
		title: ccmi18n_filemanager.title,
		onClose: function () {
			refreshFilesetList(last_selected_fsid);
		}
	});
}
