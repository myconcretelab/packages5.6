<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
class RelatedContentLinksPackage extends Package {

	protected $pkgHandle = 'related_content_links';
	protected $appVersionRequired = '5.4';
	protected $pkgVersion = '1.0';
	
	public function getPackageName() {
		return t('Related Content Links'); 
	}
	
	public function getPackageDescription() {
		return t('Displays links to "related content" pages in a chosen category.');
	}
	
	public function install() {
		$pkg = parent::install();
		
		//install page attribute
		Loader::model('collection_attributes');	
		$ak = CollectionAttributeKey::getByHandle('related_content_category');
		if (is_null($ak)) {
			$args = array(
				'akHandle' => 'related_content_category',
				'akName' => t('Content Is Related To Category'),
				'akIsSearchable' => true,
				'akIsSearchableIndexed' => true,
				'akSelectAllowMultipleValues' => true,
				'akSelectAllowOtherValues' => false, //"Allow users to add to this list." -- turned off by default because I don't like the UI for it (confusing textbox/tag thingy)
				'akSelectOptionDisplayOrder' => 'display_asc', //'display_asc', 'alpha_asc', 'popularity_desc'
			);
			CollectionAttributeKey::add('select', $args, $pkg);
		}
		
		// install block
		BlockType::installBlockTypeFromPackage('related_content_links', $pkg);		
	}

}