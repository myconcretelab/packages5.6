<?php  defined('C5_EXECUTE') or die("Access Denied.");

class PortfolioOptions extends Object {

	/*
		Le Model est dŽjˆ plus ou moins prŽvu pour recevoir des presets.
	 */
	public function get_default_option () {
		return array(
			'options'=>'description,title,showTitle',
			'blankFileID' => 0,
			'thumbWidth'=>'210',
			'thumbHeight'=>'auto',
			'maxPicture'=>'10',
			'displayType'=>'fileset',
			'indexPicture'=>'0',
			'position'=>'body',
			'buttonText'=>'Expand Folio',
			'button_color'=>'black',
			'textUnderDesc'=>'Hover to zoom > click to view'
			, 'zoomWidth'=>'auto'
			, 'zoomHeight'=>'auto'
			, 'adjustX'=>'0'
			, 'adjustY'=>'0'
			, 'tintOpacity'=>'.5'
			, 'lensOpacity'=>'.5'
			, 'smoothMove'=>'3'
			, 'titleOpacity'=>'.5'
			, 'tint_color'=>'#CC5555'
		     );
	}
	public function install() {
		PortfolioOptions::add(PortfolioOptions::get_default_option());
	}
	
	public function load() {
		$db = Loader::db();
		$row = $db->GetRow("select * from PortfolioOptions where oID = ?",array(1));
		if ($row) {
			return $row;
		} else {
			return false;
		}

	}
	public function add ($array) {
		$db = Loader::db();
		$abs = array();
		if (is_array) :
			foreach ($array as $ok=>$ov) :
				$clean_array[$ok] =  (is_array($ov)) ? implode(',',$ov) : $ov; // ce test n'est plus nŽcessaire.
				$abs[] = '?'; 
			endforeach;
			$keys = implode(', ', array_keys($clean_array));
			$values = array_values($clean_array);
			$abs = implode(', ',$abs);
			$db->Execute("insert into PortfolioOptions ($keys) values ($abs)", $values);
			//EXECUTE("insert into PortfolioOptions (options, maxPicture, displayType, buttonText, button_color, textUnderDesc, zoomWidth, zoomHeight, adjustX, adjustY, tintOpacity, lensOpacity, smoothMove, titleOpacity, tint_color) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		endif;
	}
	public function update ($array) {
		//var_dump($this);
		$array = array_intersect_key ($array, PortfolioOptions::get_default_option()); 
		$db = Loader::db();
			foreach ($array as $ok=>$ov) :
				$ov = (is_array($ov)) ? implode(',',$ov) : $ov;
				$set[] = $ok . '=' . "'$ov'";
			endforeach;
			$set = implode(', ', $set);
		
		$db->Execute("update ignore PortfolioOptions set  $set WHERE oID = ?",array(1));
	}
	
}