<?php  defined('C5_EXECUTE') or die("Access Denied.");

	/*
	Are available here :
	$product 	-- 	The product object from core_commerce
	$slide 		-- 	The Slide object that contains all info about slide. Fore example here 
	$ih 		--  The Image Helper from C5

    [csID] => 2
    [cssID] => 1
    [productsID] => Array
        (
            [0] => 5
            [1] => 2
            [2] => 6
            [3] => 3
        )

    [structure] => Array
        (
            [0] => 4
            [1] => one_three
        )

    [fType] => 1
    [richContent] => "Hello World"
    [lateralContentDisplay] => right
    [contentWidth] => 30
    [contentBg] => #d0d9d6
    [contentBgImg] => 0
    [overridePagerColor] => on
    [pagerColor] => #f4f6f7
    [pagerColorActive] => #e1e3e6
    [productImageInfo] => circle_price
    [ImageCaptionbg] => #d0d9d6
    [productImageHoverCaption] => cover
    [ImageHoverCaptionbg] => #f4f6f7
    [imageHeight] => 300
    [products] => Array ()
 */
   	$th = Loader::helper('text');
	$slide->shortenCaptionDescription = 110;
?>	
	
	<div class="hoverdir pcs_caption" style="background-color:<?php echo $slide->ImageHoverCaptionbg ?>">
		<h3><a class="" href="<?php echo $product->pcs_pageLink ?>"><?php echo $product->getProductName() ?></a></h3>
		<p><?php echo  $th->shorten($product->getProductDescription(),$slide->shortenCaptionDescription) ?></p>
		<p class="pcs_price"><?php   echo Loader::packageElement('product/price', 'core_commerce', array('product' => $product, 'displayDiscount' => true)); ?></p>
	</div>