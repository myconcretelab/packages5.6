
<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('countable_area', 'theme_sue');
$t = Loader::helper('sue_theme', 'theme_sue');

$this->inc('elements/header.php') ?>

	<hr class="demi-space">
	<div class="row">
		<?php  if ($t->__display_page_title) : ?>
			<div class="col_12" id="page-title">
					<h1 class="page-title"><?php  echo $c->getCollectionName() ?>
					<?php  if ($t->__display_page_desc) : ?>
						<small><?php  echo $c->getCollectionDescription() ?> </small>
					<?php  endif ?>					
					</h1>
			</div>
			<div class="clear"></div>
			<hr />
			<?php  endif ?>
		<div class="col_12" id="full">
			<?php  
				print $innerContent;
			?>
		</div>						
		<div class="clear"></div>
	</div>
	
<?php  if ($c->isEditMode()) : ?>
<div style="clear:both">&nbsp;</div>
<?php  endif ?>

<?php   $this->inc('elements/footer.php'); ?>
