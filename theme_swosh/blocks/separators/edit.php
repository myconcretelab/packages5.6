<?php  defined('C5_EXECUTE') or die("Access Denied.");
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Title</h2>
		<input type="text" value="<?php echo $title ?>" name="title">
	<h2>Type</h2>
	<?php 
	$options = array(
		'0' => t('--Choose One--'),
		'double' => t('Double'),
		'box' => t('Tiny box'),
		'blankSeparator' => t('Space')
	);
	echo $form->select('type', $options, $type);

	?>
</div>