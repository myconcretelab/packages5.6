<table class="entry-form" cellspacing="1" cellpadding="0" style="width:50%">
<tr>
	<td class="subheader"><?php  echo t('Define the type of list you want to have')?></td>
</tr>
<tr>
	<td>
		<input name="display_type" id="stacks_list" type="radio" value="stacks_list" <?php if ($display_type == 'stacks_list') echo 'checked'?>  />
		<strong><?php echo t('List all available stacks')?></strong>
	</td>
</tr>
<tr>
	<td>
		<input name="display_type" id="stacks_list_global" type="radio" value="stacks_list_global" <?php if ($display_type == 'stacks_list_global') echo 'checked'?>  />
		<strong><?php echo t('List all Globals stacks')?></strong>
	</td>
</tr>
<tr>
	<td>
		<input name="display_type" id="stacks_list_user" type="radio" value="stacks_list_user" <?php if ($display_type == 'stacks_list_user') echo 'checked'?>  />
		<strong><?php echo t('List all User added stacks')?></strong>
	</td>
</tr>
<tr>
	<td>
		<input name="display_type" id="item_list" type="radio" value="item_list" <?php if ($display_type == 'item_list') echo 'checked'?> />
		<strong><?php echo t('List items from this stacks : ')?></strong>
		<select name="display_stacks">
			<!--<option value="">-- Choose a Stack --</option>-->
			<?php  
			foreach($availableStacks as $availableStack){
				echo '<option value="' . $availableStack['stID'] . '"';
				if ($availableStack['stID'] == $display_stacks) {
					echo ' selected="selected" ';
				}
				echo '>' . $availableStack['name'] . '</option>';
			}
			?>
		</select>
		
	</td>
</tr>
</tr>
</table>