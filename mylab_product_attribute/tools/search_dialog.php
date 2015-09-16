<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
$c1 = Page::getByPath('/dashboard/core_commerce');
$cp1 = new Permissions($c1);
if (!$cp1->canRead()) { 
	die(_("Access Denied."));
}

$cnt = Loader::controller('/dashboard/core_commerce/products/search');
$productList = $cnt->getRequestedSearchResults();
$products = $productList->getPage();
$pagination = $productList->getPagination();

$uh = Loader::helper('urls', 'core_commerce');
$sdu = $uh->getToolsURL('search_dialog');

ob_start();
Loader::packageElement('search_results', 'mylab_product_attribute', array('mode' => $mode, 'products' => $products, 'productList' => $productList, 'pagination' => $pagination, 'searchType' => 'DIALOG'));
$searchForm = ob_get_contents();
ob_end_clean();

$v = View::getInstance();
$v->outputHeaderItems();


?>

<?php  if (!isset($_REQUEST['refreshDialog'])) { ?> 
	<div id="ccm-core-commerce-product-overlay-wrapper">
<?php  } ?>
<div id="ccm-core-commerce-product-search-overlay" class="ccm-ui">
	<input type="hidden" name="dialogAction" value="<?php echo $sdu?>" />

<div class="ccm-pane-options" id="ccm-core-commerce-product-pane-options">
<div class="ccm-core-commerce-product-search-form"><?php  Loader::packageElement('search', 'mylab_product_attribute', array('searchType' => 'DIALOG')) ?></div>
</div>
<div id="search-results">
	<?php echo $searchForm?>
</div>

</div>

<?php  if (!isset($_REQUEST['refreshDialog'])) { ?> 
	</div>
<?php  } ?>



