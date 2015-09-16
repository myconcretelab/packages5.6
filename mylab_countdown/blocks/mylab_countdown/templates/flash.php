<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));
$date = $controller->getTargetDate($theDate);
$targetDate = $date['targetDateDisplay'];
$now = $date['actualDateDisplay'];
?>

<div id="flashCountDown-<?=$bID?>" class="flashCountDown">
        Unable to load the flash content
</div>
<script type="text/javascript">
        var today = new Date(); var theDate = new Date(<?=$targetDate?>); var _month = theDate.getMonth() - 1; theDate.setMonth(_month);
	params = {'allowScriptAccess': "always",'wmode': "transparent"};	
        flashvars = {targetDate: <?=$date['targetDate']?>,now:<?=$date['actualDate']?>};
        swfobject.embedSWF( "<?php  echo $this->getBlockURL()?>/swf/Countdown.swf", "flashCountDown-<?=$bID?>", "100%", "120", "9", false, flashvars, params );
</script>