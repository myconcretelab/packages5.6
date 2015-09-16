<?php      defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('file/types');
Loader::model('file');
$al             = Loader::helper('concrete/asset_library');
$db             = Loader::db();
$ih             = Loader::helper('image');
srand();
$random = (rand());

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}
if ($_REQUEST['fID']) {
        $layer = File::getByID($_REQUEST['fID']);
}
//$pli = explode(',',$bi->fileLink);

?>
<style type="text/css">
	.w-border td {border:0px !important;}
	.w-border {background:#ffffff;margin-bottom:10px;}
	.delete-btn{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAcJJREFUeNqkUz1PAkEQfStggjESejU0GozlGqn8SGywkYIYY0IsaLCwIBTQUN5fMLGm8S8QSWwslVAYjAlUBEJDhCgWwp3nzN6eHqIVl8zN7rx5b+dm9oRt25jlmcOMj59f10JAkPcBcXIGWdECyqYn6TfGdZ9S9d4K4gQYx4WCtJzE+G/sKJudwpQABUGnGSf5vKzX60jmctL8SYzz+iCdls1mEzuplMIsLSC4iSUh1ClUlpHIZGStVkM0GsVNqVRlIJZIyG63i1AohMdKpUrZRQqXz4j7LWA7VSiR/WRSNhsNRRgOh+i02wgGg3hrtRSZelLmI6cExs7nKJGVtTX50uupMn0+H157PUWmZpYDXLoWUFPo6MC87jivx4MBFtxOWZYS11VipNdT98DWDVsPh2XQNLFIMdc4xpg9OZ3JMdIpRowSXVKt36+yuXvGxn+N0XS+3zj0kG+JSPEi261H5FCLmN9lUyNWyZ+Qag54eA6Hbfa8j1A88g+2qrlqCkKIZdovbAG7m8D5E3B5D9xR7IPsk/u7DextABd14OrBwd6J23YFligQ0IPwXE7lbedXUAPya5yHMiLuq5j1d/4SYAAj3NATBGE4PgAAAABJRU5ErkJggg==); display:block; width:16px; height:16px; background-repeat:no-repeat}
</style>

<table cellpadding="5" width="100%" class="w-border layer_table" id="layer-table_<?php echo $_REQUEST['layerID']?>">
	<tr>
		<td style="width:60%">
			<input type="hidden" name='layerID[]' value='<?php echo $_REQUEST['layerID']?>' />
			<div class="file-picker">
				<?php   $img['fType'] = FileType::T_IMAGE; ?>
				<?php  echo $al->file('layer_'.$_REQUEST['layerID'], 'layer_'.$_REQUEST['layerID'], t('Choose File'),$layer,$img);?> 
			</div>

		</td>
		<td>
			<label for="direction_<?php echo $_REQUEST['layerID']?>">Direction</label>
			<input type="checkbox" name="direction_<?php echo $_REQUEST['layerID']?>" class="{labelOn: 'LtR', labelOff: 'RtL'}" <?php echo $_REQUEST['direction'] == 'ltr' ? 'checked="checked"' : '' ?> />						
		</td>
		<td rowspan="2" style="cursor:move; background:#dddddd; width:10%" valign='top'>
			<a onclick="delete_layer($('#layer-table_<?php echo $_REQUEST['layerID']?>'))" class='delete-btn' >&nbsp;</a>
		</td>
	</tr>
	<tr>
		<td>
			<label for="offset_<?php echo $_REQUEST['layerID']?>">Offset <small>(speed)</small></label>
		</td>
		<td>
			<input type="text" id="offset_<?php echo $_REQUEST['layerID']?>" name="offset_<?php echo $_REQUEST['layerID']?>" style="border:0; width:20px; font-weight:bold" /> %
			<div id="slider-offset_<?php echo $_REQUEST['layerID']?>"></div>				
		</td>
	</tr>
</table>
<script type="text/javascript">

$( "#slider-offset_<?php echo $_REQUEST['layerID']?>").slider({
	value:<? echo $_REQUEST['offset'] ? $_REQUEST['offset'] : 5 ?>,
	min: 1,
	max: 100,
	slide: function( event, ui ) {
	$( "#offset_<?php echo $_REQUEST['layerID']?>" ).val(ui.value );
	}
});
	$( "#offset_<?php echo $_REQUEST['layerID']?>" ).val($( "#slider-offset_<?php echo $_REQUEST['layerID']?>" ).slider( "value" ) );

 $(":checkbox").iButton();
 
 function delete_layer (l) {
	l.remove();
 }

</script>
