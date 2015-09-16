<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('mcl_area','theme_myconcretelab');
$this->inc('elements/header.php');
?>
<div class="header">
			<?php 
			$a = new Area('Header');
			$a->display($c);
			?>  	
</div>
<div class="row">
		<div class="large-12 small-12 columns">
					<?php 
					$a = new Area('Header 2');
					$a->display($c);
					?>

			<?php 
			$a = new Area('Main');
			$a->display($c);
			?>			
		</div>
		<div class="large-3 small-6 columns">
			<?php 
			$a = new Area('col-1');
			$a->display($c);
			?>				
		</div>
		<div class="large-3 small-6 columns">
			<?php 
			$a = new Area('col-2');
			$a->display($c);
			?>				
		</div>
		<div class="large-3 small-6 columns">
			<?php 
			$a = new Area('col-3');
			$a->display($c);
			?>				
		</div>
		<div class="large-3 small-6 columns">
			<?php 
			$a = new Area('col-4');
			$a->display($c);
			?>				
		</div>
</div>
<div class="divider-line divider-bottom"></div>
<div class="full-color-third">
	<div class="row">
		
		<div class="large-12 columns">
			<div class="divider-xl"></div>
			<?php 
			$a = new Area('col-1-0');
			$a->display($c);
			?>										
		</div>
		<div class="large-12 columns divider-xl"></div>
		<div class="large-6 small-12 columns">
			<?php 
			$a = new Area('col-1-1');
			$a->display($c);
			?>							
		</div>
		<div class="large-5 large-offset-1 small-12 columns">
			<?php 
			$a = new Area('col-1-2');
			$a->display($c);
			?>										
		</div>
	</div>
	<div class="divider-line divider-bottom divider-normal"></div>
</div>

	<div class="row">
		<div class="large-12 columns">
			<div class="divider-xl"></div>
			<?php 
			$a = new Area('col-2-0');
			$a->display($c);
			?>										
		</div>
		<div class="large-12 columns divider-xl"></div>
	</div>

<div class="full-color-black">
	<div class="row">
		
		<div class="large-12 columns">
			<div class="divider-xl"></div>
			<?php 
			$a = new Area('col-3-0');
			$a->display($c);
			?>										
		</div>
		<div class="large-12 columns divider-xl"></div>
	</div>
	<div class="divider-line divider-bottom divider-normal"></div>
</div>


<?php  $this->inc('elements/footer.php'); ?>