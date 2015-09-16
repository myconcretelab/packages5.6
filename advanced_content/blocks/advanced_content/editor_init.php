<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php  $th = $c->getCollectionThemeObject(); ?>
<?php  $this->inc('editor_config.php', array('theme' => $th)); ?> 
<?php  Loader::PackageElement('editor_controls', 'advanced_content'); ?>

