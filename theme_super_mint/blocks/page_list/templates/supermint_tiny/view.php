<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
?>

<div class="ccm-page-list">

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
		$thumb = $ih->getThumbnail($img, 120, 100, true);
		?>
		<div class="tiny-page-list tiny">
			<img src="<?php  echo $thumb->src ?>" width="<?php  echo $thumb->width ?>" height="<?php  echo $thumb->height ?>" alt="" />
			<h5>
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?></a>
			</h5>
				<p><?php  echo $description ?> <a class="button button-rounded button-flat button-tiny right" href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo t('Read more..') ?> <i class="fa fa-chevron-right"></i></a></p>
				
		</div>
		
	<?php  endforeach; ?>
 

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
 
</div><!-- end .ccm-page-list -->


<?php  if ($showPagination): ?>
	<div id="pagination">
		<div class="ccm-spacer"></div>
		<div class="ccm-pagination">
			<span class="ccm-page-left"><?php  echo $paginator->getPrevious('&laquo; ' . t('Previous')) ?></span>
			<?php  echo $paginator->getPages() ?>
			<span class="ccm-page-right"><?php  echo $paginator->getNext(t('Next') . ' &raquo;') ?></span>
		</div>
	</div>
<?php  endif; ?>