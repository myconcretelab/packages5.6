<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('product/model', 'core_commerce');
Loader::model('cart', 'core_commerce');
$pkg = Package::getByHandle('core_commerce');
// Sets
Loader::model('product/set', 'core_commerce');
$productSets = CoreCommerceProductSet::getList();

$cart = CoreCommerceCart::get();

Loader::library('price', 'core_commerce');
$items = $cart->getProducts(); 
$uh = Loader::helper('urls', 'core_commerce');
$chs = Loader::helper('checkout/step', 'core_commerce');
$form = Loader::helper('form');

if(count($items)){
	$itemsCount = 0;
	foreach($items as $it)
		$itemsCount += $it->getQuantity();
}
?>
<br>
<a href="#" class="right" onclick="$.pageslide.close()">
	<i class="icon-remove-circle icon-2x" />
</a>
<h1>Panier d'achat</h1>
<?php  if (count($items) == 0) : ?>

	<h2>:-( <br>Votre panier est vide</h2>
	
<?php else : ?>

<p class="line"></p>
<form method="post" action="" id="slide_form">
	<table class="cartproduct">
	<?php  foreach($items as $it) : 
		// Prendre les products set auquel le produit appartient
	$productSetsName = array();
	if (count($productSets) > 0) {	
		foreach($productSets as $prs) {
			if ($prs->contains($it->getProductObject())) $productSetsName[] = $prs->getProductSetName();
		}
	}
	?>
		<tr>
			<td class="alternate">				
<!-- 			<div id="increase_decrease">
					<a id="increase"><i class="icon-plus-sign"></i></a>
					<a id="decrease"><i class="icon-minus-sign"></i></a>
				</div>
 -->			<?php echo $it->getQuantityField()?>	
			</td>
			<td>
				<h1 class="title">
					
					<?php echo implode(',', $productSetsName) ?>
				</h1>
				<small class="name"><?php echo $it->getProductName()?>	</small>
			</td>
			<td>
				<a class="delete" href="#" data-pid="<?php echo $it->getOrderProductID() ?>"><i class="icon-remove-circle"></i></a>
			</td>
		</tr>
	<?php endforeach ?>
	</table>
	<div class="clear"></div>
	<p class="line"></p>
	<p class="total">Total</p>
	<h1 class="total"><?php echo $cart->getOrderDisplayTotal()?></h1>
	<div class="space"></div>
	<input type="hidden" name="method" value="JSON">
	<!-- <input type="hidden" name="rcID" id="rcID" value="<?php //echo Page::getCurrentPage()->getCollectionID() ?>"> -->
	<input type="hidden" name="dialog" value="1">
	
	<button type="submit" class="button button-flat-royal update" value="Mettre à jour" ><i class="icon-refresh"></i> <?php echo t('Update') ?></button>
	<a href="<?php  echo CoreCommerceCheckoutStep::getBase() . View::url('/checkout')?>" class="button button-flat-primary "><i class="icon-shopping-cart"></i> <?php echo t('Buy') ?></a>
	<!-- <button class="button-block" onclick="coreCommerceGoToCheckout('<?php echo CoreCommerceCheckoutStep::getBase() . View::url('/checkout')?>')" ></button> -->
	
	</form>
<?php endif ?>
<script>
	$(document).ready(function(){

		$('#slide_form').slideCart(cart);

	});
</script>