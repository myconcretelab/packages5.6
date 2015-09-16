<?php
global $imagedujour;
$page = Page::getCurrentPage();
$ih = Loader::helper('image'); 
?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo  SITE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="">
    <meta name="author" content="">
      <?php  Loader::element('header_required'); ?>     
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,700italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="<?=$this->getThemePath()?>/css/icheck/line/orange.css" rel="stylesheet">
    <link href="<?=$this->getThemePath()?>/css/screen.css" rel="stylesheet">



  </head>

<body class="off-canvas hide-extras" style="zoom: 1;">
  <div class="divider-line-xxl"></div>
  <nav class="top-bar hide-for-small">
    <div class="row">
  <?php 
        // Doit utiliser la class .right
        $bt_main = BlockType::getByHandle('autonav');
        $bt_main->controller->displayPages = 'all';
        $bt_main->controller->orderBy = 'display_asc';                  
        $bt_main->controller->displaySubPages = 'none';
        $bt_main->render('view');
    ?>    
    </div>
  </nav>
  <header>
    <div class="row">
      <div class="left">
        <a href="/">
          <h1 class="logo hide-strong">
            <strong>Myconcretelab Themes & addons for Concrete5</strong>
          </h1>
        </a>
      </div> <!-- .left -->
    </div> <!-- .row -->
    <div class="divider-line"></div>
  </header>

  <section role="main">