<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('mcl_area','theme_myconcretelab');
$this->inc('elements/header.php');
$ih = Loader::helper('image');
$c = Page::GetCurrentPage();
?>
<div class="divider-xl"></div>
	<div class="row">
		<div class="large-12 columns">
			<?php 
			$a = new Area('Main');
			$a->display($c);
			?>				
		</div>
	</div>
	<div class="divider-normal"></div>
	<div class="row">
		<div class="large-4 small-12 columns">
			<?php 
			$a = new Area('Details');
			$a->display($c);
			?>				
		</div>
		<div class="large-8 small-12 columns theme-figure-detail">
			<div class="divider-normal"></div>
			<figure>
				<?php 
					$img = $c->getAttribute('page_thumbnail');
					$thumb = $ih->getThumbnail($img,430,272,true);
				 ?>
				<img src="<?php echo $thumb->src ?>" alt="Conrete5 <?php // echo $c->getTitle()  ?> theme" class="thumb">
				<img src="<?=$this->getThemePath()?>/images/mac/mac-830.png" alt="Concrete5 theme on a macbook" class="mac">
			</figure>
			
		</div>
	</div>
	<div class="divider-line divider-bottom"></div>
	<div class="full-color-third">
		<div class="row">
			
			<div class="large-12 columns">
				<div class="divider-xl"></div>
				<?php 
				$a = new Area('Full width');
				$a->display($c);
				?>										
			</div>

		</div>
		<div class="divider-line divider-bottom divider-normal"></div>
	</div>	
	<div class="row">
		<div class="large-12 columns">
			<?php 
			$a = new Area('Main 1');
			$a->display($c);
			?>					
		</div>
	</div>

<?php  $this->inc('elements/footer.php'); ?>