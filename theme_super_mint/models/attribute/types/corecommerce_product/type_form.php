<?php  defined('C5_EXECUTE') or die("Access Denied.") ?>

<div class="clearfix">
	<label for="display_type" class="control-label"><?php echo t('Choose a display type for this key : ')?></label>
	<div class="input">
			<select name="display_type">
				<!--<option value="">-- Choose a Stack --</option>-->
				<?php  
				foreach($display_type_list as $handle=>$name){
					echo '<option value="' . $handle . '"';
					if ($handle == $display_type) {
						echo ' selected="selected" ';
					}
					echo '>' . $name . '</option>';
				}
				?>
			</select>
	</div>
</div>
