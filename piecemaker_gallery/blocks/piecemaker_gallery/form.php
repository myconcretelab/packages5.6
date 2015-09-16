<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div id="accordion">
	<h3><a href="#">Filesets / Links settings</a></h3>
	<div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				    <td style="width:60%"><strong><?php echo t('File Set') ?>:</strong></td>
				    <td><select id="fsID" name="fsID"><option value="0">Loading...</option></select></td>
			   </tr>
			   <tr>
			   	<td colspan="2"><div id="ccm-file-infos-list"></div></td>
			   </tr>
		  </table>
	</div>
	 <h3><a href="#">Transitions Settings</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				    <td><strong><?php  echo t('Transitions presets')?></label></td>
				    <td>
					   <?php print $ah->button_js('Manage Transition Presets', 'openPresetDialog()', $buttonAlign=’left’, $innerClass=null, $args = array()) ?>
				    </td>
			   </tr>
			   <tr>
				   <td>
					   <?php print $ah->button_js('Add a Transition', 'addAnimationType()', $buttonAlign=’left’, $innerClass=null, $args = array()) ?>
					   <br /><br /><small>You can add as many transitions to the Piecemaker as you want. These transitions will be started in the order they are specified here. This order is entirely independent from the order of contents. Once the last transition is reached, it starts over again with the first transition.</small>
				   </td>
				   <td>
					   <div id="array_types">
						   <?php foreach ($transitions as $t) : ?>
						   <div class="type">
						      <select name="transitions[]" title="<?php echo $t?>" class="presets" ><option value="0" class="presets" title=>Loading..</option></select>
						      <a href="#" onclick="removeAnimationType($(this))">Remove</a>
						   </div>
						   <?php endforeach ?>
					   </div>
				   </td>
			   </tr>
		  </table>
	</div>
	 <h3><a href="#">Resizing</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				   <td style="width:60%">
					   <label for="resize">Activate Picture Resizing ? <small>If yes, the picture will be resized to fit the gallery</small></label><br /><br />						
				   </td>
				   <td>
					   <input type="checkbox" id="resize" name="active_resize" value='resize' <?php echo $active_resize == 'resize' ? 'checked="checked"' : '' ?> />							
			   </tr>
			   <tr>
				   <td>
					   <label for="">Gallery size <small>No compromises here, the size of the gallery should be fixed <br />This value are automatically recalculated each time you pick a fileset</small></label><br /><br />			
				   </td>
				   <td>
					   Width :<input type="text" id="width" name="width" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly" /> px									
					   <div id="range-width"></div>																									
					   <br /><br />
					   Height :<input type="text" id="height" name="height" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> px									
					   <div id="range-height"></div>																									
				   </td>
			   </tr>			   
			   <tr>
				   <td>
					   <strong>Additional width / height </strong><br /><small>The gallery is built in flash. So any animation beyond the confines of the gallery will be cut. These settings can enlarge part of the gallery. Adjust according to your animation</small>			
				   </td>
				   <td>
					   Additional Width :<input type="text" id="awidth" name="awidth" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly" /> px									
					   <div id="range-awidth"></div>																									
					   <br /><br />
					   Additional Height :<input type="text" id="aheight" name="aheight" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> px									
					   <div id="range-aheight"></div>																									
				   </td>
			   </tr>			   
		  </table>		  
	 </div>
	 <h3><a href="#">Global Options</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				    <td style="width:60%"><strong>Autoplay</strong><br /><small>Number of seconds from one transition to another, if not stopped. Set to 0 to disable autoplay</small></td>
				    <td>
					   <input type="text" id="Autoplay" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> sec
					   <div id="range-Autoplay"></div>	
				    </td>
			   </tr>
			   <tr>
				   <td><strong>Loader Color</strong><br /><small>Color of the cubes before the first image appears, also the color of the back sides of the cube, which become visible at some transition types</small></td>
				   <td><?php echo $colorh->output('options_1', '', '#'.$options[1], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td><strong>Drop Shadow Alpha</strong><br /><small>Alpha of the drop shadow - 0 == no shadow, 1 == opaque</small></td>
				   <td>
					   <input type="text" id="DropShadowAlpha" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-DropShadowAlpha"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Drop Shadow Distance</strong><br /><small>Distance of the shadow from the bottom of the image</small></td>
				   <td>
					   <input type="text" id="DropShadowDistance" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-DropShadowDistance"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Drop Shadow Scale</strong><br /><small>As the shadow is blurred, it appears wider that the actual image, when not resized. Thus it‘s a good idea to make it slightly smaller. - 1 would be no resizing at all.</small></td>
				   <td>
					   <input type="text" id="DropShadowScale" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-DropShadowScale"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Menu Distance X</strong><br /><small>Distance between two menu items (from center to center)</small></td>
				   <td>
					   <input type="text" id="MenuDistanceX" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-MenuDistanceX"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Menu Distance Y</strong><br /><small>Distance of the menu from the bottom of the image</small></td>
				   <td>
					   <input type="text" id="MenuDistanceY" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-MenuDistanceY"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>Menu Color 1</strong><br /><small>Color of an inactive menu item</small></td>
				   <td><?php echo $colorh->output('options_7', '', '#'.$options[7], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>Menu Color 2</strong><br /><small>Color of an active menu item</small></td>
				   <td><?php echo $colorh->output('options_8', '', '#'.$options[8], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>Menu Color 3</strong><br /><small>Color of the inner circle of an active menu item. Should equal the background color of the whole thing.</small></td>
				   <td><?php echo $colorh->output('options_9', '', '#'.$options[9], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td><strong>Control Size</strong><br /><small>ize of the controls, which appear on rollover (play, stop, info, link)</small></td>
				   <td>
					   <input type="text" id="ControlSize" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-ControlSize"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Control Distance</strong><br /><small>Distance between the controls (from the borders)</small></td>
				   <td>
					   <input type="text" id="ControlDistance" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-ControlDistance"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>ControlColor1</strong><br /><small>Background color of the controls</small></td>
				   <td><?php echo $colorh->output('options_12', '', '#'.$options[12], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>ControlColor2</strong><br /><small>Font color of the controls</small></td>
				   <td><?php echo $colorh->output('options_13', '', '#'.$options[13], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td><strong>Controls Y</strong><br /><small>Y-position of the point, which aligns the controls (measured from [0,0] of the image)</small></td>
				   <td>
					   <input type="text" id="ControlsY" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-ControlsY"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td><strong>Tooltip Height</strong><br /><small>Height of the tooltip surface in the menu</small></td>
				   <td>
					   <input type="text" id="TooltipHeight" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-TooltipHeight"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>TooltipColor</strong><br /><small>Color of the tooltip surface in the menu</small></td>
				   <td><?php echo $colorh->output('options_16', '', '#'.$options[16], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>TooltipTextColor</strong><br /><small>Color of the tooltip text</small></td>
				   <td><?php echo $colorh->output('options_17', '', '#'.$options[17], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
			   <tr>
				   <td><strong>InfoWidth</strong><br /><small>The width of the info text field</small></td>
				   <td>
					   <input type="text" id="InfoWidth" name="options[]" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly"/> px
					   <div id="range-InfoWidth"></div>	
				   </td>
			   </tr>
			   <tr>
				   <td style="width:40%"><strong>InfoBackground</strong><br /><small>The background color of the info text field</small></td>
				   <td><?php echo $colorh->output('options_19', '', '#'.$options[19], true) ?><input type="hidden" value="color" name="options[]" /></td>
			   </tr>
		  </table>		  
	 </div>
	 <h3><a href="#">Images HTML Infos</a></h3>
	 <div>
		  <table cellpadding="15" class="ads_edit" width="100%" >
			   <tr>
				   <td style="width:60%">
					   <strong>Show Image description as Info <br /><small>If enabled, the gallery will use image description with <a href="http://www.textism.com/tools/textile/">Textile formating</a></small></strong>
				   </td>
				   <td>
					   <input type="checkbox" id="showCaption" name="options[]" value="showCaption" <?php echo in_array('showCaption',$options) ? 'checked="checked"' : '' ?> />			
				   </td>
			   </tr>			   
		  </table>		  
	 </div>
</div>

<script type="text/javascript">

	 var GET_FILESETS_URL = '<?php  echo $get_filesets_url; ?>';
	 var GET_PRESETS_DIALOG_URL = '<?php  echo $get_presets_dialog_tool; ?>';
	 var GET_PRESETS_FORM_URL = '<?php  echo $get_presets_form_tool; ?>';
	 var GET_PRESETS_SAVE_URL = '<?php  echo $save_presets_tool; ?>';
	 var GET_PRESETS_DELETE_URL = '<?php  echo $delete_presets_tool; ?>';
	 var GET_PRESETS_OPTIONS_URL = '<?php  echo $get_presets_options_tool; ?>';
	 var GET_IMAGES_OPTIONS_URL = '<?php  echo $get_images_options_tool; ?>';
	 var BLOCK_ID = '<?php  echo $this->controller->bID; ?>';
	 
	 setjQuerySlider('width',50,2000,<? echo $width ?>);
	 setjQuerySlider('height',50,1000,<? echo $height?>);
	 setjQuerySlider('awidth',0,200,<? echo isset($awidth) ? $awidth : 80 ?>);
	 setjQuerySlider('aheight',0,200,<? echo isset($aheight ) ? $aheight : 50 ?>);
	 setjQuerySlider('Autoplay',0,20,<? echo $options[0]?>,.1);
	 setjQuerySlider('DropShadowAlpha',0,1,<? echo $options[2]?>,.1);
	 setjQuerySlider('DropShadowDistance',0,100,<? echo $options[3]?>);
	 setjQuerySlider('DropShadowScale',0,1,<? echo $options[4]?>,.1);
	 setjQuerySlider('MenuDistanceX',0,200,<? echo $options[5]?>);
	 setjQuerySlider('MenuDistanceY',0,2000,<? echo $options[6]?>);
	 setjQuerySlider('ControlSize',0,200,<? echo $options[10]?>);
	 setjQuerySlider('ControlDistance',0,1000,<? echo $options[11]?>);
	 setjQuerySlider('ControlsY',0,1000,<? echo $options[11]?>);
	 setjQuerySlider('TooltipHeight',0,150,<? echo $options[15]?>);
	 setjQuerySlider('InfoWidth',0,1000,<? echo $options[18]?>);
	 
	 refreshFilesetList('<?php  echo $fsID; ?>');
	 refreshPresetsList ();
	 
	 $(document).ready(function() {        
		  $(':checkbox').iToggle();
		  $( "#accordion" ).accordion({autoHeight:false,collapsible: true});
	 });
	 
</script>

<!--

[0] Autoplay = "10"
	- Number of seconds from one transition to another, if not stopped. Set to 0 to disable autoplay
[1] LoaderColor = "0x333333"
	Color of the cubes before the first image appears, also the color of the back sides of the cube, which become visible at some transition types
[2] DropShadowAlpha = "0.7"
	- Alpha of the drop shadow - 0 == no shadow, 1 == opaque
[3] DropShadowDistance = "25"
	- Distance of the shadow from the bottom of the image
[4] DropShadowScale = "0.95"
	- As the shadow is blurred, it appears wider that the actual image, when not resized. Thus it‘s a good idea to make it slightly smaller. - 1 would be no resizing at all.
[5] MenuDistanceX = "20"
	- Distance between two menu items (from center to center)
[6] MenuDistanceY = "50"
	- Distance of the menu from the bottom of the image
[7] MenuColor1 = "0x999999"
	- Color of an inactive menu item
[8] MenuColor2 = "0x333333"
	- Color of an active menu item
[9] MenuColor3 = "0xFFFFFF"
	- Color of the inner circle of an active menu item. Should equal the background color of the whole thing.
[10] ControlSize = "100"
	- Size of the controls, which appear on rollover (play, stop, info, link)
[11] ControlDistance = "20"
	- Distance between the controls (from the borders)
[12] ControlColor1 = "0x222222"
	- Background color of the controls
[13] ControlColor2 = "0xFFFFFF"
	- Font color of the controls
[14] ControlsY = "280"
	- Y-position of the point, which aligns the controls (measured from [0,0] of the image)
[15] TooltipHeight = "31"
	- Height of the tooltip surface in the menu
[16] TooltipColor = "0x222222"
	- Color of the tooltip surface in the menu
[17] TooltipTextColor = "0xFFFFFF"
	- Color of the tooltip text
[18] InfoWidth = "400"
	- The width of the info text field
[19] InfoBackground = "0xFFFFFF"
	- The background color of the info text field
-->