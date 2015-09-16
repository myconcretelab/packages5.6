<?php  defined('C5_EXECUTE') or die("Access Denied.");

class RelatedProductsBlockController extends BlockController {
	
	protected $btName = 'Related Products';
	protected $btDescription = '';
	
	protected $btTable = 'btRelatedProducts';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "350";
	

	public function getBlockTypeDescription() {
		return t("Show related products from corecommerce.");
	}
	
	public function getBlockTypeName() {
		return t("Related products");
	}	
	public function add() {
		$this->set('attributeHandle', 'related_products');
		$this->set('productSource', 'inherit');
		$this->set('columns', 3);
	}
	public function edit () {
	}
	public function getJavaScriptStrings() {
		return array(
			'attributeHandle-required' => t('You must enter a attribute Handle.'),
			'product-required' => t('You must provide a product.'),
		);
	}
	protected function view () {
		$products = array();
		Loader::model('product/model', 'core_commerce');
		// Si on charge un produit special comme reference
		if ($this->productID && $this->productSource == 'specific') {
			$product = CoreCommerceProduct::getByID($this->productID);
		// Sinon, on charge le produit lié a la page, comme reference.
		} else if ($this->productSource == 'inherit') {
			$c = $this->getCollectionObject();	
			if(!$c instanceof Page || $c->getCollectionID() <= 0) {
				$c = Page::getCurrentPage(); 
			}

			if($c instanceof Page && $c->getCollectionID() > 0) {
				$db = Loader::db();
				$productID = $db->GetOne('select productID from CoreCommerceProducts where cID = ?', array($c->getCollectionID()));
				if ($productID > 0) {
					$product = CoreCommerceProduct::getByID($productID);
				}
			}
		}

		if (is_object($product)) {
			// On prend ses produits liés
			$relatedProducts = $product->getAttribute($this->attributeHandle);
			
			if (is_array($relatedProducts) && count($relatedProducts)) :
				$products = $relatedProducts;
			endif;
		}
		$this->set('ih',Loader::helper('image'));
		$this->set('products', $products );
	}	

	function save ($data) {
		
		if (is_array($data['productID']))
			$data['productID'] = implode(',', $data['productID']);
		$data['columns'] = (is_numeric($data['columns']) && $data['columns'] < 24 && $data['columns'] > 0) ? $data['columns'] : 3;
		
		parent::save($data);
	}





}
