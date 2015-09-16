<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

// Cette requete peut prendre plus d'une demi seconde !
$navItems = $controller->getNavItems();

foreach ($navItems as $ni) {
	$classes = array();
        $selected = '';
	
	if ($ni->is_current) {
		//class for the page currently being viewed
		$classes[] = 'nav-selected';
                $selected = 'SELECTED';
                
	}
	
	if ($ni->in_path) {
		//class for parent items of the page currently being viewed
		$classes[] = 'nav-path-selected';
	}

	//Put all classes together into one space-separated string
	$ni->classes = implode(" ", $classes);
}

/******************************************************************************
* DESIGNERS: CUSTOMIZE THE HTML STARTING HERE...
*/
//print_r($navItems);
echo '<select class="nav-select" id="mobile_nav">'; //opens the top-level menu

foreach ($navItems as $ni) {
	
	if ($ni->is_current) $selected = 'SELECTED'; else $selected = '';

         $sub_menu_caracter = $ni->has_submenu ? '&nbsp;&darr;' : '';

	
	echo '<option '  . $selected . ' class="' . $ni->classes . '"' ; //opens a nav item
	
	echo ' value="' . $ni->url . '" target="' . $ni->target  . '">' . str_repeat('&rsaquo;', ($ni->level - 1)) . '&nbsp;' . $ni->name . $sub_menu_caracter . '</option>';
	
        /*
	if ($ni->has_submenu) {
		echo '<ul>'; //opens a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		echo str_repeat('</ul></li>', $ni->sub_depth); //closes dropdown sub-menu(s) and their top-level nav item(s)
	}
        */
}

echo '</select>'; //closes the top-level menu

$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<!-- Mobile nav Generated in <?php   echo $time ?> secs -->