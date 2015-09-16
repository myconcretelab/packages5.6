<?php 
defined('C5_EXECUTE') or die("Access Denied.");
/* 
--- Designer, look at here. It easy to create custom templates. ---

 * Values available for diplaying :
 -----------------------------------
 * $iconName : the class name that define the icon
 * $size the size class for icon : icon-large, icon-2x, ..
 * $mainColor : The first color choosed
 * $secondColor : the second color
 * $titleText : the Title
 * $contentText : the Content
 * $linkTo : the url to link
 * $textLink : The text to the link

Good luck !
*/

?>

<table class="icooon-table icooon">
	<tr>
		<td class="i-icon">
			<i class="<?php echo $iconName ?> <?php echo $size ?> icooon" style="color:<?php echo $mainColor?>;"></i>
		</td>
		<td>
			<h3 style="color:<?php echo $mainColor?>"><?php echo html_entity_decode($titleText) ?></h3>			
			<p><?php echo $contentText ?></p>
		</td>
		<?php if (isset($linkTo)) : ?>
		<td style="text-align:right">
			<a href="<?php echo $linkTo ?>" class="button button-flat-primary" target="_blank"><?php echo $textLink ?> <i class="fa fa-arrow-right"></i></a>			
		</td>
		<?php endif ?>
	</tr>

</table>

