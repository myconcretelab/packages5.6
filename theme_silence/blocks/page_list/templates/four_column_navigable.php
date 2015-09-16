<?php      
/************************************************************
 * DESIGNERS: SCROLL DOWN! (IGNORE ALL THIS STUFF AT THE TOP)
 ************************************************************/
defined('C5_EXECUTE') or die("Access Denied.");

$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('image');
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


<!-- ccm-page-list-three-column-navigable -->
<div class="col_12 ccm-page-list-column ccm-page-list-four-column-navigable ccm-page-list-navigable">
	<div class="navigable col_12 <?php      if ($t->__page_list_navi_autoscroll) : ?> diaporama<?php      endif?>" data-interval="<?php      echo $t->page_list_navi_interval?>" data-speed="<?php      echo $t->page_list_navi_scroll_speed?>">   
		<div class="navigable-items">
		<?php      foreach ($pages as $n => $page):
			
			// Prepare data for each page being listed...
			$first = $n == 0;
			$last = (3 == ($n % 4));
			$i = ($n %4);
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
			$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
			$author = $pageObj->getVersionAuthorUserName();
			$author_id = $pageObj->getVersionAuthorUserID();
			$author_link = DIR_REL . '/profile/view/' . $author_id;
			$img = $page->getAttribute('page_thumbnail');
			
			$thumb = is_object($img) ? $ih->getThumbnail($img, 351, 197, true) : null;
			$tags = $page->getAttribute('tags');
			$comment_count = $ch->comment_count($page);
			?>

			<?php      if ($i == 0 ) echo "<div class='navigable-group-item ccm-page-list-page'>" ?>
			<div class="col_3 <?php      if ($last) echo 'last'?>">
				<div class="thumb" > <!-- style="width:351px; height:197px" -->
					<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><img src="<?php      echo $thumb->src ?>" width="<?php      echo $thumb->width ?>" height="<?php      echo $thumb->height ?>" alt="thumbnail" /></a>
				</div>
				<?php      if ($t->__page_list_navi_title) : ?>				
				<h4 class="ccm-page-list-title">
					<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><?php      echo $title ?></a>
				</h4>
				<?php      endif ?>
				<?php      if ($t->__display_meta_creator || $t->__display_meta_tag || $t->__display_meta_comments || $t->__display_meta_date ) : ?>
					<p class="meta">
						<?php      if ($t->__display_meta_creator) : ?>
							<?php      if ($t->__display_meta_creator_link) : ?>
								<a href="<?php      echo $author_link ?>" class="author">
							<?php      else : ?>
								<span class="author">
							<?php      endif ?>
								<?php      echo $author ?>
							<?php      if ($t->__display_meta_creator_link) : ?>
								</a>
							<?php      else : ?>
								</span>
							<?php      endif ?>
							&nbsp;&thksim;&nbsp;
						<?php      endif ?>

						<?php      if ($t->__display_meta_date) : ?>
							<span class="date"><?php      echo $date ?></span>
						<?php      endif ?>

						<?php       if ($tags && $t->__display_meta_tag) : ?>
							&nbsp;&thksim;&nbsp;<span class="tags"><?php        // echo t('Tags: ')?> <?php       echo $tags?></span>
						<?php      endif ?>
						<?php       if ($comment_count && $t->__display_meta_comments) : ?>
							&nbsp;&thksim;&nbsp;<?php      // echo t('Comments')?>
							<span class="comment"><?php      echo $comment_count ?></span>
						<?php      endif ?>
					</p>
					<?php      endif ?>
				<?php      // description ?>
					<?php      if ($t->__page_list_navi_description) : ?>					
					<p class="ccm-page-list-description">
						<?php      echo $description ?>
					</p>
					<?php      endif ?>

				<?php      // Read More ?>
					<?php      if ($t->__page_list_read_more) : ?>					
					<p class="read_more">
						<a class="<?php      if ($t->__page_list_read_more_button):?>butn<?php      endif ?>" href="<?php      echo $url ?>" target="<?php      echo $target ?>"><?php       echo $t->page_list_read_more_text ?></a>
					<div class="clear"></div>
					</p>
					<?php      endif ?>
			</div>
	
			<?php      if ($i == 3 || $end) echo '</div> <!-- end -->' ?>
			<?php      // if ($last) echo '<div class="clear"></div>'?>
	
		
		<?php      endforeach; ?>
		</div>
	</div>
	<div class="clear"></div>
	<?php      if ($t->__page_list_navi_bullets) : ?>
		<div class="navi"></div>
	<?php      endif ?>
	<?php      if ($t->__page_list_navi_arrows) : ?>
		<a class="prev browse left no-transition"></a>
		<a class="next browse right no-transition"></a>
	<?php      endif ?>
		
</div>

<?php      /* The rest of the template is for the RSS icon and pagination links, which generally don't need to be changed. */ ?>

	<?php      if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php      echo $rssUrl ?>" target="_blank"><img src="<?php      echo $rssIconSrc ?>" width="14" height="14" alt="<?php      echo $translatedRssIconAlt; ?>" title="<?php      echo $translatedRssIconTitle; ?>" /></a>
		</div>
		<?php      echo $rssInvisibleLink ?>
	<?php      endif; ?>
 
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
<div class="clear"></div>
