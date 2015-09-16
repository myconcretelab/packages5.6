<?php  
/************************************************************
 * DESIGNERS: SCROLL DOWN! (IGNORE ALL THIS STUFF AT THE TOP)
 ************************************************************/
defined('C5_EXECUTE') or die("Access Denied.");
// error_reporting(E_ALL);
// ini_set('display_errors','On');
$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('image');
//$ch = Loader::helper('comments', 'theme_silence');
//$ph = Loader::helper('page_list', 'theme_silence');

Loader::model('theme_sue_options', 'theme_sue');
$t = new ThemeSueOptions();
$t->set_collection_object($c);
$t->set_toggle_option_name('slider');

if (file_exists(DIR_BASE . '/packages/theme_sue/images/assets/glass.png')) {
	$glass = $ih->getThumbnail(DIR_BASE . '/packages/theme_sue/images/assets/glass.png', 250, 250, true);
}


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



<div class="col_12 ccm-page-list-column ccm-page-list-two-column-round">
<?php  foreach ($pages as $n => $page):
	
	// Prepare data for each page being listed...
	$first = $n == 0;
	$last = (1== ($n % 2));
	$i = ($n %2);
	$end = (bool)($n == count($pages)-1);
	$pageObj = Page::getByID($page->getCollectionID(), 1)->getVersionObject();
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
	
	//Other useful page data...
	//$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
	//$author = $pageObj->getVersionAuthorUserName();
	//$author_id = $pageObj->getVersionAuthorUserID();
	//$author_link = DIR_REL . '/profile/view/' . $author_id;
	$img = $page->getAttribute('page_thumbnail');
	$thumb = is_object($img) ? $ih->getThumbnail($img, 210, 210, true) : null;
	//$tags = $page->getAttribute('tags');
	//$comment_count = $ch->comment_count($page);
	?>

	<div class="col_6 <?php  if ($last) echo 'last'?> item">
		<div class="col_6">
			<div class="thumb" >
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>" >
					<img src="<?php  echo $thumb->src ?>" width="<?php  echo $thumb->width ?>" height="<?php  echo $thumb->height ?>" alt="thumbnail" class="thumb circle" />
				</a>
			</div>		
		</div>
		<div class="col_6 last">
			<h1 class="ccm-page-list-title">
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?>
				<?php if ($page->getAttribute('featured')) : ?>
				&nbsp;<span>*</span>
				<?php  endif; ?>
				</a>
			</h1>
			<p class="ccm-page-list-description">
				<?php  echo $description ?>
			</p>
			<?php  // Read More ?>
		</div>

	</div>

	<?php   if ($last) echo '<div class="clear"></div>'?>

		
	<?php  endforeach; ?>

</div><!-- .ccm-page-list -->

<?php  /* The rest of the template is for the RSS icon and pagination links, which generally don't need to be changed. */ ?>

	<?php  if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php  echo $rssUrl ?>" target="_blank"><img src="<?php  echo $rssIconSrc ?>" width="14" height="14" alt="<?php  echo $translatedRssIconAlt; ?>" title="<?php  echo $translatedRssIconTitle; ?>" /></a>
		</div>
		<?php  echo $rssInvisibleLink ?>
	<?php  endif; ?>
 

<?php  if ($showPagination): ?>
	<div id="pagination">
		<div class="ccm-spacer"></div>
		<div class="ccm-pagination">
			<span class="ccm-page-left"><?php  echo $paginator->getPrevious('&laquo; Previous') ?></span>
			<?php  echo $paginator->getPages() ?>
			<span class="ccm-page-right"><?php  echo $paginator->getNext('Next &raquo;') ?></span>
		</div>
	</div>
<?php  endif; ?>
<div class="clear"></div>
