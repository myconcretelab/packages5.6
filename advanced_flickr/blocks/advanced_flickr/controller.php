<? defined('C5_EXECUTE') or die(_("Access Denied."));


Loader::library('xml_domit_include','advanced_flickr');

class AdvancedFlickrBlockController extends BlockController {

    protected $btTable = 'btAdvancedFlickr';
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "300";
	
    var $Fomit = array();
    protected $Fuser = "31557983@N02"; // this is your flickr id ex. 78354145@N00
    var $Fapikey = "f9da463cf9d35144d6424cb8e46e5486"; // insert your flickr API key
    var $secret = "6cbce99f13943d00";
    var $tagCount = 150; // This is the limit on how many tags will appear in the tag section. Adjust this if you like.
    var $per_page = 30;
    
 
    public function getBlockTypeDescription() {
      return t("Add a Flickr Gallery");
    }

    public function getBlockTypeName() {
      return t("Advanced Flickr");
    }

    function save($args) {
      parent::save($args);
    }

    function view(){ 
      $this->set('currentPageObject',Page::getCurrentPage());
     // $this->dump($this);
    }

    function makeTagCloud() {
    
	$params = array(
		'api_key'	=> $this->Fapikey,
		'user_id'	=> $this->Fuser,
		'method'	=> 'flickr.tags.getListUserPopular',
		'count'		=> $this->tagCount,
		'format'	=> 'php_serial'
	);	
    	$rsp_obj = $this->getResponseObject($params);
	
	//$this->dump($rsp_obj);
    
	$tags = $rsp_obj['who']['tags']['tag'];
	$total = count($tags);
	  
	$highestTag = 0;
	$lowestTag = 60000;
	$maxFontSize = 40;
	$minFontSize = 7;
	$bright = 140;
	$dark = 200;
	  
	// build tag arrays
	foreach ($tags as $i=>$currTag)  {
		$theTag[$i] = $currTag['_content'];
		$theCount[$i] = $currTag['count'];
	}
	  
	// get highest and lowest count
	  
	for ($i=0; $i<count($theTag); $i++) {
		if ($theCount[$i]>$highestTag) {
			$highestTag=$theCount[$i];
		}
		if ($theCount[$i]<$lowestTag) {
			$lowestTag=$theCount[$i];
		}
	}
	echo "<p>";
	for ($i=0; $i<count($theTag); $i++) {
		// calculate the font size
		$fontOffset = $highestTag-$lowestTag;
		$fontPerc = ($theCount[$i]-$lowestTag)/$fontOffset;
		$fontSize = ($maxFontSize-$minFontSize)*$fontPerc+$minFontSize;
		$fontSize = ceil($fontSize);
		// calculate the color
		$colorOffset = $highestTag-$lowestTag;
		$colorPerc = ($theCount[$i]-$lowestTag)/$colorOffset;
		$fontColor = ($bright-$dark)*$colorPerc+$dark;
		$fontColor = ceil($fontColor);
		echo "<a href=\"#\" onclick=\"searchPhotos('tags','" . $theTag[$i] . "')\" style=\"font-size: ".$fontSize."px; color: rgb(".$fontColor.",".$fontColor.",".$fontColor.");\">".$theTag[$i]."</a> ";
	}
	echo "</p>\n";
	
}
    

    
    function getcollectionsTree () {
	$params = array(
		'api_key'	=> $this->Fapikey,
		'user_id'	=> $this->Fuser,
		'method'	=> 'flickr.collections.getTree',
		'format'	=> 'php_serial'
	);	
    	$rsp_obj = $this->getResponseObject($params);
	
	return $rsp_obj['collections']['collection'];
	
    }
    
    function action_outputCollections () {
	foreach ($this->getcollectionsTree() as $collection) {
	$psIDs = '';
	// echo '<span class="return">'
	    foreach($collection['set'] as $key=>$set ) {
		$separator = (count($collection['set'])-1) == $key ? '' : ',';
		$psIDs.= $set['id'] . $separator;
	    }
	    echo '<a href="#" class="collection-th" onclick="getPhotosets(\''. $psIDs .'\')"><img src="' . $collection['iconsmall'] . '" alt="' . $collection['title'] . '" height="68" width="91"/>';
	    echo '<div class="th_info"><h4>' . $collection["title"] . '</h4><span class="desc">' . htmlentities($collection["desc"]) . '</span></div></a>'; 
	}
	exit;
    }
	
    
    
    
    function getPhotosets ($psIDs = NULL) {
	$params = array(
		'api_key'	=> $this->Fapikey,
		'user_id'	=> $this->Fuser,
		'method'	=> 'flickr.photosets.getList',
		'format'	=> 'php_serial'
	);
   	$rsp_obj = $this->getResponseObject($params);
	

	$psIDs = $psIDs == NULL ? NULL : explode(',',$psIDs);

	// search photoSets inside a collection
	foreach($rsp_obj['photosets']['photoset'] as $key=>$photoSet) :
	    if ($psIDs != NULL) {	    
		foreach ($psIDs as $key_=>$psID) :
		    if($photoSet['id'] == $psID){
			$PhotoSets[$key_]['id'] 	= $photoSet['id'];
			$PhotoSets[$key_]['src'] 	= "http://farm{$photoSet['farm']}.static.flickr.com/{$photoSet['server']}/{$photoSet['primary']}_{$photoSet['secret']}";
			$PhotoSets[$key_]['photos'] 	= $photoSet['photos'];
			$PhotoSets[$key_]['title'] 	= $photoSet['title']['_content'];
			$PhotoSets[$key_]['desc'] 	= $photoSet['description']['_content'];
		    }
		endforeach;
	    } else {
		$PhotoSets[$key]['id'] 	= $photoSet['id'];
		$PhotoSets[$key]['src'] 	= "http://farm{$photoSet['farm']}.static.flickr.com/{$photoSet['server']}/{$photoSet['primary']}_{$photoSet['secret']}";
		$PhotoSets[$key]['photos'] 	= $photoSet['photos'];
		$PhotoSets[$key]['title'] 	= $photoSet['title']['_content'];
		$PhotoSets[$key]['desc'] 	= $photoSet['description']['_content'];
	    }
	endforeach;
	
	return $PhotoSets;	    	    

   }
    
    public function action_outputPhotosets() {
	$size = $_GET['size'] == NULL ? '_s' : $_GET['size'] ;
	foreach($this->getPhotosets($_GET['psIDs']) as $photoSet) :
	    echo '<a href="#" class="photoset-th" onclick="getPhotosetsPhotos(\''. $photoSet['id'] .'\',1)" rel="'. $photoSet['id'] .'"><img src="' . $photoSet['src'] . $size . '.jpg" alt="' . $photoSet['title'] . '" rel="' . $photoSet['id'] . '" width="75" height="75" />';
	    echo '<div class="th_info"><h4>' . $photoSet["title"] . '</h4><span class="desc">' . htmlentities($photoSet["desc"]) . '</span><span class="count">' . $photoSet["photos"] . '</span></div></a>'; 
	endforeach;

	exit;
    }
    
    function action_searchPhotos () {
	$size = $_GET['size'] == NULL ? '_s' : $_GET['size'] ;
	foreach($this->searchPhotos($_GET['type'],$_GET['data']) as $photoSetphoto) :
	    echo '<a href="'. $photoSetphoto['original'] .'" class="photo-th"  rel="prettyPhoto['. $photoSetphoto['id'] .']"><img src="' . $photoSetphoto['src'] . $size . '.' . $photoSetphoto['type'] .'" alt="' . $photoSet['title'] . '" width="75" height="75"  />';
	    echo '<div class="th_info"><h4>' . $photoSet["title"] . '</h4></div></a>'; 
	endforeach;
	exit;
    }

    
    function searchPhotos ($type,$data) {

	$params = array(
		'api_key'	=> $this->Fapikey,
		'user_id'	=> $this->Fuser,
		'method'	=> 'flickr.photos.search',
		'format'	=> 'php_serial',
		$type		=> $data,
		'extras'	=> 'original_format,url_o,views'
	);
	
	$rsp_obj = $this->getResponseObject($params);

	$photos = array();
	
	if ($rsp_obj['stat'] == 'ok'){
	    foreach ($rsp_obj['photos']['photo'] as $key=>$photo) {
		$photos['photo'][$key]['src'] 		= "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}";
		$photos['photo'][$key]['original'] 	= $photo['url_o'];		
		$photos['photo'][$key]['type'] 		= $photo['originalformat'];
		$photos['photo'][$key]['title'] 		= $photo['title'] ;
		$photos['photo'][$key]['views'] 		= $photo['views'] ;
		$photos['photo'][$key]['id'] 		= $psID ;
	    }
	}else{
    	    return false;
	}
	return $photos;

     }


    
    function getPhotosetsPhotos ($psID, $page = 1) {

	$params = array(
		'api_key'	=> $this->Fapikey,
		'method'	=> 'flickr.photosets.getPhotos',
		'photoset_id'	=> $psID,
		'format'	=> 'php_serial',
		'extras'	=> 'original_format,url_o,views',
		'per_page'	=> $this->per_page,
		'page'		=> $page
	);
	
	$rsp_obj = $this->getResponseObject($params);
	
	$photos = array();
	$photos['totalPage'] 	= $rsp_obj['photoset']['pages'];
	$photos['nextPage']	= $page + 1 > $rsp_obj['photoset']['pages'] ? 1 : $page + 1;
	$photos['psID']		= $rsp_obj['photoset']['id'];
		
	if ($rsp_obj['stat'] == 'ok'){
	    foreach ($rsp_obj['photoset']['photo'] as $key=>$photo) {
		$photos['photo'][$key]['src'] 		= "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}";
		$photos['photo'][$key]['original'] 	= $photo['url_o'];		
		$photos['photo'][$key]['type'] 		= $photo['originalformat'];
		$photos['photo'][$key]['title'] 		= $photo['title'] ;
		$photos['photo'][$key]['views'] 		= $photo['views'] ;
		$photos['photo'][$key]['id'] 		= $psID ;
	    }
	}else{
	    $this->dump($rsp_obj);
	    return false;
	}
	//$this->dump($rsp_obj);

	return $photos;
     }

    
    public function action_outputPhotosetsPhotos() {
	$size = $_GET['size'] == NULL ? '_s' : $_GET['size'] ;
	$photosetsPhotos = $this->getPhotosetsPhotos($_GET['psID'], $_GET['page']);
	//$this->dump($photosetsPhotos);
	foreach($photosetsPhotos['photo'] as $photoSetphoto) :
	    echo '<a href="'. $photoSetphoto['original'] .'" class="photo-th"  rel="prettyPhoto[\''. $photoSetphoto['id'] . '_' .  $_GET['page'] . '\']"><img src="' . $photoSetphoto['src'] . $size . '.' . $photoSetphoto['type'] .'" alt="' . $photoSet['title'] . '" width="75" height="75" />';
	    echo '<div class="th_info"><h4>' . $photoSet["title"] . '</h4></div></a>'; 
	endforeach;
	    if ($photosetsPhotos['totalPage'] > 1) {
		// Add navigation for pages
		echo '<div class="photos-navigation"><div class="photos-count"><span class="actual-page">' . $_GET['page'] .'</span><span class="photo-navigation-separator"> / </span><span class="total-page">' . $photosetsPhotos['totalPage'] . '</span></div><a href="javascript:getPhotosetsPhotos(\'' . $photosetsPhotos['psID'] . '\' , ' . $photosetsPhotos['nextPage'] . ')" > Go to page ' . $photosetsPhotos['nextPage'] . '</a></div>';
	    }
	exit;
    }



    function getResponseObject($params) {
	
	$encoded_params = array();
	
	foreach ($params as $k => $v){
	
		$encoded_params[] = urlencode($k).'='.urlencode($v);
	}
	
	$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
	
	$rsp = file_get_contents($url);
	
	return unserialize($rsp);
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
