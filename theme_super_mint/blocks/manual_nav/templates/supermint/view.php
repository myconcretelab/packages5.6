<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
$c = Page::getCurrentPage();
// Les options
Loader::model('theme_super_mint_options', 'theme_super_mint');
$t = new ThemeSuperMintOptions($c);

?>

<ul class="secondary-nav">
<?php  foreach ($links as $link):
	$cssClasses = array();
	
	if ($link->isCurrent) {
		$cssClasses[] = 'nav-selected';
	}
	
	if ($link->inPath) {
		$cssClasses[] = 'nav-path-selected';
	}
	
	$cssClasses = implode(' ', $cssClasses);
	?>
	
	<li class="<?php  echo $cssClasses; ?>">
		<a href="<?php  echo $link->url; ?>" class="<?php  echo $cssClasses; ?>">
			<?php  echo htmlentities($link->text, ENT_QUOTES, APP_CHARSET); ?>
		</a>
	</li>

<?php  endforeach; ?>
</ul>
