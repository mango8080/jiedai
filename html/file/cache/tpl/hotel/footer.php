<?php defined('IN_DESTOON') or exit('Access Denied');?><div class="w1200" >
        <div class="clear_float"></div>
        <div class="clear_float clearfix"></div>
        <div class="footLink"></div>
        <div class="copyRight">备案号：&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn/">苏ICP备16064744</a><br /><br />版权所有:&nbsp;&nbsp;全国民警出差网&nbsp;&nbsp;</div></div>
<div class="back2top"><a href="javascript:void(0);" title="返回顶部">&nbsp;</a></div>
<script type="text/javascript">
<?php if($destoon_task) { ?>
show_task('<?php echo $destoon_task;?>');
<?php } else { ?>
<?php include DT_ROOT.'/api/task.inc.php';?>
<?php } ?>
<?php if($lazy) { ?>$(function(){$("img").lazyload();});<?php } ?>
</script>
</body>
</html>