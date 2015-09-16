<?php     defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php    echo $this->action('view')?>" method="post" id="preset_to_edit">
    <?php    $poh->output_presets_list(true, $pID)?>
    </form>
<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;   </div>

<?php     
// sprintf
$options = array(
		 array (
			'name'=> t("Header Options"),
			'type'=>'start'
		 ),
                    array (
                            "name" => t("Display Page Title"),
                            "desc" => t("Display page title in the top of the page (not on 'headered' page type)"),
                            "id" => "display_page_title",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Display Page Description"),
                            "desc" => t("Display page description in the top of the page (not on 'headered' page type)"),
                            "id" => "display_page_desc",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Display Breadcrumb"),
                            "desc" => t("Display Breadcrumb in the top of the page (not on 'headered' page type)"),
                            "id" => "display_breadcrumb",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Display Search box"),
                            "desc" => t("Display Search box in the top of the page"),
                            "id" => "display_searchbox",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Hide Search box on Mobiles"),
                            "desc" => t("If activated, the search box will be hidden in small screen like mobile"),
                            "id" => "hide_searchbox_on_mobile",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Hide Sidebar on Mobiles"),
                            "desc" => t("If activated, the sidebar will be hidden in small screen like mobile, better to a clear content"),
                            "id" => "hide_sidebar_on_mobile",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Disable the mobile detection"),
                            "desc" => t("If set to off, some part of the layout will be adapted for mobile. If set to on the website will have exactly the same face on desktop or mobile screen."),
                            "id" => "disable_mobile_detection",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),
                array (
			'type'=>'stop'
		),
// Headered Page type
		 array (
			'name'=>t("Headered Page Type"),
			'type'=>'start'
		 ),
                    array (
                            "name" => t("Make header transparent"),
                            "desc" => t("If activated, the header is staying transparent (ideal for some header content or sliders)"),
                            "id" => "header_transparent",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Padding inside header"),
                            "desc" => t("If activated, the header is displayed with padding inside of it (ideal to desactive for some header content or sliders)"),
                            "id" => "header_padding",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Shadow around header"),
                            "desc" => t("If activated, the header is displayed with shadow around of it (not on non-css3 browser)"),
                            "id" => "header_shadow",
                            "value"=>'options',
                            "activated" => false,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Display 'Main' area"),
                            "desc" => t("If desactivated, only the 'Whithout Frame' Area will be displayed (really beautiful with certain content like portfolio)"),
                            "id" => "display_main_area",
                            "value"=>'options',
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
		 array (
			'name'=>t("Footer"),
			'type'=>'start'
		 ),
                    array (
                            "name" => t("Display footer"),
                            "desc" => t("If you don't want display footer, turn off the button."),
                            "id" => "display_footer",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Make Footer as Global area"),
                            "desc" => t("If activated blocks into footer area will be sitewide displayed"),
                            "id" => "footer_global",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Display round corner on footer"),
                            "id" => "footer_rounded",
                            "value"=>'options',
                            "activated" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Footer column"),
                            "desc" => t("How many column you want in the footer"),
                            "id" => "display_footer_column",
                            "default" => t("Three"),
                            "options" => array(
                                    "1" => t("One"),
                                    "2" => t("Two"),
                                    "3" => t("Three"),
                                    "4" => t("Four"),
                                    "half_two" => t("One Half and two"),
                                    "half_three" => t("One Half and three"),
                            ),
                            "type" => "select",
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
