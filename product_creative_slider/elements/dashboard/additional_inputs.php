<?php  defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('product/model', 'core_commerce');
// Toutes les variable POST envoyée deviennent variable ici 

$product = CoreCommerceProduct::getById($pID);

if (is_object($product)) :

	$images = array();
	
	if($product->getProductThumbnailImageID())
		$images[] = $product->getProductThumbnailImageObject();
	if ($product->getProductFullImageID())
		$images[] = $product->getProductFullImageObject();
	
	$add = $product->getAdditionalProductImages();
	if (count($add))
		$images = array_merge($images, $add);

	// Maintenant on construit les inputs
	if (count($images)) :
		echo '<ul>';
		foreach ($images as $k => $f) : ?>
			<li>
			<label>
				<input type="radio" name="productImage_<?php echo $pID?>" value="<?php echo $f->fID ?>" <?php  if ($selected == $f->fID || (!$selected && $k == 0)) echo 'checked';?>>
				<img src="<?php echo Loader::helper('image')->getThumbnail($f,40,40)->src ?>" alt="<?php echo $f->fID ?>">
			</label>
			</li>
		<?php endforeach;
		echo '</ul>';
	endif;

endif;





