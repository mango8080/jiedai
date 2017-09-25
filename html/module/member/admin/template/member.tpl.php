<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">用户搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $group_select;?>&nbsp;
<?php echo $gender_select;?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
<?php echo $order_select;?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>&nbsp;
<select name="timetype">
<option value="regtime" <?php if($timetype == 'regtime') echo 'selected';?>>注册时间</option>
<option value="logintime" <?php if($timetype == 'logintime') echo 'selected';?>>登录时间</option>
</select>&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
<?php echo $DT['money_name'];?>：<input type="text" size="2" name="minmoney" value="<?php echo $minmoney;?>"/>~<input type="text" size="2" name="maxmoney" value="<?php echo $maxmoney;?>"/>&nbsp;
<?php echo $DT['credit_name'];?>：<input type="text" size="2" name="mincredit" value="<?php echo $mincredit;?>"/>~<input type="text" size="2" name="maxcredit" value="<?php echo $maxcredit;?>"/>&nbsp;
短信：<input type="text" size="2" name="minsms" value="<?php echo $minsms;?>"/>~<input type="text" size="2" name="maxsms" value="<?php echo $maxsms;?>"/>&nbsp;
保证金：<input type="text" size="2" name="mindeposit" value="<?php echo $mindeposit;?>"/>~<input type="text" size="2" name="maxdeposit" value="<?php echo $maxdeposit;?>"/>&nbsp;
</td>
</tr>
<tr>
<td>&nbsp;
<?php echo $vprofile_select;?> 
<?php echo $vemail_select;?> 
<?php echo $vmobile_select;?> 
<?php echo $vtruename_select;?> 
<?php echo $vbank_select;?> 
<?php echo $vcompany_select;?> 
<?php echo $vtrade_select;?> 
<?php echo $avatar_select;?> 
警号：<input type="text" name="username" value="<?php echo $username;?>" size="6"/>&nbsp;
昵称：<input type="text" name="passport" value="<?php echo $passport;?>" size="6"/>&nbsp;
用户ID：<input type="text" name="uid" value="<?php echo $uid;?>" size="4"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt">用户管理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>用户ID</th>
<th>用户名称</th>
<th>推荐人</th>
<th><?php echo $DT['money_name'];?></th>
<th><?php echo $DT['credit_name'];?></th>
<th>短信</th>
<th>性别</th>
<th>用户组</th>
<th>注册时间</th>
<th>最后登录</th>
<th>登录次数</th>
<th width="100">操作</th>
</tr>
<?php foreach($members as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="userid[]" value="<?php echo $v['userid'];?>"/></td>
<td class="px11"><?php echo $v['userid'];?></td>
<td align="left">&nbsp;<a href="javascript:_user('<?php echo $v['username'];?>');" title="<?php echo $v['truename'];?>"><?php echo $v['username'];?></a></td>
<td align="left">&nbsp;<?php echo $v['shangxian'];?></td>
<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=record&username=<?php echo $v['username'];?>', '[<?php echo $v['username'];?>] <?php echo $DT['money_name'];?>记录');"><?php echo $v['money'];?></a></td>
<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=credit&username=<?php echo $v['username'];?>', '[<?php echo $v['username'];?>] <?php echo $DT['credit_name'];?>记录');"><?php echo $v['credit'];?></a></td>
<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=sms&username=<?php echo $v['username'];?>&action=record', '[<?php echo $v['username'];?>] 短信记录');"><?php echo $v['sms'];?></a></td>
<td><?php echo gender($v['gender']);?></td>
<td><a href="?moduleid=<?php echo $moduleid;?>&groupid=<?php echo $v['groupid'];?>"><?php echo $GROUP[$v['groupid']]['groupname'];?></a></td>
<td class="px11" title="修改时间:<?php echo $v['edittime'] ? timetodate($v['edittime']) : '无';?>"><?php echo $v['regdate'];?></td>
<td class="px11"><?php echo $v['logindate'];?></td>
<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=loginlog&username=<?php echo $v['username'];?>&action=record', '[<?php echo $v['username'];?>] 登录记录');"><?php echo $v['logintimes'];?></a></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&action=edit&userid=<?php echo $v['userid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=2&action=show&userid=<?php echo $v['userid'];?>"><img src="admin/image/view.png" width="16" height="16" title="用户[<?php echo $v['username'];?>]详细资料" alt=""/></a>&nbsp;
&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&userid=<?php echo $v['userid'];?>" onclick="if(!confirm('确定危险！！要删除此用户吗？系统将删除选中用户所有信息，此操作将不可撤销')) return false;"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删除用户 " class="btn" onclick="if(confirm('确定要删除选中用户吗？系统将删除选中用户所有信息，此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 禁止访问 " class="btn" onclick="if(confirm('确定要禁止选中用户访问吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&action=move&groupids=2'}else{return false;}"/>&nbsp;
<input type="submit" value=" 设置<?php echo VIP;?> " class="btn" onclick="this.form.action='?moduleid=4&file=vip&action=add';"/>&nbsp;
<input type="submit" value=" <?php echo $DT['money_name'];?>增减 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=record&action=add';"/>&nbsp;
<input type="submit" value=" <?php echo $DT['credit_name'];?>奖惩 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=credit&action=add';"/>&nbsp;
<input type="submit" value=" 短信增减 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=sms&action=add';"/>&nbsp;
<input type="submit" value=" 发送短信 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=sendsms';"/>&nbsp;
<input type="submit" value=" 发送邮件 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=sendmail';"/>&nbsp;
<input type="submit" value=" 发送消息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=message&action=send';"/>&nbsp;
<input type="submit" value=" 贸易提醒 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=alert&action=add';"/>&nbsp;
<input type="submit" value=" 移动至 " class="btn" onclick="if(Dd('mgroupid').value==0){alert('请选择用户组');Dd('mgroupid').focus();return false;}this.form.action='?moduleid=<?php echo $moduleid;?>&action=move';"/> <?php echo group_select('groupid', '用户组', 0, 'id="mgroupid"');?> 
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<div class="tt">修改用户名</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="rename"/>
<a name="#editusername"></a>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;当前户名： <input type="text" name="cusername" size="20" value="<?php echo $username;?>"/> &nbsp; 新户名： <input type="text" name="nusername" size="20"<?php if($catid==1) echo ' style="color:#FF6600;" value="请输入新用户名" onclick="if(this.value==\'请输入新用户名\')this.value=\'\';"';?>/>  &nbsp; <input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;<span class="f_gray">如无特殊情况，建议不要频繁修改用户名</span>
</td>
</tr>
</table>
</form>	<div class="tt">修改用户昵称</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="passport"/>
<a name="#editpassport"></a>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;当前昵称： <input type="text" name="cpassport" size="20" value="<?php echo $passport;?>"/> &nbsp; 新昵称： <input type="text" name="npassport" size="20"<?php if($catid==2) echo ' style="color:#FF6600;" value="请输入新昵称" onclick="if(this.value==\'请输入新昵称\')this.value=\'\';"';?>/>  &nbsp; <input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;<span class="f_gray">如无特殊情况，建议不要频繁修改用户昵称</span>
</td>
</tr>
</table>
</form>	
<div class="tt">手机查询</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;手机号： <input type="text" name="mob" size="30" id="mob"/> &nbsp; <input type="button"  value=" 查 询 " class="btn" onclick="if(Dd('mob').value){_mobile(Dd('mob').value);}"/>&nbsp;&nbsp;<span class="f_gray">可查询手机所在地区</span>
</td>
</tr>
</table>
<div class="tt">IP查询</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;IP地址： <input type="text" name="ip" size="30" id="ip"/> &nbsp; <input type="button"  value=" 查 询 " class="btn" onclick="if(Dd('ip').value){_ip(Dd('ip').value);}"/>&nbsp;&nbsp;<span class="f_gray">可查询IP所在地区</span>
</td>
</tr>
</table>
<div class="tt">IP解锁</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="unlock"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;IP地址： <input type="text" name="ip" size="30"/> &nbsp; <input type="submit" name="submit" value=" 解 锁 " class="btn"/>&nbsp;&nbsp;<span class="f_gray">可解除因登录失败次数过多而被锁定登录的IP</span>
</td>
</tr>
</table>
</form>
<br/><br/><br/>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>