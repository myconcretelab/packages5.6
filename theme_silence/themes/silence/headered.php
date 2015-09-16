<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

$t = Loader::helper('mylab_theme', 'theme_silence');

$this->inc('elements/header.php'); ?>

		<div class="row">
			<div class="content <?php      if (!$t->__header_transparent) :?>white rounded<?php      endif ?> <?php      if ($t->__header_padding) :?>padding-inner <?php      endif?> <?php      if ($t->__header_shadow) :?>shadow<?php      endif?>">
				<div id="header" class="col_12">
					<?php      
					$a = new Area('Header');
					$a->display($c);
					?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="row">
			<div id="sub-header" class="col_12">
				<?php      
				$a = new Area('Sub Header');
				$a->display($c);
				?>				
			</div>
		</div>
	</div>
</div>

<?php     
Loader::model('countable_area', 'theme_silence');
$a = new CountableArea('Main');
if (($t->__display_main_area && $a->getTotalBlocksInArea($c) > 0) || $c->isEditMode()) : ?>

<div id="middle" style="margin-top:0">
	<div class="container">
		<div class="row">
			<div class="content padding-inner white shadow">
				<div class="col_12" id="full">
					<?php      					
					$a->display($c);
					?>
				</div>						
			</div>
		</div>
	</div>
</div>
<?php      endif ?>
<div id="bottom">
	<div class="container">
		<div class="row">
			<div class="col_12" id="without-frame">
				<?php      
				$wf = new Area('Without Frame');
				$wf->display($c);
				?>
			</div>
		</div>
	</div>
</div>
<?php      if ($c->isEditMode()) : ?>
<div style="clear:both">&nbsp;</div>
<?php      endif ?>


<?php       $this->inc('elements/footer.php'); ?>