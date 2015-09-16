<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('dynamic_area', 'theme_swosh');

$this->inc('elements/header.php'); ?>
<script>
    $(document).ready(function() {
        var allPanels = $('.accordion > .panel');
        $('.accordion > .title > a').click(function() {
            allPanels.slideUp();
            $(this).parent().next().slideDown();
            return false;
        });
        allPanels.hide(); 
    });
</script>
<div class="blankSeparator"></div>
<div class="container">
  <div class="two_third accordion">
     <?php 
        $a = new Area('Above Main');
        $a->display($c);
        ?>            
          
          <?php
          $a = new DynamicArea('Main');
          if (!$c->isEditMode()) {
              $a->setBlockWrapperTemplate('elements/accordion.php');
          }         
          $a->display($c);

    ?> 
    </div> <!-- .two_third -->

<div class="one_third lastcolumn sidebar">
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
</div> <!-- .one_third -->
</div> <!-- .container -->
<div class="blankSeparator1"></div>

<?php $this->inc('elements/footer.php'); ?>
