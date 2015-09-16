<?php 
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('file_list');
Loader::library('file/types');

$fl = new FileList();
$fl->filterByType(FileType::T_IMAGE);
$files = $fl->get(100, 0);

$more_file = count($files) > 99;

?>
<?php if (!$more_file): ?>
<p><?php echo t('If you have a lot of image files in your manager, the installation can take some time. Indeed it adds three main attributes corresponding to the main colors of the image.')?></p>
<?php else : ?>
<p><?php echo t('You have more than 100 image files in your manager,the installation can take some time. Indeed it adds three main attributes corresponding to the main colors of the image.')?></p>
<?php endif ?>