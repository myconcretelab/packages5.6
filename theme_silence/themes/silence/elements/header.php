<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

global $mobile, $mobile_active;

$th = Loader::helper('concrete/urls');
$t = Loader::helper('mylab_theme', 'theme_silence');
Loader::model('package');
$c = Page::getCurrentPage();
$mobile = $t->detection_mobile () ;
$cp = new Permissions($c);
$mobile_active = !$t->__disable_mobile_detection;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php      echo $this->getThemePath()?>/fonts.css" />

<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getThemePath()?>/css/columnal.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getThemePath()?>/typography.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getThemePath()?>/css/static.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getThemePath()?>/styles.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getThemePath()?>/css/jquery.mmenu.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $th->getToolsURL('override.css?c='.$c->getCollectionID() . '&mobile=' . ($mobile ? 'true' : 'false'), 'theme_silence')?>" />
<?php  if (is_file($css = DIR_BASE . '/' . DIRNAME_CSS . '/silence/styles.css')) :?>
<link rel="stylesheet" href="<?php  echo DIR_REL . '/' . DIRNAME_CSS . '/silence/styles.css'?>" type="text/css" media="screen" />
<?php  endif ?>




<!-- Start Concrete Header -->
<?php      Loader::element('header_required'); ?>
<!-- End Concrete Header --> 
<?php     if ($mobile_active): ?>
<meta name="viewport" content="initial-scale=1.0 width=device-width">
<?php      endif ?>
<!--[if lt IE 9]>
<link rel="stylesheet" href="<?php     echo $this->getThemePath()?>/css/ie.css" type="text/css" media="screen" />
<![endif]-->
<!-- use "fixed-984px-ie.css" or "fixed-960px-ie.css for a 984px or 960px fixed width for IE6 and 7 -->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php     echo $this->getThemePath()?>/css/ie-6-7.css" type="text/css" media="screen" />
<![endif]-->
<!-- Use .imagescale to fix IE6 issues with full-column width images (class must be added to any image wider than the column it is placed into) -->
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php     echo $this->getThemePath()?>/css/ie6-984px.css" type="text/css" media="screen" />
<script src='<?php     echo $this->getThemePath()?>/js/jquery.pngFix.pack.js' type='text/javascript'></script>
<script type="text/javascript"> 
    $(document).ready(function(){ 
        $(document).pngFix(); 
    }); 
</script>
<![endif]-->
</head>
<!-- Theme Silence V<?php     echo Package::getByHandle('theme_silence')->getPackageVersion() ?> -->
<!-- Theme preset Name : <?php  echo $t->get_preset_title($t->pID) ?> / Theme preset ID : <?php  echo $t->pID ?> -->
<body id="silence"  class="<?php   if ($c->isEditMode()) : ?>edit-mode<?php  endif ?> <?php   if($cp->canWrite() && $cp->canAddSubContent()) :?>toolbar-active<?php endif ?> <?php       if ($mobile) : ?>mobile<?php      endif ?>" >
		<?php     if ($mobile_active): ?>
		<div id="mobile-top" class="mm-fixed-top">
			<a href="#mobile_nav">&nbsp;</a>
		</div>
		<?php endif ?>
		<div id="top">

		<div class="container">
			<div class="row" id="logo-nav-container">
				
			<?php       if ($c->isEditMode()) : ?>
			    <div class="clear"><br /><br /><br /></div>
			<?php      endif ?>    
				<div id="logo" class="col_4">
				    <a href="<?php      echo DIR_REL?>/">
					<?php    
					// if (class_exists(GlobalArea))
					    $a = new GlobalArea('Site Name');
					// else
					   // $a = new Area('Site Name');
					$a->display($c);
					?>						
				    </a>
				</div>
				<div id="main-nav" class="col_8 last">
				    <?php      
					$a = new GlobalArea('Header_Nav');
				    $a->display($c);
				    ?>
				</div>
			</div>
			
			<?php      if ($t->__display_searchbox) :?>
			<?php      if (!($t->__hide_searchbox_on_mobile && $mobile)) : //false ?>
			<div class="clear"></div>
			<div class="row" id="search-box-wrapper">
				<div id="search-box">
					<form action="<?php      echo View::url('search'); ?>">
					   <input type="text" id="search-keywords" name="query" value="Search" />
					   <input type="submit" id="search-go" name="go" value="go"/>
					</form>
				</div>
			</div>
			<?php      endif ?>
			<?php      endif ?>