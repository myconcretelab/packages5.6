<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
/*
* $innerContent - the html contents of the block. This should always be echo'd out in your template.
* $bName - block name (can be set by clicking on the block in edit mode and choosing "Custom Template" from the popup menu)
* $bPosition - the order number of this block in its area (first block is 1, second is 2, etc.)
* $totalBlocks - the total number of blocks in the area
* $b - the block object
* $stack - stack object (if the block is a stack)
* $c - the collection object (same as in theme templates -- e.g. if ($c->isEditMode()) { ... })
* $bv - the block_view object (same as $this in theme templates -- e.g. $bv->getThemePath())
*/
?>
<h3 class="title ccm-easyAccordion-title"><a href="#"><?php echo $bName; ?></a></h3>
<div class="panel ccm-easyAccordion-container" style="display:none">
	<div class="ccm-easyAccordion-content">
    	<?php echo $innerContent; ?>
    </div>
</div>