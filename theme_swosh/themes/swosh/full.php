<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$this->inc('elements/header.php'); ?>
<div class="blankSeparator"></div>
<div class="container">
     <?php 
      $a = new Area('Main');
      if ($c->getAttribute('wrap_white_box')) :
        $a->setBlockWrapperStart('<div class="whitebox">');
        $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
      endif;
      $a->display($c);
    ?> 
</div>

<div class="blankSeparator"></div>
<div class="container">
  <div class="one_third">
    <section class="aboutoneleft">
        <?php 
        $a = new Area('Main Col 1');
        if ($c->getAttribute('wrap_white_box')) :
          $a->setBlockWrapperStart('<div class="whitebox">');
          $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
        endif;
        $a->display($c);
        ?>      
    </section>
  </div>
  <!-- end one-third column ends here -->
  <div class="one_third">
    <section class="aboutonecenter">
        <?php 
        $a = new Area('Main Col 2');
        if ($c->getAttribute('wrap_white_box')) :
          $a->setBlockWrapperStart('<div class="whitebox">');
          $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
        endif;
        $a->display($c);
        ?>   
    </section>
  </div>
  <!-- end one-third column ends here -->
  <div class="one_third lastcolumn">
    <section class="aboutoneright">
        <?php 
        $a = new Area('Main Col 3');
        if ($c->getAttribute('wrap_white_box')) :
          $a->setBlockWrapperStart('<div class="whitebox">');
          $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
        endif;
      $a->display($c);
        ?>       </section>
  </div>
  <!-- end one-third column ends here -->   
</div>

<div class="container">
     <?php 
      $a = new Area('Main 1');
      if ($c->getAttribute('wrap_white_box')) :
        $a->setBlockWrapperStart('<div class="whitebox">');
        $a->setBlockWrapperEnd('</div><!-- .whitebox -->');
      endif;
      $a->display($c);
    ?> 
    </div>
<div class="blankSeparator1"></div>

<?php $this->inc('elements/footer.php'); ?>
