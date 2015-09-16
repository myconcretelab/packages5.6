<?php      
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div id="blog-index">
	<?php       
	$isFirst = true; //So first item in list can have a different css class (e.g. no top border)
	$excerptBlocks = ($controller->truncateSummaries ? 1 : null); //1 is the number of blocks to include in the excerpt
	$truncateChars = ($controller->truncateSummaries ? $controller->truncateChars : 0);
	foreach ($cArray as $cobj):
		$title = $cobj->getCollectionName();
		$date = $cobj->getCollectionDatePublic('F j, Y');
		$author = $cobj->getVersionObject()->getVersionAuthorUserName();
		$link = $nh->getLinkToCollection($cobj);
		$firstClass = $isFirst ? 'first-entry' : '';
		
		$entryController = Loader::controller($cobj);
		$comments = $entryController->getCommentCountString('%s '.t('Comment'), '%s '.t('Comments'));
		
		$isFirst = false;
	?>
	<div class="entry <?php       echo $firstClass; ?>">
		<h2>
			<a href="<?php       echo $link; ?>"><?php       echo $title; ?></a>
		</h2>
		<p class="meta">
			<span class="author"><?php         echo $author ?></span>
			&nbsp;&thksim;&nbsp;
			<span class="date"><?php         echo $date; ?></span>
			<?php      if($cobj->getAttribute('tags')) : ?>
			&nbsp;&thksim;&nbsp;
			<span class="tags"><?php       echo $cobj->getAttribute('tags')?></span>
			<?php      endif ?>
			<?php      if($comments) : ?>
			&nbsp;&thksim;&nbsp;
			<span class="comment"><?php      echo $comments ?></span>
			<?php      endif ?>
			
		</p>
		<div class="excerpt">
			<?php      
			$a = new Area('Main');
			$a->disableControls();
			$a->display($cobj);
			?>
		</div>
		<div class="meta">
			<?php       echo $comments; ?>
			<div class="clear"></div>
			<a class="butn right" href="<?php       echo $link; ?>"><?php      echo t('Read full post')?></a>
		</div>
	</div>
	<hr/>
	<?php       endforeach; ?>
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
