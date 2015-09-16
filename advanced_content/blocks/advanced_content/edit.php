<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$bt->inc('editor_init.php');
?>

<link rel="stylesheet" href="<?php  echo $block_url ?>/auto.css" />
<div style="text-align: center" id="ccm-editor-pane">
<textarea id="ccm-content-<?php echo $b->getBlockID()?>-<?php echo $a->getAreaID()?>" class="advancedEditor ccm-advanced-editor" name="content" style="width: 580px; height: 380px"><?php echo htmlspecialchars($controller->getContentEditMode())?></textarea>
</div>

<script type="text/javascript">
var GET_FORM = '<?php echo $form_url ?>';
</script>