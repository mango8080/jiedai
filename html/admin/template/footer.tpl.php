<?php
defined('DT_ADMIN') or exit('Access Denied');
if(DT_DEBUG) {
	echo '<br/><center class="f_gray px11">';
	debug();
	echo '</center><br/>';
}
?>
<div class="back2top"><a href="javascript:void(0);" title="返回顶部">&nbsp;</a></div>
<script type="text/javascript">
<?php if($_message) { ?>
Dnotification('new_message', '<?php echo $MODULE[2]['linkurl'];?>message.php', '<?php echo useravatar($_username, 'large');?>', '站内信(<?php echo $_message;?>)', '收到新的站内信件，点击查看');
<?php } ?>
<?php if($_chat) { ?>
Dnotification('new_chat', '<?php echo $MODULE[2]['linkurl'];?>chat.php', '<?php echo useravatar($_username, 'large');?>', '新对话(<?php echo $_chat;?>)', '收到新的对话请求，点击交谈');
<?php } ?>

var url='<?php echo $MODULE[2]['linkurl'];?>newregist.php';
function showalert(){
	$.getJSON(url,function(result){
			if(result.stat != 0){
				alert('系统有'+result.stat+'个待审核的新用户，请及时处理！');
			}
	});
}
window.setInterval(showalert, 60000);
</script>
</body>
</html>