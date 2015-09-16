<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
Loader::model('theme_super_mint_options', 'theme_super_mint');
$t = new ThemeSuperMintOptions();
$t->set_collection_object($c);
$t->sidebar_size = $t->sidebar_size ? $t->sidebar_size : 4;
$span_sidebar = 'span' . $t->sidebar_size;
$span_main = 'span' . ( 12 - $t->sidebar_size ) ;

$this->inc('elements/header.php');
?>
<div id="middle_unbordered" class="unbordered">
	<?php if($t->__display_top_box) : ?>
	<div id="top-page">
		<div class="container" id="">
			<div class="row">
				<div class="span12" id="page-top-unbordered">
					<div class="row">
						<div class="span3 title">
							<?php if($t->__display_page_title) : ?><h3 class="alternate left"><?php echo $c->getCollectionName() ?></h3><?php else : ?>&nbsp <?php endif ?>
						</div>
						<div class="span5 desc">
							<?php if($t->__display_page_desc) : ?><p class="tiny"><?php echo $c->getCollectionDescription() ?></p><?php else : ?>&nbsp <?php endif ?>
						</div>
						<?php if($t->__display_breadcrumb) : ?>
						<div class="span4 bread">
							<?php
								$bt_main = BlockType::getByHandle('autonav');
								$bt_main->controller->displayPages = 'top';
								$bt_main->controller->orderBy = 'display_asc';                  
								$bt_main->controller->displaySubPages = 'relevant_breadcrumb';
								$bt_main->controller->displaySubPageLevels = 'enough';
								$bt_main->render('templates/supermint_breadcrumb');			
							?>					
						</div> <!-- .span4 -->
						<?php endif ?>
					</div> <!-- .row -->
				</div> <!-- .span12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- #top-page -->
	<?php endif ?>
	<div id="header_unbordered">
	<?php 
		/// Magic Header ////
		Loader::model('countable_area', 'theme_super_mint');
		$options = array('areaName' => 'Header', 'span' => '');
		$header = new CountableArea($options['areaName']);
		if ($c->isEditMode()) :
		
			$this->inc('elements/header_area.php',$options);
		
		elseif ($header->getTotalBlocksInArea($c) > 0 ) :
			if ($c->getAttribute('easy_slider') ) {
				$this->inc('elements/easy_slider.php',$options);
			} else {
				$this->inc('elements/header_area.php',$options);
			}
		endif;
		/// / Magic Header ////
	?>
		<div id="under_header_unbordered">
			<div class="container">
				<!-- <div class="row"> -->
				<?php 
				$a = new Area('Under_header');
				$a->display($c);
				?>	
				<!-- </div> <!-- .row -->						
			</div> <!-- .container -->
		</div>	<!-- .under_header_unbordered -->
	</div> <!-- #header_unbordered -->

	<!-- End header -->
	
	<div id="main_unbordered">
		<div class="container">
			<div class="row">
				<div class="<?php echo $span_main ?>">
					<?php 
					$a = new Area('Main');
					$a->display($c);
					?>				
				</div> <!-- .span12 -->
				<div class="<?php echo $span_sidebar ?>">
					<?php 
					$a = new Area('Sidebar');
					$a->display($c);
					?>				
				</div> <!-- .span12 -->
			</div> <!-- .row -->			
		</div> <!-- .container -->			
	</div> <!-- #main_unbordered -->
	
	<!-- Under main unbordered -->
	
	<div id="under_main_unbordered">	
		<div class="container">
			<div class="row">
				<div class="span12">
					<?php 
					$a = new Area('Under Main');
					$a->display($c);
					?>						
				</div> <!-- .span12 -->
			</div> <!-- .row -->			
		</div> <!-- .container -->			
	</div> <!-- .under_main_unbordered -->
</div> <!-- #middle -->



<?php   $this->inc('elements/footer.php'); ?>