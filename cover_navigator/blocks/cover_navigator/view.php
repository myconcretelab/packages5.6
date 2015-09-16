<?php    defined('C5_EXECUTE') or die(_("Access Denied."))?>
<?php 
$c = Page::getCurrentPage() ;
$view_type =  $view_type ? $view_type : 'gallery';

?>


<?php if ($c->isEditMode()) : ?>
<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php      echo t('Cover Navigator<br />Content disabled in edit mode.')?>
	</div>
</div>
<?php else : ?>


<?php  if ($view_type == 'inline' )  : ?>
<a href="#" rel="fancybox__" onclick="open_gallery(ajax_cf)">Open the gallery</a>
<?php endif ?>


<?php  if ($view_type == 'gallery' || $view_type == 'inline' )  : ?>
	
	<div id="cover-navigator_<?php echo $bID ?>" class='ContentFlow'>
		<div class="loadIndicator"><div class="indicator"></div></div>
		<div class="flow"></div>
	
		<!--<div class="globalCaption"></div>-->
		<!--<div class="scrollbar"><div class="slider"><div class="position"></div></div></div>	-->
	</div>
	<div id="itemcontainer" style="height: 0px; width: 0px; visibility: hidden"></div>
	<div class="result"></div>

	<script type="text/javascript">
		var ajax_cf = new ContentFlow('cover-navigator_<?php echo $bID ?>',{maxItemHeight:100, onMakeActive : function (item) {
			clearTimeout(intent); // On supprime les instances précédentes.
			intent = setTimeout(apply, 800); // setTimeout ne peut pas prendre d'arguments pour la fonction appelée, donc on appele une fonction ss arg.
			function apply () {
				loadRessources(item);
			}
		}
			});
	</script>
<?php endif ?>

<?php  if ($view_type == 'gallery' ) : ?>
	<script type="text/javascript">
	$(document).ready(function () {
		open_gallery(ajax_cf);
	});	
	</script>
<?php endif ?>




<?php if ($view_type == 'fancy') : ?>


<a href="<?php echo $gallery_url ?>?bID=<?php echo $bID?>" class="fancybox">Open the fancy</a>

<script type="text/javascript">
var ajax_flow ;
$(document).ready(function () {
	$('a.fancybox').fancybox({onComplete:function() {
		ajax_flow = new ContentFlow('ajax_cover-navigator_<?php echo $bID ?>',{maxItemHeight:100,
			onMakeActive : function (item) {
				clearTimeout(intent); // On supprime les instances précédentes.
				intent = setTimeout(apply, 800); // setTimeout ne peut pas prendre d'arguments pour la fonction appelée, donc on appele une fonction ss arg.
				function apply () {
					loadRessources(item);
					}
				}
			});
		open_gallery(ajax_flow);
		}
		
	});
});
</script>


<?php endif ?>


<script type="text/javascript">
var intent;
var RESULT = $('.result');
var MP3_PLAYER_URL = "<?php echo $mp3_player_url ?>";
var LOAD_PLAYER_URL = '<?php echo str_replace("&amp;","&",$this->action('load_players')) ?>';
var BLOCK_URL = "<?php echo $block_url ?>";
var GALLERY_URL = "<?php echo $gallery_url ?>";
var BLOCK_ID = '<?php echo $bID ?>';
var RETRIEVE_CLIENT_URL = "<?php echo str_replace("&amp;","&",$this->action('retrieve_clients')) ?>";
var CLIENT_ARRAY = new Array();
</script>


<?php endif ?>

