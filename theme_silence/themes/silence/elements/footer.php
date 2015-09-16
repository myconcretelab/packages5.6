<?php       defined('C5_EXECUTE') or die(_("Access Denied."));

$th = Loader::helper('concrete/urls');
$c = Page::getCurrentPage();
$t = Loader::helper('mylab_theme', 'theme_silence');
$footer = $t->get_footer_geometry();
$responsive = !$t->__disable_mobile_detection;
?>
<?php     if ($t->__display_footer) : ?>
<div id="footer">
	<div class="container">
		<div class="row footer-box <?php     if ($t->__footer_rounded) : ?>rounded<?php     endif?> shadow margin_bottom_20">
			<div class="padding-inner">
				<?php foreach ($footer as $area) : ?>
				<div class="<?php echo $area['class'] ?>" id='<?php echo $area['name']?>'>
					<?php 
					if($t->__footer_global) :
						$f = new GlobalArea($area['name']);
						$f->display();
					else :
						$f = new Area($area['name']);
						$f->display($c);
					endif;
					
					?>								
				</div>
				<?php      endforeach ?>
				<div class="clear"></div>
				<div class="col_12" id="footer-credit">
					<small style="text-align:center; color:#a2a2a2"> &copy; <?php      echo date('Y')?> <a href="<?php      echo DIR_REL?>/"><?php      echo SITE?></a>.
					&nbsp;&nbsp;
					<?php      echo t('All rights reserved.')?>
					&nbsp;&nbsp;
					<?php      
					$u = new User();
					if ($u->isRegistered()) { ?>
						<?php       
						if (Config::get("ENABLE_USER_PROFILES")) {
							$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
						} else {
							$userName = $u->getUserName();
						}
						?>
						<span class="sign-in"><?php      echo t('Currently logged in as <b>%s</b>.', $userName)?> <a href="<?php      echo $this->url('/login', 'logout')?>"><?php      echo t('Sign Out')?></a></span>
					<?php       } else { ?>
						<span class="sign-in"><a href="<?php      echo $this->url('/login')?>"><?php      echo t('Sign In to Edit this Site')?></a></span>
					<?php       } ?>
					<small id="mylab">Template by <a href="http://www.myconcretelab.com" rel="Themes Concrete5" title="Concrete5 Themes & Addons by MyConcreteLab">MyConcreteLab</a></small>
					</small>
				</div>
			</div>
		</div>
	
	</div>
</div>

<?php     endif ?>

<script src='<?php echo $th->getToolsURL('blender.js?c='.$c->getCollectionID(), 'theme_silence')?>' type='text/javascript'></script>
<script src='<?php  echo $this->getThemePath()?>/js/jquery.mmenu.min.js' type='text/javascript'></script>
    
<script type="text/javascript">

<?php       if ($c->isEditMode()) : ?>
	var IS_EDIT_MODE = true;
<?php      else : ?>
	var IS_EDIT_MODE = false;
<?php      endif ?>
	var THEME_PATH = '<?php      echo $this->getThemePath()?>';
	var DYNAMIC_COLUMNS = <?php      echo $t->__dynamic_columns ? 'true' : 'false' ?>;	
<?php if ($responsive) : ?>
	var RESPONSIVE = true;
<?php      else : ?>
	var RESPONSIVE = false;
<?php      endif ?>
</script>


<!-- Generated in 
<?php    
global $time_start;
if (isset($time_start)) :
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo $time;
endif;
?>
sec -->
<?php       Loader::element('footer_required'); ?>
</body>
</html>