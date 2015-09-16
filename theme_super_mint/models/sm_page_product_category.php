<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

//sm_page_product_category
Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
Loader::model('attribute/type');
Loader::model('attribute/categories/collection');
Loader::model('attribute/types/select/controller');
Loader::model('theme_super_mint_options', 'theme_super_mint');
Loader::model('product/list', 'core_commerce');

class SmPageProductCategory extends Object {

	// Gettings
	static function getBycID($cID) {
		$db = Loader::db();
		$js = Loader::helper('json');
		$row = $db->getRow("SELECT specs FROM SuperMinteCommerceCategory WHERE cID = ?",array($cID));
		if(!count($row)) return false;
		$pc = new SmPageProductCategory ();
		
		$pc->init(json_decode($row['specs'], true));
		return $pc;
	}
	static function getByPage($cObj) {
		return SmPageProductCategory::getBycID($cObj->cID);
	}
	static function getAll () {
		$all = array();
	    foreach (SmPageProductCategory::getPagesCategorized() as $cID) 	$all[$cID] = SmPageProductCategory::getBycID($cID);
	    return $all;
	}

	/* -- Initialisation --- */

	function init ($cat) { 
		$this->akID = array(); 
		$this->setPropertiesFromArray($cat);		 
		$this->active_akID = false; 
		$this->active_cID = false; 
		$this->build(); 
	}

	public function build () {

		// On compose le coktail d'option selectionné
		// et on transforme le ID d'options en objects
		if (count($this->akID) > 0) :
			foreach ($this->akID as $akID => $oIDs) :
				$this->active_oID[$akID] = array();
				// On va voir si on peut determiner ce menu comme selectionne
				if (is_array($_GET['selectedSearchField']) && is_array($_GET['akID'][$akID]['atSelectOptionID']) && $_GET['pcID'] == $this->category_result_page ) :
					if (in_array($akID, $_GET['selectedSearchField']) ) :
					  	$this->active_akID = $akID;
					  	$this->active_cID =  $this->category_result_page;
					  	$this->active_oID[$akID] =  $_GET['akID'][$akID]['atSelectOptionID'];
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
				$this->options[$akID] = $categOptions;
				$this->categories[$akID] = $akObj;
			endforeach;
			$this->contains = $this->createContainsProducts();
		endif;
	}

	public function getProductSet () {
		
		if ($this->prSet) :
			Loader::model('product/set', 'core_commerce');
			$ps = CoreCommerceProductSet::getByID($this->prSet);
			if (is_object($ps)) :
				return $ps;
			endif;
		endif;
	}

	function save ($data){

		$db = Loader::db();
		if ($db->GetOne("SELECT * FROM SuperMinteCommerceCategory WHERE cID = ?", array($data['cID']))) :
			$db->query("UPDATE SuperMinteCommerceCategory
					SET specs = ?
					WHERE cID = ?",
					array($data['specs'], $data['cID']));
		else :
			$db->query("INSERT INTO SuperMinteCommerceCategory (specs,cID) VALUES(?,?)", array($data['specs'],$data['cID']));				
		 endif;		
	}

	function createContainsProducts () {
		$db = Loader::db();
		$q = "
			SELECT  COUNT( DISTINCT pv.productID ) product_count, opt.value oVal, opt.ID oID, opt.akID
			FROM 	CoreCommerceProducts ccp,
					CoreCommerceProductAttributeValues pv,
					atSelectOptions opt,
					atSelectOptionsSelected sel,
					CoreCommerceProductSetProducts prset
			WHERE
				ccp.productID = pv.productID 
			AND ccp.prStatus = 1
			AND opt.ID = sel.atSelectOptionID
			AND pv.avID = sel.avID
			AND ccp.productID = prset.productID	
			AND opt.akID IN  (" . implode ( ',', array_keys($this->akID)) . ') ';
		// Si on a un product Set	
		if ($this->prSet) $q .= " AND prset.prsID = $this->prSet";

		$q .= ' GROUP BY(opt.value)';
		$query = $db->GetAll($q);
		// echo "<!-- ";			
		// print_r($query);
		// echo "-->";
		// Transformation des résultat en [213][5] => 12
		// ou 213 est l'akID, 5 l'ID de l'option et 12 le nombre de produits
		$count = array();
		foreach ($query as $key => $value) $count[$value['akID']][$value['oID']] = $value['product_count'];
		return ($count);	
	}

	function containsProducts ($oID, $akID) {

		$r = $this->contains[$akID][$oID];
		return $r ? $r : 0;
	}

	public function get_attribute_list ($type = 'string') {

	    Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
	    Loader::model('product/list', 'core_commerce');
	    $categories = array();
		$categories_list = CoreCommerceProductAttributeKey::getList();
		if (is_array($categories_list)) :
		    foreach ($categories_list as $key => $attr) :
		      if($attr->atHandle == 'select'):
		      	if ($type == 'string') :
			      	$categories[$key]['ak'] = $attr;
			      	$categories[$key]['options'] = $attr->getController()->getOptions()->getOptions(); // return array of object SelectAttributeTypeOption
			    elseif ($type == 'object') :
			      	$categories[$key] = $attr;
			    endif;
		      endif;
		    endforeach;
		endif;
		return $categories;
	}

	public function getPraparedAkFromAkID ($akID) {
	    Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
	    $a = new stdClass();
		$a->ak = CoreCommerceProductAttributeKey::getByID($akID);
		if(is_object($a->ak))
			$a->options= $a->ak->getController()->getOptions()->getOptions();		
		return $a;
	}


	/* --- Relative with pages --- */

	static function getPagesCategorized (){
		Loader::model('page_list');
		$cIDS = array();
		$pl = new PageList();
		$pl->filterByPageProductCat(1);
		$pages = $pl->get();	
		// On compose un tableau QUE de cID
		array_walk($pages, create_function ('&$n','$n = intval($n->cID);'));
		return $pages;
	}


}

