<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php  echo $this->action('view')?>" method="post" id="preset_to_edit">
	<?php  $poh->output_presets_list(true, $pID)?>
    </form>
<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;	</div>

<?php 
$options = array(
     array(
    	'name'=>t("Pages list Globals"),
    	'type'=>'start'
     ),
        array(
            "name" => t("Display a link button"),
            'desc' => t('(only for fullpage slider)'),
            "id" => "page_list_read_more",
            "value"=>'page_list',
            "default" => true,
            "type" => "toggle"
        ),
        array(
            'name'=>t("'Read more' custom text"),
            'id'=>'page_lists_read_more_text',
            "default" => t("Go"),
            'size'=>30,
            'type'=>'text'
        ),
       
// ----- Reviews ------ //

        array(
                "name" => t("Page-list template : 'Reviews'"),
                "type" => "section"
        ),
        array(
                "name" => t("Display Page meta (comments, creator,..)"),
                "id" => "page_list_1_meta",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),

// ------ Tiny -------- //

        array(
                "name" => t("Page-list template : 'Tiny'"),
                "type" => "section"
        ),
        array(
                "name" => t("Display Page Title"),
                "id" => "page_list_3_title",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display Page description"),
                "id" => "page_list_3_description",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),
/*
// ------ Easy page_list -------- //

        array(
                "name" => t("Easy page_list (Activated by page attribute : Transform all header's blocks into slides)"),
                "type" => "accordion_section"
        ),
        array(
                "name" => t("Display navigation bullets"),
                "id" => "easy_page_list_bullets",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display navigation arrows (left&right)"),
                "id" => "easy_page_list_arrows",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Enable autoscroll"),
                "id" => "easy_page_list_autoscroll",
                "value"=>'page_list',
                "default" => true,
                "type" => "toggle"
        ),
        array (
                "name" => t("Interval time"),
                "desc" => t("The time (in milliseconds) between autoscrolls."),
                "id" => "easy_page_list_interval",
                "min" => "100",
                "max" => "10000",
                "step" => "10",
                "unit" => 'ms',
                "default" => "1000",
                "type" => "range"
        ),
        array (
                "name" => t("Scroll Speed"),
                "id" => "easy_page_list_scroll_speed",
                "min" => "100",
                "max" => "2000",
                "step" => "10",
                "unit" => 'ms',
                "default" => "400",
                "type" => "range"
        ),
*/

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
