<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<input type="hidden" value= "<? echo $pID ?>" name="pID"/>
<table width="100%" cellpadding="5">
	<tr>
	    <td>
		<strong>Title</strong>
	    </td>
	    <td>
		<input type="text" value="<?php echo $title?>" name="title" id="preset_title" >
	    </td>
	</tr>
	<tr><td><strong>Pieces</strong><br /><small>Number of pieces to which the image is sliced</small></td>
	    <td><input type="text" id="Pieces" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> pieces
			<div id="range-Pieces"></div>	
	    </td>
	</tr>
	<tr><td><strong>Time</strong><br /><small>Time for one cube to turn</small></td>
	    <td><input type="text" id="Time" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> sec
	    <div id="range-Time"></div>	
	    </td>
	</tr>
	<tr><td><strong>Transition</strong><br /><small>Transition type of the Tweener class. The best results are achieved by those transition types, which begin with easeInOut</small></td>
		<td><?php echo $form->select('options[]', PiecemakerGalleryPresets::getTweenArray(),$advanced_options[2])?></td>

	</tr>
	<tr><td><strong>Delay</strong><br /><small>Delay between the start of one cube to the start of the next cube</small></td>
	    <td><input type="text" id="Delay" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> sec
			<div id="range-Delay"></div>	
	    </td>
	</tr>
	<tr><td><strong>DepthOffset</strong><br /><small>The offset during transition on the z-axis. Value between 100 and 1000 are recommended.</small></td>
	    <td><input type="text" id="DepthOffset" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> 
			<div id="range-DepthOffset"></div>	
	    </td>
	</tr>
	<tr><td><strong>CubeDistance</strong><br /><small>The distance between the cubes during transition. Values between 5 and 50 are recommended.</small></td>
	    <td><input type="text" id="CubeDistance" name="options[]" style="border:0; font-weight:bold; width:50px; background:#fafafa;" READONLY /> 
			<div id="range-CubeDistance"></div>	
	    </td>
	</tr>

</table>
<hr />

<input class="ccm-input-submit" id="preset_submit_form" type="submit" name="submit" value="<?php echo $statut?> Preset" style="display:none">
<?php print $in->button_js("$statut Preset", "$('#preset_submit_form').get(0).click()", $buttonAlign=ÕrightÕ, $innerClass=null, $args = array('style'=>'float:right')) ?>
<?php if ($statut == "Update") : ?>
<?php print $in->button_js('Delete Preset', "deletePreset(".$pID.")", $buttonAlign=ÕleftÕ, $innerClass=null, $args = array()) ?>
<?php endif ?>

<br /><br />

<script type="text/javascript">
    // $name,$min,$max,$value,$step,$Default_value
    setjQuerySlider('Pieces',1,18,'<? echo $advanced_options[0]?>',1);
    setjQuerySlider('Time',.1,5,'<? echo $advanced_options[1]?>',.1);
    setjQuerySlider('Delay',.1,5,'<? echo $advanced_options[3]?>',.1);
    setjQuerySlider('DepthOffset',100,1000,'<? echo $advanced_options[4]?>',10);
    setjQuerySlider('CubeDistance',5,50,'<? echo $advanced_options[5]?>',1);
</script>
<!--
[0] Pieces = "9"
[1] Time = "1.2"
[2] Transition = "easeInOutBack"
[3] Delay = "0.1"
[4] DepthOffset = "300"
[5] CubeDistance = "30"
-->