<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Sue theme Options
 * @category Helper
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */

class OptionsGeneratorHelper {
	
	function __construct ($options = null, $saved = null, $action = null,$hiddens = array()) {
		
		if ($options) : // Option n'est pas rempli quand il est appellŽ par loader::helper
			$this->generator = Loader::helper('base_options_generator', 'theme_sue');
			$this->form = Loader::helper('form');
			$this->ih = Loader::helper("concrete/interface");
			$this->action = $action;
			$this->options = $options;
			$this->saved_options = $saved;
			$this->hiddens = $hiddens;
			
			$this->render();
		endif;
	}
	function save () {
		
	}
	
	function render() {
		if ($this->action) echo "<form method='post' action='$this->action'>";

		if (count($this->hiddens)) :
			foreach($this->hiddens as $k=>$v):
				array_unshift($this->options,array('id'=>$k,'type'=>'hidden','default'=> $v));
			endforeach;
		endif;
		
		foreach($this->options as $option) {
			$this->renderOption($option);
		
		}
		if ($this->action) echo '</form>';
	}
	
	function renderOption($option){
		
		if(isset($option['id'])){
			if (isset($this->saved_options[$option['id']]) || isset($this->saved_options[$option['value']])) {
				if ($option['type'] == 'toggle') { // Ne supporte actuelement QUE les toggle sous forme de tableau
					// GŽrer les tableaux
					$option['activated'] = in_array ( $option['id'] , explode (',', $this->saved_options[$option['value']] ) );
				} elseif ( is_string($this->saved_options[$option['id']])){
					$option['value'] = stripslashes($this->saved_options[$option['id']]);
				}else{
					$option['value'] = $this->saved_options[$option['id']];
				}
			}else{
				if ($option['type'] == 'toggle') { // Ne supporte actuelement QUE les toggle sous forme de tableau
					$option['activated'] =  $option['default'];
				} elseif (isset($option['default'])){
					$option['value'] = $option['default'];
				} else {
					$option['value'] = '';
					$option['default'] = '';
				}
			}
		}
		if (isset($option['prepare']) && function_exists($option['prepare'])) {
			$option = $option['prepare']($option);
		}
		if (method_exists($this->generator, $option['type'])) { 
			echo '<tr><td><strong><label for="'.$option['id'].'">' . $option['name'] . '</label></strong><td>';
			if(isset($option['desc'])){
				echo '<p class="description">' . $option['desc'] . '</p>';
			}
			$this->generator->$option['type']($option);
			echo '</td></tr>';
		}elseif (method_exists($this, $option['type'])) {
			$this->$option['type']($option);
		}
	}
	
	/**
	 * prints the options page title
	 */
	function title($item) {

	}
	function start ($item) {
		echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper($item['name'], false, 'span10', false);
		echo '<div class="ccm-pane-body">';
		echo '<table cellspacing="0" class="entry-form zebra-striped" width="100%">';
		echo '<tbody>';		

	}
	function stop ($item) {

	}

	function submit ($item) {
		echo '</tbody></table><!-- stop -->';
		echo '</div>'; //<div class="ccm-pane-body">
		echo '<div class="ccm-pane-footer">';
		echo $this->ih->submit($item['name'],$item['id'], 'right', 'primary');
		echo '<small class="quiet">' . t('This action will save the whole page') . '</small>';
		//submit($item['id'],$item['name'], null, 'ccm-button-v2  ccm-button-v2-right');
		echo '</div>';
		echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);
		echo '<div class="clear" style="height:24px">&nbsp;	</div>';
	}
	
	/**
	 * begins the accordion section
	 */
	function accordion_start($item) {
		echo '<tr><td colspan="2">';
		echo '<div class="accordion">';
		echo '<h3><a href="#">' . $item['name'] . '</a></h3>';
		echo '<div>';
		echo '<table cellspacing="0" class="" width="100%">';
		echo '<tbody>';		

	}
	function accordion_section ($item) {
		echo '</tbody></table></div>';
		echo '<h3><a href="#">' . $item['name'] . '</a></h3>';
		echo '<div>';
		echo '<table cellspacing="0" class="" width="100%">';
		echo '<tbody>';		

	}
	
	function desc($item) {
		echo '<tr><td scope="row" colspan="2">' . $item['desc'] . '</td></tr>';
	}
	
	/**
	 * closes the accordion section
	 */
	function accordion_stop($item) {
		echo '</tbody></table></div></div><!-- stop -->';
		echo '</td></tr>';
	}
	
	function hidden ($item) {
		echo $this->form->hidden($item['id'],$item['value']);
	}
	
	function section ($item) {
		echo '<tr><td colspan="2"><h3 style="text-align:center">' . $item['name'] . '</h3></td></tr>';		
	}
	
	/**
	 * displays a custom field
	 */
	function custom($item) {
		if (isset($this->saved_options[$item['id']])) {
			$default = $this->saved_options[$item['id']];
		} else {
			$default = $item['default'];
		}
		if(isset($item['layout']) && $item['layout']==false){
			if (isset($item['function']) && function_exists($item['function'])) {
				$item['function']($item, $default);
			} else {
				echo $item['html'];
			}
		}else{
			echo '<tr><th scope="row"><h4>' . $item['name'] . '</h4></th><td>';
			if(isset($item['desc'])){
				echo '<p class="description">' . $item['desc'] . '</p>';
			}
			if (isset($item['function']) && function_exists($item['function'])) {
				$item['function']($item, $default);
			} else {
				echo $item['html'];
			}
			echo '</td></tr>';
		}
	}
}
