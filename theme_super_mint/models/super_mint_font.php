<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));


class GoggleFontObject extends Object {	

	// Ce helper est censé servir coté page, 
	// Il faudrait lui envoyer un pID si on veut l'utiliser coté dashboard

	var $weight = array('regular');
	var $weightconversion = array('regular' => 'normal');
	var $style = array('italic');
	var $pregstyle = '/(?:italic|regular|\d+)/';

	function __construct ($tag) {

		$this->tag = $tag;
		// On ajouytre a cet objet le nom des ses valeur en DB
		$this->setInputName();
		// On lui ajoute ses valeurs prises de la DB
		$this->setFontInfo();

	}
	function setInputName () {
		$this->fontName = $this->getFontName();
		$this->subsetName = $this->getSubsetName();
		$this->variantName = $this->getVariantName();
		$this->sizeName = $this->getSizeName();
		$this->uppercaseName = $this->getUppercaseName();
	}

	function setFontInfo () {
		Loader::model('theme_super_mint_options', 'theme_super_mint');
		$o = new ThemeSuperMintOptions(Page::getCurrentPage());
		// Le nom avec le "+"
		$this->font = $o->{$this->fontName};
		// Le nom sans le "+"
		$this->cleanfont =str_replace('+', ' ', $this->font);
		// Le tableau des subset choisis
		$this->subset = explode(',' ,  $o->{$this->subsetName});
		// Le tableau des variants choisis
		$this->variant = explode(',' , $o->{$this->variantName});
		// SI cette police doit s'afficher en uppercase
		$this->upp = $o->{$this->uppercaseName}('fonts');
		// la taille minimale acceptées des fontes
		$size_minimum = $o->_size_minimum;
		// Sa taille en regular
		$this->normalsize = $o->{$this->sizeName};
		// Sa taile en Wide
		$this->widesize = $this->calculateSizeRatio($this->normalsize, $o->_wide_ratio, $size_minimum, '*');
		// Sa taile en 724
		$this->tabletsize = $this->calculateSizeRatio($this->normalsize,  $o->_w724_ratio, $size_minimum, '/'); 
		// Sa taille en width 100%
		$this->fullsize = $this->calculateSizeRatio($this->normalsize,  $o->_full_ratio, $size_minimum, '/'); 
		
	}

	function getFontName () {
		return '_' . $this->tag . '_font';
	}
	function getSubsetName () {
		return  '_' . $this->tag . '_subset';
	}
	function getVariantName () {
		return '_' . $this->tag . '_variants';
	}
	function getSizeName () {
		return '_' . $this->tag . '_size';
	}
	function getUppercaseName () {
		return '_' . $this->tag . '_upp';
	}

	function calculateSizeRatio ($normal,$ratio,$min,$op) {
		switch ($op) {
			case '/': $s = $normal / $ratio; break;
			case '*': $s = $normal * $ratio; break;			
			default: $s = $normal * $ratio;	break;
		}
		return intval($s < $min ? $min : $s);
	}

	function getFamilyCss () {
		if ($this->font) :
			// Le nom de la famille
			$str = "font-family:'$this->cleanfont', sans;\n";
			// Le mode uppercase ou non
			$str .= "\ttext-transform:" . ($this->upp ? 'uppercase' : 'none') . " !important;\n";
			$css = array();
			// On va tourner dans les différentes variantes selectionné
			// Normalement il y ne a qu'une !
			foreach ($this->variant as $variant) :
				// On decortique si jamais il y a 300italic ou juste italic ou juste regular ou 400..
				preg_match_all($this->pregstyle, $variant, $matches, PREG_OFFSET_CAPTURE);
				// On trourne dans les decortiqué genre [0] italic, [1] 300 ..
				foreach ($matches[0] as $match) :
					// on regarde a qui appartient ce style  Si c'est 300 ou regular
					if (in_array($match[0], $this->weight)) $css['weight'][$this->weightconversion[$match[0]]] = '';
					if (is_numeric($match[0])) $css['weight'][$match[0]] = '';
					if (in_array($match[0], $this->style)) $css['style'][$match[0]] = '';
				endforeach;
				
			endforeach;
//			print_r($css);
			// Maintenant on va composer !
			foreach ($css as $cssName => $valueArray) :
				foreach ($valueArray as $value => $empty) :
					$str .= "\tfont-$cssName : $value;\n";
				endforeach;
			endforeach;
			return $str;
		endif;
	}



}

class SuperMintFontList {

	var $googleUrl = "http://fonts.googleapis.com/css";
	var $subsetUrl = "subset";
	var $familyUrl = "family";

	function __construct () {
		$this->list = array();
		$this->time_start = microtime(true);
	}

	function addFont ($tag) {
		$font = new GoggleFontObject($tag);
		if ($font->font):
			foreach ($font->subset as $key => $subset) {
				$this->list[$font->font]['subset'][$subset] = '';
			}
			foreach ($font->variant as $key => $variant) {
				$this->list[$font->font]['variant'][$variant] = '';
			}
		endif;
	}

	function getCssUrlFromList () {
		if (!is_array($this->list) || !count($this->list)) return;
		$str = array();
		$subsets = array();
		//Cache::set('fontList','selectedFont',$this);
		// On traverse otutes les fontes ajoutées à la liste
		foreach ($this->list as $font => $fontArray) {
			if (!$font) continue;
			$str[$font] = 	$font . ':' . implode(',', array_keys($fontArray['variant']));
			foreach ($fontArray['subset'] as $sub => $value) :
				$subset[$sub] = '';
			endforeach;
			
		}
		$time_end = microtime(true);
		$time = $time_end - $this->time_start;
		$str = 	$this->googleUrl .
				'?' . $this->familyUrl . '=' . implode('|', $str) . 
				'&' . $this->subsetUrl . '=' . implode(',', array_keys($subset)) .
				''; //'&generatedTime=' . $time;


		return $str;
	}

}