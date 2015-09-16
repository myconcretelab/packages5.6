<?php      defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<link rel="stylesheet" href="<?php   echo $block_url?>/auto.css" />

<h2><span><?php      echo $fsID ? "Edit your Slider":"New Advanced Slide with default settings" ?></span></h2>
<hr />
<div id="accordion">
	<h3><a href="#">Filesets / animations settings</a></h3>
	<div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				   <td style="width:40%"><strong><?php      echo t('File Set') ?>:</strong></td>
				   <td><select id="fsID" name="fsID"><option value="0">Loading...</option></select></td>
			   </tr>
			   <tr>
			   	<td colspan="2">
				    <div id="ccm-file-infos-list">
					     						   
				    </div>

				</td>
			   </tr>
			   <tr>
				   <td>
					   <strong><?php       echo t('Transitions presets')?></label>
				   </td>
				   <td>
					   <?php      print $ah->button_js('Manage Transition Presets', 'openPresetDialog()', $buttonAlign=ÕleftÕ, $innerClass=null, $args = array()) ?>
				   </td>
			   </tr>
			   <tr>
			   	<td><strong>Set a global Transition Preset</strong></td>
			   	<td> <select name="globalImagePID" id="globalImagePID" class="presets" title="<?php      echo $globalImagePID ?>" ><option value="0">Loading...</option></select></td>
			   </tr>
		  </table>
	</div>
	 <h3><a href="#">Resizing</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
		  		<tr>
		  			<td colspan="2">
		  				<p>In order to make a slider responsive, you will need to set its 'width' and 'height' properties to percentage values, for example '100%'. When you set the width and height to '100%', it will make the slider adjust to fill its container entirely. Please note that sometimes the container of the slider has a height of 0px which will make the height of the slider to become 0px as well. So, in order to properly create a responsive slider, there are several solutions as set the 'scaleType' option to 'proportionalFit' or  If you want the height of the images to be automatically set based on the width, you can define an aspect ratio by using the 'aspectRatio' property. The default value is -1 which means that no ratio will be applied. Setting the property to 2 will make the width of the slider 2 times larger than the height</p>
		  			</td>
			   <tr>
				   <td style="width:40%">
					   <label for="">Gallery size <small>The size of the slider. Can be set in percentages if the '%' symbol is used or in pixels if only a number is used.</small></label><br /><br />			
				   </td>
				   <td>
					   <p>Width : <input type="text" value="<?php  echo $gallery_width ?>" id="gallery_width" name="gallery_width" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /></p>																																	
					   <br /><br />
					   <p>Height : <input type="text" value="<?php  echo $gallery_height ?>" id="gallery_height" name="gallery_height" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /></p>																																	
				   </td>
			   </tr>
			   <tr>
			   		<td>
			   			<label for="aspectRatio">Aspect Ratio <small>If Scale Type is set on 'no-scale' this option defines the ratio between the width and the height of the slider. A ratio of 2 will make the slider width 2 times larger than the height. The default value, -1, indicates that an aspect ratio will not be applied to the slider.</small></label><br /><br />
			   		</td>
			   		<td>
			   			<p>aspectRatio : <input type="text" value="<?php  echo $aspectRatio ?>" id="aspectRatio" name="aspectRatio" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /></p>	
			   		</td>
			   </tr>		   
			   <tr>
			   		<td>
			   			<label for="scaleType">scaleType <small> Indicates the scale type of the slide images.</small></label><br /><br />
			   		</td>
			   		<td>
			   			<?php  echo $form->select('scaleType', $this->controller->addKeyToArray(array('insideFit', 'outsideFit', 'proportionalFit', 'exactFit', 'noScale')),$scaleType)?>
			   		</td>
			   </tr>		   
			   <tr>
				   <td>
				   		<input type="checkbox" id="resize" name="options[]" value='resize' <?php      echo in_array('resize',$options) ? 'checked="checked"' : '' ?> />
				   		<label for="resize">Activate Picture Resizing ? <small>If yes, the picture will be resized to fit the gallery</small></label><br /><br />
				   		
					   <label for="">Resize image <small>This option helps you to recalculate the size of your images. They should, ideally, be close to the maximum size of your slider's container </small></label><br /><br />			
					   <input type="checkbox" id="crop" name="options[]" value='crop' <?php      echo in_array('crop',$options) ? 'checked="checked"' : '' ?> />	
					   <label for="crop">Activate Picture Croping ? <small>If yes, the picture will be croped</small></label><br /><br />						
					   						
				   </td>
				   <td>
					   <p>Width : <input type="text" id="width" name="width" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  /> px</p>									
					   <div id="range-width"></div>																									
					   <br /><br />
					   <p>Height : <input type="text" id="height" name="height" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  /> px</p>									
					   <div id="range-height"></div>																									
				   </td>
			   </tr>			   
		  </table>		  
	 </div>
	 <h3><a href="#">Global Options</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			<tr>
				<td><label for='skin'>Skin</label></td>
				<td><?php      echo $form->select('skin', $this->controller->addKeyToArray($this->controller->skins),$skin)?></td>
			</tr>
			<tr>
				<td><label for='scrollbarSkin'>Scrollbar Skin</label></td>
				<td><?php      echo $form->select('scrollbarSkin', $this->controller->addKeyToArray($this->controller->scrollbarSkins),$scrollbarSkin)?></td>
			</tr>
			   <tr>
				   <td style="width:40%">
					    <label class="label" for="slideshow">Slideshow</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="slideshow" name="options[]" value='slideshow' <?php      echo in_array('slideshow',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					   <label for="slideshowDelay">Slideshow Delay</label>
		   
				   </td>
				   <td>
					   <input type="text" id="slideshowDelay" name="slideshowDelay" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> mms
					   <div id="range-slideshowDelay"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="slideshowControls">slideshow Controls</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="slideshowControls" name="options[]" value="slideshowControls" <?php      echo in_array('slideshowControls',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="timerAnimation">Timer Animation</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="timerAnimation" name="options[]" value="timerAnimation" <?php      echo in_array('timerAnimation',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="shuffle">shuffle</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="shuffle" name="options[]" value="shuffle" <?php      echo in_array('shuffle',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="navigationArrows">Navigation Arrows</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="navigationArrows" name="options[]" value="navigationArrows" <?php      echo in_array('navigationArrows',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="hideNavigationArrows">Fade Navigation Arrows</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="hideNavigationArrows" name="options[]" value="hideNavigationArrows" <?php      echo in_array('hideNavigationArrows',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label for='navigationButtons'>Navigation Buttons</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="navigationButtons" name="options[]" value="navigationButtons" <?php      echo in_array('navigationButtons',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="navigationButtonsNumbers">Navigation Buttons Numbers</label>
				   </td>
				   <td>
					   <input type="checkbox" id="navigationButtonsNumbers" name="options[]" value="navigationButtonsNumbers" <?php      echo in_array('navigationButtonsNumbers',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="navigationButtonsCenter">Navigation Buttons Center</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="navigationButtonsCenter" name="options[]" value="navigationButtonsCenter" <?php      echo in_array('navigationButtonsCenter',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="shadow">Shadow</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="shadow" name="options[]" value="shadow" <?php      echo in_array('shadow',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			<tr>
				<td><label for='thumbnailType'>Thumbnails Type</label>
				    <small>Indicates the way in which the thumbnails will be displayed. If 'tooltip' is used the thumbnails will fade in on top of the navigation buttons when you roll over them. If 'scroller' is used the thumbnails will appear inside the thumbnail scroller. If 'none' is used the thumbnails will not be displayed.</small>				
				</td>
				<td><?php   echo $form->select('thumbnailsType', $this->controller->addKeyToArray($this->controller->thumbnailsTypes),$thumbnailsType)?></td>
			</tr>
			<tr>
				<td><label for='thumbnailOrientation'>Thumbnail Orientation</label>
				</td>
				<td><?php   echo $form->select('thumbnailOrientation', $this->controller->addKeyToArray($this->controller->thumbnailOrientations),$thumbnailOrientation)?></td>
			</tr>
			   <tr>
				   <td>
					    <label class="label" for="thumbnailScrollbar">thumbnail Scrollbar</label>			
				   </td>
				   <td>
					   <input type="checkbox" id="thumbnailScrollbar" name="options[]" value="thumbnailScrollbar" <?php      echo in_array('thumbnailScrollbar',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					    <label class="label" for="fadeThumbnailScrollbar">fade Thumbnail Scrollbar</label>
					    <small> indicates whether the thumbnail scrollbar will fade in/out on hover.</small>
				   </td>
				   <td>
					   <input type="checkbox" id="fadeThumbnailScrollbar" name="options[]" value="fadeThumbnailScrollbar" <?php      echo in_array('fadeThumbnailScrollbar',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					   <label for="slidesPreloaded">Slides Preloaded</label>
		   
				   </td>
				   <td>
					   <input type="text" id="slidesPreloaded" name="slidesPreloaded" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> mms
					   <div id="range-slidesPreloaded"></div>	
				   </td>
			   </tr>			   
			   <tr>
				   <td>
					    <label class="label" for="target_link">Target link</label>
					    <small>Tells the web browser where to open the link</small>
				   </td>
				   <td>
					<?php   echo $form->select('target_link', array(
										       '_self' => 'Same window',
										       '_blank' => 'New window'
										       ),$target_link) ?>
				</td>
			   </tr>
		  </table>		  
	 </div>
	 <h3><a href="#">Captions</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				   <td>
					   <label for="showCaption">Show Caption</label>
				   </td>
				   <td>
					   <input type="checkbox" id="showCaption" name="options[]" value="showCaption" <?php      echo in_array('showCaption',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>
			   <tr>
				   <td>
					   <label for="caption"><?php        echo t('Display as caption') ?>:</label>
				   
				   </td>
				   <td>
					   <select name="caption">
					   <optgroup label="Image attribute">
					       <option value="title"       <?php       echo ($caption == "title"?'selected':'')?>            >Title</option>
					       <option value="description" <?php       echo ($caption == "description"?'selected':'')?>      >Description (as Textile)</option>
					       <option value="date"        <?php       echo ($caption == "date"?'selected':'')?>             >Date Posted</option>
					       <option value="filename"    <?php       echo ($caption == "filename"?'selected':'')?>         >File Name</option>
					   </optgroup>
					   <optgroup label="Custom attribute">
					       <?php       
					       foreach($fileAttributes as $ak) :  ?>
						   <option value="<?php       echo $ak->getAttributeKeyHandle() ?>"
							   <?php       echo ($caption == $ak->getAttributeKeyHandle()?'selected':'')?> ><?php       echo  $ak->getAttributeKeyName() ?>
						   </option>
					       <?php        endforeach ?> 
					   </optgroup>
					   </select>
					   </div>		
				   </td>
			   </tr>
			   
		  </table>		  
	 </div>
</div>

<script>
var GET_FILESETS_URL = '<?php       echo $get_filesets_url; ?>';
var GET_PRESETS_DIALOG_URL = '<?php       echo $get_presets_dialog_tool; ?>';
var GET_PRESETS_FORM_URL = '<?php       echo $get_presets_form_tool; ?>';
var GET_PRESETS_SAVE_URL = '<?php       echo $save_presets_tool; ?>';
var GET_PRESETS_DELETE_URL = '<?php       echo $delete_presets_tool; ?>';
var GET_PRESETS_OPTIONS_URL = '<?php       echo $get_presets_options_tool; ?>';
var GET_IMAGES_OPTIONS_URL = '<?php       echo $get_images_options_tool; ?>';
var BLOCK_ID = '<?php       echo $this->controller->bID; ?>';


$(function() {       
 // $('input:checkbox').iphoneStyle({resizeHandle:false, resizeContainer:false });
	setjQuerySlider('width',50,2000,'<?php  echo $width ?>');
	setjQuerySlider('height',50,1000,'<?php  echo $height?>');
	setjQuerySlider('slideshowDelay',10,10000,'<?php      echo $slideshowDelay?>');
	setjQuerySlider('slidesPreloaded',0,10,'<?php      echo $slidesPreloaded?>',1,-2);


	$( "#accordion" ).accordion({autoHeight:false,collapsible: true});
 $('input').iToggle({
		easing: 'easeOutExpo',
		type: 'checkbox',
		keepLabel: true,
		speed: 300});
	
	refreshFilesetList(<?php       echo $fsID; ?>);
});
</script>