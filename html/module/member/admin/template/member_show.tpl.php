<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!isset($dialog)) show_menu($menus);
?>
<div class="tt">用户资料</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td rowspan="9" align="center" width="160" class="f_gray">
<img src="<?php echo useravatar($username, 'large');?>" width="128" height="128"/>
<div style="padding:5px 0 0 0;">
<a href="?moduleid=<?php echo $moduleid;?>&action=login&userid=<?php echo $userid;?>" class="t" target="_blank" title="点击登入用户商务中心">用户前台</a> | 
<a href="?moduleid=<?php echo $moduleid;?>&action=edit&userid=<?php echo $userid;?>" class="t"<?php if(isset($dialog)) {?> target="_blank"<?php } ?>>修改资料</a>
</div>
<div style="padding:2px 0 2px 0;">
<a href="?moduleid=<?php echo $moduleid;?>&action=move&groupids=2&userid=<?php echo $userid;?>" class="t"<?php if(isset($dialog)) {?> target="_blank"<?php } ?> onclick="return confirm('确定要禁止此用户访问吗？');">禁止访问</a> | 
<a href="?moduleid=<?php echo $moduleid;?>&action=delete&userid=<?php echo $userid;?>&forward=<?php echo urlencode('?moduleid='.$moduleid);?>" class="t"<?php if(isset($dialog)) {?> target="_blank"<?php } ?> onclick="return confirm('确定要删除此用户吗？系统将删除选中用户所有信息，此操作将不可撤销');">删除用户</a><br/>
</div>

<?php if($DT['im_web']) { ?><?php echo im_web($username);?> <?php } ?>
<a href="javascript:Dwidget('?moduleid=2&file=sendmail&email=<?php echo $email;?>', '发送邮件');"><img width="16" height="16" src="<?php echo DT_SKIN;?>image/email.gif" title="发送邮件 <?php echo $email;?>" align="absmiddle"/></a> 
<?php if($mobile) { ?><a href="javascript:Dwidget('?moduleid=2&file=sendsms&mobile=<?php echo $mobile;?>', '发送短信');"><img src="<?php echo DT_SKIN;?>image/mobile.gif" title="发送短信" align="absmiddle"/></a> <?php } ?>
<a href="javascript:Dwidget('?moduleid=2&file=message&action=send&touser=<?php echo $username;?>', '发送消息');"><img width="16" height="16" src="<?php echo DT_SKIN;?>image/msg.gif" title="发送消息" align="absmiddle"/></a>
<?php echo im_qq($qq);?>
<?php echo im_ali($ali);?>
<?php echo im_msn($msn);?>
<?php echo im_skype($skype);?>
</td>
<td class="tl">用户名</td>
<td>&nbsp;<a href="<?php echo $linkurl;?>" target="_blank"><?php echo $username;?></a>
[<?php $ol = online($userid);if($ol == 1) { ?><span class="f_red">在线</span><?php } else if($ol == -1) { ?><span class="f_blue">隐身</span><?php } else { ?><span class="f_gray">离线</span><?php } ?>]
</td>
<td class="tl">用户ID</td>
<td>&nbsp;<?php echo $userid;?>&nbsp;&nbsp;

</tr>
<tr>
<td class="tl">昵称</td>
<td>&nbsp;<?php echo $passport;?></td>
<td class="tl">用户组</td>
<td class="f_red">&nbsp;<?php echo $GROUP[$groupid]['groupname'];?></td>
</tr>

<tr>
<td class="tl">姓 名</td>
<td>&nbsp;<?php echo $truename;?></td>
<td class="tl">性 别</td>
<td>&nbsp;<?php echo $gender == 1 ? '先生' : '女士';?></td>
</tr>
<tr>
<td class="tl"><?php echo VIP;?>指数</td>
<td>&nbsp;<img src="<?php echo DT_SKIN;?>image/vip_<?php echo $vip;?>.gif"/></td>
<td class="tl">登录次数</td>
<td>&nbsp;<?php echo $logintimes;?></td>
</tr>
<?php if($totime) { ?>
<tr>
<td class="tl">服务开始日期</td>
<td>&nbsp;<?php echo timetodate($fromtime, 3);?></td>
<td class="tl">服务结束日期</td>
<td>&nbsp;<?php echo timetodate($totime, 3);?><?php echo $totime < $DT_TIME ? ' <span class="f_red">[已过期]</span>' : '';?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">上次登录</td>
<td>&nbsp;<?php echo timetodate($logintime, 6);?></td>
<td class="tl">登录IP</td>
<td>&nbsp;<?php echo $loginip;?> - <?php echo ip2area($loginip);?></td>
</tr>
<tr>
<td class="tl">注册时间</td>
<td>&nbsp;<?php echo timetodate($regtime, 6);?></td>
<td class="tl">注册IP</td>
<td>&nbsp;<?php echo $regip;?> - <?php echo ip2area($regip);?></td>
</tr>
<tr>
<td class="tl"><?php echo $DT['money_name'];?>余额</td>
<td>&nbsp;<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=record&username=<?php echo $username;?>', '<?php echo $DT['money_name'];?>流水');"><strong class="f_red"><?php echo $money;?></strong></a> <?php echo $DT['money_unit'];?></td>
<td class="tl">保证金</td>
<td>&nbsp;<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=deposit&username=<?php echo $username;?>', '保证金流水');"><strong class="f_blue"><?php echo $deposit;?></strong></a> <?php echo $DT['money_unit'];?></td>
</tr>
<tr>
<td class="tl">短信余额</td>
<td>&nbsp;<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=sms&action=record&username=<?php echo $username;?>', '短信记录');"><strong class="f_red"><?php echo $sms;?></strong></a> 条</td>
<td class="tl">用户<?php echo $DT['credit_name'];?></td>
<td>&nbsp;<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=credit&username=<?php echo $username;?>', '<?php echo $DT['credit_name'];?>流水');"><strong class="f_blue"><?php echo $credit;?></strong></a> <?php echo $DT['credit_unit'];?></td>
</tr>
</table>
<div class="tt">备注信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php
	if($note) {
		echo '<tr><th>时间</th><th>内容</th><th width="150">管理员</th></tr>';
		$N = explode('--------------------', $note);
		foreach($N as $n) {
			if(strpos($n, '|') === false) continue;
			list($_time, $_name, $_note) = explode('|', $n);
			if(strlen(trim($_time)) == 16 && check_name($_name) && $_note) echo '<tr><td align="center">'.trim($_time).'</td><td style="padding:6px 10px;line-height:24px;">'.nl2br(trim($_note)).'</td><td align="center"><a href="javascript:_user(\''.$_name.'\')">'.$_name.'</a></td></tr>';
		}
	}
?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="note_add"/>
<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
<tr>
<td class="tl">追加备注</td>
<td align="center">
<textarea name="note" style="width:99%;height:20px;overflow:visible;padding:0;"></textarea></td>
<td align="center" width="130"><input type="submit" name="submit" value="追加" class="btn"/><?php if($_admin == 1) {?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:$('#edit_note').toggle();" class="t">修改</a><?php } ?></td>
</tr>
</form>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="note_edit"/>
<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
<tr id="edit_note" style="display:none;">
<td class="tl">修改备注</td>
<td align="center" class="f_gray">
<textarea name="note" style="width:99%;height:100px;overflow:visible;padding:0;"><?php echo $note;?></textarea><br/>请只修改备注文字，不要改动 | 和 - 符号以及时间和管理员</td>
<td align="center"><input type="submit" name="submit" value="修改" class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?moduleid=<?php echo $moduleid;?>&action=note_edit&userid=<?php echo $userid;?>&note=" class="t" onclick="return confirm('确定要清空此用户的备注信息吗？此操作将不可撤销');">清空</a></td>
</tr>
</form>
</table>
<?php if ($regid==6): ?>

<div class="tt">公司资料</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl">公司名</td>
<td>&nbsp;<?php echo $company;?></td>
<td class="tl">公司类型</td>
<td>&nbsp;<?php echo $type;?></td>
</tr>

<tr>
<td class="tl">注册资本</td>
<td>&nbsp;<?php echo $capital;?>万<?php echo $regunit;?></td>
<td class="tl">公司规模</td>
<td>&nbsp;<?php echo $size;?></td>
</tr>
<tr>
<td class="tl">成立年份</td>
<td>&nbsp;<?php echo $regyear;?></td>
<td class="tl">公司所在地</td>
<td>&nbsp;<?php echo area_pos($areaid, '/');?></td>
</tr>

</table>
<?php endif ?>
<?php if ($regid==5): ?>

<div class="tt">个人资料</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl">身份证</td>
<td>&nbsp;<?php echo $cardcode;?></td>
<td class="tl">警号</td>
<td>&nbsp;<?php echo $jinghao;?></td>
</tr>

<tr>
<td class="tl">警种</td>
<td>&nbsp;<?php echo $jingzhong;?></td>
<td class="tl">工作单位</td>
<td>&nbsp;<?php echo $danwei;?></td>
</tr>

</table>
<?php endif ?>
<div class="tt">联系方式</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">姓 名</td>
<td>&nbsp;<?php echo $truename;?></td>
<td class="tl">手 机</td>
<td>&nbsp;<?php if($mobile) { ?><a href="javascript:Dwidget('?moduleid=2&file=sendsms&mobile=<?php echo $mobile;?>', '发送短信');"><img src="<?php echo DT_SKIN;?>image/mobile.gif" title="发送短信" align="absmiddle"/></a> <?php } ?><a href="javascript:_mobile('<?php echo $mobile;?>');" title="归属地查询"><?php echo $mobile;?></a></td>
</tr>
<?php if ($regid==6): ?>
<tr>
<td class="tl">部 门</td>
<td>&nbsp;<?php echo $department;?></td>
<td class="tl">职 位</td>
<td>&nbsp;<?php echo $career;?></td>
</tr>
<tr>
<td class="tl">电 话</td>
<td>&nbsp;<?php echo $telephone;?></td>
<td class="tl">传 真</td>
<td>&nbsp;<?php echo $fax;?></td>
</tr>
<?php endif ?>

<tr>
<td class="tl">Email (不公开)</td>
<td>&nbsp;<a href="javascript:Dwidget('?moduleid=2&file=sendmail&email=<?php echo $email;?>', '发送邮件');"><img width="16" height="16" src="<?php echo DT_SKIN;?>image/email.gif" title="发送Email <?php echo $email;?>" alt="" align="absmiddle"/></a> <?php echo $email;?></td>
<td class="tl">Email (公开)</td>
<td>&nbsp;<?php if($mail) { ?><a href="javascript:Dwidget('?moduleid=2&file=sendmail&email=<?php echo $mail;?>', '发送邮件');"><img width="16" height="16" src="<?php echo DT_SKIN;?>image/email.gif" title="发送Email <?php echo $mail;?>" alt="" align="absmiddle"/></a> <?php } ?><?php echo $mail;?></td>
</tr>

</table>
<?php if ($regid): ?>
	

<div class="tt">财务信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">开户银行</td>
<td>&nbsp;<?php echo $bank;?></td>
</tr>
<tr>
<td class="tl">开户网点</td>
<td>&nbsp;<?php echo $branch;?></td>
</tr>
<tr>
<td class="tl">账户性质</td>
<td>&nbsp;<?php echo $banktype ? '对公' : '对私';?></td>
</tr>
<tr>
<td class="tl">收款户名</td>
<td>&nbsp;<?php echo $banktype ? $company : $truename;?></td>
</tr>
<tr>
<td class="tl">收款帐号</td>
<td>&nbsp;<?php echo $account;?></td>
</tr>
<tr>
<td class="tl"><?php echo $DT['trade_nm'];?></td>
<td>&nbsp;<?php echo $trade;?></td>
</tr>
</table>
<?php endif ?>
<?php if ($regid==6): ?>
<div class="tt">资质认证</div>
<table class="tb" cellspacing="1" cellpadding="2">
<form action="?" method="post">

	<tr>
<th>认证名称</th>
<th>营业执照</th>
<th>消防许可证</th>
<th>卫生许可证</th>
<th>特种行业许可证</th>
<th width="130">提交时间</th>
<th>状态</th>
</tr>
<?php if ($renzheng): ?>
	

<tr>
<input name="itemid[]" value="<?php echo $renzheng['itemid'] ?>" type="hidden">
	<td><?php echo $renzheng['title'] ?></td>
	<td><?php if($renzheng['thumb']) {?> <a href="javascript:_preview('<?php echo $renzheng['thumb'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
<td><?php if($renzheng['thumb1']) {?> <a href="javascript:_preview('<?php echo $renzheng['thumb1'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
<td><?php if($renzheng['thumb2']) {?> <a href="javascript:_preview('<?php echo $renzheng['thumb2'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
<td><?php if($renzheng['thumb3']) {?> <a href="javascript:_preview('<?php echo $renzheng['thumb3'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>

	<td><?php echo timetodate($renzheng['addtime'],6); ?></td>
	<td><?php echo $renzheng['status'] == 3 ? '<span class="f_green">已认证</span>' : '<span class="f_red">未认证</span>';?></td>
</tr>
<?php endif ?>
<tr>
	<td colspan="7">
		<div class="btns">
		<input name="msg" id="msg" value="1" type="hidden">
<input value=" 通过认证 " class="btn" onclick="if(1){this.form.action='?moduleid=2&amp;file=validate&amp;action=check';}else{return false;}" type="submit">&nbsp;
<input value=" 拒绝认证 " class="btn" onclick="if(1){this.form.action='?moduleid=2&amp;file=validate&amp;action=reject';}else{return false;}" type="submit">&nbsp;
<input value=" 取消认证 " class="btn" onclick="if(1){this.form.action='?moduleid=2&amp;file=validate&amp;action=cancel';}else{return false;}" type="submit">
</div>
	</td>
</tr>
</form>
</table>
<?php endif ?>

<br/>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>