<?php    
 defined('C5_EXECUTE') or die(_("Access Denied."));
 // get the list of all pages matching the selection
 $aBlocks = $controller->generateNav();
 $nh = Loader::helper('navigation');
 echo("<select class=\"nav-select\" id='mobile_nav'>");
  $c = Page::getCurrentPage();

 // loop through all the pages
 foreach($aBlocks as $ni) :
  
  $_c = $ni->getCollectionObject();
  if (!$_c->getCollectionAttributeValue('exclude_nav')) :
  
  //echo "\n {$c->getCollectionID()} \n";
  //echo "\n {$_c->getCollectionID()} \n";
  
  if ( $c->getCollectionID() == $_c->getCollectionID() ) :
   $selected = " SELECTED ";
  else:
   $selected = "";
  endif;
  
  // get the level of the current element.
  // This is necessary to create the proper indentation.
  $thisLevel = $ni->getLevel();
  
  // The prefix 
  $prefix = $tab = '';
  for ($p = 0 ; $p < $thisLevel ; $p ++) :
   //$prefix .= '&nbsp;&nbsp;'; // for options
   //$tab .='&nbsp;&nbsp;'; // for optgroup
  endfor;

  // the current page has a higher level than the previous
  // page which means that we have to print another UL
  // element to indent the next pages
  if ($thisLevel > $lastLevel) {
    $parent = Page::getByID($_c->getCollectionParentID());
    //echo("<optgroup label='$tab {$parent->getCollectionName()}'>");
    // On imprime une deuxième fois en temps que lien
    if ($child_name)
     echo("<option $child_selected value='$child_url'>$prefix $child_name</option>");
  }

  // the current page has a lower level compared to
  // the previous page. We have to close all the open
  // LI and UL elements we've previously opened
  else if ($thisLevel < $lastLevel) {
   for ($j = $thisLevel; $j < $lastLevel; $j++) {
    if ($lastLevel - $j > 1) {
      //echo("</option></optgroup>");
      echo("</option>");
    } else {
      //echo("</option></optgroup></option>");
      echo("</option></option>");
    }
   }
  }

  // when adding a page, see "echo('<li>..." below
  // the tag isn't closed as nested UL elements
  // have to be within the LI element. We always close
  // them in an iteration later
  else if ($i > 0) {
    echo("</option>");
  }

  // output the page information, name and link

    $subPage = $_c->getFirstChild();
    if ($subPage instanceof Page && $ni->cID > 1) :
      $child_name = $ni->getName();
      $child_url  =  $ni->getURL();
      $child_selected = $selected;
    else :

     echo('<option ' . $selected  . 'value="' . $ni->getURL() . '">' .
     $prefix . $ni->getName()  . '</option>');

    endif;

  // We have to compare the current page level
  // to the level of the previous page, safe
  // it in $lastLevel
  $lastLevel = $thisLevel;
  $i++;
  
  endif;
 endforeach;
 // When the last page has been printed, it
 // can happen that we're not in the top level
 // and therefore have to close all the child
 // level we haven't closed yet
 $thisLevel = 0;
 for ($i = $thisLevel; $i <= $lastLevel; $i++) {
   echo("</option></select>");
 }
?>