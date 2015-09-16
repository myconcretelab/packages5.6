<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
global $langue, $c;
$this->inc('elements/header.php'); ?>
<hr class="space" />
<hr class="space" />
<hr class="space" />
<hr class="space" />
<div id="middle">
	<div id="full-width">
		<?php 
		$a = new Area('Full width');
		$a->display($c);
		?>
	</div>		
	<div class="container">
		<div class="content">
			<div class="span-14" id="header-left">
				<?php 
				$a = new Area('Header');
				$a->display($c);
				?>
			<? if (!$c->getAttribute('hide_shadow')) : ?><img src="<?=$this->getThemePath()?>/images/ombre-header.png" /><? endif ?>	
			</div>
			
			<div class="span-9 prepend-1 last" id="header-right">
				<?php 
				$a = new Area('Header right');
				$a->display($c);
				?>				
			</div>
			
		</div>
	</div>
</div>
<hr class="space" />
<hr class="space" />
<hr class="space" />

<div id="bottom">
	<div class="container">
		<hr class="space" />
		<div class="content">
			<div class="col span-7 colborder" id="col-1">
				<?php 
				$a = new Area('col-3');
				$a->display($c);
				?>								
			</div>
			<div class="col span-7 colborder" id="col-2">
				<?php 
				$a = new Area('Sidebar');
				$a->display($c);
				?>				
			</div>
			<div class="col span-8 last" id="col-3">
				<?php 
				$a = new Area('Main');
				$a->display($c);
				?>								
			</div>
		</div>
	</div>
</div>


<?php  $this->inc('elements/footer.php'); ?>