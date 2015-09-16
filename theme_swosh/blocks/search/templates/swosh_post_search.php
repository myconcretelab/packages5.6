<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php  if (isset($error)) { ?>
	<?php echo $error?><br/><br/>
<?php  } ?>
<div class="whitebox">
	<form action="<?php echo $this->url( $resultTargetURL )?>" method="get" class="blog_form" id="swosh_form">
	
	<?php  if(strlen($query)==0){ ?>
		<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php  } else if (is_array($_REQUEST['search_paths'])) { 
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
		<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php   }
	} ?>
	
	<input name="query" type="text" value="<?php echo htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" placeholder="<?php echo t('Search into blog')?>" />
	
	<input name="submit" type="submit" value="<?php echo $buttonText?>" class="ccm-search-block-submit" />

<?php  
$tt = Loader::helper('text');
if ($do_search) {
	if(count($results)==0){ ?>
		<h4 style="margin-top:32px"><?php echo t('There were no results found. Please try another keyword or phrase.')?></h4>	
	<?php  }else{ 
		$th = Loader::helper('text');
		$ih = Loader::helper('image');
		$nh = Loader::helper('navigation');
		foreach($results as $r) :
					$page = Page::getByID($r->cID);
					$title = $th->entities($page->getCollectionName());
					$url = $nh->getLinkToCollection($page);
					$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
					$target = empty($target) ? '_self' : $target;
					$description = $page->getCollectionDescription();
					$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
					$description = $th->entities($description);	
					
					//Other useful page data...
					$date = date('F j, Y', strtotime($page->getCollectionDatePublic()));
					//$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();
					$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
					$img = $page->getAttribute('page_thumbnail');
					$thumb = $ih->getThumbnail($img, 630, 300, true);
			?>
			  	<section class="post">
			      <h2><?php  echo $title ?></h2>
			      <p class="meta"> 
			      <span class="left"><?php echo ('Date:')?> <strong><?php echo $date?></strong></span> 
			      <span class="left"><?php echo t('posted by')?> <strong><?php echo $original_author?></strong></span>
			      <!-- <span class="left tags">on <a href="#" rel="tag">photography</a>, <a href="#" rel="tag">Artistic</a>, <a href="#" rel="tag">Beauty and Art</a></span> <span class="left comment"> <a href="#" title="">46 Comments</a></span> </p> -->
			      <a href="<?php  echo $url ?>"><img src="<?php echo $thumb->src?>" alt="" target="<?php  echo $target ?>"/></a>
			      <?php  echo $description ?>
			      <!-- <h4>Tags: <a href="#">Seo</a> &loz; <a href="#">Print</a> &loz; <a href="#">Design</a></h4> -->
			      <a href="<?php  echo $url ?>" class="buttonhome" target="<?php  echo $target ?>">&rarr; <?php echo t('more')?></a> 
			    </section>
		<?php  	endforeach //foreach search result ?>
		
		<?php 
		if($paginator && strlen($paginator->getPages())>0){ ?>	
		<div class="ccm-pagination">	
			 <span class="ccm-page-left"><?php echo $paginator->getPrevious()?></span>
			 <?php echo $paginator->getPages()?>
			 <span class="ccm-page-right"><?php echo $paginator->getNext()?></span>
		</div>	
		<?php  } ?>

	<?php 				
	} //results found
} 
?>
</div>
</form>
<div class="blankSeparator"></div>