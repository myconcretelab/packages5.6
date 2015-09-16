
	<footer class="full-color-third">
		<div class="divider-xl"></div>
		<div class="row">
			<div class="columns large-4 small-12">
				<?php
				   $ga = new GlobalArea('Footer-col-1');
				   $ga->display();
				?>				
			</div>
			<div class="columns large-4 small-12">
				<?php
				   $ga = new GlobalArea('Footer-col-2');
				   $ga->display();
				?>				
			</div>
			<div class="columns large-4 small-12">
				<?php
				   $ga = new GlobalArea('Footer-col-3');
				   $ga->display();
				?>				
			</div>
			<div class="divider-xl"></div>
		</div>
		<div class="row">
			<div class="columns large-12">
				
				<div class="divider-line divider-centered"></div>
	      		<p id="footer-note">
	      			<span>&copy; <?php echo date('Y')?> <a href="<?php echo DIR_REL?>/"><?php echo SITE?></a>.</span>
	      			<span><i class="icon-magic"></i> <?php echo t('Designed by ') ?><a href="http://www.myconcretelab/" rel="Concrete5 theme & addons" title="Concrete5 themes & addons by MyConcreteLab">MyConcreteLab</a></span>
	      			<span class="powered-by"><i class="icon-cogs"></i> <?php echo t('Powered by ')?> <a href="http://www.concrete5.org" title="<?php echo t('concrete5 - open source content management system for PHP and MySQL')?>"><?php echo t('concrete5')?></a></span>	
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
			</div>
		</div>
	</footer>	

  <?php  Loader::element('footer_required'); ?>
<script src="<?php echo $this->getThemePath()?>/js/foundation/foundation.js"></script>
<script src="<?php echo $this->getThemePath()?>/js/foundation/foundation.section.js"></script>
<script src="<?=$this->getThemePath()?>/js/icheck/jquery.icheck.min.js"></script>
<script>
  $(document).foundation().ready(function(){
	$('input').each(function(){
    	var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: 'icheckbox_line-orange',
      radioClass: 'iradio_line-orange',
      insert: '<div class="icheck_line-icon"></div>' + label_text
    });
  });
	});  
</script>
  </section> <!-- role Main -->
</body>