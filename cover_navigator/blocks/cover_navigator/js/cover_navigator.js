var open_gallery = function (gallery) {
	$('#itemcontainer').html('');
	$.ajax({
		type: 'POST',
		url: RETRIEVE_CLIENT_URL,
		//data: {'bID':BLOCK_ID},
		dataType: 'json',		
		success: function(data) {
			for (a in data) {
				if (data[a].src) {
					$('<img src="' + data[a].src + '" alt="' + data[a].title + '" class="item" rel="' + data[a].fID + '" />').appendTo('#itemcontainer' );					
				}
			}
			$('img', '#itemcontainer').each(function (index) {
				 gallery.addItem(this,index);
				 CLIENT_ARRAY[index] = $(this).attr('rel');
				});
			gallery.resize();
		}
	});		
	
}

var log = function ( string ) {
if ( typeof console == 'object' ) {
	console.log ( string );
}
}
var ex_e = false;

var loadRessources = function (e) {
	//console.log(CLIENT_ARRAY);
	$.ajax({
		type: 'POST',
		url: LOAD_PLAYER_URL,
		data: {'index':e.index, fID:CLIENT_ARRAY[e.index]},
		dataType: 'json',
		success: function(data) {
				//log(data);
		//		$('.result').html(data);
				display(data);
			      }
	});		
//		console.log(e.index);
}
var display = function(g){
	$('.result').html(' &nbsp;');
	context = $('<div></div>').addClass('loader').hide().appendTo('.result');
	display_client(g.client, context);
	for (a in g.medias) {
		context = $('<div id="media-' + a + '"></div>').addClass('loader').appendTo('.result');
		eval ('display_' + g.medias[a].type)(g.medias[a], context);
		
	}
}
var display_mp3 = function (e, c) {
	var rp = e.relativePath;
	c
	.addClass('mp3').append('')
			.append('<h3 class="media-title">' + e.cat[0] + ' > <span>' + e.title + '</span>' + '</h3>')
			.append('<p>' + e.description + '</p>');
	if (e.thumb){c.prepend('<div class="file-thumb"><img src="' + e.thumb + '" alt="' + e.title + '" /></div>')};
	$.ajax({
		type: 'POST',
		url: MP3_PLAYER_URL,
		data: {'object':e},
		success: function(data) {
			c.append(data).removeClass('loader');
			init_player(e);
			      }
	});
	
	
}
var display_youtube = function (e, c) {
	//console.log(e);
	c.addClass('youtube').append('<iframe width="420" height="315" src="http://www.youtube.com/embed/' + e.youtube_id + '" frameborder="0" allowfullscreen></iframe>').removeClass('loader');

}
var display_client = function (e, c) {
	c
	.addClass('client')
	.append('<img src="'+ e.relativePath +'" alt="'+ e.title +'" />')
	.append('<div class="title"><h3>'+ e.title +'</h3></div>')
	.append('<div class="description"><p>'+ e.description +'</p></div>')
	.removeClass('loader')
	.fadeIn(800)
}

var init_player = function (e) {
	$("#jquery_jplayer_" + e.fID).jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				mp3:e.relativePath
			});
		},
		swfPath: BLOCK_URL + "/js",
		supplied: "mp3",
		wmode: "window",
		cssSelectorAncestor:'#jp_container_' + e.fID
	});			
}