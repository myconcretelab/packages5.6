<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
?>

<div id="accordion">
	<h3><a href="#">Filesets / Scrabbook settings</a></h3>
	<div>
	  <table cellpadding="5" class="ads_edit" width="100%" >
		<tr>
			<td colspan="3"><p><?php echo t('Choose a Fileset or a Stack to fill your Kwick\'s elements') ?></p></td>
		</tr>
		   <tr>
			<td style="width:40%">
				<strong><?php echo t('File Set') ?>:</strong><br />
				<select id="fsID" name="fsID" onchange="refreshImagesList()"><option value="0">Loading...</option></select>			
			</td>
			<td style="width:10%">
				<strong><?php echo t('Or') ?>:</strong>
			</td>
			<td style="width:40%">
				<strong><?php echo t('Stacks')?></strong><br />
					<select name="stID" onchange="loadBlockInfos(this.value)">
						<option value="0">Choose a Stack</option>
					<?php  
					foreach($_stacks as $b){
						echo '<option value="' . $b->cID . '"';
						if ($b->cID == $stID) {
							echo ' selected="selected" ';
						}
						echo '>' . $b->getCollectionName() . '</option>';
					}
					?>
					</select>
			</td>
		   </tr>
		   <tr>
			<td colspan="3" style="border:1px solid #ccc">
				<strong><?php echo t('Elements below wil be used to fill your Kwiks\'s elements :') ?></strong><br /><br />
			    <div id="ccm-file-infos-list">
										   
			    </div>

			</td>
		   </tr>
	  </table>
	</div>
	
	
	


	<h3><a href="#">Options</a></h3>
	<div>
	<table width="100%" cellpadding="10" style="padding:0; margin:0">
		<tr>
			<td><strong>Max<strong><br> <small><?php      echo t('How much in percent your picture will be open (compared to the width of the container of the gallery)')?></small></td>
			<td><input type="text" name="max" value="<?=$max?>" size="5"></td>
		</tr>
		<tr>
			<td><strong>Width<strong><br> <small><?php      echo t('The width of the gallery (images wil be resized to fit in the percent uppond)')?></small></td>
			<td><input type="text" name="width" value="<?php echo $width?>" size="5"></td>
		</tr>
		<tr>
			<td><label  for="spacing"><?php      echo t('Margin between picture<small> (pixels)<br>All css will be overwrited</small>');?></label></td>
			<td><input type="text" id="spacing" name="spacing" size="4" value="<?php echo $spacing?>" /></td>
		</tr>
		<tr>
			<td><label  for="duration"><?php      echo t('Duration <small>(milliseconds)</small>');?></label></td>
			<td><input type="text" id="duration" name="duration" size="4" value="<?php echo $duration?>" /></td>
		</tr>
		<tr>
			<td><label  for="defaultKwick"><?php      echo t('Witch open<small> (0 for none)<br>When none open, the Kwiks close when mouse leave</small>');?></label></td>
			<td><input type="text" id="defaultKwick" name="defaultKwick" size="4" value="<?php echo $defaultKwick?>" /></td>
		</tr>
		<tr>
			<td><label for="options[]"><?php      echo t('Homogenize height of elements')?></label></td>
			<td><input type="checkbox" name="options[]" value="homogenize_height" <?php echo in_array('homogenize_height', $options) ? 'checked' : '' ?> /></td>
		</tr>
		<tr>
			<td>
				<label  for="easing"><?php      echo t('Easing');?></label>
			</td>
			<td>
				 
				<select name='easing'>
					<option value="jswing" <?=$easing == "jswing" ? 'selected' :''?> >jswing</option>
					<option value="easeInQuad" <?=$easing == "easeInQuad" ? 'selected' :''?> >easeInQuad</option>
					<option value="easeOutQuad" <?=$easing == "easeOutQuad" ? 'selected' :''?> >easeOutQuad</option>
					<option value="easeInOutQuad" <?=$easing == "easeInOutQuad" ? 'selected' :''?> >easeInOutQuad</option>
					<option value="easeInCubic" <?=$easing == "easeInCubic" ? 'selected' :''?> >easeInCubic</option>
					<option value="easeOutCubic" <?=$easing == "easeOutCubic" ? 'selected' :''?> >easeOutCubic</option>
					<option value="easeInOutCubic" <?=$easing == "easeInOutCubic" ? 'selected' :''?> >easeInOutCubic</option>
					<option value="easeInQuart" <?=$easing == "easeInQuart" ? 'selected' :''?> >easeInQuart</option>
					<option value="easeOutQuart" <?=$easing == "easeOutQuart" ? 'selected' :''?> >easeOutQuart</option>
					<option value="easeInOutQuart" <?=$easing == "easeInOutQuart" ? 'selected' :''?> >easeInOutQuart</option>
					<option value="easeInQuint" <?=$easing == "easeInQuint" ? 'selected' :''?> >easeInQuint</option>
					<option value="easeOutQuint" <?=$easing == "easeOutQuint" ? 'selected' :''?> >easeOutQuint</option>
					<option value="easeInOutQuint" <?=$easing == "easeInOutQuint" ? 'selected' :''?> >easeInOutQuint</option>
					<option value="easeInSine" <?=$easing == "easeInSine" ? 'selected' :''?> >easeInSine</option>
					<option value="easeOutSine" <?=$easing == "easeOutSine" ? 'selected' :''?> >easeOutSine</option>
					<option value="easeInOutSine" <?=$easing == "easeInOutSine" ? 'selected' :''?> >easeInOutSine</option>
					<option value="easeInExpo" <?=$easing == "easeInExpo" ? 'selected' :''?> >easeInExpo</option>
					<option value="easeOutExpo" <?=$easing == "easeOutExpo" ? 'selected' :''?> >easeOutExpo</option>
					<option value="easeInOutExpo" <?=$easing == "easeInOutExpo" ? 'selected' :''?> >easeInOutExpo</option>
					<option value="easeInCirc" <?=$easing == "easeInCirc" ? 'selected' :''?> >easeInCirc</option>
					<option value="easeOutCirc" <?=$easing == "easeOutCirc" ? 'selected' :''?> >easeOutCirc</option>
					<option value="easeInOutCirc" <?=$easing == "easeInOutCirc" ? 'selected' :''?> >easeInOutCirc</option>
					<option value="easeInElastic" <?=$easing == "easeInElastic" ? 'selected' :''?> >easeInElastic</option>
					<option value="easeOutElastic" <?=$easing == "easeOutElastic" ? 'selected' :''?> >easeOutElastic</option>
					<option value="easeInOutElastic" <?=$easing == "easeInOutElastic" ? 'selected' :''?> >easeInOutElastic</option>
					<option value="easeInBack" <?=$easing == "easeInBack" ? 'selected' :''?> >easeInBack</option>
					<option value="easeOutBack" <?=$easing == "easeOutBack" ? 'selected' :''?> >easeOutBack</option>
					<option value="easeInOutBack" <?=$easing == "easeInOutBack" ? 'selected' :''?> >easeInOutBack</option>
					<option value="easeInBounce" <?=$easing == "easeInBounce" ? 'selected' :''?> >easeInBounce</option>
					<option value="easeOutBounce" <?=$easing == "easeOutBounce" ? 'selected' :''?> >easeOutBounce</option>
					<option value="easeInOutBounce" <?=$easing == "easeInOutBounce" ? 'selected' :''?> >easeInOutBounce</option>
				</select>                               
			</td>
		</tr>
		<tr>
			<td>
				<label for='event'><?php echo t('Mouse Event :')?> </label>
			</td>
			<td>
				<select name="event">
					<option value="mouseover" <?=$event == "mousover" ? 'selected' : '' ?> >Mouse over</option>
					<option value="click" <?=$event == "click" ? 'selected' : '' ?> >Mouse click</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="sorted-selectPage" <?php     if ($link != "page") { echo 'style="display:none"';}?>>
				<?php    
					echo $pageSelector->selectPage('linkPageID', $linkPageID);
				?>
				</div>
		
			</td>
		</tr>
		</table>
	</div>
</div>

<!-- end tab container -->
<!-- Tab Setup -->
<script type="text/javascript">

var GET_FILESETS_URL = '<?php echo $get_filesets_url; ?>';
var GET_IMAGES_OPTIONS_URL = '<?php echo $get_images_options_tool; ?>';
var BLOCK_ID = '<?php echo $this->controller->bID; ?>';
var GET_BLOCK_FORM_TOOL_URL = '<?php echo $get_blocks_list_url ?>';
var PAGE_ID = <?php echo $c->getCollectionID() ?>;

refreshFilesetList(<?php echo $content_type == 'fileset' ? $fsID : 0?>);
<?php echo $content_type == 'stacks' ? "loadBlockInfos('$stID');" : ''?>	

$(function () {	
	$('select#fsID').change(function() {
		console.log(this);
		if (this.value == -1) {
                    openFileManager();
		} else if (this.value > 0) {
                    refreshImagesList();
		}
	});
	
        $('.ccm-sitemap-select-page').click(function(){
            // On voudrait que le radio outon se selectionne
        });
});
// Fixer le bug du rcID = 0
url = $('#ccm-block-form').attr('action');
url = url.replace("rcID=0", "rcID=" + PAGE_ID); 
$('#ccm-block-form').attr('action', url);

</script>


