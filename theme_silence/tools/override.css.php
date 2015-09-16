<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

$time_start = microtime(true);
$c = Page::getByID($_GET['c']);
$file = Loader::helper('file');    
$pt = PageTheme::getByHandle('silence');
$pkg = Package::getByHandle('theme_silence');

$info = '(generated)';

// Les options
Loader::model('theme_options', 'theme_silence');
$t = new ThemeOptions($c);

$path = $t->packageRelativePath();

$h = Loader::helper('mylab_theme', 'theme_silence');
$h->set_collection_object($c);

// On ecrit les overrides.
ob_start();
	Loader::packageElement('override.css', $pkg->getPackageHandle(), array('t' => $t,                                                                                  
                                                                        'h' => $h,
                                                                        'mobile' => $_GET['mobile'],
                                                                        'c' => $c
                                                                           ));
$style = ob_get_clean();


header("Content-Type: text/css");

$time_end = microtime(true);
$time = $time_end - $time_start;

echo '/* Generated Time ' . $info . ' : ' . $time . ' ms  ' . $ratio . "*/ \n\n";
echo $style;
