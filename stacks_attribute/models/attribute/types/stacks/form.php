<?php  defined('C5_EXECUTE') or die("Access Denied.");
if (is_array($list)) : ?>

<select name="<?php echo $name ?>">
	<option value="">-- Choose a <?php echo $type ?> --</option>
	<?php  
	foreach($list as $b){
		echo '<option value="' . $b[$key] . '"';
		if ($b[$key] == $selected) {
			echo ' selected="selected" ';
		}
		echo '>' . $b[$value] . '</option>';
	}
	?>
</select>

<?php elseif (is_string($list)) : // They are a explained eror ?>
	<strong><?php echo $list?></strong>
<?php else : ?>
	<strong><?php echo ('They are a error') // Not explained error ?></strong>
<?php endif ?>