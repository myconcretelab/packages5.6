<?php  defined('C5_EXECUTE') or die(_("Access Denied."))?>
<div id="footer">
  <div class="container footer">
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer col 1');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer col 2');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth">
      <?php       
      $ahh = new GlobalArea('Footer col 3');
      $ahh->display();      
      ?>  
    </div>
    <div class="one_fourth lastcolumn">
      <?php       
      $ahh = new GlobalArea('Footer col 4');
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
      <p class="copyright"></p>
    </div>
    <div class="five columns omega">
      <section class="socials">
        <ul class="socials fr">
          <li><a href="#"><img src="<?=$this->getThemePath()?>/images/socials/twitter.png" class="poshytip" title="Twitter"  alt="" /></a></li>
          <li><a href="#"><img src="<?=$this->getThemePath()?>/images/socials/facebook.png" class="poshytip" title="Facebook" alt="" /></a></li>
          <li><a href="#"><img src="<?=$this->getThemePath()?>/images/socials/google.png" class="poshytip" title="Google" alt="" /></a></li>
          <li><a href="#"><img src="<?=$this->getThemePath()?>/images/socials/dribbble.png" class="poshytip" title="Dribbble" alt="" /></a></li>
        </ul>
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