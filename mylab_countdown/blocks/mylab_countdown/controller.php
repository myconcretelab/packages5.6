<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabCountdownBlockController extends BlockController {
	
	
	protected $btTable = 'btMylabCountdown';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "550";

	public function __construct($obj = null) {		
		parent::__construct($obj);
	}
		
	public function on_page_view() {
		if (isset($this->type) && $this->type == 'flash') {
			$html = Loader::helper('html');
			$this->addHeaderItem($html->javascript('swfobject.js'));			
		}
		
	}
	
	public function getBlockTypeDescription() {
		return t("Provide a fresh countdown");
	}
	
	public function getBlockTypeName() {
		return t("Countdown");
	}
	public function getJavaScriptStrings() {
		return array(
		'element-required' => t('You must pick at least one element'),
		);
	}
	
	function getTargetDate($d) {
		$date = Loader::helper('date');
		
		$td = array();
		$td['dateFormat'] = "Y,m,d,H,i,s";
		
		$td['targetDate'] = strtotime($d);
		$td['actualDate'] = strtotime($date->getLocalDateTime());
		
		$td['isExpired'] =  $td['targetDate']  < $td['actualDate'] ? true : false;
		
		$td['secondsDiff'] = $td['targetDate']  - $td['actualDate'];
		
		$td['remainingDay']     = floor($td['secondsDiff']/60/60/24);
		$td['remainingHour']    = floor(($td['secondsDiff']-($td['remainingDay']*60*60*24))/60/60);
		$td['remainingMinutes'] = floor(($td['secondsDiff']-($td['remainingDay']*60*60*24)-($td['remainingHour'] *60*60))/60);
		$td['remainingSeconds'] = floor(($td['secondsDiff']-($td['remainingDay']*60*60*24)-($td['remainingHour'] *60*60))-($td['remainingMinutes']*60));
		
		$td['targetDateDisplay'] = date($td['dateFormat'],$td['targetDate']);
		$td['actualDateDisplay'] = date($td['dateFormat'],$td['actualDate'] );
		
		$td['base'] = $d;
		
		return $td;
		
	}
	
	function view() {
		$this->render("templates/{$this->type}");
	}
	
	function delete(){
	}
	

	function save ($data) {
		$dh = Loader::helper('form/date_time');
		$e = array('d','h','m','s','w','o','y');
		$data['theDate'] =  $dh->translate('theDate',$data);
		
		for ($i = 1 ; $i < 8 ; $i++) {
			$labels[] = $data['labels' . $i];
			$label[] = $data['label' . $i];
		}
		foreach($e as $ee) {
			if( key_exists('elements_'.$ee,$data)) {
				$elements[] = $ee;
			}
		}
		$data['labels'] = implode(',',$labels);
		$data['label'] = implode(',',$label);
		$data['elements'] = implode(',',$elements);
		
		parent::save($data);
	}


}

?>
