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
    	'name'=>t("Font from Google"),
    	'type'=>'start'
     ),
    
    array(
        "name" => t("Fonts for Paragraphs  <br><b>P tag</>"),
        "desc" => t(""),
        "id" => "p",
        "default" => '',
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for alternate text <br><b>.alternate class</>"),
        "desc" => t("This font is used to create contrast."),
        "id" => "alternate",
        "default" => 'Pacifico',
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-1 <br><b>h1 tag</>"),
        "desc" => t(""),
        "id" => "h1",
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-2 <br><b>h2 tag</>"),
        "desc" => t(""),
        "id" => "h2",
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-3 <br><b>h3 tag</>"),
        "desc" => t(""),
        "id" => "h3",
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for Titles level-4  <br><b>h4 tag</>"),
        "desc" => t(""),
        "id" => "h4",
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for Titles leve 5  <br><b>h5 tag</>"),
        "desc" => t(""),
        "id" => "h5",
        "type" => "font"
    ),
    array(
        "name" => t("Fonts for small tags into heading"),
        "desc" => t("You can add rythm to your heading by adding a \<small\> tag into it"),
        "id" => "small",
        "type" => "font"
    ),
    array(
        "name" => t("Load default font"),
        "desc" => t("If all font are override here, this option allow you to avoid default font loading (nice for speed)"),
        "id" => "load_default_fonts",
        "value"=>'fonts',
        "activated" => true,
        "type" => "toggle"
    ),     
    array(
        'type'=>'stop'
    ),
    array(
        'type'=>'submit',
        'name'=>t("Save !"),
        'id'=>'saved'
    ),

/* --- Measurements --- */

     array(
        'name'=>t("Fonts size"),
        'type'=>'start'
     ),
     //This size is keeped for desktop display, recalculed for other device
    array(
        "name" => t("Fonts size for Paragraphs"),
        "desc" => t(""),
        "id" => "p_size",
        "default" => "14",
        "min" => 10,
        "max" => 25,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size for H1"),
        "desc" => t(""),
        "id" => "h1_size",
        "default" => "50",
        "min" => 12,
        "max" => 60,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size for H2"),
        "desc" => t(""),
        "id" => "h2_size",
        "default" => "35",
        "min" => 10,
        "max" => 45,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size for H3"),
        "desc" => t(""),
        "id" => "h3_size",
        "default" => "25",
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size for H4"),
        "desc" => t(""),
        "id" => "h4_size",
        "default" => "20",
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size for 'Lead' class"),
        "desc" => t(""),
        "id" => "lead_size",
        "default" => "14",
        "min" => 10,
        "max" => 35,
        "step" => 1,
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => t("Fonts size (in em) for small tag in titles"),
        "desc" => t(""),
        "id" => "small_tag_size",
        "default" => ".8",
        "min" => .1,
        "max" => 2,
        "step" => .1,
        "unit" => 'em',
        "type" => "range"
    ),
    array(
        "name" => t("Font variation"),
        "desc" => t(""),
        "type" => "section"
    ),
    array(
        "name" => t("Make H4 uppercase"),
        "desc" => t(""),
        "id" => "h4_upp",
        "value"=>'fonts',
        "activated" => true,
        "type" => "toggle"
    ),     

    array(
        "name" => t("Responsive text"),
        "desc" => t("Size above are used on regular display (between 980px & 1200px). To keep proportionalities, fonts are tailored to bigger & smaller screens with a ratio. You can adjust the ratio if the result does not satisfy you on your tablet or phone."),
        "type" => "section"
    ),
    array(
        "name" => t("Ratio for bigger desktop screen (more that 1200px)"),
        "desc" => t("I think the most popular screen size"),
        "id" => "wide_ratio",
        "default" => 1.24,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),
     array(
        "name" => t("Ratio for Portrait tablets "),
        "desc" => t(""),
        "id" => "w724_ratio",
        "default" => 1.30,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),  
     array(
        "name" => t("Ratio for Phones & tablets "),
        "desc" => t(""),
        "id" => "full_ratio",
        "default" => 1.30,
        "min" => 1,
        "max" => 2,
        "step" => .01,
        "unit" => '',
        "type" => "range"
    ),
     array(
        "name" => t("Text minimun limit."),
        "desc" => t("This option prevent to have too small text on tablet or mobiles."),
        "id" => "size_minimum",
        "default" => 12,
        "min" => 5,
        "max" => 20,
        "step" => 1,
        "unit" => '',
        "type" => "range"
    ),     
    array(
        'type'=>'stop'
    ),
    array(
        'type'=>'submit',
        'name'=>t("Save !"),
        'id'=>'saved'
    ),    
);



$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID), $pID);
?>
<script>
    var FONT_DETAILS_TOOLS_URL = "<?php echo Loader::helper('concrete/urls')->getToolsURL('font_details','theme_super_mint') ?>";
</script>