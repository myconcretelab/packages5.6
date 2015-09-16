<?php  defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/*******************************************/
	/******* Customize here some option : ******/
	/*******************************************/
	
	$short_desc 	= 45; 	// from how many character the description will be cutted
	$short_title 	= 15 ; 	// same as desc but for title
	
	$thumb_size 	= 170; 	// The size of the thumbnails. If you change that, don't forget to make change in view.css
	$nav_height	= 85; 	// The height of the first level nav
	
	
	/************************************************/
	/******* End of Customization for view.php *****/
	/************************************************/
	
	$c = Page::getCurrentPage() ;
	if ($c->isEditMode()) : ?>
	
	<div class="ccm-edit-mode-disabled-item" style="height:100px">
		<div style="padding: 30px 0px 0px 0px">
			<?php      echo t('Navi Box<br />Content disabled in edit mode.')?>
		</div>
	</div>
	
	<?php
	else :	
	
	$aBlocks = $controller->generateNav();
	$c = Page::getCurrentPage();
	$containsPages = false;
	
	$th = Loader::helper('text');
	$nh = Loader::helper('navigation');
		
	//this will create an array of parent cIDs 
	$inspectC=$c;
	$selectedPathCIDs=array( $inspectC->getCollectionID() );
	$parentCIDnotZero=true;	
	while($parentCIDnotZero){
		$cParentID=$inspectC->cParentID;
		if(!intval($cParentID)){
			$parentCIDnotZero=false;
		}else{
			$selectedPathCIDs[]=$cParentID;
			$inspectC=Page::getById($cParentID);
		}
	} 	
	
	foreach($aBlocks as $ni) {
		$_c = $ni->getCollectionObject();
		if (!$_c->getCollectionAttributeValue('exclude_nav')) {
			
			
			$target = $ni->getTarget();
			
			if ($target != '') {
				$target = 'target="' . $target . '"';
			}
			if (!$containsPages) {
				// this is the first time we've entered the loop so we print out the UL tag
				echo("<ul id='nb_menu_$bID' class='nb_menu'>");
			}
			
			$containsPages = true;
			
			$thisLevel = $ni->getLevel();
			if ($thisLevel == 0 ) {

			} elseif ($thisLevel == 1) {

			} else {
				continue; // Evite les menu de 3ieme niveau et + 
			}
			
			if ($thisLevel > $lastLevel) {
				echo("<ul class='second_level_box'>");
			} else if ($thisLevel < $lastLevel) {
				for ($j = $thisLevel; $j < $lastLevel; $j++) {
					if ($lastLevel - $j > 1) {
						echo("</li></ul>");
					} else {
						echo("</li></ul></li>");
					}
				}
			} else if ($i > 0) {
				echo("</li>");
			}

			$pageLink = false;
			
			if ($_c->getCollectionAttributeValue('replace_link_with_first_in_nav')) {
				$subPage = $_c->getFirstChild();
				if ($subPage instanceof Page) $pageLink = $nh->getLinkToCollection($subPage);
			}
			
			if (!$pageLink) $pageLink = $ni->getURL();


			if ($c->getCollectionID() == $_c->getCollectionID()) {
				$selected = "nav-selected nav-path-selected";
			} elseif ( in_array($_c->getCollectionID(),$selectedPathCIDs) && ($_c->getCollectionID() != HOME_CID) ) {
				$selected = 'nav-path-selected';
			} else {
				$selected = '';
			}
			?>			
			<li class="<?php echo $selected ?>" >
				<a class="<?php echo $selected ?> nb-main" href='<?php echo  $pageLink?>' <?php $target ?> >
				<?php if ($thisLevel == 0 ) : ?>
					<?php
					$image_helper = Loader::helper('mylab_image','navi_box');
					$thumb = $_c->getAttribute('page_thumbnail') ? $image_helper->getThumbnail($_c->getAttribute('page_thumbnail')->getPath(),$thumb_size,$thumb_size,array('crop'=>true))->src : null;
					?>
					<img src="<?php echo $thumb ?>" alt=""/>
					<span class="nb_active"></span>
					<span class="nb_wrap">
						<span class="nb_title"><?php echo  $th->shorten($ni->getName(), $short_title) ?></span>
						<span class="nb_descr"><?php echo $th->shorten($ni->getDescription(), $short_desc) ?></span>
					</span>					
				<?php else : ?>
					<?php echo $ni->getName() ?>				
				<?php endif ?>
				</a>

			<?php 
			$lastLevel = $thisLevel;
			$i++;
			
			
		}
	}
	
	$thisLevel = 0;
	if ($containsPages) {
		for ($i = $thisLevel; $i <= $lastLevel; $i++) {
			echo("</li></ul>");
		}
	}


?>
<div style="clear:both"></div>
<script type="text/javascript">
     $(function() {
	 $('#nb_menu_<?php echo $bID ?> > li').NaviBox({
		thumb_width:<?php echo $thumb_size ?>,
		thumb_height:<?php echo $thumb_size ?>,
		nav_height:<?php echo $nav_height ?>
		});
     });
 </script>
<?php endif ?>
