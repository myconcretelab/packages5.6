function ccmValidateBlockForm() {
    if ($('#fsID').val() == '' || $('#fsID').val() == null) {
        ccm_addError(ccm_t('fsID-required'));
    }
    if ($(document.forms['ccm-block-form'].elements['layerID[]']).size() > 0){
        for ( i=0 ; i < $(document.forms['ccm-block-form'].elements['layerID[]']).size(); i++){
            if (i==0) {
                id = $(document.forms['ccm-block-form'].elements['layerID[]']).val();
            } else {
                id = $(document.forms['ccm-block-form'].elements['layerID[]'][i]).val();            
            }
            layer_file = $(document.forms['ccm-block-form'].elements['layer_'+id+'-fm-value']).val();
            if (layer_file == 0 ) {
                ccm_addError(ccm_t('layerFile-required'));
            }            
        }
    } else {
        // They are no layers;
    }
        return false;
}



 