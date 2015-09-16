<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductCategoryListPackage extends Package {
    protected $pkgHandle = 'product_category_list';
    protected $appVersionRequired = '5.6';
    protected $pkgVersion = '0.9.0.1';

    public function getPackageName() {
        return t('eCommerce Product Category');
    }

    public function getPackageDescription() {
        return t('A great way to navigate through eCommerce product categories');
    }

    public function install() {
        $this->precheck();

        $pkg = parent::install();
        BlockType::installBlockTypeFromPackage('ecommerce_category_list', $pkg);
    }

    function precheck(){
        $cc = Package::getByHandle('core_commerce');
        if( !$cc ) {
            $err = t('You must install <a href="http://www.concrete5.org/marketplace/addons/ecommerce/" target="_blank">eCommerce</a> add-on first');  
            throw new Exception( $err);
            exit;            
        } 
    } 
}