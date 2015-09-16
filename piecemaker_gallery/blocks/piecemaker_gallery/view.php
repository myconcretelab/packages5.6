<?php     defined('C5_EXECUTE') or die(_("Access Denied."));?>

<?php  $c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>

<div class="ccm-edit-mode-disabled-item" style="height:<?php echo $height?>px">
	<div style="padding: <?php echo intval($height) / 2 ?>px 0px 0px 0px">
		<?php  echo t('Content disabled in edit mode.')?>
    </div>
</div>

<?php  else : ?>
        <div id="piecemaker-gallery-<?php   echo $bID?>" style="overflow:visible" class="piecemaker-gallery">
                You need to upgrade your Flash Player !
        </div>
<?php   endif ?>


<script type="text/javascript">
$(document).ready(function() {
	var width = <?php echo $width?>  + <?php echo isset($awidth) ? $awidth : 80 // additional width?>;
	var height = <?php echo $height // images height ?> + <?php echo $options[3] // shadow distance ?> + <?php echo isset($aheight) ? $aheight : 50// additional height?>;
        var flashvars = {}; flashvars.cssSource = "<?php echo $get_block_asset_url?>/piecemaker.css"; flashvars.xmlSource = '<?php echo ($get_xml_tools_url .'?bID='. $bID)?>';
        var params = {}; params.play = "true"; params.menu = "false"; params.scale = "showall"; params.wmode = "transparent"; params.allowfullscreen = "true"; params.allowscriptaccess = "always"; params.allownetworking = "all";       
        swfobject.embedSWF('<?php echo $get_block_asset_url?>/swf/piecemaker.swf', 'piecemaker-gallery-<?php echo $bID?>', width, height, '10', null, flashvars, params, null);
});
	
</script>
<style>
    object#piecemaker-gallery-<?php   echo $bID?> {
        height: <?php echo $height + $options[3]  + ( isset($aheight) ? $aheight : 50) ?>px;
    }
</style>