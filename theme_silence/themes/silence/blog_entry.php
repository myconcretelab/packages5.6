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
						<h1><?php         echo $c->getCollectionName(); ?></h1>
						<p class="meta">
							<span class="author"><?php         echo $c->getVersionObject()->getVersionAuthorUserName(); ?></span>
							&nbsp;&thksim;&nbsp;
							<span class="date"><?php         echo $c->getCollectionDatePublic('F j, Y'); ?></span>
							<?php      if($c->getAttribute('tags')) : ?>
							&nbsp;&thksim;&nbsp;
							<span class="tags"><?php       echo $c->getAttribute('tags')?></span>
							<?php      endif ?>
						</p>
					<?php      endif ?>
					<?php      if ($t->__display_page_desc) : ?>
						<p><?php      echo Page::getByID($c->getCollectionParentID())->getCollectionDescription() ?> </p>
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
					<div class="col_8" id="content">
						<?php         $as = new Area('Main'); $as->display($c); ?>
						<?php         $a = new Area('Blog Post More'); $a->display($c); ?>
						<?php         $ai = new Area('Blog Post Footer'); $ai->display($c); ?>
						
					</div>
					<div class="col_4 last right-sidebar <?php      if ($t->__hide_sidebar_on_mobile) :?>mobile-hide<?php      endif?>" id="sidebar">
						<div class="padding-inner">
							<?php      
							$as = new Area('Sidebar');
							$as->display($c);
							?>
						</div>
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