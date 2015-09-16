<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('file_set');
Loader::model('file_attributes');

$fileAttributes = FileAttributeKey::getList(); 
$s1 = FileSet::getMySets();

$fsa = array("" => "Select a file set");
?>
<label for="title"><?php   echo t('Display as image title') ?>:</label>
<select name="title[]" onchange="toggleCustomTitle(this.value);">
<optgroup label="image attribute">
    <option value="blank"       <?php  echo ($fsTitle == "blank"?'selected':'')?>            >No description</option>
    <option value="title"       <?php  echo ($fsTitle == "title"?'selected':'')?>            >Title</option>
    <option value="description" <?php  echo ($fsTitle == "description"?'selected':'')?>      >Description</option>
    <option value="date"        <?php  echo ($fsTitle == "date"?'selected':'')?>             >Date Posted</option>
    <option value="filename"    <?php  echo ($fsTitle == "filename"?'selected':'')?>         >File Name</option>
    <option value="customTitle"<?php  echo ($fsTitle == "customTitle"?'selected':'')?>     >Custom Title</option>
</optgroup>
<optgroup label="Custom attribute">
    <?php  
    foreach($fileAttributes as $ak) :  ?>
        <option value="<?php  echo $ak->getAttributeKeyHandle() ?>"
                <?php  echo ($fsTitle == $ak->getAttributeKeyHandle()?'selected':'')?> ><?php  echo  $ak->getAttributeKeyName() ?>
        </option>
    <?php   endforeach ?> 
</optgroup>
</select>
<div id="ccm-customTitle"  <?php  if ($fsTitle != 'customTitle') :?> style="display:none"<?php  endif ?>>
        <br>
<!--<label for="galleryTitle">Title</label>-->
<input name="customTitle[]" class="ccm-input-text" type="text" value="<?php  echo $customTitle ?>" size="30" />
</div>