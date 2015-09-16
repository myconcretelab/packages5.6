<?php  defined('C5_EXECUTE') or die("Access Denied.");

// Toutes les variable POST envoyée deviennent variable ds l'element
Loader::PackageElement('dashboard/additional_inputs', 'product_creative_slider', $_POST);
