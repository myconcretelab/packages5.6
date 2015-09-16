<?php  defined('C5_EXECUTE') or die("Access Denied.");
$fc = Loader::helper('form/color');

?>

<table style="width:100%" class="tbl">
<tr>
	<?php if (is_array($slider_list)) : ?>
		<td style="width:40%">
			<strong><?php echo t('Choose a slider to display') ?></strong>			
		</td>
		<td>
			<select name="csID" id="csID">
			<?php foreach ($slider_list as $key => $slider) :?>
					<option value="<?php echo $slider->csID ?>" <?php echo $slider->csID == $specs->csID ? 'selected' : '' ?>><?php echo $slider->name ?></option>
			<?php endforeach ?>
			</select>			
		</td>
	<?php else : ?>
		<td colspan="2">
			<strong><?php echo t('They are no slider created yet') ?><a href="<?php echo $this->url('/dashboard/core_commerce/creative_slider') ?>"><?php echo t('go ahead and create a stunning slider') ?></a></strong>			
		</td>
	<?php endif ?>
	</tr>	
	<!-- Not working for the moment
	<tr>
		<td>
			<strong><?php echo t('Animation mode') ?></strong>			
		</td>
		<td>
			
			<select name="mode" id="mode">
				<option value="fade" <?php echo $specs->mode == 'fade' ? 'selected' : '' ?>><?php echo t('Fade') ?></option>
				<option value="vertical" <?php echo $specs->mode == 'vertical' ? 'selected' : '' ?>><?php echo t('Vertical') ?></option>
				<option value="horizontal" <?php echo $specs->mode == 'horizontal' ? 'selected' : '' ?>><?php echo t('Horizontal') ?></option>
			</select>			
		</td>
	</tr>
	-->
	<input type="hidden" name="mode" value="fade">
	<tr>
		<td>
			<strong><?php echo t('Animation speed') ?></strong>			
		</td>
		<td>
			<div class="jrange" data-id="speed" data-min="0" data-max="4000" data-value="<?php echo $specs->speed ?>" data-step="100"></div>
			<input type="text" id="speed" name="speed" readonly value="<?php echo $specs->speed ?>"> ms			
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Diaporama (auto play)') ?></strong>			
		</td>
		<td>
			<input type="checkbox" name="diaporama" value="on" <?php if($specs->diaporama) echo 'checked' ?>>
		</td>
	</tr>
	<tr>
		<td>
			<strong for="pause"><?php echo t('Pause time in milliseconds (if diaporama)') ?></strong>
		</td>
		<td>
			<div class="jrange" data-id="pause" data-min="500" data-max="10000" data-value="<?php echo $specs->pause ?>" data-step="100"></div>
			<input type="text" id="pause" name="pause" readonly value="<?php echo $specs->pause ?>"> ms			
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Display Diaporama Controls (Play-Pause)') ?></strong>			
		</td>
		<td>
			<select name="diaporamaControls" id="pagerPosition">
				<option value="disabled" <?php echo $specs->diaporamaControls == 'disabled' ? 'selected' : '' ?>><?php echo t('Don\'t display') ?></option>
				<option value="display" <?php echo $specs->diaporamaControls == 'display' ? 'selected' : '' ?>><?php echo t('Display') ?></option>
			</select>			
		</td>
	</tr>
	<tr>
		<td>
			<strong for="controlsSize"><?php echo t('Controls bullet size in pixels') ?></strong>
		</td>
		<td>
			<div class="jrange" data-id="controlsSize" data-min="1" data-max="50" data-value="<?php echo $specs->controlsSize ?>" data-step="1"></div>
			<input type="text" id="controlsSize" name="controlsSize" readonly value="<?php echo $specs->controlsSize ?>"> px			
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Pager position') ?></strong>			
		</td>
		<td>
			<select name="pagerPosition" id="pagerPosition">
				<option value="none" <?php echo $specs->pagerPosition == 'none' ? 'selected' : '' ?>><?php echo t('Don\'t display') ?></option>
				<option value="under_content" <?php echo $specs->pagerPosition == 'under_content' ? 'selected' : '' ?>><?php echo t('Under Content text') ?></option>
				<option value="under_slider" <?php echo $specs->pagerPosition == 'under_slider' ? 'selected' : '' ?>><?php echo t('Under the slider') ?></option>
			</select>			
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Display Controls (Next-Prev)') ?></strong>			
		</td>
		<td>
			<select name="controls" id="pagerPosition">
				<option value="disabled" <?php echo $specs->controls == 'disabled' ? 'selected' : '' ?>><?php echo t('Don\'t display') ?></option>
				<option value="display" <?php echo $specs->controls == 'display' ? 'selected' : '' ?>><?php echo t('Display') ?></option>
			</select>			
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Pager color') ?></strong>
			
		</td>
		<td>
			<?php echo $fc->output('pagerColor', t('Pager bullets color'), $specs->pagerColor);  ?>
			<hr>
			<?php echo $fc->output('pagerColorActive', t('Pager active bullets color'), $specs->pagerColorActive);  ?>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo t('Controls color') ?></strong>
			
		</td>
		<td>
			<?php echo $fc->output('controlsColor', t('Background for next/prev/play/pause'), $specs->controlsColor);  ?>
			<hr>
			<?php echo $fc->output('controlsSignColor', t('Sign color for next/prev/play/pause'), $specs->controlsSignColor);  ?>
		</td>
	</tr>
</table>
<script>
$(document).ready(function(){
	
	$(".jrange").each(function(){
		var t = $(this);
		t.slider({
			min:t.data('min'), 
			max:t.data('max'),
			step:t.data('step'),  
			value: t.data('value'), 
			slide: function(event, ui) {
				$("#" + $(this).data('id')).val(ui.value)}
			})
	});

});
</script>
<style>
	.tbl td {
		padding:20px 10px;
	}
	.tbl tr {
		border-bottom: 1px solid #ccc;
	}
	.tbl .ui-slider {
		margin: 15px 0;
		width:90%;
	}
	.tbl .ui-slider + input {
		width:80px;
	}
</style>