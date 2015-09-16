<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span10', true) ?>
    <form action="<?php  echo $this->action('view')?>" method="post" id="preset_to_edit">
	<?php  $poh->output_presets_list(true, $pID)?>
    </form>
<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;	</div>

<?php 
$options = array(
		 array (
			'name'=>t("Main colors"),
			'type'=>'start'
		 ),
		    array(
			    "name" => t("Main color"),
			    "desc" => t("This color is used for lot of items like top navigation, selection, page description, accordion, .. "),
			    "id" => "main_color",
			    "default" => "#64dfdf",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Body color"),
			    "desc" => t("This color is used for the background page"),
			    "id" => "bg_body_color",
			    "default" => "#64dfdf",
			    "type" => "color"
		    ),
            array (
                    "name" => t("Body background Pattern"),
                    "desc" => t("Select which pattern to use on the hole page. (the 'for black' patterns is made for dark colors)"),
                    "id" => "bg_body_pattern",
                    "default" => 'noise',
                    "options" => $pattern_list,
                    "type" => "select"
            ),
            array(
                    "name" => t("Custom Pattern"),
                    "desc" => "Click to choose",
                    "id" => "bg_body_custom",
                    "type" => "file"
            ),
		    array(
			    "name" => t("Body Plain color"),
			    "desc" => t("Only used on 'plain' page-types"),
			    "id" => "bg_plain_color",
			    "default" => "#ffffff",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Header & Footer color"),
			    "desc" => t("This color is used for the Header & footer page"),
			    "id" => "bg_header_color",
			    "default" => "#ffffff",
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
		 array (
			'name'=>t("Header colors"),
			'type'=>'start'
		 ),
                    array(
                            "name" => t("Enable header color rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "header_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
		    array(
			    "name" => t("Header as link color"),
			    "desc" => t("When a title is a link"),
			    "id" => "h_link_color",
			    "default" => "#004d60",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Header in footer"),
			    "desc" => t("When a title is in the footer"),
			    "id" => "h_footer_color",
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
                    array(
                            "name" => t("Enable Typo & elements rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "typo_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
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
			    "name" => t("Paragraph in footer color"),
			    "desc" => "",
			    "id" => "p_footer_color",
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
			    "name" => t("Buttons"),
			    "type" => "section"
		    ),
                    array (
                            "name" => t("Buttons background color"),
			    "desc" => "",
			    "id" => "button_bg_color",
			    "default" => "#64dfdf",
			    "type" => "color"
                    ),
                    array (
                            "name" => t("Buttons background color on hover"),
			    "desc" => "",
			    "id" => "button_bg_hover_color",
			    "default" => "#12ebeb",
			    "type" => "color"
                    ),
		    array(
			    "name" => t("Buttons text color"),
			    "desc" => "",
			    "id" => "button_text_color",
			    "default" => "#ffffff",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Buttons hover text color"),
			    "desc" => "",
			    "id" => "button_text_hover_color",
			    "default" => "#ffffff",
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
                    array(
                            "name" => t("Enable Header Navigation' rewritting"),
                            "desc" => t('Disable if you don\'t want activate options below (color will be taked from style.css)'),
                            "id" => "top_nav_color_enabled",
                            "value"=>'colors',
                            "default" => true,
                            "type" => "toggle"
                    ),
		    array(
			    "name" => t("Text First level"),
			    "desc" => "",
			    "id" => "nav_first_level_color",
			    "default" => "#eee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text Second level"),
			    "desc" => "",
			    "id" => "nav_second_level_color",
			    "default" => "#eee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text Third level"),
			    "desc" => "",
			    "id" => "nav_third_level_color",
			    "default" => "#eee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Text All level hover & selected"),
			    "desc" => "",
			    "id" => "nav_selected_color",
			    "default" => "#eee",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Background color on hover & selected"),
			    "desc" => "",
			    "id" => "nav_background_selected_color",
			    "default" => "#eee",
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
	    );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
