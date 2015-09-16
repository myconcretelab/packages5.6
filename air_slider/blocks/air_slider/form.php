<?php    defined('C5_EXECUTE') or die(_("Access Denied."));


?> 
<table>
   <tr>
	   <td>
	   		<label for="fsID"><?php echo t('Fileset') ?></label>
	   </td>
		<td>
			<select id="fsID" name="fsID"><option value="0"><?php echo  t('Loading...')?></option></select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="gallery_width"><?php echo t('The width of the gallery (idealy the width of your website)')?></label>
		</td>
		<td>
			<input type="text" value="<?php echo $gallery_width; ?>" name="gallery_width" size="3" class="numeric"> <span><?php echo t('px')?></span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="gallery_height"><?php echo t('The Height of the gallery')?></label>
		</td>
		<td>
			<input type="text" value="<?php echo $gallery_height; ?>" name="gallery_height"  size="3" class="numeric"> <span><?php echo t('px')?></span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Choose to resize & crop image to fit into the gallery')?></label>
		</td>
		<td>
			<input type="checkbox" value="resize" name="options[]" <?php echo in_array('image_resize', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Choose to autoplay the banner')?></label>
		</td>
		<td>
			<input type="checkbox" value="autoPlay" name="options[]" <?php echo in_array('autoPlay', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="anim_duration"><?php echo t('The duration of the animation')?></label>
		</td>
		<td>
			<input type="text" value="<?php echo $anim_duration; ?>" name="anim_duration"  size="3" class="numeric"> <span><?php echo t('ms')?></span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="duration"><?php echo t('The delay between slide transitions in milliseconds if autopay is set to true')?></label>
		</td>
		<td>
			<input type="text" value="<?php echo $duration; ?>" name="duration"  size="3" class="numeric"> <span>ms</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Choose to randomize the slide order')?></label>
		</td>
		<td>
			<input type="checkbox" value="randomizeSlides" name="options[]" <?php echo in_array('randomizeSlides', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Choose to use arrow buttons')?></label>
		</td>
		<td>
			<input type="checkbox" value="useArrows" name="options[]" <?php echo in_array('useArrows', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Display arrow button inside the container')?><small><?php echo t('Useful if your container is not full with') ?></small></label>
		</td>
		<td>
			<input type="checkbox" value="arrowInside" name="options[]" <?php echo in_array('arrowInside', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Display File title as title')?></label>
		</td>
		<td>
			<input type="checkbox" value="display_title" name="options[]" <?php echo in_array('display_title', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options"><?php echo t('Display File description as description')?></label>
		</td>
		<td>
			<input type="checkbox" value="display_desc" name="options[]" <?php echo in_array('display_desc', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="default_link_text"><?php echo t('If the attribute "Link Url" is filled, a button will be displayed. Set the default text of the button')?><small><?php echo t('You can override this setting by adding text to the "Link Text" attribute of each file') ?></small></label>
		</td>
		<td>
			<input type="text" value="<?php echo $default_link_text; ?>" name="default_link_text"  size="15">
		</td>
	</tr>
	<tr>
		<td>
			<label for="easing"><?php echo t('The easing animation')?></label>
		</td>
		<td>
			<?php echo $form->select('easing', $controller->anim_easing , $easing ) ?>
		</td>
	</tr>
</table>

<style type="text/css">
	input[size="3"] {
		width: 30px;
	}
	input + span {
		color: #ccc;
		font-size: 12px;
	}
	#ccm-block-fields small {
		display: block;
		color: #ccc;
		font-size: 11px;
		line-height: 14px;

	}
</style>

<script type="text/javascript">
	var GET_FILESETS_URL = '<?php echo $get_filesets_url; ?>';
	refreshFilesetList(<?php echo $fsID; ?>);
</script>