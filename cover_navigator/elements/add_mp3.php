<?php    defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div class="mp3 media">
  <table width="100%">
    <tr>
      <td style="width:50%">
	<h3 class="media-title">Music file&nbsp;&nbsp;</h3>
     </td>
      <td>
	<input type="hidden" name="media-type-<?php echo $panelID?>[]" value="mp3" />
	<?php $array['fType'] = FileType::T_AUDIO ?>
	  <?php echo $al->file("mp3_$panelID_$r", "media_$panelID"."[]" , t('Choose File'),$media,$array) ?>    	
       </td>
    </tr>
  </table>
</div>

