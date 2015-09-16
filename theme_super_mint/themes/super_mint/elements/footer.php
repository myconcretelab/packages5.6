<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
$t = Loader::helper('super_mint_theme', 'theme_super_mint');

Loader::model('theme_super_mint_options', 'theme_super_mint');
$o = new ThemeSuperMintOptions($c);

$footer = $t->get_footer_geometry($o->display_footer_column);

?>
<?php // if ($t->__display_footer) : ?>
<div id="bottom">
	<div class="container">
		<div class="row">
			<?php  
			$a = new Area('Bottom');
			//$a->setBlockWrapperStart('<div class="span12 padding">');
			//$a->setBlockWrapperEnd('</div><!-- .span12 -->');
			$a->display($c);
			?>
		</div>
	</div>
</div>
<div id="footerpush">
	<?php 
	$f = new GlobalArea('Bottom Full');
	$f->display();
 	?>
 <div class="container inverse">
    <div id="footer">
      <div class="row">
      	<div class="space"></div>
		<?php  foreach ($footer as $area) : ?>
		<div class="<?php  echo $area['class'] ?>" id='<?php  echo $area['name']?>'>
			<?php
			//var_dump($t->__footer_global);
			if($o->__footer_global) :
				$f = new GlobalArea($area['name']);
				$f->display();
			else :
				$f = new Area($area['name']);
				$f->display($c);
			endif;
			
			?>								
		</div>
		<?php  endforeach ?>
		<div class="space"></div>
      </div>
      <div class="hr"></div>
      <div class="space"></div>
      <div class="row credits">
      	<div class="span8">
      		<p id="footer-note">
      			<span>&copy; <?php echo date('Y')?> <a href="<?php echo DIR_REL?>/"><?php echo SITE?></a>.</span>
				<?php echo $o->footer_credit ?>
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
					<span class="sign-in"><?php echo t('Currently logged in as <b>%s</b>.', $userName)?> <a href="<?php echo $this->url('/login', 'logout')?>"><?php echo t('Sign Out')?></a></span>
				<?php  } else { ?>
					<span class="sign-in"><a href="<?php echo $this->url('/login')?>"><?php echo t('Sign In to Edit this Site')?></a></span>
				<?php  } ?>      			
      		</p>
      		<div class="space"></div>
      	</div>
      </div>
    </div>
  </div>
</div>
<?php // endif ?>
    
<?php   Loader::packageElement('backstretch', 'theme_super_mint', array('themePath' => $this->getThemePath())); ?>
<?php   Loader::element('footer_required'); ?>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.boxnav.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.ecommerce.js"></script>
<!-- <script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/prefixfree.min.js"></script> -->
<!--<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/corecommerce.js"></script> -->
<script src="<?php echo $this->getThemePath()?>/js/jquery.pageslide.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.rcrumbs.min.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.zoom.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.grid.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/jquery.imagezoom.min.js"></script>
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/mmenu/jquery.mmenu.min.all.js"></script>
<!-- <script type="text/javascript" src="<?php  echo $this->getThemePath()?>/js/epic-image-zoom.min.js"></script> -->
<script type="text/javascript" src="<?php  echo $this->getThemePath()?>/script.js"></script>
<script type="text/javascript">
	<?php if ($o->__slide_nav) : ?>
	// Si navigationOption n'est pas défini, on n'initira pas le box.nav
	var navigationOptions = {
		columnsNumber : <?php echo $o->_nav_columns ?>,
		columnsMargin : <?php echo $o->_nav_columns_margin ?>,
		slideSpeed : <?php echo $o->_nav_slide_speed ?>,
		openSpeed : <?php echo $o->_nav_open_speed ?>,
		closeSpeed : <?php echo $o->_nav_close_speed ?>,
		mouseLeaveActionDelay : <?php echo $o->_nav_mouseleave_delay ?>,
		mode : '<?php echo $o->__force_mobile_nav ? 'mobile' : 'regular' ?>',
		globalWrapperSelector:'#top',
		openOnLoad : <?php echo $o->__nav_open_on_load ? 'true' : 'false' ?>, // A regler depuis l'admin
		eventName : '<?php echo $o->nav_event ?>',
		doubleCLickAction : '<?php echo $o->nav_dbl_click_event ?>'
	}
	<?php endif ?>
	var THEME_PATH = '<?php  echo $this->getThemePath()?>';
	// L'adresse pour l'outils des quantité de produits
	var QUANTITY_CART_URL = "<?php echo Loader::helper('concrete/urls')->getToolsURL('cart_quantity','theme_super_mint') ?>";
	var PAGE_SLIDE_URL = "<?php echo Loader::helper('concrete/urls')->getToolsURL('cart_details', 'theme_super_mint'); ?>";
	var FONT_DETAILS_TOOLS_URL = "<?php echo Loader::helper('concrete/urls')->getToolsURL('font_details', 'theme_super_mint'); ?>";
	var FIX_IFRAME_ZINDEX = <?php echo $o->__fix_iframe_zindex ? 'true' : 'false' ?>;

<?php if ($t->enable_ecommerce) : ?>
	var cart = $(document).slideCart({
		cartUrl :'<?php echo Loader::helper('concrete/urls')->getToolsURL('cart_details', 'theme_super_mint'); ?>',
		quantityUrl : "<?php echo Loader::helper('concrete/urls')->getToolsURL('cart_quantity','theme_super_mint') ?>",
		formUrl:"<?php echo View::url('cart') ?>"
	});
<?php endif ?>

</script>
<!-- The last file is the user override js if exist. -->
<script type="text/javascript" src="<?php echo Loader::helper('concrete/urls')->getToolsURL('extend.js','theme_super_mint'); ?>"></script>

<!-- Generated in <?php global $time_start;if (isset($time_start)) : $time_end = microtime(true);$time = $time_end - $time_start; echo $time;endif;?> sec -->
</div> <!-- #pagewrapper -->
    <?php 
	    $bt_main = BlockType::getByHandle('autonav');
	    $bt_main->controller->displayPages = 'top';
	    $bt_main->controller->orderBy = 'display_asc';                  
	    $bt_main->controller->displaySubPages = 'all';
	    $bt_main->controller->displaySubPageLevels = 'all';
	    $bt_main->render('templates/super_mint_mobile');
	?>
</body>
</html>