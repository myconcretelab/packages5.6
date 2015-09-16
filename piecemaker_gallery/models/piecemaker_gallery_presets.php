<?php  
class PiecemakerGalleryPresets extends Object {

	public $effectPresetID = 0;
	public $title = NULL;
	public $options = array();
		
	public function __construct() {
	
	}
	
	public static function getByID($effectPresetID) {
		$db = Loader::db();
		$row = $db->getRow("SELECT * FROM btPiecemakerGalleryPresets WHERE effectPresetID = ?", array($effectPresetID));
		if(is_array($row)) {
			return $row;
		} else {
			return false;
		}
	}
	public static function getOptionsByID($effectPresetID) {
		$temp = PiecemakerGalleryPresets::getByID($effectPresetID);
		return $temp['options'];
	}
	
	public static function getDefaultOptionsValues () {
		return array('Pieces'=>9, 'Time'=>1.2, 'Transition'=>"easeInOutBack", 'Delay'=>0.1, 'DepthOffset'=>300, 'CubeDistance'=>30);
	}

	public static function getTweenArray () {
		return array('linear'=>'linear',
				'easeInCubic'=>'easeInCubic',
				'easeOutCubic'=>'easeOutCubic',
				'easeInOutCubic'=>'easeInOutCubic',
				'easeInBack'=>'easeInBack',
				'easeOutBack'=>'easeOutBack',
				'easeInOutBack'=>'easeInOutBack',
				'easeInElastic'=>'easeInElastic',
				'easeOutElastic'=>'easeOutElastic',
				'easeInOutElastic'=>'easeInOutElastic',
				'easeInBounce'=>'easeInBounce',
				'easeOutBounce'=>'easeOutBounce',
				'easeInOutBounce'=>'easeInOutBounce'
				);
	}

	public static function getList() {
		$db = Loader::db();
		$pl = $db->getAll("SELECT effectPresetID,title FROM btPiecemakerGalleryPresets");
		if(is_array($pl)) {
			return $pl;
		} else {
			return false;
		}
	}
		
	
	public static function delete($effectPresetID) {
		if(intval($effectPresetID) > 0) {
			$db = Loader::db();	
			$db->query("DELETE FROM btPiecemakerGalleryPresets WHERE effectPresetID = ?",array($effectPresetID));
		} else {
			return false;
		}
	}

	public static function save($data) {
		$db = Loader::db();
		$vals = array($data['title'],implode(',',$data['options']));
		if (intval($data['pID']) > 0) {
			$vals[] = $data['pID'];
			$db->query("UPDATE btPiecemakerGalleryPresets SET title=?, options=? WHERE effectPresetID = ?",$vals);
		} else {
			$db->query("INSERT INTO btPiecemakerGalleryPresets (title, options) VALUES (?,?)", $vals);
			print $db->Insert_ID();
		}
	}	
}
?>