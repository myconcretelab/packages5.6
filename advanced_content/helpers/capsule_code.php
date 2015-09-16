<?php defined('C5_EXECUTE') or die("Access Denied.");
class CapsuleCodeHelper {

    protected $content;
    protected $code;
    protected $atts;
    protected $tagregexp = '[a-z0-9A-Z_]*';
    protected $options_default = array('type' => 'text', 'required' => false);
    protected $options_codes = array('t' => 'text', 'b' => 'boolean', 'n' => 'number', 's' => 'stack', 'p' => 'page', 'f' => 'file', 'i' => 'image', 'u' => 'user', 'c' => 'color', 'fs' => 'fileset', 'pa' => 'page_attribute', 'fa' => 'file_attribute', 'mp3' => 'mp3', 'mov' => 'mov', 'separator' => 'separator');


    function __construct() {
        $this->corecaps = $this->dirToArray(DIR_PACKAGES . '/' . 'advanced_content' . '/' . DIRNAME_LIBRARIES . '/' . 'capscodes');
        $this->usercaps = $this->dirToArray(DIR_LIBRARIES . '/' . 'capscodes');
    }


    public function do_capscode($content) {
        //print_r(CapsuleCodeHelper::dirToArray(DIR_PACKAGES . '/' . 'advanced_content' . '/' . DIRNAME_LIBRARIES . '/' . 'capscodes'));
        $pattern = $this->get_capscode_regex();
        $content = preg_replace('/<p[^>]*>\[/', '[', $content); // Remove the start <p> or <p attr="">
        $content = preg_replace('/]<\/p>/', ']', $content); // Replace the end
        return preg_replace_callback('/' . $pattern . '/s', Array($this, 'do_capscode_tag'), $content);
    }


    /*
    * The regular expresion contains 6 different sub matches to help with parsing.
    *
    * 1/6 - An extra [ or ] to allow for escaping shortcodes with double [[]]
    * 2 - The capscode name
    * 3 - The capscode argument list
    * 4 - The self closing /
    * 5 - The content of a capscode when it wraps some content.
    * */


    private function get_capscode_regex() {
        return '(.?)\[(' . $this->tagregexp . ')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
    }
    // Return false if class doesn't exist


    private function include_tag_class($tag) {
        $corecategory = $this->search_category($this->corecaps, $tag);
        $usercategory = $this->search_category($this->usercaps, $tag);
        // Check if is a package associate
        if ($usercaps || $usercategory) {
        }
        if ($usercategory !== false) {
            if (substr($usercategory, 0, 7) == 'package') {
                if (!is_object(BlockType::getByHandle(substr($usercategory, 8)))) return false;
            }
            Loader::library('capscodes/' . $usercategory . $tag);
            return $this->tag_to_class($tag);
        } elseif ($corecategory) {
            if (substr($corecategory, 0, 7) == 'package') {
                if (!is_object(BlockType::getByHandle(substr($corecategory, 8)))) return false;
            }
            Loader::library('capscodes/' . $corecategory . $tag, 'advanced_content');
            return $this->tag_to_class($tag);
        } else {
            return false;
        }
    }


    private function search_category($arraycaps, $tag) {
        foreach($arraycaps as $categoryID => $category) {
            if (!is_array($category) && $categoryID == $tag) return '' ;
            if (!is_array($category)) continue;
            if (array_key_exists($tag, $category)) return  $categoryID  . '/';
        }
        return false;
    }



    private function tag_to_class($tag) {
        return 'Capscode' . Object::camelcase($tag);
    }


 
    private function do_capscode_tag($m) {
        // allow [[foo]] syntax for escaping a tag
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }
        $tag = $m[2];
        $atts = $this->capscode_parse_atts($m[3]);
        $Class = $this->include_tag_class($tag);
        if (!class_exists($Class)) return $m[0];
        if (isset($m[5])) $content = $m[5];
        else $content = null;
        $Class = $Class::init($atts, $content, $tag, $Class);
        if (Page::getCurrentPage()->isEditMode() && $Class->hiddenOnEditMode )return '<div class="ccm-edit-mode-disabled-item"><div style="padding: 20px 0px 20px 0px">'. t('Disabled on edit mode') . '</div></div>';
        return $m[1] . $Class->build_html() . $m[6];
    }


  
    function capscode_parse_atts($text) {
        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach($match as $m) {
                if (!empty($m[1])) $atts[strtolower($m[1]) ] = stripcslashes($m[2]);
                elseif (!empty($m[3])) $atts[strtolower($m[3]) ] = stripcslashes($m[4]);
                elseif (!empty($m[5])) $atts[strtolower($m[5]) ] = stripcslashes($m[6]);
                elseif (isset($m[7]) and strlen($m[7])) $atts[] = stripcslashes($m[7]);
                elseif (isset($m[8])) $atts[] = stripcslashes($m[8]);
            }
        } else {
            //$atts = ltrim($text);
            return array(); // Remplace le prÃ©cÃ©dent pour eviter l'erreur fatale du foreach
            
        }
        return $atts;
    }


  
    static function init($atts, $content = null, $tag, $class) {
        // $atts : attributs premier niveau
        // $tag : le nom du capscode
        // $content : Ce qui a dans le premier niveau
        //$content = preg_replace('/\[\[/', "[", $content); // Replace the end
        //$content = preg_replace('/\]\]/', "]", $content); // Replace the end
        $cc = new $class;
        $cch = new CapsuleCodeHelper;
        $cc->merge_atts($atts);
        $cc->set_attributes($atts);
        $cc->set_content($cch->do_capscode($content));
        $cc->set_code($tag);
        $cc->set_enclosing_tag(CapsuleCodeHelper::parse_enclosing_tag($content, $tag));
        //$cc->get_tag_options($cc->cpsCode);
        return $cc;
    }


  
    function parse_enclosing_tag($content, $tag) {
        $tag = substr($tag, 0, -1);
        if (preg_match_all("/(.?)\[($tag)\b(.*?)(?:(\/))?\](?:(.+?)\[\/$tag\])/s", $content, $matches)) {
            # [0] : Un tableau avec chaque sous niveau ([tab disabled="true" title="toto"]Content of the tab here[/tab])
            # [2] : Un tableau avec chaque nom de tag
            # [3] : un tableau avec la ligne d'options (disabled="true" title="toto");
            # [5] : Un tableau ave le contenu de chaque tab
            $return = array();
            foreach($matches[3] as $key => $value) {
                //var_d
                $return[$key] = array();
                foreach(CapsuleCodeHelper::capscode_parse_atts($matches[3][$key]) as $id => $value) { // Dangeureux car les options ne peuvent pas Ãªtre ni 'content' ni 'tag'
                    $return[$key][$id] = $value;
                }
                $cc = new CapsuleCodeHelper;
                $return[$key]['content'] = $cc->do_capscode($matches[5][$key]);
            }
            //print_r($return);
            return $return;
        } else {
            return array();
        }
    }
  


    function merge_atts($atts) {
        $atts = (array)$atts;
        //var_dump($atts);
        foreach($atts as $name => $value):
            if (is_int($name) && $value != ''):
                $this->$value = true; // Si c'est juste le nom ('top' au lieu de top="true")
                else:
                    $this->$name = $value;
                endif;
            endforeach;
            //var_dump($this);
            
        }



    function set_content($content = null) {
        $this->content = $content;
    }
    function set_code($code = null) {
        $this->code = $code;
    }
    function set_attributes($atts = null) {
        $this->atts = $atts;
    }
    function set_enclosing_tag($enclosing_tag = null) {
        $this->enclosing_tag = $enclosing_tag;
    }
    private function strip_capscodes($content) {
        $pattern = $this->get_capscode_regex();
        return preg_replace('/' . $pattern . '/s', '$1$6', $content);
    }



    // Used to create form
    public function get_tag_options($obj) {

        $cpsCode = $obj->get_capscode();
        $samplecontent = $obj->samplecontent ? $obj->samplecontent : t('Add your content here');
        $pattern = $this->get_capscode_regex();
        
        preg_match_all('/' . $pattern . '/s', $cpsCode, $match);
        
        $attr1 = $this->capscode_parse_atts($match[3][0]); // Les attributs du premier niveau
        if ($attr1) $options1 = array_map(Array($this, 'attribute_to_options'), array_keys($attr1), array_values($attr1));
        // niveau encapsulÅ½
        if (preg_match_all('/' . $pattern . '/s', $match[5][0], $match2)):
            $attr2 = ($this->capscode_parse_atts($match2[3][0]));
            if (is_array($attr2)) $options2 = array_map(Array($this, 'attribute_to_options'), array_keys($attr2), array_values($attr2));
        endif;
        return array('options_level_1' => $options1, 'options_level_2' => $options2, 'samplecontent' => $samplecontent);
    }
 


    public function attribute_to_options($attr, $value) {
        $return = array();
        // Extract # foo #
//var_dump($value);
        if (preg_match('/#(.*)#/i', $value, $match)) $value = str_replace($match[0], '', $value);
        if (preg_match('/_(.*)_/i', $value, $match_title)) $value = str_replace($match_title[0], '', $value);;
       
        
        $return['description'] = $match[1] ? $match[1] : t('');
        $value = str_replace(' ', '', $value);
        $opts = (explode('-', $value));
        array_shift($opts); // le [0] est toujourds vide
        $return['title'] = ($match_title[1]) ? $match_title[1] : $attr; // Donne la possibilité de traduire le nom de l'input
        $return['capsID'] = $attr;
        $return['required'] = in_array('r', $opts) ? 'true' : 'default';
        $typearray = array_intersect_key(($this->options_codes), array_flip($opts));
        $valuetypearray = array_values($typearray);
        $return['type'] = $valuetypearray[0];
        // Select input
        $select = preg_grep('/^s:/', $opts);
        if (count($select)) {
            $options = (explode('|', $select[0]));
            array_shift($options); // le [0] est toujourds 's:'
            $return['type'] = 'select';
            $return['options'] = $options;
        }
        if (is_object($this->obj)) {
            $return['default'] = $this->obj->$attr;
        }
        return $return;
    }
  

    function get_available_caps() {
        $interns = CapsuleCodeHelper::scan_available_caps(DIR_PACKAGES . '/' . 'advanced_content' . '/' . DIRNAME_LIBRARIES . '/' . 'capscodes');
        ksort($interns);
        return array_merge(CapsuleCodeHelper::scan_available_caps(DIR_LIBRARIES . '/' . 'capscodes'), $interns);
    }
  


    function scan_available_caps($dir) {
        $full_caps = array();
        foreach(CapsuleCodeHelper::dirToArray($dir) as $category => $files) {
            if (is_array($files)) {
                if (substr($category, 0, 7) == 'package') {
                    $package = Package::getByHandle(substr($category, 8));
                    if (!is_object($package)) continue;
                }
                foreach($files as $caps => $name) {
                    Loader::library('capscodes' . DIRECTORY_SEPARATOR . $category . DIRECTORY_SEPARATOR . $caps, 'advanced_content');
                    if (class_exists($capsclass = $this->tag_to_class($caps))) {
                        $obj = new $capsclass;
                        $this->obj = $obj;
                        if (method_exists($obj, 'get_capscode')) {
                            if ($obj->get_capscode()) {
                                $full_caps[$category][$caps] = CapsuleCodeHelper::get_tag_options($obj);
                            }
                        }
                    }
                }
            }
        }
        //print_r($full_caps);
        return $full_caps;
    }
  

    function file_dir($path, $ext = 'php') {
        if ($handle = @opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (substr($entry, -3, 3) == $ext) {
                        $files[substr($entry, 0, -4) ] = str_replace('_', ' ', ucfirst(substr($entry, 0, -4)));
                    }
                }
            }
            closedir($handle);
            return $files;
        } else {
            return array();
        }
    }




    static function dirToArray($dir, $ext = 'php') {
        $contents = array();
        # Foreach node in $dir
        if(!is_dir($dir)) return $contents; 
        foreach(scandir($dir) as $node) {
            # Skip link to current and parent folder
            if ($node == '.') continue;
            if ($node == '..') continue;
            # Check if it's a node or a folder
            if (is_dir($dir . DIRECTORY_SEPARATOR . $node)) {
                # Add directory recursively, be sure to pass a valid path
                # to the function, not just the folder's name
                $contents[$node] = CapsuleCodeHelper::dirToArray($dir . DIRECTORY_SEPARATOR . $node);
            } else {
                if (substr($node, -3, 3) != $ext) continue;
                # Add node, the keys will be updated automatically
                $contents[substr($node, 0, -4) ] = str_replace('_', ' ', ucfirst(substr($node, 0, -4)));;
            }
        }
        # done
        //var_dump($contents);
        return $contents;
    }
    };
    