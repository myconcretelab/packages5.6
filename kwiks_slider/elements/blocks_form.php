<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php if (count($blocks)) : ?>
<input type="hidden" name="content_type" value="stacks" />
<table cellpadding="0" width="100%" class="ajax">
	<?php foreach ($blocks as $k=>$b) : ?>
	<tr>
		<td style="text-align:center">
			<img src="<?php echo $pckgUrl?>/images/block.png" alt="" />
		</td>
		<td>
			<strong><?php echo $b->btHandle ?></strong>
		</td>
	</tr>
	<?php endforeach ?>
</table>

<?php else: ?>
<strong><?php t('No Blocks in these Stack')?></strong>
<?php endif ?>


