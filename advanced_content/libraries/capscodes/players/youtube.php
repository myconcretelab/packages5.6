<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeYoutube extends CapsuleCodeHelper {

	public $width = 640;
	public $height = 390;
	public $id = 'UUcY2O0eWd4';
	public $hiddenOnEditMode = true;


	function get_capscode () {

		return t('[youtube
							width ="-n #constraint the video width#"
							height ="-n #constraint the video height#"
							id = "-t #Required, the id of the video#"
							][/youtube]');

	}
	
	function build_html () {
	
		$output = "<div id='ytplayer'></div>
					<script>
					  var tag = document.createElement('script');
					  tag.src = 'https://www.youtube.com/player_api';
					  var firstScriptTag = document.getElementsByTagName('script')[0];
					  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

					  var player;
					  function onYouTubePlayerAPIReady() {
					    player = new YT.Player('ytplayer', {
					      height: '$this->height',
					      width: '$this->width',
					      videoId: '$this->id'
					    });
					  }
					</script>";

		return  $output ;
		
	}
}
