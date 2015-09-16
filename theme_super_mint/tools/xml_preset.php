<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); 

if (!$_GET['pid']) die;

$th = Loader::helper('text');
Loader::model('theme_super_mint_options', 'theme_super_mint');
$t = new ThemeSuperMintOptions();
$xmlDOM =$t->getXML_from_pid($_GET['pid']);

header ("Content-Type:text/xml");
header('Content-Disposition: attachment; filename="' .  $th->sanitizeFileSystem($t->get_preset_title($_GET['pid'])) . '.mcl"');

echo $xmlDOM;
