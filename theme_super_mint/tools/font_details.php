<?php defined('C5_EXECUTE') or die("Access Denied.");

if ($_POST['font'] === 0) exit;

$fontList = Cache::get('fontList', 'googlefontList');
		
if (!$fontList) {
	$fontList = Loader::helper('json')->decode (Loader::helper('file')->getContents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAsT5OzRSuWghytRLmwLagJ4BCl49qC1kM'));
	Cache::set('fontList', 'googlefontList', $fontList, 604800);
}

if (is_object($fontList)) {
	foreach ($fontList->items as $key => $fontObj) {
		
		if (str_replace("+", " ", $_POST['font']) == $fontObj->family) {
			$variants = $fontObj->variants;
			$subsets = $fontObj->subsets;
		}
	}
}
// on force le 'regular' et le 'latin'
$selected_variants[] = 'regular';
$selected_subsets[] = 'latin';
// Le nom des inputs
$subsetName = $_POST['subsetName'];
$variantName = $_POST['variantName'];

Loader::packageElement('font_details','theme_super_mint',array(
	// Le type d'input
	'inputType' => $_POST['inputType'],
	// LE nom de la police avec +
	'font' => $_POST['font'],
	// Les tableaux des options disponibles
	'variants' => $variants, 
	'subsets' => $subsets,
	// LE nom des inputs
	'subsetName' => $subsetName,
	'variantName' => $variantName, 
	// Les options selectionee
	'selected_variants' => $selected_variants,
	'selected_subsets' => $selected_subsets

));
