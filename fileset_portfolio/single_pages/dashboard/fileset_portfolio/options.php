<?php  defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Fileset Portfolio
 * @category Single Page
 * @author Sebastien Jacqmin <seb@tellthem.be>
 * @copyright  Copyright (c) 2010-2011 myconcterelab. (http://www.myconcterelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
?>
<form action="<?php echo $this->action('save_options')?>" method="post">
<div style="width: 800px;">
	<h1><span><?php echo t('Global settings')?></span></h1>
	<div class="ccm-dashboard-inner">
		  <table width="100%" border="0" cellpadding="15" class='separate'> 
			<tr> 
				<td style="width:30%"><strong>Gallery Type</strong></td> 
				<td style="width:35%"><small>You can view a series of image from a fileset or a single image. You must first create a fileset attribute type, with the handle '<strong>folio_group</strong>' or a file type attribute named '<strong>page_thumbnail</strong>' and place them to each page of your portfolio</small></td> 
				<td><?php echo $form->select('displayType', array('fileset'=>'Fileset', 'image'=>'Image alone'), $displayType)?></td> 
			</tr>
			<tr> 
				<td><strong>Thumbnails width</strong></td> 
				<td><small>Image wil be cropped for the thumbnail version, not the full-size image</small></td> 
				<td>
					<input type="text" id="thumbWidth" name="thumbWidth" class="soft-input"  readonly="readonly" /> px
					<div id="range-thumbWidth"></div></td> 					
				</td> 
			</tr> 
			<tr> 
				<td><strong>Thumbnails height</strong></td> 
				<td><small>Image wil be cropped for the thumbnail version, not the full-size image</small></td> 
				<td>
					<input type="text" id="thumbHeight" name="thumbHeight" class="soft-input"  readonly="readonly" /> px
					<div id="range-thumbHeight"></div></td> 					
				</td> 
			</tr> 
			<tr> 
				<td><strong>Number max of picture from fileset</strong></td> 
				<td></td> 
				<td>
					<input type="text" id="maxPicture" name="maxPicture" class="soft-input"  readonly="readonly" /> pics
					<div id="range-maxPicture"></div></td> 					
				</td> 
			</tr> 
			<tr> 
				<td><strong>Picture index to start from</strong></td> 
				<td></td> 
				<td>
					index <input type="text" id="indexPicture" name="indexPicture" class="soft-input"  readonly="readonly" />
					<div id="range-indexPicture"></div></td> 					
				</td> 
			</tr> 
			<tr> 
				<td><strong>Randomize Fileset</strong></td> 
				<td></td> 
				<td><?php echo $form->checkbox('options[]', 'randomize', in_array('randomize',$options)) ?></td> 
			</tr> 
			<tr> 
				<td><strong>Display description</strong></td> 
				<td></td> 
				<td><?php echo $form->checkbox('options[]', 'description', in_array('description',$options)) ?></td> 
			</tr> 
			<tr> 
				<td><strong>Display title</strong></td> 
				<td></td> 
				<td><?php echo $form->checkbox('options[]', 'title', in_array('title',$options)) ?></td> 
			</tr> 
			<tr> 
				<td><strong>Text for the button <br />under the description</strong></td> 
				<td><small>leave blank if you do not want the button</small></td> 
				<td><input type="text" name="buttonText" value="<?php echo $buttonText ?>" class="ccm-input-text" /></td> 
			</tr> 
<!--			<tr> 
				<td><strong>Color of the button under the description</strong></td> 
				<td></td> 
				<td><?php echo $form->select('button_color', array('Fileset', 'Image alone'), $displayType)?></td> 
			</tr>
-->
			<tr> 
				<td><strong>Text under the picture</strong></td> 
				<td><small>leave blank if you do not want text</small></td> 
				<td><input type="text" name="textUnderDesc" value="<?php echo $textUnderDesc ?>" class="ccm-input-text" /></td> 
			</tr> 
			<tr> 	
				<td><strong>Substitution picture</strong></td> 
				<td><small>Choose a picture that will be used in the case of error</small></td> 
				<td><?php echo $al->image('blankFileID', 'blankFileID', 'Select Substitution picture', $blankFileID) ?></td> 
			</tr> 
			<!--	Display other pages's attribute?-->
		  </table>
		
	</div>
</div>

<div style="width: 800px;">
	<h1><span><?php echo t('Cloud Zoom Options')?></span></h1>
	<div class="ccm-dashboard-inner">
	  <table width="100%" border="0" cellpadding="15" class='separate'> 
	  <tr> 
	    <td style="width:15%"><strong>Zoom Width</strong></td> 
	    <td style="width:35%"><small>The width of the zoom window in pixels. If 'auto' is specified, the width will be the same as the small image.</small></td> 
	    <td class="noWrap"  style="width:50%">
		<input type="text" id="zoomWidth" name="zoomWidth" class="soft-input"  readonly="readonly" /> px
		<div id="range-zoomWidth"></div></td> 
	  </tr> 
	  <tr> 
	    <td><strong>Zoom Height</strong></td> 
	    <td><small>The height of the zoom window in pixels. If 'auto' is specified, the height will be the same as the small image.</small></td> 
	    <td>
		<input type="text" id="zoomHeight" name="zoomHeight" class="soft-input"  readonly="readonly" /> px
		<div id="range-zoomHeight"></div></td> 		
	    </td> 
	  </tr>
	  <!-- NE fonctionne pas surement a cause de l'ajout du defilement // A ameliorer 
	  <tr> 
	    <td><strong>Position</strong></td> 
	    <td><small>Specifies the position of the zoom window relative to the small image.</small></td> 
	    <td><?php echo $form->select('position', array('left'=>'Left', 'right'=>'Right', 'top'=>'Top', 'bottom'=>'Bottom', 'inside'=>'Inside', 'body'=>'Body'), $position)?></td> 
	  </tr> 
	  
	  <tr> 
	    <td><strong>Adjust X</strong></td> 
	    <td><small>Allows you to fine tune the x-position of the zoom window in pixels.</small></td> 
	    <td>
		<input type="text" id="adjustX" name="adjustX" class="soft-input"  readonly="readonly" /> px
		<div id="range-adjustX"></div></td> 		
		
	    </td> 
	  </tr> 
	  <tr> 
	    <td><strong>Adjust Y</strong></td> 
	    <td><small>Allows you to fine tune the y-position of the zoom window in pixels.</small></td> 
	    <td>
		<input type="text" id="adjustY" name="adjustY" class="soft-input"  readonly="readonly" /> px
		<div id="range-adjustY"></div></td> 		
		
	    </td> 
	  </tr> 
	  -->
	  <tr> 
	    <td><strong>Tint</strong></td> 
	    <td><small>Specifies a tint colour which will cover the small image. <br /><strong>Does not work with softFocus.</strong></small></td> 
	    <td><table width="100%">
		<tr>
			<td style="width:50%"><?php echo $form->checkbox('options[]', 'tint', in_array('tint',$options)) ?> 
			</td>
			<td><?php echo $colorh->output('tint_color', 'Tint Color', $tint_color) ?></td>
		</tr>
	    </table>
	    
	    </td> 
	  </tr> 
	   <tr> 
	    <td><strong>Tint Opacity</strong></td> 
	    <td><small>Opacity of the tint, where 0 is fully transparent, and 1 is fully opaque.</small></td> 
	    <td class="noWrap">
		<input type="text" id="tintOpacity" name="tintOpacity" class="soft-input"  readonly="readonly" />
		<div id="range-tintOpacity"></div></td> 		
		
	    </td> 
	  </tr> 
	  <tr> 
	    <td><strong>Lens Opacity</strong></td> 
	    <td><small>Opacity of the lens mouse pointer, where 0 is fully transparent, and 1 is fully opaque. In tint and soft-focus modes, it will always be transparent.</small></td> 
	    <td>
		<input type="text" id="lensOpacity" name="lensOpacity" class="soft-input"  readonly="readonly" />
		<div id="range-lensOpacity"></div></td> 		
		
	    </td> 
	  </tr> 
	  <tr> 
	    <td><strong>Soft Focus</strong></td> 
	    <td>Applies a subtle blur effect to the small image. Does not work with tint.</td> 
	    <td><?php echo $form->checkbox('options[]', 'softFocus', in_array('softFocus',$options)) ?></td> 
	  </tr> 
	  <tr> 
	    <td><strong>Smooth Move</strong></td> 
	    <td><small>Amount of smoothness/drift of the zoom image as it moves. The higher the number, the smoother/more drifty the movement will be. 1 = no smoothing.</small></td> 
	    <td>
		<input type="text" id="smoothMove" name="smoothMove" class="soft-input"  readonly="readonly" />
		<div id="range-smoothMove"></div></td> 				
	    </td> 
	  </tr> 
	   <tr> 
	    <td><strong>Show Title</strong></td> 
	    <td><small>Shows the title tag of the image.</small></td> 
	    <td><?php echo $form->checkbox('options[]', 'showTitle', in_array('showTitle',$options)) ?></td> 
	  </tr> 
	   <tr> 
	    <td><strong>Title Opacity</strong></td> 
	    <td><small>Specifies the opacity of the title if displayed,  where 0 is fully transparent, and 1 is fully opaque.</small></td> 
	    <td>
		<input type="text" id="titleOpacity" name="titleOpacity" class="soft-input"  readonly="readonly" />
		<div id="range-titleOpacity"></div></td> 				
		
	    </td> 
	  </tr> 
	  
	</table> 
	</div>
</div>

<div style="width: 800px;">
	<h1><span><?php echo t('Light Box options')?></span></h1>
	<div class="ccm-dashboard-inner">
	<table width="100%" border="0" cellpadding="15" class='separate'> 		
	   <tr> 
	    <td><strong>Enable Light box</strong></td> 
	    <td><small></small></td> 
	    <td><?php echo $form->checkbox('options[]', 'lightbox', in_array('lightbox',$options)) ?></td> 
	  </tr>
	</table>
		
	<!--
	'transitionIn'	:	'elastic',
	'transitionOut'	:	'none',
	'speedIn'		:	600,
	'speedOut'		:	200,
	'overlayShow'	:	true,
	'overlayColor'	:	'#000',
	'cyclic'		:	true,
	'easingIn'		:	'easeInOutExpo'
	-->
	</div>
</div>
<div style="width: 800px;">
	<h1><span><?php echo t('Save Options')?></span></h1>
	<div class="ccm-dashboard-inner">
		<?php // print $ih->submit(t('Save'), 'folio_options'); ?>
		<input type="submit" class="ccm-button-v2  ccm-button-v2-right" id="ccm-submit-folio_options" />
		<div style="clear:both"></div>
	</div>
</div>
	
</form>
<?php 
	if ($this->controller->getTask() == 'edit') { ?>

	<?php 
	} else {
	?>

	<?php  } ?>
		
<script type="text/javascript">
$(document).ready(function() {
	$(':checkbox').iToggle();
	$( "#accordion" ).accordion({autoHeight:false,collapsible: true});
	setjQuerySlider('thumbWidth',0,400,'<?php    echo $thumbWidth ?>');
	setjQuerySlider('thumbHeight',0,400,'<?php    echo $thumbHeight == 'auto' ? $thumbWidth : $thumbHeight ?>');
	setjQuerySlider('zoomWidth',0,1000,'<?php    echo $zoomWidth ?>',1,0);
	setjQuerySlider('zoomHeight',0,1000,'<?php    echo $zoomHeight ?>',1,0);
	setjQuerySlider('adjustX',0,1000,'<?php    echo $adjustX ?>');
	setjQuerySlider('adjustY',0,1000,'<?php    echo $adjustY ?>');
	setjQuerySlider('tintOpacity',0,1,'<?php    echo $tintOpacity ?>',.1);
	setjQuerySlider('lensOpacity',0,1,'<?php    echo $lensOpacity ?>',.1);
	setjQuerySlider('smoothMove',0,20,'<?php    echo $smoothMove ?>',1);
	setjQuerySlider('titleOpacity',0,1,'<?php    echo $titleOpacity ?>',.1);
	setjQuerySlider('maxPicture',2,20,'<?php    echo $maxPicture ?>',1);
	setjQuerySlider('indexPicture',0,20,'<?php    echo $indexPicture ?>',1);
	
	
	
	});

</script>