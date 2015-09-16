<?php  defined('C5_EXECUTE') or die("Access Denied.");
$ih = Loader::helper('image');
$th = Loader::helper('concrete/urls');
$teh = Loader::helper('text');
$form = Loader::helper('form');
$db = Loader::db();
Loader::model('product/model', 'core_commerce');

$pID = $_GET['pID'];
if (!$pID) die('Erreur, pas d\'identifiant produit');

$product = CoreCommerceProduct::getByID($pID);
//var_dump($pID);
$c = Page::getByID($_GET['cID']);

$themePath = DIR_REL . '/packages/theme_little_fabric/themes/little_fabric/';

// Infos

$productID = $product->getProductID();

$description = $product->getProductDescription();
$price = $product->getProductDisplayPrice();
$name = $product->getProductName();
$taille = $product->getAttribute('taille');
$taille_motif = $product->getAttribute('taille_motif');
$composition = $product->getAttribute('composition');
$designer = $product->getAttribute('designer');

// Images	
$image = $product->getProductFullImageObject();
$image_small = $ih->getThumbnail($image,300,300,true);
$image_big = $ih->getThumbnail($image,1000,1000);
// Tools
$product_popup_url = $th->getToolsURL('product_popup', 'theme_little_fabric') . '?pID=' . $productID;
$colorcategoryurl = '?category=les_couleurs&value' . $product->getAttribute('les_couleurs');
// Les attributs
$categories_list = CoreCommerceProductAttributeKey::getList();

?>
<div class="container">
<form method="post" id="add_cart_popup" action="#"> <!-- ccm-core-commerce-add-to-cart-form -->
<input type="hidden" name="rcID" value="<?php echo $_GET['cID'] ?>" />


		<div class="row">			
			<div class="span5">
				
				<div class="image">
					<h1 class="ribbon-pink"><div class="ribbon-stitches-top"></div><span><?php echo $product->prName ?><?php if($description) :?><small><?php echo $description ?></small><?php endif ?></span><div class="ribbon-stitches-bottom"></div></h1>
					<img src="<?php echo $image_big->src ?>" style="display:none" />
					<img src="<?php echo $image_small->src ?>" class="small" alt="" />
				</div>
			</div> <!-- .images -->
			
			<div class="infos span4">
				<div class="text">
					<table>
					<?php foreach ($categories_list as $att) :
						$attValue = $product->getAttribute($att->akHandle);
						if(is_object($attValue) && is_object($attValue->current()) ) : ?>
						<tr>
							<td class="title"><?php echo str_replace('Les ', '', $att->akName) ?></td>
							<td><?php echo $attValue->current()->getSelectAttributeOptionValue();  ?></td>
						</tr>
					<?php endif; endforeach; ?>
					</table>
					<div class="add_cart">
						<div class="ajax-loader"></div>
						<strong><?php echo t('Quantité :') ?></strong>
						<input type="text" name="quantity" value="1" id="quantity" class="ccm-core-commerce-max-quantity">
						<div id="increase_decrease">
							<a id="increase"><i class="icon-plus-sign"></i></a>
							<a id="decrease"><i class="icon-minus-sign"></i></a>

						</div>
						<?php if ($_GET['special_text']) : ?><p style="margin:0"><?php echo urldecode($_GET['special_text']) ?></p><?php endif ?>
						<div class="clear space"></div>
						<?php echo $form->hidden('productID', $pID); ?>
						<span class="button button-flat-primary"><?php echo $price ?> ttc</span>
						<button type="submit" name="submit" value="1" id="submit" class="button button-flat-primary"><i class="icon-shopping-cart icon-large"></i> <?php echo t('Ajouter au panier') ?></button>
						
					</div><!-- #add_cart -->
				</div> <!-- .texte -->				
			</div> <!-- .infos -->
			
			<div class="span4">
			</div>
			<div class="clear"></div>
		</div> <!-- .row -->

	<div class="clear"></div>
	<a title="Close" class="hide"><i class="icon-remove-sign icon-3x"></i></a>
	
	</form>
</div>	
	
<script>
	$(".image").zoom();
	$(document).ready(function () {
		$('#add_cart_popup').slideCart(cart);

	})
	//coreCommerceRegisterAddToCart("add_cart_popup",);

</script>	