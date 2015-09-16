<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));



?>


<div id="accordion">
	<h3>Basics</h3>
	<div style="padding:0em;">
	
		<table width="100%" cellpadding="10" >
		<tr>
			<td style="width:50%; padding:1.5em">
				<label for="fsID"><?php      echo t('File Set') ?>:</label>
			</td>	
			<td>
				<select name="fsID" title="fsID">
					<?php      foreach($s1 as $fs) {
					echo '<option value="'.$fs->getFileSetID().'" ' . ($fsID == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>n';
					  }?>
				</select>
			</td>
		</tr>
		<tr>
			<td style="width:50%; padding:1.5em">
				<label for="fsTitle"><?php      echo t('Display as Image title') ?>:</label>
			</td>
			<td>
				<select name="fsTitle"> 
				    <option value="title"       <?php     echo ($fsTitle == "title"?'selected':'')?>            >Title</option>
				    <option value="description" <?php     echo ($fsTitle == "description"?'selected':'')?>      >Description</option>
				    <option value="date"        <?php     echo ($fsTitle == "date"?'selected':'')?>             >Date Posted</option>
				    <option value="filename"    <?php     echo ($fsTitle == "filename"?'selected':'')?>         >File Name</option>
				    <?php     
				    foreach($fileAttributes as $ak) {  ?>
					<option value="<?php     echo $ak->getAttributeKeyHandle() ?>"
								<?php     echo ($fsTitle == $ak->getAttributeKeyHandle()?'selected':'')?> >         <?php     echo  $ak->getAttributeKeyName() ?>
					</option>
				    <?php      } ?> 
				</select>
			</td>
		</tr>
		<tr>
		
			<td style="width:50%; padding:1.5em;">
				<label for="fsDescription"><?php      echo t('Display as Image Description')?>:</label>
			</td>	
			<td>
				<select name="fsDescription" class="ccm-file-set-description">
				    <option value="title"       <?php     echo ($fsDescription == "title"?'selected':'')?>        >Title</option>
				    <option value="description" <?php     echo ($fsDescription == "description"?'selected':'')?>  >Description</option>
				    <option value="date"        <?php     echo ($fsDescription == "date"?'selected':'')?>         >Date Posted</option>
				    <option value="filename"    <?php     echo ($fsDescription == "filename"?'selected':'')?>     >File Name</option>
				    <?php     
				    foreach($fileAttributes as $ak) {  ?>
					<option value="<?php     echo $ak->getAttributeKeyHandle()?>"
					    <?php     echo ($fsDescription == $ak->getAttributeKeyHandle()?'selected':'')?>         ><?php     echo  $ak->getAttributeKeyName() ?>
					</option>
				    <?php      } ?> 
				</select>
		</td>
		</tr>
			<tr valign="top">
				<td style="width:50%;">	
					<label for="width"><?php      echo t('Width');?></label>
				</td>
				
				<td>
					<input type="text" id="width" name="width" size="4" value="<?php    echo $width?>" />&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="height"><?php      echo t('Height (0 for 16:9 ratio)');?></label>
				</td>
				<td>
					<input type="text" id="height" name="height" size="4" value="<?php    echo $height?>" />&nbsp;<small>px</small>
				</td>
			</tr>
		<tr>
			<td style="width:50%; padding:1.5em">
				<label for="thumbnails"><?php      echo t('Display Thumbnails');?></label>
			</td>
			<td>			
				<input type="radio" name="thumbnails" value="1"         <?php    echo $thumbnails == 1 ?'checked':''?>      />&nbsp;Yes, please&nbsp;
				<input type="radio" name="thumbnails" value="0"         <?php    echo $thumbnails == 0 ?'checked':''?>      />&nbsp;No, Thank you!
			</td>
		</tr>

	</table>	
		
	</div>
	<h3>Geeks options</h3>
	<div style="padding:0em;">
		<table cellpadding="10" width="100%">
		<tr>
			<td style="width:50%;">
				<label for="transition"><?php      echo t('Transition animation');?></label>
			</td>
			<td>			
				<select name="transition" class="ccm-input-select ccm-file-set-id">
					<option value="fade"    <?php     echo ($transition == "fade"?'selected':'')?>      >fade</option>
					<option value="flash"   <?php     echo ($transition == "flash"?'selected':'')?>     >flash</option>
					<option value="slide"   <?php     echo ($transition == "slide"?'selected':'')?>     >slide</option>
					<option value="fadeslide"<?php     echo ($transition == "fadeslide"?'selected':'')?>>fadeslide</option>
				</select>
			</td>				       
		</tr>
		<tr>
			<td>
				<label for="theme"><?php  echo t('Theme')?></label>
				<small><?php  echo t('Add your themes folders into root/blocks/mylab_galleria/themes')?></small>
			</td>
			<td>
				<?php  echo $form->select('theme', $themes, $theme, $tagAttributes) ?>
			</td>
		</tr>
		<tr valign="top">
				<td colspan="2">
	
					<?php     echo $colorh->output('myColor', 'Background Color', $myColor) ?>
				</td>
		</tr>
		<tr>
			<td>
				<label for="slideShow"><?php      echo t('Slideshow ?');?></label>
			</td>	
			<td>
				<input type="radio" name="slideShow" value="1"         <?php    echo $slideShow == 1 ?'checked':''?>      />&nbsp;Yes, please&nbsp;
				<input type="radio" name="slideShow" value="0"         <?php    echo $slideShow == 0 ?'checked':''?>      />&nbsp;No, Thank you!
			</td>
		</tr>
		<tr>
			<td>
				<label for="slideShowSpeed"><?php      echo t('Slideshow Speed (milliseconds)');?></label>
			</td>
			<td>
				<input type="text" id="slideShowSpeed" name="slideShowSpeed" size="4" value="<?php    echo $slideShowSpeed?>"/>
			</td>
		</tr>
			<tr>	
				<td>
					<label for="imageMargin"><?php      echo t('Image margin');?></label>
				</td>
				<td>
					<input type="text" id="imageMargin" name="imageMargin" size="4" value="<?php    echo $imageMargin?>"/>&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="thumbMargin"><?php      echo t('Thumbnail margin');?></label>
				</td>
				<td>
					<input type="text" id="thumbMargin" name="thumbMargin" size="4" value="<?php    echo $thumbMargin?>"/>&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="popupLinks"><?php      echo t('Open image in a new window');?></label>
				</td>
				<td>
					<input type="radio" name="popupLinks" value="1"         <?php    echo $popupLinks ==  1 ?'checked':''?>      />&nbsp;Yes, please&nbsp;
					<input type="radio" name="popupLinks" value="0"         <?php    echo $popupLinks ==  0 ?'checked':''?>      />&nbsp;No, Thank you!
				</td>
			</tr>
			<tr>
				<td>
					<label for="history"><?php      echo t('History for bookmarking, back-button etc');?></label>
				</td>
				<td>
					<input type="radio" name="history" value="1"         <?php    echo $history ==  1 ?'checked':''?>      />&nbsp;Yes, please&nbsp;
					<input type="radio" name="history" value="0"         <?php    echo $history ==  0 ?'checked':''?>      />&nbsp;No, Thank you!</td>
			</tr>
			<tr>
				<td>
					<label for="preload"><?php      echo t('Preload (number or "all")');?></label>
				</td>
				<td>
					<input type="text" id="preload" name="preload" size="4" value="<?php    echo $preload?>"/>&nbsp;<small>images</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="transitionSpeed"><?php      echo t('Transition speed');?></label>
				</td>
				<td>
					<input type="text" id="transitionSpeed" name="transitionSpeed" size="4" value="<?php    echo $transitionSpeed?>"/>&nbsp;<small>ms</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="maxScaleRatio"><?php      echo t('maximum scale ratio (1=100%)');?></label>
				</td>
				<td>
					<input type="text" id="maxScaleRatio" name="maxScaleRatio" size="4" value="<?php    echo $maxScaleRatio?>"/>&nbsp;<small></small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="carouselFollow"><?php      echo t(' Follow carousel');?></label>
				</td>
				<td><input type="radio" name="carouselFollow" value="1"    <?php    echo $carouselFollow == 1 ?'checked':''?>       />follow the active image
					<input type="radio" name="carouselFollow" value="0"    <?php    echo $carouselFollow == 0 ?'checked':''?>       />Don't follow</td>
			</tr>
			<tr>
				<td>
					<label for="carouselSpeed"><?php      echo t('Carousel speed (milliseconds)');?></label>
				</td>
				<td>
					<input type="text" id="carouselSpeed" name="carouselSpeed" size="4" value="<?php    echo $carouselSpeed?>"/>&nbsp;<small>ms</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="carouselSteps"><?php      echo t('Carousel steps (n or "auto")');?></label>
				</td>
				<td>
					<input type="text" id="carouselSteps" name="carouselSteps" size="4" value="<?php    echo $carouselSteps?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="imageCropPhp"><?php      echo t('Resize & Crop the picture');?></label>
					<small><?php  echo t('If enabled, the server will resize and crop your image to fit in you width/heigth settings. Usefull if you original picture are bigger than 1000px width ')?></small>
				</td>
				<td>
					<input type="radio" name="imageCropPhp" value="1" <?php    echo $imageCropPhp ==  1 ?'checked':''?> />&nbsp;Yes, please&nbsp;
					<input type="radio" name="imageCropPhp" value="0" <?php    echo $imageCropPhp ==  0 ?'checked':''?> />&nbsp;No, Thank you!
				</td>
			</tr>
			<tr>
				<td>
					<label for="imageCrop"><?php      echo t('Galleria Cropping');?></label>
					<small><?php  echo t('Defines how the main image will be cropped inside it\'s container.')?></small>
				</td>
				<td><input type="radio" name="imageCrop" value="1"          <?php    echo $imageCrop ==  1 ?'checked':''?>       />&nbsp;Yes, please&nbsp;
					<input type="radio" name="imageCrop" value="0"          <?php    echo $imageCrop ==  0 ?'checked':''?>       />&nbsp;No, Thank you!
					</td>
			</tr>
			<tr>
				<td>
					<label for="imagePan"><?php      echo t('Image Pan');?></label>
					
					<small><?php  echo t('Galleria comes with a built-in panning effect. The effect is sometimes useful if you have cropped images and want to let the users pan across the stage to see the entire image. Set to true to apply a mouse-controlled movement of the image to reveal the cropped parts. This effect is useful if you want to avoid dark areas around the image but still be able to view the entire image. (only work if "Resize & Crop the picture" is disabled <br /> If enabled the server disable the crop function')?></small>
				</td>
				<td><input type="radio" name="imagePan" value="1"          <?php    echo $imagePan ==  1 ?'checked':''?>       />&nbsp;Yes, please&nbsp;
					<input type="radio" name="imagePan" value="0"          <?php    echo $imagePan ==  0 ?'checked':''?>       />&nbsp;No, Thank you!
					</td>
			</tr>
			<tr>
				<td>
					<label for="lightbox"><?php      echo t('Lightbox');?></label>
					<small><?php  echo t('This option acts as a helper for attaching a lightbox when the user clicks on an image.')?></small>
				</td>
				<td>
					<input type="radio" name="lightbox" value="1" <?php    echo $lightbox ==  1 ?'checked':''?> />&nbsp;Yes, please&nbsp;
					<input type="radio" name="lightbox" value="0" <?php    echo $lightbox ==  0 ?'checked':''?> />&nbsp;No, Thank you!
				</td>
			</tr>
			<tr>
				<td>	
					<label for="lightboxWidth"><?php      echo t('Width of images in the lightbox');?></label>
					<small><?php  echo t('(let 0 if you want the same size as the gallery)')?></small>
				</td>
				
				<td>
					<input type="text" id="lightboxWidth" name="lightboxWidth" size="4" value="<?php    echo $lightboxWidth?>" />&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="lightboxHeight"><?php      echo t('Height of images in the lightbox');?></label>
					<small><?php  echo t('(let 0 if you want the same size as the gallery)')?></small>
				</td>
				<td>
					<input type="text" id="lightboxHeight" name="lightboxHeight" size="4" value="<?php    echo $lightboxHeight?>" />&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>	
					<label for="thumbWidth"><?php      echo t('Width of generated thumbs (croped)');?></label>
				</td>
				
				<td>
					<input type="text" id="thumbWidth" name="thumbWidth" size="4" value="<?php    echo $thumbWidth?>" />&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="thumbHeight"><?php      echo t('Height of generated thumbs (croped)');?></label>
				</td>
				<td>
					<input type="text" id="thumbHeight" name="thumbHeight" size="4" value="<?php    echo $thumbHeight?>" />&nbsp;<small>px</small>
				</td>
			</tr>
			<tr>
				<td>
					<label for="thumbCrop"><?php      echo t('Crop the Thumbnails');?></label>
				</td>
				<td><input type="radio" name="thumbCrop" value="1"          <?php    echo $thumbCrop ==  1 ?'checked':''?>      />&nbsp;Yes, please&nbsp;
					<input type="radio" name="thumbCrop" value="0"          <?php    echo $thumbCrop ==  0 ?'checked':''?>      />&nbsp;No, Thank you!
					</td>			
				</td>
			</tr>
		</table>
	
	</div>

</div><!-- end Accordion-->
<!-- Tab Setup -->
<style type="text/css">
	.ccm-ui label {
		width:auto;
		float:none;
		display:block;
		text-align: left;
	}
	small {
		font-size:10px !important;
		line-height:auto;
		color:#999;
	}
	.ccm-ui h3 {
		text-indent:30px;
	}
</style>

<script type="text/javascript">
	
	$(document).ready(function() { 
		$( "#accordion" ).accordion({autoHeight:false,collapsible: true});
	});
</script>
