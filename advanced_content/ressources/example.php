<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapscodeExample  extends CapsuleCodeHelper {
	
	# 	Each tag have a name (in this case 'Example')
	#	this name is found in the file name, the class name, preceded by Capscode and in the tag name below. 
	#	In the case of embedded tags (like tabs, accordions), tag name is the same as the tag batch operator, without the 's'.
	#	Example: [tags] [tag] content of tag 1 [/tag] [tag] content of tag 2 [/tag] [/tags]

	#	$samplecontent is the taxt that will insered into the example, when a user add a capscode into the wysiwyg. the variable is optional.
	# 	eg : [example]Example text[/example]
	public $samplecontent = 'Example text';

	#	Each option has its default value. This value will be used to create the form and as a replacement if it has not been specified by the user. 
	#	These values ​​by default, if it is omitted can create errors.
	public $option = "option text";

	function get_capscode () {

		# 	The capscode can be in two ways:
		#	- 	Simple, it has a [tag] opening, content between two tag, and closing [\tag]. Options are inserted into the opening tag.
		#	- 	With embeded tag, it has a [tags] opening, a [tag] opening, content for tag 1, closing [\tag], and the closing [/tags] Options are inserted into the opening tags and/or the opening [tag] for each tag.

		#	The option can be written as option_name = "-option-type #description option#"
		# 	eg : [image image="-i #Choose a image#"][/image]
		#	eg : [tabs open="-n #wich tab is open#"][tab tilte="-t #The title of the tab#"][/tab][/tabs]
		#
		# 	Type of options are :
		#
		#	't'=>'text',
		#	'b'=>'boolean', 
		#	'n'=>'number',
		#	'p'=>'page',
		#	'f'=>'file',
		#	'i'=>'image',
		#	'u'=>'user',
		#	'c'=>'color',
		#	'fs'=>'fileset',
		#	'pa'=>'page_attribute',
		#	'fa'=>'file_attribute'
		#	'mp3'=>'mp3'
		#	'mov'=>'mov'

		# The tag are embeded into a t() function for translation.
		return t('[example option="-t #Description of the option#"][/example]');


	}

	#	build_html function is called to render the capscode. it must return a html string.
	#	echo and print are not recomended here

	function build_html () {

		# 	variables are available here:
		#
		#	$this->content (string) : the html text extracted from the space between the two tags
		# 	$this->the_name_of_option (string) : (in this case $this->option) the value of the option
		#
		#	$this->enclosing_tag (array) : a array containing all enclosing tag as :
		#		$this->enclosing_tag[0]['content'] :  the html text extracted from the space between the two first tag
		#		$this->enclosing_tag[0]['option_name'] : the value of the option_name of the first tag
		#
		# 	to use enclosing tag :
		#
		#	if (count($this->enclosing_tag)) :
		#		foreach ($this->enclosing_tag as $i => $tag ) : 
		#			$conten_of_tag 	= 	$tag['content'];
		#			$option_value	=	$tag['option_name']
		#		endforeach;
		#	endif;
		
		return 	'<p> Value of the option is : ' . $this->option . '</p>' .
				'<p> Value of content is : ' . $this->content . '</p>' ;
	

	}
}