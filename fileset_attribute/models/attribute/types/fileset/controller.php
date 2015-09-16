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

	public function getFsObjectValue () {
		Loader::model('file_set');
		$fs = FileSet::getByID($this->getValue);
		return is_object($fs) ? $fs : false;	
	}

	public function getFileListObjectValue () {
		Loader::model('file_set');
		Loader::model('file_list');
		$fs = FileSet::getByID($this->getValue());

		if (is_object($fs)) :
			$fl = new FileList();		
			$fl->filterBySet($fs);
			// Return the FileList Object that can be manipulated later (for pagination, sorting,..)
			return $fl;
		else :
			return false;	
		endif;	
	}
	public function getFilesValue () {
		Loader::model('file_set');
		Loader::model('file_list');
		$fs = FileSet::getByID($this->getValue());


		if (is_object($fs)) :
			$fl = new FileList();		
			$fl->filterBySet($fs);
			$fl->sortByFileSetDisplayOrder();
			return $fl->get(1000);
		else :
			return false;	
		endif;	
	}

}