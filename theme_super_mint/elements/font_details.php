<?php defined('C5_EXECUTE') or die("Access Denied.");

if(!is_array($variants) || !is_array($subsets)) die(t('A error a occured to retrieve font infos'));
// Les noms des inputs
if (!$subsetName || !$variantName) 	die(t('A intern error are occured'));
?>

<div class="font_details" id="_">
	<!-- <h3><?php echo t('Details for ') . $font ?></h3> -->
	<table style="width:100%">
		<tr>
			<td class="td">
				<strong><?php echo t('Variants') ?></strong>
				<hr>
				<?php if ($inputType == 'radio' || $inputType =='checkbox') :?>
				<!-- Les radio ou checkbox -->
				<?php foreach ($variants as $key => $variant) : 
					$checked = in_array($variant, $selected_variants) ? 'checked' : '';
					?>
					<label for="variants">
						<input type="<?php echo $inputType ?>" name="<?php echo $variantName ?>[]" value="<?php echo $variant ?>" <?php echo $checked ?>><?php echo $variant ?>
					</label>
				<?php endforeach ?>				
				
				<?php else : ?>
				<!-- Le select -->
				<select name="<?php echo $variantName ?>[]" id="">
				<?php foreach ($variants as $key => $variant) : 
					$selected = in_array($variant, $selected_variants) ? 'selected' : '';
					?>
					<option value="<?php echo $variant ?>" <?php echo $selected ?>><?php echo $variant ?></option>
				<?php endforeach ?>				
				</select>
				<?php endif ?>
			</td>
			<td class="td">
				<strong><?php echo t('subsets') ?></strong>
				<hr>
				<?php foreach ($subsets as $key => $subset) : 
					$checked = in_array($subset, $selected_subsets) ? 'checked' : '';
					?>
					<label for="subsets">
						<input type="checkbox" name="<?php echo $subsetName ?>[]" value="<?php echo $subset ?>" <?php echo $checked ?>><?php echo $subset ?>
					</label>
				<?php endforeach ?>
			</td>
			<td class="td">
				<strong><?php echo t('Sample') ?></strong>
				<hr>
				<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $font) ?>" type="text/css" />
				<div id="__" contenteditable="true">
					<h3 style="font-family:'<?php echo str_replace('+', ' ', $font) ?>'">Grumpy wizards make toxic brew for the evil Queen and Jack.</h3>
				</div>
			</td>
		</tr>
		
	</table>
</div>

<style>
	#ccm-dashboard-page td.td {
		width:33%;
		padding: 10px;
		vertical-align: top;
		background-color: transparent;
	}
	td.td label {
		display: inline-block;
		margin-right : 20px;
		text-align: center;
	}
	.ccm-ui td.td input {
		margin: 0 auto
	}
</style>