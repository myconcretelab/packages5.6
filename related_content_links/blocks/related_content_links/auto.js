function ccmValidateBlockForm() {
	if ($('select#relatedCategoryOptionID').val() == '' || $('select#relatedCategoryOptionID').val() == '0') {
		ccm_addError('You must choose a related category.');
	}
	
	if (missingRequiredNumber('displayCount')) {
		ccm_addError('You must enter the number of pages to display.');
	}
 
	return false;
}

function missingRequiredNumber(id) {
	var value = $('input#'+id).val();
	return ( value == '' || isNaN(value) );
}
