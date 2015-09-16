<?php defined('C5_EXECUTE') or die(_("Access Denied."));

if (!preg_match('/em|px|%/', $controller->spacerHeight)) {
	$height = $controller->spacerHeight.'px';
} else {
	$height = $controller->spacerHeight;
}
?>


<p class="ml-spacer" style="height:<?php echo $height ?>; <?php if ($top) :?> line-height:<?php echo $height ?><?php endif?>">
	<?php if ($iurl) : ?>
	<img src="<?php echo $iurl ?>" alt="">
	<?php endif ?>
</p>
