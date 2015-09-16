<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
if ($c->getAttribute('page_background') || $c->getAttribute('page_backgrounds')) : 
  $ih = Loader::helper('image');
  $bg = $c->getAttribute('page_background');
  $bgs = $c->getAttribute('page_backgrounds');
  if ($bg) $bgurls[] = $bg->getRelativePath();
  if ($bgs) :
    Loader::model('file_list');
    Loader::model("file_set");
    $ih = Loader::helper('image');
    $fs = FileSet::getByID($bgs);
    $fl = new FileList();
    $fl->filterBySet($fs);
    $fl->sortByFileSetDisplayOrder();
    $files = $fl->get();
    foreach ($files as $key => $file) $bgurls[] = $file->getRelativePath();
  endif;

if (count($bgurls)) : ?>
  <script src="<?=$this->getThemePath()?>/js/jquery.backstretch.js" type="text/javascript"></script>
  
<script>
  $(function() {
        //$.backstretch(<?php // print Loader::helper('json')->encode($bgurls, JSON_UNESCAPED_SLASHES)  ?>,  {speed: 750});
        $.backstretch(<?php echo str_replace('\\/', '/', Loader::helper('json')->encode($bgurls))  ?>,  {speed: 750});
      });
</script>
<style>
  /* Retirer la texture du middle */
  #middle {background: transparent;}
  /* L'effet du footer ne marche pas a cause conflit de z-index */
  #footer {position: relative;}
</style>
<?php endif?>
<?php else : ?>
  <!-- No bakstrech attribute -->
<?php endif?>