<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
//Note that $nh (navigation helper) is already loaded for us by the controller (for legacy reasons)
?>
<div class="clearfix">
	
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
		$thumb = $ih->getThumbnail($img, 500, 250, true);

 ?>
		

  <div class="one_third <?php if($last) echo 'lastcolumn'?>">
    <section class="boxthreebox"> 
    <?php if ($thumb) : ?>
    	<img src="<?php echo $thumb->src?>" alt="" target="<?php  echo $target ?>"/>
    <?php endif ?>
     <a class ="simple" href="<?php  echo $url ?>"><h3><?php  echo $title ?></h3></a> 
      <p><?php  echo $description ?></p>
      <a class ="simple" href="<?php  echo $url ?>"><?php echo t('+ Learn more')?></a> 
    </section>
  </div>
		<?php if ($last) echo '<div class="blankSeparator1"></div>'?>
	<?php  endforeach; ?>
 

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo t('RSS Icon') ?>" title="<?php  echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php  echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php  echo $rssTitle; ?>" />
	<?php  endif; ?>
 
</div>

<div class="blankSeparator1"></div>



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