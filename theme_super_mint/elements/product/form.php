<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?> 
<?php  
$form = Loader::helper('form');

Loader::model('product/set', 'core_commerce');

$v = View::getInstance();
$html = Loader::helper('html');
$th = Loader::helper('concrete/urls'); 
$ps = Loader::helper('form/page_selector');
$this->addHeaderItem($html->javascript('tiny_mce/tiny_mce.js'));

if (is_object($product)) { 
	$prName = $product->getProductName();
	$prDescription = $product->getProductDescription();
	$prStatus = $product->getProductStatus();
	$prPrice = $product->getProductPrice();
	$prSpecialPrice = $product->getProductSpecialPrice(false);
	if ($prSpecialPrice == 0) {
		$prSpecialPrice = '';
	}
	$prQuantity = $product->getProductQuantity();
	$prMinimumPurchaseQuantity = $product->getMinimumPurchaseQuantity();
	$prQuantityUnlimited = $product->productHasUnlimitedQuantity();
   $prQuantityAllowNegative = $product->getProductNegativeQuantitySetting();
	$prPhysicalGood = $product->productIsPhysicalGood();
	$prRequiresShipping = $product->productRequiresShipping();
	
	$prWeight = $product->getProductWeight();
	$prWeightUnits = $product->getProductWeightUnits();
	$prDimL = $product->getProductDimensionLength();
	$prDimW = $product->getProductDimensionWidth();
	$prDimH = $product->getProductDimensionHeight();
	$prDimUnits = $product->getProductDimensionUnits();

	$productID = $product->getProductID();
	$prRequiresTax = $product->productRequiresSalesTax();
	$prShippingModifier = $product->getProductShippingModifier();
	$gIDs = $product->getProductPurchaseGroupIDArray();
	$cID = $product->getProductCollectionID();
	$prRequiresLoginToPurchase = $product->productRequiresLoginToPurchase();
	$prUseTieredPricing = $product->productUsesTieredPricing();
	
	$tiers = array();
	if ($prUseTieredPricing) {
		Loader::model('product/tiered_price', 'core_commerce');
		$tiers = CoreCommerceProductTieredPrice::getTiers($product);
	}
}

?>

	<?php echo $form->hidden('productID', $productID); ?>
<div class="clearfix">
   <fieldset>
      <legend><?php echo t('Base Information')?></legend>
      <div class="clearfix">
      <?php echo $form->label('prName', t('Name') . '	<span class="ccm-required">*</span>')?>
         <div class="input">
            <?php echo $form->text('prName', $prName, array('class' => "span7"))?>
         </div>
      </div>

      <div class="clearfix">
      <?php echo $form->label('prDescription', t('Description') . '	<span class="ccm-required">*</span>')?>
         <div class="input">
            <div style="width:540px">
               <?php  Loader::element('editor_init'); ?>
               <?php  Loader::element('editor_config'); ?>
               <?php  Loader::element('editor_controls', array('mode'=>'full')); ?>
               <?php echo $form->textarea('prDescription', $prDescription, array('style' => 'height: 150px; width: 526px', 'class' => 'ccm-advanced-editor span7'))?>
            </div>
         </div>
      </div>

   <?php 	if (is_object($product)) { ?>
      <div class="clearfix">
      <label><?php echo t('Product Page')?></label>
      <div class="input">
         <div style="width:540px">
         <?php echo $ps->selectPage('cID', $cID)?>
         </div>
      </div>
      </div>
   <?php  } ?>

   </fieldset>
</div>

<div class="clearfix">
   <div class="span5">
   <fieldset>
      <legend><?php echo t('Purchase and Stock')?></legend>

      <div class="clearfix">
         <?php echo $form->label('prStatus', t('Status') . '	<span class="ccm-required">*</span>')?>
         <div class="input">
            <?php echo $form->select('prStatus', array(
                  '1' => t('Enabled'), 
                  '0' => t('Disabled')
               ), $prStatus,array('class'=>'input-medium'));?>
         </div>
      </div>

      <div class="clearfix">
         <?php echo $form->label('prQuantity', t('Quantity In Stock'))?>
         <div class="input">
            <?php echo $form->text('prQuantity', $prQuantity, array('style' => 'width: 50px'))?>
            <?php echo $form->checkbox('prQuantityUnlimited', 1, $prQuantityUnlimited)?>
            <?php echo t('Unlimited')?>
         </div>
      </div>

      <div class="clearfix">
         <?php echo $form->label('prQuantityAllowNegative', t('Allow Negative Quantity'))?>
         <div class="input">
            <?php echo $form->select('prQuantityAllowNegative', array(
                  (string)CoreCommerceProduct::NEGATIVE_QUANTITY_YES => 'Yes',
                  (string)CoreCommerceProduct::NEGATIVE_QUANTITY_NO => 'No',
                  (string)CoreCommerceProduct::NEGATIVE_QUANTITY_SYSTEM => 'System default'
               ), $prQuantityAllowNegative,array('class'=>'input-medium'))?>
         </div>
      </div>

      <div class="clearfix">
         <?php echo $form->label('prMinimumPurchaseQuantity', t('Min. Units To Buy'))?>
         <div class="input">
            <?php echo $form->text('prMinimumPurchaseQuantity',$prMinimumPurchaseQuantity, array('style' => 'width: 50px'))?>
         </div>
      </div>

      <div class="clearfix">
         <?php echo $form->label('prPhysicalGood', t('Physical Good'))?>
         <div class="input">
            <?php echo $form->select('prPhysicalGood', array(
                  '1' => t('Yes'),
                  '0' => t('No')
               ), $prPhysicalGood,array('class'=>'input-medium'));?>
         </div>
      </div>

      <div class="clearfix">
         <?php echo $form->label('prRequiresLoginToPurchase', t('Requires Login'))?>
         <div class="input">
            <?php echo $form->select('prRequiresLoginToPurchase', array(
                  '1' => t('Yes'), 
                  '0' => t('No')
               ), $prRequiresLoginToPurchase,array('class'=>'input-medium'));?>
         </div>
      </div>
   </fieldset>
   </div>

   <div class="span5 offset1">
   <fieldset>
      <legend><?php echo t('Price and Cost')?></legend>
      <div class="clearfix">
      <?php echo $form->label('prPrice', t('Price'))?>
         <div class="input">
            <?php echo $form->text('prPrice', $prPrice, array('style' => 'width: 100px'))?>
         </div>
      </div>

      <div class="clearfix">
         <label for="prHasSpecialPrice"><?php echo t('Special/Sale Price')?></label>
         <div class="input">
            <div class="input-prepend">
               <span class="add-on"><?php echo $form->checkbox('prHasSpecialPrice', 1, $prSpecialPrice != '',array('class'=>'inline'))?></span>
               <?php echo $form->text('prSpecialPrice', $prSpecialPrice, array('class' => 'input-mini'))?>
            </div>
         </div>
      </div>

      <div class="clearfix">
      <?php echo $form->label('prRequiresTax', t('Charge Sales Tax'))?>
      <div class="input ccm-core-commerce-product-requires-tax"><?php echo $form->select('prRequiresTax', array(
            '1' => t('Yes'),
            '0' => t('No')
         ), $prRequiresTax,array('class'=>'input-medium'));?>
      </div>
      </div>

      <div class="clearfix">
         <label for="prUseTieredPricing"><?php echo t('Tiered Pricing')?></label>
         <div class="input">
            <ul class="inputs-list">
               <li><label><?php echo $form->checkbox('prUseTieredPricing', 1, $prUseTieredPricing)?> <span><?php echo t('Enable Tiered Pricing')?></span></label>
               <br/>

               <div  id="ccm-core-commerce-product-tiered-pricing-fields-wrapper">
               <?php 
               $pkg = Package::getByHandle('core_commerce');
               $currency = $pkg->config('CURRENCY_SYMBOL'); if (empty($currency)) { $currency = '$'; } ?>
               
               <?php  if (Controller::isPost()) { ?>
                  <?php  for ($i = 0; $i < count($_POST['prTieredPricing']['tierStart']); $i++) { ?>
                     <div class="ccm-core-commerce-product-tiered-pricing-fields" <?php  if ($i == 0) { ?>id="ccm-core-commerce-product-tiered-pricing-fields-base" <?php  } ?>>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="<?php echo htmlentities($_POST['prTieredPricing']['tierStart'][$i], ENT_QUOTES, APP_CHARSET)?>" style="width: 30px" />
                     <?php echo t('to')?>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="<?php echo htmlentities($_POST['prTieredPricing']['tierEnd'][$i], ENT_QUOTES, APP_CHARSET)?>" style="width: 30px" />
                     &nbsp;&nbsp;
                     <?php echo $currency?>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="<?php echo htmlentities($_POST['prTieredPricing']['tierPrice'][$i], ENT_QUOTES, APP_CHARSET)?>" style="width: 80px" />
                     <a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
                     </div>
                  <?php  } ?>
               <?php  } else if (count($tiers) > 0) { ?>
                  <?php  for ($i = 0; $i < count($tiers); $i++) { 
                     $t = $tiers[$i];?>
                  
                     <div class="ccm-core-commerce-product-tiered-pricing-fields" <?php  if ($i == 0) { ?>id="ccm-core-commerce-product-tiered-pricing-fields-base" <?php  } ?>>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="<?php echo $t->getTierStart()?>" style="width: 30px" />
                     <?php echo t('to')?>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="<?php echo $t->getTierEnd()?>" style="width: 30px" />
                     &nbsp;&nbsp;
                     <?php echo $currency?>
                     <input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="<?php echo $t->getTierPrice()?>" style="width: 80px" />
                     <a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
                     </div>
                  
                  <?php  } ?>	
               
               <?php  } else { ?>
               <div class="ccm-core-commerce-product-tiered-pricing-fields" id="ccm-core-commerce-product-tiered-pricing-fields-base">
                  <input type="text" class="ccm-input-text" name="prTieredPricing[tierStart][]" value="1" style="width: 30px" />
                  <?php echo t('to')?>
                  <input type="text" class="ccm-input-text" name="prTieredPricing[tierEnd][]" value="" style="width: 30px" />
                  &nbsp;&nbsp;
                  <?php echo $currency?>
                  <input type="text" class="ccm-input-text" name="prTieredPricing[tierPrice][]" value="" style="width: 80px" />
                  <a href="javascript:void(0)" onclick="ccm_coreCommerceRemovePricingTier(this)"><img src="<?php echo ASSETS_URL_IMAGES?>/icons/remove_minus.png" style="vertical-align: middle"  width="16" height="16" /></a>
               </div>
         
               <?php  } ?>
         
            </div>
         
               <br/>

            <a class="btn" style="<?php  if (!$prUseTieredPricing) { ?> display: none<?php  } ?>" id="ccm-core-commerce-product-tiered-pricing-add-tier" href="javascript:void(0)" onclick="ccm_coreCommerceAddPricingTier()"><?php echo t('Add Tier')?></a>
            </li>
         </ul>
      </div>
   </div>

   </fieldset>
   </div>
</div>

<div class="clearfix">
   <div class="span5">
      <fieldset>
         <legend><?php echo t('Shipping Information')?></legend>

         <div class="clearfix">
            <?php echo $form->label('prRequiresShipping', t('Requires Shipping'))?>
            <div class="input ccm-core-commerce-product-requires-shipping"><?php echo $form->select('prRequiresShipping', array(
                  '1' => t('Yes'),
                  '0' => t('No')
               ), $prRequiresShipping,array('class'=>'input-medium'));?>
            </div>
         </div>

         <div class="clearfix">
         <?php echo $form->label('prWeight', t('Weight'))?>
            <div class="input ccm-core-commerce-product-weight">
                  <?php echo $form->text('prWeight', $prWeight, array('class'=>'input-mini'))?>
                  <?php echo $form->select('prWeightUnits', array(
                     'lb' => t('lb'),
                     'g' => t('g'),
                     'kg' => t('kg'),
                     'oz' => t('oz'),
                  ), $prWeightUnits, array('class' => 'input-mini'));?>		
            </div>
         </div>

         <div class="clearfix">
            <?php echo $form->label('prDimL', t('Dimensions (LxWxH)'))?>
            <div class="input ccm-core-commerce-product-dimensions">
               <?php echo $form->text('prDimL', $prDimL, array('style' => 'width: 20px'))?>
               <?php echo $form->text('prDimW', $prDimW, array('style' => 'width: 20px'))?>
               <?php echo $form->text('prDimH', $prDimH, array('style' => 'width: 20px'))?>
               <?php echo $form->select('prDimUnits', array(
                  'in' => t('in'),
                  'mm' => t('mm'),
                  'cm' => t('cm')
               ), $prDimUnits, array('class' => 'input-mini'));?>
            </div>
         </div>

         <div class="clearfix">
            <?php echo $form->label('prShippingModifier', t('Shipping Modifier'))?>
            <div class="input ccm-core-commerce-product-shipping-modifier">
               <?php echo $form->text('prShippingModifier', $prShippingModifier, array('class'=>'input-mini'))?>
            </div>
         </div>
      </fieldset>
   </div>

   <div class="span5 offset1">
      <fieldset>
         <legend><?php echo t('Other Product Attributes')?></legend>
<?php 
Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
$attribs = CoreCommerceProductAttributeKey::getList();

if (count($attribs) > 0) {
      foreach($attribs as $ak) { 
         if (is_object($product)) {
            $caValue = $product->getAttributeValueObject($ak);
         }
         ?>
         <div class="clearfix">
            <?php echo $ak->render('label');?>
            <div class="input">
               <?php echo $ak->render('composer', $caValue, true)?>
            </div>
         </div>
      <?php  } ?>

<?php  } else {?>
      <div class="span4">
         <em><?php echo t('This product has no additional attributes')?></em>
      </div>
<?php }?>
      </fieldset>
   </div>	
</div>

<div class="clearfix">
   <div class="span5">
   <fieldset>
      <legend><?php echo t('Groups &amp; Sets')?></legend>

   <?php   $tp = TaskPermission::getByHandle('access_user_search');
   if ($tp->can()) { ?>

      <div class="clearfix">
         <label><?php echo t('Place customers in user group.')?> <strong><?php echo t('Requires login or registration before checkout.')?></strong></label>
         <div class="input">
            <ul class="inputs-list">
            <?php 
            Loader::model("search/group");
            $gl = new GroupSearch();
            if ($gl->getTotal() < 1000) { 
               $gl->setItemsPerPage(1000);
               $gArray = $gl->getPage();
               if (!isset($gIDs)) {
                  $gIDs = $_POST['gID'];
               }
               foreach ($gArray as $g) {
                  if($g['gID'] != ADMIN_GROUP_ID) {?> 
                     <li><label>
                        <input type="checkbox" name="gID[]" value="<?php echo $g['gID']?>" <?php 
                           if (is_array($gIDs)) {
                              if (in_array($g['gID'], $gIDs)) {
                                 echo(' checked ');
                           }
                        }
                     ?> /> <span><?php echo $g['gName']?></span></label></li>
                  <?php  } ?>
               <?php  } ?>
            <?php  } ?>
            </ul>
         </div>
      </div>
   <?php  } ?>

   <?php  $sets = CoreCommerceProductSet::getList(); ?>
   <?php  if (count($sets) > 0) { ?>
      <div class="clearfix">
         <label><?php echo t('Place this product in a set: ')?></label>
         <div class="input">
            <ul class="inputs-list">
               <?php  foreach ($sets as $prs) { 
                  $isChecked = 0;
                  if (is_object($product)) {
                     $isChecked = $prs->contains($product);
                  }
                  ?>
                  <li><label>
                  <?php echo $form->checkbox('prsID[]', $prs->getProductSetID(), $isChecked) ?>
                  <span><?php echo $prs->getProductSetName()?></span></label></li>
               <?php  } ?>
            </ul>
         </div>
      </div>

   <?php  } ?>
      </fieldset>
   </div>

   <?php 
   $mlh = Loader::helper('multilingual','core_commerce');
   if($mlh->isEnabled()) { ?>
   <div class="span5 offset1">
      <fieldset>
      <legend><?php echo t('Multilingual Setup')?></legend>
         <div class="clearfix">
         <?php echo $form->label('prLanguage', t('Select a Language'))?>
            <div class="input">
               <?php 
               $sections = $mlh->getSectionSelectArray();
               if (is_object($product)) {
                  $lang = $product->getProductLanguage();
               }
               if(is_array($sections) && count($sections)) {
                  echo $form->select('prLanguage', $sections, $lang);
               } else {?>
                  <select disabled="disabled"><option><?php echo t('No languages enabled')?></option></select>
               <?php 
               }
               ?>
            </div>
         </div>
      </fieldset>
   </div>
   <?php  } ?>
</div>



<script type="text/javascript">
ccm_coreCommerceAddPricingTier = function() {
	var wrap = $("#ccm-core-commerce-product-tiered-pricing-fields-wrapper");
	var base = $("#ccm-core-commerce-product-tiered-pricing-fields-base");
	wrap.append('<div class="ccm-core-commerce-product-tiered-pricing-fields">' + base.html() + '</div>');
}

ccm_coreCommerceRemovePricingTier = function(row) {
	var wrap = $(row).parent();
	wrap.remove();
}

ccmCoreCommerceProductCheckSelectors = function(s) {
	if ($('select[name=prPhysicalGood]').val() == '1') {
		if (s && s.attr('name') != 'prRequiresShipping') {
			$("select[name=prRequiresShipping]").val(1);
		}
		$("td.ccm-core-commerce-product-requires-shipping select").attr('disabled', false);
	} else {
		$("select[name=prRequiresShipping]").val(0);
		$("td.ccm-core-commerce-product-requires-shipping select").attr('disabled', true);
	}

	if ($('select[name=prRequiresShipping]').val() == '1') {
		$("td.ccm-core-commerce-product-dimensions input").attr('disabled', false);
		$("td.ccm-core-commerce-product-dimensions select").attr('disabled', false);
		$("td.ccm-core-commerce-product-weight input").attr('disabled', false);
		$("td.ccm-core-commerce-product-weight select").attr('disabled', false);
		$("td.ccm-core-commerce-product-shipping-modifier input").attr('disabled', false);
	} else {
		$("td.ccm-core-commerce-product-dimensions input").attr('disabled', true);
		$("td.ccm-core-commerce-product-dimensions select").attr('disabled', true);
		$("td.ccm-core-commerce-product-weight input").attr('disabled', true);
		$("td.ccm-core-commerce-product-weight select").attr('disabled', true);
		$("td.ccm-core-commerce-product-shipping-modifier input").attr('disabled', true);

	}


	if ($('input[name=prQuantityUnlimited]').attr('checked')) {
		$("input[name=prQuantity]").val("");
		$("input[name=prQuantity]").attr('disabled', true);
	} else {
		$("input[name=prQuantity]").attr('disabled', false);
		if (s && s.attr('name') == 'prQuantityUnlimited') {
			$("input[name=prQuantity]").get(0).focus();
		}
	}

	if ($('input[name=prUseTieredPricing]').attr('checked')) {
		$("input[name=prPrice]").val("");
		$("input[name=prPrice]").attr('disabled', true);
		$("#ccm-core-commerce-product-tiered-pricing-add-tier").show();
		$("#ccm-core-commerce-product-tiered-pricing-fields-wrapper").show();
	} else {
		$("input[name=prPrice]").attr('disabled', false);
		$("#ccm-core-commerce-product-tiered-pricing-add-tier").hide();
		$("#ccm-core-commerce-product-tiered-pricing-fields-wrapper").hide();
	}

	if ($('input[name=prHasSpecialPrice]').attr('checked')) {
		$("input[name=prSpecialPrice]").attr('disabled', false);
		if (s && s.attr('name') == 'prHasSpecialPrice') {
			$("input[name=prSpecialPrice]").get(0).focus();
		}
	} else {
		$("input[name=prSpecialPrice]").val("");
		$("input[name=prSpecialPrice]").attr('disabled', true);

	}

}

$(function() {
	ccm_activateFileSelectors();
	$("input[name=prUseTieredPricing]").click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
		
	$("input[name=prQuantityUnlimited]").click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$("select[name=prRequiresShipping]").change(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$("input[name=prHasSpecialPrice]").click(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	$("select[name=prPhysicalGood]").change(function() {
		ccmCoreCommerceProductCheckSelectors($(this));
	});
	
	ccmCoreCommerceProductCheckSelectors();
	$(".page-selector").click( 
		function (e) {
            $.fn.dialog.open({
                href: "<?php echo $th->getToolsURL('create_page', 'core_commerce')?>",
                title: "<?php echo t('Create a Product Page?')?>",
                width: 550,
                modal: true,
                onOpen:function(){},
                onClose: function(e){},
                height: 480
            });
           e.preventDefault(); 
		}
	);
	//$(".dialog-launch").dialog();
	
});
</script>

<style type="text/css">
#ccm-core-commerce-product-edit-form td {vertical-align: top;}
.ccm-core-commerce-product-tiered-pricing-fields {padding-bottom: 5px;}
#ccm-core-commerce-product-tiered-pricing-fields-base a {display: none}
</style>
