<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class ThemeMyconcretelabPackage extends Package {
    protected $pkgHandle = 'theme_myconcretelab';
    protected $appVersionRequired = '5.6';
    protected $pkgVersion = '0.9.2';

    public function getPackageName() {
        return t('My Concrete Lab theme');
    }

    public function getPackageDescription() {
        return t('A really clean themle for MCL');
    }

    public function install($args) {
        $pkg = parent::install();
        $this->_upgrade($pkg);
    }

    public function upgrade() {
        $pkg = Package::getByHandle($this->pkgHandle);
        $this->_upgrade($pkg);
        parent::upgrade();
    }

    private function _upgrade(&$pkg) {
        Loader::library('myconcretelab_package_installer_utils', $this->pkgHandle);
        $utils = new MyconcretelabPackageInstallerUtils($pkg);

        $utils->getOrInstallTheme('myconcretelab');

        $ctHome = $utils->getOrInstallCollectionType('home', t('Home'));
        $ctHome = $utils->getOrInstallCollectionType('addon_detail', t('Addon Details'));
        $ctHome = $utils->getOrInstallCollectionType('theme_detail', t('Theme Details'));

        // $utils->getOrInstallBlockType('handy_block');

    }

}
