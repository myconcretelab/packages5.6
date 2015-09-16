<?php      
/************************************************************
 * DESIGNERS: SCROLL DOWN! (IGNORE ALL THIS STUFF AT THE TOP)
 ************************************************************/
defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();

if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php            echo t('one Columns Page List <br />Content disabled in edit mode.')?>
    </div>
</div>

<?php      else :

$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('theme_image', 'theme_silence');
$ch = Loader::helper('comments', 'theme_silence');
$ph = Loader::helper('page_list', 'theme_silence');

Loader::model('theme_options', 'theme_silence');
$t = new ThemeOptions($c);
$t->set_toggle_option_name('page_list');

$showRss = false;
$cats = array();
$pageCats = array();
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
foreach ($pages as $n => $page):
	if ($page->getAttribute('page_category')) :
		foreach($page->getCollectionAttributeValue('page_category') as $opt) {
			$pageCats[$page->getCollectionID()] .= ((string)$opt . ' ' );
			$cats[] = (string)$opt;
		}
	endif ;
endforeach;

$cats = array_unique($cats);

//*********************************************************************************************************************
//*********************************************************************************************************************

?>

<div class="ccm-page-list-sortable ccm-page-list-column ccm-page-list-one-column">
	<div class="filter-panel col_12 margin_bottom_30">
	<?php      if (count($cats) && $t->__sort_category) : ?>
		<ul class="option-set" data-option-key="filter">
		<li><?php      echo t('Display :')?> </li>
		  <li><a href="#show-all" data-option-value="*" class="selected rounded"><?php      echo t('show all')?></a></li>
		  <?php      foreach ($cats as $cat): ?>
		  <li><a class="rounded" href="#<?php      echo  $th->entities($cat)?>" data-option-value=".<?php      echo  $th->entities($cat)?>"><?php      echo  $th->entities($cat)?></a></li>
		  <?php      endforeach ?>
		</ul>
	<?php      endif ?>
	<?php      if ($t->__sort_alphabetical) : ?>
		<ul class="option-set" data-option-key="sortBy">
		<li><?php      echo t('Sort :')?> </li>
			<li><a href="#original" data-option-value="original-order" class="selected rounded"><?php      echo t('original')?></a></li>
			<li><a href="#alphabetical" data-option-value="alphabetical" class="rounded"><?php      echo t('alphabetical')?></a></li>
		</ul>	
	<?php      endif ?>
	</div>
	
	<div class="isotope-container">
		<?php      foreach ($pages as $n => $page):
			// Prepare data for each page being listed...
			$last = (1 == ($n % 2)) ;
			$pageObj = Page::getByID($page->getCollectionID(), 1)->getVersionObject();
			$title = $th->entities($page->getCollectionName());
			$url = $nh->getLinkToCollection($page);
			$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
			$target = empty($target) ? '_self' : $target;
			$category = $pageCats[$page->getCollectionID()]; 
	
			$description = $page->getCollectionDescription();
			if ($controller->truncateSummaries) {
				$description = $th->shorten($description, $controller->truncateChars); //Concrete5.4.2.1 and lower
			}
			$description = $th->entities($description);
			
			//Other useful page data...
			$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
			$author = $pageObj->getVersionAuthorUserName();
			$author_id = $pageObj->getVersionAuthorUserID();
			$author_link = DIR_REL . '/profile/view/' . $author_id;
			$img = $page->getAttribute('page_thumbnail');
			$thumb = is_object($img) ? $ih->getThumbnail($img, 600, 300, array('crop' => true, 'quality'=>$t->jpg_quality)) : null;
			$tags = $page->getAttribute('tags');
			$comment_count = $ch->comment_count($page);
			?>
			<div class="<?php      echo $category ?> element element-one-columns-sortable" <?php      if ($category) : ?>data-category="<?php      echo $category ?>" <?php      endif ?> style="">
				<div class="element-one-columns-sortable-inner">
					<div class="thumb">
						<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><img src="<?php      echo $thumb->src ?>" width="<?php      echo $thumb->width ?>" height="<?php      echo $thumb->height ?>" alt="thumbnail" /></a>
					</div>
					<h2 class="ccm-page-list-title">
						<a href="<?php      echo $url ?>" target="<?php      echo $target ?>"><?php      echo $title ?></a>
					</h2>
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
					<?php      if ($t->__page_list_description) : ?>					
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
			</div>
		
		<?php      endforeach; ?>
	
	</div><?php      /* The rest of the template is for the RSS icon and pagination links, which generally don't need to be changed. */ ?>

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

<?php      endif ?>