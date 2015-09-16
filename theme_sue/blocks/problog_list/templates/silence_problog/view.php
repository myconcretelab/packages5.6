<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
extract($blog_settings);
    global $c;
	?>
	<style type="text/css">
		.content-sbBlog-date {background-image: url('<?php   echo $uh->getBlockTypeAssetsURL($bt, 'images/cal_'.$blog_settings['icon_color'].'.png');?>')!important;}
	</style>
	<?php   
	if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	
	<?php   
	$isFirst = true; //So first item in list can have a different css class (e.g. no top border)
	$excerptBlocks = ($controller->truncateSummaries ? 1 : null); //1 is the number of blocks to include in the excerpt
	$truncateChars = ($controller->truncateSummaries ? $controller->truncateChars : 0);
	$ih = Loader::helper('image');
	foreach ($cArray as $cobj):
		// Comments
		$comment_count = blogify::getNewCommentCount($cobj->getCollectionID());
		
		// Category
		$ak_g = CollectionAttributeKey::getByHandle('blog_category'); 
		$cat = $cobj->getCollectionAttributeValue($ak_g);
		
		// tags
		$ak_t = CollectionAttributeKey::getByHandle('tags'); 
		$tag_list = $cobj->getCollectionAttributeValue($ak_t);
		$akc = $ak_t->getController();
		if(!empty($tag_list)){
			
			$tag_string = '';
			
			foreach($tag_list as $x => $akct){
				
				if($x) $tag_string .= ', ';
				
				$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
				$tag_string .= '<a href="'.$BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().'</a>';
					
			}
		}
				
		$title = $cobj->getCollectionName();
		$date = $cobj->getCollectionDatePublic('F j, Y');
		$author = $cobj->getVersionObject()->getVersionAuthorUserName();
		$link = $nh->getLinkToCollection($cobj);
		$firstClass = $isFirst ? 'first-entry' : '';
		
//		$entryController = Loader::controller($cobj);
//		$comments = $entryController->getCommentCountString('%s '.t('Comment'), '%s '.t('Comments'));
		
		$isFirst = false;
	
		// thumbnail
		if ($imageF = $cobj->getAttribute('thumbnail')) { 
			$image = $ih->getThumbnail($imageF, $blog_settings['thumb_width'],$blog_settings['thumb_height'],true); 
		}
		
		if($use_content > 0){
			$block = $cobj->getBlocks('Main');
			foreach($block as $b) {
				if($b->getBlockTypeHandle() == 'content' || $b->getBlockTypeHandle()=='sb_blog_post'){
					$content .= $b->getInstance()->getContent();
				}
			}
		}else{
			$content = $cobj->getCollectionDescription();
		}
		?>



	<div class="entry <?php   echo $firstClass; ?>">


		<h2>
			<a href="<?php   echo $link; ?>"><?php   echo $title; ?></a>
		</h2>
		<p class="meta">
			<span class="author"><?php     echo $author ?></span>
			&nbsp;&thksim;&nbsp;
			<span class="date"><?php     echo $date; ?></span>
			<?php  if($cobj->getAttribute('tags')) : ?>
			&nbsp;&thksim;&nbsp;
			<span class="tags"><?php   echo $cobj->getAttribute('tags')?></span>
			<?php  endif ?>
			<?php  if($comments) : ?>
			&nbsp;&thksim;&nbsp;
			<span class="comment"><?php  echo $comment_count ?></span>
			&nbsp;&thksim;&nbsp;
			<?php  endif ?>
			
			<!-- Social -->
						
			<?php  
			if($tweet){
			?>
			<span  class="st_twitter"></span>
			<?php  
			}
			if($fb_like){
			?>
			<span  class="st_facebook"></span>
			<?php  
			}
			if($google){
			?>
			<span  class="st_plusone"></span>
			<?php  
			}
			?>
		</p>


		<div class="excerpt">
			<?php if($imageF) : ?>
				<img class='blog-thumbnail' src="<?php echo $image->src ?>" width="<?php echo $image->width ?>" height="<?php echo $image->height ?>"/>
			<?php endif ?>
			  		<?php
			  			if(!$controller->truncateSummaries){
							echo $content;
						}else{
							echo $texthelper->shorten($content,$controller->truncateChars);
						}
			  		?>
		</div>
		
		<hr class="space" />
		
		<p class="category meta">
			<span class="category"><?php  echo t('In category :') . $cat ?></span>

		</p>

		<a class="butn right" href="<?php   echo $link; ?>"><?php  echo t('Read full post')?></a>

		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<?php   if($sharethis){ ?>
		<script type="text/javascript">stLight.options({publisher:'<?php   echo $sharethis;?>'});</script>
		<?php   } ?>
		
	</div>
	<hr/>

	<?php   		
	endforeach;
	
	if(!$previewMode && $controller->rss) { 
			global $b;
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="rssIcon">
				<?php  echo t('Get this feed')?> &nbsp;<a href="<?php   echo $rssUrl?>" target="_blank"><img src="<?php   echo $uh->getBlockTypeAssetsURL($bt, 'rss.png')?>" width="14" height="14" /></a>
				
			</div>
			<link href="<?php   echo $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php   echo $controller->rssTitle?>" />
	<?php   
	} 
	?>
</div>
<?php   } 
	
	if ($paginate && $num > 0 && is_object($pl)) {
		$pl->displayPaging();
	}
	
?>
