function ccmValidateBlockForm() {
	if($('#sortable1 li').size() == 0 ) {
		$('#sortable1').css('border','2px solid red');
		ccm_addError(ccm_t('element-required'));
		
	};
      $('#sortable1 li').each(function(){
		val = $(this).attr('rel');									   
		$(this).append("<input type='hidden' name='elements_" + val + "' value='" + val + "' />");
	      });
}
