<?php       defined('C5_EXECUTE') or die(_("Access Denied.")); ?>


<form action="<?php      echo $this->action('edit_preset')?>" method="post">
    <?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Manage Options presets'), false, 'span12', false) ?>
    <div class="ccm-pane-body">
        <table cellpadding="20" cellspacing="1" class="entry-form zebra-striped" style="width:100%">
            <td class="subheader"><strong><?php      echo t("Name"); ?></strong></th>
            <td class="subheader"><strong><?php      echo t("Creator"); ?></strong></th>
            <td class="subheader"><strong><?php      echo t("Rename"); ?></strong></th>
            <td class="subheader"><strong><?php      echo t("Default Selection"); ?></strong></th>
            <td class="subheader"><strong><?php      echo t("Delete"); ?></strong></th>
    <?php      foreach ($list as $k=>$p) :
            $u = User::getByUserID($p['creator']);
        ?>
            <tr <?php      if ($p['pID'] == $poh->get_default_pID()) : ?> style="background:#DDF4FB"<?php      endif ?>>
                <td align='center'><?php      if ($p['pID'] == $poh->get_default_pID()) : ?><strong><?php      endif?><?php      echo $p['name']?><?php      if ($p['pID'] == $poh->get_default_pID()) : ?></strong><?php      endif?></td>
                <td align='center'><?php      echo $u->getUserName() ?></td>
                <td align='center'>
                    <?php      // if ($k != 0):?>
                    <input type="text" name="rename_<?php      echo $p['pID']?>" class="ccm-input-text" style="width:60%" />
                    <input type="submit" name="preset_to_rename_<?php      echo $p['pID']?>" value="<?php      echo t('Rename');?>" class="btn ccm-button-v2" />
                    <?php      // endif ?>
                </td>
                <td align='center'>
                    <?php      if ($p['pID'] != $poh->get_default_pID()) : ?>
                        <input type="submit" name="set_as_default_<?php      echo $p['pID']?>" value="<?php      echo t('Set as Default'); ?>" class="btn ccm-button-v2 primary" />
                    <?php      else : ?>
                        <strong><?php      echo t("Choosed as default"); ?></strong>
                    <?php      endif ?>
                </td>
                <td align='center'>
                    <?php      if ($k != 0):?>
                        <input type="submit" name="preset_to_delete_<?php      echo $p['pID']?>" value="<?php      echo t('Delete'); ?>" class="btn ccm-button-v2 error" />
                    <?php      else : ?>
                        <input type="submit" name="preset_to_reset_<?php      echo $p['pID']?>" value="<?php      echo t('Reset Values'); ?>" class="btn ccm-button-v2 error" />
                    <?php      endif ?>
                </td>
            </tr>
        <?php      endforeach ?>
        </table>
    </div>
<!--
<div class="ccm-pane-footer">
<?php      //echo $ih->submit($item['name'],$item['id'], 'right', 'primary') ?>
</div>
-->
<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false) ?>
<div class="clear" style="height:24px">&nbsp;	</div>

</form>
<form action="<?php      echo $this->action('save_preset')?>" method='post'>
    <?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add a new Options presets'), false, 'span14', false) ?>
    <div class="ccm-pane-body">
        <table cellpadding="20" cellspacing="1" class="entry-form">
            <tr>
                <td class="subheader" style="width:33%"><strong><?php      echo t("Name"); ?></strong></td>
                <td class="subheader"><strong><?php      echo t("Based on"); ?></strong></td>
                <td class="subheader"><strong><?php      echo t("Add"); ?></strong></td>
            </tr>
            <tr>
                <td align='center'><input type="text" name="name" style="width:95%" /></td>
                <td align='center'><?php      $poh->output_presets_list(true, 1, 'preset_id', array('Blank'))?> <hr /><p><?php      echo t("If 'blank' is selected <strong>(only for experimented users)</strong> , all options will be taked from the preset selected as 'default' upon a page of options of this new preset will be saved. <br />If you select a 'based on' preset <strong>(recomended)</strong>, all options from these selected preset will be duplicated to the new preset")?> </p></td>
                <td align='center'><input type="submit" class="btn ccm-button-v2 primary" name="new" value="<?php      echo t('Add'); ?>" /></td>
            </tr>
        </table>
    </div>
<?php      echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false) ?>
</form>
