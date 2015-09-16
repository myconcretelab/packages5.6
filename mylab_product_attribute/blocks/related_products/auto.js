function ccmValidateBlockForm() {
    if ($('#attributeHandle').val() == '') {
        ccm_addError(ccm_t('attributeHandle-required'));
    }
    if ($('.productSource:checked').val() == 'specific' && $('div.product-selected-wrapper').size() == 0) {
        ccm_addError(ccm_t('product-required'));
    }
 
    return false;
}