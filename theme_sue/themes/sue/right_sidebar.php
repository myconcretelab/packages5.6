<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
$t= Loader::helper('sue_theme', 'theme_sue');
?>
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

		<div class="col_8" id="content">
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
		</div>
		<div class="col_4 last right-sidebar <?php  if ($t->__hide_sidebar_on_mobile) :?>mobile-hide<?php  endif?>" id="sidebar">
			<?php  
			$as = new Area('Sidebar');
			$as->display($c);
			?>
		</div>
		<div class="clear"></div>
	</div>


<?php   $this->inc('elements/footer.php'); ?>