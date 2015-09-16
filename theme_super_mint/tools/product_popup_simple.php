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
$image_small = $ih->getThumbnail($image,450,450);
// Les attributs
$categories_list = CoreCommerceProductAttributeKey::getList();

?>
<div class="container">
<form method="post" id="add_cart_popup" action="#"> <!-- ccm-core-commerce-add-to-cart-form -->
<input type="hidden" name="rcID" value="<?php echo $_GET['cID'] ?>" />
		<div class="row-fluid">			
			<div class="span5">
                <div class="preview-caption zoom-caption" style="max-width:<?php echo $image_small->width ?>px; max-height:<?php echo $image_small->height ?>px">
                	<img src="<?php echo $image_small->src ?>" class="" alt="" />                    
                    <div class="mask">
                        <h2><?php echo $product->prName ?></h2>
                        <?php if($description) :?><p><?php echo $description ?></p><?php endif ?>                        
                        <!-- <a href="#" class="info">Read More</a> -->
                    </div><!-- .mask -->
                </div><!-- Zoo-caption -->
            </div><!-- span5 -->
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
						<div class="clear space"></div>
						<?php echo $form->hidden('productID', $pID); ?>
						<span class="button-block"><?php echo $price ?> ttc</span>
						<button type="submit" name="submit" value="1" id="submit" class="button button-flat-primary"><i class="icon-shopping-cart icon-large"></i> <?php echo t('Ajouter au panier') ?></button>
						
					</div><!-- #add_cart -->
				</div> <!-- .texte -->				
			</div> <!-- .infos -->
			
			<div class="span3">
				<?php 
				$add = $product->getAdditionalProductImages();
				if(count($add)) :
				 ?>
				<h3>Autres images</h3>
				<?php foreach ($add as $key => $image) : ?>
					<a href="<?php echo $image->getRelativePath() ?>" class="fancybox"><img src="<?php echo $ih->getthumbnail($image,80,80, true)->src ?>" alt=""></a>
				<?php endforeach ?>	
				<?php endif ?>			
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