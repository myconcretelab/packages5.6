<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('mcl_area','theme_myconcretelab');
$this->inc('elements/header.php');
$ih = Loader::helper('image');
$c = Page::GetCurrentPage();

?>
	<div class="full">
			<?php 
			$a = new Area('Full width');
			$a->display($c);
			?>	
	</div>
	<div class="row">
		<div class="columns large-12">
			<?php 
			$a = new Area('Header right');
			$a->display($c);
			?>			
		</div>
	</div>
<?php  if ($c->isEditMode()) : ?>
	<div class="row addon-detail">
		<div class="divider-normal"></div>
		<div class="divider-normal"></div>
		<div class="large-7 columns">
<?php endif ?>
			<?php 
			$a = new Area('Main');
			$a->display($c);
			?>				
<?php  if ($c->isEditMode()) : ?>
		</div>
<?php endif ?>	
		<div class="large-5 columns">
			<div class="divider-xl"></div>
			<?php 
			$a = new Area('Header');
			$a->display($c);
			?>  			
		</div>
	</div><!-- .row ouvert dans le view du plugin gnt_addon_showcase -->
	<div class="row">
		<div class="large-12 columns">
				<?php 
				$a = new Area('Full');
				$a->display($c);
				?>	
				<?php 
				$a = new Area('col-3');
				$a->display($c);
				?>								

		</div>
	</div>
	<div class="divider-line divider-bottom"></div>
	<div class="full-color-third">
		<div class="row">
			<div class="divider-xl"></div>			
			<div class="large-6 columns">
				<h2>Addons also worth a visit</h2>
			</div>
			<div class="large-6 columns">
				<?php 
				$a = new Area('Related addons');
				$a->display($c);
				?>										
			</div>
		</div>
		<div class="divider-line divider-bottom divider-normal"></div>
	</div>	
<?php  $this->inc('elements/footer.php'); ?>