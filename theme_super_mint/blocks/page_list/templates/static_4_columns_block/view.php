<?php 
defined('C5_EXECUTE') or die("Access Denied.");

// --- Here start otpion for columns ---- //

$columns_number = 4;

// --- Here stop option for columns ---- //


$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
?>


	<div class="ccm-page-list">

	<?php  foreach ($pages as $key => $page):

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$img = $page->getAttribute('page_thumbnail');
			$thumb = $ih->getThumbnail($img, 1170 / $columns_number, (1170 / $columns_number) / 1.4, true);
			$big = $ih->getThumbnail($img, 1500, 1500);
		//$big = is_object($img) ? $img->getRelativePath() : '';
		?>
		<?php if ($key%$columns_number == 0) : ?><div class="row-fluid"><?php endif ?>
		<div class="span<?php echo 12 / $columns_number?>">
			<div class="page-list-block">
				<div class="mediaholder">
						<?php if ($thumb) : ?>
						<img alt="<?php echo $title ?>" src="<?php  echo $thumb->src ?>">
						<?php else : ?>
						<div class="fill" style="width:<?php echo 1170 / $columns_number ?>px; height:<?php echo intval ((1170 / $columns_number)) / 1.4 ?>px; background-color:#efefef"></div>
						<?php endif ?>
						<div class="hovercover">
							<a href="<?php  echo $url ?>" class="" title="<?php echo $title ?>" target="<?php  echo $target ?>">
								<span class="fa-stack icon-stack fa-lg p-link">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-link fa-stack-1x fa-inverse"></i>
								</span>								
							</a>
							<?php if ($thumb) : ?>
							<a href="<?php echo $big->src ?>" class="fancybox">
								<span class="fa-stack icon-stack fa-lg i-link">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
								</span>								
							</a>
							<?php endif ?>
						</div>
				</div>

				<a href="<?php  echo $url ?>">
					<div class="item-description">
						<p><?php echo $title ?></p>
						<!-- <span><?php echo  $th->shorten($description, 20)?></span> -->
					</div>
				</a>
			</div>
		</div>
		<?php if ( $key%$columns_number == ($columns_number) - 1 || ($key == count($pages)-1) ) : ?></div><?php endif ?>
	<?php  endforeach; ?>	
</div><!-- end .ccm-page-list .row-->
<div class="row">
<?php  if ($showPagination): ?>
		<div id="pagination">
			<div class="ccm-spacer"></div>
			<div class="ccm-pagination">
				<span class=""><?php  echo $paginator->getPrevious('&laquo; ') ?></span>
				<?php  echo $paginator->getPages() ?>
				<span class=""><?php  echo $paginator->getNext(' &raquo;') ?></span>
			</div>
		</div>
	<?php  endif; ?>	
</div>
