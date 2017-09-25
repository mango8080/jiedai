<?php defined('IN_DESTOON') or exit('Access Denied');?></td>
</tr>
</table>
</div>
<?php if($DT_TOUCH) { ?>
<?php } else { ?>
<div class="back2top"><a href="javascript:void(0);" title="返回顶部">&nbsp;</a></div>
<script type="text/javascript">
if(document.body.clientHeight > Dd('main').scrollHeight) Dd('main').style.height=document.body.clientHeight+'px';
if(get_local('m_side') == 'Y' && Dd('side_oh').className == 'side_h') {Dh('side');Dd('side_oh').className = 'side_s';}
var destoon_message = <?php echo $_message;?>;
var destoon_chat = <?php echo $_chat;?>;
<?php if($_message && $_sound) { ?>
if(window.location.href.indexOf('message.php') == -1) $('#destoon_space').html(sound('message_<?php echo $_sound;?>'));
<?php } ?>
<?php if($_chat) { ?>
if(window.location.href.indexOf('chat.php') == -1) $('#destoon_space').html(sound('chat_new'));
<?php } ?>
<?php if($_message) { ?>
Dnotification('new_message', '<?php echo $MODULE['2']['linkurl'];?>message.php', '<?php echo useravatar($_username, 'large');?>', '站内信 (<?php echo $_message;?>)', '收到新的站内信件，点击查看');
<?php } ?>
<?php if($_chat) { ?>
Dnotification('new_chat', '<?php echo $MODULE['2']['linkurl'];?>chat.php', '<?php echo useravatar($_username, 'large');?>', '新对话 (<?php echo $_chat;?>)', '收到新的对话请求，点击交谈');
<?php } ?>
<?php if($_userid && $DT['pushtime']) { ?>
window.setInterval('PushNew()',<?php echo $DT['pushtime'];?>*1000);
<?php } ?>
if($('#mini_profile').length > 0) {
$('#my_profile').mouseover(function(){
$('#mini_profile').show('fast');
$('#my_profile').bind('mouseleave',function(){ 
$('#mini_profile').hide(); 
});
}); 
}
</script>
<?php } ?>
</body>
</html>