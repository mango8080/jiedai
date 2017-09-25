<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">问题受理</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 问题分类</td>
<td><?php echo $TYPE[$typeid]['typename'];?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 问题标题</td>
<td><?php echo $title;?></td>
</tr>
<?php if($qid) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 来源问题</td>
<td><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $qid;?>', '来源问题');" class="t">点击查看</a></td>
</tr>
<?php } ?>
<tr class="on">
<td class="tl"><span class="f_hid">*</span> 问题内容</td>
<td><?php echo $content;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 用户名</td>
<td><a href="javascript:_user('<?php echo $username;?>');"><?php echo $username;?></a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 提交时间</td>
<td><?php echo $addtime;?></td>
</tr>
<?php if($status < 2) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 问题回复</td>
<td><textarea name="reply" id="reply" class="dsn"><?php echo $reply;?></textarea><?php echo deditor($moduleid, 'reply', 'Destoon', '100%', 300);?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理状态</td>
<td>
<input type="radio" name="status" value="0" id="status_0" onclick="Dh('notice');"<?php echo $status == 0 ? ' checked' : '';?>/><label for="status_0"> 待受理</label>
<input type="radio" name="status" value="1" id="status_1" onclick="Dh('notice');"<?php echo $status == 1 ? ' checked' : '';?>/><label for="status_1"> 受理中</label>
<input type="radio" name="status" value="2" id="status_2" onclick="Ds('notice');"<?php echo $status == 2 ? ' checked' : '';?>/><label for="status_2"> 已解决</label>
<input type="radio" name="status" value="3" id="status_3" onclick="Ds('notice');"<?php echo $status == 3 ? ' checked' : '';?>/><label for="status_3"> 未解决</label>
</td>
</tr>
<tr style="display:none;" id="notice">
<td class="tl"><span class="f_hid">*</span> 通知用户</td>
<td>
<input type="checkbox" name="msg" id="msg" value="1" onclick="Dn();" checked/><label for="msg"> 站内通知</label>
<input type="checkbox" name="eml" id="eml" value="1" onclick="Dn();"/><label for="eml"> 邮件通知</label>
<input type="checkbox" name="sms" id="sms" value="1" onclick="Dn();"/><label for="sms"> 短信通知</label>
<input type="checkbox" name="wec" id="wec" value="1" onclick="Dn();"/><label for="wec"> 微信通知</label>
</td>
</tr>
<?php } else { ?><tr>
<td class="tl"><span class="f_hid">*</span> 问题回复</td>
<td><?php echo $reply;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理状态</td>
<td><?php echo $_status[$status];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理人</td>
<td><?php echo $editor;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 受理时间</td>
<td><?php echo $edittime;?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 用户评分</td>
<td><?php echo $stars[$star];?></td>
</tr>
</table>
<?php if($status < 2) { ?>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
<?php } ?>
</form>
<script type="text/javascript">Menuon(<?php echo $status;?>);</script>
<?php include tpl('footer');?>