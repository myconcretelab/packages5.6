<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="related_content_links">
	<?php if (!empty($title)): ?>
	<h2><?php echo htmlspecialchars($title, ENT_QUOTES, APP_CHARSET); ?></h2>
	<?php endif; ?>
	
	<ul>
	<?php
	foreach ($pages as $page):
		$link = $nh->getLinkToCollection($page);
		$title = htmlspecialchars($page->getCollectionName(), ENT_QUOTES, APP_CHARSET);
		$date = empty($dateFormat) ? '' : date($dateFormat, strtotime($page->getCollectionDatePublic()));
		?>
		<li>
			<a href="<?php echo $link; ?>" class="more"><?php echo $title; ?></a>
			<?php if (!empty($date)): ?>
			<br /><em class="date"><?php echo $date; ?></em>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>