<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<optgroup label="File attribute">
    <option value="none">None</option>
    <option value="title">Title</option>
    <option value="description">Description</option>
    <option value="date">Date Posted</option>
    <option value="filename">File Name</option>
</optgroup>
<optgroup label="Custom attribute">
    <?php  
    foreach($fileAttributes as $ak) :  ?>
        <option value="<?php  echo $ak->getAttributeKeyHandle() ?>">
                <?php  echo  $ak->getAttributeKeyName() ?>
        </option>
    <?php   endforeach ?> 
</optgroup>
