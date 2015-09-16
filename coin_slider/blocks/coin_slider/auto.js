// Sartable galleria JS

function ccmValidateBlockForm() {
    if ($('#fsID').val() == '' || $('#fsID').val() == null) {
        ccm_addError(ccm_t('fsID-required'));
    }
        return false;
}
