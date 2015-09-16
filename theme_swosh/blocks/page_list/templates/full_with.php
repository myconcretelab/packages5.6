<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
//Note that $nh (navigation helper) is already loaded for us by the controller (for legacy reasons)
?>

<div class="blankSeparator"></div>



	<?php  foreach ($pages as $i=>$page):

		$last = $i % 3 == 2 ; //
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$img = $page->getAttribute('page_thumbnail');
		$thumb = $ih->getThumbnail($img, 650, 300, true);
 ?>
		
  <div class="two_third">
    <div class="flexslider">
      <img src="<?php echo $thumb->src?>" alt="" target="<?php  echo $target ?>"/>
    </div>
  </div>
  <div class="one_third lastcolumn">
    <h2><?php  echo $title ?></h2>
     <p><?php  echo $description ?></p>
    <p class="portfolio"><a href="<?php  echo $url ?>"><?php echo t('+ Learn more')?></a><?if ($page->getAttribute('link_url')) echo "| <a href='{$page->getAttribute('link_url')}'> {t('Visit Website')}</a>"?></p>
  </div>

<?php  endforeach; ?>
<div class="blankSeparator1"></div> 

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
 
<div class="blankSeparator1"></div>



<?php  if ($showPagination): ?>

  <div class="blankSeparator"><!-- --></div>
  <div id="pagination" class="fl"> 
    <!-- Pagination -->
    <ul class="pagination">
      <li><?php  echo $paginator->getPrevious('&laquo; ' . t('Previous'), 'a') ?></li>
      <?php  echo $paginator->getPages('li') ?>
      <li><?php  echo $paginator->getNext(t('Next') . ' &raquo;', 'a') ?></li>

    </ul>
  </div>
  <!-- end pagination --> 


<?php  endif; ?>