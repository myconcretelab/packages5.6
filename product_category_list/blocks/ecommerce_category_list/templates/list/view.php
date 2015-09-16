<?php  defined('C5_EXECUTE') or die("Access Denied."); 
$i = 0;
$columns_number = $columns_number_per_ak;
if (!is_array($categories) || isset($blocks)) : ?>

<?php else : ?>
<div class="prcategory-list" id="prcategory-list-<?php echo $bID?>">
	<!-- Controller working time :  <?php echo $time ?> -->
	<form id="product_<?php echo $bID?>" action="<?php  echo $redirectpage ? $nh->getLinkToCollection(Page::getByID($redirectpage)) : $nh->getLinkToCollection(Page::getCurrentPage()) ?>" method="GET" class="nav-pane-product-form">
	<input type="hidden" name="search" value="1" />
	<!-- <input type="hidden" name="numResults" value="<?php echo $o->numResults ?>"> -->
	<input type="hidden" name="pcID" value="<?php echo $redirectpage ?>">		
		
<?php foreach ($categories as  $akID => $akObj):
?>
	<?php if($i % $columns_number == 0 ) :?><div class="cat_row row-fluid"> <?php endif ?>
	<input type="hidden" value="<?php echo $akID ?>" name="selectedSearchField[]">	
	<ul class="product_categories span<?php echo 12 / $columns_number?>">
	<?php if($display_title == 1) : ?>	
			<li class='head-title'><span><?php echo $akObj->akName ?></span></li>
	<?php endif ?>
	<?php foreach ($options[$akID] as $key => $oObj) : ?>
			<li<?php echo in_array($oObj->ID, $active_oID) ? ' class="active" ' : ''?>><input id="option<?php echo $oObj->ID ?>" type="checkbox" name="akID[<?php echo $akID ?>][atSelectOptionID][]" value="<?php echo $oObj->ID ?>" class="pc_check"><a href="javascript:void(0)"><?php echo $oObj->value ?><?php if ($display_product_count): ?><span> (<?php echo $contains[$akID][$oObj->ID]['count'] ? $contains[$akID][$oObj->ID]['count'] : 0 ?>)</span><?php endif ?></a></li>		
	<?php endforeach ?>
	</ul>
	<?php if ( $i % $columns_number == $columns_number - 1 || ($i == count($categories) - 1) ) :?></div><!-- .row --><?php endif ?>
	<?php $i++ ?>	
<?php endforeach ?>	
</form>
</div> <!-- .prcategor-list -->
<?php endif ?>
<script>
$('#prcategory-list-<?php echo $bID?> a').click(function(e){
	e.preventDefault();
	$(this).prevAll('input').attr('checked', true);
	$('#product_<?php echo $bID?>').submit();
})	
</script>
<style>
	<?php if (!$multiple_choice): ?>#prcategory-list-<?php echo $bID?> .pc_check {display: none;}<?php endif ?>
</style>
