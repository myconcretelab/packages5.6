<?php 

defined('C5_EXECUTE') or die("Access Denied.");
class RelatedContentLinksBlockController extends BlockController {
		
	protected $btTable = 'btRelatedContentLinks';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "200";

	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;
	
	private $dateFormats = array(
		0 => '', //don't show date
		1 => 'F j, Y', //January 24, 2011
		2 => 'M j, Y', //Jan 24, 2011
		3 => 'n/j/y', //1/24/11
		4 => 'n/j/Y', //1/24/2011
		5 => 'j/n/y', //24/1/11
		6 => 'j/n/Y', //24/1/2011
		7 => 'Y-m-d', //2011-01-24
	);
	
	public function getBlockTypeName() {
		return t('Related Content Links');
	}
	
	public function getBlockTypeDescription() {
		return t('Displays links to "related content" pages in a chosen category.');
	}
	
	public function view() {
		$pages = $this->getRelatedContentPages();
		$this->set('pages', $pages);

		$nh = Loader::helper('navigation');
		$this->set('nh', $nh);

		$this->set('dateFormat', $this->dateFormats[$this->dateFormat]);
	}
	
	private function getRelatedContentPages() {
		Loader::model('page_list');
		$pl = new PageList();
		if ($this->displayOrder == 'SITEMAP') {
			$pl->sortByDisplayOrder();
		} else {
			$pl->sortBy('cvDatePublic', 'desc'); //$pl->sortByPublicDate() is only ascending, and there's no sortByPublicDateDescending() function [UPDATE: AS OF 5.5(?) THERE *IS* A sortByPublicDateDescending() function!]
		}
		$pl->filter('c.cID', Page::getCurrentPage()->getCollectionID(), '<>'); //Exclude current page from the list
		
		$db = Loader::db();
		$relatedCategoryOptionName = $db->GetOne('SELECT value FROM atSelectOptions WHERE ID = ?', array($this->relatedCategoryOptionID));

		//FILTER NOTES:
		// * PageList filter() takes an attributeValue's name, not its ID
		// * Attributes of type "select" wrap values in newline characters when saved to the database -- see http://www.concrete5.org/developers/bugs/5-4-1-1/select-type-attribute-wraps-saved-values-in-linefeed-characters/
		$pl->filterByAttribute('related_content_category', "%\n{$relatedCategoryOptionName}\n%", "LIKE");
		//
		//The following line does the exact same thing as above:
		// $pl->filterByRelatedContentCategory(array("%\n{$relatedCategoryOptionName}\n%", 'LIKE')); //Note that the value and comparison must be passed in an array as a single argument to this magic method (if you only pass in 1 arg it does an equality comparison)
		//
		//And the following 2 lines do the exact same thing as above:
		// $escapedRelatedCategoryOptionName = $db->escape($relatedCategoryOptionName); //Must manually escape values when passing 'false' as first arg to $pl->filter(), otherwise you're open to SQL injection!! See http://www.concrete5.org/community/forums/customizing_c5/pagelist_filter_by_page_custom_attributes/#379922
		// $pl->filter(false, "(ak_related_content_category LIKE '%\n{$escapedRelatedCategoryOptionName}\n%')"); //See http://www.concrete5.org/developers/pro-accounts/community-leaders-area/community-leaders-discussion/filter-by-attribute/
		//
		//One last note about $db->escape() vs. $db->quote() and $db->qstr()... the former escapes quotes in the string, and the latter two escape quotes AND wrap the whole string in quotes.
		
		return $pl->get($this->displayCount);
		//Alternately, you could do this:
		// $pl->setItemsPerPage($this->displayCount);
		// return $pl->getPage();
	}
	
	function add() {
		$this->setCategories();
		$this->set('relatedCategoryOptionID', '0');
		$this->set('dateFormats', $this->dateFormats);
		
		//Default values for new blocks
		$this->set('displayCount', 3);
		$this->set('displayOrder', 'RECENT');
		$this->set('title', t('Related Content'));
		$this->set('dateFormat', 1);
	}
	
	function edit() {
		$this->setCategories();
		$this->set('dateFormats', $this->dateFormats);
	}
	
	private function setCategories() {
		Loader::model('attribute/type');
		Loader::model('attribute/categories/collection');
		// $ak = CollectionAttributeKey::getByID($akID);
		$ak = CollectionAttributeKey::getByHandle('related_content_category');
		$satc = new SelectAttributeTypeController(AttributeType::getByHandle('select'));
		$satc->setAttributeKey($ak);
		$categories = $satc->getOptions();
		$this->set('categories', $categories);
	}
	
}

?>