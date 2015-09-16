<?php  
defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @package Sue theme Options
 * @category Controller
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

Loader::model('theme_sue_options', 'theme_sue');

class SuePresetListAttributeTypeController extends DefaultAttributeTypeController  {

	public function form() {

		$this->set ('name', $this->field('value'));
		$this->set ('poh', new ThemeSueOptions);

		if (is_object($this->attributeValue)) {
			$this->set('selected', $this->getAttributeValue()->getValue());
		} else {
			$this->set('selected', 0);
		}
	}

}