<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
$al = Loader::helper('concrete/asset_library');
?>

<?php  echo $al->file('media_'.$_GET['ID'], 'media_'.$_GET['ID'], t('Choose File'));?> 