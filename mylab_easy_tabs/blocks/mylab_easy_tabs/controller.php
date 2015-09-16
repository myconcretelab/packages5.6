<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));

class MylabEasyTabsBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btMylabEasyTabs';
	protected $btInterfaceWidth = "650";
	protected $btInterfaceHeight = "400";
	
	public $mst_skins = array('skin1','skin2','skin3','skin4','skin5','skin6','skin7','skin8','skin9','skin10','skin11','skin12');
	public $mst_effects = array('basic_display','simple_fade','hide_and_seek','evanescence','transfading_down','transfading_up','overlapping','slide_right','slide_left','slide_up','fade_slide_left','fade_slide_right','fade_slide_up','fade_slide_down','horizontal_bouncer','vertical_bouncer','fireworks','puff');
	public $mst_positions = array('top','bottom','left','right');

	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
		
	public function on_page_view() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('jquery.ui.js'));		
		
	}
	
	public function getBlockTypeDescription() {
		return t("Transform easily your C5 layouts into tabs");
	}
	
	public function getBlockTypeName() {
		return t("Easy Tabs");
	}
	public function getJavaScriptStrings() {
	return array(
		'position-required' => t('You are multiple layout in your Area, please choose a position'),
		'tName-required' => t('Oops, your are forgot to set some titles for tabs'),
	);
	}
	public function addKeyToArray ($array) {
		if (is_array($array)) {
			$return = array();
			foreach ($array as $k) {
				$return[$k] = $k;
			}
			return $return;
		}
	}
	
	
	function view() {
		$data = $this->getTabsArray();
		$this->set('data', $data);
		$this->set('dl',  count($data)-1);
		$this->set('block_url', $this->get_block_url());
	}
	function get_block_url() {
		$bv = new BlockView();
		$bv->setBlockObject($this->getBlockObject());		
		return $bv->getBlockURL();
	}
	function edit() {
		$this->edit_utilities ();
		$this->check_is_editable();
		if (!$this->mst_position) $this->add();
	}
	function add() {
		$this->edit_utilities ();
		$this->check_is_editable();
		$this->set('mst_position', 'top');
		$this->set('mst_effect', 'slide_up');
		$this->set('mst_skin', 'skin4');
	}
	
	
	
	function edit_utilities () {
		$cID = $_REQUEST['cID'];
		$ar = $_REQUEST['arHandle'];
		global $c;
		$cvID = $c->vObj->getVersionID();
		$CollectionVersionAreaLayout = $this->getCollectionVersionAreaLayout ($cID, $cvID, $ar);

		$this->set('rows',$this->getNumberRows($CollectionVersionAreaLayout['layoutID']));
		$this->set('names', explode('||', $this->tName));
		$this->set('fIDs', explode('||', $this->fID));
		$url= Loader::helper('concrete/urls');
		$this->set('al', Loader::helper('concrete/asset_library'));
		$this->set('tools_url', $url->getToolsURL('options','mylab_easy_tabs'));
		$this->set('ah', Loader::helper('concrete/interface'));
		$this->set('form', Loader::helper('form'));
		$html = Loader::helper('html');
		// $this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));
	}
	function check_is_editable() {
		$this->cleanAreaHandle($_REQUEST['arHandle']) or exit ('This block need to create Layout First');
	}
	function delete(){
	}
	
	function isViewError($a) {
		if ( is_object($a)) :
			if ($this->cleanAreaHandle($a->getAreaHandle())) :
					return false; // it is ok		
			else : return "Ooops, i think that you forgot to create layout first..";		
			endif;
		else : return 'Please Reload the page.';
		endif;
		
	}
	
	public function cleanAreaHandle ($ah,$actual = false) {
		if ( ($areaN = strpos($ah,' :')) !== false) { // ok, there are a ': Layout n : Cell n'
			$ar = substr($ah, 0, $areaN);	
			preg_match_all("/Layout [0-9]+ : Cell [0-9]+/", $ah, $deep );
				for ($n = 0 ; $n < (count($deep[0])-1) ; $n++) {
					$ar .= " : " . $deep[0][$n];
				}
			if (!$actual) {
				return $ar;				
			} elseif ($actual === true) {
				$a = $deep[0][count($deep[0])-1];
				// The Layout number
				return (int)substr($a,7,2);
			}
		} else {
			return false;
		}
		
	}
	
	public function getCollectionVersionAreaLayout ($cID, $vID, $areaHandle) {	
		$vals = array( $cID, $vID, $this->cleanAreaHandle($areaHandle), $this->cleanAreaHandle($areaHandle, true));
		$sql = 'SELECT * FROM CollectionVersionAreaLayouts WHERE cID=? AND cvID=? AND arHandle=? AND areaNameNumber=? ORDER BY position ASC, cvalID ASC';
		$CollectionVersionAreaLayout = $this->db->getRow($sql,$vals);		
		
		return $CollectionVersionAreaLayout;
	}

	public function getLayoutID ($arHandle) {
		$vals = array( intval($this->c->cID), $this->c->getVersionID(), $this->cleanAreaHandle($arHandle), $this->position );
		$sql = 'SELECT cvalID FROM CollectionVersionAreaLayouts WHERE cID=? AND cvID=? AND arHandle=? AND position=?';
		$lID = $this->db->getAll($sql,$vals);
		return $lID[0]['cvalID'];
		
		
	}
	
	public function getNumberRows ($lID) {
		$vals = array($lID);
		$sql = 'SELECT layout_rows FROM Layouts WHERE layoutID=?';
		$rows = $this->db->getAll($sql,$vals);
		if ( ($row = intval($rows[0]['layout_rows'])) > 1) {
			return $row;
		}

	}
	public function getTabsArray() {

		Loader::library('file/types');
		$ih = Loader::helper('image');
		$names = explode("||",$this->tName);
		$fIDs = explode("||",$this->fID);

		Loader::model('file');
		$i = Loader::helper('image');

		$v = array();
		$cc = 0;

		foreach ($names as $k=>$n){
		  if (intval($fIDs[$k]) > 0 ) :
			$img = $test = File::getByID($fIDs[$k]);
			$fv = $img->getExtension();
			$ft = FileTypeList::getType($fv);
			$img = $ft->type == 1 ?  $img : false;  
		  else :
			$img = false;
		  endif;
		$v[$cc]['name'] 		= $n;
		$v[$cc]['src']			= $img ? $ih->getThumbnail($img,100,100)->src : false;
		$cc ++;
		}
		return $v;
	}
	
	function save ($data) {
		
		$data['tName'] 	= implode('||',$data['tName']);
		$data['fID'] 	= implode('||',$data['fID']);
		parent::save($data);

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
