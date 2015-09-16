<?php  defined('C5_EXECUTE') or die("Access Denied.")?>

    <!-- ===== FLOW ===== -->
    <div id="contentFlow" class="ContentFlow">
        <!-- should be place before flow so that contained images will be loaded first -->
        <div class="loadIndicator"><div class="indicator"></div></div>

        <div class="flow">
				                

<?php 
foreach ($products as $key => $product) :
$columns = 3;	
// Here some variable usefull for your template
$price = $product->getProductDisplayPrice();
$name = $product->getProductName();

// The image thumbnail
$image = $product->getProductThumbnailImageObject();
$imagesrc = $ih->getThumbnail($image,80,80)->src;
$productID = $product->getProductID();

// The link to the product page //
$linksTo = Page::getByID($product->getProductCollectionID());
if ($linksTo->cID>0) 
	$pageLink = $this->url($linksTo->getCollectionPath());


//$attribs = $product->getProductConfigurableAttributes();			
//foreach($attribs as $at)

// Now The html that you can customize as you want
?>
            <div class="item" href="<?php echo $pageLink ?>">
                <img class="content" src="<?php echo $imagesrc ?>"/>
                <div class="caption">
					<h2><?php echo $name ?></h2>
					<p class="rp_price"><?php echo $price ?></p>
					<a href="<?php echo $pageLink ?>"><?php echo t('View') ?></a>			
                </div>
            </div>
	
<?php endforeach ?>
        </div>
        <div class="globalCaption"></div>
        <div class="scrollbar">
        	<div class="preButton"></div>
            <div class="nextButton"></div>
            <div class="slider"></div>
        </div>

    </div> <!-- #contentFlow -->

<script>
$(document).ready(function() {
	var cf = new ContentFlow('contentFlow', {reflectionColor: "#000000"});	
})

</script>

