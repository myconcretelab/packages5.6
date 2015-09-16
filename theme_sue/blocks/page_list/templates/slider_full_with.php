<?php  defined('C5_EXECUTE') or die("Access Denied.");

$time_start = microtime(true);

$c = Page::getCurrentPage();

if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:366px; background:rgba(100,223,223,.2)">
	<div style="padding: 180px 0px 0px 0px; color:rgba(200,200,200,.6)">
		<?php       echo t('Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php

else :

$pages = $cArray;
$th = Loader::helper('text');
$ih = Loader::helper('image');
$sue = Loader::helper('sue_theme', 'theme_sue');
$ch = Loader::helper('comments', 'theme_sue');
$ph = Loader::helper('page_list', 'theme_sue');

Loader::model('theme_sue_options', 'theme_sue');
$t = new ThemeSueOptions();
$t->set_collection_object($c);
$t->set_toggle_option_name('slider');
$count = 0;

if ($t->__background_animation)
	$background =  (($t->_background_file) )  ? '"' . File::getByID($t->_background_file)->getRelativePath() . '"' : 'THEME_PATH + "/images/slider/bg2.png"' ;
else
	$background = "''";

$showRss = false;
if ($controller->rss) {
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

?>



<div class="col_12 ccm_page_list_slider full_width_slider">

	<div class="jq_fmslideshow" rel="<?php echo $bID?>" style="position:relative; overflow:visible; background:none" align="left" >
	
		<div id="fmslideshow" style="visibility:hidden; text-align:center">
<?php  foreach ($pages as $n => $page):
	
	// Prepare data for each page being listed...

	$first = $n == 0;
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
		//$description = $th->shortenTextWord($description, $controller->truncateChars); //Concrete5.4.2.2 and higher
	}
	$description = $th->entities($description);
	
	//Other useful page data...
	$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
	$author = $pageObj->getVersionAuthorUserName();
	$author_id = $pageObj->getVersionAuthorUserID();
	$author_link = DIR_REL . '/profile/view/' . $author_id;
	$img = $page->getAttribute('page_thumbnail');
	if (is_object($img)) {

	$thumb['thumb'] = $ih->getThumbnail($img,$t->_page_list_1_image_width, $t->_page_list_1_image_height,$t->__page_list_crop);
//continue;
		if (!$img->getAttribute('common_color_1') || !$img->getAttribute('common_color_2') || !$img->getAttribute('common_color_3')) :
			ThemeSuePackage::check_main_colors($img, $img->getVersion());
		endif;
		$caption_align = $img->getAttribute('caption_alignment') ? $img->getAttribute('caption_alignment') : $caption_align = 'R';
		$thumb['common_color_1'] = $img->getAttribute('common_color_1');
		$thumb['common_color_2'] = $img->getAttribute('common_color_2');
		$thumb['common_color_3'] = $img->getAttribute('common_color_3');
		
	} else {
		 $thumb = array();
		 $caption_align = 'R';
		$thumb['common_color_1'] = '000000';
		$thumb['common_color_2'] = '000000';
		$thumb['common_color_3'] = '000000';
	}
	$tags = $page->getAttribute('tags');
	$comment_count = $ch->comment_count($page);
	?>			
				<!--Slide <?php echo  $n ?> -->
			       <div>
				<?php if ($thumb['thumb']) : ?>
					<img data-align="TL" data-spacing="0,0" data-inOutDirection="RL" data-inOutDistance="50" src="<?php  echo $thumb['thumb']->src ?>" alt="fmslideshow" style="width:100%" />
				<?php endif ?>
				
				<div data-align="B<?php echo $caption_align?>" data-spacing="0,0" data-inOutDirection="L" data-inOutDistance="50" class="full_width_slider_caption_box" style="height:<?php echo $t->_page_list_1_image_height?>px; background-color:<?php echo $thumb['common_color_3'] ?>; background-color:rgba(<?php echo implode(',', $sue->hex_to_rvb( $thumb['common_color_3'] ))?>,.6)">	
				<?php  if ($t->__page_list_1_title) : ?>
						<h1>
						     <a href="<?php  echo $url ?>" target="<?php  echo $target ?>" style="color:#<?php echo $sue->get_contrast_color($thumb['common_color_1']) ?>"><?php  echo $title ?></a>
						</h1>		
				<?php endif ?>
				<?php  if ($t->__page_list_1_meta ) : ?>
						<p class="meta" style="color:#<?php echo $sue->get_contrast_color($thumb['common_color_1'] ) ?>">
							<a href="<?php  echo $author_link ?>" class="author" style="color:#<?php echo $sue->get_contrast_color($thumb['common_color_2'], 100 ) ?>">
								<?php  echo $author ?>
									</a>
								&nbsp;&thksim;&nbsp;
								<span class="date"><?php  echo $date ?></span>
			
							<?php   if ($tags) : ?>
								&nbsp;&thksim;&nbsp;<span class="tags"><?php    // echo t('Tags: ')?> <?php   echo $tags?></span>
							<?php  endif ?>
							<?php   if ($comment_count) : ?>
								&nbsp;&thksim;&nbsp;<?php  // echo t('Comments')?>
								<span class="comment"><?php  echo $comment_count ?></span>
							<?php  endif ?>
						</p>
				<?php  endif ?>
				<?php  if ($t->__page_list_1_description) : ?>					
						<p class="full_width_slider_description" style="color:#<?php echo $sue->get_contrast_color($thumb['common_color_3'] ) ?>">
							<?php  echo $description ?>
						</p>
					<?php  if ($t->__page_list_read_more) : ?>
					<div data-align="BR" data-spacing="20,<?php echo 20?>" data-inOutDirection="R" data-inOutDistance="50" data-animationSpeed='100' class="textBg">
						<a href="<?php echo $url ?>" class="butn"><span><?php echo $t->_sliders_read_more_text ?></span></a>
					</div>
					<?php  endif ?>

					<?php  endif ?>

					</div>
					
			       </div><!--Slide <?php echo $n ?> -->
	<?php  endforeach ?>

			</div> <!-- fmslideshow -->
		</div> <!-- jq_fmslideshow -->
	</div> <!-- col_12 -->
	<script type="text/javascript">
		SLIDER_CUSTOM_SETTINGS_<?php echo $bID?> = {
			buttons_type : <?php echo $t->_button_style ?>,
			button_nextPrevious_type:  <?php echo $t->_button_style ?>,
			slideShow : <?php echo $t->__page_list_1_autoscroll ? 'true' : 'false' ?>,
			image_background : <?php echo $background ?>,
			dotButtons : <?php echo $t->__page_list_1_bullets ? 'true' : 'false'?>,
			button_next_previous : <?php echo $t->__page_list_1_arrows ? 'true' : 'false'?>,
			slideshow:<?php echo $t->__page_list_1_slideshow ? 'true' : 'false'?>,
			slideShow_delayTime:<?php echo $t->_page_list_1_interval?>,
			banner_height : <?php echo $t->_page_list_1_image_height ?>,
			button_nextPrevious_autoHide:false,
			button_previous_align: 'BL',
			button_next_align: 'BR',
			button_next_spacing:'-50,0',
			button_previous_spacing:'-50,0',
			desktop_drag : false,
			background_move : true,
			background_moveDistance: 800
		}
	</script>

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
<?php global $shadow_has_displayed; $shadow_has_displayed =true ?>
<div class="shadow-under"></div>
<div class="double-spacer"></div>
<div class="double-spacer"></div>

<?php $time_end = microtime(true);
$time = $time_end - $time_start;
?>
<!-- Slider Generated in <?php echo $time ?> secs -->
 <?php endif ?>