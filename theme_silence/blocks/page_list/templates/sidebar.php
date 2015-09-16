<?php      
/************************************************************
 * DESIGNERS: SCROLL DOWN! (IGNORE ALL THIS STUFF AT THE TOP)
 ************************************************************/
defined('C5_EXECUTE') or die("Access Denied.");

$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('theme_image', 'theme_silence');
$ch = Loader::helper('comments', 'theme_silence');
$ph = Loader::helper('page_list', 'theme_silence');

Loader::model('theme_options', 'theme_silence');
$t = new ThemeOptions(Page::getCurrentPage());
$t->set_toggle_option_name('page_list');

$showRss = false;
if (!$previewMode && $controller->rss) {
	$showRss = true;
	$rssUrl = $controller->getRssUrl($b);
	$rssTitle = $th->entities($controller->rssTitle);
	$btID = $b->getBlockTypeID();
	$bt = BlockType::getByID($btID);
	$rssIconSrc = Loader::helper('concrete/urls')->getBlockTypeAssetsURL($bt, 'rss.png');
	$rssInvisibleLink = '<link href="'.BASE_URL.$rssUrl.'" rel="alternate" type="application/rss+xml" title="'.$rssTitle.'" />';
	$translatedRssIconAlt = t('RSS Icon');
	$translatedRssIconTitle = t('RSS Feed');
}

$showPagination = false;
if ($paginate && $num > 0 && is_object($pl)) {
	$description = $pl->getSummary();
	if ($description->pages > 1) {
		$showPagination = true;
		$paginator = $pl->getPagination();
	}
}

/******************************************************************************
* DESIGNERS: CUSTOMIZE THE PAGE LIST HTML STARTING HERE...
*/?>

<div class="ccm-page-list-sidebar">

	<?php      foreach ($pages as $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;

		$description = $page->getCollectionDescription();
		if ($controller->truncateSummaries) {
			$description = $th->shorten($description, $controller->truncateChars); //Concrete5.4.2.1 and lower
			//$description = $th->shortenTextWord($description, $controller->truncateChars); //Concrete5.4.2.2 and higher
		}
		$description = $th->entities($description);
		$img = $page->getAttribute('page_thumbnail');
		$thumb = is_object($img) ? $ih->getThumbnail($img, 100, 100, array('crop' => true, 'quality'=>$t->jpg_quality)) : null;
		



		/*** Here comes the most important part of the template! The html from here down to the "endforeach" line is repeated for each page in the list... */ ?>

		<h3 class="ccm-page-list-title">
			<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><?php      echo $title ?></a>
		</h3>
		<div class="ccm-page-list-description">

				<img src="<?php      echo $thumb->src ?>" width="<?php      echo $thumb->width ?>" height="<?php      echo $thumb->height ?>" alt="thumbnail" class="alignleft" />
			<p>
				<?php      echo $description ?>
			</p>

			<?php      if ($t->__page_list_read_more) : ?>					
			<p class="read_more">
				<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><?php       echo $t->page_list_read_more_text ?> &rarr;</a>
			</p>
			<div class="clear"></div>
			<?php      endif ?>
		</div>

	<?php      endforeach; ?>
 
<?php      /* The rest of the template is for the RSS icon and pagination links, which generally don't need to be changed. */ ?>

	<?php      if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php      echo $rssUrl ?>" target="_blank"><img src="<?php      echo $rssIconSrc ?>" width="14" height="14" alt="<?php      echo $translatedRssIconAlt; ?>" title="<?php      echo $translatedRssIconTitle; ?>" /></a>
		</div>
		<?php      echo $rssInvisibleLink ?>
	<?php      endif; ?>
 
</div><!-- .ccm-page-list -->

<?php      if ($showPagination): ?>
	<div id="pagination">
		<div class="ccm-spacer"></div>
		<div class="ccm-pagination">
			<span class="ccm-page-left"><?php      echo $paginator->getPrevious('&laquo; Previous') ?></span>
			<?php      echo $paginator->getPages() ?>
			<span class="ccm-page-right"><?php      echo $paginator->getNext('Next &raquo;') ?></span>
		</div>
	</div>
<?php      endif; ?>