<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<option value="0">--Choose a Preset--</option>
<?php  foreach ($presets as $p): ?>
	<option value="<?php  echo $p['effectPresetID'] ?>"><?php echo $p['title'] ?></option>
<?php  endforeach ?>

