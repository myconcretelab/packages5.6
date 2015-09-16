<?php  
	defined('C5_EXECUTE') or die("Access Denied.");
	$cc = loader::helper('capsule_code', 'advanced_content');
	if (!$capscoded) $capscoded = $cc->do_capscode($controller->getContent());
	print $capscoded;
?>