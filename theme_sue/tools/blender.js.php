<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Sue theme
 * @category Tools
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

$time_start = microtime(true);

@ini_set('zlib.output_compression_level', 1);
@ob_start('ob_gzhandler');

$c = Page::getByID($_GET['c']);

$js = Cache::get('theme_js_', 'custom');

if ($js == '') :

        $file = Loader::helper('file');

	$pt = PageTheme::getByHandle('sue');

	$info = '(generated)';
/*	Loader::model('theme_sue_options', 'theme_sue');
	$t = new ThemeSueOptions();
	$t->set_collection_object($c);
*/	
	
	// Faire la boucle de recherche de tous les fichiers js
	$js .= $file->getContents($pt->getThemeDirectory() . '/js/superfish.js');
	$js .= $file->getContents($pt->getThemeDirectory() . '/js/tools.js');
	$js .= $file->getContents($pt->getThemeDirectory() . '/js/fmslideshow.min.js');
	$js .= $file->getContents($pt->getThemeDirectory() . '/script.js');
	//$js .= $file->getContents($pt->getThemeDirectory() . '/js/tinynav.js');
		
	Cache::set('theme_js_',  'custom' , $js);

else :
	$info = '(from Concrete5 caching system)';
endif;



header("Content-Type: text/javascript");


$time_end = microtime(true);
$time = $time_end - $time_start;

echo '// Generated Time ' . $info . ' : ' . $time . " ms \n\n";


echo $js;
