
function ccmValidateBlockForm() {
    if (!$('#tName').val()) {
        ccm_addError(ccm_t('tName-required'));
    }
        return false;

}
