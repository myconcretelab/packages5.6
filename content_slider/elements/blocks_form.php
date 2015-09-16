<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<?php if (count($blocks)) : ?>
<table cellpadding="5" width="100%" class="ajax">
	<th style=="width:25%"><strong>Block Type</strong></th>
	<th style=="width:25%"><strong>Name (required)</strong></th>
	<th style=="width:25%"><strong>Description (optional)</strong></th>
	<th style=="width:25%"><strong>Image (optional)</strong></th>
	<?php foreach ($blocks as $k=>$b) : ?>
	<tr>
		<td>
			<?php echo $b->btHandle ?>
		</td>
		<td>
			<textarea name="blockTitle[]" class="blockTitle"><?php echo $blockTitle[$k] ?></textarea>
		</td>
		<td>
			<textarea name="blockDescription[]" class="blockTitle"><?php echo $blockDescription[$k] ?></textarea>
		</td>
		<td>
			<?php echo $al->file('file_'.$k, 'file_'.$k, t('Choose File'),File::getByID($files[$k]),$img) ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>

<?php else: ?>
<strong><?php t('No Blocks in these Stack')?></strong>
<?php endif ?>


