<?php defined('C5_EXECUTE') or die(_("Access Denied.")) ?>
<div class="chart chart_<?php echo $bID?>" id="chart_<?php echo $bID?>" data-percent="0" data-updateto="<?php echo $value ?>" style="width:<?php echo $size ?>px; height:<?php echo $size ?>px"><?php echo $content ?></div>
<script type="text/javascript">
$(document).ready(function() {
    if (!chart_<?php echo $bID?>) {
        var chart_<?php echo $bID?> = true;
            $('.chart_<?php echo $bID?>').easyPieChart({
                barColor : '<?php echo $barColor ?>',
                trackColor : <?php echo $track ? '"' . $trackColor . '"' : 'false' ?>,
                scaleColor : <?php echo $scale ? '"' . $scaleColor . '"' : 'false' ?>,
                lineCap : '<?php echo $lineCap ?>',
                lineWidth : <?php echo $lineWidth ?>,
                size : <?php echo $size ?>,
                rotate : <?php echo $rotate ?>,
                <?php echo $animate ? 'animate:' . $animate : '' ?> 
            });
        
            $('.chart_<?php echo $bID?>').bind('enterviewport', updateChart).bind('leaveviewport', resetchart).bullseye();
    }   
});
    // Si la function n'existe pas on la crée
    if (typeof(updateChart) == 'undefined') {
        var updateChart = function  (e) {
            var t = $(this);
            t.data('easyPieChart').update(t.data('updateto'));
        }
        var resetchart = function  (e) {
            var t = $(this);
            t.data('easyPieChart').update(0);
        }
    }
</script>
<style>
    #chart_<?php echo $bID?> {
        font-size: <?php echo $fontSize ?>px;
        <?php echo $textColor ? 'color:' . $textColor . ';' : '' ?>
        width: <?php echo $size ?>px;
        margin:0 auto;
    }
</style>