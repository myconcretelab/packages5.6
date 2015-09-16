<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>

<table width="100%" class='ccm-roundabout-link-table'>
  <tr>
    <th  width="30%">Image</th>
    <th  width="30%">Link to <small>(optional)</small></th>
  </tr>

  <?php    foreach ($files as $key=>$file ) :
        // Prendre le fichier associŽ ˆ l'ID, tester si c'est une image
        $img = File::getByID($file['fID']);
        $fv = $img->getExtension();
	$ft = FileTypeList::getType($fv);
	$img = $ft->type == 1 ?  $img : false;
	
	$s = @getimagesize($img->getPath());
	$hh = $hh < $s[1] ?  $s[1] : $hh;
	$hw = $hw < $s[0] ?  $s[0] : $hw;	
  ?>
        
  <tr>
	<td class='item-thumb'><?php  echo $img ? $ih->outputThumbnail($img,80,80)->src : '' ?>
		<input type='hidden' value='<?php  echo $file['fID']?>' name='fileLink[]' />
	</td>
	<td><?php    echo $pageSelector->selectPage('linkPageID[]', $linkPageID[array_search($file['fID'],$fileLink)]); ?></td>
  </tr>
  <?php    endforeach ?>
</table>
<script type="text/javascript">
	refreshPresetsList ();
	setjQuerySlider('width',50,2000,'<? echo $hw ?>');
	setjQuerySlider('height',50,1000,'<? echo $hh?>');
</script>
