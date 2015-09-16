<?php  defined('C5_EXECUTE') or die(_("Access Denied."))?>
<!-- <a href="#">Toto</a> -->
<div>
	<ul class="list">
<?php 
// We are here in the right wrapper for both slider and dropdown
foreach ($ni->blocks as $n => $block) {
	echo '<li><span>';
	// On affiche le titre et le bloc;
	echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
 	$block->display();
 	echo '</span></li>';
}
?>
	</ul>
</div>