<?php  defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$pcsID = $bID . rand(); // This ID to avoid conflict when they are both same block on same page (scrapbook paste)
if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php echo t('Content disabled in edit mode.')?>
	</div>
</div>

<?php else : ?>
	<!-- <pre><?php print_r($specs) ?></pre> -->
	<div style="clear:both"></div><!-- Pour "nettoyer" les float sur Firefox sur le theme C5 de base  -->
	<div id="pcs_slider<?php echo $pcsID?>">
		<div class="pcs_slider" data-callback="pcsSlideronSliderLoad<?php echo $pcsID?>" data-pagercustom=".pager_<?php echo $pcsID ?>" data-mode="<?php echo $specs->mode ?>" data-auto="<?php echo $specs->diaporama ?>" data-pause="<?php echo $specs->pause ?>" <?php echo $specs->controls == 'disabled' ? 'data-controls="disabled"' : '' ?> <?php echo $specs->diaporamaControls == 'disabled' ? 'data-diapocontrols="disabled"' : '' ?> data-sxpagerposition="<?php echo $specs->pagerPosition ?>">
			<?php foreach ($slides as $k => $slide) : 			
			// First we create the pager into $pager
			if(count($slides) > 1) :
				ob_start();
			?>
			<div class="" style="height:15px"></div>
			<div class="pager_<?php echo $pcsID ?> pager_slide_<?php echo $k ?> pcs_pager pcs_pager_circle <?php echo $specs->pagerPosition ?>">
				<?php foreach ($slides as $n => $sl) : ?>
				<a data-slide-index="<?php echo $n ?>" href="#" <?php if($slide->overridePagerColor && !$specs->pagerPosition == 'under_slider') : ?>style="border-color:<?php echo $slide->pagerColor ?>;"<?php endif ?>><?php echo $n ?></a>
			<?php endforeach ?>
			</div>
			<div class="" style="height:15px"></div>

		<?php if($slide->overridePagerColor && !$specs->pagerPosition == 'under_slider') : ?><style>.pcs_pager.pager_slide_<?php echo $k ?> a.active {background-color:<?php echo $slide->pagerColorActive ?> !important;}</style><?php endif ?>
		<?php $pager = ob_get_clean();
		endif;
 		// End Pager getter
		?>
		
		
		<!-- The box for slide  <?php echo $k ?> -->
		<div class="pcs_container" >
			<?php 
	 	// We print the Rich content on left or right
			if($slide->lateralContentDisplay && $slide->richContent) : ?>
			<div class="pcs_<?php echo $slide->lateralContentDisplay ?>_sidebar pcs_sidebar" style="width:<?php echo $slide->contentWidth ?>%; background:<?php echo ($slide->contentBg ? $slide->contentBg : '') . ($slide->contentBgImg ? ' url(' . File::getByID($slide->contentBgImg)->getRelativePath() . ') ' : '' )?>">
				<div class="pcs_sidebar_padding">
					<!-- The Content -->
					<?php 
		 		// We print the content
					echo $this->controller->translateFrom($slide->richContent);
		 		// and if asked, the pager under
					if ($specs->pagerPosition == 'under_content') echo $pager;
					?>
					<!-- End of Content -->
				</div><!-- .pcs_sidebar_padding -->
			</div><!-- .pcs_left_sidebar -->
		<?php endif ?>
		<div class="pcs_main" style="<?php if ($slide->richContent && $slide->lateralContentDisplay ) : ?>margin-<?php echo $slide->lateralContentDisplay ?>:<?php echo $slide->contentWidth ?>%; width:<?php echo 100 - $slide->contentWidth ?>% <?php else : ?>width:100% <?php endif?>" >

			<?php 
		// Now we prepare all info about products 
		// that we made available for thumbnails displaying
			foreach ($slide->products as $key => $product) :
			// The image thumbnail
				$fileID = 'productImage_' . $product->getProductID();
			$product->pcs_imageObject = File::getByID($slide->$fileID);
			// The link to the product page
			$productPage = Page::getByID($product->getProductCollectionID());
			if ($productPage->cID>0) :
				$product->pcs_productPage = $productPage;
			$product->pcs_pageLink = $this->url($productPage->getCollectionPath());
			endif;

			//$attribs = $product->getProductConfigurableAttributes();			
			endforeach;
		// End product preparations

		// Here whe are loading a file like elements/structure/3_stack.php
			Loader::PackageElement('structure/' . $slide->structure[0] . '_' . $slide->structure[1], 'product_creative_slider', array(
				'infos' => $infos,
				'slide' => $slide,
				'ih' => $ih
				)) ?>
			</div> <!-- .pcs_main -->
			<div style="clear:both"></div>		
		</div> <!-- .pcs_container -->
	<?php endforeach ?>
</div><!-- .pcsslider -->
</div><!-- #pcs_slider<?php echo $pcsID?> -->
<?php
 // If the pager is asked under the slider
if ($specs->pagerPosition == 'under_slider') : ?>
<div class="pager_under_slider">
	<?php echo $pager ?> 	
</div>
<?php endif ?>



<style>
/* --- Dynamic styles --- */
.pcs_pager_circle.pager_<?php echo $pcsID ?> a {
	width:<?php echo $specs->controlsSize ?>px;
	height:<?php echo $specs->controlsSize ?>px;
	border-color:<?php echo $specs->pagerColor ?>;

}
.pcs_pager_circle.pager_<?php echo $pcsID ?> a.active {
	background-color:<?php echo $specs->pagerColorActive ?>;
}
#pcs_slider<?php echo $pcsID?>  .bx-wrapper .bx-controls-direction a,
#pcs_slider<?php echo $pcsID?>  .bx-wrapper .bx-controls-auto .bx-stop,
#pcs_slider<?php echo $pcsID?>  .bx-wrapper .bx-controls-auto .bx-start {
	background-color:<?php echo $specs->controlsColor ?>;
	color:<?php echo $specs->controlsSignColor ?> !important;
}
</style>



<script>

slider = "#pcs_slider<?php echo $pcsID?>"
if (typeof(pcsSlideronSliderLoad<?php echo $pcsID?>) === 'undefined' ) {
	var pcsSlideLoaded = true;
	pcsSlideronSliderLoad<?php echo $pcsID?>  = function () {
		<?php 
		// Je ne pige pas, o,n est plus ds un environement slide mais slider 
		// Donc on ne peut pas savoir si il faut declecher le script ou pas..
		// if ($slide->productImageHoverCaption && ! $slide->desactivateHoverDir) : ?>
		// This is the script to show full caption on hover
		$(slider + ' .pcs_product_inner').each( function() {
			$(this).hoverdir(); 
		});
		<?php// endif ?>
	}
}

</script>
<?php endif ?>
