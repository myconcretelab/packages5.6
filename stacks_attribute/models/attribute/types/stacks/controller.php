<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class StacksAttributeTypeController extends DefaultAttributeTypeController  {
	
	public function form() {

		$this->load();
		
		if ($this->display_type == 'item_list' && $this->display_stacks ) {
			$this->set('list', $this->get_blocks_from_stacks($this->display_stacks));
			$this->set('type','block');
			$this->set('key','bID');
			$this->set('value','name');
		} elseif ($this->display_type == 'stacks_list' || $this->display_type == 'stacks_list_global' || $this->display_type == 'stacks_list_user') {
			$filter = substr($this->display_type,12);
			$this->set('list', $this->get_available_stacks($filter));			
			$this->set('type','stacks');
			$this->set('key','stID');
			$this->set('value','name');
		} else {
			
		}
		$this->set('name', $this->field('value'));

		if (is_object($this->attributeValue)) {
			$this->set('selected', $this->getAttributeValue()->getValue());
		} else {
			$this->set('selected', 0);
		}
	}
	
	private function get_available_stacks ($filter = false) {
		
		Loader::model('stack/list');
		$stm = new StackList();
		if ($filter):
			switch($filter) :
				case 'global':
					$stm->filterByGlobalAreas();					
					break;
				case 'user':
					$stm->filterByUserAdded();
					break;
				default: break;
			endswitch;
		endif;
		$stacks = $stm->get();
		
		foreach ($stacks as $k=>$stack) :
			$st[] = array();
			$st[$k]['name'] = $stack->vObj->cvName ;
			$st[$k]['stID'] = $stack->cID;
		endforeach;
		
		if (count($stacks)) return $st;
		else return t('No Stacks available');
	}

	private function get_blocks_from_stacks ($stID, $cvID = 'RECENT') {

		$stack = Stack::getByID($stID, $cvID);
		$p = new Permissions($stack);
		if ($p->canRead()) {
			$blocks = $stack->getBlocks();
			foreach($blocks as $b) {
				$bp = new Permissions($b);
				if ($bp->canRead()) {
					$btc[] = $b;
					
				}
			}
			$blocks = array();
			foreach ($btc as $k=>$b) :
				$blocks[$k] = array();
				$place = $k +1;
				$blocks[$k]['name'] = "place : $place  - type : $b->btHandle";
				$blocks[$k]['bID'] = $b->bID; // The block ID
			endforeach;
			return $blocks;
		}

		if (count($btc)) return $btc;
			else return t('No blocks into stacks');
		
	}		
	protected function load() {
		$ak = $this->getAttributeKey();
		if (!is_object($ak)) {
			 $this->set('display_type', 'stacks_list');
			return false;
		}
		
		$this->display_type = Config::get('STACKS_KEY_' . $ak->getAttributeKeyID() .'_TYPE');
		if (!$this->display_type) $this->display_type = 'stacks_list';
		if ($this->display_type =='item_list') {
			$this->display_stacks = Config::get('STACKS_KEY_' . $ak->getAttributeKeyID() .'_STACKS');
			$this->set('display_stacks', $this->display_stacks);			
		}
		$this->set('display_type', $this->display_type);
	}

	public function type_form() {
		$this->load();
		$this->set('availableStacks', $this->get_available_stacks());
		
	}
	
	public function saveKey($data) {
		$ak = $this->getAttributeKey();
		$db = Loader::db();
		$display_type = $data['display_type'];
		
		Config::save ('STACKS_KEY_' . $ak->getAttributeKeyID() .'_TYPE' , $display_type);
		if ($display_type == 'item_list') Config::save ('STACKS_KEY_' . $ak->getAttributeKeyID() .'_STACKS' , $data['display_stacks']);
	}
	
	public function duplicateKey($newAK) {
		Config::save ('STACKS_KEY_' . $newAK->getAttributeKeyID() .'_TYPE' , $this->display_type);
		Config::save ('STACKS_KEY_' . $newAK->getAttributeKeyID() .'_STACKS' , $this->display_type);

	}

	public function deleteKey() {
		Config::clear ('STACKS_KEY_' . $this->getAttributeKey()->getAttributeKeyID() .'_TYPE' , $this->display_type);
		Config::clear ('STACKS_KEY_' . $this->getAttributeKey()->getAttributeKeyID() .'_STACKS' , $this->display_type);
		
		parent::deleteKey();
	}
	

}