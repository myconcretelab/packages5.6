<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$this->inc('elements/header.php');
?>
<div id="middle">
	<div class="container">	
		<div class="row">
			<div class="span12">
				<div id="" class="content">
					<div class="padding">
						<div class="pageSection">
							<?php  $ai = new Area('Blog Post Header'); $ai->display($c); ?>
						</div>
						<div class="pageSection">
							<h1><?php  echo $c->getCollectionName(); ?></h1>
							<p class="meta"><?php   echo t('Posted by')?> <?php   echo $c->getVersionObject()->getVersionAuthorUserName(); ?> <?php echo t('on'); ?> <?php   echo $c->getCollectionDatePublic(t('F j, Y')); ?></p>
						</div>
						<div class="pageSection">
							<?php  $as = new Area('Main'); $as->display($c); ?>
						</div>
						<div class="pageSection">
							<?php  $a = new Area('Blog Post More'); $a->display($c); ?>
						</div>
					</div> <!-- .padding -->
				</div> <!-- #content -->
				<div id="under-main">
						<?php  $ai = new Area('Blog Post Footer'); $ai->display($c); ?>
				</div> <!-- #under-main -->
			</div> <!-- .span8 -->
		</div> <!-- .row -->			
	</div> <!-- .container -->
</div> <!-- #middle -->



<?php   $this->inc('elements/footer.php'); ?>