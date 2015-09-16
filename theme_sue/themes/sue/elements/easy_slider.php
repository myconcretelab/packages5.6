<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

		<div class="row">
			<div id="header" class="col_12 ccm_page_list_slider">
			<?php

				Loader::model('theme_sue_options', 'theme_sue');
				Loader::model('file');
				$t = new ThemeSueOptions();
				$t->set_collection_object($c);
				$t->set_toggle_option_name('slider');


				if ($t->__background_animation)
					$background =  (($t->_background_file) )  ? '"' . File::getByID($t->_background_file)->getRelativePath() . '"' : 'THEME_PATH + "/images/slider/bg2.png"' ;
				else
					$background = "''";
					
				$sliderarea = Area::getOrCreate($c, 'Header', $a->arIsGlobal);
				$ap = new Permissions($sliderarea);
				$blocksToDisplay =  $sliderarea->getAreaBlocksArray($c, $ap);
				
				$bv = new BlockView();
				
				$bv->renderElement('block_area_header_view', array('a' => $sliderarea));
				?>
								
					<div class="jq_fmslideshow" rel="<?php echo $c->cID ?>" style="position:relative; overflow:visible; background:none; height:200px;" align="left" >
					
						<div id="fmslideshow" style="visibility:hidden; text-align:center">
				
				<?php
				foreach ($blocksToDisplay as $n=>$b) :
					$bv = new BlockView();
					$bv->setAreaObject($sliderarea); 					
					$p = new Permissions($b);
					if ($p->canRead()) : ?>

							
							<div><!--Slide <?php echo $n ?> -->
								<div data-align="TL" data-spacing="0,0" data-inOutDirection="RL" data-inOutDistance="0" data-resize="true" style="width:960px; text-align:left">
								<?php // The content !
								echo $a->enclosingStart;		
								$bv->render($b);		
								echo $this->enclosingEnd;
								?>
								</div>
									
							</div><!-- / Slide <?php echo $n ?> -->
						
					<?php endif ?>
				<?php endforeach ?>
				<?php $bv->renderElement('block_area_footer_view', array('a' => $sliderarea)) ?>
						</div> <!-- fmslideshow -->
					</div> <!-- jq_fmslideshow -->

					<?php global $shadow_has_displayed; $shadow_has_displayed = true ?>
					<div class="shadow-under"></div>
					<div class="double-spacer"></div>
					<div class="double-spacer"></div>

				</div> <!-- col_12 -->				

			<script type="text/javascript">
				SLIDER_CUSTOM_SETTINGS_<?php echo $c->cID?> = {
					buttons_type : <?php echo $t->_button_style ?>,
					button_nextPrevious_type:  <?php echo $t->_button_style ?>,
					slideShow : <?php echo $t->__easy_slider_autoscroll ? 'true' : 'false' ?>,
					banner_height : '100%',
					button_nextPrevious_autoHide:false,
					button_previous_align: 'BL',
					button_next_align: 'BR',
					button_next_spacing:'-50,0',
					button_previous_spacing:'-50,0',
					dotButtons : <?php echo $t->__easy_slider_bullets ? 'true' : 'false' ?>,
					button_next_previous: <?php echo $t->__easy_slider_arrows ? 'true' : 'false' ?>,
					desktop_drag : false,
					background_move : true,
					image_background : <?php echo $background ?>,
					background_moveDistance: 800
				}
			</script>
		</div>


