<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<table class="slim_table">
<?php  
foreach($properties as $property) { ?>
	<?php  if ($property->type == 'attribute') { 
		$dak = CoreCommerceProductAttributeKey::getByID($property->akID);
		$av = $product->getAttributeValueObject($dak);
		if (is_object($av))  : ob_start(); echo $av->getValue('display'); $v = trim(ob_get_clean()); else: $v = false; endif;
		if ($v) { ?>
		<tr>
			<td class="title"><?php echo  $dak->getAttributeKeyName()?></td>
			<td>
				<strong><?php echo $v ?></strong>
			</td>
		</tr>		
		<?php  }		
	} ?>
<?php  } ?>
</table>