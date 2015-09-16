<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$textHelper = Loader::helper("text"); 
Loader::model('file_list');
Loader::model('file_set');
Loader::library('file/types');
$i = Loader::helper('image');
Loader::model('portfolio_options','fileset_portfolio');

extract(PortfolioOptions::load()); // Assign a variable for each options
if ($description == '' && $title == '' ) { };
$options = explode(',',$options);
if (count($cArray) > 0) {

$themePath = DIR_REL . '/packages/fileset_portfolio/blocks/page_list/templates/fileset_portfolio';
?>
<script type="text/javascript" src="<?php echo $themePath?>/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php echo $themePath?>/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?php echo $themePath?>/cloud-zoom.1.0.2.js"></script>

<div class="portfolio-list" id="portfolio-list-<?php echo $bID?>">
<!-- <a href="#" class="switch_thumb">Switch Display</a> -->
	<?php 
	foreach ($cArray as $cObj) :

		// Pages stuffs
		$target = $cObj->getAttribute('nav_target');
		$title = $textHelper->entities($cObj->getCollectionName());
		$link = $nh->getLinkToCollection($cObj);

		// Images stuffs
		$maxsizes['tw'] = $maxsizes['th'] = 0;
		if ($displayType == 'fileset') :
			$portfolioID = $cObj->getAttribute('folio_group');
			if ($portfolioID) :
				$fs = FileSet::getByID($portfolioID);
				if(is_object($fs)) :
					$fl = new FileList();
					$fl->filterBySet($fs);
					$fl->filterByType(FileType::T_IMAGE);
					$files = $fl->get($maxPicture,$indexPicture);
					if (!count($files)) {
						// Image de substitution
						$files =  $page_thumb ? array($page_thumb) : array (File::getByID($blankFileID)) ;
					};
				else :
					// Image de substitution
					$files =  $page_thumb ? array($page_thumb) : array (File::getByID($blankFileID)) ;
				endif;
			endif;
		else: // page_thumb
			$page_thumb = $cObj->getAttribute('page_thumbnail');
			$files =  $page_thumb ? array($page_thumb) : array (File::getByID($blankFileID)) ;
			$portfolioID = $files[0]->fID;
		endif;

		if ($cObj->getCollectionPointerExternalLink() != '') {
			if ($cObj->openCollectionPointerExternalLinkInNewWindow()) {
				$target = "_blank";
			}
		}
		$target = ($target != '') ?  "target='$target?>'" : ''		
		?>
	
	
		<div class="item" id="item-<?php echo $portfolioID ?>">
			<div class="thumb_wrapper">
				<div class="thumb">					
					<ul>
					<?php foreach ($files as $fObj) : 
						$sizes = @getimagesize($fObj->getPath());
						$img_thumb_size = $i->getThumbnail($fObj,$thumbWidth,$thumbHeight == 'auto' ? $thumbWidth : $thumbHeight, true);
						//var_dump($img_thumb_size['width']);
						if (!$img_thumb_size->src) continue;
						$img_full_size =  $i->getThumbnail($fObj,$sizes[0],$sizes[1]);
						$maxsizes['tw'] = $maxsizes['tw'] < $img_thumb_size->width ? $img_thumb_size->width : $maxsizes['tw'];
						$maxsizes['th'] = $maxsizes['th'] < $img_thumb_size->height ? $img_thumb_size->height : $maxsizes['th'];
						?>	<li>
							<a rev="group_<?php echo $portfolioID?>" rel="zoomHeight:'<?php echo $zoomHeight ?>' , zoomWidth:'<?php echo $zoomWidth ?>', adjustX: <?php echo $adjustX ?>, adjustY:<?php echo $adjustY ?>, position:'<?php echo $position ?>'<?php if (in_array('tint',$options)) {?>,tint:'<?php echo $tint_color?>', tintOpacity:<?php echo $tintOpacity ?> <?php } ?> <?php if (!in_array('tint',$options) && in_array('softFocus',$options)) {?> , softFocus:true<?php } ?>, lensOpacity:<?php echo $lensOpacity ?>, smoothMove:<?php echo $smoothMove?>, showTitle:<?php echo in_array('showTitle', $options) ? 'true' : 'false'?>, titleOpacity:<?php echo $titleOpacity ?>" class='cloud-zoom' href="<?php echo $img_full_size->src?>">
								<img src="<?php echo $img_thumb_size->src ?>" alt="<?php echo $fObj->getTitle()?>" width="<?php echo $img_thumb_size->width ?> " height="<?php echo $img_thumb_size->height?>" />
							</a>
						</li>
					<?php endforeach ?>
					</ul>
				</div>
				<?php if ($displayType == 'fileset') : ?>
				<a class="prev" href="#"></a>
				<a class="next" href="#"></a>
				<?php endif ?>
				<span><?php echo $textUnderDesc?></span>
			</div>
			<div class="description">
				<?php if (in_array('title',$options)) : ?><h3 class="portfolio-title"><a <?php echo $target ?> href="<?php echo $link ?>"><?php echo $title?></a></h3><?php endif?>
				<?php if (in_array('description',$options)) : ?>
				<p>
					<?php 
					if(!$controller->truncateSummaries){
						echo $textHelper->entities($cObj->getCollectionDescription());
					}else{
						echo $textHelper->entities($textHelper->shorten($cObj->getCollectionDescription(),$controller->truncateChars));
					}
					?>				
				</p>
				<?php endif ?>
				<?php if ($buttonText != '') : ?><a <?php echo $target ?> href="<?php echo $link ?>" class='button'><?php echo $buttonText ?></a><?php endif ?>
			</div>
		</div>
		<style type="text/css">
			#item-<?php echo $portfolioID ?> .thumb { /* The thumbnail window */
				width:<?php echo $maxsizes['tw']?>px;
				height:<?php echo $maxsizes['th']?>px;
			}
			#item-<?php echo $portfolioID ?> .thumb ul { /* The thumbnails slider */
				height:<?php echo $maxsizes['th'] ?>px;
			}
			#item-<?php echo $portfolioID ?> .thumb_wrapper{
				width:<?php echo $maxsizes['tw'] + 90 ?>px;
				height:<?php echo $maxsizes['th'] ?>px;
			}			
		</style>
<?php   endforeach; ?>



	<?php if(!$previewMode && $controller->rss) :
			$btID = $b->getBlockTypeID();
			$bt = BlockType::getByID($btID);
			$uh = Loader::helper('concrete/urls');
			$rssUrl = $controller->getRssUrl($b);
			?>
			<div class="ccm-page-list-rss-icon">
				<a href="<?php echo $rssUrl?>" target="_blank"><img src="<?php echo $uh->getBlockTypeAssetsURL($bt, 'rss.png')?>" width="14" height="14" alt="<?php  echo t('RSS Icon')?>" title="<?php  echo t('RSS Feed')?>" /></a>
			</div>
			<link href="<?php echo BASE_URL . $rssUrl?>" rel="alternate" type="application/rss+xml" title="<?php echo $textHelper->entities($controller->rssTitle)?>" />
		<?php  
	endif;
	?>
</div>
<?php  } 
	
	if ($paginate && $num > 0 && is_object($pl)) {
		$pl->displayPaging();
	}	
?>
<?php if (false) : ?>
<style type="text/css">
/* N'apporte pas de réelle plus-value à la présentation et apporte des problèmes de z-index pour la fenetre de pré-visualisation
#portfolio-list-<?php echo $bID?> .thumb_view { width: <?php echo $thumbWidth + 100 ?>px !important; clear:none }
#portfolio-list-<?php echo $bID?> .thumb_view h2 { display: inline; text-align:center }
#portfolio-list-<?php echo $bID?> .thumb_view  p{ display: none; }
#portfolio-list-<?php echo $bID?> .thumb_view .content_block a img { margin: 0 0 10px; }
#portfolio-list-<?php echo $bID?> .clear {display:none}
*/
</style>
<?php endif ?>
<script type="text/javascript">
$(function() {
<?php if (in_array('lightbox', $options)) : ?>
	$(".cloud-zoom",'#portfolio-list-<?php echo $bID?>').fancybox({
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'none',
		'speedIn'	: 600,
		'speedOut'	: 200,
		'overlayShow'	: true,
		'overlayColor'	: '#000',
		'cyclic'	: true,
		'easingIn'	: 'easeInOutExpo'
	});
	$(".mousetrap", '#portfolio-list-<?php echo $bID?>').live('click',function(){
		$(this).prev().trigger('click');
	});
<?php endif ?>
<?php if (false) : ?>
/*
    $("a.switch_thumb").toggle(function(){
        $(this).addClass("swap");
        $('.item', '#portfolio-list-<?php echo $bID?>').fadeOut("fast", function() {
            $(this).fadeIn("fast").addClass("thumb_view");
        });
    }, function () {
        $(this).removeClass("swap");
        $('.item', '#portfolio-list-<?php echo $bID?>').fadeOut("fast", function() {
            $(this).fadeIn("fast").removeClass("thumb_view");
        });
    }); 
*/
<?php endif ?>

<?php if ($displayType == 'fileset') : ?>
	$('.thumb > ul', '#portfolio-list-<?php echo $bID?>').filesetPortfolio();
<?php endif ?>
});
 

</script>