<?php defined('C5_EXECUTE') or die("Access Denied.");

class CapscodeAudio extends CapsuleCodeHelper {
	
	public $samplecontent = ' ';
	public $file = 0;
	public $hiddenOnEditMode = true;

	function get_capscode () {
		return t('[audio 
						file="-mp3 #choose a music file#"
						]
						[/audio]');
	}

	function build_html () {
		if (!intval($this->file)) return;
		loader::model('file');
		$src = Concrete5_Model_File::getRelativePathFromID($this->file);
		return "
			<script>audiojs.events.ready(function() {var as = audiojs.createAll({imageLocation:CCM_BASE_URL + '/' + CCM_REL + '/packages/advanced_content/blocks/advanced_content/js/player-graphics.gif'});});</script>
			<audio src='$src' preload='auto'></audio>";

	}
}

