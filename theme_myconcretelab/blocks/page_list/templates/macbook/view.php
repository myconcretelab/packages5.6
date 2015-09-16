<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$k = 0;
$c = Page::getCurrentPage();
$th = Loader::helper('text');
$ih = Loader::helper('image'); 
$large_columns_number = 3;
$small_columns_number = 2;

?>

<section class="mac-pl" role="Product Theme">

	<?php  foreach ($pages as $key => $page):


		// Prepare data for each page being listed...
		if ($page->cID == $c->cID) continue;
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$img = $page->getAttribute('page_thumbnail');
		$thumb = $ih->getThumbnail($img, 300, 190, true);
	 ?>
		 <?php if ($k%$large_columns_number == 0) : ?><div class="row"><?php endif ?> 
		<div class="large-<?php echo 12 / $large_columns_number?> small-<?php echo 12 / $small_columns_number?> columns">	 
			<figure>
				
				<a href="<?php  echo $url ?>">
					<img src="<?php  echo $thumb->src ?>" alt="Concrete5 theme <?php echo $title ?>">
				</a>
			</figure>
			<h4 class="divider-box shift"><a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?></a></h4>
			<p class="small shift"><?php  echo $description ?></p>
		</div>
		<?php if ( $k%$large_columns_number == ($large_columns_number) - 1 || ($k == count($pages)-1) ) : ?></div><?php endif ?> 
	<?php
		$k ++;  
		endforeach; ?>
</section><!-- .mac -->
