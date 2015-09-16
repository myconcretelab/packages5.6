<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
?>
<div id="middle">
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
	<div class="container">
		<div class="row">				
			<div id="homeheader">
				<div class="double_space"></div>
					<?php 
					/// Magic Header ////
						Loader::model('countable_area', 'theme_super_mint');
						$options = array('areaName' => 'Header Image', 'span' => 'span10 offset1');
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
			</div> <!-- #homeheader -->			
		</div>	<!-- .row -->		
		<div class="row">
			<div class="span12 content">
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
					
				</div>
			</div> <!-- #content -->
		</div> <!-- .row -->
		<div class="row">
			<div class="span12" id="under_content">
				<?php 
				$a = new Area('Under Main');
				$a->display($c);
				?>				
			</div> <!-- #under_content -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</div>



<?php   $this->inc('elements/footer.php'); ?>