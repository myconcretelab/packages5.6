<?php 
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('attribute/types/default/controller');

class FilesetAttributeTypeController extends DefaultAttributeTypeController  {

	public function form() {

		Loader::model('file_set');

		$this->set('fileSets', FileSet::getMySets());
		$this->set('name', $this->field('value'));

		if (is_object($this->attributeValue)) {
			$this->set('selected', $this->getAttributeValue()->getValue());
		} else {
			$this->set('selected', 0);
		}
	}

}