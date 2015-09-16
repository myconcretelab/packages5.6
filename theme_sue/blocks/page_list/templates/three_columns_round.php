<?php  defined('C5_EXECUTE') or die("Access Denied.");


$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('image');
$h = Loader::helper('sue_theme', 'theme_sue');
//$ph = Loader::helper('page_list', 'theme_silence');

Loader::model('theme_sue_options', 'theme_sue');
$t = new ThemeSueOptions();
$t->set_collection_object($c);
$t->set_toggle_option_name('slider');

if (file_exists(DIR_BASE . '/packages/theme_sue/images/assets/glass.png')) {
	$glass = $ih->getThumbnail(DIR_BASE . '/packages/theme_sue/images/assets/glass.png', 250, 250, true);
}

$bodypattern = $t->_bg_body_custom ? $t->_bg_body_custom : $t->_bg_body_pattern;
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



<div class="col_12 ccm-page-list-column ccm-page-list-three-column-round">
<?php  foreach ($pages as $n => $page):

	if ($page->getAttribute('exclude_from_page_list')) continue;
	
	// Prepare data for each page being listed...
	$first = $n == 0;
	//var_dump($n % 3);
	$last = (2 == ($n % 3));
	$i = ($n %3);
	$end = (bool)($n == count($pages)-1);
	$pageObj = Page::getByID($page->getCollectionID(), 1)->getVersionObject();
	$title = $th->entities($page->getCollectionName());
	$url = $nh->getLinkToCollection($page);
	$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	$target = empty($target) ? '_self' : $target;

	$description = $page->getCollectionDescription();
	if ($controller->truncateSummaries) {
		$description = $th->shorten($description, $controller->truncateChars); //Concrete5.4.2.1 and lower
		//$description = $th->shortenTexthreerd($description, $controller->truncateChars); //Concrete5.4.2.2 and higher
	}
	$description = $th->entities($description);
	
	//Other useful page data...
	//$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
	$author = $pageObj->getVersionAuthorUserName();
	//$author_id = $pageObj->getVersionAuthorUserID();
	//$author_link = DIR_REL . '/profile/view/' . $author_id;
	$img = $page->getAttribute('page_thumbnail');
	$thumb = is_object($img) ? $ih->getThumbnail($img, 210, 210, true) : null;
	//$tags = $page->getAttribute('tags');
	//$comment_count = $ch->comment_count($page);
	?>

	<div class="col_4 <?php  if ($last) echo 'last'?> item">
		<div class="" style="">

			    <div class="ch-item ch-img-1" style="background-image:url(<?php  echo $thumb->src ?>); width:<?php  echo $thumb->width + 40 ?>px; height:<?php  echo $thumb->height +40 ?>px">                
			        <div class="ch-info-wrap" style="width:<?php  echo $thumb->width ?>px; height:<?php  echo $thumb->height ?>px; ">
			            <div class="ch-info" style="width:<?php  echo $thumb->width ?>px; height:<?php  echo $thumb->height ?>px">
			                <div class="ch-info-front ch-img-1" style="background-image:url(<?php  echo $thumb->src ?>)"></div>
			                <div class="ch-info-back" style="background-image:url(<?php echo $h->get_pattern_relative_path(array('color' => substr($img->getAttribute('common_color_1'), 1 , 6 ), 'pattern' => $bodypattern))?>)">
			                    <h3 style="color:#<?php echo $h->get_contrast_color($img->getAttribute('common_color_1')) ?>"><?php  echo $title ?></h3>
			                    <p style="color:#<?php echo $h->get_contrast_color($img->getAttribute('common_color_1')) ?>"><?php echo $description?> </p>
			                    <p><a  style="color:#<?php echo $h->get_contrast_color($img->getAttribute('common_color_1')) ?>" href="<?php  echo $url ?>" class=""><?php echo $t->_sliders_read_more_text ?></a></p>
			                </div>    
			            </div>
			        </div>
			    </div>




<!-- 			<div class="thumb" >
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>" >
					<img src="<?php  echo $thumb->src ?>" width="<?php  echo $thumb->width ?>" height="<?php  echo $thumb->height ?>" alt="thumbnail" class="thumb circle" />
				</a>
			</div>	 -->	
		</div>


	</div>

	<?php   if ($last) echo '<div class="clear"></div><hr class="space">'?> 

		
	<?php  endforeach; ?>

</div><!-- .ccm-page-list -->
<hr class="space">

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
