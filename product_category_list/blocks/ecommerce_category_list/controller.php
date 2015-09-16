<?php  defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
Loader::model('attribute/type');
Loader::model('attribute/categories/collection');
Loader::model('attribute/types/select/controller');
Loader::model('product/list', 'core_commerce');

class EcommerceCategoryListBlockController extends BlockController {
	
	protected $btName = 'Category List';
	protected $btDescription = 'Dislay a list of first product from a categorie list options';
	protected $btTable = 'btDCEcommerceCategoryList';
	
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;

	protected $categoryNameSpace = 'category';
	protected $categoryValueNameSpace = 'value';


	public function add () {

	    $this->set('akIDs',array());
	    $this->addEdit();
	    $this->set('contains', $this->createContainsProducts());
	}

	public function edit () {
		$this->build();
		$this->setCategoryToView();
	    $this->addEdit();
		$this->set('akIDs', $this->akID);
	}
	function addEdit () {
	    $this->set('categories_list', $this->get_attribute_list());
	    $this->set('pageSelector' ,Loader::helper('form/page_selector'));		
	}

	public function build ($akObj = NULL) {
		// I don't use the json because only late version of C5 use the second parameter that create a table in place of object.
		$js = Loader::helper('json');
		// This is to try to avoid error on test :-)
		$js = 'json' . '_decode';
		$this->akID = $js($this->categories, true);
		$this->category = array();
		$this->active_akID = false;
		$this->active_oID = array();
		$column_asked = $this->columns_limit;

		foreach ($this->akID as $akID => $oIDs) :
			
			// On va voir si on peut determiner ce menu comme selectionne
			// A voir l'utilité d'afficher la categorie en cours car ds ce genre de bloc, on a rarement reglé la page de redirection, donc les résultas seront moyens..
			if (is_array($_GET['selectedSearchField']) && is_array($_GET['akID'][$akID]['atSelectOptionID'])) :
				if (in_array($akID, $_GET['selectedSearchField']) ) :
				  	$this->active_akID = $akID;
				  	$this->active_oID = $_GET['akID'][$akID]['atSelectOptionID'];
				endif;
			endif;	
			

			$akObj = CoreCommerceProductAttributeKey::getByID($akID);
			if(!is_object($akObj)) continue;
			$categOptions = array();

			// Si on n'a QUE 'all'
			if ($oIDs[0] == 'all' && count($oIDs) == 1) :
				// On les prend toutes
				$categOptions = $akObj->getController()->getOptions()->getOptions();
			// Si il y a 'all' et d'autres ID	
			elseif ($oIDs[0] == 'all' && count($oIDs) > 1) :
				// Ici on va retirer les options citées après 'all'
				unset ($oIDs[0]);
				foreach ($akObj->getController()->getOptions()->getOptions() as $oObj ) :
					if (in_array($oObj->ID , $oIDs) ) continue;
					else $categOptions[] = $oObj ;
				endforeach;

			// il n'y a pas 'all'
			else :
				// Il n'y a pas de 'all', on prend celle selectionnées
				foreach ($oIDs as $avID) $categOptions[] = Concrete5_Model_SelectAttributeTypeOption::getByID($avID);
			endif;

			// petit calcul pour les colonnes d'options 
			$calculated_columns_number_from_opt = $this->getClosestColumnsNumber(count($categOptions));
			if ($column_asked) :
				// Si le nombre d'options dépasse le nombre maximum de colonnes, on prend le nb d'options
				if ($column_asked > $calculated_columns_number_from_opt) $columns_number = $calculated_columns_number_from_opt;
				else $columns_number = $column_asked;
			else : $columns_number = $calculated_columns_number_from_opt;
			endif;

			$this->options[$akID] = $categOptions;
			$this->category[$akID] = $akObj;
			$this->columns_number_per_options[$akID] = $columns_number;	


		endforeach;
		// On va compter pour chaque options le nombre de produits présent. Si il n'y a pas de produits, loID ne sera pas présent ds ce tableau
		$this->contains = $this->createContainsProducts();

		// petit calcul pour les colonnes de catégories
		$calculated_columns_number_from_cat = $this->getClosestColumnsNumber(count($this->category));
		if ($column_asked) :
			// Si le nombre de categories dépasse le nombre maximum de colonnes, on prend le nb de cat
			if ($column_asked > $calculated_columns_number_from_cat) $columns_number = $calculated_columns_number_from_cat;
			else $columns_number = $column_asked;
		else : $columns_number = $calculated_columns_number_from_cat;
		endif;
		$this->columns_number_per_ak = $columns_number;

		// Si on doit retirer les options qui ne contiennent pas de produits
		if (!$this->display_empty_option) :
			foreach ($this->category as $akID => $akObj) :
				foreach ($this->options[$akID] as $key => $oObj) :
					// Quand une option ne contient pas de produits, elle n'existe pas ds le tableau 'contains'
					if(!isset($this->contains[$akID][$oObj->ID])) unset($this->options[$akID][$key]);
				endforeach;
			endforeach;
		endif;

	}	
	function createContainsProducts () {
		$this->akID = $this->akID ? $this->akID : array();
		$db = Loader::db();
		$q = "
			SELECT  COUNT( DISTINCT pv.productID ) product_count, ccp.prThumbnailImageFID fID, opt.value oVal, opt.ID oID, opt.akID
			FROM 	CoreCommerceProducts ccp,
					CoreCommerceProductAttributeValues pv,
					atSelectOptions opt,
					atSelectOptionsSelected sel,
					CoreCommerceProductSetProducts prset
			WHERE
				ccp.productID = pv.productID 
			AND opt.ID = sel.atSelectOptionID
			AND pv.avID = sel.avID
			";	
		$q .= count($this->akID) ? ("AND opt.akID IN  (" . implode ( ',', array_keys($this->akID)) . ')') : ' ';
		// Si on a un product Set	
		if ($this->fsID) $q .= " AND ccp.productID = prset.productID AND prset.prsID = $this->fsID";

		$q .= ' GROUP BY(opt.value)';	
		$query = $db->GetAll($q);
		
		// Transformation des résultat en [213][5] => 12
		// ou 213 est l'akID, 5 l'ID de l'option et 12 le nombre de produits
		$count = array();


		foreach ($query as $key => $value) :
			$count[$value['akID']][$value['oID']]['count'] = $value['product_count'];
			$count[$value['akID']][$value['oID']]['fID'] = $value['fID'];
		endforeach;
		return ($count);	
	}

	function containsProducts ($oID, $akID) {

		$r = $this->contains[$akID][$oID];
		return $r ? $r : 0;
	}


	public function getAttributeKey ($akID) {
		return CoreCommerceProductAttributeKey::getByID($akID);
	}

	function setCategoryToView () {
        $this->set('categories', $this->category);
        $this->set('contains', $this->contains);
        $this->set('options', $this->options);		
        $this->set('active_akID', $this->active_akID);		
        $this->set('active_oID', $this->active_oID);
        $this->set('columns_number_per_options', $this->columns_number_per_options);		
        $this->set('columns_number_per_ak', $this->columns_number_per_ak);		
	}


	public function view () {
		$start = microtime(true);
		$db = Loader::db();
		$this->display_empty_cat = false;
		$this->build();

		$redirect =  $this->redirectpage ? $this->redirectpage : Page::getCurrentPage()->cID;
		$redirect = BASE_URL . DIR_REL . Page::getByID($redirect)->cPath;

		$this->setCategoryToView();
		$this->set('redirecturl', $redirect);            
		$this->set('time',  microtime(true) - $start);
		$this->set('productSet' , $ps);
		$this->set('uh', Loader::helper('url'));
		$this->set('ih', Loader::helper('image'));
		$this->set('nh', Loader::helper('navigation'));	
		Loader::model('file');	
	}

	public function save ($data) {
		
		// Test si l'utilisateur a au moin coché une case

		if(is_array($data['selected_categories'])) :
			// A travers les catégories
			foreach ( $data['selected_categories'] as $akID ) :
				$options = $data['categories'][$akID];
				//print_r($data['categories']['akID']); exit();
				// Tester si cette catégorie contient des options cochées
				if (is_array($options)):
					// A travers les options cochées
					foreach ($options as $oID) {
						$o[$akID][] = $oID;
					}
				// Sinon, l'utilisateur a coché la catégorie, mais sans options
				else :

				endif;
			endforeach;
		// Si l'utilisateur n'a rien coché
		else :
			$data['categories'] = '';
		endif;
			// On sauve sous json
		$js = Loader::helper('json');
		$data['categories'] = $js->encode($o);
		parent::save($data);
	}

	function getClosestColumnsNumber ($search, $arr = array(1,2,3,4,6)) {
	   $closest = null;
	   foreach($arr as $item) {
	      if($closest == null || abs($search - $closest) > abs($item - $search)) {
	         $closest = $item;
	      }
	   }
	   return $closest;
	}

	public function get_attribute_list ($type = 'string') {
	    $categories = array();
		$categories_list = CoreCommerceProductAttributeKey::getList();
		if (is_array($categories_list)) :
		    foreach ($categories_list as $key => $attr) :
		      if($attr->atHandle == 'select'):
		      	if ($type == 'string') :
			      	$categories[$key]['ak'] = $attr;
			      	$categories[$key]['options'] = $attr->getController()->getOptions()->getOptions(); // return array of object SelectAttributeTypeOption
			    elseif ($type == 'object') :
			      	$categories[$key]['object'] = $attr;
			    endif;
		      endif;
		    endforeach;
		endif;
		return $categories;

	}


}
