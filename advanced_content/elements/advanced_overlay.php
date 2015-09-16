<?php  
defined('C5_EXECUTE') or die("Access Denied.");


/*
	available_caps 
		tabs
			options level 1
				option capsID, desc, required, type
			options level 2
				option capsID, desc, required, type

*/
				// print_r($categories);
?> 
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
    <a class="brand" href="#">Caps</a>
      <!-- Everything you want hidden at 940px or less, place within here -->
      <div class="nav-collapse collapse">
        <ul class="nav">    	
<?php foreach ($categories as $k => $available_caps) { ?>
			<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ucwords(str_replace('_', ' ', str_replace('package', '', $k))) ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
		<?php
			foreach ($available_caps as $key => $value) {
				echo  "<li><a class='capscode' href='#' data-category='$k' data-caps='$key'>$key</a></li>";
			}
		?>
                </ul>
              </li>
<?php  } ?>
        </ul>
      </div>
 
    </div>
  </div>
</div>


 



<div id="form"></div>
<div class="dialog-buttons">
   <a href="javascript:jQuery.fn.dialog.closeTop();" class="ccm-button-left cancel btn"><?=t('Close')?></a>
   <a href="javascript:makecaps()" class="ccm-button-right primary btn"><?=t('Add Caps !')?></a>
</div>

<hr>


<script type="text/javascript">

var 	html = '',
		caps = <?php print Loader::helper('json')->encode($categories) ?>,
    	uniqueID = 0,
		bm; 
		//console.log(caps);

function createform (category, capsID) {

	var c = caps[category][capsID];
	console.log(c);
	$('#form').data('capsID',capsID).data('category', category);

	html = '<h4>Global options for ' + capsID + '</h4>';
	html += '<table class="table table-hover table-condensed table-bordered">';
	if (c.options_level_1) {
		for (var i = c.options_level_1.length - 1; i >= 0; i--) {
      uniqueID = Math.floor(Math.random()*9999);
			html += '<tr><td>';
			html += '<label class="capslabel" data-uniqueid="'+ uniqueID + '" data-capsid="' + c.options_level_1[i].capsID + '">' + c.options_level_1[i].title + '</label>';
      if (c.options_level_1[i].description != '')
        html += '<small>' + c.options_level_1[i].description + '</small>';

			html += '</td><td>';
			fillform (c.options_level_1[i], uniqueID);
			html += '</td></tr>';

		};			
		html += '</table>';
	}
	if (c.options_level_2) {
		html += '<hr /><h4>Add more ' + capsID ;
		html += "<a href='javascript:addinnercaps(\"" + category + "\",\""+ capsID + "\")' class='ccm-button-right primary btn' style='float:right: font-size:14px'> Add a " + capsID.substr(0, capsID.length -1) + "</a></h4>";
		html += "<div id='innerform'></div>";
	}

	$('#form').html(html);
}

function fillform (obj, uniqueID) {
	
	var select = '';
	switch (obj.type) {
		case 'boolean' :
			var booltrue = (obj.default) ? 'checked' : '';
			var boolfalse = (! obj.default) ? 'checked' : ''; 
			html += "<input type='radio' data-inputcheck='checked' value='true' data-default='" + obj.default  +  "' id='" + obj.capsID + "_"  + uniqueID + "' name='" + obj.capsID + "_"  + uniqueID + "' " + booltrue + " >Yes";
			html += '&nbsp;&nbsp;';
			html += "<input type='radio' data-inputcheck='checked' value='false' data-default='" + obj.default  +  "' id='" + obj.capsID + "_"  + uniqueID + "' name='" + obj.capsID + "_"  + uniqueID + "' " + boolfalse + " >No";
			break;
		case 'text' :
		case 'number' :
			html += "<input type='text' id='" + obj.capsID + "_"  + uniqueID + "' class='" + obj.capsID  +  "' value='" + obj.default + "' data-default='" + obj.default + "'>" ;
			break;
		case 'select' :
			html += "<select id='" + obj.capsID + "_"  + uniqueID + "' data-default='" + obj.default  +  "' >";
			for (var i = obj.options.length - 1; i >= 0; i--) {
				selected = obj.options[i] == obj.default ? 'selected' : '';
				html += "<option " + selected + ">" + obj.options[i] + "</option>";
			};
			html += "</select>";
			break;
		case 'image' :
		case 'page_attribute' :
		case 'page' :
		case 'user' :
		case 'color' :
		case 'mp3' :
		case 'fileset' :
		case 'quicktime' :

			getremoteinput (uniqueID, obj.capsID, obj.type);
      break;
	}

}

function getremoteinput (uniqueID, capsID, type) {
  var div = $('<div id="' + type + '_' + (uniqueID + 1000) + '" data-uniqueid="' + uniqueID + '" class="' + capsID  +  '"></div>'); // +1000 pour ne pas entrer en confli avec les inputs au niveau des noms
  fillmedia (div,type,uniqueID,capsID);
  html += $(div)[0].outerHTML;
}

function fillmedia (div, type, uniqueID, capsID) {
    $.get(GET_FORM + '?type=' + type + '&uniqueID=' + uniqueID + '&capsID=' + capsID, function(r) {
    	destination = $(div)[0].outerHTML;
	    id = $(destination).attr('id');
    	$('#' + id ).html(r);
     });

}

function addinnercaps (category, capsID) {
	var optionObjet = caps[category][capsID].options_level_2;
  uniqueID = Math.floor(Math.random()*9999);
	html = "<table class='table table-condensed  table-bordered innerform'>";//<strong>" + capsID.substr(0, capsID.length -1) + " options</strong>";

	for (var j = optionObjet.length - 1; j >= 0; j--) {
		html += '<tr><td style="width:50%">';
		html += '<label class="innercapslabel" data-uniqueid="' + uniqueID + '" data-capsid="' + optionObjet[j].capsID + '">' + optionObjet[j].title + '</label>';
		if (optionObjet[j].description != '')
			html += '<small>' + optionObjet[j].description + '</small>';
		html += '</td><td>';
		fillform (optionObjet[j], uniqueID);
		html += '</td></tr>';
	};
	html += '</table>';

	$('#innerform').append(html);
}

function makecaps () {
		
	var	capsID = $('#form').data('capsID'),
		category = $('#form').data('category'),
		insert = ' [' + capsID,
		tiny = tinyMCE.activeEditor,
		tinyContent = tiny.selection.getContent(),
		samplecontent = (tinyContent != '' ? tinyContent : caps[category][capsID].samplecontent);

		// premier niveau		  
		$('#form .capslabel').each(function (){
			insert += getinputvalue(this);
		});

		// second niveau		  
		if ($('#innerform').html()) {
			var innercapsID =  capsID.substr(0, capsID.length -1);
			// A travers chaque sous section
			$('#form .innerform').each(function (){
				insert +='][' + innercapsID;
				var t = $(this);
				// A travers chaque option de cette sous section
				$('.innercapslabel', t).each(function (){
					insert += getinputvalue(this);
				});
				insert +=']' + samplecontent + '[/' + innercapsID;
			});
			insert += '][/' + capsID + ']';
		
		} else {
			insert += ']' + samplecontent + '[/' + capsID + '] ';
		}
	
	// Insérer ce beau monde dans l'éditeur tinymce	
	//tiny.selection.moveToBookmark(bm);
	//tinyMCE.execCommand('mceInsertRawHTML', false, insert, true);
	 tinyMCE.execCommand("mceInsertRawHTML", !1, insert, !0);

	tiny.undoManager.add();

	jQuery.fn.dialog.closeTop();
}


function getinputvalue(label) {

		var optionID = $(label).data('capsid'),
	      uniqueID = $(label).data('uniqueid'),
	      id = optionID + '_' + uniqueID;
	      e = $('#' + id),
	      e_file =$('#' + id + '-fm-value'), // C5 ajoute -fm-value a l'id du hidden input des files !!
	      e_name = $('input[name="' + id + '"]');

	      if (!e.size()) { 
	      	if(e_file.size()) e = e_file;
	      	else	e = e_name;
	      }


	  if (e.data('inputcheck')) // traitement spécial pour les radio et checkbox
	    var val = $("input[name=" + id + "]:checked").val();
	  else          
	    var val = e.val();
	
	  val = (val == 'false' ? false : val);
	  val = (val == 'true' ? true : val);
	  d = e.data('default') == 'false' ? false : e.data('default');

		if (val != undefined && val != '' && val != d)
			return ' ' + optionID + '="' + val + '"';
		else
			return '';

}


function setBookMark () {
	tinyMCE.activeEditor.focus();
	bm = tinyMCE.activeEditor.selection.getBookmark();
}		


$('a.capscode').click(function(){
	createform($(this).data('category'), $(this).data('caps'));
	$('ul.nav > li.open').removeClass('open');
});

$('.capscodes').each(function () {
	$(this).change(function(i){
		 if ($(this).val() != '0') {
		 	var value = $(this).val().split('#');
			createform(value[0], value[1]);		 	
		 }
	});
});

$('.dropdown-toggle').dropdown()

</script>

<style type="text/css">
#form select {
	margin: 0;
}
#form label {
  font-weight: bold;
}

</style>
