
	function onProductAdded (data) {
		PRODUCTS_COUNT ++;
		// on test si on ne dépasse pas le nombre max
		if (PRODUCTS_COUNT <= MAX_IMAGES) {
			refreshStructureInputs(PRODUCTS_COUNT);
			// Maintenant on va ajouter des input specialisé
			addInputToProductForm (data);

		}else {
			PRODUCTS_COUNT --;
			alert(ALERT_PRODUCT_MSG);
		}

	}

	function onProductRemoved () {
		if (PRODUCTS_COUNT > 0) {
			PRODUCTS_COUNT --;
			refreshStructureInputs(PRODUCTS_COUNT);
		}
	}

	function refreshStructureInputs (_n, _checked) {
		$.post(STRUCTURE_INPUT, {n:_n, max_images:MAX_IMAGES, checked:_checked},function(data){
			// On rempli du html reçu
			$('#structure').html(data);
		});

	}

	function addInputToProductForm (data) {
		additionalFormContainer = data.container.find('.additional-data');
		data.container = '';
		additionalFormContainer.load(ADDITIONAL_PRODUCT_FORM_URL, data);		
	}

	$(document).ready(function(){
		// On sauve le formulaire en ajax		
        $('#slide_form').ajaxForm( {

        	beforeSubmit : function () {
				$('.pcs-loader').addClass('loading').find('.notice').html('Saving options')
        	},
        	success : function(data) {
				//$("#ccm-dialog-loader-wrapper").hide();
				if (!data) {
					$('.pcs-loader .notice').html('Saved, redirecting');
					window.location.href = MANAGE_SLIDER_URL;
				} else {
					$('.pcs-loader').removeClass('loading');
					$('#ccm-dashboard-result-message').show().find('.span12').html('<div class="alert alert-error">' + data + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
				}
				}
        	}
        )
	});