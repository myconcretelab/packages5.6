
$(document).ready(function(){

	/* --- Quand on pick une categorie --- */

	$(".chzn-select").chosen();
	
	/* --- Les tabs --- */

	var ccm_ugActiveTab = "ccm-block-categories";
	 
	$("#ccm-block-tabs a").click(function() {
	    $("li.ccm-nav-active").removeClass('ccm-nav-active');
	    $("#" + ccm_ugActiveTab + "-tab").hide();
	    ccm_ugActiveTab = $(this).attr('id');
	    $(this).parent().addClass("ccm-nav-active");
	    $("#" + ccm_ugActiveTab + "-tab").show();
	});

});