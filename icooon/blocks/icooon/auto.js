
function ccmValidateBlockForm() {
	//console.log('validate : ',$('#iconName').val(), $('#contentText').val() )
    if ($('#iconName').val() == '') {
        ccm_addError(ccm_t('icon-required'));
    }
    if ($('#titleText').val() == '') {
        ccm_addError(ccm_t('title-required'));
    }
    return false;
}

function showPane (pane) {
	$('ul#ccm-icooon-tabs li').each(function(num,el){ $(el).removeClass('ccm-nav-active') });
	$(document.getElementById('ccm-icooon-tab-' + pane).parentNode).addClass('ccm-nav-active');
	$('div.ccm-icooonPane').each(function(num,el){ el.style.display='none'; });
	$('#ccm-icooonPane-'+pane).css('display','block');
}
