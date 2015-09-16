<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
 $this->inc('elements/header.php'); ?>
<div class="blankSeparator"></div>
<div class="container">
<div class="one_third sidebar">
  <?php if ($c->getAttribute('wrap_white_box')) : ?>
  <div class="whitebox">
  <?php endif ?>
     <?php 
      $a = new Area('Sidebar');
      $a->display($c);
    ?> 
  <?php if ($c->getAttribute('wrap_white_box')) : ?>
    </div><!-- .whitebox -->
  <?php endif ?>
</div>
  <div class="two_third lastcolumn">
     <?php 
      $a = new Area('Main');
      if ($c->getAttribute('wrap_white_box')) :
        $a->setBlockWrapperStart('<div class="whitebox">');
        $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
      endif;
      $a->display($c);
    ?> 
</div>
</div>


<div class="blankSeparator1"></div>

<?php $this->inc('elements/footer.php'); ?>
