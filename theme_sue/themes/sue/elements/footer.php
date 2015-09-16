<?php   defined('C5_EXECUTE') or die(_("Access Denied."));

$th = Loader::helper('concrete/urls');
$c = Page::getCurrentPage();
$t = Loader::helper('sue_theme', 'theme_sue');
$footer = $t->get_footer_geometry();
?>
<?php if ($t->__display_footer) : ?>
		<div id="footer" class="row footer-box margin_bottom_20">
			<div class="padding-inner">
				<?php  foreach ($footer as $area) : ?>
				<div class="<?php  echo $area['class'] ?>" id='<?php  echo $area['name']?>'>
					<?php  
					$f = new Area($area['name']);
					$f->display($c);
					?>								
				</div>
				<?php  endforeach ?>
				<div class="clear"></div>
				<hr />
				<div class="col_12" id="footer-credit">
					<small> &copy; <?php  echo date('Y')?> <a href="<?php  echo DIR_REL?>/"><?php  echo SITE?></a>.
					&nbsp;&nbsp;
					<?php  echo t('All rights reserved.')?>
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
						<span class="sign-in"><?php  echo t('Currently logged in as <b>%s</b>.', $userName)?> <a href="<?php  echo $this->url('/login', 'logout')?>"><?php  echo t('Sign Out')?></a></span>
					<?php   } else { ?>
						<span class="sign-in"><a href="<?php  echo $this->url('/login')?>"><?php  echo t('Sign In to Edit this Site')?></a></span>
					<?php   } ?>
					<small id="mylab">Creation by <a href="http://www.myconcretelab.com">myconcretelab</a></small>
					</small>
				</div>
			</div>
	
		</div>
</div>

<?php endif ?>

<script src='<?php  echo $th->getToolsURL('blender.js?c='.$c->getCollectionID(), 'theme_sue')?>' type='text/javascript'></script>
    
<script type="text/javascript">

<?php   if ($c->isEditMode()) : ?>
	var IS_EDIT_MODE = true;
<?php  else : ?>
	var IS_EDIT_MODE = false;
<?php  endif ?>
	var THEME_PATH = '<?php  echo $this->getThemePath()?>';
<?php   global $mobile; if ($mobile && $t->__enable_mobile) : ?>
	var IS_MOBILE = true;
	var DYNAMIC_COLUMNS = true;
<?php  else : ?>
	var IS_MOBILE = false;
	var DYNAMIC_COLUMNS = false;
<?php  endif ?>

</script>

<?php   Loader::element('footer_required'); ?>
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
</body>
</html>