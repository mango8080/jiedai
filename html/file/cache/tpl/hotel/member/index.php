<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $module);?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/index.css"/>
<div id="warn">
<?php if($_groupid == 4) { ?>
<div class="warn">尊敬的用户，您的帐号<span class="f_red">正在审核中..</span>，本站部分功能和服务可能受到一定的使用限制，<?php if($MOD['checkuser']==2) { ?><a href="send.php?action=check" class="l">请点这里验证您的邮箱</a>，系统将自动审核<?php } else { ?>请稍候，等待网站审核<br/>完善的商业信息有助于审核通过的概率&nbsp;&nbsp;<a href="edit.php?tab=2" class="t">现在就去完善&raquo;</a><?php } ?>
</div>
<?php } ?>
<?php if($_groupid > 5 && !$_edittime) { ?>
<div class="warn">贵公司尚未完善详细资料！完善的商业信息有助于获得别人的信任&nbsp;&nbsp;<a href="edit.php?tab=2" class="t">现在就去完善&raquo;</a></div>
<?php } ?>
<?php if($vip && $havedays < 30 && $havedays > 0) { ?>
<div class="warn">尊敬的<?php echo $MG['groupname'];?>，您的<?php echo VIP;?>服务将在 <strong class="f_red"><?php echo $havedays;?></strong> 天后到期，为了不影响您的正常使用，请您尽快续费&nbsp;&nbsp;<a href="vip.php?action=renew" class="t">立即续费&raquo;</a></div>
<?php } ?>
</div>
<div class="iuser">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="120" valign="top" align="center"><div class="iuser_avatar"><a href="avatar.php"><img src="<?php echo useravatar($_username, 'large');?>" width="100" height="100"/></a></div></td>
<td valign="top" width="400">
<ul>
<li><span class="f_b px14" title="">欢迎，<?php echo $_truename;?></span> (<?php echo $_username;?>) <a href="<?php echo $MODULE['2']['linkurl'];?>line.php" title="<?php if($_online) { ?>在线，点击隐身<?php } else { ?>隐身，点击上线<?php } ?>
"><img src="<?php echo DT_SKIN;?>image/user_<?php if($_online) { ?>on<?php } else { ?>off<?php } ?>
line.png" width="10" height="10" align="absmiddle"/></a></li>
<li><a href="<?php echo $linkurl;?>" target="_blank"><?php echo $_company;?></a>(<?php echo $MG['groupname'];?>)&nbsp;&nbsp;&nbsp;<a href="profile.php" class="t">账户详情&raquo;</a></li>
<?php if($MOD['vmember']) { ?>
<li>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($validated) { ?>v<?php } else { ?>u<?php } ?>
_member.gif" width="16" height="16" title="<?php if($validated) { ?>已通过<?php echo $validator;?>认证<?php } else { ?>未通过认证<?php } ?>
" align="absmiddle"/> 认证：
<?php if($MOD['vemail']) { ?>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($vemail) { ?>v<?php } else { ?>u<?php } ?>
_email.gif" width="16" height="16" title="<?php if($vemail) { ?>已通过<?php } else { ?>未通过<?php } ?>
邮件认证" align="absmiddle"/> <a href="validate.php?action=email" class="l">邮件</a> &nbsp;
<?php } ?>
<?php if($MOD['vmobile']) { ?>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($vmobile) { ?>v<?php } else { ?>u<?php } ?>
_mobile.gif" width="16" height="16" title="<?php if($vmobile) { ?>已通过<?php } else { ?>未通过<?php } ?>
手机认证" align="absmiddle"/> <a href="validate.php?action=mobile" class="l">手机</a> &nbsp;
<?php } ?>
<?php if($MOD['vbank']) { ?>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($vbank) { ?>v<?php } else { ?>u<?php } ?>
_bank.gif" width="16" height="16" title="<?php if($vbank) { ?>已通过<?php } else { ?>未通过<?php } ?>
银行帐号认证" align="absmiddle"/> <a href="validate.php?action=bank" class="l">银行</a> &nbsp;
<?php } ?>
<?php if($MOD['vtruename']) { ?>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($vtruename) { ?>v<?php } else { ?>u<?php } ?>
_truename.gif" width="16" height="16" title="<?php if($vtruename) { ?>已通过<?php } else { ?>未通过<?php } ?>
真实姓名认证" align="absmiddle"/> <a href="validate.php?action=truename" class="l">实名</a> &nbsp;
<?php } ?>
<?php if($MOD['vcompany'] && $groupid > 5) { ?>
<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/<?php if($vcompany) { ?>v<?php } else { ?>u<?php } ?>
_company.gif" width="16" height="16" title="<?php if($vcompany) { ?>已通过<?php } else { ?>未通过<?php } ?>
公司资料认证" align="absmiddle"/> <a href="validate.php?action=company" class="l">公司</a>
<?php } ?>
</li>
<?php } else { ?>
<li>上次登录：<?php echo timetodate($logintime, 5);?></li>
<?php } ?>
</ul>
</td>
<td valign="top">
<div class="iuser_money">
<p class="f_b px14">账户余额</p>
<span class="my_money"><?php echo $DT['money_sign'];?><?php echo $my_money;?></span> <?php echo $DT['money_unit'];?>
&nbsp;&nbsp;
<a href="record.php" class="t">流水</a> <span class="f_gray">&nbsp;|&nbsp;</span> 

<a href="charge.php?action=pay" target="_blank"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/btn_charge.gif" width="40" height="18" alt="" align="absmiddle"/></a>
</div>
</td>
</tr>
</table>
</div>
<div class="icount">
<table cellpadding="0" cellspacing="0">
<tr>
<td onclick="Go('message.php');"><div>新消息</div><span><?php echo $_message;?></span></td>
<td onclick="Go('credit.php');"><div><?php echo $DT['credit_name'];?></div><span><?php echo $_credit;?></span></td>
<td onclick="Go('trade.php');"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/icon_order.png" width="32" height="32"/><br/><span>我的订单</span></td>
</tr>
</table>
</div>
<!-- <div class="ihead">
<strong>系统消息</strong>
</div> -->
<!-- <div class="ibody">
<div class="isys">
<ul>
<?php if($sys) { ?>
<?php if(is_array($sys)) { foreach($sys as $v) { ?>
<li><span class="f_r px11 f_gray"><?php echo timetodate($v['addtime'], 3);?></span>&nbsp;<a href="message.php?action=show&itemid=<?php echo $v['itemid'];?>" title="<?php echo $v['title'];?>" class="l"><?php echo $v['title'];?></a></li>
<?php } } ?>
<?php } else { ?>
<li>&nbsp;暂无消息</li>
<?php } ?>
</ul>
</div>
</div> -->
<?php include template('footer', $module);?>