<?php     defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('file/types');
Loader::model('file');
$al             = Loader::helper('concrete/asset_library');
$db             = Loader::db();
$ih             = Loader::helper('image');
$pageSelector   = Loader::helper('form/page_selector');

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}

$pla = explode(',',$bi->linkPageID);
$pli = explode(',',$bi->fileLink);

$vals = array( $_GET['fsID']);
$sql = 'SELECT fID FROM FileSetFiles WHERE fsID=?';
$files = $db->getAll($sql,$vals);

?>

<table width="100%" class='ccm-roundabout-link-table'>
  <tr>
    <th  width="40%">image</th>
    <th  width="60%">link to </th>
  </tr>

  <?php   foreach ($files as $file ) :
        $img = File::getByID($file['fID']);
        $fv = $img->getExtension();
	$ft = FileTypeList::getType($fv);
	$img = $ft->type == 1 ?  $img : false;
  ?>
        
  <tr>
    <td class='item-thumb'><?php echo $img ? $ih->outputThumbnail($img,80,80)->src : '' ?>
        <input type='hidden' value='<?php echo $file['fID']?>' name='fileLink[]' />
  </td>
        <td><?php   echo $pageSelector->selectPage('linkPageID[]', $pla[array_search($file['fID'],$pli)]) ?></td>
  </tr>
  <?php   endforeach ?>
</table>

