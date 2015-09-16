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
		//$big = $ih->getThumbnail($img, 1500, 1500)->src;

		$big = is_object($img) ? $img->getRelativePath() : '';

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
	<div>
		<div class="carousel-page-list carousel-item">
			<div class="padding">
				<?php if ($thumb) : ?>
		        <a class="fancybox" href="<?php echo $big ?>"><!-- end opening tag -->
		        	<img src="<?php  echo $thumb->src ?>" alt="responsive lightbox" width="<?php echo $thumb->width ?>" height="<?php echo $thumb->height ?>" />
				</a>
					
					<!-- <a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><img src="<?php  echo $thumb->src ?>" width="<?php  echo $thumb->width ?>" height="<?php  echo $thumb->height ?>" alt="" /></a>  -->
				<?php endif ?>
				<a href="<?php  echo $url ?>" target="<?php  echo $target ?>" class="button button-block button-flat-primary button-large">
					<?php  echo $title ?>
				</a>
				<p><?php  echo $description ?></p>
				<!-- <a class="btn" href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo t('Read more..') ?> <i class="icon-arrow-right"></i></a> -->
				<!-- <div class="clear"></div> -->
			</div>	
		
		</div>
		<div class="space"></div>
	</div>	
	<?php  endforeach; ?>
 
</div><!-- end .ccm-page-list -->
