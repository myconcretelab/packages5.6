<?php if ($type== 'fileset') : ?>
<div class="fileset ">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="fileset" />
    <table width="100%" cellpadding="5">
        <tr valign='top'>
           <td style="width:40%;">
              <!-- Choose a FileSet -->
                   <h2><?php  echo t('FileSet')?></h2>
                   <select name="media_<?php echo $random?>" title="fsID">
                           <?php   foreach($myFileSet as $fs) {
                           echo '<option value="'.$fs->getFileSetID().'" ' . ($medias[$place] == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
                             }?>
                   </select>
                   
           </td>
            <td  style="width:60%;">
               <!-- Choose a Title -->
                    <strong>Display as title</strong><br />
                    <select name="title_<?php echo $random?>" class='attributes' title="<?php  echo $titles[$place]?>"><option value="0">Loading...</option></select>
       
            </td>
        </tr>
        <tr>
            <td>
                <strong>Display Thumbnails type</strong><br /><small>First image of fileset will be selected to represent the fileset</small>
                <select name="media_options_<?php echo $random?>[]" id="media_options_<?php echo $random?>">
                    <option value="gallery" <? echo in_array('gallery',$media_options) ? 'selected' : ''?> >Gallery of thumbnails</option>
                    <option value="one" <? echo in_array('one',$media_options) ? 'selected' : ''?> >One thumbnail</option>                    
                </select>
            </td>
            <td>
            <strong>Display as description</strong><br />
            <select name="description_<?php echo $random?>" class='attributes' title="<?php  echo $descs[$place]?>"><option value="0">Loading...</option></select>
             </td>
        </tr>
     </table>
</div><!-- End fileset-empty -->


<?php  elseif ($type== 'image') : ?>
<div class="image">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="image" />
  <table width="100%" cellpadding="5">
     <tr valign='top'>
        <td  rowspan="2" style="width:40%;">
           <!-- Choose a File -->
            <h2><?php  echo t('Pick a Picture')?></h2>
            <div class="file-picker">
                <?php   $img['fType'] = FileType::T_IMAGE; ?>
                <?php  echo $al->file('media_'.$random, 'media_'.$random, t('Choose File'),$media,$img);?> 
            </div>
                          
        </td>
        <td  style="width:60%;">
        <strong>Display as title</strong><br />
        <select name="title_<?php echo $random?>" class='attributes' title="<?php  echo $titles[$place]?>"><option value="0">Loading...</option></select>
    </div>
   
        </td>
     </tr>
     <tr>
        <td>
            <strong>Display as description</strong><br />
            <select name="description_<?php echo $random?>" class='attributes' title="<?php  echo $descs[$place]?>"><option value="0">Loading...</option></select>
         </td>
     </tr>
 </table>

</div><!-- End image -->

<?php  elseif ($type== 'flash') : ?>


<div class="flash">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="flash" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
               <div class="file-picker">
                <?php  $wf['fExtension'] = "swf"; ?>
                <strong><?php  echo t('Pick a File')?></strong><br />
                <?php  echo $al->file('media_'.$random, 'media_'.$random, t('Choose File'),$media,$wf);?> 
            </div>         
        </td>
         <td>
            <strong>Display as title</strong><br />
            <select name="title_<?php echo $random?>" class='attributes' title="<?php  echo $titles[$place]?>"><option value="0">Loading...</option></select>
         </td>    </tr>
    <tr>
         <td>
            <strong>Display as description</strong><br />
            <select name="description_<?php echo $random?>" class='attributes' title="<?php  echo $descs[$place]?>"><option value="0">Loading...</option></select>
         </td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>

 </table>

</div><!-- End flash -->


<?php  elseif ($type== 'youtube') : ?>
<div class="youtube">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="youtube" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
            <strong><?php  echo t('Link to the YouTube video page, the same link you would share with friends ')?></strong><br />
            <input name="media_<?php echo $random?>" class="ccm-input-text" type="text" value="<?php  echo $medias[$place] ?>" size="30"  />
            <?php  if ($edit == 'true') : ?>
            <img src='http://img.youtube.com/vi/<?php echo $mb->get_youtube_id($medias[$place])?>/2.jpg' alt='' style="margin-top:10px;"  />
            <?php  endif ?>
        </td>
         <td>
            <strong><?php  echo t('Title')?></strong><br />
            <input name="title_<?php echo $random?>" class="ccm-input-text" type="text" value="<?php  echo $titles[$place] ?>" size="30" />
         </td>    </tr>
    <tr>
         <td>
            <strong><?php  echo t('Description')?></strong><br />
           <textarea name="description_<?php echo $random?>" class="ccm-input-textarea" style="width:200px; height:50px;"><?php  echo $descs[$place] ?></textarea>
         </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>

 </table>

</div><!-- End youtube -->

<?php  elseif ($type== 'vimeo') : ?>
<div class="vimeo">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="vimeo" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
            <strong><?php echo  t('Link to the vimeo video page')?></strong><br />
            <input name="media_<?php echo $random?>" class="ccm-input-text URL" type="text" value="<?php  echo $medias[$place] ?>" size="30" />      
            <?php  if ($edit == 'true') : ?>
            <img src='<?php echo $mb->get_vimeo_infos($medias[$place],'thumbnail_small')?>' alt='' style="margin-top:10px;" />
            <?php  endif ?>
        </td>
         <td>
            <strong><?php echo  t('The title (provided by vimeo)')?></strong><br />
            <p><?php echo $edit == 'true' ? $mb->get_vimeo_infos($medias[$place],'title') : ''?>
           <!--<input name="title_<?php echo $random?>" class="ccm-input-text" type="text" value="<?php  echo $titles[$place] ?>" size="30" />-->
         </td>    </tr>
    <tr>
         <td>
            <strong><?php echo  t('The description (provided by vimeo)')?></strong><br />
            <p><?php echo $edit == 'true' ? html_entity_decode($mb->get_vimeo_infos($medias[$place],'description')) : ''?>
           <!--<textarea name="description_<?php echo $random?>" class="ccm-input-textarea" style="width:200px; height:50px;"><?php  echo $descs[$place] ?></textarea>-->
         </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>

 </table>

</div><!-- End vimeo -->


<?php  elseif ($type== 'webpage' || $type == 'web-page') : ?>
<div class="Iframe">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="webpage" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
            <strong><?php  echo t('Link to the Web page')?></strong><br />
            <input name="media_<?php echo $random?>" class="ccm-input-text" type="text" value="<?php  echo $medias[$place] ?>" size="30"  />      
        </td>
         <td>
            <strong><?php  echo t('Title')?></strong><br />
            <input name="title_<?php echo $random?>" class="ccm-input-text" type="text" value="<?php  echo $titles[$place] ?>" size="30" />
         </td>    </tr>
    <tr>
         <td>
            <strong><?php  echo t('Description')?></strong><br />
           <textarea name="description_<?php echo $random?>" class="ccm-input-textarea" style="width:200px; height:50px;"><?php  echo $descs[$place] ?></textarea>
         </td>
    </tr>
    <tr>
        <td>
            <strong><?php  echo t('Width')?></strong>
            <input type="text" class="ccm-input-text"  name="width_<?php echo $random?>" value="<?php echo $widths[$place] ?>" size="4" />
            <strong><?php  echo t('Height')?></strong>
            <input type="text" class="ccm-input-text" name="height_<?php echo $random?>" value="<?php echo $heights[$place] ?>" size="4"  /> 
        </td>
    </tr>

 </table>

</div><!-- End Iframe -->

<?php  elseif ($type== 'mp3') : ?>
<div class="mp3">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="mp3" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
               <div class="file-picker">
                <strong><?php  echo t('Pick a File (.mp3 only)')?></strong><br />
                 <?php  $mp3['fExtension'] = "mp3"; ?>
                <?php  echo $al->file('media_'.$random, 'media_'.$random, t('Choose File'),$media,$mp3);?> 
            </div>         
        </td>
         <td>
            <strong>Display as title</strong><br />
            <select name="title_<?php echo $random?>" class='attributes' title="<?php  echo $titles[$place]?>"><option value="0">Loading...</option></select>
         </td>    </tr>
    <tr>
         <td>
            <strong>Display as description</strong><br />
            <select name="description_<?php echo $random?>" class='attributes' title="<?php  echo $descs[$place]?>"><option value="0">Loading...</option></select>
         </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>

 </table>

</div><!-- End Sounds -->

<?php  elseif ($type== 'quicktime') : ?>


<div class="quicktime">
    <input type="hidden" name="mID[]" value="<?php echo $random?>" />
    <input type="hidden" name="type_<?php echo $random?>" value="quicktime" />
  <table width="100%" cellpadding="5">
    <tr valign='top'>
        <td rowspan="3">
               <div class="file-picker">
                <strong><?php  echo t('Pick a File')?></strong><br />
                <?php  $mov['fExtension'] = "mov"; ?>
                <?php  echo $al->file('media_'.$random, 'media_'.$random, t('Choose File'), $media,$mov);?> 
            </div>         
        </td>
         <td>
            <strong>Display as title</strong><br />
            <select name="title_<?php echo $random?>" class='attributes' title="<?php  echo $titles[$place]?>"><option value="0">Loading...</option></select>
         </td>    </tr>
    <tr>
         <td>
            <strong>Display as description</strong><br />
            <select name="description_<?php echo $random?>" class='attributes' title="<?php  echo $descs[$place]?>"><option value="0">Loading...</option></select>
         </td>
    </tr>
    <tr>
        <td>
            <strong><?php  echo t('Width')?></strong>
            <input type="text" class="ccm-input-text"  name="width_<?php echo $random?>" value="<?php echo $widths[$place] ?>" size="4" />
            <strong><?php  echo t('Height')?></strong>
            <input type="text" class="ccm-input-text" name="height_<?php echo $random?>" value="<?php echo $heights[$place] ?>" size="4"  /> 
        </td>
    </tr>

 </table>

</div><!-- End Sounds -->

<?php  endif ?>