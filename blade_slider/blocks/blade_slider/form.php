<?php    defined('C5_EXECUTE') or die(_("Access Denied."));


?> 
<table>
   <tr>
	   <td>
	   		<label for="fsID">Fileset</label>
	   </td>
		<td>
			<select id="fsID" name="fsID"><option value="0">Loading...</option></select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="width">The width of the gallery</label>
		</td>
		<td>
			<input type="text" value="<?php echo $width; ?>" name="width" size="3" class="numeric"> <span>px</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="height">The Height of the gallery</label>
		</td>
		<td>
			<input type="text" value="<?php echo $height; ?>" name="height"  size="3" class="numeric"> <span>px</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="rows">The number of rows</label>
		</td>
		<td>
			<input type="text" value="<?php echo $rows; ?>" name="rows"  size="3" class="numeric"> <span>rows</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="cols">The number of columns</label>
		</td>
		<td>
			<input type="text" value="<?php echo $cols; ?>" name="cols"  size="3" class="numeric"> <span>columns</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="thumbSpacing">The "break apart" square padding </label>
		</td>
		<td>
			<input type="text" value="<?php echo $thumbSpacing; ?>" name="thumbSpacing"  size="3" class="numeric"> <span>px</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Choose to autoplay the banner</label>
		</td>
		<td>
			<input type="checkbox" value="autoPlay" name="options[]" <?php echo in_array('autoPlay', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="slideDelay">The delay between slide transitions in milliseconds if autopay is set to true</label>
		</td>
		<td>
			<input type="text" value="<?php echo $slideDelay; ?>" name="slideDelay"  size="3" class="numeric"> <span>ms</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Choose to randomize the slide order,</label>
		</td>
		<td>
			<input type="checkbox" value="randomizeSlides" name="options[]" <?php echo in_array('randomizeSlides', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Choose to use arrow buttons</label>
		</td>
		<td>
			<input type="checkbox" value="useArrows" name="options[]" <?php echo in_array('useArrows', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="arrowPadding">The padding for the arrow buttons in relation to the bottom right and bottom left corners of the banner</label>
		</td>
		<td>
			<input type="text" value="<?php echo $arrowPadding; ?>" name="arrowPadding"  size="3" class="numeric"> <span>px</span>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Display File title as title</label>
		</td>
		<td>
			<input type="checkbox" value="display_title" name="options[]" <?php echo in_array('display_title', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Display File description as description</label>
		</td>
		<td>
			<input type="checkbox" value="display_desc" name="options[]" <?php echo in_array('display_desc', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="options">Resize & crop image to fit the slider (recommended)</label>
		</td>
		<td>
			<input type="checkbox" value="resize" name="options[]" <?php echo in_array('resize', $options) ? 'checked' : '' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<label for="transitionType">The transition type</label>
		</td>
		<td>
			<?php echo $form->select('transitionType', array("whiteFlash"=>"white Flash",
														"basicFade"=>"basic Fade",
														"whiteFlashRandom"=>"white Flash Random", 
														"basicFadeRandom" => "basic Fade Random",
														"colorsRandom" => "colors Random"),
														$transitionType
														 ) ?>
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
</style>

<script type="text/javascript">
	var GET_FILESETS_URL = '<?php echo $get_filesets_url; ?>';
	refreshFilesetList(<?php echo $fsID; ?>);
</script>