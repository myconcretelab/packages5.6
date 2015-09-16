<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package SuperMint theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

 
class PageListHelper {
	public function output_page_blocks($collectionObject, $areaHandle = 'Main', $maxBlocks = null, $blockWrapperStart = '', $blockWrapperEnd = '') {
		$layout_blocks = $this->get_layout_blocks($collectionObject, $areaHandle);
		$nonlayout_blocks = $collectionObject->getBlocks($areaHandle); //Returns blocks in the order they're on the page
		$blocks = array_merge($layout_blocks, $nonlayout_blocks);
 
		$block_count = count($blocks);
		$maxBlocks = empty($maxBlocks) ? $block_count : $maxBlocks;
		$maxBlocks = ($maxBlocks < $block_count) ? $maxBlocks : $block_count;
 
		for ($i = 0; $i < $maxBlocks; $i++) {
			$bi = $blocks[$i]->getInstance();
			$b = Block::getByID($bi->bID);
 
			echo $blockWrapperStart;
			$b->display();
			echo $blockWrapperEnd;
		}
	}
 
	private function get_layout_blocks($collectionObject, $areaHandle) {
		$blocks = array();
		$area = new Area($areaHandle);
		$layouts = $area->getAreaLayouts($collectionObject); //returns empty array if no layouts
		foreach ($layouts as $layout) {
			$maxCell = $layout->getMaxCellNumber();
			for ($i=1; $i<=$maxCell; $i++) {
				$cellAreaHandle = $layout->getCellAreaHandle($i);
				$cellBlocks = $collectionObject->getBlocks($cellAreaHandle);
				$blocks = array_merge($blocks, $cellBlocks);
			}
		}
		return $blocks;
	}
	
}