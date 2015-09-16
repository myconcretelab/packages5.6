<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductCreativeSliderPackage extends Package {
    protected $pkgHandle = 'product_creative_slider';
    protected $appVersionRequired = '5.6';
    protected $pkgVersion = '1.0';

    public function getPackageName() {
        return t('Product Creative Slider');
    }

    public function getPackageDescription() {
        return t('A responsive slider to show product in a creative way.');
    }

    public function install($args) {
        $this->precheck();
        $pkg = parent::install();
        $this->_upgrade($pkg);
    }

    public function upgrade() {
        $pkg = Package::getByHandle($this->pkgHandle);
        $this->_upgrade($pkg);
        parent::upgrade();
    }

    private function _upgrade(&$pkg) {
        Loader::library('product_creative_slider_installer', $this->pkgHandle);
        $utils = new ProductCreativeSliderInstaller($pkg);

        $utils->getOrInstallBlockType('product_creative_slider');
        $utils->getOrAddSinglePage('/dashboard/core_commerce/creative_slider',  t('Creative slider'), t('Manage Creative slider'), 'icon-film');
        $utils->getOrAddSinglePage('/dashboard/core_commerce/creative_slider/edit_slide',t('Edit Creative slider'), t('Manage Creative slides'));

    }
    function precheck(){
        $rp = Package::getByHandle('mylab_product_attribute');
        $cc = Package::getByHandle('core_commerce');
        $err ="";
        if( !$rp ) {
            $err .= t('You must install <a href="http://www.concrete5.org/marketplace/addons/related-product/" target="_blank">Related Product</a> add-on first');  
        }
        if( !$cc ) {
            $err .= $rp ? '' : '<br>' ;
            $err .= t('You must install <a href="http://www.concrete5.org/marketplace/addons/ecommerce/" target="_blank">eCommerce</a> add-on first');  
        } 
        if (!$rp || !$cc) {
            throw new Exception( $err);
            exit;            
        }
    } 

}