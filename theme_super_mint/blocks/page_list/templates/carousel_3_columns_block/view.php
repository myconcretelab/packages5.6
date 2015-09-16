<?php 
defined('C5_EXECUTE') or die("Access Denied.");

// --- Here start otpion for columns ---- //

$max_columns_number = 3;
$min_columns_number = 2;

// --- Here stop option for columns ---- //


$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); 
?>

<div class="ccm-page-list bxslider ccm-page-list-3d" data-carousel="true" data-maxslides="<?php echo $max_columns_number ?>" data-minslides="<?php echo $min_columns_number ?>" data-slidewidth="<?php echo (1170 / $max_columns_number) ?>">

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
		$thumb = $ih->getThumbnail($img, 1170 / $max_columns_number, (1170 / $max_columns_number) /2, true);
		$big = $ih->getThumbnail($img, 1500, 1500);

		//$big = is_object($img) ? $img->getRelativePath() : '';

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
			<div class="page-list-block">
				<div class="mediaholder">
					
						<img alt="<?php echo $title ?>" src="<?php  echo $thumb->src ?>">
						<div class="hovercover">
							<a href="<?php  echo $url ?>" class="" title="<?php echo $title ?>" target="<?php  echo $target ?>">
								<span class="fa-stack icon-stack p-link">
								  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
								  <i class="fa-stack-1x fa-inverse fa fa-link icon-light"></i>
								</span>
							</a>
							<a href="<?php echo $big->src ?>" class="fancybox">
								<span class="fa-stack icon-stack i-link">
								  <i class="fa fa-circle fa-stack-2x icon-circle icon-stack-base"></i>
								  <i class="fa-stack-1x fa-inverse fa fa-picture-o icon-light"></i>
								</span>
							</a>
						</div>
				</div>

				<a href="<?php  echo $url ?>">
					<div class="item-description">
						<p><?php echo $title ?></p>
						<!-- <span><?php echo  $th->shorten($description, 20)?></span> -->
					</div>
				</a>
			</div>
	<?php  endforeach; ?>
 
</div><!-- end .ccm-page-list -->
