<!-- todo : Like in advanced slider --> <link rel="stylesheet" href="<?php echo $block_url?>/auto.css" />

<pre><? //print_r($stacks)?></pre>

<table border="0" cellpadding="15" width="100%" class="admin">
	<tr>
		<td style="width:45%">
			<strong><?php   echo t('Stacks')?></strong>
		</td>
		<td>
			<select name="stID" onchange="loadBlockInfos(this.value)">
				<option value="0">Choose a Stack</option>
			<?php  
			foreach($stacks as $b){
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
		<td colspan="2">
			<div id="blocks_infos"></div>
		</td>
	</tr>
	<tr>
		<td>
			<?php print $ah->button_js('Add a animation type', 'addAnimationType()', $buttonAlign=ÕleftÕ, $innerClass=null, $args = array()) ?>
			<br /><br /><small>Add animation style as much you want or just select 'all'</small>
			
		</td>
		<td>
			<div id="array_types">
				<? foreach ($type as $t) : ?>
				<div class="type">
					<?php echo $form->select('type[]', $this->controller->addKeyToArray($this->controller->availableTypes),$t)?>
					<a href="#" onclick="removeAnimationType($(this))">Remove</a>
				</div>
				<?php endforeach ?>
			</div>
		</td>
	</tr>
	<tr><td><strong>Slider With</strong></td>
	    <td><input type="text" id="width" name="width" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /> px
			<div id="range-width"></div>	
	    </td>
	</tr>
	<tr><td><strong>Slider Height</strong></td>
	    <td><input type="text" id="height" name="height" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /> px
			<div id="range-height"></div>	
	    </td>
	</tr>
	<tr><td><strong>Diaporama delay</strong> <br /><strong>0 for disable diaporama</strong></td>
	    <td><input type="text" id="delay" name="delay" style="border:0; font-weight:bold; width:50px; background:#fafafa;"  /> ms
			<div id="range-delay"></div>	
	    </td>
	</tr>

</table>
<script type="text/javascript">
	var GET_BLOCK_FORM_TOOL_URL = '<?php echo $get_blocks_list_url ?>';
	var BLOCK_ID = '<?php  echo $this->controller->bID; ?>';

	setjQuerySlider('width',10,1500,<?php echo $width ?>);
	setjQuerySlider('height',10,800,<?php echo $height ?>);
	setjQuerySlider('delay',0,10000,<?php echo $delay ?>);
	loadBlockInfos('<?php echo $stID ?>');
	
	
</script>