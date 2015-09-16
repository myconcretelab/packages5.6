<?php       
class AdvancedSliderPresets extends Object {

	public $effectPresetID = 0;
	public $title = NULL;
	public $options = array();
		
	public function __construct() {
	
	}
	
	public static function getByID($effectPresetID) {
		$db = Loader::db();
		$row = $db->getRow("SELECT * FROM btAdvancedSliderPresets WHERE effectPresetID = ?", array($effectPresetID));
		if(is_array($row)) {
			return $row;
		} else {
			return false;
		}
	}
	public static function getRandomValues () {
		return array('options'=>"random,random,random,random,slide,50,1000,5,3,1,5000,sliceFade,autoHorizontal, random");
	}
	public static function getDefaultValues () {
		return array('options'=>"random,random,centerCenter,left,slide,50,1000,5,3,1,5000,sliceFade,autoHorizontal,random");
	}
	public static function getList() {
		$db = Loader::db();
		$pl = $db->getAll("SELECT effectPresetID,title FROM btAdvancedSliderPresets");
		if(is_array($pl)) {
			return $pl;
		} else {
			return false;
		}
	}
		
	
	public static function delete($effectPresetID) {
		if(intval($effectPresetID) > 0) {
			$db = Loader::db();	
			$db->query("DELETE FROM btAdvancedSliderPresets WHERE effectPresetID = ?",array($effectPresetID));
		} else {
			return false;
		}
	}

	public static function save($data) {
		$db = Loader::db();
		$vals = array($data['title'],implode(',',$data['options']));
		if (intval($data['pID']) > 0) {
			$vals[] = $data['pID'];
			$db->query("UPDATE btAdvancedSliderPresets SET title=?, options=? WHERE effectPresetID = ?",$vals);
		} else {
			$db->query("INSERT INTO btAdvancedSliderPresets (title, options) VALUES (?,?)", $vals);
			print $db->Insert_ID();
		}
	}
	
	
	
}
?>