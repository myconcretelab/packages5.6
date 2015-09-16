<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$time_start = microtime(true);
$c = Page::getByID($_GET['cID']);

// La mise en cache chez alwaysdata fait gagner +/- 0.02 s
// $style = Cache::get('theme_stylesheet_', $_GET['c'], false, true);



if ($style) :

	$info = '(from Concrete5 caching system)';
	$ratio = '';

else :
	$info = '(generated)';
	
	// Les options
	Loader::model('theme_super_mint_options', 'theme_super_mint');
	$o = new ThemeSuperMintOptions($c);

//	$o = Cache::get('supermint_options',false, false, true);

	// le helper
	$h = Loader::helper('super_mint_theme', 'theme_super_mint');

	// Les google fonts
	Loader::model('super_mint_font', 'theme_super_mint');

	// CSS things
	$bodypattern = $o->_bg_body_custom ? $o->_bg_body_custom : $o->_bg_body_pattern;
	
	// On capte le code CSS dans le tampon
	ob_start();
    Loader::packageElement('override.css', 'theme_super_mint', array('o' => $o, 'h' => $h, 
    																'bodypattern' => $bodypattern,
    																'c' => $c
    																));	
	$style = ob_get_clean();

	Cache::set('theme_stylesheet_',  $_GET['c'] , $style);

endif;

header("Content-Type: text/css");

$time_end = microtime(true);
$time = $time_end - $time_start;

echo $style;
echo '/* Generated Time ' . $info . ' : ' . $time . ' ms ' . "*/ \n\n";
