<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
Loader::model('theme_super_mint_options', 'theme_super_mint');
$t = new ThemeSuperMintOptions();
$t->set_collection_object($c);
//$t->set_toggle_option_name('slider');
$t->sidebar_size = $t->sidebar_size ? $t->sidebar_size : 4;
$span_sidebar = 'span' . $t->sidebar_size;
$span_main = 'span' . ( 12 - $t->sidebar_size ) ;

$this->inc('elements/header.php');
?>
<div class="full-width-header">
	<?php 
	$a = new Area('Full_width_header');
	$a->display($c);
	?>				
</div>
<div id="middle">
	<div class="container">
		<?php if($t->__display_top_box) : ?>
		<div class="row">
			<div class="span12" id="top-page">
				<div class="row">
					<div class="span3 title">
						<?php if($t->__display_page_title) : ?><h3 class="alternate left"><?php echo $c->getCollectionName() ?></h3><?php else : ?>&nbsp <?php endif ?>
					</div>
					<div class="span5 desc">
						<?php if($t->__display_page_desc) : ?><p class=""><?php echo $c->getCollectionDescription() ?></p><?php else : ?>&nbsp <?php endif ?>
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
		<?php endif ?>
	<?php 
	/// Magic Header ////
		Loader::model('countable_area', 'theme_super_mint');
		$options = array('areaName' => 'Header', 'span' => 'span12');
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

		<div class="row">
			<div class="<?php echo $span_sidebar ?> sidebar" id="left-sidebar">
				<div class="padding">
					<?php
					$a = new Area('Sidebar');
					$a->display($c);
					?>
				</div> <!-- .padding -->
			</div> <!-- .span4 #sidebar -->
			<div class="<?php echo $span_main ?>">
				<div class="content">
				<?php if(Page::getCurrentPage()->getAttribute('ribbon_text')) :?>
					<div class="sm_ribbon">
						<h2><?php echo Page::getCurrentPage()->getAttribute('ribbon_text') ?></h2>
						<div class="sm_ribbon_bottom"></div>
					</div> <!-- #sm_ribbon -->
				<?php endif ?>
					<div class="padding">
						<?php 
						$a = new Area('Main');
						$a->display($c);
						?>				
					</div> <!-- .padding -->
				</div> <!-- #content -->
				<div id="under-main">
					<?php 
					$a = new Area('Under Main');
					$a->display($c);
					?>						
				</div> <!-- #under-main -->
			</div> <!-- .span8 -->
		</div> <!-- .row -->			
	</div> <!-- .container -->
</div> <!-- #middle -->



<?php   $this->inc('elements/footer.php'); ?>