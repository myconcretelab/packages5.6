<?php defined('C5_EXECUTE') or die(_("Access Denied."))?>
<link rel="stylesheet" href="<?php echo $block_url?>/auto.css" />
<div><!-- Tab container -->
  <ul class="ccm-dialog-tabs" id="ccm-multimedia-tabs">
    <li class="ccm-nav-active"><a href="javascript:void(0)" id="ccm-multimedia-type"><?php  echo t('multimedia')?></a></li>
    <li><a href="javascript:void(0)" id="ccm-multimedia-options"><?php      echo t('Advanced Options')?></a></li>
  </ul>
  
  <div id="ccm-multimedia-options-tab" style="display:none">
      <br>
      <H2><?php  echo t('General Options')?></H2>      
      <table cellpadding="10" width="100%" class="form">
	<tr>
	  <td>
	    <strong><?php  echo t('Thumbnails max size')?></strong>
	  </td>
	  <td>
	    <input name="thumb_size" id="thumb_size" class="invisible" type="text" size="5" />&nbsp;px<br>
	    <div id="range-thumb_size"></div>
	  </td>
	</tr>
	<tr>
	  <td>
	    <strong><?php  echo t('LightBox template')?></strong>	    
	  </td>
	  <td>
	    <select name="template_options">
	      <option value="light_rounded" <?php echo $template_options == 'light_rounded' ? 'selected':''?>>Light rounded</option>
	      <option value="dark_rounded" <?php echo $template_options == 'dark_rounded' ? 'selected':''?>>Dark rounded</option>
	      <option value="light_square" <?php echo $template_options == 'light_square' ? 'selected':''?>>Light square</option>
	      <option value="dark_square" <?php echo $template_options == 'dark_square' ? 'selected':''?>>Dark square</option>
	      <option value="facebook" <?php echo $template_options == 'facebook' ? 'selected':''?>>Facebook</option>
	    </select>  
	  </td>
	</tr>
	<tr>
	  <td><strong>Show Thumbnails Title</strong></td>
	  <td><input type="checkbox" id="show_title" name="options[]" value="show_title" <?php echo in_array('show_title',$options) ? 'checked="checked"' : '' ?> /></td>
	</tr>
	<tr>
	  <td><strong>Show Thumbnails Description</strong></td>
	  <td><input type="checkbox" id="show_desc" name="options[]" value="show_desc" <?php echo in_array('show_desc',$options) ? 'checked="checked"'  : '' ?> /></td>
	</tr>
	<tr>
	  <td><strong>Show Lightbox Title</strong></td>
	  <td><input type="checkbox" id="show_lightbox_title" name="options[]" value="show_lightbox_title" <?php echo in_array('show_lightbox_title',$options) ? 'checked="checked"'  : '' ?> /></td>
	</tr>
	<tr>
	  <td><strong>Allow Full size Resize</strong><br><small>Resize the photos bigger than viewport</small></br></td>
	  <td><input type="checkbox" id="allow_resize" name="options[]" value="allow_resize" <?php echo in_array('allow_resize',$options) ? 'checked="checked"'  : '' ?> /></td>
	</tr>
	<tr>
	  <td><strong>Overlay Gallery</strong><br><small>If set to 'on', a gallery will overlay the fullscreen image on mouse over</small></br></td>
	  <td><input type="checkbox" id="overlay_gallery" name="options[]" value="overlay_gallery" <?php echo in_array('overlay_gallery',$options) ? 'checked="checked"'  : '' ?> /></td>
	</tr>
	<tr>
	  <td><strong>Autoplay Slideshow</strong></td>
	  <td><input type="checkbox" id="autoplay_slideshow" name="options[]" value="autoplay_slideshow" <?php echo in_array('autoplay_slideshow',$options) ? 'checked="checked"'  : '' ?> /></td>
	</tr>
	<tr>
	  <td>
	    <strong>Slideshow</strong><br><small>Zero to disable slideshow feature</small></br>
	  </td>
	  <td>
	    <input name="slideshow" id="slideshow" class="invisible" type="text" size="5" />&nbsp;ms<br>
	    <div id="range-slideshow"></div>
	  </td>
	</tr>

      </table>
    <!-- Advanced options -->
  </div>
  
  
  <div id="ccm-multimedia-type-tab">
    <br />
    <h2><?php  echo t('Medias available')?></h2>
    <ul id="media-available" class="connectedSortable">
      <li class="ui-state-highlight" rel="Fileset"><a href="#" class="btn grey"><span>Fileset</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>image</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>flash</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>mp3</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>youtube</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>vimeo</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>Quicktime</span></a><div class="media-content"></div></li>  
      <li class="ui-state-highlight"><a href="#" class="btn grey"><span>webpage</span></a><div class="media-content"></div></li>  
    </ul>
    <div style="clear:both">&nbsp;</div>
    <h2><?php  echo t('Your Gallery (drop here)')?><a href="#" onclick="toggleAll()" style="float:right">Toggle All</a></h2>
    <ul id="media-gallery" class="connectedSortable">
    </ul>
  </div>

        
</div><!-- end tab container -->


<script type="text/javascript">
var FORM_TOOL_URL = '<?php echo $form_media_url?>';
var FILE_ATTRIBUTES_OPTIONS_URL = '<?php echo $get_file_attributes_options ?>';
var BLOCK_ID = '<?php echo $bID ? $bID : 0 ?>';
var BLOCK_URL = '<?php echo $block_url ?>';
var ccm_fpActiveTab = "ccm-multimedia-type";
var i= 0;

setjQuerySlider('thumb_size',10,300,<?php echo $thumb_size ? $thumb_size : 128 ?>);
setjQuerySlider('slideshow',0,10000,<?php echo $slideshow ? $slideshow : 0 ?>);

$(document).ready(function() {        
  $(':checkbox').iToggle();
<?php 
if (is_array($types)) :
  foreach ($types as $key=>$type) :
	$url = "&edit=true&place=$key";
	$typeName = ucfirst($type);
	$li = '<li class="ui-state-highlight" id="media-li-'.$key.'"><a href="#" class="btn grey"><span>' . $type . '</span></a><div class="media-content"></div></li>';
	echo "$('#media-gallery').append('$li');\n";
	echo "li_$key = $('#media-li-$key');";
	echo "addMedia(li_$key,'$type','$url');\n";
  endforeach;
endif;
?>
});

</script>