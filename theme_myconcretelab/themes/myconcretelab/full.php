<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('mcl_area','theme_myconcretelab');
$this->inc('elements/header.php');
?>
<div class="row">
		<div class="large-12 columns">
			<?php 
			$a = new Area('Main');
			$a->display($c);
			?>			
		</div>
</div>

<?php  $this->inc('elements/footer.php'); ?>