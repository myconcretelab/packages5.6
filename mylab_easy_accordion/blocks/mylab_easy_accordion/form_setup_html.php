<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

($controller->cleanAreaHandle($_REQUEST['arHandle'])) or exit ('This block need to create Layout First');

global $c;
$cvID = $c->vObj->getVersionID();
$cID = $_REQUEST['cID'];
$ar = $_REQUEST['arHandle'];

$CollectionVersionAreaLayout = $controller->getCollectionVersionAreaLayout ($cID, $cvID, $ar);
$rows = $controller->getNumberRows($CollectionVersionAreaLayout['layoutID']);

$names = explode('||', $tName);
if (isset($disabled)) {
	$disabled = explode(',', $disabled);	
} else {
	$disabled = array(9999);
}
?>
<style>
.ccm-easyTab-item-table td {
	padding:10px;
	background:#eee;
}
.ccm-easyTab-item-table th {
	background:#999;
	color:#eee;
	text-align:center;
}
.ccm-position-list {
	width:80px;
	margin:2em;
	float:left;
}
.ccm-position-item {
	background:#eee;
	border:2px dotted #CCCCCC;
	margin:1px;
}
.ccm-position-item a {
	display:block;
	padding:10px;
	text-align:center;
	font-size:2em;
	color:#faa;
	font-weight:bold;
}
.ccm-position-item:hover, .active {
	background:#fbb;
	border:2px dotted #FF0000;
}
</style>
<div id="ccm-easyTabs-options">
	<?php   if ($rows > 1) : ?>
	<div id="ccm-easyTab-item-list">
		<table width="100%" class='ccm-easyTab-item-table'>
		  <tr>
		    <th  width="15%">Place</th>
		    <th  width="40%">Name</th>
		    <th  width="20%">Opened</th>
		    <th  width="25%">Click Disabled</th>
		      <!--<a onclick='showAdvanced($(this)'>Show options</a>--></th>
		  </tr>
		
		  <?php   for ($i = 0 ; $i < ($rows) ; $i++ ) : ?>
		
		  <tr>
		    <td class='item-id'><?php  echo $i+1?></td>
		    <td><input type="text" name="tName[]" class="ccm-easyTab-name" id='tName' value="<?php  echo $names[$i]?>" /></td>
		    <td><input type='radio' name='open'  value='<?php  echo $i?>' <?php  echo $open == $i ? 'checked' : ''?>></td>
		    <td><input type='checkbox' name='disabled[]'  value='<?php  echo $i?>' <?php  echo in_array($i,$disabled) ? 'checked' : ''?>></td>
		  </tr>
		  <?php   endfor ?>
		  <tr>
		    <td></td>
		    <td>No tabs open</td>
		    <td><input type='radio' name='open'  value='999' <?php  echo ($open == null || $open ==999) ?  'checked' : ''?>></td>
		    <td></td>
		  </tr>
		  <tr>
			<td colspan="2"><strong><?php  echo t('Additional classes <br> (separate by comma)')?></strong></td>
			<td colspan="2"><input type="text" name="classes" value="<?php  echo $classes ?>" /></td>
		  </tr>
		</table>
		<?php   else : ?>
		<h2 style='color:#ff0011'>Please add rows at your layout</h2>
		<?php   endif ?>

	</div>
</div>