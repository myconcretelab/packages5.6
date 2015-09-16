<?php  
	defined('C5_EXECUTE') or die("Access Denied.");

	$textHelper = Loader::helper("text");
	$ih = Loader::helper('image');
	$ch = Loader::helper('comments', 'theme_sue');
	
	// now that we're in the specialized content file for this block type, 
	// we'll include this block type's class, and pass the block to it, and get
	// the content
	
	if (count($cArray) > 0) { ?>
	
	<?php  
	for ($i = 0; $i < count($cArray); $i++ ) {
		
		$cobj = $cArray[$i]; 
		$pageObj = Page::getByID($cobj->getCollectionID(), 1)->getVersionObject();
		
		$target = $cobj->getAttribute('nav_target');

		$title = $cobj->getCollectionName();
		$date = $cobj->getCollectionDatePublic('M j, Y');

		$author = $pageObj->getVersionAuthorUserName();
		$author_id = $pageObj->getVersionAuthorUserID();
		$author_link = DIR_REL . '/profile/view/' . $author_id;
		
		$tags = $page->getAttribute('tags');
		$comment_count = $ch->comment_count($page);

		?>

	<div class="span2 blog_infos">
		<div class="bog_date">
			<h1><?php  echo $cobj->getCollectionDatePublic('d') ?></h1>
			<h3><?php echo $cobj->getCollectionDatePublic('F') ?></h3>
			<h4><?php echo $cobj->getCollectionDatePublic('y') ?></h4>
		</div>
		<div class="circle"></div>

		<p class="meta">
			<span class="meta_title"><?php echo t('By ')?></span>	<a href="<?php  echo $author_link ?>" class="author"><?php  echo $author ?></a>
			<br />
			<span class="meta_title"><?php echo t('On ')?></span> <?php   echo $cobj->getCollectionDatePublic('F D j Y')?>
			<br />
			<span class="meta_title"><?php echo t('Tags ')?></span> <?php   echo $tags?>
			<br />
			<span class="meta_title"><?php echo t('With ')?></span><?php  echo $comment_count ?><span class="meta_title"><?php echo t(' Comments')?></span>
		</p>
			<a <?php   if ($target != '') { ?> target="<?php  echo $target?>" <?php   } ?> href="<?php  echo $nh->getLinkToCollection($cobj)?>" class="butn"><?php echo t(' Go')?></a>


	</div>
	<div class="col_9 last blog_post">
		<div class="blog_thumb_link">
			<a <?php   if ($target != '') { ?> target="<?php  echo $target?>" <?php   } ?> href="<?php  echo $nh->getLinkToCollection($cobj)?>">
			<?php  
				$ts = $cobj->getBlocks('Thumbnail Image');
				if (is_object($ts[0])) {
					$tsb = $ts[0]->getInstance();
					$thumb = $tsb->getFileObject();
					if($thumb){
					$ih->outputThumbnail($thumb, 455, 150, $title, false,true);
					}
				}
			?></a>
		</div>
		<h3><a <?php   if ($target != '') { ?> target="<?php  echo $target?>" <?php   } ?> href="<?php  echo $nh->getLinkToCollection($cobj)?>"><?php  echo $title?></a></h3>	

		<p>
			<?php  
			if(!$controller->truncateSummaries){
				echo $cobj->getCollectionDescription();
			}else{
				echo $textHelper->wordSafeShortText($cobj->getCollectionDescription(),$controller->truncateChars);
			}
			?>
		</p>
	</div>
	<div class="spacer"></div>
	<hr class="square" />
	<div class="double-spacer"></div>


<?php    } 
	if(!$previewMode && $controller->rss) { 
			$btID = $b->getBlockTypeID();
			$bt = BlockType::getByID($btID);
			$uh = Loader::helper('concrete/urls');
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="ccm-page-list-rss-icon">
				<a href="<?php  echo $rssUrl?>" target="_blank"><img src="<?php  echo $uh->getBlockTypeAssetsURL($bt, 'rss.png')?>" width="14" height="14" /></a>
			</div>
			<link href="<?php  echo BASE_URL . $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php  echo $controller->rssTitle?>" />
		<?php   
	} 
	?>

<?php   } 
	
	if ($paginate && $num > 0 && is_object($pl)) { 

		if ($pl->requiresPaging()) {
		
		$summary = $pl->getSummary();
		$c = Page::getCurrentPage();
		$pagination = $pl->getPagination();
		if ($c->getCollectionID() == 1) { 
			$base = DIR_REL . '/';
		} else {
			$base = Loader::helper('navigation')->getLinkToCollection($c);
		}
			
		Loader::element('pagination',array('pagination'=>$pagination,'base'=>$base));
	}
}
?>
