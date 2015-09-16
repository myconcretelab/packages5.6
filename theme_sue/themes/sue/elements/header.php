<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

global $mobile, $shadow_has_displayed;

$th = Loader::helper('concrete/urls');
$t = Loader::helper('sue_theme', 'theme_sue');
$c = Page::getCurrentPage();
$mobile = $t->detection_mobile () ;
$shadow_has_displayed = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<link rel="stylesheet" type="text/css" href="<?php  echo $th->getToolsURL('blender.css?c='.$c->getCollectionID() . '&mobile=' . ($mobile ? 'true' : 'false'), 'theme_sue')?>" />
<?php 	if (file_exists(DIR_FILES_THEMES . '/sue/css/custom.css')) : ?>
<link rel="stylesheet" type="text/css" href="<?php echo (BASE_URL . DIR_REL) ?>/themes/sue/css/custom.css" />
<?php endif ?>

<!-- Start Concrete Header -->
<?php  Loader::element('header_required'); ?>
<!-- End Concrete Header -->
<script type="text/javascript">
    var THEME_PATH = "<?php echo $this->getThemePath()?>";
    var SLIDER_CUSTOM_SETTINGS =  new Object();
    var left_menu_position = (-112);
</script>
<?php if ($t->__enable_mobile) : ?>
<meta name="viewport" content="initial-scale=1.0 width=device-width"> 
<?php endif ?>
<!--[if lt IE 9]>
<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/css/ie.css" type="text/css" media="screen" />
<![endif]-->
<!-- use "fixed-984px-ie.css" or "fixed-960px-ie.css for a 984px or 960px fixed width for IE6 and 7 -->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/css/ie-6-7.css" type="text/css" media="screen" />
<script type="text/javascript">left_menu_position = (-152); </script>
<![endif]-->
<!-- Use .imagescale to fix IE6 issues with full-column width images (class must be added to any image wider than the column it is placed into) -->
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/css/ie6-984px.css" type="text/css" media="screen" />
<script src='<?php echo $this->getThemePath()?>/js/jquery.pngFix.pack.js' type='text/javascript'></script>
<script type="text/javascript"> 
    $(document).ready(function(){ 
        $(document).pngFix(); 
    }); 
</script>
<![endif]-->
<script type="text/javascript">
// google fonts //
var center_nav = function  () {
	$('#main-nav>ul>li').each(function(){
	    var $ul = $('>ul', this);
	    if ($ul.size()) { $il = $(this); var $w = $il.width(); if($w / 2 == Math.round( $w / 2 )) $w ++ ; $ul.css('left', (left_menu_position + ( $w / 2)) +'px' ); }});	//112
}
WebFontConfig = { google: {families: [ 'Abel', 'Merriweather:300,400' ]},fontactive: function(fontFamily, fontDescription) { if (fontFamily == 'Abel') { center_nav ();} } };
(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
    
</script>

</head>
<body id="sue"  class="<?php   if ($c->isEditMode()) : ?>edit-mode<?php  endif ?> <?php   if ($mobile && $t->__enable_mobile) : ?>mobile<?php  endif ?>" >
    <div class="container">
	<div class="row top" id="logo-search-container">
	<div class="padding-inner">
	    <?php   if ($c->isEditMode()) : ?>
	    <?php  endif ?>    
		<div id="logo" class="col_8">
		    <a href="<?php  echo DIR_REL?>/">
		    <?php
		    if (class_exists(GlobalArea))
			$a = new GlobalArea('Site Name');
		    else
			$a = new Area('Site Name');
		    $a->display($c);
		    ?>						
		    </a>
		</div>
		<div id="main-search" class="col_4 last">
		    <?php  if ($t->__display_searchbox) :?>
		    <?php  if (!($t->__hide_searchbox_on_mobile && $mobile)) : //false ?>
		    <div class="clear"></div>
		    <div class="row" id="search-box-wrapper">
			<div id="search-box">
			    <form action="<?php  echo View::url('search'); ?>">
			       <input type="text" id="search-keywords" name="query" value="Search" />
			       <input type="submit" id="search-go" name="go" value="go"/>
			    </form>
			</div>
		    </div>
		    <?php  endif ?>
		    <?php  endif ?>
		</div>
	    <div class="clear"></div>
	</div>
	</div>
	<div class="row top">
	    <div class="col_12" id="main-nav">
		<?php  
		    if (class_exists(GlobalArea))
			$a = new GlobalArea('Header Nav');
		    else
			$a = new Area('Header Nav');
		    $a->display($c);
		?>
	    </div> 
	<div class="clear"></div>
	</div>	
	<div class="row top" id="breadcrumb">
		<div class="col_12">
		    <?php  if ($t->__display_breadcrumb) : ?>
			    <div id="inner-breadcrumb"><?php  $t->output_breadcrumb() ?></div>
			   <?php else: ?>
			   <hr class="demi-space" />		
		    <?php  endif ?>
		</div>
	<div class="clear"></div>
	</div>
<?php

/// Magic Header ////
	Loader::model('countable_area', 'theme_sue');
	
	$header = new CountableArea('Header');
	if ($c->isEditMode()) :
	
		$this->inc('elements/header_area.php',array('header' => $header));
	
	elseif ($header->getTotalBlocksInArea($c) > 0 ) :
		if ($c->getAttribute('easy_slider') ) {
			$this->inc('elements/easy_slider.php',array('sliderarea' => $header));
		} else {
			$this->inc('elements/header_area.php',array('header' => $header));
		}
	endif;

/// / Magic Header ////	?>
