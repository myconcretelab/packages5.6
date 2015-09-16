<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('cart', 'core_commerce');
$chs = Loader::helper('checkout/step', 'core_commerce');
$th = Loader::helper('concrete/urls')->getToolsURL('cart_dialog', 'core_commerce');
$c = Page::getCurrentPage();
?>



<div class="cart-quantity-wrapper scallop">
	&nbsp;
	<i class="icon-shopping-cart"></i> <?php // echo $cartLinkText?>
	&nbsp;
	<a class="toggle-pageslide alternate cart-quantity" href="<?php echo $this->url('/cart?rcID=' . $c->getCollectionID())?>">
		<?php  echo $items ?>
	</a>
	&nbsp; | &nbsp;
	<span class='cc-checkout-link-show' style='<?php echo ($showCheckoutLink && $items > 0?'':'display:none')?>'>
		<a href="<?php  echo CoreCommerceCheckoutStep::getBase() . View::url('/checkout')?>"><?php  echo $checkoutLinkText?></a>
	</span>	
	&nbsp; | &nbsp;
	<a class="toggle-pageslide" href="<?php echo $this->url('/cart?rcID=' . $c->getCollectionID())?>">
		<?php echo $cartLinkText?> <i class="icon-expand"></i>
	</a>
	&nbsp;
</div>
