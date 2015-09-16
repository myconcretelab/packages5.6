<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));


$al = 		Loader::helper('concrete/asset_library');
$ah = 		Loader::helper('concrete/interface');
$pageSelector = Loader::helper('form/page_selector');
$colorh = 	Loader::helper('form/color');
$af = 		Loader::helper('form/attribute');
$url 	= 	Loader::helper('concrete/urls');
$tools_url  =	$url->getToolsURL('options','coin_slider');

Loader::model('file_set');
Loader::model('file_attributes');

$fileAttributes = FileAttributeKey::getList(); 
$s1 = FileSet::getMySets();
$options = explode(',',$options);

$fsa = array("" => "Select a file set");

if (!$fsID) {
        $spw          =      	$controller->spw_default;
        $sph          =      	$controller->sph_default;
        $effect          =      $controller->effect_default;
        $delay        =       	$controller->delay_default;
        $sDelay        =   	$controller->sDelay_default;
        $opacity   	=       $controller->opacity_default;
        $navigation   	=       $controller->navigation_default;
        $hoverPause  	=       $controller->hoverPause_default;
        $titleSpeed  	=       $controller->titleSpeed_default;

}

?>


<style type="text/css">
.ccm-nivo-link-table th {
	background:#333;
	color:white;
	padding:5px;
	text-align:center;
}
.ccm-nivo-link-table td {
	background:#eee;
	border:1px solid #ffffff;
}
.ccm-nivo-link-table td *{
	line-height:2em;
}
.ccm-nivo-link-table tr, .ccm-nivo-link-table td {
	padding:3px;
	vertical-align:middle;
}
.ccm-nivo-link-table td img {
	background:#fff;
	
	padding:5px;
	border:1px solid #999;
	margin:0 !important;
}
.ccm-nivo-link-table td.item-thumb {
	text-align:center;
}

label, .label {
	padding-top:.5em; margin-top:1em;
	margin-right:10px;
}

.clear {
	clear:both;
	height:.5em;
}
</style>



<div id="ccm-gallery-type-tab">

        <h2><span><?php    echo $fsID ? "Edit your Slider":"New Nivo Slide with default settings"?></span></h2>
	<div class="backgroundRow">


                <table width="100%" >
		<tr>
		<td style="width:50%; padding:10px;">
                        <label class="label"  for="fsID"><?php      echo t('File Set') ?>:</label>
                        <select name="fsID" title="fsID" id="fsID" onchange='refreshFsID(this.value)'>
				<?php      foreach($s1 as $fs) {
				echo '<option value="'.$fs->getFileSetID().'" ' . ($fsID == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
				  }?>
                        </select>
			<?php     if (is_array($s1) && count($s1) >= 1) : ?>

			<?php     else : ?>
				<h2 style="color:#ff0000">Create file set first<br><span style="font-size:9px">Go to your dashboard > file manager</span></h2>
			<?php     endif ?>
			
                </td>
                <td  style="width:50%; padding:10px;">
                        <label class="label"  for="fsTitle"><?php      echo t('Display as Image title') ?>:</label>
                        <select name="fsTitle">
                            <option value="blank"       <?php     echo ($fsTitle == "blank"?'selected':'')?>            >No Title</option>
                            <option value="title"       <?php     echo ($fsTitle == "title"?'selected':'')?>            >Title</option>
                            <option value="description" <?php     echo ($fsTitle == "description"?'selected':'')?>      >Description</option>
                            <option value="date"        <?php     echo ($fsTitle == "date"?'selected':'')?>             >Date Posted</option>
                            <option value="filename"    <?php     echo ($fsTitle == "filename"?'selected':'')?>         >File Name</option>
                            <?php     
                            foreach($fileAttributes as $ak) {  ?>
                                <option value="<?php     echo $ak->getAttributeKeyHandle() ?>"
                                                        <?php     echo ($fsTitle == $ak->getAttributeKeyHandle()?'selected':'')?> >         <?php     echo  $ak->getAttributeKeyName() ?>
                                </option>
                            <?php      } ?> 
                        </select>
                </td>
		</tr>
		</table>
		
		
		
		
		
		<!-- Basic options -->
		
		
		
	<br>
	<h2><span>Basics options</span></h2>
		
                <table width="100%" style="background:#eee;">
                <tr valign="top">
                        <td style="width:50%; padding:10px;">
				<table>
					<tr>
						<td>
							<label class="label"  for="spw"><?php      echo t('Squares per width');?></label>
						</td>
						<td>
							<input type="text" id="spw" name="spw" size="4" value="<?php echo $spw?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for="sph"><?php      echo t('Squares per height');?></label>
						</td>
						<td>
							<input type="text" id="sph" name="sph" size="4" value="<?php echo $sph?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for="delay"><?php      echo t('Delay between images in ms');?></label>
						</td>
						<td>
							<input type="text" id="delay" name="delay" size="4" value="<?php    echo $delay?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for="sDelay"><?php      echo t('Delay beetwen squares in ms');?></label>
						</td>
						<td>
							<input type="text" id="sDelay" name="sDelay" size="4" value="<?php    echo $sDelay?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for="opacity"><?php      echo t('Opacity of title and navigation');?></label>
						</td>
						<td>
							<input type="text" id="opacity" name="opacity" size="4" value="<?php    echo $opacity?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for="titleSpeed"><?php      echo t('Speed of title appereance in ms');?></label>
						</td>
						<td>
							<input type="text" id="titleSpeed" name="titleSpeed" size="4" value="<?php    echo $titleSpeed?>" />
						</td>
					</tr>
				</table>
				
				
			</td>
                        <td style="width:50%; padding:10px;">
				
				<table>
					<tr>
						<td>
							<label class="label"  for="link"><?php      echo t('Link your image to')?>:</label>
						</td>
						<td>
							<select name="link" class="ccm-file-set-description" id='link' onchange="toggleCustomPage(this.value);">
									<option value="0"       	<?php    echo $link == "link" ? 'selected' :''?>        >No link</option>
									<option value="image"       	<?php    echo $link == "image" ? 'selected':''?>        >Image</option>
									<option value="page"       	<?php    echo $link == "page" ? 'selected':''?>        >Page</option>
									<option value="multipages"       <?php    echo $link == "multipages" ? 'selected':''?>>Separate Page</option>
								
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="sorted-selectPage" <?php     if ($link != "page") { echo 'style="display:none"';}?>>
							<?php    
								echo $pageSelector->selectPage('linkPageID', $linkPageID);
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							 <label class="label"  for="effect"><?php      echo t('effect transition');?></label>
						</td>
						<td>
							<select name="effect" class="ccm-input-select ccm-file-set-id">
								<option value="random"		<?php     echo ($effect == "random"?'selected':'')?>     >random</option>
								<option value="swirl"		<?php     echo ($effect == "swirl"?'selected':'')?>      >swirl</option>
								<option value="rain"		<?php     echo ($effect == "rain"?'selected':'')?>      	>rain</option>
								<option value="straight"	<?php     echo ($effect == "straight"?'selected':'')?>   >straight</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for='navigation'>Navigation</label>
						</td>
						<td>
							<input type='checkbox' <?php echo in_array('navigation',$options) ? 'checked' : '' ?> name='options[]' value='navigation' />
						</td>
					</tr>
					<tr>
						<td>
							<label class="label"  for='navigation'>Pause on hover</label>
						</td>
						<td>
							<input type='checkbox' <?php echo in_array('hoverPause',$options) ? 'checked' : '' ?> name='options[]' value='hoverPause' />
						</td>
					</tr>
				</table>
			
                        </td>
                </tr>
		</table>
		<div id="ccm-file-infos-list">
			
		</div>

	</div>

        
</div>
<!-- end tab container -->
<!-- Tab Setup -->
<script type="text/javascript">

	function toggleCustomPage(value) {
		if (value == "page") {
			$("#sorted-selectPage").css('display','block');
		} else if (value == "multipages") {
			$("#sorted-selectPage").hide();
			fs = $('#fsID').val();
			$.get("<?php  echo $tools_url?>?bID=<?php   echo $this->controller->bID?>&fsID="+fs,
				function(data) {
					$('#ccm-file-infos-list').html(data);
				});
		
		} else {
			$("#sorted-selectPage").hide();
			$('#ccm-file-infos-list').html('');
		}
	}
	function refreshFsID(id) {
		if ($('#link').val() == 'multipages') {
			toggleCustomPage('multipages');
		}
	}
	
	function thumbControl(b){
		if (b.checked){
			$('#controlNavThumbs').removeAttr("disabled").prev().css('color','#000000');
		} else {
			$('#controlNavThumbs').attr("disabled", true).prev().css('color','#cccccc');			
		}
	}
	
	
	$(document).ready(function() { 
	<?php 
		if ($fsID && $link == 'multipages') : ?>
		refreshFsID(); 
	<?php  endif ?>
	});
</script>


