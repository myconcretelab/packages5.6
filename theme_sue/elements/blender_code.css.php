<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Sue theme
 * @category Tools
 * @author Sebastien Jacqmin <seb@tellthem.eu>
 * @copyright  Copyright (c) 2011-2012 myconcretelab (http://www.myconcretelab.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */


if (!$t->__display_page_title && !$t->__display_page_desc && !$t->__display_breadcrumb) {
    $tidy->css_add_property('@media screen','#middle .content','padding-top','0');
}

$t->set_toggle_option_name('colors');

if ($t->__header_color_enabled) {
    $tidy->css_add_property('@media screen','h1 a,h2 a,h3 a,h4 a,h5 a','color',$t->_h_link_color);
    $tidy->css_add_property('@media screen','h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover','color',$t->_h_hover_color);
    $tidy->css_add_property('@media screen','h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited','color',$t->_h_visited_color);
    
    $tidy->css_add_property('@media screen','h1','color',$t->_h1_color);
    $tidy->css_add_property('@media screen','h2','color',$t->_h2_color);
    $tidy->css_add_property('@media screen','h3','color',$t->_h3_color);
    $tidy->css_add_property('@media screen','h4','color',$t->_h4_color);
    $tidy->css_add_property('@media screen','h5','color',$t->_h5_color);

    $tidy->css_add_property('@media screen','#footer h1, #footer h2, #footer h3, #footer h4, #footer h5 ','color',$t->_h_footer_color);
}

if ($t->__typo_color_enabled) {
    $tidy->css_add_property('@media screen','p','color',$t->_p_color);

    $tidy->css_add_property('@media screen','p a,li a','color',$t->_a_color);
    $tidy->css_add_property('@media screen','.ccm-next-previous-wrapper a','color',$t->_a_color);
    

    $tidy->css_add_property('@media screen','p a:hover,li a:hover','color',$t->_a_hover_color);
    $tidy->css_add_property('@media screen','.ccm-next-previous-wrapper a:hover','color',$t->_a_hover_color);

    $tidy->css_add_property('@media screen','p a:visited','color',$t->_a_visited_color);

    $tidy->css_add_property('@media screen','#sue #footer p,#sue #footer li','color',$t->_p_footer_color);
    
    $tidy->css_add_property('@media screen','#inner-breadcrumb a','color',$t->_a_color);
    $tidy->css_add_property('@media screen','#sue #inner-breadcrumb a:hover','color',$t->_a_hover_color);

    

}

/*-----  Top Nav ------*/

    $tidy->css_add_property('@media screen','#main-nav a.first-level','color',$t->_nav_first_level_color);
    $tidy->css_add_property('@media screen','#main-nav ul li li a','color',$t->_nav_second_level_color);
    $tidy->css_add_property('@media screen','#main-nav ul li ul li ul li a','color',$t->_nav_third_level_color);
    $tidy->css_add_property('@media screen','#main-nav ul li a.nav-path-selected,#main-nav ul li a.nav-path-selected,#main-nav ul a:hover','color',$t->_nav_selected_color);

    $tidy->css_add_property('@media screen','#main-nav ul li li a:hover','background-color',$t->_nav_background_selected_color);
    $tidy->css_add_property('@media screen','#main-nav ul li li a:hover','background-color','rgba(' . implode(',', $h->hex_to_rvb($t->_nav_background_selected_color)) .',.4)');

    $tidy->css_add_property('@media screen','#main-nav ul li ul','background','url(' . $h->get_nav_background_rel_path(array('level'=>1,'color' => substr($t->_main_color, 1 , 6 ))) . ')');
    $tidy->css_add_property('@media screen','#main-nav ul li li ul','background','url(' . $h->get_nav_background_rel_path(array('level'=>2, 'color' => substr($t->_main_color, 1 , 6 ))) . ')');
    
    $tidy->css_add_property('@media screen','#main-nav','background-image','url(' . $h->get_main_nav_relative_path(array('color' => substr($t->_main_color, 1 , 6 ))) . ')');
//    $tidy->css_add_property('@media screen','#main-nav ul.first-level','background-image','url(' . $h->get_main_nav_relative_path(array('color' => substr($t->_main_color, 1 , 6 ))) . ')');
    $tidy->css_add_property('@media screen','#main-nav li.first-level','background-image','url(' . $h->get_main_nav_arrow_relative_path(array('color' => substr($t->_bg_header_color, 1 , 6 ))) . ')'); // Little arrow

/*---- Button ---*/
    $tidy->css_add_property('@media screen','a.butn span,button span','background-color', $t->_button_bg_color);
    $tidy->css_add_property('@media screen','a.butn span:hover','background-color', $t->_button_bg_hover_color);
    $tidy->css_add_property('@media screen','a.butn span,button span','color', $t->_button_text_color);
    $tidy->css_add_property('@media screen','a.butn span:hover','color', $t->_button_text_hover_color);

/*-----  main color ------*/
$tidy->css_add_property('@media screen','::selection','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','::selection','color', '#' . $h->get_contrast_color($t->_main_color));

$tidy->css_add_property('@media screen','.selected','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','.blog_infos .circle','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','.ccm-easyTabs-wrapper ul.ccm-easyTabs-nav li.current span,.ccm-easyTabs-wrapper ul.ccm-easyTabs-nav li.current','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','h3.ccm-easyAccordion-title-active','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','#logo h1 a','color', $t->_main_color);
$tidy->css_add_property('@media screen','#page-title small','color', $t->_main_color);
$tidy->css_add_property('@media screen','#search-go','background-color', $t->_main_color);
$tidy->css_add_property('@media screen','#search-go:hover','background-color', $t->_main_color);


/*-----  Pattern & backgrounds ------*/

$bodypattern = $t->_bg_body_custom ? $t->_bg_body_custom : $t->_bg_body_pattern;

// Body & top
$tidy->css_add_property('@media screen','body#sue','background-image','url(' . $h->get_pattern_relative_path(array('color' => substr($t->_bg_body_color, 1 , 6 ), 'pattern' => $bodypattern)) . ')');
$tidy->css_add_property('@media screen','.section span','background-image','url(' . $h->get_pattern_relative_path(array('color' => substr($t->_bg_body_color, 1 , 6 ), 'pattern' => $bodypattern)) . ')');
$tidy->css_add_property('@media screen','.section span','background-color',$t->_bg_body_color);
$tidy->css_add_property('@media screen','.plain .section span','background-color',$t->_bg_plain_color);
$tidy->css_add_property('@media screen','#sue #footer .section span','background-color',$t->_bg_header_color);
$tidy->css_add_property('@media screen','.top,div#footer','background-color',$t->_bg_header_color);
$tidy->css_add_property('@media screen','#sue .plain','background-color',$t->_bg_plain_color);


// Main content & sidebar
$tidy->css_add_property('@media screen','#middle .row .content','background-color',$t->_bg_main_color);
$tidy->css_add_property('@media screen','#sidebar li','border-bottom','1px dotted ' . $t->_a_color);

//$tidy->css_add_property('@media screen','#sidebar','background-color',$t->_bg_sidebar_color);
