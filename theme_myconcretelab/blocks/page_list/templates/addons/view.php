<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$k = 0;
$c = Page::getCurrentPage();
$th = Loader::helper('text');
$ih = Loader::helper('image'); 
$cats = array(array('name' => 'Freebies', 'handle' => 'free'));
$pageCats = array();
$test = array('free' => 0);

$large_columns_number = 4;
$small_columns_number = 2;

foreach ($pages as $n => $page):
	if ($page->getAttribute('free'))  :
		$test['free'] ++;
		$pageCats[$page->getCollectionID()] .= ('free ');
	endif;
	if ($page->getAttribute('related_content_category')) :
		foreach($page->getCollectionAttributeValue('related_content_category') as $k => $opt) {
			// Les classes pour les elements
			$handle = $th->sanitizeFileSystem($opt);
			// On ajoute les classe pour chaque page
			$pageCats[$page->getCollectionID()] .= ($handle . ' ' );
			// Le key
			// On teste si on a déjà cette option
			// Et on compte le nombre d'elus
			if (array_key_exists($handle, $test)) : 
				$test[$handle] ++;
				continue;
			endif;
			// SI on a pas on l'ajout à la liste des options dispo
			$test[$handle] = 1;
			$i = $n . $k;
			$cats[$i]['name'] = (string)$opt;
			$cats[$i]['handle'] = $th->sanitizeFileSystem($opt);	
		}
	endif ;
endforeach;

?>
	<div class="row">
		<div class="filter-panel columns large-12">
		<?php if (count($cats)) : ?>
			<ul class="option-set" data-option-key="filter">
			  <li><a href="#show-all" data-option-value="*" class="selected rounded"><strong><?php echo t('show all')?></strong></a></li>
			  <?php foreach ($cats as $cat): ?>
			  <li><a class="rounded" href="#<?php     echo  $th->entities($cat['handle'])?>" data-option-value=".<?php echo  $cat['handle']?>"><?php echo  $th->entities($cat['name'])?> <small><?php echo $test[$cat['handle']] ?></small></a></li>
			  <?php endforeach ?>
			</ul>
		<?php endif ?>
		</div>	
	</div>
	<div class="divider-xl"></div>
<section class="addon-pl" role="Product Addon">

	<div class="row" style="position:relative" id="addon-pl" >
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
		$img = $page->getAttribute('thumb');
		$thumb = $ih->getThumbnail($img, 300, 300);
		$category = $pageCats[$page->getCollectionID()]; 
	 ?>
		<!-- <?php if ($k%$large_columns_number == 0) : ?><div class="row"><?php endif ?> -->
		<div class="large-<?php echo 12 / $large_columns_number?> small-<?php echo 12 / $small_columns_number?> columns item  <?php if ($category) : echo $category ; endif ?>" >	 
			<?php if ($page->getAttribute('new')) : ?>
			<div class="ribbon new">New</div>
			<?php elseif ($page->getAttribute('free')) : ?>
			<div class="ribbon free">Free</div>
			<?php elseif ($page->getAttribute('reloaded')) : ?>
			<div class="ribbon info">Reloaded</div>
			<?php endif ?>
			<figure>
				
				<a class="figure" href="<?php  echo $url ?>">
					<img src="<?php  echo $thumb->src ?>" alt="Concrete5 theme <?php echo $title ?>">
				</a>
				<h4 class="divider-box shift"><a href="<?php  echo $url ?>" target="<?php  echo $target ?>"><?php  echo $title ?><?php if (!$category) : echo " ! " ; endif ?></a></h4>
				<p class="small shift"><?php  echo $description ?></p>
			</figure>
		</div>
	<!--	<?php if ( $k%$large_columns_number == ($large_columns_number) - 1 || ($k == count($pages)-1) ) : ?></div><?php endif ?>  -->
	<?php
		$k ++;  
		endforeach; ?>
		</div>
</section><!-- .mac -->

<script>
$(document).ready(function(){
	var $container = $('#addon-pl');
	$container.isotope({
	  // options
	  itemSelector : '.item',
	  resizable: false, // disable normal resizing
	  // set columnWidth to a percentage of container width
	  masonry: { columnWidth: $container.width() / 4 } 
	});
     var $optionSets = $('.option-set'),
         $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
	      // otherwise, apply new options
	      $container.isotope( options );
        
        return false;
	      });
	$(window).smartresize(function(){
	  $container.isotope({
	    // update columnWidth to a percentage of container width
	    masonry: { columnWidth: $container.width() / 4 }
	  });
	});      
});	
</script>