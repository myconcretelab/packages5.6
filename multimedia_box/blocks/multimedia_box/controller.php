<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));

class MultimediaBoxBlockController extends BlockController {
	
	
	protected $btTable = 'btMultimediaBox';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "550";

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
		
	public function on_page_view() {
		
	}
	
	public function getBlockTypeDescription() {
		return t("Provide a Multimedia viewer");
	}
	
	public function getBlockTypeName() {
		return t("Multimedia Box");
	}
	public function add (){
		$this->set('options', array('show_title', 'show_desc'));
		$this->set_form_utilities();	
	}

	public function edit () {
		$this->set_form_utilities();	
		$this->set('types', explode('0o0', $this->types));
		$this->set('templateOptions', explode('0o0', $this->template_options ));		
		// options
		$this->set('options',explode(',',$this->options));
	}
	
	private function set_form_utilities () {
		$url = Loader::helper('concrete/urls');
		$this->set('form_media_url', $url->getToolsURL('get_form_media','multimedia_box'));
		$this->set('get_file_attributes_options', $url->getToolsURL('get_file_attributes_options','multimedia_box'));
		// List of custom templates
		$blockType = BlockType::getByHandle('multimedia_box');
		$this->set('templatesList', $blockType->getBlockTypeCustomTemplates());
		// Block URL
		$th = Loader::helper('concrete/urls'); 
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('multimedia_box')));
		
	}

	public function getJavaScriptStrings() {
		return array(
		'gallery-required' => t('You must pick at least one media'),
		'url-valid' => t('You must choose a valid URL'),
		'file-required' => t('You must choose a file'),
		'dimension-required' => t('You must have a dimension')
		);
	}

	
	function get_thumb_src($file) {
		$i = Loader::helper('image');
		$fv = $file->getApprovedVersion();
		if ($file->getAttribute('custom_thumbnail')) {
			$th = $i->getThumbnail($file->getAttribute('custom_thumbnail'),$this->thumb_size,$this->thumb_size, array('crop'=>true));
			$url['src'] = $th->src;
			$url['width'] = $th->width;
			$url['height'] = $th->height;
			return $url;
		}
		// is a picture
		elseif ($fv->hasThumbnail(1)) {
			$th = $i->getThumbnail($file ,$this->thumb_size, $this->thumb_size, array('crop'=>true));
			$url['src'] = $th->src;
			$url['width'] = $th->width;
			$url['height'] = $th->height;
			return $url;

		// it's a other file
		} else {
			$ft = FileTypeList::getType($fv->fvFilename);
			$img = $fv->fvFilename;
			if (file_exists(DIR_BASE . '/packages/multimedia_box/images/types_icons/' . $ft->extension . '.png')) {
				$url['src'] = DIR_REL . '/packages/multimedia_box/images/types_icons/' . $ft->extension . '.png';
			} else if (file_exists(DIR_AL_ICONS . '/' . $ft->extension . '.png')) {
				$url['src'] = REL_DIR_AL_ICONS . '/' . $ft->extension . '.png';
			} else {
				$url['src'] = AL_ICON_DEFAULT;
			}
			$url['width'] = $this->thumb_size;
			$url['height'] = $this->thumb_size;

		}
		return $url;
	}
	function get_web_page_thumb () {
		if (file_exists(DIR_BASE . '/packages/multimedia_box/images/types_icons/web-page.png')) {
			$url = DIR_REL . '/packages/multimedia_box/images/types_icons/web-page.png';
		} else {
			$url = AL_ICON_DEFAULT;
		}
		return $url;
		
	}
	
	function get_youtube_id($url) {
		$parsed_url = parse_url($url);
		parse_str($parsed_url[query], $parsed_query);
		return $parsed_query[v];
	}
	function get_vimeo_infos($url, $info = NULL) {
		preg_match ("/vimeo.com\/(\d+)\/?/", $url,$parsed_query);
		$imgid = $parsed_query[1];
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
		if ($info == NULL) {
			return $hash[0];
		} elseif ($info == 'description') {
			preg_match("@(.)*<br />@" , $hash[0]['description'],$match);
			return htmlentities($match[0],ENT_QUOTES);
		} elseif ($info == 'title') {
			return htmlentities($hash[0]['title'],ENT_QUOTES);
		} else {
			return htmlentities($hash[0][$info],ENT_QUOTES);			
		}

	}


	function get_media_infos ($type,$media,$title,$desc,$width=NULL,$height=NULL) {
		
		// TODO : 	Placer la function dans la function view()
		//		remplacer $return[$count]['img'] par des ŽlŽments sŽparŽs ($return[$count]['width'], ..) et crŽer la balise image dans le view.php
		
		$return = array();
		$count = 0;
		Loader::model('file');
		$i = Loader::helper('image');

		switch ($type) {
			case 'image':
			case 'flash':
			case 'mp3':
			case 'quicktime':
				$f = File::getByID($media);
				$s = @getimagesize($f->getPath());
				$url = $this->get_thumb_src($f);
				$return[$count]['title'] = $_title = $this->get_file_field_value($f,$title);
				$return[$count]['desc'] = $_desc = $this->get_file_field_value($f,$desc);
				
				//$relativePath = $i->getThumbnail($f,$s[0],$s[1])->src;
				$relativePath = $f->getAttribute('url') == NULL ? $f->getRelativePath() : $f->getAttribute('url');
				$marginTop = intval(( $this->thumb_size - $url['height']) / 2);
				$return[$count]['img'] = "<img src='".$url['src']."' alt='$_title' title='$_desc' width='".$url['width']."px' height='".$url['height']."px' style='margin-top:{$marginTop}px'  />";	

				if ($type == "mp3") {
					// load the flash music player
					$return[$count]['box_mediaURL'] = DIR_REL . '/packages/multimedia_box/elements/player_mp3.swf?width=500&height=80&flashvars=autoplay=1&showstop=1&showinfo=1&mp3=' . $relativePath;
				} else {
					//relative path
					$return[$count]['box_mediaURL'] = $relativePath;					
				}
				$return[$count]['media_options'] = '';
				break;
			case 'youtube':
				$vID = $this->get_youtube_id($media);
				$return[$count]['box_mediaURL'] = 'http://www.youtube.com/watch?v=' . $vID;
				$Vheight = intval(((intval($this->thumb_size))/8)*6);
				$marginTop = intval(( $this->thumb_size - $Vheight) / 2);
				$return[$count]['title'] = $title;
				$return[$count]['desc'] = $desc;
				$return[$count]['img'] = "<img src='http://img.youtube.com/vi/$vID/0.jpg' alt='$title' title='$desc' width='{$this->thumb_size}px' height='{$Vheight}px' style='margin-top:{$marginTop}px' />";
				$return[$count]['media_options'] = '';
				break;
			case 'vimeo':
				$vimeo = $this->get_vimeo_infos($media);
				$return[$count]['box_mediaURL'] = 'http://vimeo.com/' . $vimeo['id'] ;//. '?width=' . $vimeo['width'] . '&height=' . $vimeo['height'];
				$Vheight = intval(((intval($this->thumb_size))/4)*3);
				$marginTop = intval(( $this->thumb_size - $Vheight) / 2);	
				$vimeo['title'] = $return[$count]['title'] = htmlentities($vimeo['title'],ENT_QUOTES);
				$vimeo['description'] = $return[$count]['desc'] = htmlentities($vimeo['description'],ENT_QUOTES);
				$subdesc = substr($vimeo['description'],0,80);
				$return[$count]['img'] = "<img src='{$vimeo['thumbnail_medium']}' alt='{$vimeo['title']}' title='$subdesc...' width='{$this->thumb_size}px' height='{$Vheight}px'  style='margin-top:{$marginTop}px' />";
				$return[$count]['media_options'] = '';
				break;
			case 'webpage':
				$return[$count]['box_mediaURL'] = $media . '?iframe=true&width=' . $width . '&height=' . $height;
				$return[$count]['img'] = "<img src='" . $this->get_web_page_thumb() . "' alt='$title' title='$desc' width='{$this->thumb_size}px' height='{$this->thumb_size}px' />";
				$return[$count]['title'] = $title;
				$return[$count]['desc'] = $desc;
				$return[$count]['media_options'] = '';
				break;
			case 'fileset':
				// Check compatibility with Concrete 5.4.1
				if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
					$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($media) );				
				} else {
					$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($media) );				
				}
				if (!is_array($data)) return false;
				$nv = Loader::helper('navigation');
				$i = Loader::helper('image');
				Loader::library('file/types');
				
				$v = array();
				$cc = 0;
				foreach ($data as $d) :
					$img = File::getByID($d['fID']);
					$fv = $img->getExtension();
					$ft = FileTypeList::getType($fv);
					switch ($ft->type) {
						case 1: // image
							if ($fv == 'swf'){ $mtype = 'flash';} else {$mtype = 'image';};
							break;
						case 2: // video
							if ($fv == 'mov'){
								$mtype = 'quicktime';								
							}
							break;
						case 4: // audio
							if ($fv == 'mp3'){
								$mtype = 'mp3';								
							}
							break;
						default:
							
							break;
						
					}
					$m = $this->get_media_infos($mtype,$d['fID'],$title,$desc);
					$return[$count] = $m[0];
					$count ++;
				endforeach;
			break;
		}
			// Adding some special things 
			if ( $type == 'flash' || $type == 'quicktime' ) {
				if ($type == 'flash' || $type == 'quicktime' ) {
					// Attribute "height" & "width" is naturally given by C5 and taked if User attribute "Width" or "Height" is null
					
					$height = $f->getAttribute('height') == NULL ?  $height : $f->getAttribute('height');
					$width = $f->getAttribute('width') == NULL ?  $width : $f->getAttribute('width');
					
					
				} else {
					$height = $height == NULL ? 100 : $height;
					$width = $width == NULL ? 100 : $width;		
				}
				$return[$count]['box_mediaURL'] .= "?width=$width&height=$height";
				if ($type == 'web-page') {
					$return[$count]['box_mediaURL'] .= '&iframe=true';
				}
			}
		return $return;		
	}
	
	function addUriInfos($type,$width=100,$height=100) {
		$box_mediaURL = "";

		return $box_mediaURL;
		
	}
	private function get_file_field_value($f,$handle) {
		if(!is_object($f)) {
			return false;
		}
		$value = "";
		switch($handle) {
			case "none";
				$value = '';
			break;
			case "title";
				$value = $f->getTitle();
			break;
			case "description";
				$value = $f->getDescription();
			break;
			case "date":
				$value = $f->getDateAdded();
			break;
			case "filename":
				$value = $f->getFileName();
			break;
			default:
				$value = $f->getAttribute($handle);
			break;
		}
		return $value;
	}
	function view() {
		$types = explode('0o0', $this->types);
		$this->set('descs', explode('0o0', $this->descs));
		$this->set('medias', explode('0o0', $this->medias));
		$this->set('titles', explode('0o0', $this->titles));
		$this->set('types', $types);
		$this->set('widths', explode('0o0', $this->widths));
		$this->set('heights', explode('0o0', $this->heights));
		$this->set('options', explode('0o0', $this->options));
		$this->set('box_titles', "");
		$this->set('box_descs',  "");
		$this->set('options',explode(',',$this->options));
		$this->set('media_options', explode('0o0',$this->media_options));
		if (count($types) == 1 && $types[0] != 'fileset') {
			$this->set('notAGallery',true);
		}
		if (file_exists(DIR_BASE . '/packages/multimedia_box/images/glass.png')) {
			$i = Loader::helper('custom_image', 'multimedia_box');
			$this->set ('glass',$i->getThumbnail(DIR_BASE . '/packages/multimedia_box/images/glass.png', $this->thumb_size, $this->thumb_size, array('crop'=>true)));

		}
	}
	
	function save ($data) {
		$ave = array();
		$ave['thumb_size'] = $data['thumb_size'] != '' ? $data['thumb_size'] : 64;
		$ave['slideshow'] = $data['slideshow'] != '' ? $data['slideshow'] : 5000;
		$ave['template'] = $data['template'];		
		$ave['template_options'] = $data['template_options'];		
		foreach($data['mID'] as $mID){
			$type = $data['type_'.$mID];
			$ave['types'][] = $type;
			switch($type) {
				case 'fileset':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = $data['width_'.$mID];
					$ave['heights'][] = $data['height_'.$mID];
					$ave['thumbs'][] = "";
					// Utiliser le media_options comme variable evolutives pour donenr des option au media
					$ave['media_options'][] = is_array($data['media_options_'.$mID]) ? implode('_', $data['media_options_'.$mID]) : $data['media_options_'.$mID];
					break;
				case 'image':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = "";
					$ave['heights'][] = "";
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
				case 'flash':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = '';
					$ave['heights'][] = '';
					$ave['thumbs'][] = '';
					$ave['media_options'][] = '';
					break;
				case 'mp3':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = "";
					$ave['heights'][] = "";
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
				case 'quicktime':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = $data['width_'.$mID];
					$ave['heights'][] = $data['height_'.$mID];
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
				case 'youtube':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = "";
					$ave['heights'][] = "";
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
				case 'vimeo':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = "";
					$ave['descs'][] = "";
					$ave['widths'][] = "";
					$ave['heights'][] = "";
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
				case 'webpage':
					$ave['medias'][] = $data['media_'.$mID];
					$ave['titles'][] = $data['title_'.$mID];
					$ave['descs'][] = $data['description_'.$mID];
					$ave['widths'][] = $data['width_'.$mID];
					$ave['heights'][] = $data['height_'.$mID];
					$ave['thumbs'][] = "";
					$ave['media_options'][] = '';
					break;
			}
			
		}
		$ave['types'] =implode("0o0", $ave['types']);		
		$ave['medias'] =implode("0o0", $ave['medias']);
		$ave['titles'] =implode("0o0", $ave['titles']);
		$ave['descs'] =implode("0o0", $ave['descs']);
		$ave['widths'] =implode("0o0", $ave['widths']);
		$ave['heights'] =implode("0o0", $ave['heights']);
		$ave['thumbs'] =implode("0o0", $ave['thumbs']);
		$ave['media_options'] =implode("0o0", $ave['media_options']);
		$ave['bID'] = $data['bID'];
		$ave['options'] = is_array($data['options']) ? implode(',',$data['options']) : "";
		parent::save($ave);
	}

	function dump(&$var, $info = FALSE) {
		$scope = false;
		$prefix = 'unique';
		$suffix = 'value';
		
		if($scope) $vals = $scope;
		else $vals = $GLOBALS;
		
		$old = $var;
		$var = $new = $prefix.rand().$suffix; $vname = FALSE;
		foreach($vals as $key => $val) if($val === $new) $vname = $key;
		$var = $old;
		
		echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 10px; line-height: 13px;'>";
		if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
		$this->do_dump($var, '$'.$vname);
		echo "</pre>";
	}
////////////////////////////////////////////////////////
// Function:         do_dump
// Inspired from:     PHP.net Contributions
// Description: Better GI than print_r or var_dump

	function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)	{
		$do_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
		$reference = $reference.$var_name;
		$keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';
		
		if (is_array($var) && isset($var[$keyvar]))
		{
		    $real_var = &$var[$keyvar];
		    $real_name = &$var[$keyname];
		    $type = ucfirst(gettype($real_var));
		    echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
		}
		else
		{
		    $var = array($keyvar => $var, $keyname => $reference);
		    $avar = &$var[$keyvar];
		
		    $type = ucfirst(gettype($avar));
		    if($type == "String") $type_color = "<span style='color:green'>";
		    elseif($type == "Integer") $type_color = "<span style='color:red'>";
		    elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
		    elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
		    elseif($type == "NULL") $type_color = "<span style='color:black'>";
		
		    if(is_array($avar))
		    {
			$count = count($avar);
			echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
			$keys = array_keys($avar);
			foreach($keys as $name)
			{
			    $value = &$avar[$name];
			    $this->do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
			}
			echo "$indent)<br>";
		    }
		    elseif(is_object($avar))
		    {
			echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
			foreach($avar as $name=>$value) $this->do_dump($value, "$name", $indent.$do_dump_indent, $reference);
			echo "$indent)<br>";
		    }
		    elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		    elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
		    elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
		    elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
		    elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
		    else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";
		
		    $var = $var[$keyvar];
		}
	}
}

?>
