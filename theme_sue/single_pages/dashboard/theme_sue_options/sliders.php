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
			'name'=>t("Pages list Globals"),
			'type'=>'start'
		 ),
                    array(
                            "name" => t("Display a link button"),
			    'desc' => t('(only for fullpage slider)'),
                            "id" => "page_list_read_more",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            'name'=>t("'Read more' custom text"),
                            'id'=>'sliders_read_more_text',
                            "default" => t("Go"),
                            'size'=>30,
                            'type'=>'text'
                    ),
                    array(
                            "name" => t("Crop image"),
                            "id" => "page_list_crop",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable Background animation"),
			    "desc" => t('If enabled, a nice background animation is displayed behind the blocks.'),
                            "id" => "background_animation",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Custom Pattern"),
                            "desc" => "Click to choose another background than the diagonal white stripes",
                            "id" => "background_file",
                            "type" => "file"
                    ),
                    array(
                            "name" => t("Buttons style"),
                            "desc" => "Style for next/prev & bullet buttons",
                            "id" => "button_style",
                            "type" => "select",
			    "options"=>array('0'=>'style 1',
					   '1'=>'style 2',
					   '2'=>'style 3'
					   )
                    ),
// ----- Full Size Slider
                    array(
                            "name" => t("Page-list template : 'Slider Full Width'"),
                            "type" => "accordion_start"
                    ),
                    array(
                            "name" => t("Display Page Title"),
                            "id" => "page_list_1_title",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page meta (comments, creator,..)"),
                            "id" => "page_list_1_meta",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page description"),
                            "id" => "page_list_1_description",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation bullets"),
                            "id" => "page_list_1_bullets",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation arrows (left&right)"),
                            "id" => "page_list_1_arrows",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable autoscroll"),
                            "id" => "page_list_1_autoscroll",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
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
                    array (
                            "name" => t("Image Width"),
                            "desc" => t("The width of the main image."),
                            "id" => "page_list_1_image_width",
                            "min" => "10",
                            "max" => "1500",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "960",
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
                            "default" => "366",
                            "type" => "range"
                    ),
// Accordion Section 2
                    array(
                            "name" => t("Page-list template : 'Slider 3 columns'"),
                            "type" => "accordion_section"
                    ),
                    array(
                            "name" => t("Display Page Title"),
                            "id" => "page_list_3_title",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display Page description"),
                            "id" => "page_list_3_description",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation bullets"),
                            "id" => "page_list_3_bullets",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation arrows (left&right)"),
                            "id" => "page_list_3_arrows",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable Slideshow"),
                            "id" => "page_list_3_slideshow",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Interval time"),
                            "desc" => t("The time (in milliseconds) between autoscrolls."),
                            "id" => "page_list_3_interval",
                            "min" => "100",
                            "max" => "10000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "3000",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Scroll Speed"),
                            "id" => "page_list_3_scroll_speed",
                            "min" => "100",
                            "max" => "2000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "400",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Image Height"),
                            "desc" => t("The height of the main image."),
                            "id" => "page_list_3_image_height",
                            "min" => "10",
                            "max" => "800",
                            "step" => "1",
                            "unit" => 'px',
                            "default" => "366",
                            "type" => "range"
                    ),
// Accordion Section 2
                    array(
                            "name" => t("Easy slider (Activated by page attribute : Transform all header's blocks into slides)"),
                            "type" => "accordion_section"
                    ),
                    array(
                            "name" => t("Display navigation bullets"),
                            "id" => "easy_slider_bullets",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Display navigation arrows (left&right)"),
                            "id" => "easy_slider_arrows",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array(
                            "name" => t("Enable autoscroll"),
                            "id" => "easy_slider_autoscroll",
                            "value"=>'slider',
                            "default" => true,
                            "type" => "toggle"
                    ),
                    array (
                            "name" => t("Interval time"),
                            "desc" => t("The time (in milliseconds) between autoscrolls."),
                            "id" => "easy_slider_interval",
                            "min" => "100",
                            "max" => "10000",
                            "step" => "10",
                            "unit" => 'ms',
                            "default" => "1000",
                            "type" => "range"
                    ),
                    array (
                            "name" => t("Scroll Speed"),
                            "id" => "easy_slider_scroll_speed",
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
		)
		 );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
