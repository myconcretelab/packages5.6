<?php     defined('C5_EXECUTE') or die(_("Access Denied."));

$check = $controller->isViewError($this->area);
if (!$check) :
	global $c;
	$CollectionVersionAreaLayout = $controller->getCollectionVersionAreaLayout ($c->cID, $c->vObj->getVersionID(), $this->area->getAreaHandle());
	?>
	
	<?php  global $c; if (!$c->isEditMode()) : ?>

<div id="easyMSTabs-script_<?php echo $bID ?>">
	<script>
	
	function displayTab(index) {
		var $ref=[];
		$('.ccm-layout-wrapper').each(function () {
			if ( $(this).find('.tabs_nav').length)  $ref = $(this);
		});
		$('.tab_header_item', $ref).eq(index-1).find('a').click();
	}
	//alert(" SKIN_RELATIVE_PATH = '<?php  echo $block_url ?>/templates/multi_skins/'; SKIN = '<?php  echo $mst_skin?>'; var EFFECT = '<?php  echo $mst_effect?>';var POSITION = '<?php  echo $mst_position?>';");

	$(document).ready(function() {
		$('#ccm-layout-wrapper-<?php echo $CollectionVersionAreaLayout['cvalID']?>').easyMSTabs({
			titles:[<?php  foreach ($data as $k=>$n) : ?> "<?php echo $n['name']?>"<?php echo $dl == $k ? '' : ','?><?php  endforeach ?>],
			images:[<?php  foreach ($data as $k=>$n) : ?> <?php echo ($n['src']) ? "'" . $n['src'] . "'" : '0' ?><?php echo $dl == $k ? '' : ','?><?php  endforeach ?>],
			skin_relative_path : '<?php  echo $block_url ?>/templates/multi_skins/',
			skin : '<?php  echo $mst_skin?>',
			effect : '<?php  echo $mst_effect?>',
			position : '<?php  echo $mst_position?>',
			bID : <?php echo $bID ?>
			});
	});
	</script>
	
</div>
	
	<?php  else : // edit mode ?>
	
	<div class="ccm-edit-mode-disabled-item" style="height:80px">
		<div style="padding: 20px 0px 0px 0px">
			<?php   echo t('Content disabled in edit mode.')?>
			<br>
			<?php  foreach ($data as $k=>$n) : ?>
				<span> <?php echo $n['name']?> |</span>
			<?php  endforeach ?>
	</div>
	</div>
	
	<?php  endif ?>

<?php  else : // view check ?>

<!-- there are something wrong, let explain -->
<div class="ccm-edit-mode-disabled-item" style="height:50px">
	<div style="padding: 20px 0px 0px 0px">
		<?php echo $check?>
</div>
</div>

<?php  endif ?>

