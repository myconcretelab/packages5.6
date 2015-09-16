<?php  defined('C5_EXECUTE') or die("Access Denied.");

class SeparatorsBlockController extends BlockController {
	
	protected $btName = 'Separators';
	protected $btDescription = '';
	protected $btTable = 'btDCSeparators';
	
	protected $btInterfaceWidth = "200";
	protected $btInterfaceHeight = "200";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;


}
