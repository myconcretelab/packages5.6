<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

//@ini_set('zlib.output_compression_level', 1);
//@ob_start('ob_gzhandler');

$file = Loader::helper('file');

header("Content-type: text/javascript");

Loader::packageElement('init_javascript','content_slider',array(
                                                                'bID'=>$_REQUEST['bID'],
                                                                'cID'=>$_REQUEST['cID'])
                                                                
                       );

echo $file->getContents(BlockType::getByHandle('content_slider')->getBlockTypePath() . '/global_javascript/jquery.svUltimateSlider.min.js');


exit;
