<?php    defined('C5_EXECUTE') or die(_("Access Denied."));
if ($cover_infos) extract($cover_infos);
?>
		<input type="hidden" name="panelID[]" value="<?php echo $panelID?>" />
		<input type="hidden" name="ciID[]" value="<?php echo $ciID?>" />
		<div id="logo-<?php echo $panelID?>" class="logo">
			<table cellpadding="10" border="0">
				<tr>
					<td>
						<?php
						$logo = File::getByID($logo);
						echo $al->image("logo_$panelID", "logo_$panelID", t('Choose File'),$logo);
						?>
						
					</td>
					<td id="infos-<?php echo $panelID?>" class="logo-infos"> 
						<h2>Please choose a file...</h2>
						<p>Please choose a file</p>					
					</td>
				</tr>
			</table>
		<hr />
		<?php    print $int->button_js('Add a MP3', "addMedia('mp3',$panelID)", $buttonAlign=’left’, $innerClass=null, $args = array()) ?>
		<?php    print $int->button_js('Add a Youtube', "addMedia('youtube',$panelID)", $buttonAlign=’right’, $innerClass=null, $args = array()) ?>
		<?php    print $int->button_js('Delete this Cover', "deleteCover($panelID)", $buttonAlign=’right’, $innerClass=null, $args = array()) ?>
		<div style='height:15px'>&nbsp;</div>
		</div>
		<div id="medias-<?php echo $panelID?>" class="medias-infos">
		
		</div>
<script type="text/javascript">
	// TOurner en boucle suivant le nombre de médias et apeller addMedia();
	
	<?php if(is_array($medias)) {
		foreach ($medias as $k=>$media) {
			echo 'context = $("<div></div>").appendTo("#medias-' . $panelID . '");';
			echo "addMedia('$mediaTypes[$k]', $panelID, '$media', context);";
		}
	}
	?>
</script>



