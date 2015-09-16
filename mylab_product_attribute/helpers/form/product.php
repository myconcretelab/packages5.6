<?php  defined('C5_EXECUTE') or die("Access Denied.");
class MylabProductAttributeFormProductHelper {

	// value can be a ProductID, or array of productIDs
	public function display ($inputName, $value = '', $limitProduct = false, $additionalData = array()) {

		$products = array();
		if ($value) :
			Loader::model('product/model', 'core_commerce');
			if(is_array($value)):
				foreach ($value as $pID) :
					$p = CoreCommerceProduct::getByID($pID);
					if(is_object($p))
						$products[] = $p;
				endforeach;
			else :
				$p = CoreCommerceProduct::getByID($value);
				if(is_object($p))
					$products[] = $p;
			endif;
		endif;
		
		Loader::PackageElement('product_attribute_html', 'mylab_product_attribute', array(
			'attribute_tools_url'=> Loader::helper('concrete/urls')->getToolsURL('product_attribute_html', 'mylab_product_attribute'),
			'product_list_tools'=> Loader::helper('concrete/urls')->getToolsURL('search_dialog','mylab_product_attribute'),
			'inputName' => $inputName,
			'products' => $products,
			'limitProduct' => $limitProduct,
			'additionalData' => $additionalData
		));
	}

}