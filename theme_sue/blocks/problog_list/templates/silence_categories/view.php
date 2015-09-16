<?php   
	defined('C5_EXECUTE') or die(_("Access Denied."));
	if($title!=''){
		echo '<h2>'.t($title).'</h2>';
	}
	
	if (count($cArray) > 0) { ?>
	<div class="ccm-page-list">
	
	<?php   
	$ak = CollectionAttributeKey::getByHandle('blog_category');
	$akc = $ak->getController();

	$tagCounts = array();
	
	$ttags = $akc->getOptionUsageArray($pp);
	$tags = array();
	foreach($ttags as $t) {
		$tagCounts[] = $t->getSelectAttributeOptionUsageCount();
		$tags[] = $t;
	}
	shuffle($tags);
	
	for ($i = 0; $i < $ttags->count(); $i++) {
		$akct = $tags[$i];
		$qs = $akc->field('atSelectOptionID') . '[]=' . $akct->getSelectAttributeOptionID();
		echo '<a href="'.BASE_URL.$search.'?'.$qs.'">'.$akct->getSelectAttributeOptionValue().' ('.$akct->getSelectAttributeOptionUsageCount().')</a><br/>';
			
	}
	?></div><br/><?php   
}
	
		