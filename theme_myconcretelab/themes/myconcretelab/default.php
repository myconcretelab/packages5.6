<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
global $langue;
$this->inc('elements/header.php'); ?>
<div id="middle">
	<div class="container">
		<div class="content">
			<div class="span-14" id="header-left">
				<?php 
				$a = new Area('Header 1');
				$a->setBlockLimit(1);
				$a->display($c);
				?>
				
			</div>
			<div class="span-9 prepend-1 last" id="header-right">
				<?php 
				$a = new Area('Header 2');
				$a->display($c);
				?>				
			</div>
		</div>
	</div>
</div>
<div id="bottom">
	<div class="container">
		<div class="content">
			<div class="col span-8" id="col-1">
				<?php 
				$a = new Area('Sidebar');
				$a->display($c);
				?>				
			</div>
			<div class="col span-8" id="col-2">
				<?php 
				$a = new Area('col-2');
				$a->setBlockLimit(1);
				$a->display($c);
				?>								
			</div>
			<div class="col span-8 last" id="col-3">
				<?php 
				$a = new Area('col-3');
				$a->setBlockLimit(1);
				$a->display($c);
				?>								
			</div>

		</div>
	</div>
</div>


<?php  $this->inc('elements/footer.php'); ?>