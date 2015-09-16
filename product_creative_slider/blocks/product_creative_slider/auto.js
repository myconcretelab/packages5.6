function ccmValidateBlockForm() {
    if (!$('#csID').val()) {
        ccm_addError(ccm_t('csID-required'));
    }
    return false;
}