<?php   
defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @package SuperMint theme Product page
 * @category Controller
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

Loader::model('sm_page_product_category','theme_super_mint');
Loader::model('product/list', 'core_commerce');
Loader::model('product/set', 'core_commerce');

class ProductsController extends Controller {

	function __construct() {
	}

	function category ( $psName, $akHandle, $akValue) {
		$this->__call('category', array($psName, $akHandle, $akValue));
	}

	public function view() {
		


	/*
		Cette gestion des template me parrait pas vraiment super.
		Avantage : on peut très facilement changer la façon dont s'affichent les produits
		Inconvéniants : Tout est très cadenassé
	*/

	// Si on arrive sur cette page sans REQUEST (en edition par exemple), on doit regler certaines variables.
		//var_dump();
		if (!$this->cID) :
			$this->cID = $this->c->cID;
		endif;

	// Les options
		Loader::model('theme_super_mint_options', 'theme_super_mint');
		$t = new ThemeSuperMintOptions();
		// On lui assigne un preset id correspondant à la page qui apelle.
		$t->set_collection_object(Page::getByID($this->cID));			

	// Le fichier d'affichae des produits
		loader::model('sm_page_product_category', 'theme_super_mint');
        $fh = Loader::helper('theme_file', 'theme_super_mint');
        // $paths est un tableau de deux url representnant les deux endorits ou peuvent se trouver les templates de listing produit
        $paths = SmPageProductCategory::getProductListTemplateDirPath();
        // le fichier choisi par l'utilisateur
        $file = $t->{'_product_list_template-' . $this->cID};
        // On teste si ile existe en root/element/product_list/
        if ( is_file($paths['custom'] . '/' . $file . '.php')) :
        	// On charge le fichier d'utilisateur dans le tampon
        	ob_start(); loader::element($paths['dir'] . '/' . $file, array('activeCategoryList' => $this->activeCategoryList, 'passiveCategory' => $this->passiveCategory));
        	$productPage = ob_get_clean();

        elseif (is_file($paths['theme'] . '/' . $file. '.php')) :
        	// On charge le fichier du theme dans le tampon
        	ob_start();
        		loader::packageElement($paths['dir'] . '/' . $file,'theme_super_mint', array('activeCategoryList' => $this->activeCategoryList, 'passiveCategory' => $this->passiveCategory));
        	$productPage = ob_get_clean();
        else :
        	// On a pas su charger de template, nous voila bien embeté.
        	// Alors on charge l'element de base 
        	ob_start();
        	loader::packageElement('product_list/product_list_round', 'theme_super_mint', array('c' => Page::getCurrentPage()));	
        	$productPage = ob_get_clean();
        endif;
    	
        $this->set('productPage', $productPage);
        
	}

	function buildMainCategory () {
		// On rend global un tableau qui contient les info de la categorie
		// Ce qui permet de l'avoir dans la navigation ou autre
		global $activeCategory;
		$activeCategory = array(
				'productSetName' => $this->productSetName,
				'akHandle' => $this->akHandle,
				'akValue' => $this->akValue,
				'cID' => $this->cID 
				);


		$pp = new SmPageProductCategory ($this->c);

		// Mainteant il faut préparer les produits appartenant à l'option demandé
		// ex : les produit de couleur rouge
		// ainsi que UN produit representant chaque autre option demandé.

		// On recence les options que l'utilisateur à demande
		$selected_options = $pp->getSelectedOptions($this->ak);
		// Le tableau qui contiendra toutes les autres options de categorie
		$passiveCategory = array();
		foreach ($selected_options as $oObj) {
			if ($oObj->value == $this->akValue) :
				// Ici on est dans l'option qui à été choise par l'utilisateur

				$activeCategoryList = $this->getProductList($oObj);
			else :
				// Ici on est dans une option non séléctionnée
				// donc on ne retien qu'un produit
				$passiveCategory[] = $this->getProductList($oObj,1);
			endif;

		}
		if (isset($activeCategoryList)) :
			$this->activeCategoryList = $activeCategoryList;
			$this->passiveCategory = $passiveCategory;
		else:

			// On a un problème, on  a pas de catégorie et pas de produits principaux...
		endif;

		$this->view();
	}

	function getProductList ($akOptionObject, $itemPerPage = 50) {
		$list = new CoreCommerceProductList();
		$list->filterByAttribute($this->ak->akHandle,$akOptionObject->value);
		//if ($this->underpage) $list->filterByPage($this->underpage);
		if ($this->productSetName) $list->filterBySet($this->getProductSetByName($this->productSetName));
		$list->setItemsPerPage($itemPerPage);
		$list->sortBy('prDateAdded', 'desc');
		return $list;
	}
	public function getProductSetByName($prsName) {
		$db = Loader::db();
		$r = $db->GetRow('select * from CoreCommerceProductSets where prsName = ?', array($prsName));
		if (is_array($r) && $r['prsID'] > 0) {
			$pr = new CoreCommerceProductSet();
			$pr->setPropertiesFromArray($r);
			return $pr;
		}
	}
	
	function __call ($name,$arg) {
		// Cette fonction va supporter tous les appels 
		// non référencé par des fonctions.
		// ici $name = $arg[0]

		// Le nom du Product Set
		$this->productSetName = urldecode($arg[0]);
		// Le nom de la categorie
		$this->akHandle = urldecode($arg[1]);
		// La valeur de la categorie
		$this->akValue = urldecode($arg[2]);
		// La cID
		$this->cID = $arg[3];
		// La page de 
		$this->c = Page::getByID($this->cID);

		
		//La première chose à voir est si l'attrribut existe
		Loader::model('attribute/categories/core_commerce_product', 'core_commerce');
		$this->ak = CoreCommerceProductAttributeKey::getByHandle($this->akHandle);
		// Si l'attribut existe, on va aller chercher les options que l'utilisateur à selectionné
		// Qu faire si il y a une erreur ?
		//var_dump($this->ak);
		if (is_object($this->ak)) $this->buildMainCategory();
		//$options = Concrete5_Model_SelectAttributeTypeOption::getByValue($_GET['value'], $akObject_get);

	}

}