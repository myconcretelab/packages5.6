<?php     defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * @package Silence theme
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
}

if ($t->__typo_color_enabled) {
    $tidy->css_add_property('@media screen','p','color',$t->_p_color);
    $tidy->css_add_property('@media screen','body#sue','color',$t->_p_color);

    $tidy->css_add_property('@media screen','a','color',$t->_a_color);
    $tidy->css_add_property('@media screen','a','border-bottom','1px dotted ' . $t->_a_color);
    $tidy->css_add_property('@media screen','.ccm-next-previous-wrapper a','color',$t->_a_color);

    $tidy->css_add_property('@media screen','a:hover','color',$t->_a_hover_color);
    $tidy->css_add_property('@media screen','a:hover','border-bottom','1px dotted ' . $t->_a_hover_color);
    $tidy->css_add_property('@media screen','.ccm-next-previous-wrapper a:hover','color',$t->_a_hover_color);

    $tidy->css_add_property('@media screen','a:visited','color',$t->_a_visited_color);
    $tidy->css_add_property('@media screen','a:visited','border-bottom','1px dotted ' . $t->_a_visited_color);

    /*-----  Buttons ------*/
      
    $tidy->css_add_property('@media screen','a.butn,button,a.butn:visited,a.butn span,button span','background-image','url(' . $h->get_ressource_relative_path($t->_bg_button,'buttons') . ')');
    $tidy->css_add_property('@media screen','a.butn,button,a.butn:visited','color',$t->_button_text_color);
    $tidy->css_add_property('@media screen','a.butn:hover span','color',$t->_button_text_hover_color);
    $tidy->css_add_property('@media screen','a.butn:hover','background-image','url(' . $h->get_ressource_relative_path($t->_bg_button_hover,'buttons') . ')');
    $tidy->css_add_property('@media screen','a.butn:hover span','background-image','url(' . $h->get_ressource_relative_path($t->_bg_button_hover,'buttons') . ')');

    /*-----  Sidebar Title ------*/
    
    // Left
    $tidy->css_add_property('@media screen','#sidebar h3','background-image','url(' . $h->get_ressource_relative_path($t->_bg_left_sidebar_title,'left_sidebar_title') . ')');
    $tidy->css_add_property('@media screen','#sidebar h3','color',$t->_left_sidebar_title_color);
    $tidy->css_add_property('@media screen','#sidebar h3 a','color',$t->_left_sidebar_title_link_color);
    
    $tidy->css_add_property('@media screen','#sidebar.right-sidebar h3','background-image','url(' . $h->get_ressource_relative_path($t->_bg_right_sidebar_title,'right_sidebar_title') . ')');
    $tidy->css_add_property('@media screen','#sidebar.right-sidebar h3','color',$t->_right_sidebar_title_color);
    $tidy->css_add_property('@media screen','#sidebar.right-sidebar h3 a','color',$t->_right_sidebar_title_link_color);

}

/*-----  Top Nav ------*/

if ($t->__top_nav_color_enabled) {
    $tidy->css_add_property('@media screen','#top .silence-main-nav a.first-level','color',$t->_nav_first_level_color);
    $tidy->css_add_property('@media screen','#top #main-nav ul li li a','color',$t->_nav_second_level_color);
    $tidy->css_add_property('@media screen','#top  #main-nav ul li ul li ul li a','color',$t->_nav_third_level_color);
    $tidy->css_add_property('@media screen','#main-nav ul li.nav-path-selected a,#main-nav ul li.nav-path-selected span,#main-nav ul li.nav-selected a,#main-nav ul li.nav-selected span,#main-nav ul a:hover,#main-nav ul a.sfHover,#main-nav ul li.first-level.sfHover a.first-level','color',$t->_nav_third_level_color);

    $tidy->css_add_property('@media screen','#main-nav ul li li a:hover','background',$t->_nav_background_selected_color);

    if (!$t->__top_nav_shadow_enabled) {
        $tidy->css_add_property('@media screen','#main-nav a ','text-shadow','none');
        $tidy->css_add_property('@media screen','#main-nav ul li li a:hover,#main-nav ul li li a:hover span','text-shadow','none');        
    }
    
}

/*-----  Pattern & backgrounds ------*/

$t->set_toggle_option_name('background');


$toppattern = $t->_bg_top_custom ? $t->_bg_top_custom : $t->_bg_top_pattern;
$bodypattern = $t->_bg_body_custom ? $t->_bg_body_custom : $t->_bg_body_pattern;
$footerpattern = $t->_bg_footer_custom ? $t->_bg_footer_custom : $t->_bg_footer_pattern;

$colorheight = ($mobile == 'true' ) ? 270 : $t->_bg_top_height;

// Body & top
$tidy->css_add_property('@media screen','body#silence','background-image','url(' . $h->get_pattern_relative_path(array('color' => substr($t->_bg_body_color, 1 , 6 ), 'pattern' => $bodypattern)) . ')');
$tidy->css_add_property('@media screen','#top','background-image','url(' . $h->get_pattern_relative_path(array('color' => substr($t->_bg_top_color, 1 , 6 ), 'pattern' => $toppattern, 'color-height' => $colorheight, 'shadow' => $t->_bg_top_shadow)) . ')');

// Main nav
$tidy->css_add_property('@media screen','#main-nav ul li ul','background','url(' . $h->get_nav_background_rel_path(array('level'=>1,'light'=>$t->_bg_nav_light, 'color' => substr($t->_bg_nav_color, 1 , 6 ))) . ')');
$tidy->css_add_property('@media screen','#main-nav ul li li ul','background','url(' . $h->get_nav_background_rel_path(array('level'=>2,'light'=>$t->_bg_nav_light, 'color' => substr($t->_bg_second_nav_color, 1 , 6 ))) . ')');

// Footer
$tidy->css_add_property('@media screen','#footer .container','background','url(' . $h->get_pattern_relative_path(array('color' => substr($t->_bg_footer_page_color, 1 , 6 ), 'pattern' => $footerpattern, 'color-height' => 800 , 'shadow' => $t->_bg_footer_shadow)) . ')');
$tidy->css_add_property('@media screen','#footer .row','background-color',$t->_bg_footer_color);

if (!$t->_bg_top_light)
    $tidy->css_add_property('@media screen','#top .container','background-image','none');

// Main content & sidebar
$tidy->css_add_property('@media screen','#middle .row .content','background-color',$t->_bg_main_color);
$tidy->css_add_property('@media screen','#sidebar','background-color',$t->_bg_sidebar_color);
