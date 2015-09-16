<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeButton  extends CapsuleCodeHelper {
	
	public $link= '';
	public $linktarget= '_parent';
	public $style = "default";
	public $size = "default";
	public $block = false;
	public $link_url = 'http://';

	function get_capscode () {

		return t('[button 
						style="-s:|default|primary|info|success|warning|danger|inverse|link #Choose the apparence of the button##"
						size = "-s:|default|large|small|mini #Fancy larger or smaller buttons?#"
						block = "-b #Create block level buttons—those that span the full width of a parent#"
						link_page ="-p #Or choose a page#"
						link_url ="-t #your url must start by http://#"
						]
						[/button]');
	}
	public function __get ($option) {
		
		$default =  array ('samplecontent' => t('Boutton text'));
		return $default[$option];

	}
	function build_html () {
		$rand = rand(0,999);

		$class = '';

		if ($this->style != 'default')
			$class .= ' btn-' . $this->style;
		if ($this->size != 'default')
			$class .= ' btn-' . $this->size;
		if ($this->block)
			$class .= ' btn-block';
		
		if ($this->link_url != 'http://' && substr($this->link,0,7) == '') {
			$link = $this->link_url;
		}
		if (intval($this->link_page)) {
			$nv = Loader::helper('navigation');
			$page = Page::getByID($this->link_page);
			if($page->cID) 
				$link = $nv->getLinkToCollection($page);

		}

		$output = '<a href="' . (isset($link) ? $link : '#') . '" type="button" class="btn ' . $class . ' ' . $alignment .'">';
		$output .= $this->content;
		$output .= '</a>';

		return $output ;

	}
}