<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('cart', 'core_commerce');
$chs = Loader::helper('checkout/step', 'core_commerce');
$th = Loader::helper('concrete/urls')->getToolsURL('cart_dialog', 'core_commerce');
$c = Page::getCurrentPage();
?>

<div class="cart-quantity-wrapper">
	<i class="fa fa-shopping-cart fa-lg"></i>&nbsp;
<?php  if ($showCartLink) { ?>
	<a href="<?php echo $this->url('/cart?rcID=' . $c->getCollectionID())?>" onclick="ccm_coreCommerceLaunchCart(this, '<?php echo $th?>'); return false"><?php echo $cartLinkText?></a>&nbsp;
<?php  } ?>
<?php  if ($showItemQuantity) { ?>
	(<span id="cc-cart-quantity" href="<?php echo $qh?>"><?php  echo $items . ' ' . ($items != 1 ? t('items'):t('item')) ?></span>)&nbsp;
<?php  } ?>
	<span class='cc-checkout-link-show' style='<?php echo ($showCheckoutLink && $items > 0?'':'display:none')?>'>
	    |
		<a href="<?php  echo CoreCommerceCheckoutStep::getBase() . View::url('/checkout')?>"><?php  echo $checkoutLinkText?></a>
	</span>
</div>


