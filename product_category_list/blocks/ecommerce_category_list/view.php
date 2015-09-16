<?php  defined('C5_EXECUTE') or die("Access Denied."); 

if (!is_array($categories) || isset($blocks)) : ?>

<?php else : ?>
<div class="prcategory" id="prcategory-<?php echo $bID?>">
	<!-- Controller working time :  <?php echo $time ?> -->
	<form id="product_<?php echo $bID?>" action="<?php  echo $redirectpage ? $nh->getLinkToCollection(Page::getByID($redirectpage)) : $nh->getLinkToCollection(Page::getCurrentPage()) ?>" method="GET" class="nav-pane-product-form">
	<input type="hidden" name="search" value="1" />
	<!-- <input type="hidden" name="numResults" value="<?php echo $o->numResults ?>"> -->
	<input type="hidden" name="pcID" value="<?php echo $redirectpage ?>">		
<?php 
foreach ($categories as  $akID => $akObj):
	$i = 0;
	$columns_number = $columns_number_per_options[$akID];
	echo '<input type="hidden" value="' . $akID . '" name="selectedSearchField[]">'
	?>
<?php if($display_title == 1) : ?>
	<h3><?php echo $akObj->akName ?></h3>
<?php endif ?>
	<?php foreach ($options[$akID] as $key => $oObj) : ?>
		<?php $thumb = $ih->getThumbnail(File::getByID($contains[$akID][$oObj->ID]['fID']),180,180,true);?>
		<?php if($i % $columns_number == 0 ) :?><div class="cat_row row-fluid"  id="result_<?php echo $$oObj->ID?>"> <?php endif ?>
		<div class="span<?php echo 12 / $columns_number?> product_category_item stack <?php echo in_array($oObj->ID, $active_oID) ? 'active' : ''?>">
			<input id="option<?php echo $oObj->ID ?>" type="checkbox" name="akID[<?php echo  $akObj->akID ?>][atSelectOptionID][]" value="<?php echo $oObj->ID ?>" class="pc_check">
			<a href="javascript:void(0)">
				<div class="img"><img src="<?php echo $thumb->src?>" alt="" class=""></div>
				<h4><?php echo $oObj->value ?></h4>
			</a>
		</div> <!-- prcategoryitem -->
		<?php if ( $i % $columns_number == $columns_number - 1 || ($i == count($options[$akID]) - 1) ) :?></div><!-- .row --><?php endif ?>
		<?php 
		$i++;
	endforeach;
endforeach ?>	
</form>
</div> <!-- .prcategory -->
<?php endif ?>
<script>
$('#prcategory-<?php echo $bID?> .product_category_item a').click(function(e){
	e.preventDefault();
	$(this).prev().attr('checked', true);
	$('#product_<?php echo $bID?>').submit();
})	
</script>