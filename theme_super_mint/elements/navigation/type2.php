<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

echo "\n<div class='nav-pane'> <!-- pane-$j $ni->name -->\n";
if($o->__display_pane_title) :
	echo '<h3><a href="' . $ni->url . '">' . $ni->name . '</a></h3>';
endif;

echo '<ul class="l123 row columned">';
//print_r($ni->childrens );
	foreach($ni->childrens as $cID) :
		if (array_key_exists($cID,($subNavItems))) :
			$ni = $subNavItems[$cID];
			
			//selected
			if ($ni->isCurrent || $ni->inPath)  {
				$selected_level = 1;
			}			 
						
			echo '<li class="' . $ni->classes . '">';
			echo '<a href="' . $ni->url . '" class="' . $ni->classes . ' lined" onfocus="this.blur();">' . $ni->name . '</a>';
			if ($ni->hasSubmenu) :
				
				echo "\n <ul class='third'> <!-- subsub $j --> \n";
				foreach($ni->childrens as $cID) :
					if (array_key_exists($cID,($subsubNavItems))) :
						$ni = $subsubNavItems[$cID];
						echo '<li class="' . $ni->classes . '">';
						echo '<a href="' . $ni->url . '" class="' . $ni->classes . '" onfocus="this.blur();">' . $ni->name . '</a>';
						echo '</li>';
					endif;
				endforeach;
				echo "\n </ul> <!-- /subsub $j --> \n";
				echo "\n";
			endif;
			echo '</li>';					
		endif;
	endforeach;
echo '</ul>';
echo "\n</div> <!-- /pane-$j -->\n";
