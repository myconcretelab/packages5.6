<?php 
defined('C5_EXECUTE') or die("Access Denied.");

// --- Here start otpion for columns ---- //

$max_columns_number = 4;
$min_columns_number = 2;

// --- Here stop option for columns ---- //


$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
?>

<div class="ccm-page-list bxslider" data-carousel="true" data-maxslides="<?php echo $max_columns_number ?>" data-minslides="<?php echo $min_columns_number ?>" data-slidewidth="<?php echo (1170 / $max_columns_number) + 100 ?>">

	<?php  foreach ($pages as $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$img = $page->getAttribute('page_thumbnail');
		$thumb = $ih->getThumbnail($img, 1170 / $max_columns_number, (1170 / $max_columns_number) /2, true);

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
		<div class="carousel-page-list">
			<?php if ($thumb) : ?><img src="<?php  echo $thumb->src ?>" width="<?php  echo $thumb->width ?>" height="<?php  echo $thumb->height ?>" alt="" /> <?php endif ?>
			<p class="p-title sans upp bld zero">
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?></a>
			</p>
				<p><?php  echo $description ?></p>
				<a class="readmore" href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo t('Read more..') ?> <i class="fa fa-arrow-right"></i></a>
		</div>
		
	<?php  endforeach; ?>
 

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
 
</div><!-- end .ccm-page-list -->
