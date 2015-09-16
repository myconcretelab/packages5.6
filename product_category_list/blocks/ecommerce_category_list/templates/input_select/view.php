<?php  defined('C5_EXECUTE') or die("Access Denied."); 
$i =0;
$columns_number = $columns_number_per_ak;
?>

<div class="prcategory-list" id="prcategory-list-<?php echo $bID?>">
	<!-- Controller working time :  <?php echo $time ?> -->
		
<?php foreach ($categories as  $akID => $akObj):
	
?>
	<?php if($i % $columns_number == 0 ) :?><div class="cat_row row-fluid"> <?php endif ?>
	<div class="product_categories_input span<?php echo 12 / $columns_number?>">
		<form id="product_<?php echo $bID?>" action="<?php  echo $redirectpage ? $nh->getLinkToCollection(Page::getByID($redirectpage)) : $nh->getLinkToCollection(Page::getCurrentPage()) ?>" method="GET" class="nav-pane-product-form">
			<input type="hidden" name="search" value="1" />
			<!-- <input type="hidden" name="numResults" value="<?php echo $o->numResults ?>"> -->
			<input type="hidden" name="pcID" value="<?php echo $redirectpage ?>">		
			<input type="hidden" value="<?php echo $akID ?>" name="selectedSearchField[]">	
		<?php if($display_title == 1) : ?>	
			<h4 class='head-title'><span><?php echo $akObj->akName ?></span></h4>
		<?php endif ?>
			<select name="akID[<?php echo $akID ?>][atSelectOptionID][]" id="option<?php echo $oObj->ID ?>" class="categoryselect spa<?php echo 12 / $columns_number?> <?php echo $active_akID == $akID ? 'active' : '' ?>">
				<?php if(!$display_title) : ?><option value="-1"><?php echo t('> Pick a ') . $akObj->akName  . t(' <')?></option><?php endif ?>
		<?php foreach ($options[$akID] as $key => $oObj) : ?>
				<option value="<?php echo $oObj->ID ?>" <?php echo in_array($oObj->ID, $active_oID) ? 'selected' : ''?>><?php echo $oObj->value ?><?php if ($display_product_count): ?> (<?php echo $contains[$akID][$oObj->ID]['count'] ? $contains[$akID][$oObj->ID]['count'] : 0 ?>)<?php endif ?></option>
		<?php endforeach ?>
			</select>
			</form>
	</div><!-- .span<?php echo 12 / $columns_number?> -->
	<?php if ( $i % $columns_number == $columns_number - 1 || ($i == count($categories) - 1) ) :?></div><!-- .row --><?php endif ?>
	<?php $i++ ?>	
<?php endforeach ?>	
</div> <!-- .prcategor-list -->

<script>
	categoryselectinit = false;
	$(document).ready(function(){
		// Ceci est pour essayer de ne déclencher l'ecouteur d'evenement qu'une fois 
		// alors que le bloc à peut être été ajouté plusieurs fois dans la page.
		// ça semble marcher..
		if (!categoryselectinit) {
			categoryselectinit = true;
			$('.categoryselect').change(function(){
				t= $(this);
				if (t.val() == -1) return;
				t.parents('form.nav-pane-product-form').submit();

			});
		}
	});
</script>
