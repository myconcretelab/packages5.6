<?php    defined('C5_EXECUTE') or die(_("Access Denied."))?>
<input type="hidden" name="content_type" value="fileset" />
<table width="100%">
  <tr>
    <th  width="30%">Image</th>
    <th  width="70%">Link to <small>(optional)</small></th>
  </tr>

  <?php       foreach ($files as $key=>$file ) :
        // Prendre le fichier associŽ ˆ l'ID, tester si c'est une image
        $img = File::getByID($file['fID']);
        $fv = $img->getExtension();
	$ft = FileTypeList::getType($fv);
	$img = $ft->type == 1 ?  $img : false;
	if (!$img) continue;
	$s = @getimagesize($img->getPath());
	$hh = $hh < $s[1] ?  $s[1] : $hh;
	$hw = $hw < $s[0] ?  $s[0] : $hw;	
  ?>

  <tr>
    <td class='item-thumb rg-elements'>
      <?php     echo $img ? $ih->outputThumbnail($img,80,80)->src : '' ?>
      <input  type='hidden' value='<?php echo $file['fID']?>' name='fileLink[]' />
  </td>
  <td>
    <table width="100%">
      <tr>
	<td><input type="radio" name="link_type_<?php echo $file['fID']?>" value="page" <?php echo $linkType[array_search($file['fID'],$fileLink)] == 'page' ? 'CHECKED' : ''?> /><strong><?php echo t('Page')?></strong></td>
	<td>
	   <?php echo $pageSelector->selectPage('linkPageID_' . $file['fID'], $linkPageID[array_search($file['fID'],$fileLink)]); ?>
	</td>
      </tr>
      <tr>
	<td><input type="radio" name="link_type_<?php echo $file['fID']?>" id="link_type_<?php echo $file['fID']?>" value="url" <?php echo $linkType[array_search($file['fID'],$fileLink)] == 'url' ? 'CHECKED' : ''?> /><strong><?php echo t('Url')?></strong></td>
	<td>
	    <input type="text" name="linkAdress[]" value="<?php echo $linkAdress[array_search($file['fID'],$fileLink)] ?>" onclick="$('#link_type_<?php echo $file['fID']?>').attr('checked', true)" style="width:230px; border:1px solid #ccc" /><br />
	    <small>This url is ignored if it doesn't start by "http://"</small>
	</td>
      </tr>
      <tr>
	<td colspan="2"><input type="radio" name="link_type_<?php echo $file['fID']?>" value="none" <?php echo $linkType[array_search($file['fID'],$fileLink)] == 'none' || count($linkType) < 1 ? 'CHECKED' : ''?> /><strong>No link</strong></td>
      </tr>
    </table>
    
  </td>
  </tr>
<!--  <tr>
    <td colspan="2">
      <hr />
    </td>
  </tr> -->
  <?php       endforeach ?>
</table>
