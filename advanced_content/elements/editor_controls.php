<?php  defined('C5_EXECUTE') or die("Access Denied."); ?> 
<div class="ccm-editor-controls-left-cap" <?php  if (isset($editor_width)) { ?>style="width: <?php echo $editor_width?>px"<?php  } ?>>
<div class="ccm-editor-controls-right-cap">
<div class="ccm-editor-controls">
<ul>
<li ccm-file-manager-field="rich-text-editor-image"><a class="ccm-file-manager-launch" onclick="ccm_editorSetupImagePicker(); return false" href="#"><?php echo t('Add Image')?></a></li>
<li><a class="ccm-file-manager-launch" onclick="ccm_editorSetupFilePicker(); return false;" href="#"><?php echo t('Add File')?></a></li>
<li><a href="#" onclick="ccm_editorSitemapOverlay();"><?php echo t('Insert Link to Page')?></a></li>
<li><a href="#" onclick="ccmEditorAdvancedContentOverlay();"><?php echo t('Add a element !')?></a></li>
</ul>
</div>
</div>
</div>
<div id="rich-text-editor-image-fm-display">
<input type="hidden" name="fType" class="ccm-file-manager-filter" value="<?php echo FileType::T_IMAGE?>" />
</div>

<div class="ccm-spacer">&nbsp;</div>
<script type="text/javascript">
$(function() {
	ccm_activateFileSelectors();

});
function ccmEditorAdvancedContentOverlay() {
    $.fn.dialog.open({
        title: '<?php  echo t("Choose an Extended function") ?>',
        href: '<?php  $urlshelper = Loader::helper("concrete/urls"); echo $urlshelper->getToolsURL("get_advanced_overlay","advanced_content") ?>',
        width: '650',
        modal: false,
        appendButtons:true,
        height: '500'
    });
}
</script>


