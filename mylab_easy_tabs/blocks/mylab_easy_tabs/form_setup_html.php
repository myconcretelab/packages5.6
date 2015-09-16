<?php  defined('C5_EXECUTE') or die(_("Access Denied.")) ?>

<div id="accordion">
	<h3><a href="#">Labels & files</a></h3>
	<div>
	<?php  if ($rows > 1) : ?>
		<div id="ccm-easyTab-item-list">
			<table width="100%" class='ccm-easyTab-item-table'>
			  <tr>
			    <th  width="20">Place</th>
			    <th  width="130">Name</th>
			    <th  width="300">thumbnail
			      <!--<a onclick='showAdvanced($(this)'>Show options</a>--></th>
			  </tr>
			
			  <?php  for ($i = 0 ; $i < ($rows) ; $i++ ) : ?>
			
			  <tr>
			    <td class='item-id'><?php echo $i+1?></td>
			    <td><input id='tName' type="text" name="tName[]" class="ccm-easyTab-name" id='tName' value="<?php echo $names[$i]?>" /></td>
			    <td class='advanced' id="advanced-file"><?php echo $al->file('ccm-easyTab-file-'.$i, 'fID[]', t('Choose File'), $fIDs[$i] ? File::getByID($fIDs[$i]) : null);?></td>
			  </tr>
			  <?php  endfor ?>
			</table>
			<br /><br />
		</div>
	<?php  else : ?>
	<h2 style='color:#ff0011'>Please add rows at your layout</h2>	
	<?php  endif ?>
	</div>
	
	
	<h3><a href="#">Default Template options</a></h3>
	<div>
		<label for='type'>Display type</label>
		<select id='type' name='type' title='type'>
			<option value='easyTabs' <?php echo $type == 'easyTabs' ? "selected='selected'" : ''?>>as top tabs</option>
			<option value='easySlides' <?php echo $type == 'easySlides' ? "selected='selected'" : ''?>>as lateral tabs</option>
		</select>
		<br /><br />
		<label for="history">Enable broswer history on top tab</label> 
		<select id='history' name='history' title='history'>
			<option value='0' <?php echo !$history ? "selected='selected'" : ''?>>No</option>
			<option value='1' <?php echo $history ? "selected='selected'" : ''?>>Yes</option>
		</select>
		<br /><small>The History tool allows you to take control of the browser's back button. This means that when the user clicks on the browser's back or forward buttons your JavaScript functions will notified. This is a very powerful tool but with a page reload with every click.</small>
	</div>
	<h3><a href="#">Multi skins template options</a></h3>
	<div>
		<p>These options will only be used if you select "<strong>Multi-skin</strong>"as a custom template</p>
		<table class='ccm-easyTab-item-table'>
			<tr>
				<td>
					<label for="mst_skin">Select the skin:</label>
					<?php  echo $form->select('mst_skin', $controller->addKeyToArray($controller->mst_skins),$mst_skin) ?>
				</td>
				<td>
					<label for="mst_effect">Select the effect:</label>
					<?php  echo $form->select('mst_effect', $controller->addKeyToArray($controller->mst_effects),$mst_effect) ?>
					
				</td>
				<td>
					<label for="mst_position">Select the Position:</label>
					<?php  echo $form->select('mst_position', $controller->addKeyToArray($controller->mst_positions),$mst_position) ?>
					
				</td>
			</tr>
		</table>
		

	</div>
</div>	
<script type="text/javascript">
$(window).ready(function() {        
	 $(':checkbox').iToggle();
	$( "#accordion" ).accordion({autoHeight:false,collapsible: true});
});
</script>