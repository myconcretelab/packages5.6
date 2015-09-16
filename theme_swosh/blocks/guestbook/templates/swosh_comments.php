<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php  $c = Page::getCurrentPage(); ?>

<?php  if($invalidIP) { ?>
<div class="ccm-error"><p><?php echo $invalidIP?></p></div>
<?php  } ?>
<?php 
$u = new User();
if (!$dateFormat) {
	$dateFormat = t('M jS, Y');
}
$posts = $controller->getEntries();
$bp = $controller->getPermissionObject()?>

    <section class="comments">
      <div class="blankSeparator"></div>
      <div class="sepContainer2"></div>
      <h2><?php echo $controller->title?></h2>
      <div class="sepContainer2"></div>
      <div class="blankSeparator"></div>
      <div class="boxtwos ep"></div>
      <div id="comments">
        <ul id="articleCommentList">
        	
<?php foreach($posts as $p) {?>




	<?php  if($p['approved'] || $bp->canWrite()) { ?>        	
          <li>
            <div class="commentMeta">
              <?php 
                $username = $c->getVersionObject()->getVersionAuthorUserName();
               $ui = UserInfo::getByID($p['uID']);
                if ($ui && $ui->hasAvatar()) {
                  echo '<img class="user" src="'.BASE_URL.DIR_REL.'/files/avatars/'.$ui->getUserID().'.jpg'.'" alt="avatar" />';
                } else {
                  echo '<img class="user" src="' . BASE_URL . DIR_REL . '/' . DIRNAME_PACKAGES . '/theme_swosh/' . DIRNAME_THEMES .  '/swosh/images/default_avatar.png" alt="Default user icon" />';
                }
               ?>
              
               </div>
            <!-- end commentMeta -->
            <div class="commentBody">
            	<h3>
				<?php  if($bp->canWrite()) { ?> 
							<small>
                       <small><?php echo date($dateFormat,strtotime($p['entryDate']));?></small>
       
			                	<a href="<?php echo $this->action('loadEntry')."&entryID=".$p['entryID'];?>#guestBookForm"><?php echo t('Edit')?></a> | 
								<a href="<?php echo $this->action('removeEntry')."&entryID=".$p['entryID'];?>" onclick="return confirm('<?php echo t("Are you sure you would like to remove this comment?")?>');"><?php echo t('Remove')?></a> |
			                	<?php  if($p['approved']) { ?>
			 	                   	<a href="<?php echo $this->action('unApproveEntry')."&entryID=".$p['entryID'];?>"><?php echo t('Un-Approve')?></a>
			                    <?php  } else { ?>
				                    <a href="<?php echo $this->action('approveEntry')."&entryID=".$p['entryID'];?>"><?php echo t('Approve')?></a>
								<?php  } ?>
								
			                </small>
						<?php  } ?>            	
            	
            	
            	
              <?php if( intval($p['uID']) ){ $ui = UserInfo::getByID(intval($p['uID'])); if (is_object($ui)) { echo $ui->getUserName(); }} else echo $p['user_name'];?></h3>
              <p><?php echo nl2br($p['commentText'])?></p>
            </div>
            <!-- end commentBody --> 
          </li>


	<?php  } ?>
<?php  } ?>


        </ul>
      </div>
      <!-- end Comments --> 
    </section>
<?php if (isset($response)) { ?>
	<?php echo $response?>
<?php  } ?>
<?php  if($controller->displayGuestBookForm) { ?>
	<?php 	
	if( $controller->authenticationRequired && !$u->isLoggedIn() ){ ?>
		<div><?php echo t('You must be logged in to leave a reply.')?> <a href="<?php echo View::url("/login","forward",$c->getCollectionID())?>"><?php echo t('Login')?> &raquo;</a></div>
	<?php  }else{ ?>	

    <div id="contactForm">
      <h2><?php  echo t('Leave a Reply')?></h2>
      <form method="post" action="<?php echo $this->action('form_save_entry', '#guestBookForm-'.$controller->bID)?>" id="contact_form">
		<?php  if(isset($Entry->entryID)) { ?>
			<input type="hidden" name="entryID" value="<?php echo $Entry->entryID?>" />
		<?php  } ?> 
		<a name="guestBookForm-<?php echo $controller->bID?>"></a> 
			<?php  if(!$controller->authenticationRequired) : ?>    	
        <div class="name">
          <label for="name"><?php echo t('Name')?></label>
          <p> <?php echo t('Please enter your full name')?></p>
          <input type="text" name="name" value="<?php echo $Entry->user_name ?>" placeholder="<?php echo t('e.g. Mr. John Smith')?>" />
        </div>
        <div class="email">
          <label for="email">Your Email:</label>
          <p><?php echo t('Your email will not be publicly displayed.')?></p>
          	<input type="email" name="email" id="email" value="<?php echo $Entry->user_email ?>" placeholder="<?php echo t('example@domain.com')?>" />
        </div>
        <?php endif ?>
        
        <div class="message">
          <label for="message">Your Message:</label>
          <p> Please enter your question</p>
		<?php echo (isset($errors['commentText'])?"<br /><span class=\"error\">".$errors['commentText']."</span>":"")?>
		<textarea name="commentText"><?php echo $Entry->commentText ?></textarea><br />
        </div>
			<?php 
			if($controller->displayCaptcha) {
						   
				
				$captcha = Loader::helper('validation/captcha');				
   				$captcha->label();
   				$captcha->showInput();
				$captcha->display();

				echo isset($errors['captcha'])?'<span class="error">' . $errors['captcha'] . '</span>':'';
				
			}
			?>        
        <div id="loader">
          <input type="submit" name="Post Comment" value="<?php echo t('Post Comment')?>" class="button"/>
        </div>
      </form>
    </div>
	<?php  } ?>
<?php  } ?>    
