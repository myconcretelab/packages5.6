<?php  defined('C5_EXECUTE') or die(_("Access Denied."))?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<link href='http://fonts.googleapis.com/css?family=Arvo|PT+Sans' rel='stylesheet' type='text/css'>
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
<?php  Loader::element('header_required'); ?> 

<link rel="stylesheet" href="<?=$this->getThemePath()?>/css/base.css">
<link rel="stylesheet" href="<?=$this->getThemePath()?>/css/skeleton.css">
<link rel="stylesheet" href="<?=$this->getThemePath()?>/css/screen.css">
<link rel="stylesheet" href="<?=$this->getThemePath()?>/typography.css">
<link rel="stylesheet" href="<?php echo $this->getStyleSheet('/styles.css')?>">
<link rel="stylesheet" href="<?=$this->getThemePath()?>/css/font-awesome.min.css">
<?php if (is_file(DIR_BASE . '/' . DIRNAME_CSS . '/swosh.css')) :?>
<link rel="stylesheet" href="<?php echo DIR_REL . '/' . DIRNAME_CSS . '/swosh.css'?>" type="text/css" media="screen" />
<?php endif ?>

</head>
<body id="swosh">

<!-- Theme Swosh tehme by myconcreteLab V<?php echo Package::getByHandle('theme_swosh')->getPackageVersion() ?> -->
<div id="header">
  <div class="container header"> 
    <header>
      <div class="logo">
        <a href="<?php echo DIR_REL?>/">
        <?php
        if (class_exists(GlobalArea))
      $a = new GlobalArea('Site Name');
        else
      $a = new Area('Site Name');
        $a->display($c);
        ?>  
        </a>
      </div>
      <div class="mainmenu">
      <!-- SWOSH_DISABLE_EMBED_NAVIGATION : <?php var_dump(SWOSH_DISABLE_EMBED_NAVIGATION); ?> -->
        <?php 
          if (!defined('SWOSH_DISABLE_EMBED_NAVIGATION')) :
            $bt_main = BlockType::getByHandle('autonav');
            $bt_main->controller->displayPages = 'top';
            $bt_main->controller->orderBy = 'display_asc';                    
            $bt_main->controller->displaySubPages = 'all';
            $bt_main->controller->displaySubPageLevels = 'all';      
            $bt_main->render('templates/swosh'); 
          else :
             $ga = new GlobalArea('Header Nav');
             $ga->display();
          endif;
         ?>   
 
      </div>
    </header>
  </div>
</div>
<div class="header-image">
  <?php       
  $ahh = new Area('Header');
  $ahh->display($c);      
  ?>    
</div>