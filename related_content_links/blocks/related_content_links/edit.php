<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<table border="0">
	<tr>
		<td align="right"><strong><?php echo t('Display Links in Category'); ?>: </strong></td>
		<td align="left">
			<?php
			$options = array('0' => t('--Choose--'));
			foreach ($categories as $category) {
				$options[$category->ID] = htmlspecialchars($category->value, ENT_QUOTES, APP_CHARSET);
			}
			echo $form->select('relatedCategoryOptionID', $options, $relatedCategoryOptionID);
			?>
		</td>
	</tr>
	<tr>
		<td align="right"><strong><?php echo t('Number of Links'); ?>: </strong></td>
		<td align="left"><?php echo $form->text('displayCount', $displayCount, array('size' => '3', 'maxlength' => '2')); ?></td>
	</tr>
	<tr>
		<td align="right"><strong><?php echo t('Link Display Order'); ?>: </strong></td>
		<td align="left"><?php echo $form->select('displayOrder', array('RECENT' => t('Most Recent First'), 'SITEMAP' => t('Sitemap Order')), $displayOrder); ?></td>
	</tr>
	<tr>
		<td align="right"><strong><?php echo t('Block Title'); ?>: </strong></td>
		<td align="left"><?php echo $form->text('title', $title); ?></td>
	</tr>
	<tr>
		<td align="right"><strong><?php echo t('Date Style'); ?>: </strong></td>
		<td align="left">
			<?php
			$options = array();
			foreach ($dateFormats as $key => $format) {
				$options[$key] = empty($format) ? t('Do not show date') : date($format, 1295856000); //2011-01-24
			}
			echo $form->select('dateFormat', $options, $dateFormat);
			?>
		</td>
	</tr>
</table>
<hr />