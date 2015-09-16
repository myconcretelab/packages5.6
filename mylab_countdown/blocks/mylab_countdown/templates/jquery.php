<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));
$date = $controller->getTargetDate($theDate);
$targetDate = $date['targetDateDisplay'];
$now = $date['actualDateDisplay'];
?>

<div id="jsCountDown-<?=$bID?>" class="jsCountDown">
        Too late!
</div>

<script type="text/javascript">
        var today = new Date(); var theDate = new Date(<?=$targetDate?>); var _month = theDate.getMonth() - 1; theDate.setMonth(_month);
	<? if (!$date['isExpired']) :?>	
	$('#jsCountDown-<?=$bID?>').countdown({format: "<?=$elements?>", until: theDate, onExpiry:expiry});
	function expiry () {$('#jsCountDown').html('expiré!')};
	<?endif?>
</script>