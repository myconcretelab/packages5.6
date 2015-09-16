<?php  defined('C5_EXECUTE') or die(_("Access Denied."))?>
<link rel="stylesheet" href="<?php  echo $controller->get_block_url()?>/auto.css" />

<div id="accordion">

    <h3><a href="#">Fileset settings</a></h3>
            <div>               
                <table width="100%" >
                <tr>
                <td style="width:50%; padding:10px;">
                        <label class="label"  for="fsID"><?php       echo t('File Set') ?>:</label>
                        <select name="fsID" title="fsID" id="fsID" onchange='refreshFsID(this.value)'>
                                <?php       foreach($s1 as $fs) {
                                echo '<option value="'.$fs->getFileSetID().'" ' . ($fsID == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
                                  }?>
                        </select>
                        <?php      if (is_array($s1) && count($s1) >= 1) : ?>

                        <?php      else : ?>
                                <h2 style="color:#ff0000">Create file set first<br><span style="font-size:9px">Go to your dashboard > file manager</span></h2>
                        <?php      endif ?>
                        
                </td>
                <td  style="width:50%; padding:10px;">
                        <label class="label"  for="fsTitle"><?php       echo t('Display as Image title') ?>:</label>
                        <select name="fsTitle">
                            <option value="blank"       <?php      echo ($fsTitle == "blank"?'selected':'')?>            >No Title</option>
                            <option value="title"       <?php      echo ($fsTitle == "title"?'selected':'')?>            >Title</option>
                            <option value="description" <?php      echo ($fsTitle == "description"?'selected':'')?>      >Description</option>
                            <option value="date"        <?php      echo ($fsTitle == "date"?'selected':'')?>             >Date Posted</option>
                            <option value="filename"    <?php      echo ($fsTitle == "filename"?'selected':'')?>         >File Name</option>
                            <?php      
                           foreach($fileAttributes as $ak) {  ?>
                                <option value="<?php      echo $ak->getAttributeKeyHandle() ?>"
                                                        <?php      echo ($fsTitle == $ak->getAttributeKeyHandle()?'selected':'')?> >         <?php      echo  $ak->getAttributeKeyName() ?>
                                </option>
                            <?php       } ?> 
                        </select>
                </td>
                </tr>
                </table>
            </div>      
  
           <h3><a href="#">Basic options</a></h3>
            <div>
                
                <table width="100%" class='separate' cellpadding="10">
		<!-- Les themes fournis ne sont pas assez bien dŽveloppŽ que pour supporter les amplitudes de changement, les bullets ne supportent qu'un petit nombre de photos, les paddind sont diffŽrents pour chaque theme...
                <tr>
                        <td>
                                <label class="label"  for="effect"><?php  echo t('Theme');?></label>
                        </td>
                        <td>
                                <?php  echo $form->select('theme',$controller->addKeyToArray($controller->themes),$theme)?>
                              
                       </td>
               </tr>
	       -->
		<tr>
			<td style="width:50%;">
				<label class="label"  for="animSpeed"><?php       echo t('Animation Speed <small>(milliseconds)</small>');?></label>
			</td>   

			<td>
				  <input type="text" id="animSpeed" name="animSpeed" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php       echo t('ms')?>                                                                      
				   <div id="range-animSpeed"></div>
			</td>
		</tr>
		<tr><td>
				<label class="label"  for="pauseTime"><?php       echo t('Pause Time <small>(milliseconds)</small>');?></label>
			</td>
			<td>
				  <input type="text" id="pauseTime" name="pauseTime" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php       echo t('ms')?>                                                                      
				   <div id="range-pauseTime"></div>
			</td>   </tr>                   
		<tr>
			<td>
				<label class="label"  for="slices"><?php       echo t('Number of slices');?></label>
			</td>
			<td>
				  <input type="text" id="slices" name="slices" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php       echo t('slices')?>                                                                        
				   <div id="range-slices"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"  for="boxCols"><?php       echo t('box Cols');?></label>
			</td>
			<td>
				  <input type="text" id="boxCols" name="boxCols" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" />  <?php       echo t('Cols')?>                                                               
				   <div id="range-boxCols"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"  for="boxRows"><?php       echo t('box Rows');?></label>
			</td>
			<td>
				  <input type="text" id="boxRows" name="boxRows" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php       echo t('Rows')?>                                                                
				   <div id="range-boxRows"></div>
			</td>
		</tr>
		
		<tr>
			<td>
				<label class="label"  for="startSlide"><?php       echo t('Start Slide <small>(image index)</small>');?></label>
			</td>
			<td>
				  <?php       echo t('index')?><input type="text" id="startSlide" name="startSlide" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" />                                                                  
				   <div id="range-startSlide"></div>
			</td>
		</tr>
	<tr>
		<td>
			<label class="label"  for="effect"><?php       echo t('effect transition');?></label>
		</td>
		<td>
			<?php  echo $form->select('effect',$controller->addKeyToArray($controller->effects),$effect)?>
		       
		</td>
	</tr>
	<tr>
		<td style="width:50%; padding:10px;">
		
			<label class="label"  for="link"><?php       echo t('Link your image to')?>:</label>
		</td>
		<td>
			<select name="link" class="ccm-file-set-description" id='link' onchange="toggleCustomPage(this.value);">
					<option value="0"               <?php     echo $link == "link" ? 'selected' :''?>        >No link</option>
					<option value="image"           <?php     echo $link == "image" ? 'selected':''?>        >Image</option>
					<option value="page"            <?php     echo $link == "page" ? 'selected':''?>        >Page</option>
					<option value="multipages"       <?php     echo $link == "multipages" ? 'selected':''?>>Separate Page</option>
				
			</select>
			<div class='clear'></div>
			<div id="sorted-selectPage" <?php      if ($link != "page") { echo 'style="display:none"';}?>>
			<?php     
				echo $pageSelector->selectPage('linkPageID', $linkPageID);
			?>
			</div>


		</td>
		</tr>

                </table>
                <div id="ccm-file-infos-list">
                        
                </div>

        </div>
  
        <h3><a href="#">Advanced options</a></h3>
        <div>
        <table cellpadding="10" width="100%" class='separate' >
                <tr valign="top">
                        <td style="width:50%; padding:10px;">
				<label class="label"  for='pauseOnHover'>Pause on Hover</label>
					
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('pauseOnHover',$options) ? 'checked' : '' ?> name='options[]' value='pauseOnHover' id='pauseOnHover' />                                                        
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='directionNav'>Show nav (prev&next)</label>                                                   
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('directionNav',$options) ? 'checked' : '' ?> name='options[]' value='directionNav' id='directionNav' />                                                        
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='directionNavHide'>Only show nav on hover</label>                                                     
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('directionNavHide',$options) ? 'checked' : '' ?> name='options[]' value='directionNavHide' id='directionNavHide' />                                                        
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='controlNav'>Control Nav</label>                                                      
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('controlNav',$options) ? 'checked' : '' ?> name='options[]' value='controlNav' id='controlNav' onclick='thumbControl(this)' />                                                       
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='controlNavThumbs' <?php  echo in_array('controlNav',$options)? '' : 'style="color:#cccccc"' ?>>Use thumbnails for Control Nav</label>
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('controlNav',$options)? '' : 'disabled' ?><?php  echo in_array('controlNavThumbs',$options)? 'checked' : '' ?> name='options[]' value='controlNavThumbs' id='controlNavThumbs' />                                                     
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='keyboardNav'>Use left & right keyboard arrows</label>                                                        
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('keyboardNav',$options) ? 'checked' : '' ?> name='options[]' value='keyboardNav' id='keyboardNav' />                                                  
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='randomize'>Randomize Pictures ?</label>                                                      
				</td>
				<td>
					<input type='checkbox' <?php  echo in_array('randomize',$options) ? 'checked' : '' ?> name='options[]' value='randomize' id='randomize' />                                                      
				</td>
			</tr>
        </table>
        </div>

 
        
</div>

<script type="text/javascript">

  TOOLS_URL = "<?php   echo $tools_url?>";
  BLOCK_ID = '<?php    echo $this->controller->bID?>';

  $(document).ready(function() { 
  <?php  
	  if ($fsID && $link == 'multipages') : ?>
	  refreshFsID(); 
  <?php   endif ?>
	  $(':checkbox').iToggle();
	  $( "#accordion" ).accordion({autoHeight:false,collapsible: true});

	  setjQuerySlider('animSpeed',100,5000,'<?php     echo $animSpeed ?>');
	  setjQuerySlider('pauseTime',100,5000,'<?php     echo $pauseTime ?>');
	  setjQuerySlider('slices',1,30,'<?php     echo $slices ?>');
	  setjQuerySlider('startSlide',0,20,'<?php     echo $startSlide ?>');
	  setjQuerySlider('boxCols',1,20,'<?php     echo $boxCols ?>');
	  setjQuerySlider('boxRows',1,20,'<?php     echo $boxRows ?>');
  });
</script>
