<?php defined('C5_EXECUTE') or die("Access Denied.");

global $mobile_active;
$navItems = $controller->getNavItems();


foreach ($navItems as $ni) {
	$classes = array();
	
	if ($ni->isCurrent) {
		//class for the page currently being viewed
		$classes[] = 'nav-selected';
	}
	
	if ($ni->inPath) {
		//class for parent items of the page currently being viewed
		$classes[] = 'nav-path-selected';
	}

	if ($ni->inPath || $ni->isCurrent) $classes[] = 'selected';
	
	//Put all classes together into one space-separated string
	$ni->classes = implode(" ", $classes);
}

echo '<ul class="nav">'; //opens the top-level menu
ob_start();
foreach ($navItems as $ni) {
	
	echo '<li class="' . $ni->classes . '">'; //opens a nav item
	
	echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $ni->name . '</a>';
	
	if ($ni->hasSubmenu) {
		echo '<ul>'; //opens a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
	}
}
$nav = ob_get_clean();
echo $nav;

if ($mobile_active) :
	echo '</ul>'; //closes the top-level menu
	echo '<nav id="mobile_nav" class="mm-menu"><ul id="mmobile">' . $nav . '</ul></nav>'; 
endif;