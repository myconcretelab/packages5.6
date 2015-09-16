<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$time_start = microtime(true);

//$url = Cache::get('googleapisurl', $cID, false, true);

if ($url) :
//	$url .= '&source=cache';
else :

	Loader::model('super_mint_font', 'theme_super_mint');
	$list = new SuperMintFontList();
	$list->addFont('p');
	$list->addFont('h1');
	$list->addFont('h2');
	$list->addFont('h3');
	$list->addFont('h4');
	$list->addFont('h5');
	$list->addFont('alternate');
	$list->addFont('small');

	$url = $list->getCssUrlFromList();
	Cache::set('googleapisurl',  $cID , $url);

//	$url .= '&source=generated';


endif;

echo $url;