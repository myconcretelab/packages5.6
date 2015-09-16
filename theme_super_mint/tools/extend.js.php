<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

header("Content-type: text/javascript");

$js = DIR_BASE . '/' . DIRNAME_JAVASCRIPT . '/supermint.js';

if (is_file($js)) {
	echo t("// extend.js\n\n\n");
	include($js);	
}  else {
	echo t('// -- They are no js extend for Theme supermint -- //');
}
