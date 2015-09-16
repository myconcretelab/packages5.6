<?php defined('C5_EXECUTE') or die(_("Access Denied."));

if ($c->isEditMode()) : ?>

<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php   echo t('Kwiks Slider<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php endif ?>