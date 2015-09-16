<?php     
class CoverNavigatorInfos extends Object {

	public $effectPresetID = 0;
	public $title = NULL;
	public $options = array();
		
	public function __construct() {
	
	}
	
	public static function getByID($cID) {
		$db = Loader::db();
		$row = $db->getRow("SELECT * FROM btCoverNavigatorInfos WHERE ciID = ?", array($cID));
		if(is_array($row)) {
			return $row;
		} else {
			return false;
		}
	}		
	
	public static function delete($ciID) {
		if(intval($ciID) > 0) {
			$db = Loader::db();	
			$db->query("DELETE FROM btCoverNavigatorInfos WHERE ciID = ?",array($ciID));
		} else {
			return false;
		}
	}

	public static function save($data) {
		$db = Loader::db();
		if (key_exists('ciID',$data)) {
			$db->query("UPDATE btCoverNavigatorInfos SET logo=?, medias=?, mediaTypes=? WHERE ciID = ?",array_values($data));
			return $data['ciID'];
		} else {
			$db->query("INSERT INTO btCoverNavigatorInfos (logo, medias, mediaTypes) VALUES (?,?,?)", array_values($data));
			return $db->Insert_ID();
		}
		
	}
	
	
	
}
?>