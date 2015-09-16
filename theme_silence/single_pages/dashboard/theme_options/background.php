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
			'name'=>t("Page background"),
			'type'=>'start'
		 ),
		    array(
			    "name" => t("Top page background color"),
			    "desc" => "",
			    "id" => "bg_top_color",
			    "default" => "#464f5c",
			    "type" => "color"
		    ),
                    array (
                            "name" => t("Top page Pattern"),
                            "desc" => t("Select which pattern to use on the top page."),
                            "id" => "bg_top_pattern",
                            "default" => 'square',
                            "options" => $pattern_list,
                            "type" => "select"
                    ),
                    array (
                            "name" => t("Top page color height for desktop large screen up to 1200px"),
                            "desc" => t("Increasing will be visible only when they are something in the header area. Default : 250px"),
                            "id" => "bg_top_height_large",
                            "min" => "0",
                            "max" => "1000",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "250",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Top page color height for normal desktop screen (under 1200px)"),
                            "id" => "bg_top_height",
                            "min" => "0",
                            "max" => "1000",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "250",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Top page color height for Portrait tablet to landscape and desktop"),
                            "id" => "bg_top_height_medium",
                            "min" => "0",
                            "max" => "1000",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "250",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Top page color height for Landscape phone to portrait tablet"),
                            "id" => "bg_top_height_small",
                            "min" => "0",
                            "max" => "1000",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "250",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Top page color height on Landscape phones and down "),
                            "id" => "bg_top_height_mobile_xsmall",
                            "min" => "0",
                            "max" => "1000",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "100",
                            "type" => "range"
                    ),
                	array (
                            "name" => t("Custom Pattern"),
                            "desc" => "Click to choose",
                            "id" => "bg_top_custom",
                            "type" => "file"
                    ),
                    array (
                            "name" => t("Shadow"),
                            "desc" => t("Display a emboss shadow at the top or bottom of the header color"),
                            "id" => "bg_top_shadow",
                            "default" => 'none',
                            "options" => array('none'=>t("No shadow"),
					       '7_top'=>t("7px top"),
					       '7_bottom'=>t("7px bottom"),
					       '12_top'=>t("12px top"),
					       '12_bottom'=>t("12px Bottom")
					       ),
                            "type" => "select"
                    ),
                    array (
                            "name" => t("Display light on logo"),
                            "desc" => '',
                            "id" => "bg_top_light",
                            "value"=>'background',
                            "activated" => true,
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

// ----- Body ------------- //
		 array (
			'name'=>t("Body background"),
			'type'=>'start'
		 ),
		    array(
			    "name" => t("Body background color"),
			    "desc" => "",
			    "id" => "bg_body_color",
			    "default" => "#efefef",
			    "type" => "color"
		    ),
                    array (
                            "name" => t("Body page Pattern"),
                            "desc" => t("Select which pattern to use on the hole page."),
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
			    "name" => t("Main & sidebar"),
			    "desc" => "",
			    "type" => "section"
		    ),
		    array(
			    "name" => t("Main Content background Color"),
			    "desc" => "",
			    "id" => "bg_main_color",
			    "default" => "#ffffff",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Sidebar background Color"),
			    "desc" => "",
			    "id" => "bg_sidebar_color",
			    "default" => "#F8F9F8",
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

// ----- Navigation ------- //
		 array (
			'name'=>t("Top Navigation background"),
			'type'=>'start'
		 ),
		    array(
			    "name" => t("Drop down navigation & Lateral nav on mobile background color"),
			    "desc" => "",
			    "id" => "bg_nav_color",
			    "default" => "#464f5c",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Drop down navigation color Second level"),
			    "desc" => "",
			    "id" => "bg_second_nav_color",
			    "default" => "#464f5c",
			    "type" => "color"
		    ),
                    array (
                            "name" => t("Drop down navigation Light"),
                            "desc" => t("Display a light shot on the background"),
                            "id" => "bg_nav_light",
                            "default" => 'noise',
                            "options" => array('none'=>t("none"),
					       'ultra_light'=>t("light"),
					       'light'=>t("normal")
					       ),
                            "type" => "select"
                    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),

// ------ Footer ---------- //

		 array (
			'name'=>t("Page background"),
			'type'=>'start'
		 ),
		    array(
			    "name" => t("Footer background Color"),
			    "desc" => "",
			    "id" => "bg_footer_color",
			    "default" => "#464f5c",
			    "type" => "color"
		    ),
		    array(
			    "name" => t("Footer page background Color"),
			    "desc" => "",
			    "id" => "bg_footer_page_color",
			    "default" => "#464f5c",
			    "type" => "color"
		    ),
                    array (
                            "name" => t("Footer page Pattern"),
                            "desc" => t("Select which pattern to use on the hole page."),
                            "id" => "bg_footer_pattern",
                            "default" => 'square',
                            "options" => $pattern_list,
                            "type" => "select"
                    ),
                    array(
                            "name" => t("Custom Pattern"),
                            "desc" => "Click to choose",
                            "id" => "bg_footer_custom",
                            "type" => "file"
                    ),
                    array (
                            "name" => t("Shadow"),
                            "desc" => t("Display a emboss shadow at the top or bottom of the footer color"),
                            "id" => "bg_footer_shadow",
                            "default" => 'none',
                            "options" => array('none'=>t("No shadow"),
					       '7_top'=>t("7px top"),
					       '7_bottom'=>t("7px bottom"),
					       '12_top'=>t("12px top"),
					       '12_bottom'=>t("12px Bottom")
					       ),
                            "type" => "select"
                    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		)

		 );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
