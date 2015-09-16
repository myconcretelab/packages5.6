<?php   defined('C5_EXECUTE') or die(_("Access Denied."));

?>

<div class="ccm-ui" id="ccm-dashboard-result-message" style="display: none;">
    <div class="row">
        <div class="span12">

        </div>
    </div>
</div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper( $windowName,  false, 'span12', true)?>
<?php if($is_ecommerce) : ?>
<form action="<?php echo $this->action('save_categories') ?>" id="ppc_form" method="post" enctype="multipart/form-data">
        <?php 
       // On extrait toutes les données envoyé par les options plus haut
        if (!count($pages)) : ?><div class="alert alert-error"><?php echo t('You must pick at least one page with the attribute "This is a product page Category"') ?><button type="button" class="close" data-dismiss="alert">×</button></div> <?php endif;
        // Pour chaque pages de produits
        foreach ($pages as $cID => $pc) :
            $page = Page::getByID($cID);
         ?>
        <input type="hidden" name="cID[]" value="<?php echo $cID ?>">
        <div class="row-fluid">
            <div class="span2"><h4><?php echo $page->getCollectionName()?></h4></div>
            <div class="span3">
                <strong><?php echo t('Category to show on navigation') ?></strong>
                <hr>
                <select id="akID_<?php echo $cID?>"
                        name="akID[<?php echo $cID?>][]" 
                        data-placeholder="Add a category" 
                        multiple 
                        class="chzn-select" 
                        data-relcontainer="#categories_box_<?php echo $cID?>" 
                        data-cid="<?php echo $cID?>">
                    <?php foreach ($categories as $key => $cat) : ?>
                        <option value="<?php echo $cat->akID ?>" <?php echo isset($pc->categories[$cat->akID]) ? 'selected' : '' ?>><?php echo $cat->akName ?></option>
                    <?php endforeach ?>
                </select>
                <hr>
                <strong><?php echo t('Limit the number of columns') ?></strong>         
                <select name="columns[<?php echo $cID?>]" id="">
                    <option value="0" <?php echo 0 == $pc->columns ? 'selected' : '' ?> ><?php echo('No limit') ?></option>
                    <option value="2" <?php echo 2 == $pc->columns ? 'selected' : '' ?> ><?php echo('2 columns') ?></option>
                    <option value="3" <?php echo 3 == $pc->columns ? 'selected' : '' ?> ><?php echo('3 columns') ?></option>
                    <option value="4" <?php echo 4 == $pc->columns ? 'selected' : '' ?> ><?php echo('4 columns') ?></option>
                    <option value="6" <?php echo 6 == $pc->columns ? 'selected' : '' ?> ><?php echo('6 columns') ?></option>
                </select>
                <hr>
                <strong><?php echo t('Navigation position (for drop mode only)') ?></strong>         
                <select name="full_width_mega[<?php echo $cID?>]" id="">
                    <option value="0" <?php echo 0 == $pc->full_width_mega ? 'selected' : '' ?> ><?php echo('As theme default') ?></option>
                    <option value="align" <?php echo 'align' == $pc->full_width_mega ? 'selected' : '' ?> ><?php echo('Aligned to the parent') ?></option>
                    <option value="full" <?php echo 'full' == $pc->full_width_mega ? 'selected' : '' ?> ><?php echo('Full with') ?></option>
                </select>
                <hr>
                <strong><?php echo t('Display options that doesn\'t contains products') ?></strong>         
                <select name="display_empty_categories[<?php echo $cID?>]" id="">
                    <option value="default" <?php echo 'default' == $pc->display_empty_categories ? 'selected' : '' ?> ><?php echo('As default below') ?></option>
                    <option value="1" <?php echo '1' == $pc->display_empty_categories ? 'selected' : '' ?> ><?php echo('Yes') ?></option>
                    <option value="0" <?php echo '0' == $pc->display_empty_categories ? 'selected' : '' ?> ><?php echo('No') ?></option>
                </select>   
                <hr>
                <strong><?php echo t('Show products count (5) on nav') ?></strong>         
                <select name="show_product_count_on_nav[<?php echo $cID?>]" id="">
                    <option value="1" <?php echo '1' == $pc->show_product_count_on_nav ? 'selected' : '' ?> ><?php echo('Yes') ?></option>
                    <option value="0" <?php echo '0' == $pc->show_product_count_on_nav ? 'selected' : '' ?> ><?php echo('No') ?></option>
                </select>                                
                <hr>
                <strong><?php echo t('Allow multiple categorie to be picked') ?></strong>         
                <select name="alow_multiple_choice[<?php echo $cID?>]" id="">
                    <option value="1" <?php echo '1' == $pc->alow_multiple_choice ? 'selected' : '' ?> ><?php echo('Yes') ?></option>
                    <option value="0" <?php echo '0' == $pc->alow_multiple_choice ? 'selected' : '' ?> ><?php echo('No') ?></option>
                </select>                                
            </div>
            <div class="span3" id="categories_box_<?php echo $cID?>">
                <strong><?php echo t('Picked categories') ?></strong>
                <hr>
                    <?php 
                    if (is_array($pc->categories)) :
                    foreach ($pc->categories as $akID => $akObj) {
                        echo "<div id='{$akID}_container_{$cID}' data-akid='$akID' class='product_category'>";
                        $this->controller->category_ajax($akID,$cID,$pc->akID[$akID],true);
                        echo "</div>";                        
                    }
                    endif;
                    ?>
            </div>
                 
            <div class="span3"> 

                <!-- Result page -->

                <strong><?php echo t('Pick a result page') ?></strong>
                
                <?php echo Loader::helper('form/page_selector')->selectPage('category_result_page[' . $cID .']' ,$pc->category_result_page)  ?>
                <hr>
                <?php  
                Loader::model('product/set', 'core_commerce');
                $productSets = CoreCommerceProductSet::getList();
                $form = Loader::helper('form');
                ?>
                <strong><?php echo t('Choose a Product Set for this category') ?></strong>
                <?php  if (count($productSets) > 0) : ?>
                    <select name="prSet[<?php echo $cID?>]">
                    <?php  foreach($productSets as $prs) : ?>
                            <option value="<?php echo $prs->getProductSetID() ?>"
                                    <?php echo $prs->getProductSetID() == $pc->prSet ? 'selected' : '' ?> ><?php echo  $prs->getProductSetName() ?></option>
                <?php  endforeach ?>
                    </select>

                <?php else : ?>
                    <?php echo t("No product sets created.")?>
                <?php  endif ?>            
        </div>  
    </div>
        <hr>    
        <?php endforeach ?>

</div>

    <div class="ccm-pane-footer">
        <a href="<?php echo $this->url('/dashboard/core_commerce/creative_slider')?>" class="btn"><?php echo t('Cancel')?></a>
        <input type="submit" class="btn primary ccm-button-right" value="<?php echo $slide->cssID ? t('Save edits') : t('Save')?>" /> 
    </div>
</form> 
</div>



<div class="clear" style="height:24px">&nbsp;	</div>

<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Select a Preset options to edit.'), false, 'span12', true) ?>
    <form action="<?php  echo $this->action('view')?>" method="post" id="preset_to_edit">
    <?php  $poh->output_presets_list(true, $pID)?>
    </form>
<?php  echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(true) ?>

<div class="clear" style="height:24px">&nbsp;   </div>

<?php
$options = array(
     array(
        'name'=> t("eCommerce Options"),
        'type'=>'start'
     ),
/* Plus besoin vu que le menu est devenu inteligent !!!
   array(
        "name" => t("Navigation for ecommerce"),
        "type" => "section"
        ),    
    array(
        "name" => t("Display a link to show the full page category"),
        "desc" => t(""),
        "id" => "display_full_category_link",
        "value"=>'e_commerce',
        "activated" => true,
        "type" => "toggle"
    ),
*/
   array(
        "name" => t("Block Product List"),
        "desc" => t('This option let you customize some option for the Product List Block'),
        "type" => "section"
        ),
    array(
        "name" => t("Number of columns fo categories in Product list block"),
        "id" => "categories_columns_number",
        "default" => 3,
        "options" => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Minimum price search"),
        "desc" => t("Set the minimum price search number in product list search form"),
        "id" => "min_price_search",
        "min" => "0",
        "max" => "1000",
        "step" => "1",
        "unit" => '$',
        "default" => "0",
        "type" => "range"
    ),    
    array(
        "name" => t("Maximum price search"),
        "desc" => t("Set the maximum price search number in product list search form"),
        "id" => "max_price_search",
        "min" => "0",
        "max" => "10000",
        "step" => "10",
        "unit" => '$',
        "default" => "1000",
        "type" => "range"
    ),    
    array(
        "name" => t("Maximum price search set by default"),
        "id" => "max_price_search_default",
        "min" => "0",
        "max" => "10000",
        "step" => "10",
        "unit" => '$',
        "default" => "1000",
        "type" => "range"
    ),    
    array(
        "name" => t("Minimum price search set by default"),
        "id" => "min_price_search_default",
        "min" => "0",
        "max" => "1000",
        "step" => "1",
        "unit" => '$',
        "default" => "0",
        "type" => "range"
    ), 
    array(
        "name" => t("Step to price search slider"),
        "id" => "step_price_search",
        "min" => "0",
        "max" => "100",
        "step" => "1",
        "unit" => '$',
        "default" => "1",
        "type" => "range"
    ),
    array(
        "name" => t("Activate quick edit links"),
        "id" => "quick_edit_product",
        "default" => 0,
        "options" => array(
                0 => t('None'),
                1 => t('Simple edit')
        ),
        "type" => "select"
    ),
    array(
        "name" => t("Number of product on the page result when a category is clicked on the navigation"),
        "id" => "num_results",
        "min" => "0",
        "max" => "100",
        "step" => "1",
        "unit" => 'product',
        "default" => "24",
        "type" => "range"
    ),    
    array(
        "name" => t("Show simple search bar"),
        "id" => "display_simple_search",
        "default" => 0,
        "options" => array(
                0 => t('Hide'),
                1 => t('Show')
        ),
        "type" => "select"
    ),
   array(
        "name" => t("Block Cart links"),
        "desc" => t('This option let you customize some option for the Cart Links Block'),
        "type" => "section"
        ),    
    array(
        "name" => t("Background color"),
        "id" => "bg_cart_color",
        "default" => "#585f63",
        "type" => "color"
    ),    
    array(
        "name" => t("Text color"),
        "id" => "txt_cart_color",
        "default" => "#ffffff",
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


$form = new OptionsGeneratorHelper($options,$poh->get_options_from_preset_ID($pID), $this->action('save_options'),array('preset_edited'=>$pID))?>


<script>
      $(".chzn-select").chosen().change( function () {
        var t = $(this);
        var v = t.val();
        // le container qui contient toutes les categories
        var c = $(t.data('relcontainer'));
        var cID = t.data('cid');
        if(v) {

            // Pour chaque element selectionne dans le choose
            for (var i = v.length - 1; i >= 0; i--) {
                // le container de la categorie 
                var cat = $('#' + v[i] + '_container_' + cID, c);
                // Si le select de cette cat n'existe pas
                if(!cat.size()) {
                    $('<div>')
                        .attr('id', v[i] + '_container_' + cID)
                        .data('akID', v[i])
                        .addClass('product_category')
                        .load('<?php echo $this->action("category_ajax") ?>' + v[i] + '/' + cID)
                        .appendTo(c);
                } else {
                    // Si le select existe, on verifie si il existe aussi 
                    // dans le tableau des options select
                    var cats = c.children('.product_category');
                    //console.log(cats);
                    for (var j = cats.length - 1; j >= 0; j--) {
                        // Si il existe en vrai et pas ds le tableau select.
                        // l'ID  de la categorie :
                        var co = $(cats[j]).data('akid');
                        if($.inArray(co.toString(),v) == -1){
                            // on le retire
                            $(cats[j]).remove();
                        }
                    };   
                }
            };

        } else {
            // Il n'y a pas d'options selectonnées
            // On supprime tout
            c.find('.product_category').remove();
        }
      } );
</script>
<?php endif ?>
