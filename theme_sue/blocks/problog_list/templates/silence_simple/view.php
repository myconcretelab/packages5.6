<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
extract($blog_settings);
if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	
	<?php   
	for ($i = 0; $i < count($cArray); $i++ ) {
		$cobj = $cArray[$i]; 
		$title = $cobj->getCollectionName(); 
		$comment_count = blogify::getNewCommentCount($cobj->getCollectionID());
		$date = $cobj->getCollectionDatePublic();
		$imgHelper = Loader::helper('image'); 
		$imageF = $cobj->getAttribute('thumbnail');
		if($imageF){
			$image = $imgHelper->getThumbnail($imageF, $thumb_width,$thumb_height)->src;
		}
		if($use_content > 0){
			$block = $cobj->getBlocks('Main');
			foreach($block as $b) {
				if($b->getBlockTypeHandle()=='content' || $b->getBlockTypeHandle()=='sb_blog_post'){
					$content = $b->getInstance()->getContent();
				}
			}
		}else{
			$content = $cobj->getCollectionDescription();
		}
		?>
		     <div class="content-sbBlog-wrap">
		      	<div class="addthis_toolbox addthis_default_style">
					<?php   
					if($tweet>0){
					?>
						<span class="st_twitter"></span>
					<?php   }
					if($fb_like==1){
					?>
						<span class="st_facebook"></span>
					
					<?php  
					}
					if($google==1){
					?>
						<span class="st_plusone"></span>
					<?php  
					}
					?>
				</div>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<?php   if($sharethis){ ?>
				<script type="text/javascript">stLight.options({publisher:'<?php   echo $sharethis;?>'});</script>
				<?php   } ?>
				<?php   if($comments){ ?>
	  			<div class="content-sbBlog-commentcount"><?php   echo $comment_count;?></div>
	  			<?php   } ?>
	  			<div class="content-sbBlog-contain">
	  				<div id="content-sbBlog-title">
			    		<h3 class="ccm-page-list-title"><a href="<?php   echo $nh->getLinkToCollection($cobj)?>"><?php   echo $title?></a></h3>
			    		<div id="content-sbBlog-date">
			    		<?php   echo date('M d, Y',strtotime($date));  ?>
			    		</div>
					</div>
					<div>
					<?php  
					$ak_g = CollectionAttributeKey::getByHandle('blog_category'); 
					$cat = $cobj->getCollectionAttributeValue($ak_g);
					echo t('Category').': '.$cat;
					?>
					<br/><br/>
					</div>
					<div class="content-sbBlog-post">
					<?php   
						if($imageF!=''){
							echo '<div class="thumbnail">';
							echo '<img src="'.$image.'"/>';
							echo '</div>';
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
			  	<a class="readmore" href="<?php   echo $nh->getLinkToCollection($cobj)?>"><?php  echo t('Read More')?></a>
			  	<div id="tags">
			  	<b><?php  echo t('Tags')?> : </b>
				<?php   
				$ak_t = CollectionAttributeKey::getByHandle('tags'); 
				$tag_list = $cobj->getCollectionAttributeValue($ak_t);
				$akc = $ak_t->getController();
				//$tags == $tag_list->getOptions();
				if(!empty($tag_list)){
					foreach($tag_list as $akct){
						if($x){echo ', ';}
						$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
						echo '<a href="'.BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().'</a>';
						$x++;
							
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
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	prettyPrint();
});
/*]]>*/
</script>