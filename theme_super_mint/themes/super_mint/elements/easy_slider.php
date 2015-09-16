<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="row">
	<div id="" class="<?php echo $span ?>">
		<div class="bxslider" data-video="true">
	<?php

		Loader::model('theme_super_mint_options', 'theme_super_mint');
		Loader::model('file');
		$t = new ThemeSuperMintOptions();
		$t->set_collection_object($c);
		$t->set_toggle_option_name('slider');
			
		$sliderarea = Area::getOrCreate($c, $areaName, $a->arIsGlobal);
		$ap = new Permissions($sliderarea);
		$blocksToDisplay =  $sliderarea->getAreaBlocksArray($c, $ap);
		
		$bv = new BlockView();
		
		$bv->renderElement('block_area_header_view', array('a' => $sliderarea));
		?>
		<?php
		foreach ($blocksToDisplay as $n=>$b) :
			$bv = new BlockView();
			$bv->setAreaObject($sliderarea); 					
			$p = new Permissions($b);
			if ($p->canRead()) : ?>

					
					<div><!--Slide <?php echo $n ?> -->
						<?php // The content !
						echo $a->enclosingStart;		
						$bv->render($b);		
						echo $this->enclosingEnd;
						?>							
					</div><!-- / Slide <?php echo $n ?> -->
				
			<?php endif ?>
		<?php endforeach ?>
		<?php $bv->renderElement('block_area_footer_view', array('a' => $sliderarea)) ?>
		</div> <!-- .bxslider -->
	</div> <!-- <?php echo $span ?> -->				
</div> <!-- .row -->


