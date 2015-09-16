<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));

$dh = Loader::helper('form/date_time');
$fh = Loader::helper('form');

if (isset($elements)) {
  $elms = explode(',',$elements);
} else {
  $elms = array('d','h','m','s');
}
?>

<style>
	#sortable1, #sortable2 { list-style-type: none; margin: 10px 0; padding: 0; display:block;height:50px }
	#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.5em; float:left; height:1.5em; cursor:move; }

	#sortable-elements li:first-letter{
	  float:right;
	  font-size:1px;
	}


</style>

<br />
<strong><?php echo t('Pick a date')?></strong><br>
<?php echo $dh->datetime('theDate',$theDate) ?>


<br /><br />


<label for="type"><?php echo t('Choose a display type')?></label>
<select name="type" onchange="changeType($(this))">
  <option value="jquery">Jquery countDown</option>
  <option value="flash">Flash countDown</option>
</select>

<br /><br />

<!-- Labels -->
<div id="jQuery-countDown-options">
  <!--<h2><?php echo t('Jquery countdown options')?></h2>-->
  <br>
  <strong><?php echo t('The expanded texts for the counters')?></strong><br>
  <table width="100%" border="0" cellpadding="2">
    <tr>
      <td>Years</td>
      <td>Months</td>
      <td>Weeks</td>
      <td>Days</td>
      <td>Hours</td>
      <td>Minutes</td>
      <td>Seconds</td>
    </tr>
    <tr>
      <td><input type="text" name="labels1" value="Years" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels2" value="Months" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels3" value="Weeks" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels4" value="Days" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels5" value="Hours" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels6" value="Minutes" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="labels7" value="Seconds" class="ccm-input-text" size="6" /></td>
    </tr>
  </table>
  
    <strong><?php echo t('The display texts for the counters if only one')?></strong><br>
  <table width="100%" border="0" cellpadding="2">
    <tr>
      <td>Year</td>
      <td>Month</td>
      <td>Week</td>
      <td>Day</td>
      <td>Hour</td>
      <td>Minute</td>
      <td>Second</td>
    </tr>
    <tr>
      <td><input type="text" name="label1" value="Year" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label2" value="Month" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label3" value="Week" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label4" value="Day" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label5" value="Hour" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label6" value="Minute" class="ccm-input-text" size="6" /></td>
      <td><input type="text" name="label7" value="Second" class="ccm-input-text" size="6" /></td>
    </tr>
  </table>
  <br>
  <div id="sortable-elements" style="background:#ffffff; padding:10px; border:1px solid #cccccc;">
    <strong><?php echo t('elements Displayed (drag&drop here)')?></strong><br>
    <ul id="sortable1" class="connectedSortable">
      <?=in_array('d',$elms) ? '<li class="ui-state-highlight" rel="d">1Day</li>' : ""?>
      <?=in_array('y',$elms) ? '<li class="ui-state-highlight" rel="y">2Year</li>' : ""?>
      <?=in_array('o',$elms) ? '<li class="ui-state-highlight" rel="o">3Month</li>' : ""?>
      <?=in_array('w',$elms) ? '<li class="ui-state-highlight" rel="w">4Week</li>' : ""?>
      <?=in_array('h',$elms) ? '<li class="ui-state-highlight" rel="h">5Hour</li>' : ""?>
      <?=in_array('m',$elms) ? '<li class="ui-state-highlight" rel="m">6Minute</li>' : ""?>
      <?=in_array('s',$elms) ? '<li class="ui-state-highlight" rel="s">7Seconds</li>' : ""?>
    </ul>
    <div style="clear:both">&nbsp;</div>
      <strong><?php echo t('Elements available')?></strong><br>
    <ul id="sortable2" class="connectedSortable">
      <?=!in_array('d',$elms) ? '<li class="ui-state-default" rel="d">1Day</li>' : ""?>
      <?=!in_array('y',$elms) ? '<li class="ui-state-default" rel="y">2Year</li>' : ""?>
      <?=!in_array('o',$elms) ? '<li class="ui-state-default" rel="o">3Month</li>' : ""?>
      <?=!in_array('w',$elms) ? '<li class="ui-state-default" rel="w">4Week</li>' : ""?>
      <?=!in_array('h',$elms) ? '<li class="ui-state-default" rel="h">5Hour</li>' : ""?>
      <?=!in_array('m',$elms) ? '<li class="ui-state-default" rel="m">6Minute</li>' : ""?>
      <?=!in_array('s',$elms) ? '<li class="ui-state-default" rel="s">7Seconds</li>' : ""?>
    </ul>
  </div>
</div><!-- jQuery-countDown-options -->
  
<div id="flash-countDown-options" style="display:none">
  <h2><?php echo t('Flash countdown options')?></h2>
   <strong><?php echo t('There are no option for this countdown')?></strong>   
</div>



<!-- Tab Setup -->
<script type="text/javascript">
	var ccm_fpActiveTab = "ccm-countdown-type";	

	$("#ccm-countdown-tabs a").click(function() {
		$("li.ccm-nav-active").removeClass('ccm-nav-active');
		$("#" + ccm_fpActiveTab + "-tab").hide();
		ccm_fpActiveTab = $(this).attr('id');
		$(this).parent().addClass("ccm-nav-active");
		$("#" + ccm_fpActiveTab + "-tab").show();


	});
	// Switch between types
	function changeType (t){
	  if(t.val() == 'flash') {
	    $('#flash-countDown-options').show();
	    $('#jQuery-countDown-options').hide();
	  } else {
	    $('#flash-countDown-options').hide();
	    $('#jQuery-countDown-options').show();
	  }
	}
	
/* Delete Text content */	
	$('.ccm-input-text').click(function(){
	  $(this).val('')
	})

/* Sortable ELements */	
	$(function() {
	  $("#sortable1, #sortable2").sortable({
		  connectWith: '.connectedSortable',
		  sortchange:sortItem
	  }).disableSelection();
	 
	 $( "#sortable1" ).bind( "sortreceive", function(event, ui) {
	    $(this).find('li').each(function(){
		$(this).addClass('ui-state-highlight').removeClass('ui-state-default');
	      });

	 }); 
	 
	 $( "#sortable2" ).bind( "sortreceive", function(event, ui) {
	    $(this).find('li').each(function(){
		$(this).addClass('ui-state-default').removeClass('ui-state-highlight');
	      });
	 });
	 
	$( "#sortable1, #sortable2" ).bind( "sortupdate", function(event, ui) {
	    sortItem(this);
	 }); 
	
	});
	
	function sortItem(UL){
	    // Sort
	    console.log('coucou');
	    var mylist = $(UL);
	    var listitems = mylist.children('li').get();
	    listitems.sort(function(a, b) {
	       var compA = $(a).text().toUpperCase();
	       var compB = $(b).text().toUpperCase();
	       return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
	    })
	    $.each(listitems, function(idx, itm) { mylist.append(itm); });
	    //end SOrt	  
	}

</script>