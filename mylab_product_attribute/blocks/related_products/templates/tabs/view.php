<?php  defined('C5_EXECUTE') or die("Access Denied.");
Loader::block('product');
$pc = new ProductBlockController();
$args = array(
	
	/* --- Settings --- */
	// You can play with this settings to personalize the displaying of product //

	'controller' => $pc,
    'addToCartText' => 'Add to Cart',
    'displayLinkToFullPage' => false,
    'displayAddToCart' => true,
    'displayQuantity' => true,
    'displayNameP' => true,
    'displayDescriptionP' => true,
    'displayDiscountP' => true,
    'displayDimensionsP' => true,
    'displayPriceP' => true,
    'displayQuantityInStock' => true,
    'inheritProductIDFromCurrentPage' => true,
    'displayImage' => true,
    'hideSoldOut' => false,
    'displayHoverImage' => false,
    'imageMaxWidth' => '200',
    'imageMaxHeight' => '120',
    'imagePosition' => 'T', // T, L, B, R
    'primaryHoverImage' => null,
    'propertyOrder' => array
    (
        'displayName',
        'displayDescription',
        'displayPrice',
        'displayDiscount',
        'displayDimensions',
        'displayQuantityInStock',
    )
);

?>

<div class="responsive-tabs rp-tabs" style="opacity:0">

<?php 
foreach ($products as $key => $product) :
$args['primaryImage'] = $product->getProductThumbnailImageObject();
$args['productID'] = $product->getProductID();
$args['product'] = $product;

?>

	<h4><?php echo $product->getProductName(); ?></h4>
	<!-- The DIV where is placed the content, customize as you want --> 
	<div> 
		<?php Loader::packageElement('product/display', 'core_commerce', $args); ?>
	</div>

<?php endforeach ?>
<script>
$(document).ready(function() {
	RESPONSIVEUI.responsiveTabs();
})
	
</script>

</div> <!-- .responsive-tabs -->

