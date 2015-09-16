<?php  defined('C5_EXECUTE') or die("Access Denied.")?>
<!-- Le bouton d'ajout -->
<input type="button" class="btn ccm-input-button" value="<?php echo t('Add a Product') ?>" onclick="assign_choose_product<?php echo $akID ?>();openProductList(); return false">
<!-- Le loader -->
<img id="loader_<?php echo $akID?>" style="" src="<?php echo ASSETS_URL_IMAGES?>/loader_intelligent_search.gif">

<!-- La	boite qui contients les produits attachés  -->
<div id="ak<?php echo $akID ?>_attachedProductsList"> 
	<?php   
	if ( is_array($products) && count($products)) :
		foreach($products as $product) :
			Loader::PackageElement('product_attribute', 'mylab_product_attribute', array('product'=>$product, 'akID' => $akID));
		endforeach ;
	endif?> 
</div> 


<script>
	$(document).ready(function(){
		$('#loader_<?php echo $akID?>').hide();
	});

	// La fonction qui définit la variable qui sera appellé une fois la fenetre fermée
	function assign_choose_product<?php echo $akID ?>(){
		$('#loader_<?php echo $akID?>').show();
		ccm_chooseAsset = function (data){
			if(!parseInt(data.pID)) return false;

			jQuery.post('<?php echo $attribute_tools_url ?>', {pID:data.pID, akID:<?php echo $akID?>}, function (data) {
				$('#ak<?php echo $akID ?>_attachedProductsList').append(data);
			}); 
		}
	}
	// Ouvrir la fenetre
	function openProductList () {
		$.fn.dialog.open({
			width: '90%',
			height: '70%',
			modal: false,
			href: '<?php  echo $product_list_tools; ?>?mode=choose_one',
			title: 'Choose a product',
			onClose: function() {$('#loader_<?php echo $akID?>').hide()}
		});
	}
	// Retirer un produit
	function removeProduct(id) {
		$(id).remove();
	}
</script>


<style>
	/* On cache l'effet hover présent comme sur un attribut file */
	.product-selected-wrapper:hover {
		cursor: default !important;
		border: 1px solid #ccc !important;
		background: #fefefe !important;
	}
</style>