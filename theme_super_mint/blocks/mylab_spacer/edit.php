<?php  
defined('C5_EXECUTE') or die("Access Denied.");
?>

<style>
table#SpacerSetup th {font-weight: bold; text-style: normal; padding-right: 8px; white-space: nowrap; vertical-align:top ; padding-bottom:8px}
table#SpacerSetup td{ font-size:12px; vertical-align:top; padding-bottom:8px;}
</style> 

<table id="SpacerSetup" style="width:100%"> 
	<tr>
		<td style="40%">
			<strong><?php  echo t('Spacer Height:')?></strong>
			<small><?php  echo t('Enter the height of the spacer. You can enter the units, or px will be used by default.')?></small>
		</td>
		<td>
			<input type="text" style="width:250px" name="spacerHeight" id="spacerHeight" value="<?php  echo  $spacerHeight ?>"/>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php  echo t('Spacer image:')?></strong>
		</td>
		<td>
			<select name="image" id="image">
				<?php foreach ($images as $file_name => $name) :?>
					<option value="<?php echo $file_name ?>" <?php echo $file_name == $image ? 'selected' : '' ?>><?php echo $name ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
</table>
