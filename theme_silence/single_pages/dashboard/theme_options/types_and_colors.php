<?php     defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php    echo $this->action('view')?>" method="post" id="preset_to_edit">
	<?php    $poh->output_presets_list(true, $pID)?>
    </form>
<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;	</div>

<?php     
$options = array(
		 array (
			'name'=>t("Header colors"),
			'type'=>'start'
		 ),
		 /*
                    array(
                            "name" => t("Enable header color rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "header_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
           */
		    array(
			    "name" => t("Header as link color"),
			    "desc" => t("When a title is a link"),
			    "id" => "h_link_color",
			    "default" => "#004d60",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Header as link hovered color"),
			    "desc" => t("When a title is a link"),
			    "id" => "h_hover_color",
			    "default" => "#004d60",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Header as link visited color"),
			    "desc" => t("When a title is a link"),
			    "id" => "h_visited_color",
			    "default" => "#004d60",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("H1 color"),
			    "desc" => "",
			    "id" => "h1_color",
			    "default" => "#00728F",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("H2 color"),
			    "desc" => "",
			    "id" => "h2_color",
			    "default" => "#00728F",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("H3 color"),
			    "desc" => "",
			    "id" => "h3_color",
			    "default" => "#00728F",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("H4 color"),
			    "desc" => "",
			    "id" => "h4_color",
			    "default" => "#00728F",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("H5 color"),
			    "desc" => "",
			    "id" => "h5_color",
			    "default" => "#00728F",
			    "type" => "color"
		    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),

// ------ Typo ------ //

		 array (
			'name'=>t("Typo &amp; elements colors"),
			'type'=>'start'
		 ),
		 /*
                    array(
                            "name" => t("Enable Typo & elements rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "typo_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
          */
		    array(
			    "name" => t("Text color"),
			    "desc" => "",
			    "type" => "section"
		    ),
		    array(
			    "name" => t("Paragraph color"),
			    "desc" => "",
			    "id" => "p_color",
			    "default" => "#545454",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("link color"),
			    "desc" => "",
			    "id" => "a_color",
			    "default" => "#418ef4",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("link :hover color"),
			    "desc" => "",
			    "id" => "a_hover_color",
			    "default" => "#418ef4",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("link :visited color"),
			    "desc" => "",
			    "id" => "a_visited_color",
			    "default" => "#418ef4",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Sidebar Title"),
			    "desc" => "",
			    "type" => "section"
		    ),
                    array (
                            "name" => t("Left Sidebar Title background color"),
                            "desc" => t("Select which color to use as title corner"),
                            "id" => "bg_left_sidebar_title",
                            "default" => 'black',
                            "options" => $bg_sidebar_title,
                            "type" => "select"
                    ),
                    array (
                            "name" => t("Left Sidebar title text color"),
                            "desc" => '',
                            "id" => "left_sidebar_title_color",
                            "default" => '#eee',
			    "type" => "color"
                    ),
                    array (
                            "name" => t("Left Sidebar title link color"),
                            "desc" => t('When the title is a link'),
                            "id" => "left_sidebar_title_link_color",
                            "default" => '#eef',
			    "type" => "color"
                    ),
                    array (
                            "name" => t("Right Sidebar Title background color"),
                            "desc" => t("Select which color to use as title corner"),
                            "id" => "bg_right_sidebar_title",
                            "default" => 'black',
                            "options" => $bg_right_sidebar_title,
                            "type" => "select"
                    ),
                    array (
                            "name" => t("Right Sidebar title text color"),
                            "desc" => '',
                            "id" => "right_sidebar_title_color",
                            "default" => '#eee',
			    "type" => "color"
                    ),
                    array (
                            "name" => t("Right Sidebar title link color"),
                            "desc" => t('When the title is a link'),
                            "id" => "right_sidebar_title_link_color",
                            "default" => '#eef',
			    "type" => "color"
                    ),
		    array(
			    "name" => t("Buttons"),
			    "desc" => "",
			    "type" => "section"
		    ),
                    array (
                            "name" => t("Buttons background color"),
                            "desc" => t("Select which button color to use"),
                            "id" => "bg_button",
                            "default" => 'black',
                            "options" => $bg_buttons,
                            "type" => "select"
                    ),
                    array (
                            "name" => t("Buttons background color on hover"),
                            "desc" => '',
                            "id" => "bg_button_hover",
                            "default" => 'black',
                            "options" => $bg_buttons,
                            "type" => "select"
                    ),
		    array(
			    "name" => t("Buttons text color"),
			    "desc" => "",
			    "id" => "button_text_color",
			    "default" => "#eeeeeeeee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Buttons hover text color"),
			    "desc" => "",
			    "id" => "button_text_hover_color",
			    "default" => "#eeeeeeeee",
			    "type" => "color"
		    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),

// ------ Nav ------ //

		 array (
			'name'=>t("Header Navigation"),
			'type'=>'start'
		 ),
		 /*
                    array(
                            "name" => t("Enable Header Navigation' rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "top_nav_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
          */
		    array(
			    "name" => t("Text First level"),
			    "desc" => "",
			    "id" => "nav_first_level_color",
			    "default" => "#eeeeee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text Second level"),
			    "desc" => "",
			    "id" => "nav_second_level_color",
			    "default" => "#eeeeee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text Third level"),
			    "desc" => "",
			    "id" => "nav_third_level_color",
			    "default" => "#eeeeee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text All level hover & selected"),
			    "desc" => "",
			    "id" => "nav_selected_color",
			    "default" => "#eeeeee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Background color on hover & selected"),
			    "desc" => "",
			    "id" => "nav_background_selected_color",
			    "default" => "#eeeeee",
			    "type" => "color"
		    ),
                    array(
                            "name" => t("Enable Text shadow on capable browser"),
                            "id" => "top_nav_shadow_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),
	    );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
