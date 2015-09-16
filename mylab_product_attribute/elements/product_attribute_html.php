<?php  defined('C5_EXECUTE') or die("Access Denied.");

// Ce fichier est utilisé pour afficher un input permettant de chosir un ou plusieurs produits
// Dans les block ou les pages.
// Il n'est pas concu pour être affiché dans le contexte d'un attribut.

?>
<!-- Le bouton d'ajout -->
<input type="button" class="btn ccm-input-button" value="<?php echo t('Add a Product') ?>" onclick="assign_choose_product<?php echo $inputName ?>();openProductList(); return false">
<!-- Le loader -->
<img id="loader_<?php echo $inputName?>" style="" src="<?php echo ASSETS_URL_IMAGES?>/loader_intelligent_search.gif">

<!-- La	boite qui contients les produits attachés  -->
<div id="<?php echo $inputName ?>_attachedProductsList" class="attachedProductsList"> 
	<?php   
	if (is_array($products) && count($products)) :
		foreach($products as $key => $product) :
			// $additionalData est un tbleau de caratctère correspondant à chaque produit
			// On recupère pour chaque produit sa valeur si il existe
			$a = isset($additionalData[$key]) ? $additionalData[$key] : '';
			Loader::PackageElement('product_attribute_html_form', 'mylab_product_attribute', array('product'=>$product, 'inputName' => $inputName,'additionalData' => $a ));
		endforeach ;
	endif?> 
</div> 




<script>

	$(document).ready(function(){
		$('#loader_<?php echo $inputName?>').hide();
		  $( "#<?php echo $inputName ?>_attachedProductsList" ).sortable({ containment: "parent" });
    		$( "#<?php echo $inputName ?>_attachedProductsList" ).disableSelection();
	});
	// La fonction qui définit la variable qui sera appellé une fois la fenetre fermée
	function assign_choose_product<?php echo $inputName ?>() {
		ccm_chooseAsset = function (data){			
			if(!parseInt(data.pID)) return false;

			jQuery.post('<?php echo $attribute_tools_url ?>', {pID:data.pID, inputName:'<?php echo $inputName?>'}, function (html) {
				var input = $(html).appendTo('#<?php echo $inputName ?>_attachedProductsList');
				// un callback si necessaire
				if(typeof onProductAdded == 'function'){
					onProductAdded({pID:data.pID, inputName:'<?php echo $inputName?>', container:input});
				}			
			});
		}
	}
	// Ouvrir la fenetre
	function openProductList () {
		<?php if ($limitProduct) : ?>
		// Ceci n'est utilisé que quand l'attribut est limite à un vertain nombre de produit
		if ($('#<?php echo $inputName ?>_attachedProductsList  div.product-selected-wrapper').size() >= <?php echo $limitProduct ?> ) {
			alert("<?php echo t('You can\'t add more product')?>");
			return false;
		}
		<?php endif ?>
		$('#loader_<?php echo $inputName?>').show();
		$.fn.dialog.open({
			width: '90%',
			height: '70%',
			modal: false,
			href: '<?php  echo $product_list_tools; ?>?mode=choose_one',
			title: 'Choose a product',
			onClose: function() {
				$('#loader_<?php echo $inputName?>').hide();
			}
		});
	}
	// Retirer un produit
	function removeProduct(id) {
		$(id).remove();
			// un callback si necessaire
		if(typeof onProductRemoved == 'function'){
			onProductRemoved(id);
		}		
	}
</script>


<style>
	/* On cache l'effet hover présent comme sur un attribut file */
	.product-selected-wrapper:hover {
		cursor: move !important;
		border: 1px solid #ccc !important;
		background: #fefefe !important;
	}
	.attachedProductsList {
		padding: 10px;
	}

</style>