<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>

<div id="accordion">
	<h3><a href="#">Filesets / Stacks settings</a></h3>
	<div>
	  <table cellpadding="5" class="ads_edit" width="100%" >
		<tr>
			<td colspan="3"><p><?php echo t('Choose a Fileset or a Scrapbook to fill your Roundabout\'s elements') ?></p></td>
		</tr>
		   <tr>
			<td style="width:40%">
				<strong><?php echo t('File Set') ?>:</strong><br />
				<select id="fsID" name="fsID"><option value="0" onchange="refreshImagesList()">Loading...</option></select>			
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
				<strong><?php echo t('Elements below wil be used to fill your Roundabout\'s elements :') ?></strong><br /><br />
			    <div id="ccm-file-infos-list">
										   
			    </div>

			</td>
		   </tr>
	  </table>
	</div>

	<h3><a href="#">Roundabout Options</a></h3>
	<div>
                <table width="100%" cellpadding="12">
                <tr valign="top">
                        <td style="width:40%">
			
				<strong><?php echo t('Transition animation');?></strong><br />
				<small>All about the roudabout shape <a href="http://fredhq.com/projects/roundabout-shapes/">here</a></small>
			</td>
			<td>
				<?php echo $form->select('shape', $controller->addKeyToArray($controller->shapes) ,$shape) ?>
			</td>
		</tr>
		<tr>
			<td>
				<strong for="easing"><?php     echo t('Easing') ?>:</strong>
			</td>
			<td>
				<?php echo $form->select('easing', $controller->addKeyToArray($controller->easing_array), $easing)?>
                               
                        </td>
                </tr>
		<tr>
			<td><strong><?php     echo t('duration (milliseconds)')?></strong><br />
			<small><?php echo t('The length of time (in milliseconds) that all animations take to complete by default.')?></small>
			</td>
			<td>
				<input type="text" id="duration" name="duration" size="4"  style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-duration"></div>
			</td>
		</tr>
		<tr>
			<td><strong><?php     echo t('Minimum Opacity (0  to 1)');?></strong><br />
			<small><?php echo t('The lowest opacity value that a moveable item can be assigned. (Will be the opacity of the item farthest from the focus bearing.)')?></small>
			</td>
			<td>
			<input type="text" id="minOpacity" name="minOpacity" size="4"  style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
			<div id="range-minOpacity"></div>
			</td>
		</tr>
		<tr>
			<td><strong><?php     echo t('Maximum Opacity (0  to 1)');?></strong><br />
			<small><?php echo t('The greatest opacity value that a moveable item can be assigned. (Will be the opacity of the item in focus.)')?></small>
			</td>
			<td>
			<input type="text" id="maxOpacity" name="maxOpacity" size="4"  style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
			<div id="range-maxOpacity"></div>
			</td>
		</tr>
		<tr>
			<td><strong><?php     echo t('Minimum Scale (0  to 1)');?></strong><br />
			<small><?php echo t('The lowest percentage of font-size that a moveable item can be assigned. (Will be the scale of the item farthest from the focus bearing.)')?></small>
			</td>
			<td>
				<input type="text" id="minScale" name="minScale" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-minScale"></div>
			</td>
                </tr>
		<tr>
			<td><strong><?php     echo t('Bearing');?></strong><br />
			<small><?php echo t('The starting direction in which the Roundabout should point.)')?></small>
			</td>
			<td>
				<input type="text" id="bearing" name="bearing" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-bearing"></div>
			</td>
                </tr>
		<tr>
			<td><strong><?php     echo t('tilt');?></strong><br />
			<small><?php echo t('The starting angle at which the RoundaboutÕs plane should be tipped')?></small>
			</td>
			<td>
				<input type="text" id="tilt" name="tilt" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-tilt"></div>
			</td>
                </tr>
		<tr>
			<td><strong><?php     echo t('Minimum Z');?></strong><br />
			<small><?php echo t('The lowest z-index value that a moveable item can be assigned. (Will be the z-index of the item farthest from the focusBearing.')?></small>
			</td>
			<td>
				<input type="text" id="minZ" name="minZ" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-minZ"></div>
			</td>
                </tr>
		<tr>
			<td><strong><?php     echo t('Maximum Z');?></strong><br />
			<small><?php echo t('The greatest z-index value that a moveable item can be assigned. (Will be the z-index of the item in focus.)')?></small>
			</td>
			<td>
				<input type="text" id="maxZ" name="maxZ" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-maxZ"></div>
			</td>
                </tr>
		<tr>
			<td><strong><?php     echo t('Width ajust');?></strong><br />
			<small><?php echo t('If your gallery overflows in width, decrease the setting to adjust the width')?></small>
			</td>
			<td>
				<input type="text" id="maxW" name="maxW" size="4" style="border:0; font-weight:bold; width:30px; background:#fafafa;" readonly="readonly"  />
				<div id="range-maxW"></div>
			</td>
                </tr>
		</table>
	</div>

	<h3><a href="#">Resizing options</a></h3>
	<div>
        <table cellpadding="10" width="100%">
<!--
		<tr>
			<td style="width:40%">
				<label for="resize">Activate Picture Resizing ? <small>If yes, the picture will be resized to fit the gallery</small></label><br /><br />						
			</td>
			<td>
				<input type="checkbox" id="resize" name="resize" value='resize' <?php    echo $resize == 'resize' ? 'checked="checked"' : '' ?> />							
		</tr>
-->
		<tr>
			<td>
				<label for="">Elements size </label>
				<p><small><small>No compromises here, the size of each elments should be fixed. All images will be cropped to the dimension</small></p>
			</td>
			<td>
				Width : <input type="text" id="width" name="width" style="border:0; font-weight:bold; width:30px; background:#fafafa;" /> px									
				<div id="range-width"></div>																									
				<br /><br />
				Height : <input type="text" id="height" name="height" style="border:0; font-weight:bold; width:30px; background:#fafafa;" /> px									
				<div id="range-height"></div>																									
			</td>
		</tr>
        </table>
	</div>
</div>

<!-- end tab container -->
<!-- Tab Setup -->
<script>
var GET_FILESETS_URL = '<?php echo $get_filesets_url; ?>';
var GET_IMAGES_OPTIONS_URL = '<?php echo $get_images_options_tool; ?>';
var BLOCK_ID = '<?php echo $this->controller->bID; ?>';
var GET_BLOCK_FORM_TOOL_URL = '<?php echo $get_blocks_list_url ?>';
var PAGE_ID = <?php echo $c->getCollectionID() ?>;

	refreshFilesetList(<?php echo $content_type == 'fileset' ? $fsID : 0?>);
	<?php echo $content_type == 'scrapbook' ? "loadBlockInfos('$scrapbook');" : ''?>	
	setjQuerySlider('width',50,2000,'<?php    echo $width ?>');
	setjQuerySlider('height',50,1000,'<?php    echo $height?>');
	setjQuerySlider('duration',100,3000,'<?php    echo $duration?>');
	setjQuerySlider('minOpacity',0,1,'<?php    echo $minOpacity?>',.1);
	setjQuerySlider('maxOpacity',.1,1,'<?php    echo $maxOpacity?>',.1);
	setjQuerySlider('minScale',.1,1,'<?php    echo $minScale?>',.1);
	setjQuerySlider('maxScale',.1,1,'<?php    echo $maxScale?>',.1);
	setjQuerySlider('bearing',0,1,'<?php    echo $bearing?>',.1);
	setjQuerySlider('tilt',0,1,'<?php echo $tilt?>',.1);
	setjQuerySlider('minZ',1,200,'<?php    echo $minZ?>');
	setjQuerySlider('maxZ',1,200,'<?php    echo $maxZ?>');
	setjQuerySlider('maxW',20,100,'<?php    echo $maxW?>');

// Fixer le bug du rcID = 0
url = $('#ccm-block-form').attr('action');
url = url.replace("rcID=0", "rcID=" + PAGE_ID); 
$('#ccm-block-form').attr('action', url);
</script>