<?php     defined('C5_EXECUTE') or die(_("Access Denied."))?>

<option value="0">--Choose Fileset--</option>
<?php      foreach ($fileSets as $fs): ?>
	<option value="<?php      echo $fs->fsID; ?>"><?php      echo htmlspecialchars($fs->fsName, ENT_QUOTES, 'UTF-8'); ?></option>
<?php      endforeach ?>
