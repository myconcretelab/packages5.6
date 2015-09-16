<?php         
defined('C5_EXECUTE') or die(_("Access Denied."));

class YoutubeFileTypeInspector extends  FileTypeInspector {
    
    	public function inspect($fv) {
            	$path = $fv->getPath();
		//die('ok');
		
                $con = file($path);
		$url = trim($con[0]);
		
		$vID = $this->get_youtube_id($url);

		// set video data feed URL
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $vID;
	    
		// read feed into SimpleXML object
		$entry = simplexml_load_file($feedURL);
		
		// parse video entry
		$video = $this->parseVideoEntry($entry);			

		// Update title & desc with real youtube's infos
		$fv->updateDescription($video->description);
		$fv->updateTitle($video->title);	       
                
		// Define a new attribute youtube_id
		$ft = FileTypeList::getInstance();
		$ft->defineImporterAttribute('youtube_id', t('ID of youtube video '), 'TEXT', true);
		$at1 = FileAttributeKey::getByHandle('youtube_id');
		$fv->setAttribute($at1, $vID);
		
		// Define a new attribute with the watchURL
		$ft->defineImporterAttribute('watchURL', t('Video player URL'), 'TEXTAREA', true);
		$at1 = FileAttributeKey::getByHandle('watchURL');
		$fv->setAttribute($at1, $video->watchURL);



        }
        
        function get_youtube_id($url) {
		$parsed_url = parse_url($url);
		parse_str($parsed_url[query], $parsed_query);
		return $parsed_query[v];
	}
	
	function parseVideoEntry($entry) {      
	      $obj= new stdClass;
	      
	      // get nodes in media: namespace for media information
	      $media = $entry->children('http://search.yahoo.com/mrss/');
	      $obj->title = $media->group->title;
	      $obj->description = $media->group->description;
	      
	      // get video player URL
	      $attrs = $media->group->player->attributes();
	      $obj->watchURL = $attrs['url']; 
	      
	      // get video thumbnail
	      $attrs = $media->group->thumbnail[0]->attributes();
	      $obj->thumbnailURL = $attrs['url']; 
		    
	      // get <yt:duration> node for video length
	      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
	      $attrs = $yt->duration->attributes();
	      $obj->length = $attrs['seconds']; 
	      
	      // get <yt:stats> node for viewer statistics
	      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
	      $attrs = $yt->statistics->attributes();
	      $obj->viewCount = $attrs['viewCount']; 
	      
	      // get <gd:rating> node for video ratings
	      $gd = $entry->children('http://schemas.google.com/g/2005'); 
	      if ($gd->rating) { 
		$attrs = $gd->rating->attributes();
		$obj->rating = $attrs['average']; 
	      } else {
		$obj->rating = 0;         
	      }
		
	      // get <gd:comments> node for video comments
	      $gd = $entry->children('http://schemas.google.com/g/2005');
	      if ($gd->comments->feedLink) { 
		$attrs = $gd->comments->feedLink->attributes();
		$obj->commentsURL = $attrs['href']; 
		$obj->commentsCount = $attrs['countHint']; 
	      }
	      
	      // get feed URL for video responses
	      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
	      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
	      2007#video.responses']"); 
	      if (count($nodeset) > 0) {
		$obj->responsesURL = $nodeset[0]['href'];      
	      }
		 
	      // get feed URL for related videos
	      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
	      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
	      2007#video.related']"); 
	      if (count($nodeset) > 0) {
		$obj->relatedURL = $nodeset[0]['href'];      
	      }
	    
	      // return object to caller  
	      return $obj;      
	    }   

}