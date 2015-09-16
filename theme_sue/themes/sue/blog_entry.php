<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
$t= Loader::helper('sue_theme', 'theme_sue');

?>	<div class="row">
		<div id="header" class="col_12" style="height:212px; overflow:hidden">
			<?php  
			$a = new Area('Header Image');
			$a->display($c);
			?>
		</div>
		<div class="col_12">
			<?php 
			if ($c->isEditMode()) {
				print '<br><br>';
				$a = new Area('Thumbnail Image');
				$a->display($c);
			}
			?>
		</div>
		<div class="clear"></div>
		<div class="shadow-under"></div>
		<div class="double-spacer"></div>
	</div>

	<div class="row">
		<div class="col_5" id="page-title">
			<h1 class="page-title"><?php  echo $c->getCollectionName() ?></h1>
		</div>

		<div class="col_7 last" id="page-desc">			
			<p><?php  echo $c->getCollectionDescription() ?> </p>
		</div>

		<div class="clear"></div>
		<hr />
		<div class="spacer"></div>
		
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