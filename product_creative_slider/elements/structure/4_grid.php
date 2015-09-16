<?php defined('C5_EXECUTE') or die(_("Access Denied."));
extract ($slide->products);
/*

 
*/

?>
<!-- 4_grid -->
<table class="pcs_product_table">
	<tr>
		<td>
			<div class="pcs_product_inner">
				<a class="pcs_image_link" href="<?php echo $product_1->pcs_pageLink ?>" style="height:<?php echo $slide->imageHeight ?>px; background-image:url(<?php echo  $ih->getThumbnail($product_1->pcs_imageObject,450,$slide->imageHeight,$slide->imageCrop)->src ?>)">
				<?php if ($slide->productImageInfo) :
						// Here whe are loading the file to fix on image
						Loader::element('image_infos/' . $slide->productImageInfo, array(
							'product' => $product_1,'slide' => $slide,'ih' => $ih), 'product_creative_slider');
					endif?>
				</a>
				<?php 
				// Now we load the caption if asked
				if ($slide->productImageHoverCaption) :
					Loader::element('caption/' . $slide->productImageHoverCaption, array(
							'product' => $product_1,
							'slide' => $slide
							), 'product_creative_slider');
				endif?>		
			</div>
		</td>
		<td>
			<div class="pcs_product_inner">
				<a class="pcs_image_link" href="<?php echo $product_2->pcs_pageLink ?>" style="height:<?php echo $slide->imageHeight ?>px; background-image:url(<?php echo  $ih->getThumbnail($product_2->pcs_imageObject,450,$slide->imageHeight,$slide->imageCrop)->src ?>)">
				<?php if ($slide->productImageInfo) :
						// Here whe are loading the file to fix on image
						Loader::element('image_infos/' . $slide->productImageInfo, array(
											'product' => $product_2,'slide' => $slide,'ih' => $ih), 'product_creative_slider');
					endif?>
				</a>
				<?php 
				// Now we load the caption if asked
				if ($slide->productImageHoverCaption) :
					Loader::element('caption/' . $slide->productImageHoverCaption, array(
							'product' => $product_2,
							'slide' => $slide
							), 'product_creative_slider');
				endif?>		
			</div>			
		</td>
	</tr>
	<tr>
		<td>
			<div class="pcs_product_inner">
				<a class="pcs_image_link" href="<?php echo $product_3->pcs_pageLink ?>" style="height:<?php echo $slide->imageHeight ?>px; background-image:url(<?php echo  $ih->getThumbnail($product_3->pcs_imageObject,450,$slide->imageHeight,$slide->imageCrop)->src ?>)">
				<?php if ($slide->productImageInfo) :
						// Here whe are loading the file to fix on image
						Loader::element('image_infos/' . $slide->productImageInfo, array(
							'product' => $product_3,'slide' => $slide,'ih' => $ih), 'product_creative_slider');
					endif?>
				</a>
				<?php 
				// Now we load the caption if asked
				if ($slide->productImageHoverCaption) :
					Loader::element('caption/' . $slide->productImageHoverCaption, array(
							'product' => $product_3,
							'slide' => $slide
							), 'product_creative_slider');
				endif?>		
			</div>			
		</td>
		<td>
			<div class="pcs_product_inner">
				<a class="pcs_image_link" href="<?php echo $product_4->pcs_pageLink ?>" style="height:<?php echo $slide->imageHeight ?>px; background-image:url(<?php echo  $ih->getThumbnail($product_4->pcs_imageObject,450,$slide->imageHeight,$slide->imageCrop)->src ?>)">
				<?php if ($slide->productImageInfo) :
						// Here whe are loading the file to fix on image
						Loader::element('image_infos/' . $slide->productImageInfo, array(
									'product' => $product_4,'slide' => $slide,'ih' => $ih), 'product_creative_slider');
					endif?>
				</a>
				<?php 
				// Now we load the caption if asked
				if ($slide->productImageHoverCaption) :
					Loader::element('caption/' . $slide->productImageHoverCaption, array(
							'product' => $product_4,
							'slide' => $slide
							), 'product_creative_slider');
				endif?>		
			</div>			
		</td>		
	</tr>
</table>

