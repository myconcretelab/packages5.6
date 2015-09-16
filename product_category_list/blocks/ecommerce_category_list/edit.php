<?php  defined('C5_EXECUTE') or die("Access Denied.");

?>
<ul class="ccm-dialog-tabs tabs" id="ccm-block-tabs">
    <li class="ccm-nav-active">
        <a href="javascript:void(0)" id="ccm-block-categories"><?php echo t('Choose Categories') ?></a>
    </li>
    <li>
        <a href="javascript:void(0)" id="ccm-block-options"><?php echo t('Options') ?></a>
    </li>
</ul>
<div id="ccm-block-categories-tab">
<table class="ml_table" style="width:100%">
 	<tr>
 		<td>
 			<strong><?php echo t('Filter by fileset')?></strong><br>
 		</td>
 		<td>
 			<?php 
 			
				Loader::model('product/set', 'core_commerce');
				$fsl = CoreCommerceProductSet::getList();
				if(count($fsl)) :
					echo '<select name="fsID"><option value="0">' . t('-- All --') . '</option>';

					foreach ($fsl as $key => $fs) :
						$selected = $fs->getProductSetID() == $fsID ? 'selected' :'';
						echo "<option value='{$fs->getProductSetID()}' $selected >{$fs->getProductSetName()}</option>";
					endforeach;
					echo '</select>';
				else :
					echo '<p>' . t('No fileset found!') . '</p>';
				endif;
 			 ?>
 		</td>
 	</tr>
<?php 
if (is_array($categories_list)) :
foreach ($categories_list as $k => $cat) : ?>
	<tr class="category_list_element" <?php echo $query_category == 'current_page' ? 'style="display:none"' : '' ?>>
		<td>
			<input 	type="checkbox" value="<?php echo $cat['ak']->akID ?>" 
					name="selected_categories[<?php echo $cat['ak']->akID ?>]" <?php if(array_key_exists($cat['ak']->akID, $akIDs)) echo 'checked' ?> 
					class="headcategory headcategory_<?php echo $cat['ak']->akID ?>" 
					data-akid="<?php echo $cat['ak']->akID ?>">
			<label for="<?php echo $cat['ak']->akHandle ?>"><strong><?php echo $cat['ak']->akName ?></strong></label>
		</td>
		<?php if (is_array($cat['options']) && count($cat['options'])) : ?>
		<td>
            <select id="categories_<?php echo $cat['ak']->akID ?>"
                    name="categories[<?php echo $cat['ak']->akID ?>][]" 
                    data-placeholder="Choose options" 
                    multiple class="chzn-select"
					>
					<option value="all" <?php echo  (is_array($akIDs[$cat['ak']->akID]) && in_array('all', $akIDs[$cat['ak']->akID]) || !is_array($akIDs[$cat['ak']->akID])) ? 'selected' : '' ?>><?php echo t('all') ?></option>                   
			<?php foreach ($cat['options'] as $option) : ?>
				<option value="<?php echo $option->ID ?>" 
					<?php echo (is_array($akIDs[$cat['ak']->akID]) && in_array($option->ID, $akIDs[$cat['ak']->akID])) ? 'selected' : '' ?> 
					><?php echo $option->value ?></option>
			
			<?php endforeach ?>
			</select>
		</td>
		<?php endif ?>
<?php endforeach;
 endif ?>
</table>
 </div><!-- #ccm-block-categories-tab -->
<div id="ccm-block-options-tab"  style="display: none;">
	<table class="ml_table" style="width:100%">	
		<tr>
			<td style="width:40%">
				<strong><?php echo t('Number of columns')?></strong>
			</td>
			<td>
				<select name="columns_limit" id="columns_limit">
					<option value="0" <?php echo $columns_limit == '0' ? 'selected="selected"' : '' ?>><?php echo t('No Limit')?></option>
					<option value="1" <?php echo $columns_limit == '1' ? 'selected="selected"' : '' ?>><?php echo t('1')?></option>
					<option value="2" <?php echo $columns_limit == '2' ? 'selected="selected"' : '' ?>><?php echo t('2')?></option>
					<option value="3" <?php echo $columns_limit == '3' ? 'selected="selected"' : '' ?>><?php echo t('3')?></option>
					<option value="4" <?php echo $columns_limit == '4' ? 'selected="selected"' : '' ?>><?php echo t('4')?></option>
					<option value="4" <?php echo $columns_limit == '4' ? 'selected="selected"' : '' ?>><?php echo t('6')?></option>
				</select>
			</td>
		</tr>
	 	<tr>
	 		<td>
	 			<strong><?php echo t('Redirect to page')?></strong><br>
	 				<small><?php echo t('Once a category clicked, products are displayed into a result page.')?></small>
	 		</td>
	 		<td>
	 			 <?php 	echo $pageSelector->selectPage('redirectpage', $redirectpage) ?>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<strong><?php echo t('Display category title')?></strong>
	 		</td>
	 		<td>
	 			<select name="display_title" id="display_title">
	 				<option value="1" <?php echo $display_title == '1' ? 'selected' : '' ?> ><?php echo t('Yes') ?></option>
	 				<option value="0"  <?php echo $display_title == '0' ? 'selected' : '' ?> ><?php echo t('No') ?></option>
	 			</select>

	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<strong><?php echo t('Display empty category option')?></strong>
	 			<p><?php echo t('When a options contains no products') ?></p>
	 		</td>
	 		<td>
	 			<select name="display_empty_option" id="display_empty_option">
	 				<option value="1" <?php echo $display_empty_option == '1' ? 'selected' : '' ?> ><?php echo t('Yes') ?></option>
	 				<option value="0"  <?php echo $display_empty_option == '0' ? 'selected' : '' ?> ><?php echo t('No') ?></option>
	 			</select>

	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<strong><?php echo t('Display product count')?></strong>
	 			<p><?php echo t('Display how much product in option') ?></p>
	 		</td>
	 		<td>
	 			<select name="display_product_count" id="display_product_count">
	 				<option value="1" <?php echo $display_product_count == '1' ? 'selected' : '' ?> ><?php echo t('Yes') ?></option>
	 				<option value="0"  <?php echo $display_product_count == '0' ? 'selected' : '' ?> ><?php echo t('No') ?></option>
	 			</select>

	 		</td>
	 	</tr>	 	
<!-- 	 	<tr>
	 		<td>
	 			<strong><?php echo t('Allow multiple choice')?></strong>
	 			<p><?php echo t('Only on certain templates') ?></p>
	 		</td>
	 		<td>
	 			<select name="multiple_choice" id="display_product_count">
	 				<option value="1" <?php echo $multiple_choice == '1' ? 'selected' : '' ?> ><?php echo t('Yes') ?></option>
	 				<option value="0"  <?php echo $multiple_choice == '0' ? 'selected' : '' ?> ><?php echo t('No') ?></option>
	 			</select>

	 		</td>
	 	</tr>	 --> 	
	</table>
</div><!-- #ccm-block-options-tab -->


<style>
.ml_table td {
	vertical-align: top;
	padding: 10px;
	border-bottom: 1px solid #ccc;

}
	.float {
		float: left;
		padding:5px;
		margin: 3px;
		border:1px solid #ccc;
	}
	.ml_table label {
		display: inline;
	}
	input[type:"checkbox"] + label {
		color: #ccc;
	}
	input[type:"checkbox"]:checked + label {
		color: #999;
	}
	.chzn-select {
		width: 200px;
	}
</style>