<?php     defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php    echo $this->action('view')?>" method="post" id="preset_to_edit">
    <?php    $poh->output_presets_list(true, $pID)?>
    </form>
<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;   </div>

<?php     
$options = array(
		 array (
			'name'=>t("Pages list Globals"),
			'type'=>'start'
		 ),
                    array(
                            "name" => t("Display page list meta 'creator'"),
                            "desc" => t('Disable if you don\'t want the creator\'s page name'),
                            "id" => "display_meta_creator",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list Description"),
                            "id" => "page_list_description",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list Title"),
                            "id" => "page_list_title",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list meta 'creator' as link"),
                            "desc" => t('If activated, the name of the creator redirect to her profile '),
                            "id" => "display_meta_creator_link",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list meta 'tag'"),
                            "id" => "display_meta_tag",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list meta 'Comments count'"),
                            "id" => "display_meta_comments",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display page list meta 'Date of creation'"),
                            "id" => "display_meta_date",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display 'Read more' AS button"),
			    'desc'=>'If selected, the link "Read More" will be displayed as buton, else, as simple link"',
                            "id" => "page_list_read_more_button",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display 'Read more' button"),
                            "id" => "page_list_read_more",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            'name'=>t("'Read more' custom text"),
                            'id'=>'page_list_read_more_text',
                            "default" => t("Read More"),
                            'size'=>30,
                            'type'=>'text'
                    ),
                    array(
                            "name" => t("Crop image"),
                            "id" => "page_list_crop",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Image Quality"),
                            "desc" => t("Set the quality of the thumbnail created (higher = much loaded time = better quality)"),
                            "id" => "jpg_quality",
                            "min" => "50",
                            "max" => "100",
                            "step" => "5",
                            "unit" => '',
                            "default" => "90",
                            "type" => "range"
                    ),
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),

// Accordion page list Scrollable Start 1
		 array (
			'name'=>t("Pages list Navigable"),
			'type'=>'start'
		 ),
                    array(
                            "name" => t("Page list one column Scrollable"),
                            "type" => "accordion_start"
                    ),
                    array(
                            "name" => t("Display in two column"),
                            "id" => "page_list_1_two_column",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page Title"),
                            "id" => "page_list_1_title",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page description"),
                            "id" => "page_list_1_description",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display a shadow under picture"),
                            "id" => "page_list_1_shadow",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation bullets"),
                            "id" => "page_list_1_bullets",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation arrows (left&right)"),
                            "id" => "page_list_1_arrows",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable autoscroll"),
                            "id" => "page_list_1_autoscroll",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Image Width"),
                            "desc" => t("The width of the main image."),
                            "id" => "page_list_1_image_width",
                            "min" => "10",
                            "max" => "1500",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "600",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Image Height"),
                            "desc" => t("The height of the main image."),
                            "id" => "page_list_1_image_height",
                            "min" => "10",
                            "max" => "800",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "350",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Interval time"),
                            "desc" => t("The time (in milliseconds) between autoscrolls."),
                            "id" => "page_list_1_interval",
                            "min" => "100",
                            "max" => "10000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "1000",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Scroll Speed"),
                            "id" => "page_list_1_scroll_speed",
                            "min" => "100",
                            "max" => "2000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "400",
                            "type" => "range"
                    ),
// Accordion Section 2
                    array(
                            "name" => t("Page list two, Three, Four column Scrollable"),
                            "type" => "accordion_section"
                    ),
                    array(
                            "name" => t("Display Page Title"),
                            "id" => "page_list_navi_title",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page description"),
                            "id" => "page_list_navi_description",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation bullets"),
                            "id" => "page_list_navi_bullets",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation arrows (left&right)"),
                            "id" => "page_list_navi_arrows",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable autoscroll"),
                            "id" => "page_list_navi_autoscroll",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Interval time"),
                            "desc" => t("The time (in milliseconds) between autoscrolls."),
                            "id" => "page_list_navi_interval",
                            "min" => "100",
                            "max" => "10000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "1000",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Scroll Speed"),
                            "id" => "page_list_navi_scroll_speed",
                            "min" => "100",
                            "max" => "2000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "400",
                            "type" => "range"
                    ),
                    array(
                            "type" => "accordion_stop"
                    ),
// Accordion stop
		array (
			'type'=>'stop'
		),
		array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),
		 array (
			'name'=>t("Pages list Navigable"),
			'type'=>'start'
		 ),
                    array(
                            "name" => t("Display 'Sort by Category'"),
                            "desc" => t('Disable if you don\'t want the Categories sorting'),
                            "id" => "sort_category",
                            "value"=>'page_list',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display 'Sort by Alhabetical'"),
                            "desc" => t('Disable if you don\'t want the Date sorting'),
                            "id" => "sort_alphabetical",
                            "value"=>'page_list',
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
		)
		 );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
