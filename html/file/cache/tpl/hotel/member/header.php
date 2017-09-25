<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if($DT_TOUCH==8) { ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?php echo DT_CHARSET;?>"/>
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width"/>
<title><?php echo $head_title;?></title>
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
<meta name="robots" content="nofollow"/>
<meta name="generator" content="Hotel - QQ:59693566"/>
<meta http-equiv="x-ua-compatible" content="IE=8"/>
<title><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
用户中心<?php echo $DT['seo_delimiter'];?><?php if($city_sitename) { ?><?php echo $city_sitename;?><?php } else { ?><?php echo $DT['sitename'];?><?php } ?>
<?php echo $DT['seo_delimiter'];?>Powered By Hotel</title>
<?php } ?>
<link rel="shortcut icon" href="<?php echo DT_STATIC;?>favicon.ico"/>
<link rel="bookmark" href="<?php echo DT_STATIC;?>favicon.ico"/>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/style.css"/>
<?php if($DT_TOUCH==8) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EXT['mobile_url'];?>static/member.css"/>
<script type="text/javascript">var Dbrowser = '<?php echo $DT_MOB['browser'];?>';</script>
<?php } else { ?>
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>ie6.css"/>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/ie6png.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--[if IE]>
<style type="text/css">
.head_user em {margin:-4px 0 0 -4px;}
#mini_profile {margin:20px 0 0 -140px;}
</style>
<![endif]-->
<?php } ?>
<?php if(!DT_DEBUG) { ?><script type="text/javascript">window.onerror= function(){return true;}</script><?php } ?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/admin.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/member.js"></script>
<?php if($DT_TOUCH==8) { ?><script type="text/javascript" src="<?php echo $EXT['mobile_url'];?>static/js/fix.js"></script><?php } ?>
</head>
<body>
<div id="msgbox" style="display:none;"></div>
<?php echo dmsg();?>
<?php if($DT_TOUCH==8) { ?>
<div id="head-bar">
<div class="head-bar">
<div class="head-bar-right"><a href="<?php echo $EXT['mobile_url'];?>my.php?action=back"><span>我的</span></a></div>
<div class="head-bar-back"><a href="javascript:window.history.back();"><img src="<?php echo $EXT['mobile_url'];?>static/img/icon-back.png"/><span>返回</span></a></div>
<div class="head-bar-title"><?php if($head_title) { ?><?php echo $head_title;?><?php } else { ?>用户中心<?php } ?>
</div>
</div>
<div class="head-bar-fix"></div>
</div>
<?php } else { ?>
<div class="head" id="head">
<div class="head_m">
<div class="head_logo"><a href="<?php echo $MODULE['2']['linkurl'];?>"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/logo.png" alt="商务中心"/></a></div>
<div class="head_main">
<ul>
<?php if($_userid) { ?>
<li class="menu_1" id="menu_0" onclick="c(0);">用户服务</li>

<li class="menu_2" id="menu_1" onclick="c(1);" style="display:none">信息管理</li>
<li class="menu_2" id="menu_2" onclick="c(2);">交易管理</li>
<?php if($MG['homepage'] || $show_menu) { ?>
<li class="menu_2" id="menu_3" onclick="c(3);">酒店管理</li>
<?php } ?>
<?php } ?>
<li class="menu_2"><a href="<?php echo DT_PATH;?>">网站首页</a></li>
</ul>
</div>
<div class="head_user">
<?php if($_userid) { ?>
<ul>
<li id="my_profile"><a href="avatar.php"><img src="<?php echo useravatar($_username, 'small');?>" width="20" height="20" id="myavatar"/></a>
<div id="mini_profile" style="display:none;">
<div>
<dl>
<dt><span class="f_r"><a href="edit.php"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/setting.gif" width="10" height="10" align="absmiddle" title="资料设置"/></a></span><span class="f_b px14">欢迎，<?php echo $_truename;?></span> (<?php echo $_username;?>) <a href="<?php echo $MODULE['2']['linkurl'];?>line.php" title="<?php if($_online) { ?>在线，点击隐身<?php } else { ?>隐身，点击上线<?php } ?>
"><img src="<?php echo DT_SKIN;?>image/user_<?php if($_online) { ?>on<?php } else { ?>off<?php } ?>
line.png" width="10" height="10" align="absmiddle"/></a></dt>
<dt><a href="<?php echo userurl($_username);?>" target="_blank" title="<?php echo $_company;?>"><span class="f_black"><?php echo $_company;?></span></a>(<?php echo $MG['groupname'];?>)&nbsp;&nbsp;&nbsp;<a href="profile.php"><span class="f_dblue">账户详情&raquo;</span></a></dt>
<dt><a href="record.php"><span class="f_black"><?php echo $DT['money_name'];?>:<?php echo $_money;?></span></a> <span class="f_gray">|</span> 
<a href="credit.php"><span class="f_black"><?php echo $DT['credit_name'];?>:<?php echo $_credit;?></span></a></dt>
</dl>
</div>
</div>
</li>
<li id="destoon_message"><a href="message.php">消息</a><?php if($_message) { ?><em><?php echo $_message;?></em><?php } ?>
</li>
<?php if($DT['im_web']) { ?><li id="destoon_chat"><a href="chat.php">对话</a><?php if($_chat) { ?><em><?php echo $_chat;?></em><?php } ?>
</li><?php } ?>
<li><a href="logout.php?forward=">退出</a></li>
<?php if($admin_user) { ?><li><a href="index.php?action=logout">注销授权</a></li><?php } ?>
</ul>
<?php } else { ?>
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>">立即登录</a> | 
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>">注册用户</a>
<?php } ?>

</div>
<div class="c_b"></div>
</div>
</div>
<div class="head_s" id="destoon_space">&nbsp;</div>
<?php } ?>
<div class="main_tb">
<table cellpadding="0" cellspacing="0" width="<?php if($DT_TOUCH==8) { ?>960<?php } else { ?>100%<?php } ?>
">
<tr>
<?php if(!$DT_TOUCH) { ?>
<td valign="top" class="side" id="side">
<div id="sub_0" style="display:<?php if($_userid) { ?><?php } else { ?>none<?php } ?>
">
<?php if($_userid || $show_menu) { ?>
<div class="side_head" id="h_0"><div>用户服务</div></div>
<div class="side_body" id="b_0">
<ul>
<?php if($MG['inbox_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="message"><a href="message.php" class="<?php if($MG['inbox_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">站内信件</a><?php if($_message) { ?><em><?php echo $_message;?></em><?php } ?>
</li>
<?php } ?>



<!-- <?php if($MG['spread'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="spread"><span class="f_r"><a href="spread.php?action=add" class="m">购买</a></span><a href="spread.php" class="<?php if($MG['spread']) { ?>n<?php } else { ?>f<?php } ?>
">排名推广</a></li>
<?php } ?>
 -->
<!-- <?php if($MG['ad'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="ad"><span class="f_r"><a href="ad.php?action=add" class="m">购买</a></span><a href="ad.php" class="<?php if($MG['ad']) { ?>n<?php } else { ?>f<?php } ?>
">广告预定</a></li>
<?php } ?>
 -->
<?php if($show_oauth) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="oauth"><span class="f_r"><a href="oauth.php" class="m">绑定</a></span><a href="oauth.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">一键登录</a></li>
<?php } ?>
<?php if($EXT['weixin']) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="weixin"><span class="f_r"><a href="weixin.php" class="m">绑定</a></span><a href="weixin.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">微信关注</a></li>
<?php } ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="edit"><a href="edit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">修改资料</a></li>
<?php if($MG['ask'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="ask"><span class="f_r"><a href="ask.php?action=add" class="m">提问</a></span><a href="ask.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">客服中心</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
</div>
<div id="sub_1" style="display:<?php if($_userid) { ?>none<?php } else { ?><?php } ?>
">
<?php if($MYMODS || $show_menu) { ?>
<div class="side_head" id="h_1"><div>信息管理</div></div>
<div class="side_body" id="b_1">
<ul>
<?php if(is_array($MENUMODS)) { foreach($MENUMODS as $k => $v) { ?>
<?php if($v==9) { ?>
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="mid_job"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=9&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=9" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">招聘管理</a></li> -->
<?php } else if($v==-9) { ?>
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="mid_resume"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=9&action=add&resume=1" class="m">创建</a></span><a href="<?php echo $DT['file_my'];?>?mid=9&resume=1" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">简历管理</a></li> -->
<?php } else if($v==18) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);"  id="mid_<?php echo $v;?>"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>&job=group&action=add" class="m">创建</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $MODULE[$v]['name'];?>管理</a></li>
<?php } else { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);"  id="mid_<?php echo $v;?>"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $MODULE[$v]['name'];?>管理</a></li>
<?php } ?>
<?php } } ?>
</ul>
</div>
<?php } ?>
</div>
<div id="sub_2" style="display:none;">
<?php if($_userid || $show_menu) { ?>
<div class="side_head" id="h_2"><div>交易管理</div></div>
<div class="side_body" id="b_2">
<ul>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="trade"><a href="trade.php?action=order" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">我的订单</a></li>
<!-- <?php if(isset($MODULE['17'])) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="group"><span class="f_r"><a href="group.php?action=order" class="m">买家</a></span><a href="group.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">团购订单</a></li>
<?php } ?>
 -->
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="record"><span class="f_r"><a href="record.php?action=pay" class="m">站内</a></span><a href="record.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>流水</a></li> -->
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="charge"><span class="f_r"><a href="charge.php?action=pay" class="m">充值</a></span><a href="charge.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">充值记录</a></li> -->
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="deposit"><span class="f_r"><a href="deposit.php?action=add" class="m">增资</a></span><a href="deposit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">保 证 金</a></li>
 -->
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="cash"><span class="f_r"><a href="cash.php" class="m">提现</a></span><a href="cash.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>提现</a></li> -->
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="credit"><span class="f_r"><a href="credit.php?action=buy" class="m">购买</a></span><a href="credit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['credit_name'];?>管理</a></li> -->
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="dianziquan"><a href="dianziquan.php?action=order" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">电子券</a></li>

</ul>
</div>
<?php } ?>
</div>
<div id="sub_3" style="display:none;">
<?php if($MG['homepage'] || $show_menu) { ?>
<div class="side_head" id="h_3"><div>酒店管理</div></div>
<div class="side_body" id="b_3">
<ul>
<?php if($MG['homepage'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="homepage"><span class="f_r"><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1" class="m" target="_blank">预览</a></span><a href="home.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">酒店设置</a></li>
<?php } ?>
<?php if($MG['homepage'] || $show_menu) { ?>
<!-- <li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" id="style"><span class="f_r"><a href="style.php?action=view" class="m">查看</a></span><a href="style.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">模板设置</a></li> -->
<?php } ?>

</ul>
</div>
<?php } ?>
</div>
</td>
<td class="side_h" onclick="oh(this);" title="点击展开/隐藏侧栏" id="side_oh">&nbsp;</td>
<?php } ?>
<td valign="top" class="main" id="main">