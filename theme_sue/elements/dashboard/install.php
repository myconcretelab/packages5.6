<?php 
defined('C5_EXECUTE') or die("Access Denied.");


Loader::model('theme_sue_options', 'theme_sue');
$options = new ThemeSueOptions();
$defaultvalues = $options->get_default_values_array();
$i = 0;
?>
<label for="theme">Choose wich color scheme you want as default <small>Don't worry, this can be changed in the 'option preset' page.</small></label>
<br>
<ul class="thumbnails">
	<?php foreach ($defaultvalues as $name => $valuearray) : ?>
	  <li class="span3">
    <div class="thumbnail">
    	<h3><?php echo $name?></h3>
      	<img src="<? echo  REL_DIR_PACKAGES . '/theme_sue/images/assets/sue-' . $name .'.png' ?>" alt="">
      	<hr>
      	<input class='btn' name="theme" type="radio" value="<?php echo $name?>" <?php echo $i == 1 ? 'checked' : ''?> >&nbsp;
		<small>Choose <strong><?php echo $name?></strong> a default</small>
		<br><br>
			

    </div>
  </li>
	<?php $i++; endforeach ?>
</ul>
