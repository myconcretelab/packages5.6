
$(document).ready(function(){

	/* --- Quand on clique sur la nav de la recherche --- */

	$('.relpane').click(function(e){
		e.preventDefault();
		var r = $( $(this).data('relpane') );
		$('.relpane-slide').slideUp(500);
		if (!r.is(':visible'))
			$(r).slideToggle(500);
	})

	/* --- Le compteur d'options choisies --- */

	$('.ccm-search-option').find("input[type=checkbox]").on( "click", function(){
		var t = $(this);
		var p = t.parents('.ccm-search-option');
		var c = p.find("input:checked").length;
		if (c) p.prev('h5').find('span').show().html(c);
		else p.prev('h5').find('span').hide();

	} );
});