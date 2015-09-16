<?php  defined('C5_EXECUTE') or die("Access Denied.");


class DashboardFilesetPortfolioOptionsController extends Controller { 	

	protected $helpers = array('html');

	public function view() {
		$this->view_set();
	}
	
	protected function view_set () {
		$html = Loader::helper('html');
		Loader::model('files');
		Loader::model('portfolio_options','fileset_portfolio');
		$folio_options = PortfolioOptions::load();
		foreach ($folio_options as $foK=>$foV) :
			if ($foK == 'options') :
				$foV = explode(',',$foV);
			endif;
			if ($foK == 'blankFileID' && $foV) :
				$foV = File::getByID($foV);
			endif;
			$this->set($foK,$foV);
		endforeach;
		$this->set('form',Loader::helper('form'));
		$this->set('ih', Loader::helper('concrete/interface'));
		$this->set('colorh', Loader::helper('form/color'));
		$this->set('al', Loader::helper('concrete/asset_library'));
		$this->addHeaderItem($html->javascript(BASE_URL . DIR_REL . '/packages/fileset_portfolio//js/jquery-ui-1.8.16.custom.min.js' )); // A bit uggly..
		$this->addHeaderItem($html->javascript(BASE_URL . DIR_REL . '/packages/fileset_portfolio//js/options.js' )); // A bit uggly..
		$this->addHeaderItem($html->css(BASE_URL . DIR_REL . '/packages/fileset_portfolio//css/options.css' )); // A bit uggly..		
	}

	public function on_start() {
		
	}
		
	function save_options () {
		Loader::model('portfolio_options','fileset_portfolio');
		PortfolioOptions::update($_POST);
		$this->view_set();
		//exit();
	}
	
	

}