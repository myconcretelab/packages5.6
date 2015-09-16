<?php      defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
$t = Loader::helper('mylab_theme', 'theme_silence');
$c = Page::getCurrentPage();

?>
	</div>
</div>
<div id="middle">
	<div class="container">
			<div class="row">
				<div class="content padding-inner white shadow">
					<?php      if ($t->__display_page_title || $t->__display_page_desc || $t->__display_breadcrumb) : $header = true ;?>
					<div class="col_7" id="page-title">
					<?php      if ($t->__display_page_title) : ?>
						<h1 class="page-title"><?php      echo $c->getCollectionName() ?></h1>
					<?php      endif ?>
					<?php      if ($t->__display_page_desc) : ?>
						<p><?php      echo $c->getCollectionDescription() ?> </p>
					<?php      endif ?>
					</div>	
					<div class="col_5 last" id="breadcrumb">
					<?php      if ($t->__display_breadcrumb) : ?>
						<div id="inner-breadcrumb"><?php      $t->output_breadcrumb() ?></div>				
					<?php      endif ?>
					</div>
					<div class="clear"></div>
					<div class="col_12">
						<hr />
					</div>
					<div class="clear"></div>
					<?php      endif ?>
					<!--
					<div class="col_4 <?php      if ($t->__hide_sidebar_on_mobile) :?>mobile-hide<?php      endif?>" id="sidebar">
						<div class="padding-inner">
							<?php      
							$as = new Area('Sidebar');
							$as->display($c);
							?>
						</div>
					</div>
					-->
					<div class="col_12" id="content">
							<?php      
							  print $innerContent;
							?>
					</div>
					<div class="clear"></div>
				</div>
			</div>			
		</div>
	</div>
</div>
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




<?php       $this->inc('elements/footer.php'); ?>