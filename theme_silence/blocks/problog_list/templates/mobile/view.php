<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));
extract($blog_settings);
?>
	<style>
		.custom_style{ margin-top: 12px; text-decoration: none!important; padding: 4px 8px 6px 8px; float: right;}
		.custom_style:hover{cursor: pointer}
	</style>
	<?php       
	if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	
	<?php       
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		$title = $cobj->getCollectionName(); 
		$comment_count = blogify::getNewCommentCount($cobj->getCollectionID());
		$date = $cobj->getCollectionDatePublic();
		$thumb = $cobj->getAttribute('thumbnail');
		if($thumb){
			$fID = $thumb->getFileID();
			$thumbpath = BASE_URL.File::getRelativePathFromID($fID);
		}
		if($use_content > 0){
			$block = $cobj->getBlocks('Main');
			foreach($block as $b) {
				if($b->getBlockTypeHandle()=='content'){
					$content = $b->getInstance()->getContent();
				}
			}
		}else{
			$content = $cobj->getCollectionDescription();
		}
		?>
		     <div id="content-sbBlog-wrap">
		      	<div class="addthis_toolbox addthis_default_style">
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
				</div>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<?php       if($sharethis){ ?>
				<script type="text/javascript">stLight.options({publisher:'<?php       echo $sharethis;?>'});</script>
				<?php       } ?>
	  			<?php       if($comments){ ?>
	  			<div class="content-sbBlog-commentcount"><?php       echo $comment_count;?></div>
	  			<?php       } ?>
	  			<div id="content-sbBlog-contain">
	  				<div id="content-sbBlog-title">
			    		<h1 class="ccm-page-list-title"><a href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php       echo $title?></a></h1>
			    		<div id="content-sbBlog-date">
			    		<?php       echo date('M d, Y',strtotime($date));  ?>
			    		</div>
					</div>
					<br class="clearfloat" />
					<div class="categories" >
						<?php      
						$ak_g = CollectionAttributeKey::getByHandle('blog_category'); 
						$cat = $cobj->getCollectionAttributeValue($ak_g);
						echo t('Category').': '.$cat;
						?>
						<br/><br/>
					</div>
					<div id="content-sbBlog-post">
					<?php       
						if($thumbpath){
							echo '<div class="thumbnail">';
							print '<img src="'.$thumbpath.'" alt="mobile_photo" class="mobile_photo"/>';
							echo '</div>';
							print '<br style="clear: both;" />';
						}	
					?>
			  		<?php       
			  			if(!$controller->truncateSummaries){
							echo $content;
						}else{
							echo $texthelper->shorten($content,$controller->truncateChars);
						}
			  		?>
			  		</div>
			  	</div>
			  	<br class="clearfloat" />
			  	<a class="readmore" href="<?php       echo $nh->getLinkToCollection($cobj)?>"><?php      echo t('View Post')?></a>
			  	<div class="tags">
			  	<?php      echo t('Tags')?> : 
				<?php       
					$ak_t = CollectionAttributeKey::getByHandle('tags'); 
					$tag_list = $cobj->getCollectionAttributeValue($ak_t);
					$akc = $ak_t->getController();
					if(method_exists($akc, 'getOptionUsageArray')){
					//$tags == $tag_list->getOptions();
						if(!empty($tag_list)){
							foreach($tag_list as $akct){
								$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
								echo '<a href="'.BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().'</a>';
									
							}
						}
					}
					?>
 				</div>
			</div>
			<br class="clearfloat" />
	<?php       		
	} 
	if(!$previewMode && $controller->rss) { 
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="rssIcon">
				<?php      echo t('Get this feed')?> &nbsp;<a href="<?php       echo $rssUrl?>" target="_blank"><img src="<?php       echo $uh->getBlockTypeAssetsURL($bt, 'rss.png')?>" width="14" height="14" /></a>
				
			</div>
			<link href="<?php       echo $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php       echo $controller->rssTitle?>" />
	<?php       
	} 
	?>
</div>
<?php       } 
	
	if ($paginate && $num > 0 && is_object($pl)) {
		$pl->displayPaging();
	}
	
?>
