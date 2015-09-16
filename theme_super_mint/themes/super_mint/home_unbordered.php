<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
Loader::model('theme_super_mint_options', 'theme_super_mint');
$t = new ThemeSuperMintOptions();
$t->set_collection_object($c);

$this->inc('elements/header.php');
?>
<div id="middle" class="unbordered">
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
				<div class="span12">
					<?php 
					$a = new Area('Main');
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