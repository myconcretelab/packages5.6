<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); 
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
		
		//Other useful page data...
		$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
		//$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();
		$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
		$img = $page->getAttribute('page_thumbnail');
		$thumb = $ih->getThumbnail($img, 630, 300, true);

		$entryController = Loader::controller($page);
		if(method_exists($entryController,'getCommentCountString')) {

			$comments = $entryController->getCommentCountString('%s '.t('Comment'), '%s '.t('Comments'));
		}

		
?>
  	<section class="post">
       <a href="<?php  echo $url ?>"><h2><?php  echo $title ?></h2></a>
      <p class="meta"> 
      <span class="left"><?php echo ('Date:')?> <strong><?php echo $date?></strong></span> 
      <span class="left"><?php echo t('posted by')?> <strong><?php echo $original_author?></strong></span>
      <?php if ($comments) : ?><span><?php echo $comments ?></span><?php endif ?>
      <!-- <span class="left tags">on <a href="#" rel="tag">photography</a>, <a href="#" rel="tag">Artistic</a>, <a href="#" rel="tag">Beauty and Art</a></span> <span class="left comment"> <a href="#" title="">46 Comments</a></span> </p> -->
      <a href="<?php  echo $url ?>"><img src="<?php echo $thumb->src?>" alt="" target="<?php  echo $target ?>"/></a>
      <?php  echo $description ?>
      <!-- <h4>Tags: <a href="#">Seo</a> &loz; <a href="#">Print</a> &loz; <a href="#">Design</a></h4> -->
      <a href="<?php  echo $url ?>" class="buttonhome" target="<?php  echo $target ?>">&rarr; <?php echo t('more')?></a> 
    </section>
      		
	<?php  endforeach; ?>
 

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
 
</div><!-- end .ccm-page-list -->


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