<?php  defined('C5_EXECUTE') or die("Access Denied.");
$productAttribute = Loader::helper('form/product', 'mylab_product_attribute');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
	#product {
		margin: 5px;
		padding:5px;
		border:1px solid #ccc;
	}
</style>
<div class="ccm-block-field-group">
	<h2><?php echo t('Take related product from :') ?></h2>
	<input type="radio" value="specific" name="productSource" class="productSource" <?php echo $productSource == 'specific' ? 'checked' : '' ?>>
	<strong><?php echo t('a specific product') ?></strong>
	<br>
	<input type="radio" value="inherit"  name="productSource" class="productSource"  <?php echo $productSource == 'inherit' ? 'checked' : '' ?>>
	<strong><?php echo t('the product from current page') ?></strong>
	<div id="product">
		<strong><?php echo t('Choose a product') ?></strong>
		<?php echo $productAttribute->display('productID',$productID,true); ?>
	</div>	
</div>

<div class="ccm-block-field-group">
	<h2><?php echo t('Basic formating') ?></h2>
	<strong><?php echo t('Number of columns') ?></strong>
	<input type="text" value="<?php echo $columns ?>" name="columns">
</div>

<div class="ccm-block-field-group">
	<h2><?php echo t('Advanced option') ?></h2>
	<strong><?php echo t('The attribute handle for related product') ?></strong>
	<input type="text" value="<?php echo $attributeHandle ?>" name="attributeHandle" id="attributeHandle">
</div>
<script>
	<?php if($productSource == 'inherit') :?>$('#product').hide();<? endif?>
	$('.productSource').change(function(){
		if ($(this).val() == 'specific') {
			$('#product').show();
		} else {
			$('#product').hide();
		}
	})
</script>