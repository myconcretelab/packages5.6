<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

$check = $controller->isViewError($this->area);
if (!$check) :
global $c;

$data = $controller->getTabsArray();
$CollectionVersionAreaLayout = $controller->getCollectionVersionAreaLayout ($c->cID, $c->vObj->getVersionID(), $this->area->getAreaHandle());
$dl = count($data)-1;
?>

<?php   global $c; if (!$c->isEditMode()) : ?>
<script>
$(document).ready(function() {
	$('#ccm-layout-wrapper-<?php  echo $CollectionVersionAreaLayout['cvalID']?>').easyAccordion({
		titles:[<?php   foreach ($data as $k=>$n) : ?> "<?php  echo $n['name']?>"<?php  echo $dl == $k ? '' : ','?><?php   endforeach ?>],
		disabled:[<?php  echo $disabled?>],
		open:<?php  echo $open?>,
		classes:'<?php  echo $classes ?>'		
		});	
});
</script>

<?php   else : // edit mode ?>

<div class="ccm-edit-mode-disabled-item" style="height:80px">
	<div style="padding: 20px 0px 0px 0px">
		<?php    echo t('Content disabled in edit mode.')?>
		<br>
		<?php   foreach ($data as $k=>$n) : ?>
			<span> <?php  echo $n['name']?> |</span>
		<?php   endforeach ?>
</div>
</div>

<?php   endif ?>
<?php   else : // view check ?>

<!-- there are something wrong, let explain -->
<div class="ccm-edit-mode-disabled-item" style="height:50px">
	<div style="padding: 20px 0px 0px 0px">
		<?php  echo $check?>
</div>
</div>

<?php   endif ?>

