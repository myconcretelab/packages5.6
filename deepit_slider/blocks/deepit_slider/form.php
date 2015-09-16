<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));


$ah = 		Loader::helper('concrete/interface');
$pageSelector = Loader::helper('form/page_selector');
$af = 		Loader::helper('form/attribute');
$url 	= 	Loader::helper('concrete/urls');
$link_form_tool  =	$url->getToolsURL('image_link','deepit_slider');
$layers_form_tool  =	$url->getToolsURL('sublayers_form','deepit_slider');

Loader::model('file_set');
Loader::model('file_attributes');

$fileAttributes = FileAttributeKey::getList(); 
$s1 = FileSet::getMySets();

?>
<link type='text/css' rel='stylesheet' href='<?php echo BASE_URL.DIR_REL ?>/packages/deepit_slider/blocks/deepit_slider/auto.css' />
<!-- This to display iButtons -->
<style type="text/css">label{display:inline !important; font-weight:bold}</style>
<!-- End iButtons hack -->
<style type="text/css">
	table.dpit_edit tr > td {border-bottom:1px solid #cccccc; padding:20px}
	table.w-border td {border:none};
</style>
<h2><span><?php    echo $fsID ? "Edit your Slider":"New Deepit Slide with default settings" ?></span></h2>

<hr />


<style>
	#demo-frame > div.demo { padding: 10px !important; }
</style>

<table cellpadding="15" class="dpit_edit" width="100%" >
	<tr>
		<td style="width:40%">
			<label class="label"  for="fsID"><?php      echo t('File Set') ?>:</label>
		</td>
		<td>
			<select name="fsID" title="fsID" id="fsID" onchange='refreshFsID(this.value)'>
				<?php      foreach($s1 as $fs) {
				echo '<option value="'.$fs->getFileSetID().'" ' . ($fsID == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
				}?>
			</select>
				<?php     if (is_array($s1) && count($s1) >= 1) : ?>
				
				<?php     else : ?>
				<h2 style="color:#ff0000">Create file set first<br><span style="font-size:9px">Go to your dashboard > file manager</span></h2>
				<?php     endif ?>

		</td>
	</tr>
	<tr>
		<td>
			<label for="resize">Activate Picture Resizing ?</label><br /><br />						
		</td>
		<td>
			<input type="checkbox" id="resize" name="options[]" value='resize' <?php echo in_array('resize',$options) ? 'checked="checked"' : '' ?> />							
	</tr>
	<tr>
		<td>
			<label for="">Picture size</label><br /><br />			
		</td>
		<td>
			Width : <input type="text" id="width" name="width" style="border:0; font-weight:bold; width:30px; background:#fafafa;" /> px									
			<div id="range-width"></div>																									
			<br /><br />
			Height : <input type="text" id="height" name="height" style="border:0; font-weight:bold; width:30px; background:#fafafa;" /> px									
			<div id="range-height"></div>																									
		</td>
	</tr>
	<tr>
		<td>
			<label for="animSpeed">Animation Speed :</label>

		</td>
		<td>
			<input type="text" id="animSpeed" name="animSpeed" style="border:0; font-weight:bold; width:30px; background:#fafafa;" /> mms
			<div id="range-speed"></div>	
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="pauseTime">Pause Time <small>(Diaporama needed)</small></label>			
		</td>
		<td>
			<input type="text" id="pauseTime" name="pauseTime" value="<?php echo $pauseTime?>" style="border:0; font-weight:bold; width:30px; background:#fafafa;" />	 mms		
			<div id="range-pause"></div>	
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="autoStart">Diaporama</label>			
		</td>
		<td>
			<input type="checkbox" id="autoStart" name="options[]" value='autoStart' <?php echo in_array('autoStart',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="pauseOnHover">Pause on Hover</label>			
		</td>
		<td>
			<input type="checkbox" id="pauseOnHover" name="options[]" value="pauseOnHover" <?php echo in_array('pauseOnHover',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="arrowsNav">Show Arrows <small>(left/Right)</small></label>			
		</td>
		<td>
			<input type="checkbox" id="arrowsNav" name="options[]" value="arrowsNav" <?php echo in_array('arrowsNav',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="arrowsNavHide">Hide Arrows & Caption when mouse leave</label>			
		</td>
		<td>
			<input type="checkbox" id="arrowsNavHide" name="options[]" value="arrowsNavHide" <?php echo in_array('arrowsNavHide',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="listNav">Show Bullet Navigation</label>			
		</td>
		<td>
			<input type="checkbox" id="listNav" name="options[]" value="listNav" <?php echo in_array('listNav',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="listNavThumbs">Thumbnail navigation</label>			
		</td>
		<td>
			<input type="checkbox" id="listNavThumbs" name="options[]" value="listNavThumbs" <?php echo in_array('listNavThumbs',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="liquidLayout">Is your layout liquid?</label>			
		</td>
		<td>
			<input type="checkbox" id="liquidLayout" name="options[]" value="liquidLayout"  class="{labelOn: 'Yes', labelOff: 'No'}" <?php echo in_array('liquidLayout',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			 <label class="label" for="autoLoop">Auto Loop</label> <small>When activate, the slider back to the first frame when the sequence is finite</small>			
		</td>
		<td>
			<input type="checkbox" id="autoLoop" name="options[]" value="autoLoop" <?php echo in_array('autoLoop',$options) ? 'checked="checked"' : '' ?> />			
		</td>
	</tr>
	<tr>
		<td>
			<label><?php  echo t('Manage Layers')?></label>
			<?php print $ah->button_js('Add Layer', 'add_layer()', $buttonAlign=ÕleftÕ, $innerClass=null, $args = array()) ?>
		</td>
		<td>
			<!--<table id="layer-th" cellpadding="5" style="display:none">
				<tr>
					<td  style="width:60%"><?php  echo t('Pick a Picture')?></td>
					<td><?php  echo t('Layer Offset (speed)')?></td>
				</tr>
			</table>
		-->
			<strong>Rear</strong>
			<div id="layer_form_wrapper"></div>
			<strong>Front</strong>
		</td>
	</tr>
	<tr>
		<td>
			<label for="captionPosition">Show Caption</label>
		</td>
		<td>
			<select name="captionPosition" id="captionPosition">
				<option value="none"	<?php    echo $captionPosition == "none" ? 'selected' :''?> >No Caption</option>
				<option value="bottom"	<?php    echo $captionPosition == "bottom" ? 'selected' :''?> >at Bottom</option>
				<option value="top"	<?php    echo $captionPosition == "top" ? 'selected' :''?>>at Top</option>
				<option value="left"	<?php    echo $captionPosition == "left" ? 'selected' :''?> >at Left</option>
				<option value="right"	<?php    echo $captionPosition == "right" ? 'selected' :''?>>at Right</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
                        <label for="caption"><?php   echo t('Display as caption') ?>:</label>
		
		</td>
		<td>
			<select name="caption">
			<optgroup label="Image attribute">
			    <option value="title"       <?php  echo ($caption == "title"?'selected':'')?>            >Title</option>
			    <option value="description" <?php  echo ($caption == "description"?'selected':'')?>      >Description (as Textile)</option>
			    <option value="date"        <?php  echo ($caption == "date"?'selected':'')?>             >Date Posted</option>
			    <option value="filename"    <?php  echo ($caption == "filename"?'selected':'')?>         >File Name</option>
			</optgroup>
			<optgroup label="Custom attribute">
			    <?php  
			    foreach($fileAttributes as $ak) :  ?>
				<option value="<?php  echo $ak->getAttributeKeyHandle() ?>"
					<?php  echo ($caption == $ak->getAttributeKeyHandle()?'selected':'')?> ><?php  echo  $ak->getAttributeKeyName() ?>
				</option>
			    <?php   endforeach ?> 
			</optgroup>
			</select>
			</div>		
		</td>
	</tr>
	<tr>
		<td>
			<label class="label"  for="link"><?php      echo t('Link your image to')?>:</label>
		</td>
		<td>
			<select name="link" class="ccm-file-set-description" id='link' onchange="toggleCustomPage(this.value);">
					<option value="0"       	<?php    echo $link == "link" ? 'selected' :''?>        >No link</option>
					<option value="image"       	<?php    echo $link == "image" ? 'selected':''?>        >Image</option>
					<option value="page"       	<?php    echo $link == "page" ? 'selected':''?>        >Page</option>
					<option value="multipages"       <?php    echo $link == "multipages" ? 'selected':''?>>Separate Page</option>
				
			</select>
			<br /><br />
			<div id="sorted-selectPage" <?php     if ($link != "page") { echo 'style="display:none"';}?>>
			<?php    
				echo $pageSelector->selectPage('linkPageID', $linkPageID);
			?>
			</div>
			<div id="ccm-file-infos-list">
				
			</div>


		</td>
	</tr>
</table>

<script type="text/javascript">
// iButton (Credit Below)
(function(E){E.iButton={version:"1.0.01",setDefaults:function(G){E.extend(F,G)}};E.fn.iButton=function(J){var K=typeof arguments[0]=="string"&&arguments[0];var I=K&&Array.prototype.slice.call(arguments,1)||arguments;var H=(this.length==0)?null:E.data(this[0],"iButton");if(H&&K&&this.length){if(K.toLowerCase()=="object"){return H}else{if(H[K]){var G;this.each(function(L){var M=E.data(this,"iButton")[K].apply(H,I);if(L==0&&M){if(!!M.jquery){G=E([]).add(M)}else{G=M;return false}}else{if(!!M&&!!M.jquery){G=G.add(M)}}});return G||this}else{return this}}}else{return this.each(function(){new C(this,J)})}};var A=0;E.browser.iphone=(navigator.userAgent.toLowerCase().indexOf("iphone")>-1);var C=function(N,I){var S=this,H=E(N),T=++A,K=false,U={},O={dragging:false,clicked:null},W={position:null,offset:null,time:null},I=E.extend({},F,I,(!!E.metadata?H.metadata():{})),Y=(I.labelOn==B&&I.labelOff==D),Z=":checkbox, :radio";if(!H.is(Z)){return H.find(Z).iButton(I)}E.data(H[0],"iButton",S);if(I.resizeHandle=="auto"){I.resizeHandle=!Y}if(I.resizeContainer=="auto"){I.resizeContainer=!Y}this.toggle=function(b){var a=(arguments.length>0)?b:!H.is(":checked");H.attr("checked",a?"checked":"").trigger("change")};this.disable=function(b){var a=(arguments.length>0)?b:!K;K=a;H.attr("disabled",a);V[a?"addClass":"removeClass"](I.classDisabled);if(E.isFunction(I.disable)){I.disable.apply(S,[K,H,I])}};this.repaint=function(){X()};this.destroy=function(){E([H[0],V[0]]).unbind(".iButton");E(document).unbind(".iButton_"+T);V.after(H).remove();E.data(H[0],"iButton",null);if(E.isFunction(I.destroy)){I.destroy.apply(S,[H,I])}};H.wrap('<div class="'+I.classContainer+'" />').after('<div class="'+I.classHandle+'"><div class="'+I.classHandleRight+'"><div class="'+I.classHandleMiddle+'" /></div></div><div class="'+I.classLabelOff+'"><span><label>'+I.labelOff+'</label></span></div><div class="'+I.classLabelOn+'"><span><label>'+I.labelOn+'</label></span></div><div class="'+I.classPaddingLeft+'"></div><div class="'+I.classPaddingRight+'"></div>');var V=H.parent(),G=H.siblings("."+I.classHandle),P=H.siblings("."+I.classLabelOff),M=P.children("span"),J=H.siblings("."+I.classLabelOn),L=J.children("span");if(I.resizeHandle||I.resizeContainer){U.onspan=L.outerWidth();U.offspan=M.outerWidth()}if(I.resizeHandle){U.handle=Math.min(U.onspan,U.offspan);G.css("width",U.handle)}else{U.handle=G.width()}if(I.resizeContainer){U.container=(Math.max(U.onspan,U.offspan)+U.handle+20);V.css("width",U.container);P.css("width",U.container-5)}else{U.container=V.width()}var R=U.container-U.handle-6;var X=function(b){var c=H.attr("checked"),a=(c)?R:0,b=(arguments.length>0)?arguments[0]:true;if(b&&I.enableFx){G.stop().animate({left:a},I.duration,I.easing);J.stop().animate({width:a+4},I.duration,I.easing);L.stop().animate({marginLeft:a-R},I.duration,I.easing);M.stop().animate({marginRight:-a},I.duration,I.easing)}else{G.css("left",a);J.css("width",a+4);L.css("marginLeft",a-R);M.css("marginRight",-a)}};X(false);var Q=function(a){return a.pageX||((a.originalEvent.changedTouches)?a.originalEvent.changedTouches[0].pageX:0)};V.bind("mousedown.iButton touchstart.iButton",function(a){if(E(a.target).is(Z)||K||(!I.allowRadioUncheck&&H.is(":radio:checked"))){return }a.preventDefault();O.clicked=G;W.position=Q(a);W.offset=W.position-(parseInt(G.css("left"),10)||0);W.time=(new Date()).getTime();return false});if(I.enableDrag){E(document).bind("mousemove.iButton_"+T+" touchmove.iButton_"+T,function(c){if(O.clicked!=G){return }c.preventDefault();var a=Q(c);if(a!=W.offset){O.dragging=true;V.addClass(I.classHandleActive)}var b=Math.min(1,Math.max(0,(a-W.offset)/R));G.css("left",b*R);J.css("width",b*R+4);M.css("marginRight",-b*R);L.css("marginLeft",-(1-b)*R);return false})}E(document).bind("mouseup.iButton_"+T+" touchend.iButton_"+T,function(d){if(O.clicked!=G){return false}d.preventDefault();var f=true;if(!O.dragging||(((new Date()).getTime()-W.time)<I.clickOffset)){var b=H.attr("checked");H.attr("checked",!b);if(E.isFunction(I.click)){I.click.apply(S,[!b,H,I])}}else{var a=Q(d);var c=(a-W.offset)/R;var b=(c>=0.5);if(H.is(":checked")==b){f=false}H.attr("checked",b)}V.removeClass(I.classHandleActive);O.clicked=null;O.dragging=null;if(f){H.trigger("change")}else{X()}return false});H.bind("change.iButton",function(){X();if(H.is(":radio")){var b=H[0];var a=E(b.form?b.form[b.name]:":radio[name="+b.name+"]");a.filter(":not(:checked)").iButton("repaint")}if(E.isFunction(I.change)){I.change.apply(S,[H,I])}}).bind("focus.iButton",function(){V.addClass(I.classFocus)}).bind("blur.iButton",function(){V.removeClass(I.classFocus)});if(E.isFunction(I.click)){H.bind("click.iButton",function(){I.click.apply(S,[H.attr("checked"),H,I])})}if(H.is(":disabled")){this.disable(true)}if(E.browser.msie){V.find("*").andSelf().attr("unselectable","on");H.bind("click.iButton",function(){H.triggerHandler("change.iButton")})}if(E.isFunction(I.init)){I.init.apply(S,[H,I])}};var F={duration:200,easing:"swing",labelOn:"ON",labelOff:"OFF",resizeHandle:"auto",resizeContainer:"auto",enableDrag:true,enableFx:true,allowRadioUncheck:false,clickOffset:120,classContainer:"ibutton-container",classDisabled:"ibutton-disabled",classFocus:"ibutton-focus",classLabelOn:"ibutton-label-on",classLabelOff:"ibutton-label-off",classHandle:"ibutton-handle",classHandleMiddle:"ibutton-handle-middle",classHandleRight:"ibutton-handle-right",classHandleActive:"ibutton-active-handle",classPaddingLeft:"ibutton-padding-left",classPaddingRight:"ibutton-padding-right",init:null,change:null,click:null,disable:null,destroy:null},B=F.labelOn,D=F.labelOff})(jQuery);


$(window).ready(function() {
        <?php if (is_array($layer_files) ) : ?>
        <?php foreach ($layer_files as $n=>$lf)  : ?>
                add_layer('<?=$lf?>','<?=$offsets[$n]?>','<?=$directions[$n]?>');
        <?php endforeach; ?>
        <?php endif ?>
        
        $("#layer_form_wrapper").sortable({
        }).disableSelection();
        <?php 
                if ($fsID && $link == 'multipages') : ?>
                refreshFsID(); 
        <?php  endif ?>

        // SLiders
        $( "#range-speed" ).slider({
                value: <?php echo $animSpeed ?>,
                min: 1,
                max: 10000,
                slide: function( event, ui ) {
                        $( "#animSpeed" ).val(ui.value );
                }
        });
        $( "#animSpeed" ).val($( "#range-speed" ).slider( "value" ) );
        $( "#range-pause" ).slider({
                value: <?php echo $pauseTime ?>,
                min: 1,
                max: 10000,
                slide: function( event, ui ) {
                        $( "#pauseTime" ).val(ui.value );
                }
        });
        $( "#pauseTime" ).val($( "#range-pause" ).slider( "value" ) );
        
	$( "#range-width" ).slider({
                value: <?php echo $width ?>,
                min: 1,
                max: 2000,
                slide: function( event, ui ) {
                        $( "#width" ).val(ui.value );
                }
        });
        $( "#width" ).val($( "#range-width" ).slider( "value" ) );
        
	$( "#range-height" ).slider({
                value: <?php echo $height ?>,
                min: 1,
                max: 600,
                slide: function( event, ui ) {
                        $( "#height" ).val(ui.value);
                }
        });
        $( "#height" ).val($( "#range-height" ).slider( "value" ) );



        // Ibuttons
        $(":checkbox").iButton({
                resizeHandle: 20                 // determines if handle should be resized 
                //resizeContainer: 50                 // determines if container should be resized 
                });

});
// managing Layers form
var layerID = 0;
function add_layer(fID,offset,direction) {
        //$('#layer-th').fadeIn('slow');
        var $l = $('<div class="layered"></div>').appendTo('#layer_form_wrapper');
        $.get("<?php  echo $layers_form_tool?>?bID=<?php   echo $this->controller->bID?>&layerID=" + layerID + "&fID=" + fID + "&offset=" + offset + "&direction=" + direction,
                function(data) {
                        $(data).appendTo($l);
                });
        layerID ++;

}

function toggleCustomPage(value) {
        if (value == "page") {
                $("#sorted-selectPage").css('display','block');
        } else if (value == "multipages") {
                $("#sorted-selectPage").hide();
                fs = $('#fsID').val();
                $.get("<?php  echo $link_form_tool?>?bID=<?php   echo $this->controller->bID?>&fsID="+fs,
                        function(data) {
                                $('#ccm-file-infos-list').html(data);
                        });
        
        } else {
                $("#sorted-selectPage").hide();
                $('#ccm-file-infos-list').html('');
        }
}
function refreshFsID(id) {
        if ($('#link').val() == 'multipages') {
                toggleCustomPage('multipages');
        }
}	
function thumbControl(b){
        if (b.checked){
                $('#controlNavThumbs').removeAttr("disabled").prev().css('color','#000000');
        } else {
                $('#controlNavThumbs').attr("disabled", true).prev().css('color','#cccccc');			
        }
}


/*
 * Metadata - jQuery plugin for parsing metadata from elements
 *
 * Copyright (c) 2006 John Resig, Yehuda Katz, Jšrn Zaefferer, Paul McLanahan
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id$
 *
 */

/**
 * Sets the type of metadata to use. Metadata is encoded in JSON, and each property
 * in the JSON will become a property of the element itself.
 *
 * There are three supported types of metadata storage:
 *
 *   attr:  Inside an attribute. The name parameter indicates *which* attribute.
 *          
 *   class: Inside the class attribute, wrapped in curly braces: { }
 *   
 *   elem:  Inside a child element (e.g. a script tag). The
 *          name parameter indicates *which* element.
 *          
 * The metadata for an element is loaded the first time the element is accessed via jQuery.
 *
 * As a result, you can define the metadata type, use $(expr) to load the metadata into the elements
 * matched by expr, then redefine the metadata type and run another $(expr) for other elements.
 * 
 * @name $.metadata.setType
 *
 * @example <p id="one" class="some_class {item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metadata.setType("class")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from the class attribute
 * 
 * @example <p id="one" class="some_class" data="{item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metadata.setType("attr", "data")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from a "data" attribute
 * 
 * @example <p id="one" class="some_class">
 * @before $.metadata.setType("elem", "script")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from a nested script element
 * 
 * @param String type The encoding type
 * @param String name The name of the attribute to be used to get metadata (optional)
 * @cat Plugins/Metadata
 * @descr Sets the type of encoding to be used when loading metadata for the first time
 * @type undefined
 * @see metadata()
 */

(function($) {

$.extend({
	metadata : {
		defaults : {
			type: 'class',
			name: 'metadata',
			cre: /({.*})/,
			single: 'metadata'
		},
		setType: function( type, name ){
			this.defaults.type = type;
			this.defaults.name = name;
		},
		get: function( elem, opts ){
			var settings = $.extend({},this.defaults,opts);
			// check for empty string in single property
			if ( !settings.single.length ) settings.single = 'metadata';
			
			var data = $.data(elem, settings.single);
			// returned cached data if it already exists
			if ( data ) return data;
			
			data = "{}";
			
			if ( settings.type == "class" ) {
				var m = settings.cre.exec( elem.className );
				if ( m )
					data = m[1];
			} else if ( settings.type == "elem" ) {
				if( !elem.getElementsByTagName )
					return undefined;
				var e = elem.getElementsByTagName(settings.name);
				if ( e.length )
					data = $.trim(e[0].innerHTML);
			} else if ( elem.getAttribute != undefined ) {
				var attr = elem.getAttribute( settings.name );
				if ( attr )
					data = attr;
			}
			
			if ( data.indexOf( '{' ) <0 )
			data = "{" + data + "}";
			
			data = eval("(" + data + ")");
			
			$.data( elem, settings.single, data );
			return data;
		}
	}
});

/**
 * Returns the metadata object for the first member of the jQuery object.
 *
 * @name metadata
 * @descr Returns element's metadata object
 * @param Object opts An object contianing settings to override the defaults
 * @type jQuery
 * @cat Plugins/Metadata
 */
$.fn.metadata = function( opts ){
	return $.metadata.get( this[0], opts );
};

})(jQuery);

/*
 * iButton jQuery Plug-in
 *
 * Copyright 2009 Giva, Inc. (http://www.givainc.com/labs/) 
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 * 	http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Date: 2009-08-25
 * Rev:  1.0.01
 */

</script>
