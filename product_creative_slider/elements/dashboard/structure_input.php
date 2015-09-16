<?php  defined('C5_EXECUTE') or die("Access Denied.");

$files = Loader::helper('pcs_file','product_creative_slider');
$path = "/product_creative_slider/images/structure/$n/" ;
$elem = $files->file_dir(DIR_PACKAGES . $path);

if (is_array($elem)) :
	// Si on ne spécidfie pas de structure active, on prend la premiere
	if (!$checked) :
		$handles =  array_keys($elem); 
		$checked = $handles[0];
	endif;

	foreach ($elem as $handle => $name) :
		$s = $checked == $handle ? 'checked' : ''; 
	  	echo '<label for="' . $handle . '" class="structure">';
	    echo 	'<input id="' . $handle . '" name="structure" type="radio" value="' . $n . ',' . $handle . '" ' . $s . '>';
	    echo 	'<img src="' . REL_DIR_PACKAGES . $path . $handle . '.png" />';
	    echo '<small>' . $name . '</small>';
    	echo '</label>';
	endforeach;
endif;




