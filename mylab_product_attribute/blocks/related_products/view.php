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

foreach ($products as $key => $product) :
$args['primaryImage'] = $product->getProductThumbnailImageObject();
$args['productID'] = $product->getProductID();
$args['product'] = $product;
?>
<div class="rp_product" style="width:<?php echo 100 / $columns?>%">
	<div class="rp_product_inner">
		<?php Loader::packageElement('product/display', 'core_commerce', $args); ?>
	</div>
</div>
<?php endforeach ?>



