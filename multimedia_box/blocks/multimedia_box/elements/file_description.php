<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('file_set');
Loader::model('file_attributes');

$fileAttributes = FileAttributeKey::getList(); 
$s1 = FileSet::getMySets();

$fsa = array("" => "Select a file set");
?>
<label for="description"><?php   echo t('Display as image Description')?>:</label>
   <select name="description[]" class="ccm-file-set-description" onchange="toggleCustomDescription(this.value);">
   <optgroup label="image attribute">
       <option value="blank"       <?php  echo ($description == "blank"?'selected':'')?>        >No title</option>
       <option value="title"       <?php  echo ($description == "title"?'selected':'')?>        >Title</option>
       <option value="description" <?php  echo ($description == "description"?'selected':'')?>  >Description</option>
       <option value="date"        <?php  echo ($description == "date"?'selected':'')?>         >Date Posted</option>
       <option value="filename"    <?php  echo ($description == "filename"?'selected':'')?>     >File Name</option>
       <option value="customDescription"<?php  echo ($description == "customDescription"?'selected':'')?>     >Custom Description</option>
   </optgroup>
   <optgroup label="Custom attribute">
       <?php  
       foreach($fileAttributes as $ak) {  ?>
           <option value="<?php  echo $ak->getAttributeKeyHandle()?>"
               <?php  echo ($description == $ak->getAttributeKeyHandle()?'selected':'')?>         ><?php  echo  $ak->getAttributeKeyName() ?>
           </option>
       <?php   } ?>
   </optgroup>
   </select>
   <div id="ccm-customDescription" <?php  if ($description != 'customDescription') :?> style="display:none"<?php  endif ?>>
           <br>
   <!--<label for="galleryDesc">Description</label>-->
   <textarea name="customDescription[]" class="ccm-input-textarea" style="width:200px; height:50px;"><?php  echo $customDescription ?></textarea>
   </div>