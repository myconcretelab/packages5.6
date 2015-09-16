<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

?>
<?php if ($type== 'fileset') : ?>
  <div class="fileset ">
    <select id="<?php echo $capsID . '_' . $uniqueID?>" title="fsID">
      <option value="0"><?php echo t('-- No fileset selected --')?></option>
     <?php   foreach($myFileSet as $fs) {
       echo '<option value="'.$fs->getFileSetID().'" ' . ($medias[$place] == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
     }?>
   </select>
 </div><!-- End fileset-empty -->


<?php  elseif ($type== 'image') : ?>
  <div class="image">
    <?php   $img['fType'] = FileType::T_IMAGE; ?>
    <?php  echo $al->file($capsID . '_' . $uniqueID, 'media_'.$uniqueID, t('Choose File'),$media,$img);?> 
  </div><!-- End image -->


<?php  elseif ($type== 'mp3') : ?>
  <div class="mp3">
    <?php  $mp3['fExtension'] = "mp3"; ?>
    <?php  echo $al->file($capsID . '_' . $uniqueID, 'media_'.$uniqueID, t('Choose File'),$media,$mp3);?> 
  </div><!-- End Sounds -->

<?php  elseif ($type== 'quicktime') : ?>
  <div class="quicktime">
    <input type="hidden" name="mID[]" value="<?php echo $uniqueID?>" />
    <input type="hidden" name="type_<?php echo $uniqueID?>" value="quicktime" />
    <?php  $mov['fExtension'] = "mov"; ?>
    <?php  echo $al->file($capsID . '_' . $uniqueID, 'media_'.$uniqueID, t('Choose File'), $media,$mov);?> 
  </div><!-- End Sounds -->

<?php  elseif ($type== 'color') : ?>
  <div class="color">
    <?php echo $ch->output($capsID . '_' . $uniqueID , t('Choose a color'), null, true)  ?>
  </div>


<?php  elseif ($type== 'page_attribute') : ?>
  <div class="page_attribute">
    <select id="<?php echo $capsID . '_' . $uniqueID?>" title="pa">
      <option value="0"><?php echo t('-- No attribute selected --')?></option>
    <?php foreach (CollectionAttributeKey::getList() as $key => $at) {
        echo "<option value='$at->akHandle'>$at->akName</option>";
    }  ?>
   </select>
  </div>

<?php  elseif ($type== 'page') : ?>
  <div class="user">
    <?php echo $ph->selectPage($capsID . '_' . $uniqueID)  ?>
  </div>

<?php  elseif ($type== 'user') : ?>
  <div class="user">
    <?php echo $uh->selectUser($capsID . '_' . $uniqueID)  ?>
  </div>
<?php  endif ?>