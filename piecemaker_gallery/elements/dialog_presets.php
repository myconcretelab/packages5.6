<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<form id="ajax_presets_form" name="ajax_presets_form" action="javascript:savePreset();">

<table width="100%" cellpadding="10">
	<tr>
		<td style="width:50%">
		    <?php print $int->button_js('New Preset', 'openFormPreset()', $buttonAlign=ÕrightÕ, $innerClass=null, $args = array()) ?>
		</td>
		<td>
		    <strong>Edit a Preset : </strong><select name="selectPID" id="preset_select_form" onchange="openFormPreset(this.value)" class="presets"><option value="0">Loading...</option></select>    
		</td>
	</tr>
</table>

<hr />

<div id="preset_form"></div>

</form>

<script type="text/javascript">refreshPresetsList ();</script>