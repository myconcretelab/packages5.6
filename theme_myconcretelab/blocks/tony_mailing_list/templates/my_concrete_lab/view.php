<?php  
defined('C5_EXECUTE') or die(_("Access Denied.")); 

$c = Page::GetCurrentPage();

$titleWeight = $controller->titleWeight;
if(strtolower($titleWeight)=='bold') $titleWeight='strong';
elseif(!$titleWeight) $titleWeight='div'; 
$signupTitle = '<'.$titleWeight.' class="mailing-list-signup-title">'.$controller->signupTitle.'</'.$titleWeight.'>';

$u = new User();

$dirtyAttrIds = explode(',',$controller->userAttrs);
$userAttrIds=array();
foreach($dirtyAttrIds as $attrID) 
	if(intval($attrID)) $userAttrIds[]=intval($attrID);
?> 
 
<a name="subscribe-to-mailing-list"></a>     
<div id="MailingListSubscribe<?php echo intval($bID)?>" class="MailingListSubscribe">   
	
	<?php echo  (strlen($controller->signupTitle)) ? $signupTitle : '' ?>
	
	<?php  if(strlen($controller->signupText)){ ?>
	<div class="mailing-list-signup-text">
		<?php echo  $controller->signupText ?>
	</div>
	<?php  } ?>
	
	<?php  if($subscribed){ ?>
	
		<div class="mailing-list-msg">
			<?php echo  $controller->subscribedMsg ?>
			
			<?php  if($nonUserUnsubscribing){ ?> 
				<div style="margin-top:8px;">
					<?php echo  t('To unsubscribe from the mailing lists you left unchecked, please check your email inbox.') ?> 
				</div>
			<?php  } ?>
			
			<?php  if($nonUserSubscribing){ ?> 
				<div style="margin-top:8px;">
					<?php echo  t('To confirm your email address, please check your email inbox, and click the link you have been sent') ?> 
				</div>
			<?php  } ?>			
		</div>
	
	<?php  }else{ ?>  
	
		<?php  if( !$u->uID && !$controller->allowUnregistered){ ?> 
			
			<div class="mailing-list-msg"><?php echo  t('Please <a href="%s">login</a> first to subscribe' , View::url('/login?rcID='.$c->cID) ) ?></div> 
	
		<?php  }else{ ?> 
		
		<?php  if(strlen($errorMsg)){ ?> 
		
			<div class="mailing-list-msg"><?php echo  $errorMsg ?></div>
			
		<?php  } ?> 	
	
		<form action="<?php echo  View::url( $c->getCollectionPath() ) ?>#subscribe-to-mailing-list" method="post"> 
			<input name="mailing_list_subscribe" type="hidden" value="<?php echo intval($bID) ?>" /> 
			<?php 
			$token = Loader::helper('validation/token'); 
			echo $token->output('mailing_list_subscribe'); ?>
			
			<?php  
			if( $u->uID )  
				$ui = UserInfo::getById($u->uID);
			
			if( !$u->uID || (defined('MAILING_LIST_ALWAYS_SHOW_EMAIL_FIELD') && MAILING_LIST_ALWAYS_SHOW_EMAIL) ){ 
				if(strlen($_REQUEST['email'])){ 
					$defaultEmailTxt = $_REQUEST['email'] ; 
				}else if( is_object($ui) && !defined('MAILING_LIST_SHOW_EMPTY_EMAIL_FIELD') ){ 
					$defaultEmailTxt = $ui->getUserEmail();;
				}else{
					$defaultEmailTxt = '';
				}
				?> 
				<div class="mailing-list-email-wrap">
					<?php echo t('Email:') ?> <?php  if($controller->attrsRequired || count($userAttrIds)){ ?><span class="required"><?php echo t('*')?></span><?php  } ?>
					<input name="email" type="text" value="<?php echo  htmlentities( $defaultEmailTxt, ENT_QUOTES, 'UTF-8') ?>" />
				</div>
			<?php  } ?>	
			
			<div class="mailing-list-checkboxes" style="display:<?php echo  ($controller->showCheckboxes) ? 'block' : 'none' ?>">
				<?php   
				$lockDownGIDs = explode(',',Config::get('TONY_MAILING_LIST_CAN_SUBSCRIBE_GIDS'));
				
				$checkedGIDs = explode(',',$controller->gIDs); 
				$subscribeGIDs=$_REQUEST['subscribeGIDs'];
				if(!is_array($subscribeGIDs)) $subscribeGIDs=array(intval($subscribeGIDs));
				foreach($checkedGIDs as $gID){ 
				
					//options set on the mailing list settings page
					if( !in_array($gID,$lockDownGIDs) ) continue; 
				
					$group = Group::getById($gID); 
					if( !is_object($group) ) continue; 
					if( $group->getGroupName()==t('Administrators') || strtolower($group->getGroupName())=='administrators' ) continue;
					?>
					<div class="mailing-list-group"> 
						<input id="mailingListGroup_<?php echo intval($bID) ?>_<?php echo intval($gID) ?>" name="subscribeGIDs[]" type="checkbox" value="<?php echo intval($gID) ?>" <?php echo  (!$_REQUEST['mailing_list_subscribe'] || in_array( intval($gID), $subscribeGIDs)) ? 'checked="checked"' : '' ?> />	 
						<label for="mailingListGroup_<?php echo intval($bID) ?>_<?php echo intval($gID) ?>"><?php echo  $group->getGroupName() ?></label>
					</div> 
				<?php  } ?> 
			</div>	
			
			<?php  if(count($userAttrIds)){ ?>
			<div class="mailing-list-user-attrs">
			<?php   foreach($userAttrIds as $userAttrId){ 
				$userAttr = UserAttributeKey::getByID(intval($userAttrId));  
				if(!is_object($userAttr)) continue;
				if(is_object($ui)) $vo=$ui->getAttributeValueObject($userAttr);
				else $vo=false;
				$hasAttrs=1;
				?>
				<div class="mailing-list-user-attr">
					<label><?php echo $userAttr->getAttributeKeyName() ?>
					<?php echo  ($controller->attrsRequired) ? '<span class="required">'.t('*').'</span>' : '' ?>
					</label> 
					
					<?php 
					//$vo = $uo->getAttributeValueObject($userAttr);  
					echo $userAttr->render('form', $vo, true);
					?>
				</div>
			<?php  } ?>
			</div>
			<?php  } ?>						
			<div class="divider-normal"></div>
			<input name="Submit" class="button button-flat-primary" type="submit" value="<?php echo t('Sign-up') ?>" />
			
			<?php  if( $controller->attrsRequired || (!$controller->attrsRequired && count($userAttrIds) && !$u->uID)){ ?>
			<div class="mailing-list-required-note">
				<span class="required"><?php echo t('*') ?></span> <?php echo t('Required Fields')?>
			</div>
			<?php  } ?>
		</form>
		
		<?php  } ?> 
	
	<?php  } ?>
	
</div>