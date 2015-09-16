<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
global $langue, $c;
$this->inc('elements/header.php'); ?>
<hr class="space" />
<hr class="space" />
<hr class="space" />
<hr class="space" />
<div id="middle">
	<div class="container">
		<div class="content">
			<div class="span-24 last" id="header-left">
				<?php 
				$a = new Area('Header');
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
			<div class="col span-24 last" id="col-2">
				<?php 
				print $innerContent;
				?>				
			</div>
<!--
			<div class="col span-8 last" id="col-1">
				<?php 
				$a = new Area('Sidebar');
				$a->display($c);
				?>								
			</div>
-->	
		</div>
	</div>
</div>


<?php  $this->inc('elements/footer.php'); ?>