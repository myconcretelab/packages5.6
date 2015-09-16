<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeCode  extends CapsuleCodeHelper {

	function get_capscode () {
		return t('[code] [/code]');
	}

	function build_html () {

		if (!$this->content) return '';
//		var_dump($this->content);
		$content = preg_replace('/<p[^>]*>/', '', $this->content); // Remove the start <p> or <p attr="">
		$content = preg_replace('/<\/p>/', '', $content); // Replace the end
		$content = preg_replace('/<br \/>/', "\n", $content); // Replace the end

		return '<pre class="prettyprint linenums">' . $content . '</pre>';
	}
}
?>
