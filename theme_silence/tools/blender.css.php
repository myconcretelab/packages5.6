<?php     defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Silence theme
 * @category Tools
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */


$time_start = microtime(true);

//@ini_set('zlib.output_compression_level', 1);
//@ob_start('ob_gzhandler');

$c = Page::getByID($_GET['c']);

$style = '';//Cache::get('theme_stylesheet_', $_GET['c'], false, true);

if ($style == '') :

        $file = Loader::helper('file');
        
        $pt = PageTheme::getByHandle('silence');
        $pkg = Package::getByHandle('theme_silence');

	$info = '(generated)';
	Loader::model('theme_options', 'theme_silence');
	$t = new ThemeOptions($c);
	//print_r($t);
	//$t->set_collection_object($c);
	
    $path = $t->packageRelativePath();

	$h = Loader::helper('mylab_theme', 'theme_silence');
	$h->set_collection_object($c);
	
	$style = $pt->parseStyleSheet('style.css');
		
	Loader::library('csstidy/class.csstidy', 'theme_silence' );
	$tidy = new csstidy();
	$tidy->parse($style);

        Loader::packageElement('blender_code.css', $pkg->getPackageHandle(), array('t' => $t,
                                                                                   'tidy' => $tidy,
                                                                                   'h' => $h,
                                                                                   'mobile' => $_GET['mobile']
                                                                                   ));
	//include_once(__DIR__ . '/blender_code.css.php');

	
	$style = $tidy->print->plain();
	$ratio = t('Compression ratio : ') . $tidy->print->get_ratio();

    if (file_exists(DIR_BASE . '/css/silence/styles.css'))
    	$style .= $file->getContents(DIR_BASE . '/css/silence/styles.css');

	// Adding all css file needed for the theme	
	$beforeStyle .= $file->getContents($pt->getThemeDirectory() . '/css/columnal.css');
	$beforeStyle .= $file->getContents($pt->getThemeDirectory() . '/typography.css');
	$beforeStyle .= $pt->parseStyleSheet('css/static.css');
	
	$style = $beforeStyle . $style;
	
	Cache::set('theme_stylesheet_',  $_GET['c'] , $style);

else :
	$info = '(from Concrete5 caching system)';
	$ratio = '';
endif;



header("Content-Type: text/css");
//header("Date: ". date("D, j M Y G:i:s", $stat) ." GMT");
//header("Expires: ". gmdate("D, j M Y H:i:s", time() + DAY) ." GMT");
//header("Cache-Control: max-age=86400, must-revalidate"); // HTTP/1.1
//header("Pragma: cache_asset");        // HTTP/1.0	

	//var_dump($tidy->css);


$time_end = microtime(true);
$time = $time_end - $time_start;

echo '/* Generated Time ' . $info . ' : ' . $time . ' ms  ' . $ratio . "*/ \n\n";


echo $style;
