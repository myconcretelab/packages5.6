<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

// We are here in the right wrapper for both slider and dropdown

$layout = array();
$k = 0;

/*
 *	We will construct the layout based on blocks name
 */
foreach ($ni->blocks as $n => $block) :
	$block->title = $block->getBlockName() ? $block->getBlockName() : '';

	if (stripos($block->title, '-before-') === 0) :
		$block->title = str_replace('-before-', '', $block->title);
		$layout['header'][] = $block;
	elseif (stripos($block->title, '-follow-') === 0) :
		$block->title = str_replace('-follow-', '', $block->title);
		$layout['columns'][$k][] = $block;
	elseif (stripos($block->title, '-after-') === 0) :
		$block->title = str_replace('-after-', '', $block->title);
		$layout['footer'][] = $block;
	else :
		$k ++;
		$layout['columns'][$k][] = $block;
	endif;
endforeach?>
<div class='nav-pane stack-pane' style="padding:20px; <?php if(!$o->full_width_mega) : ?>width:<?php echo (intval(count($layout['columns']) * $o->mega_columns_width)) ?>px<?php endif ?>">

<?php

/*
 *	If they are blocks for the header full width
 */

if (isset($layout['header'])):
	echo '<div class="row-fluid">';
	foreach ($layout['header'] as $block) {
		// On affiche le titre et le bloc;
		echo '<div class="span12">';
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	 	echo '</div> <!-- span12 -->';
	}
	echo '</div> <!-- row-fluid -->';
endif;

/*
 *	If they are blocks for columns in the middle
 */

if (isset($layout['columns'])):
	$span = 'span' . (intval( 12 / (count($layout['columns']))));
	echo '<div class="row-fluid">';
	// SI il y avait un header on le sépare
	if (isset($layout['header'])) echo '<hr class="dashed">';
	foreach ($layout['columns'] as $columns) {
		echo '<div class="' . $span . '">';
		foreach ($columns as $block) {
			echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
		 	$block->display();
		}
	 	echo '</div> <!-- .' . $span . '-->';
	}
	echo '</div> <!-- row-fluid -->';
endif;


/*
 *	If they are blocks for the footer full width
 */

if (isset($layout['footer'])):
	echo '<div class="row-fluid">';
	if (isset($layout['columns'])) echo '<hr class="dashed">';
	foreach ($layout['footer'] as $n => $block) {
		// On affiche le titre et le bloc;
		echo '<div class="span12">';
		echo ($block->title && $o->display_title_mega_menu) ? $block->title : null;
	 	$block->display();
	 	echo '</div>';
	}
	echo '</div> <!-- row-fluid -->';
endif;

echo "</div><!-- stack-pane -->";
