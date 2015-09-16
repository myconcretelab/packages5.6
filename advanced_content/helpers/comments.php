<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Silence theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */


class CommentsHelper {
	
	public function comment_count($collectionObject) {
		$db = Loader::db();
		$q = 'SELECT count(bID) as count
		FROM btGuestBookEntries
		WHERE approved=1
		AND bID IN (
			SELECT bID
			FROM CollectionVersionBlocks
			WHERE cID = ?
		)';
		$v = Array($collectionObject->cID);
		$rs = $db->query($q,$v);
		$row = $rs->FetchRow();
		$count = $row['count'];
		return $count;
	}
	
	public function get_last_comments ($collectionObject = null, $count = 10) {

		$db = Loader::db();
		$q = 'SELECT *
		FROM btGuestBookEntries
		WHERE approved=1 ';
		if ($collectionObject) $q .= ' and cID = ? ';
		$q .= 'ORDER BY entryID DESC LIMIT ?';
		if ($collectionObject) $v = Array($collectionObject->cID, $count);
			else $v = Array($count);
		$rs = $db->query($q,$v);
		$rows = $rs->getRows();

		if (count ($rows)) :

			$th = Loader::helper('text');
			$nh = Loader::helper('navigation');
			$result = array();

			foreach ($rows as $key=>$com) :
				$result[$key] = array();
				$page = Page::GetByID($com['cID']);
				//$pageObj = Page::getByID($page->getCollectionID(), 1)->getVersionObject();
				
				$result[$key]['pageTitle'] = $th->entities($page->getCollectionName());
				$result[$key]['url'] = $nh->getCollectionURL($page);
				$result[$key]['commentText'] =  $th->shortText($com['commentText'], 150);				
				$result[$key]['userName'] = $com['user_name'];
				$result[$key]['entryDate'] = $com['entryDate'];
			endforeach ;
			
			return $result;

		else :
			return false;	
		endif;
		
	}
}