<?php      defined('C5_EXECUTE') or die(_("Access Denied."))?>

<?php global $c; if ($c->isEditMode() ) : ?>

<div style="min-height:<?php   echo $height>0 ? $height : "200"?>px; background:#ccc;">
        <h3>Content disabled in edit mode</h3>
</div>

<?php endif?>
