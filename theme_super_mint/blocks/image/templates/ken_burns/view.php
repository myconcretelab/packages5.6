<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$img = $controller->getFileObject();
$fv = $img->getApprovedVersion();
$title = $fv->getTitle();
$description = $fv->getDescription();
// var_dump($buff);
?>
<div class="kenBurns" id="kenBurns_<?php echo $bID ?>">
	<div class="container">
		<?php if ($title) : ?><h1><?php echo $title ?></h1><?php endif ?>
		<?php if ($description) : ?><p class=""><?php echo $description ?></p><?php endif ?>
			
	</div>
	<span class="background" style="background-image:url(<?php echo $fv->getRelativePath() ?>);"></span>	
</div>
