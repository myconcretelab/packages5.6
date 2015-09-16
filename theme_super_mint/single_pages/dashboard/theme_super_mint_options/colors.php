<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php  echo $this->action('view')?>" method="post" id="preset_to_edit">
	<?php  $poh->output_presets_list(true, $pID)?>
    </form>
<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;	</div>

<?php 
$options = array(
	array (
	'name'=>t("Page pattern & colors"),
	'type'=>'start'
	),
	array(
	    "name" => t("Top color"),
	    "desc" => t("The top area is where the logo and search is placed"),
	    "id" => "bg_top",
	    "default" => "#373b3d",
	    "type" => "color"
	),
	array(
        "name" => t("Top Pattern"),
        "desc" => t("Select which pattern to use to the top. (the 'for black' patterns is made for dark colors)"),
        "id" => "bg_top_pattern",
        "default" => 'noise_for_dark',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
	    "name" => t("Body color"),
	    "desc" => t("This color is used for the background page"),
	    "id" => "bg_body_color",
	    "default" => "#efefef",
	    "type" => "color"
	),
	array(
        "name" => t("Body background Pattern"),
        "desc" => t("Select which pattern to use on the hole page. (the 'for black' patterns is made for dark colors)"),
        "id" => "bg_body_pattern",
        "default" => 'noise',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
        "name" => t("Custom Body Pattern"),
        "desc" => "Click to choose",
        "id" => "bg_body_custom",
        "type" => "file"
	),
	array(
	    "name" => t("Top-page Area background color"),
	    "desc" => t("Top-page is where live page's title, Description & breadcrumb"),
	    "id" => "bg_toppage_color",
	    "default" => "#ffffff",
	    "type" => "color"
	),		
	array(
	    "name" => t("Main Area background color"),
	    "desc" => t("Top-page is where live page's title, Description & breadcrumb"),
	    "id" => "bg_main_color",
	    "default" => "#ffffff",
	    "type" => "color"
	),
    array(
        "name" => t("Disable border on Top-page & main content"),
        "desc" => t("If enabled, the thin grey border will disapear. Usefull to avoid limits of contents"),
        "id" => "disable_border_main",
        "value"=>'colors',
        "activated" => false,
        "type" => "toggle"
    ),     		
	array(
	    "name" => t("Sidebar background color"),
	    "desc" => t(""),
	    "id" => "bg_sidebar_color",
	    "default" => "#f5f5f5",
	    "type" => "color"
	),	
	array(
	    "name" => t("Bottom Area background color"),
	    "desc" => t("The bottom is this optional place just before the footer"),
	    "id" => "bg_bottom_color",
	    "default" => "#18aedf",
	    "type" => "color"
	),	
	array(
        "name" => t("Bottom Area background Pattern"),
        "desc" => t("Select which pattern to use on the Bottom area. (the 'for black' patterns is made for dark colors)"),
        "id" => "bg_bottom_pattern",
        "default" => 'none',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
	    "name" => t("Footer Area background color"),
	    "desc" => t(""),
	    "id" => "bg_footer_color",
	    "default" => "#373b3e",
	    "type" => "color"
	),	
	array(
        "name" => t("Footer Area background Pattern"),
        "desc" => t("Select which pattern to use on the Bottom area. (the 'for black' patterns is made for dark colors)"),
        "id" => "bg_footer_pattern",
        "default" => 'noise',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
        "name" => t("Product Preview background color"),
        "desc" => t("Only available with core-commerce addon"),
	    "id" => "bg_preview_color",
	    "default" => "#eeeeee",
	    "type" => "color"
	),	
	array(
        "name" => t("Product Preview background pattern"),
        "desc" => t("Only available with core-commerce addon"),
        "id" => "bg_preview_pattern",
        "default" => 'noise',
        "options" => $pattern_list,
        "type" => "select"
	),

	array(
		'type'=>'submit',
		'name'=>t("Save !"),
		'id'=>'saved'
	),


	array(
	    "name" => t("Unbordered pages type"),
		'type'=>'start'
	),	
    array(
	    "name" => t("Header color on Unbordered"),
	    "desc" => t(""),
	    "id" => "bg_header_u_color",
	    "default" => "#ffffff",
	    "type" => "color"
	),
	array(
         "name" => t("Header pattern on Unbordered"),
        "desc" => t(""),
        "id" => "bg_header_u_pattern",
        "default" => 'none',
        "options" => $pattern_list,
        "type" => "select"
	),		
    array(
	    "name" => t("Main area color on Unbordered"),
	    "desc" => t(""),
	    "id" => "bg_main_u_color",
	    "default" => "#fcfcfc",
	    "type" => "color"
	),
	array(
        "name" => t("Custom Main area Pattern"),
        "desc" => "Click to choose",
        "id" => "bg_main_u_custom_pattern",
        "type" => "file"
	),	
	array(
         "name" => t("Main area pattern on Unbordered"),
        "desc" => t(""),
        "id" => "bg_main_u_pattern",
        "default" => 'none',
        "options" => $pattern_list,
        "type" => "select"
	),	
    array(
	    "name" => t("Under main color on Unbordered"),
	    "desc" => t(""),
	    "id" => "bg_undermain_u_color",
	    "default" => "#ffffff",
	    "type" => "color"
	),
	array(
        "name" => t("Under main Pattern on Unbordered"),
        "desc" => t(""),
        "id" => "bg_undermain_u_pattern",
        "default" => 'none',
        "options" => $pattern_list,
        "type" => "select"
	),	
	array(
		'type'=>'stop'
	),
	array(
		'type'=>'submit',
		'name'=>t("Save !"),
		'id'=>'saved'
	),


	array(
		'name'=>t("Navigation"),
		'type'=>'start'
	),	

	array(
	    "name" => t("First level Navigation backgound color"),
	    "desc" => t("The grey bar with first level of navigation"),
	    "id" => "bg_nav",
	    "default" => "#373b3d",
	    "type" => "color"
	),
	array(
	    "name" => t("First level Navigation text link color"),
	    "desc" => t(""),
	    "id" => "top_nav_a",
	    "default" => "#373b3e",
	    "type" => "color"
	),
	array(
	    "name" => t("First level Navigation hover & active background color"),
	    "desc" => t(""),
	    "id" => "top_nav_hover",
	    "default" => "#373b3e",
	    "type" => "color"
	),
    array(
        "name" => t("Disable the box shadow on active first level nav"),
        "desc" => t("Sometimes it's best without"),
        "id" => "disable_box_shadow_active_nav",
        "value"=>'colors',
        "activated" => false,
        "type" => "toggle"
    ),   	
	array(
	    "name" => t("First level Navigation hover & active links color"),
	    "desc" => t(""),
	    "id" => "top_nav_hover_link",
	    "default" => "#ffffff",
	    "type" => "color"
	),	
	array(
	    "name" => t("Second level Navigation text Description color"),
	    "desc" => t(""),
	    "id" => "top_nav_p",
	    "default" => "#373b3e",
	    "type" => "color"
	),
	array(
	    "name" => t("First level Border bottom default color of a selected top nav"),
	    "desc" => t(""),
	    "id" => "bg_nav_selected",
	    "default" => "#48a9c0",
	    "type" => "color"
	),			
	array(
	    "name" => t("Slider navigation background color"),
	    "desc" => t("The slider nav is the place where slide subs pages"),
	    "id" => "bg_nav_slide",
	    "default" => "#373b3d",
	    "type" => "color"
	),	
	array(
        "name" => t("Slider navigation Background Pattern"),
        "desc" => t("Select which pattern to use on the Slider navigation. (the 'for black' patterns is made for dark colors)"),
        "id" => "bg_nav_slide_pattern",
        "default" => 'noise_for_dark',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
	    "name" => t("Slider navigation links color"),
	    "desc" => t(""),
	    "id" => "nav_slide_a_color",
	    "default" => "#d5d8d9",
	    "type" => "color"
	),		
	array(
	    "name" => t("Slider navigation text color"),
	    "desc" => t(""),
	    "id" => "nav_slide_p_color",
	    "default" => "#d5d8d9",
	    "type" => "color"
	),		
	array(
	    "name" => t("Slider navigation title color"),
	    "desc" => t(""),
	    "id" => "nav_slide_h_color",
	    "default" => "#d5d8d9",
	    "type" => "color"
	),		
	array(
	    "name" => t("Slider Lateral navigation color (on mobiles)"),
	    "desc" => t(""),
	    "id" => "bg_pageslide",
	    "default" => "#373b3d",
	    "type" => "color"
	),	
	array(
	    "name" => t("Slider Lateral text color"),
	    "desc" => t(""),
	    "id" => "text_pageslide",
	    "default" => "#efefef",
	    "type" => "color"
	),	
	array(
        "name" => t("Slider Lateral navigation pattern (on mobiles)"),
        "desc" => t(""),
        "id" => "bg_pageslide_pattern",
        "default" => 'noise_for_dark',
        "options" => $pattern_list,
        "type" => "select"
	),
	array(
	    "name" => t("Secondary navigation links color"),
	    "desc" => t(""),
	    "id" => "secondary_nav_color",
	    "default" => "#dddddd",
	    "type" => "color"
	),	

	array(
		'type'=>'stop'
	),
	array(
		'type'=>'submit',
		'name'=>t("Save !"),
		'id'=>'saved'
	),


	array(
		'name'=>t("Text colors"),
		'type'=>'start'
	),
    array(
	    "name" => t("Paragraph color"),
	    "desc" => "",
	    "id" => "p_color",
	    "default" => "#585f63",
	    "type" => "color"
    ),
    array(
	    "name" => t("'alternate' class color"),
	    "desc" => "Alternate is used with class 'alternate'",
	    "id" => "alternate_color",
	    "default" => "#18aedf",
	    "type" => "color"
    ),
    array(
	    "name" => t("link color"),
	    "desc" => "",
	    "id" => "a_color",
	    "default" => "#18aedf",
	    "type" => "color"
    ),
    array(
	    "name" => t("link :hover color"),
	    "desc" => "",
	    "id" => "a_hover_color",
	    "default" => "#18aedf",
	    "type" => "color"
    ),
    array(
	    "name" => t("link :visited color"),
	    "desc" => "",
	    "id" => "a_visited_color",
	    "default" => "#18aedf",
	    "type" => "color"
    ),

    array(
	    "name" => t("Titles color"),
	    "desc" => "",
	    "type" => "section"
    ),
	array(
	    "name" => t("Header as link color"),
	    "desc" => t("When a title is a link"),
	    "id" => "h_link_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("Header as link hovered color"),
	    "desc" => t("When a title is a link"),
	    "id" => "h_hover_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("Header as link visited color"),
	    "desc" => t("When a title is a link"),
	    "id" => "h_visited_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("H1 color"),
	    "desc" => "",
	    "id" => "h1_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("H2 color"),
	    "desc" => "",
	    "id" => "h2_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("H3 color"),
	    "desc" => "",
	    "id" => "h3_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("H4 color"),
	    "desc" => "",
	    "id" => "h4_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
	array(
	    "name" => t("H5 color"),
	    "desc" => "",
	    "id" => "h5_color",
	    "default" => "#585f63",
	    "type" => "color"
	),
    array(
	    "name" => t("Footer  text color"),
	    "desc" => "",
	    "type" => "section"
    ),
	array(
	    "name" => t("Footer tilte's color"),
	    "desc" => "Color for all title in footer",
	    "id" => "footer_h_color",
	    "default" => "#efefef",
	    "type" => "color"
	),
	array(
	    "name" => t("Footer text color"),
	    "desc" => "Color for all text in footer",
	    "id" => "footer_t_color",
	    "default" => "#efefef",
	    "type" => "color"
	),
	array(
	    "name" => t("Footer links color"),
	    "desc" => "Color for all links in footer",
	    "id" => "footer_a_color",
	    "default" => "#efefef",
	    "type" => "color"
	),
	array(
		'type'=>'stop'
	),
	array(
		'type'=>'submit',
		'name'=>t("Save !"),
		'id'=>'saved'
	)
);




$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
