<?php      defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<input type="hidden" value= "<?php      echo $pID ?>" name="pID"/>
<table width="100%" cellpadding="5">
	<tr>
		<td>
		    <strong>Title</strong>
		</td>
		<td>
		    <input type="text" value="<?php      echo $title?>" name="title" id="preset_title" >
		</td>
	</tr>
	<tr>
		<td style="width:50%"><strong>Effect Type</strong><br /><small>the type of the transition effect.</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->effectType),$advanced_options[0])?></td>
	</tr>
	<tr>
		<td><strong>Slice Pattern</strong><br /><small>The order in which the slices will be animated.</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->slicePattern),$advanced_options[1])?></td>
	</tr>
	<tr>
		<td><strong>Slice Point</strong><br /><small>Determines the starting point for the slice animation when the 'scale', 'width' or 'height' effects are used</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->slicePoint),$advanced_options[2])?></td>
	</tr>
	<tr>
		<td><strong>Slide Start Position</strong><br /><small>The starting position of the slice animation when the "slide" effect is used</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->slideStartPosition),$advanced_options[3])?></td>
	</tr>
	<tr>
		<td><strong>Caption Show Effect</strong></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->captionShowEffect),$advanced_options[4])?></td>
	</tr>
	
	<!-- Numeric -->
	
	<tr><td><strong>sliceDelay</strong><br /><small>the delay between each slice animatio</small></td>
	    <td><input type="text" id="sliceDelay" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> mms
			<div id="range-sliceDelay"></div>	
	    </td>
	</tr>
	<tr><td><strong>sliceDuration</strong><br /><small>the duration for each slice animation</small></td>
	    <td><input type="text" id="sliceDuration" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> mms
			<div id="range-sliceDuration"></div>	
	    </td>
	</tr>
	<tr><td><strong>horizontalSlices</strong></td>
	    <td><input type="text" id="horizontalSlices" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> slices
			<div id="range-horizontalSlices"></div>	
	    </td>
	</tr>
	<tr><td><strong>verticalSlices</strong></td>
	    <td><input type="text" id="verticalSlices" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> slices
			<div id="range-verticalSlices"></div>	
	    </td>
	</tr>
	<tr><td><strong>slideStartRatio</strong><br /><small>sets the actual distance between the starting and ending point for the 'slide' animation. The actual distance will be determined by multiplying the slice's width/height to the 'slideStartRatio' property</small></td>
	    <td><input type="text" id="slideStartRatio" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY />
			<div id="range-slideStartRatio"></div>	
	    </td>
	</tr>
	<tr><td><strong>slideshowDelay</strong></td>
	    <td><input type="text" id="slideDelay" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> mms
			<div id="range-slideDelay"></div>	
	    </td>
	</tr>
	<tr><td><strong>Caption Position</strong>
	<br /><small>(if enabled)</small></td>
	    <td>
		<select name="options[]" id="captionPosition">
		    <option value="bottom"	<?php         echo $advanced_options[11] == 'bottom'  ? 'selected' :''?> >Bottom</option>
		    <option value="top"		<?php         echo $advanced_options[11] == 'top'  ? 'selected' :''?> >Top</option>
		    <option value="left"	<?php         echo $advanced_options[11] == 'left'  ? 'selected' :''?> >Left</option>
		    <option value="right"	<?php         echo $advanced_options[11] == 'right'  ? 'selected' :''?>>Right</option>
		    <option value="default"	<?php         echo $advanced_options[11] == 'default'  ? 'selected' :''?>>default</option>
		</select>
	    </td>
	</tr>
	<tr>
		<td><strong>Slide Direction</strong><br /><small>Sets the direction of the slides when the "slide" effect is used</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->slideDirection),$advanced_options[12])?></td>
	</tr>	
	<tr>
		<td><strong>Slice Effect Type</strong><br /><small>Sets the effect type for the "slice" transition when the "slice" effect is used</small></td>
		<td><?php      echo $form->select('options[]', $as->controller->addKeyToArray($as->controller->sliceEffectType),$advanced_options[13])?></td>
	</tr>	
	<tr>
	    <td>
		<strong>sliceFade</strong><br /><small>will set the opacity of the slices to 0 and fade them in during the animation</small>
	    </td>
	    <td>
		<input type="checkbox" value="sliceFade" name="options[]" <?php      echo in_array('sliceFade', $advanced_options) ? 'checked' : '' ?> />
	    </td>
	</tr>
	<tr>
	    <td>
		<strong>slideMask</strong><br /><small>indicates whether or not the slide will have overflow hidden during the transition</small>
	    </td>
	    <td>
		<input type="checkbox" value="slideMask" name="options[]" <?php      echo in_array('slideMask', $advanced_options) ? 'checked' : '' ?>/>
	    </td>
	</tr>
</table>
<hr />

<input class="ccm-input-submit" id="preset_submit_form" type="submit" name="submit" value="<?php      echo $statut?> Preset" style="display:none">
<?php      print $in->button_js("$statut Preset", "$('#preset_submit_form').get(0).click()", $buttonAlign=ÕrightÕ, $innerClass=null, $args = array('style'=>'float:right')) ?>
<?php      if ($statut == "Update") : ?>
<?php      print $in->button_js('Delete Preset', "deletePreset(".$pID.")", $buttonAlign=ÕleftÕ, $innerClass=null, $args = array()) ?>
<?php      endif ?>
<br /><br />
<script type="text/javascript">
    // $name,$min,$max,$value,$step,$Default_value
    setjQuerySlider('sliceDelay',-1,300,'<?php      echo $advanced_options[5]?>',1,-1);
    setjQuerySlider('sliceDuration',-10,3000,'<?php      echo $advanced_options[6]?>',10,-10);
    setjQuerySlider('horizontalSlices',0,15,'<?php      echo $advanced_options[7]?>',1,0);
    setjQuerySlider('verticalSlices',0,15,'<?php      echo $advanced_options[8]?>',1,0);
    setjQuerySlider('slideStartRatio',-0.1,3,<?php      echo $advanced_options[9]?>,0.1,-0.1);
    setjQuerySlider('slideDelay',0,10000,'<?php      echo $advanced_options[10]?>',10,0);
</script>