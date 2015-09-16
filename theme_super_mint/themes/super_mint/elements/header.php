<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$c = Page::getCurrentPage();
// Les options
Loader::model('theme_super_mint_options', 'theme_super_mint');
$o = new ThemeSuperMintOptions($c);
//Cache::delete('supermint_options', false);
Cache::set('supermint_options', false , $o);
// Les permissions
$th = Loader::helper('concrete/urls');
$cp = new Permissions($c);

?>
<!DOCTYPE html>
<html>
<head>

<!-- Start Concrete Header -->
<?php  Loader::element('header_required'); ?>
<!-- End Concrete Header --> 
<?php if($o->__responsive) : ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="time_generated" content="<?php echo (microtime(true) - $GLOBAL['time_global'])?>">
<?php endif ?>

<link rel="stylesheet" href="<?php Loader::packageElement('font.googleapis','theme_super_mint',array('cID' => $c->cID)) ?>" type="text/css" data-noprefix/>
<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/typography.css" type="text/css" media="screen" />
<?php if($o->load_default_fonts('fonts')) : ?>
<link rel="stylesheet" href="<?php echo $this->getThemePath()?>/default-fonts.css" type="text/css" media="screen" />
<?php endif ?>
<link href="<?php echo $this->getThemePath()?>/stylesheets/imagezoom.css" media="screen, projection" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->getThemePath()?>/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getThemePath()?>/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo Loader::helper('concrete/urls')->getToolsURL('override_css','theme_super_mint') . '?' . http_build_query(array_merge($_GET,array('cID'=> $c->cID )))  ?>" type="text/css" media="screen" data-noprefix />
<?php if (is_file($css = DIR_BASE . '/' . DIRNAME_CSS . '/supermint.css')) :?>
<link rel="stylesheet" href="<?php echo DIR_REL . '/' . DIRNAME_CSS . '/supermint.css'?>" type="text/css" media="screen" />
<?php endif ?>
<!-- Theme Supermint V<?php echo Package::getByHandle('theme_super_mint')->getPackageVersion() ?> /  Theme preset Name : <?php echo $o->get_preset_title($o->pID) ?> / Theme preset ID : <?php echo $o->pID ?> -->
</head>
<body id="supermint"  class="supermint <?php   if ($c->isEditMode()) : ?>edit-mode<?php  endif ?> <?php   if($cp->canWrite() && $cp->canAddSubContent()) :?>toolbar-active<?php endif ?>" >
	 <div id="pagewrapper">
	

	<div class="mobile-placeholder-nav">
		<div class="top_nav" id="fixed-nav">
			<ul>
				<li class="mobile-in-nav"><a href="#mobile_nav"><i class="fa fa-bars fa-lg"></i></a></li>
				<li class="search-in-nav">
					<form action="<?php  // echo  Loader::helper('navigation')->getCollectionURL($p)?>" id="expand-search">
		   				<input type="search" class="span3" id="search-keywords" name="query"/>
					</form>
		   		</li>
			</ul>
		</div>
	</div>
	<div id="fixed-top">
		<div class="container">
			<div class="row">
				<div class="span8" id="logo">
					<?php
					   $ga = new GlobalArea('Logo');
					   $ga->setBlockLimit(1);
					   $ga->display();
					?>					
				</div>
				
				<div class="span4">
					<?php
					   $ga = new GlobalArea('Header_right');
					   $ga->display();
					   $a = new Area('Header Right Local');
					   $a->display($c);
					?>							
				</div> <!-- .span3 -->
				
			</div> <!-- .row -->			
			<div class="row">
				<div class="span12">
					<?php
					   $ga = new Area('Below Header');				
					   $ga->display($c);
					?>					
				</div>
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- .fixed-top -->
	<?php
	   $ga = new Area('Below Header Full');				
	   $ga->display($c);
	?>			
	<div id="top">
		<!-- disable_embed_nav : <?php var_export($o->__disable_embed_nav) ?> -->
		<?php if (!$o->__disable_embed_nav) : ?>
<!-- Navigation type : <?php echo $c->getAttribute('supermint_navigation_type') ?> -->
    <?php 
	    $bt_main = BlockType::getByHandle('autonav');
	    $bt_main->controller->displayPages = 'top';
	    $bt_main->controller->orderBy = 'display_asc';                  
	    $bt_main->controller->displaySubPages = 'all';
	    $bt_main->controller->displaySubPageLevels = 'all';
	    if ($o->__slide_nav) 
	    	$bt_main->render('templates/super_mint');
	    else
	    	$bt_main->render('templates/super_mint_mega');

		// Et maintenant on crée le selectbox si l'affichage mobile le demande
		if($o->__select_nav_mobile) :
		    $bt_main = BlockType::getByHandle('autonav');
		    $bt_main->controller->displayPages = 'top';
		    $bt_main->controller->orderBy = 'display_asc';                  
		    $bt_main->controller->displaySubPages = 'all';
		    $bt_main->controller->displaySubPageLevels = 'all';
		    $bt_main->render('templates/super_mint_selectbox');
	    endif;

	else :?>
	<div id="top_nav">
			<?php
			 $ga = new GlobalArea('Header Nav');
			 $ga->display();
			 ?>

	</div><!-- #top_nav -->
	<?php endif	?>	
	</div> <!-- #top -->
			
