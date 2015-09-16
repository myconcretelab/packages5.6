<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodePageInfo  extends CapsuleCodeHelper  {
	
	public $samplecontent = ' ';	
	public $name = false;
	public $description = false;
	public $handle = false;


	public $creationdate = false;
	public $modificationdate = false;
	public $publicdate = false;
	public $dateformat = "%m/%d/%y";

	public $commentscount = false;
	
	public $attribute = 0;
	
	public $breadcrumb = false;

	public $nametag = 'h1';
	public $descriptiontag = 'h4';
	public $datetag = 'small';
	public $othertag = 'p';

	public $pageid = 0;
	public $link = false;

	public $class = "";

	public $lastcommentscount = 5;
	public $lastcomments = false;
	
	function get_capscode () {

		return t('[page_info 	
							othertag = "-s:h1|h2|h3|h4|p|small|i _Other tags_ #tag for other info#"
							nametag = "-s:|h1|h2|h3|h4|p _Name Tag_ #the tag for the name#"
							descriptiontag = "-s:|h3|h4|p|small _Description Tag_ #the tag for the description#"
							datetag = "-s:|p|small|i _Date Tag_ #tag for date#"
							dateformat="-t _Date Format_ #Format for the date#"
							creationdate="-b _Creation date_ #Display the creation date of selected page#"
							modificationdate="-b _Modification Date_ #Display the modification date of selected page#"
							commentscount="-b _Comments count_ #Display the number of comments in a page#"
							lastcommentscount="-n _Last comments count_ #How many last comment to display#"
							lastcomments="-b _Last comments_ #Display last(s) comment(s) from a page#"							
							attribute="-pa _A attribute_ #Display the value of a atribute#"
							breadcrumb = "-b _Breadcrumb_ #Display a breadcrumb#"
							name="-b _name_ #Display the title of selected page#"
							link = "-b _link_  #display name as link#"
							description="-b _description_ #Display the description of selected page#"
							pageid = "-p _The page_#(optional) If no page is handpicked, the current page will be used#"
						]');
	}

	function build_html () {
		
		$html = array();
		$class = " class='$this->class'";
		
		if 	(intval($this->pageid)) $page = Page::getByID($this->pageid);
		else $page = Page::getCurrentPage();

		$nh = Loader::helper('navigation');
		$linktag['open'] = $this->link ? "<a href='{$nh->getCollectionURL($page)}' >" : '';
		$linktag['close'] = $this->link ? '</a>' : '';

		if ($this->name) 	$html[] = '<' . $this->nametag . $class . '>' . $linktag['open'] . $page->getCollectionName() . $linktag['close'] . '</' . $this->nametag . '>';

		if ($this->description) $html[] = '<' . $this->descriptiontag . $class . '>' . $page->getCollectionDescription() . '</' . $this->descriptiontag . '>';
		
		if ($this->breadcrumb) 	$html[] = $this->output_breadcrumb($page); 
				
		if ($this->creationdate) :
			$time=strtotime($page->getCollectionDateAdded());
			$html[] = '<' . $this->datetag . $class . '>' . strftime($this->dateformat,$time) . '</' . $this->datetag . '>';
		endif;
			
		if ($this->modificationdate) :
			$time=strtotime($page->getCollectionDateLastModified());
			$html[] = '<' . $this->datetag . $class . '>' . strftime($this->dateformat,$time) . '</' . $this->datetag . '>';
		endif;

		if ($this->publicdate) :
			$time=strtotime($page->getCollectionDatePublic());
			$html[] = '<' . $this->datetag . $class . '>' . strftime($this->dateformat,$time) . '</' . $this->datetag . '>';
		endif;
		if (($this->attribute) && $page->getAttribute($this->attribute)) :
			$html[] = '<' . $this->othertag . $class . '>' . $page->getAttribute($this->attribute) . '</' . $this->othertag . '>';
		endif;

		if ($this->lastcomments && intval($this->lastcommentscount) > 0) :
			$comhelper = Loader::helper('comments', 'advanced_content');
			$comments = $comhelper->get_last_comments($page, intval($this->lastcommentscount));

			if (is_array($comments)) {
				foreach ($comments as $key => $com) {
					$html[] =  '<' . $this->othertag . $class . '>' . $com['commentText'] . '</' . $this->othertag . '>';
					$html[] = '<p><small><strong>' . t('By ') . '</strong>&nbsp<i>' . $com['userName'] . '</i></small></p>';
				}

			}
		endif;

		return implode("\n", $html);
		
		
	}
	// Semble ne pas fonctionner si les "pretty urls" ne sont pas activŽ ?
	function output_breadcrumb ($c = null ) {
		$c = $c ? $c : Page::getCurrentPage();
		$return = '';
		$nh = Loader::helper('navigation');
		$breadcrumb = $nh->getTrailToCollection($c); 
		krsort($breadcrumb); 
		foreach ($breadcrumb as $bcpage) {
		    $return .= '<a href="'.BASE_URL.DIR_REL.$bcpage->getCollectionPath().'/">'.$bcpage->getCollectionName().'</a>&nbsp;&gt;&nbsp;'; 
		} 
		$return .= '<span>' . $c->getCollectionName() . '</span>';
		return $return;
	}

}


