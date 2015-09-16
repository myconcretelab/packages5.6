<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$navItems = $controller->getNavItems();
$ih = Loader::helper('image');

foreach ($navItems as $ni) {
	$classes = array();

	if ($ni->isCurrent) {
		//class for the page currently being viewed
		//$classes[] = 'visited';
	}

	if ($ni->inPath) {
		//class for parent items of the page currently being viewed
		$classes[] = 'visited';
	}

	$ni->classes = implode(" ", $classes);
}


//*** Step 2 of 2: Output menu HTML ***/

?>
<div id="mainmenu">
<ul class="sf-menu">
<?php

foreach ($navItems as $ni) {
	unset($icon);
	// L'attribut image (du filemanager)
	if ($ni->cObj->getAttribute('icon_font')) :
		$icon = '<i class="fa fa-lg fa-fw ' . $ni->cObj->getAttribute('icon_font') . '"></i>';
	elseif (is_object($ni->cObj->getAttribute('icon'))) :
		$icon = '<img src="' . $ih->getThumbnail($ni->cObj->getAttribute('icon'),18,18)->src . '" alt="" />';
	// L'attribut text (repsenentant le nom d'un icone)
	elseif (defined(ICON_RELATIVE_TO_PAGE_NAME)) :
		$p = unserialize(ICON_RELATIVE_TO_PAGE_NAME);
		if (isset($p[$ni->name]))
			$icon = '<i class="fa fa-lg  fa-fw' . $p[$ni->name] . '"></i>';
	endif;
	?>
	<li><a href="<?php echo $ni->url ?>" id="<?php echo $ni->classes?>"><?php if(isset($icon))  echo '<span class="home">' . $icon . '</span>'?><?php echo $ni->name ?></a>

	<?php
	if ($ni->hasSubmenu) {
		echo '<ul>'; //opens a dropdown sub-menu
	} else {
		echo '</li>'; //closes a nav item
		echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
	}
}

echo '</ul></div>'; //closes the top-level menu

?>
       <!-- Responsive Menu -->
        
        <form id="responsive-menu" action="#" method="post">
          <select>
            <option value=""><?php echo t('Navigation')?></option>
<?php foreach ($navItems as $ni) : ?>
            <option value="<?php echo $ni->url ?>"><?php echo $ni->name ?></option>
<?php endforeach ?>
          </select>
        </form>
