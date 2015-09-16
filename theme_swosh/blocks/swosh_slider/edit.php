<?php  defined('C5_EXECUTE') or die("Access Denied.");
Loader::model('file_set');
$fileSets = FileSet::getMySets();
?>
<style>.padding tr td {padding: 10px}</style>

<table class="padding">
	<tr>
		<td>
			<label for="fsID">Choose a fileset</label>
		</td>
		<td>
			<select name='fsID'>
			<option value="0">--Choose Fileset--</option>
			<?php     foreach ($fileSets as $fs): ?>
				<option value="<?php echo $fs->fsID; ?>" <?php  if ($fs->fsID == $fsID) echo 'selected' ?>><?php echo htmlspecialchars($fs->fsName, ENT_QUOTES, 'UTF-8'); ?></option>
			<?php     endforeach ?>
			</select>			
		</td>
	</tr>
	<tr>
		<td>
			<label for="title">Choose a attribute file for the title</label>
		</td>
		<td>
			   <select name="title">
			   <optgroup label="Image attribute">
			       <option value="title"       <?php      echo ($title == "title"?'selected':'')?>            >Title</option>
			       <option value="description" <?php      echo ($title == "description"?'selected':'')?>      >Description</option>
			       <option value="date"        <?php      echo ($title == "date"?'selected':'')?>             >Date Posted</option>
			       <option value="filename"    <?php      echo ($title == "filename"?'selected':'')?>         >File Name</option>
			       <option value="none"    		<?php      echo ($title == "none"?'selected':'')?>         >File Name</option>
			   </optgroup>
			   <optgroup label="Custom attribute">
			       <?php      
			       foreach($fileAttributes as $ak) :  ?>
				   <option value="<?php      echo $ak->getAttributeKeyHandle() ?>"
					   <?php      echo ($title == $ak->getAttributeKeyHandle()?'selected':'')?> ><?php      echo  $ak->getAttributeKeyName() ?>
				   </option>
			       <?php       endforeach ?> 
			   </optgroup>
			   </select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="description"><?php echo t('Choose a attribute file for the description')?></label>			
		</td>
		<td>
			   <select name="description">
			   <optgroup label="Image attribute">
			       <option value="title"       <?php      echo ($description == "title"?'selected':'')?>            >Title</option>
			       <option value="description" <?php      echo ($description == "description"?'selected':'')?>      >Description</option>
			       <option value="date"        <?php      echo ($description == "date"?'selected':'')?>             >Date Posted</option>
			       <option value="filename"    <?php      echo ($description == "filename"?'selected':'')?>         >File Name</option>
			       <option value="none"        <?php      echo ($description == "none"?'selected':'')?>             >Date Posted</option>
			   </optgroup>
			   <optgroup label="Custom attribute">
			       <?php      
			       foreach($fileAttributes as $ak) :  ?>
				   <option value="<?php      echo $ak->getAttributeKeyHandle() ?>"
					   <?php      echo ($description == $ak->getAttributeKeyHandle()?'selected':'')?> ><?php      echo  $ak->getAttributeKeyName() ?>
				   </option>
			       <?php       endforeach ?> 
			   </optgroup>
			   </select>

		</td>
	</tr>
	<tr>
		<td>
			<label for="autoplay"><?php echo t('Autoplay') ?></label>
		</td>
		<td>
			<input type="radio" name="autoplay" value="1" <?php if ($autoplay == 1) echo 'checked' ?>><?php echo t('Yes') ?></input><br><br>
			<input type="radio" name="autoplay" value="0" <?php if ($autoplay == 0) echo 'checked' ?>><?php echo t('No') ?></input>
		</td>
	</tr>
	<tr>
		<td><label for="slideshow_interval"><?php echo t('Autoplay interval') ?></label></td>
		<td><input type="text" name="slideshow_interval" value="<?php echo $slideshow_interval ? $slideshow_interval : 5000 ?>"></td>
	</tr>
</table>
