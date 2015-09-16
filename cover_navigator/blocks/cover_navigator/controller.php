<?php         
defined('C5_EXECUTE') or die(_("Access Denied."));

class CoverNavigatorBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btCoverNavigator';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "550";
	
	public $checked_clients = array();

	
	function on_start() {		
		
	}
			
	public function getBlockTypeDescription() {
		return t("");
	}
	
	public function getBlockTypeName() {
		return t("Cover Navigator");
	}
	
	public function getJavaScriptStrings() {
		return array(
		);
	}
	
	function add () {
		$this->set_variables();
		$this->set_helpers();

	}
		
	function edit() {
		$this->set_variables();
		$this->set_helpers();
	}
	
	function set_variables() {
		loader::model('file_set');
		$ms = FileSet::getMySets();
		$cat_fileset = array();
		foreach($ms as $fs) :
			if (substr($fs->getFileSetName(),0,4) == 'cat_' ) :
				$cat_fileset[$fs->getFileSetID()]  = ucfirst(substr($fs->getFileSetName(),4)) ;
			endif;
		endforeach;
		$this->set('cat_fileset', $cat_fileset);
		$this->set('selected_fileset', explode(',',$this->selected_fileset));
	}
	
	private function set_helpers() {
		Loader::model('file_attributes');
		$this->set('ah', Loader::helper('concrete/interface'));
		$th = Loader::helper('concrete/urls'); 
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('cover_navigator')));

	}



	public function on_page_view() {
		$html = Loader::helper('html');
		$th = Loader::helper('concrete/urls');
		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());
		$page = Page::getCurrentPage();
		$this->addHeaderItem('<!--[if IE]><script src="' . $bv->getBlockURL() . '/additional_js/excanvas.compiled.js"></script><![endif]-->');

	}

	function retrieve_clients ($json = false) {
		Loader::model('file_list');
		loader::model('file_set');
		
		$clients = new FileList();
		$clients->filterByAttribute('tagged_list',true);
		$clients = $clients->get(1000);
	
		$selected_fileset = explode(',',$this->selected_fileset);
		$checked_clients = array(); // Les clients qui ont un lien avec des mŽdias
		$relation = array();


		foreach ($clients as $c) : // pour chaque client
			$relation = new FileList();
			$relation->filterByClientRelation($c->getFileID());	// Ne garder que ceux qui on un lien avec ce client
			$relation = $relation->get(100);
			if (count($relation)) :	
				foreach($relation as $r) : // Pour chaque fichier de ce client
					foreach($selected_fileset as $k=>$sfs): // tri depuis les filesets choisis
						$fs = FileSet::getByID($sfs);
						if ($r->inFileSet($fs)) :
							$checked_clients[] = $c->getFileID(); // ne garder que si il appartient au fileset/
							continue 3;
						endif;
					endforeach;
				endforeach;					
			endif;
		endforeach;				
		
		// Maintenant on a un tableau de fIDs avec des doublons. Du au fait que l'utilisateur demande peut-tre plusieurs catŽgories.
		// DOns on supprime les doublons avec array_unique() et on reconstruit un tableau d'objets plut™t que d'IDs
		$r = array();
		foreach ( array_unique($checked_clients) as $fID) : 
			$r[] = File::getByID($fID);
		endforeach;
		
		
		if ($json) {
			echo json_encode($r);
			exit;
		} else {
			return $r;
		}
	}
	function view() {
		$th = Loader::helper('concrete/urls');

		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());

		//$this->set('covers', $this->retrieve_clients());
		$this->set('i' ,  Loader::helper('image'));
		$this->set('mp3_player_url', $th->getToolsURL('get_mp3_player', 'cover_navigator'));
		$this->set('block_url', $th->getBlockTypeAssetsURL(BlockType::getByHandle('cover_navigator')));
		$this->set('gallery_url', $th->getToolsURL('get_gallery', 'cover_navigator'));

	}
	
	function action_retrieve_clients () {
		$i = Loader::helper('image');
		$result = array();
		foreach($this->retrieve_clients() as $k=>$c) :
			$result[$k] = array();
			$result[$k]['src'] = $i->getThumbnail($c,100,100)->src;
			$result[$k]['title'] = $c->getTitle();
			$result[$k]['fID'] = $c->fID;
		endforeach;
		echo json_encode($result);
		exit;
	}
	
	function action_load_players () {
		$temps_debut = microtime(true);
		Loader::model('file');
		Loader::model('file_list');
		loader::model('file_set');
		Loader::library('file/types');
		$i = Loader::helper('image');
		
		$t = array();

//		$checked_clients = $this->retrieve_clients();
		$temps_fin = microtime(true);
		$t['time'] = round($temps_fin - $temps_debut, 4);
		
		$medias = new FileList();
//		$medias->filterByClientRelation($checked_clients[$_POST['index']]->getFileID());
		$medias->filterByClientRelation($_POST['fID']);
		$medias = $medias->get(100);
		
		// $this->dump($medias);
		
		if (count($medias)) :
			
			foreach($medias as $k=>$m) :
				$fv = $m->getExtension();
				$ft = FileTypeList::getType($fv);
				if ($ft->type == 4) : // audio
					$t['medias'][$k] = array();
					$t['medias'][$k]['type'] = 'mp3';
					$t['medias'][$k]['relativePath'] = $m->getRelativePath();
					$t['medias'][$k]['thumb'] = $m->getAttribute('file_thumbnail') ? $i->getThumbnail($m->getAttribute('file_thumbnail')->getPath(),100,100)->src : null;						
				elseif ($ft->type == 3) : // Text -> Youtube
					$t['medias'][$k] = array();
					$t['medias'][$k]['type'] = 'youtube';
					$t['medias'][$k]['youtube_id'] = $m->getAttribute('youtube_id');						
				endif;
					$t['medias'][$k]['description'] = $m->getDescription();
					$t['medias'][$k]['title'] = $m->getTitle();
					$t['medias'][$k]['fID'] = $m->getFileID();
					$t['medias'][$k]['cat'] = array();
					$fsa = $m->getFileSets();
					foreach ($fsa as $fso) :
						$t['medias'][$k]['cat'][] = ucfirst(substr($fso->getFileSetName(),4));
					endforeach;

			endforeach;
		endif;
		$l = File::getByID($_POST['fID'])->getApprovedVersion();
		$t['client'] = array();
		$t['client']['relativePath'] 	= $i->getThumbnail($l->getPath(),100,100)->src;
		$t['client']['title'] 		= $l->getTitle();
		$t['client']['description'] 	= $l->getDescription();

		$t['count_client'] 	= count($medias);
		
		//echo 'test';
		//echo'<pre>';
		//print_r( $t);
		echo json_encode($t);

		exit;

	}
	
	
	
	private function getFileFieldValue($f,$handle) {
	if(!is_object($f)) {
		return false;
	}
	$value = "";
	switch($handle) {
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
	function save ($data) {
		
		$data['selected_fileset'] =  is_array($data['selected_fileset']) ? implode(',',$data['selected_fileset']) : $data['selected_fileset'];
		parent::save($data);

	}
	
	
	public function php2js ($var) {
	    if (is_array($var)) {
		$res = "[";
		$array = array();
		foreach ($var as $a_var) {
		    $array[] = $this->php2js($a_var);
		}
		return "[" . join(",", $array) . "]";
	    }
	    elseif (is_bool($var)) {
		return $var ? "true" : "false";
	    }
	    elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
		return $var;
	    }
	    elseif (is_string($var)) {
		return "\"" . addslashes(stripslashes($var)) . "\"";
	    }
	    return FALSE;
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
