<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

class CorecommerceProductAttributeTypeController extends AttributeTypeController  { 
	
	public function on_start() {
		
		$this->set('prh', Loader::helper('form/product', 'core_commerce'));
		$this->addHeaderItem(Loader::helper('html')->javascript('ccm.core.commerce.search.js', 'core_commerce'));
		$this->addHeaderItem(Loader::helper('html')->css('ccm.core.commerce.search.css', 'core_commerce'));
	}

	public function getValue() {
		$db = Loader::db();
		$value = $db->GetOne("select value from atProductAttribute where avID = ?", array($this->getAttributeValueID()));
		return $this->getProducts($value);
	}
	
	public function getDisplayValue() {
		// Load the correct element to display the choosed type

		// Soint on prend celui retenu en DB
		$choosedType = $this->get_display_type( $this->getAttributeKey()->getAttributeKeyID());
		// Si rien n'est sorti de la DB, c'est text
		$this->loadElement($choosedType ? $choosedType : 'links');
		
	}
	// ShortHand functions
	public function getTextValue () {
		$this->loadElement('text');
	}
	public function getLinksValue () {
		$this->loadElement('links');
	}
	public function getImageLinksValue () {
		$this->loadElement('image_links');
	}
	public function getImageTextLinksValue () {
		$this->loadElement('image_text_links');
	}

	/* Let's user the capabilities to create 3 special templates into roots element/display */
	public function getCustom1Value () {
		Loader::element('display/custom1' , array('products' => $this->getValue()));
	} 

	public function loadElement ($display_type = 'text') {
		Loader::PackageElement('display/' . $display_type , 'mylab_product_attribute', array('products' => $this->getValue()));
	}

	public function searchForm($list) {
		$db = Loader::db();
		$list->filterByAttribute($this->attributeKey->getAttributeKeyHandle(), '%' . $this->request('value') . '%', 'like');
		return $list;
	}	
	
	public function search() { 
		$f = Loader::helper('form');
		print $f->text($this->field('value'), $value);
	}	 
	
	public function saveValue( $pIDs=array() ) {
		$db = Loader::db();
		if(!is_array($pIDs)) $pIDs=array();
		$cleanpIDs=array();
		foreach($pIDs as $pID) $cleanpIDs[]=intval($pID);
		$cleanpIDs = array_unique($cleanpIDs);
		$db->Replace('atProductAttribute', array('avID' => $this->getAttributeValueID(), 'value' => implode(',',$cleanpIDs)), 'avID', true);
	}
	
	public function form () {
		// Si jamais il y a uen erreur dans le formulaire global, 
		// on charge ce qui est présent dans le post
		$post = $this->post();
		if (count($post)) :
			// Les $pIDs doit être une chaine de caractères
			$pIDs = implode(',', $post['pID']);
			$products = $this->getProducts($pIDs);
		elseif (is_object($this->attributeValue)) :
			$products = $this->getAttributeValue()->getValue();
		endif;

		$this->set('akID', $this->attributeKey->getAttributeKeyID());
		$this->set('attribute_tools_url', Loader::helper('concrete/urls')->getToolsURL('product_attribute', 'mylab_product_attribute'));
		$this->set('product_list_tools', Loader::helper('concrete/urls')->getToolsURL('search_dialog','mylab_product_attribute'));
		$this->set('products', $products);
	}

	public function saveForm($data) { 
		$this->saveValue($data['pID']);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atProductAttribute where avID = ?', array($this->getAttributeValueID()));
	}

	public function helper_form () {
		$this->display('form');
	}

	static public function getProducts ($valueStr=''){  
		$products=array();
		Loader::model('product/model', 'core_commerce');

		// Si $valueStr est vide, on regarde si on peut charger les produits depusi la db
		// a tester
		// Attentio,n on est parfois hors contexte objet ($this est interdit)
		//if ($valueStr == '' && is_object($this->attributeValue))
		//	$valueStr = $this->getAttributeValue()->getValue();		


		foreach(explode(',',$valueStr) as $pID){
			if(!intval($pID)) continue;
			$product = CoreCommerceProduct::getByID(intval($pID));
			if(!is_object($product) || !$product->getproductID()) continue;   
			$products[]=$product; 
		}  	
		return $products; 
	}

	/*  -- Displaying type --- */
	function get_display_type ($akID = false) {
		if ($akID) :
			$db = Loader::db();
			return $db->GetOne('SELECT display_type FROM MylabProductAttributeKeyInfo WHERE akID =?', array($akID));

		else :
			return 'text';
		endif;
	}

	function get_display_type_list () {
		// Ici on pourra faire quelque chose de dynamique,
		// Qui irait chercher les fichiers disponibles en root et ds le package
		return array (	'text' => "Simple Text",
						'links' => "Text Linked to Product Page",
						'image_links' => "Simple image linked to Product Page",
						'image_text_links' => "Image & name linked to Product Page"
			);
	}


	/* 						*
	 * Attribute Key Form	*
	*/	

	public function type_form() {
		$ak = $this->getAttributeKey();
		if (!is_object($ak)) $this->set('display_type', $this->get_display_type());
		else $this->set('display_type', $this->get_display_type($ak->getAttributeKeyID()));
		
		$this->set('display_type_list', $this->get_display_type_list());
	}
	
	public function saveKey($data) {
		$ak = $this->getAttributeKey();
		$db = Loader::db();
		$display_type = $data['display_type'] ? $data['display_type'] : 'links';
		// $ak->getAttributeKeyID()
		if (! $db->GetOne('SELECT display_type FROM MylabProductAttributeKeyInfo WHERE akID =?', array($ak->getAttributeKeyID())))
			$db->Execute('INSERT INTO MylabProductAttributeKeyInfo (akID,display_type) VALUES (?,?)', array($ak->getAttributeKeyID(), $display_type));
		else
			$db->Execute('UPDATE MylabProductAttributeKeyInfo SET display_type = ? WHERE akID = ?', array( $display_type, $ak->getAttributeKeyID()));
	}
	
	public function duplicateKey($newAK) {
		$db = Loader::db();
		$db->Execute('INSERT INTO MylabProductAttributeKeyInfo (akID,display_type) VALUES (?,?)', array($newAK->getAttributeKeyID(), $this->get_display_type()));
	}

	public function deleteKey() {
		$ak = $this->getAttributeKey();
		$db = Loader::db();
		$db->Execute('DELETE FROM MylabProductAttributeKeyInfo WHERE akID=?', array($ak->getAttributeKeyID()));
	}	
	
}
