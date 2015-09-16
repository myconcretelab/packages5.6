<?php  
defined('C5_EXECUTE') or die("Access Denied.");

$blockURL =  Loader::helper('concrete/urls')->getBlockTypeAssetsURL(BlockType::getByHandle('icooon'));
// Follow doesn't work
// $this->addHeaderItem($blockURL . '/font-awesome.min.css');

?>
<link rel="stylesheet" href="<?php echo $blockURL . '/font-awesome.min.css' ?>">
<input type="hidden" name="iconName" value="<?php echo $iconName ?>" id="iconName" id="iconName">
<div style="height:8px"></div>
<ul id="ccm-icooon-tabs" class="ccm-dialog-tabs">
	<li class="ccm-nav-active"><a id="ccm-icooon-tab-add" href="javascript:void(0);"><?php echo ($bID>0)? t('Edit') : t('Add') ?></a></li>
	<li class=""><a id="ccm-icooon-tab-app"  href="javascript:void(0);"><?php echo t('Web icons')?></a></li>
	<li class=""><a id="ccm-icooon-tab-currency-text"  href="javascript:void(0);"><?php echo t('Currency & Text')?></a></li>
	<li class=""><a id="ccm-icooon-tab-directional"  href="javascript:void(0);"><?php echo t('Directional')?></a></li>
	<li class=""><a id="ccm-icooon-tab-brand"  href="javascript:void(0);"><?php echo t('Brand icons')?></a></li>
	<li class=""><a id="ccm-icooon-tab-other"  href="javascript:void(0);"><?php echo t('Other icons')?></a></li>
</ul>

<p><?php echo t('Fill text below and choose a icon from one of the three tab') ?></p>

<div id="ccm-icooonPane-add" class="ccm-icooonPane">
	<table style="width:100%">
		<tr>
			<td style="width:30%">
				<strong><?php echo t('Tilte') ?></strong>
			</td>
			<td>
				<textarea name="titleText" class="desactivated-ccm-advanced-editor" id="contentText"><?php echo html_entity_decode($titleText) ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Base text') ?></strong>
			</td>
			<td>
			<textarea name="contentText" class="desactivated-ccm-advanced-editor" id="contentText"><?php echo html_entity_decode($contentText) ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<strong for="iconSize"><?php echo t('Global Size') ?></strong>
			</td>
			<td>
				<select name="iconSize" id="iconSize">
					<option value="r" <?php echo $iconSize == 'r' ? 'selected' : '' ?>><?php echo t('Regular') ?></option>
					<option value="l" <?php echo $iconSize == 'l' ? 'selected' : '' ?>><?php echo t('Large') ?></option>
					<option value="xl" <?php echo $iconSize == 'xl' ? 'selected' : '' ?>><?php echo t('Extra Large') ?></option>
					<option value="xxl" <?php echo $iconSize == 'xxl' ? 'selected' : '' ?>><?php echo t('Extra extra Large') ?></option>
					<option value="h" <?php echo $iconSize == 'h' ? 'selected' : '' ?>><?php echo t('Huge') ?></option>
					<option value="xh" <?php echo $iconSize == 'xh' ? 'selected' : '' ?>><?php echo t('Extra Huge') ?></option>
				</select>
				
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Main color') ?></strong>
			</td>
			<td>
				<?php echo $fc->output('mainColor', t(''), $mainColor) ?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Second color') ?></strong>
			</td>
			<td>
				<?php echo $fc->output('secondColor', t(''), $secondColor) ?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Link text (optional)') ?></strong>
			</td>
			<td>
				<input type="text" name="textLink" value="<?php echo $textLink ?>">
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Link url (optional)') ?></strong>
			</td>
			<td>
				<input type="text" name="Linkurl" value="<?php echo $Linkurl ?>">
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo t('Page link (optional)') ?></strong>
			</td>
			<td>
				<?php echo $pageSelector->selectPage('pageLinkID', $pageLinkID)  ?>
			</td>
		</tr>
	</table>

</div>
<div id="ccm-icooonPane-app" class="ccm-icooonPane" style="display:none">
	<?php include 'icons-form/app.php' ?>
</div>
<div id="ccm-icooonPane-currency-text" class="ccm-icooonPane" style="display:none">
	<?php include 'icons-form/currency_text.php' ?>
</div>
<div id="ccm-icooonPane-directional" class="ccm-icooonPane" style="display:none">
	<?php include 'icons-form/directional.php' ?>
</div>
<div id="ccm-icooonPane-brand" class="ccm-icooonPane" style="display:none">
	<?php include 'icons-form/brand.php' ?>
</div>
<div id="ccm-icooonPane-other" class="ccm-icooonPane" style="display:none">
	<?php include 'icons-form/other.php' ?>
</div>


<script>
	var ICON_NAME = "<?php echo $iconName ?>";
	// Gerer les tabs
	$('ul#ccm-icooon-tabs li a').each( function(num,el){ 
		el.onclick=function(){
			var pane=this.id.replace('ccm-icooon-tab-','');
			showPane(pane);
		}
	});			

	// gerer les actif et l'input des icones au chargement
	if (ICON_NAME != '')
		$('.' + ICON_NAME).parent().addClass('active-icon');

	// Gérer les clicks sur les icones
	$('.the-icons a').on('click',function(e){
		e.preventDefault();
		$('.active-icon').removeClass('active-icon');
		name = $(this).find('i').attr('class');
		$('#iconName').val(name);
		$(this).addClass('active-icon');
	});
	
</script>
<style>
	.ccm-icooonPane strong {
		font-family: Arial;
		color: #999;
		font-weight: bold;
	}
	.ccm-icooonPane td {
		padding:8px;
	}
	.ccm-icooonPane a {
		display: block;
		padding:5px 0;
	}
	.span-3 {
		width: 23%;
		margin-left: 5%;
		padding: 0;
	}
	.the-icons {
		padding: 0 20px;
	}
	.the-icons a:hover {
		background: #ccc;
		cursor: pointer;
	}
	.active-icon {
		background: #444;
	}
	.active-icon, .active-icon * {
		color: #ccc;
	}
	.the-icons a.active-icon:hover {
		background: #000;	
		color: #fff
	}
	.the-icons {
		padding: 0;
	}
	.ccm-dialog-tabs li {
		padding: 0;
	}
</style>