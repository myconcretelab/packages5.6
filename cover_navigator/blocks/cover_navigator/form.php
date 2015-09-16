<?php    defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<div id="cover-navigator-form">
	<?php foreach ($cat_fileset as $fsID=>$fsname): ?>
		<div class="checkbox">
			<label for="fs_<?php echo $fsID?>"><?php echo $fsname?></label>
			<input type="checkbox" value="<?php echo $fsID?>" id="fs_<?php echo $fsID?>" name="selected_fileset[]" <?php echo in_array($fsID, $selected_fileset) ? 'checked' : ''?> />			
		</div>
	<?php endforeach ?>
	<hr />
	<strong>Display settings</strong><br />
	<table>
		<tr>
			<td>
				<label for="view_type">Gallery</label>	
			</td>
			<td>
				<input type="radio" value="gallery" name="view_type" <?php echo $view_type == 'gallery' ? 'checked' : ''?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="view_type">Inline</label>
			</td>
			<td>
				<input type="radio" value="inline" name="view_type" <?php echo $view_type =='inline' ? 'checked' : ''?> />	
			</td>
		</tr>
		<tr>
			<td>
				<label for="view_type">FancyBox</label>
			</td>
			<td>
				<input type="radio" value="fancy" name="view_type" <?php echo $view_type == 'fancy' ? 'checked' : ''?> />
			</td>
		</tr>
	</table>
	
				
	
			
	
				
	
</div>

<style type="text/css">
	.checkbox{
		padding:10px;
		border-bottom:1px solid #ccc;
	}
	label {
		float:left;
		width:200px;
	}
</style>