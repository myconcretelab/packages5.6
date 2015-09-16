<?php  

defined('C5_EXECUTE') or die(_("Access Denied."));

class PieChartPackage extends Package {

	protected $pkgHandle = 'pie_chart';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.0.1';
	
	public function getPackageDescription() {
		return t("Provide a sexy flat chart with options");
	}
	
	public function getPackageName() {
		return t("Flat Pie chart");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('pie_chart', $pkg);
 
	}

}