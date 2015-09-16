<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$this->inc('elements/header.php'); 

$ih = Loader::helper('image'); 
$nav = Loader::helper('navigation');
$date = date('F j, Y', strtotime($c->getCollectionDatePublic()));
//$last_edited_by = $c->getVersionObject()->getVersionAuthorUserName();
$original_author = Page::getByID($c->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
$img = $c->getAttribute('page_thumbnail');
$thumb = $ih->getThumbnail($img, 630, 9000, true);


?>

<div class="blankSeparator"></div>
<div class="container singleblog"> 
  <div class="two_third">
    <section class="postone">
    <h2><?php  echo $c->getCollectionName(); ?></h2>
    <p class="meta">
      <span class="left"><?php echo ('Date:')?> <strong><?php echo $date?></strong></span> 
      <span class="left"><?php echo t('posted by')?> <strong><?php echo $original_author?></strong></span>
      <span class="left"><a href="mailto:?subject=<?php  echo $c->getCollectionName(); ?>&body=<?php  echo $nav->getLinkToCollection($c, true); ?>">mail</a></span>
      <span class="left"><a href="https://twitter.com/share">Twitter</a></span>
      <span class="left"><a href="http://www.facebook.com/share.php?u=<?php  echo $nav->getLinkToCollection($c, true); ?>">facebook</a></span>
      <!-- <span class="left tags">on <a href="#" rel="tag">photography</a>, <a href="#" rel="tag">Artistic</a>, <a href="#" rel="tag">Beauty and Art</a></span> <span class="left comment"> <a href="#" title="">46 Comments</a></span> </p> -->
      </p>
     <img src="<?php echo $thumb->src?>" alt="" target="<?php  echo $target ?>"/>

      <?php  
      if ($c->isEditMode()) :
      $a = new Area('Thumbnail Image');
      $a->display($c);
      $a = new Area('Header Image');
      $a->display($c);


      endif;
      ?>           
      <?php  
      $a = new Area('Main');
      $a->display($c);
      ?>
      </section>
      
     <?php 
      $a = new Area('Comments');
      $a->display($c);
    ?>       
     <?php 
      $a = new Area('Blog Post Footer');
      $a->display($c);
    ?>       
    
    
    </div>

<div class="one_third lastcolumn sidebar">
     <?php 
      $a = new Area('Sidebar');
      $a->display($c);
    ?> 
</div>
</div>
<div class="blankSeparator1"></div>


<?php $this->inc('elements/footer.php'); ?>
