<?php    defined('C5_EXECUTE') or die(_("Access Denied."))?>
<?php
  $media = File::getByID($fID);
  $img['fType'] = FileType::T_AUDIO;
  ?>
  <div class="youtube media">
    <table width="100%">
      <tr>
      <td style="width:50%">
          <h3  class="media-title">Youtube Adress</h3>          
        </td>
        <td>
          <input type="hidden" name="media-type-<?php echo $panelID?>[]" value="youtube" />  
          <input type="text" value="<?php echo $value?>" name="media_<?php echo $panelID?>[]" />
          
        </td>
      </tr>
    </table>
  </div>
