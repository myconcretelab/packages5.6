<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php  echo $this->action('view')?>" method="post" id="preset_to_edit">
	   <?php  $poh->output_presets_list(true, $pID)?>
    </form>
<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;	</div>

<?php 
// sprintf
$options = array(
		 array(
			'name'=> t("Header Options"),
			'type'=>'start'
		 ),
        array(
            "name" => t("Responsive"),
            "desc" => "",
            "type" => "section"
        ),          
        array(
                "name" => t("Enable responsive layout"),
                "desc" => t("If enabled, all layouts will be adapted for small screen like mobile (otherwise the site will be rendered as desktop on mobile & tablets)"),
                "id" => "responsive",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),
        array(
            "name" => t("Page infos"),
            "desc" => "",
            "type" => "section"
        ),         
        array(
                "name" => t("Choose a page for searching result"),
                "desc" => t("Display Search box in the top of the page if a page is selected. Add a block search on this page to display result."),
                "id" => "display_searchbox",
                "default"=>'0',
                "quick"=> false,
                "activated" => true,
                "type" => "page"
        ),
        array(
                "name" => t("Display Box on top of page with name, description and breadcrumb"),
                "desc" => t("DIf disabled all the box will not be showed"),
                "id" => "display_top_box",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display Page Title"),
                "desc" => t("Display page title in the top of the page (not on 'Home Page' page type)"),
                "id" => "display_page_title",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display Page Description"),
                "desc" => t("Display page description in the top of the page (not on 'headered' page type)"),
                "id" => "display_page_desc",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display Breadcrumb"),
                "desc" => t("Display Breadcrumb in the top of the page (not on 'headered' page type)"),
                "id" => "display_breadcrumb",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),         
        array(
                "name" => t("Sidebar width size"),
                "id" => "sidebar_size",
                "default" => 4,
                "options" => array(
                        5 => t("Large"),
                        4 => t("Normal"),
                        3 => t("thin")
                ),
                "type" => "select"
        ),        
        array(
            "name" => t("Supermint Navigation"),
            "desc" => t('Options for navigation in supermint'),
            "type" => "section"
        ),  
        array(
                "name" => t("Enable Sliding menu"),
                "desc" => t("If disabled, a dropdown with mega menu will be shown"),
                "id" => "slide_nav",
                "value"=>'options',
                "activated" => true,
                "type" => "toggle"
        ),      
        array(
                // Changer cet input en select : sliding ou dropdown
                "name" => t("Disable Auto embed navigation"),
                "desc" => t("If disabled,a global area will let you put whitch block you want for nav"),
                "id" => "disable_embed_nav",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),
        array(
            "name" => t("Mega menu options"),
            //"desc" => t('Some option when drpdown mode'),
            "type" => "section"
        ),          
        array(
                "name" => t("Mega menu position when dropdown mode"),
                "desc" => t("Display a mega menu as full with or under parent"),
                "id" => "full_width_mega",
                "default" => 1,
                "options" => array(
                        0 => t("Aligned on left of the parent (dropdown mode) / fixed columns width (slider) "),
                        1 => t("Full width mega-menu")
                ),
                "type" => "select"
        ),
        array(
                "name" => t("Mega columns width"),
                "desc" => t("Columns width on mega menu mode when not on full width"),
                "id" => "mega_columns_width",
                "min" => "100",
                "max" => "600",
                "step" => "10",
                "unit" => 'px',
                "default" => "200",
                "type" => "range"
        ),        
        array(
                // Pourra etre changé en toggle quand le nouveau moteur d'options sera en place
                "name" => t("Mega block title when exist"),
                "desc" => t("Display the block name as title"),
                "id" => "display_title_mega_menu",
                "default" => 0,
                "options" => array(
                        0 => t("Yes"),
                        1 => t("No")
                ),
                "type" => "select"
        ),
        array(
            "name" => t("Slide Navigation"),
            "desc" => t('You can set here some options for the sliding menu'),
            "type" => "section"
        ),  
        array(
                "name" => t("Navigation Event"),
                "desc" => t("Choose the event that activate the sliding menu (not on dropdown)"),
                "id" => "nav_event",
                "default" => t("click"),
                "options" => array(
                        "click" => t("Click"),
                        "mouseenter" => t("On hover")
                ),
                "type" => "select"
        ),
        array(
                "name" => t("Navigation Double click management"),
                "desc" => t("Choose to open/close or go to the url on second click)"),
                "id" => "nav_dbl_click_event",
                "default" => t("url"),
                "options" => array(
                        "url" => t("Go to the Url"),
                        "toggle" => t("Toggle open/close")
                ),
                "type" => "select"
        ),        array(
                "name" => t("Force mobile comportement on desktop"),
                "desc" => t("If enabled, Subnavs will open always on left "),
                "id" => "force_mobile_nav",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),
	   array(
                "name" => t("Display a select box on mobile"),
                "desc" => t("If enabled, all the navigation will be reduced into a selectbox, otherwise, the navigation will be adapted to mobile"),
                "id" => "select_nav_mobile",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),  
        array(
                "name" => t("Open on load"),
                "desc" => t("If enabled, Subnavs will be open they are one subpage active, else subnavs are always closed "),
                "id" => "nav_open_on_load",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),
        array(
                "name" => t("Display little arrow on right"),
                "id" => "nav_slide_arrow",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),
        array(
            "name" => t("Little arrow color"),
            "id" => "nav_slide_arrow_color",
            "default" => "#18aedf",
            "type" => "color"
        ),         
        array(
                "name" => t("Display pane title"),
                "desc" => t("Display the first level page title & link on the top of each subnav panes"),
                "id" => "display_pane_title",
                "value"=>'options',
                "activated" => false,
                "type" => "toggle"
        ),      
        array(
                "name" => t("Navigation column"),
                "desc" => t("How many column you want in the sub navs"),
                "id" => "nav_columns",
                "default" => t("Five"),
                "options" => array(
                        "1" => t("One"),
                        "2" => t("Two"),
                        "3" => t("Three"),
                        "4" => t("Four"),
                        "6" => t("Six")
                ),
                "type" => "select"
        ),
        array(
                "name" => t("Columns margin"),
                "desc" => t("Set space between columns in percent"),
                "id" => "nav_columns_margin",
                "min" => "0",
                "max" => "15",
                "step" => "1",
                "unit" => '%',
                "default" => "2",
                "type" => "range"
        ),
        array(
                "name" => t("Open speed"),
                "desc" => t("Set the speed to open the nav"),
                "id" => "nav_open_speed",
                "min" => "0",
                "max" => "1000",
                "step" => "10",
                "unit" => 'ms',
                "default" => "300",
                "type" => "range"
        ),
        array(
                "name" => t("Close speed"),
                "desc" => t("Set the speed to close the nav"),
                "id" => "nav_close_speed",
                "min" => "0",
                "max" => "1000",
                "step" => "10",
                "unit" => 'ms',
                "default" => "300",
                "type" => "range"
        ),        
        array(
                "name" => t("Slide speed"),
                "desc" => t("Set the speed when subnavs slide"),
                "id" => "nav_slide_speed",
                "min" => "0",
                "max" => "1000",
                "step" => "10",
                "unit" => 'ms',
                "default" => "300",
                "type" => "range"
        ),        
        array(
                "name" => t("On mouse leave delay"),
                "desc" => t("Set the how many time wait, after the mouse leave the nav for close the nav"),
                "id" => "nav_mouseleave_delay",
                "min" => "0",
                "max" => "10000",
                "step" => "100",
                "unit" => 'ms',
                "default" => "1000",
                "type" => "range"
        ),
        array(
                "name" => t("Shorten description on subnavs"),
                "desc" => t("If set to 0 all description text will be displayed"),
                "id" => "nav_shorten_desc",
                "min" => "0",
                "max" => "800",
                "step" => "5",
                "unit" => 'Char',
                "default" => "0",
                "type" => "range"
        ),  
        array(
			'type'=>'submit',
			'name'=>t("Save !"),
			'id'=>'saved'
		),
                array(
			'type'=>'stop'
		),
		 array(
			'name'=>t("Footer"),
			'type'=>'start'
		 ),
        array(
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
            "type" => "select"
        ),
        array(
            "name" => t("Make Footer Global"),
            "desc" => t("If enabled, Block on footer will be Globals"),
            "id" => "footer_global",
            "value"=>'options',
            "activated" => false,
            "type" => "toggle"
        ),  
        array(
            "name" => t("Enable the fixed footer"),
            "desc" => t("This is a nice effect but sometimes we need do desactivate it"),
            "id" => "footer_fixed",
            "value"=>'options',
            "activated" => true,
            "type" => "toggle"
        ),
        array(
            "name" => t("RAW HTML Credits"),
            "desc" => t("If you want to change it, feel free"),
            "id" => "footer_credit",
            "cols" => 40,
            "type" => "textarea",
            "default" => '<span><i class="fa fa-magic"></i> Designed by <a href="http://www.myconcretelab.com/" rel="Concrete5 theme & addons" title="Concrete5 themes & addons by MyConcreteLab">MyConcreteLab</a></span><span class="powered-by"><i class="fa fa-cogs"></i> Powered by <a href="http://www.concrete5.org" title="concrete5 - open source content management system for PHP and MySQL">concrete5</a></span>'
        ),
        array(
            'type'=>'submit',
            'name'=>t("Save !"),
            'id'=>'saved'
        ),
        array(
            'type'=>'stop'
        ),
         array(
            'name'=>t("Advanced"),
            'type'=>'start'
         ),
         array(
                "name" => t("Activate iFrame z-index script"),
                "desc" => t("This script fix a iFrame z-index isue on certain condition."),
                "id" => "fix_iframe_zindex",
                "value"=>'options',
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
		)

	    );


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID));
