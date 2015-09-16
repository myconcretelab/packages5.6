<?php   defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::packageElement('mp3_player','cover_navigator',array('object'=>$_POST['object']
                                                                     ));
exit;
