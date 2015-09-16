<?php  defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div id="footer">
  <div class="container footer">
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer_global_1');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer_global_2');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer_global_3');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth lastcolumn">
      <?php       
      $ahh = new GlobalArea('Footer_global_4');
      $ahh->display();      
      ?>  
    </div>
  </div>
  <!-- container ends here --> 
</div>
<!-- footer ends here --> 


<div id="copyright">
  <div class="container">
    <div class="eleven columns alpha">
      <p class="copyright">
            <span>&copy; <?php echo date('Y')?> <a href="<?php echo DIR_REL?>/"><?php echo SITE?>.</a></span>
            <span><i class="icon-magic"></i> <?php echo t('Designed by ') ?><a href="http://www.myconcretelab/" rel="Concrete5 theme & addons" title="Concrete5 theme & addons by MyConcreteLab">MyConcreteLab.</a></span>
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
    <div class="five columns omega">
      <section class="socials" style="padding-top:5px;">
        <?php
           $ga = new GlobalArea('Footer_bottom');
           $ga->display();
        ?>
      </section>

    </div>
  </div>
  <!-- container ends here --> 
</div>
<!-- copyright ends here --> 
<!-- End Document

<!-- Tweets --> 
<script src="<?=$this->getThemePath()?>/js/jquery.tweetable.js" type="text/javascript"></script> 
<!-- Include Superfish --> 
<script src="<?=$this->getThemePath()?>/js/hoverIntent.js" type="text/javascript"></script> 
<script src="<?=$this->getThemePath()?>/js/superfish.js"></script> 
<script src="<?=$this->getThemePath()?>/js/modernizr.custom.29473.js"></script>
<script src="<?=$this->getThemePath()?>/js/screen.js" type="text/javascript"></script>
<?php if ($c->getAttribute('page_background') || $c->getAttribute('page_backgrounds')) : 
  $ih = Loader::helper('image');
  $bg = $c->getAttribute('page_background');
  $bgs = $c->getAttribute('page_backgrounds');
  if ($bg) $bgurls[] = $bg->getRelativePath();//$ih->getThumbnail($bg,2500,1440)->src; // The bigger screen in the market : the Mac one :-)
  if ($bgs) {
    Loader::model('file_list');
    Loader::model("file_set");
    $ih = Loader::helper('image');
    $fs = FileSet::getByID($bgs);
    $fl = new FileList();
    $fl->filterBySet($fs);
    $fl->sortByFileSetDisplayOrder();
    $files = $fl->get();
    foreach ($files as $key => $file) {
     $bgurls[] = $ih->getThumbnail($file,2500,1440)->src; // The bigger screen in the market : the Mac one :-)
    }
  }

if (count($bgurls)) : ?>
  <script src="<?=$this->getThemePath()?>/js/jquery.backstretch.js" type="text/javascript"></script>

<script>
  $(function() {
        $.backstretch(<?php print Loader::helper('json')->encode($bgurls, JSON_UNESCAPED_SLASHES)  ?>,  {speed: 750});
      });
</script>
<?php endif?>

<?php endif?>

<?php  Loader::element('footer_required'); ?>

</body>
</html>