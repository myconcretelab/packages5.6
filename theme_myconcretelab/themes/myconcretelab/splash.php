<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Start Concrete Header -->
<?php Loader::element('header_required'); ?>
<!-- End Concrete Header --> 


<link rel="stylesheet" media="screen" type="text/css" href="<?=$this->getThemePath()?>/typography.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?=$this->getThemePath()?>/grid.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?=$this->getThemePath()?>/style.css" />

</head>
<body id="body-splash">
<div id="splash">
	<div class="container">
		<div class="content">
			<div class="span-14 prepend-5 append-5 last" id="header-splash">
				<img src="<?=$this->getThemePath()?>/images/myconcretelab.gif" alt="Plugin pour Concrete5" />
				<hr class="space" />
				<hr class="space" />
				<?php 
				$a = new Area('Header');
				$a->display($c);
				?>
				<? if (!$c->getAttribute('hide_shadow')) : ?><img src="<?=$this->getThemePath()?>/images/ombre-header.png" /><? endif ?>	
			</div>
		</div>
	</div>
</div>


<?php  $this->inc('elements/footer.php'); ?>