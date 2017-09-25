<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE HTML>
<html> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ebooking-酒店管理系统</title>
    <link rel='stylesheet' type='text/css' href='<?php echo DT_SKIN;?>new/basis_v3.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo DT_SKIN;?>new/header_v3.css' />
    <script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/admin.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/member.js"></script>
  </head>
  <body>
  <div id="msgbox" style="display:none;"></div>
<?php echo dmsg();?>
    <div id="divHeader" class="ebk3-main-header">
      <div class="ebk3-main-header-cont clearfix">
        <i class="ebk3-ico ebk3-ico-logo"></i>
        <div class="header-userAccount">
          <ul class="clearfix">
            <li id="divUserCenterLink" class="header-account-infoItem header-account-loginInfo">
              <i id="accountPhoto" class="ebk3-ico ebk3-ico-accountPhoto48 ebk3-ico-man"></i>
              <div class="loginInfo-name">
                <div class="ebk3-disInbl">
                  <span class="ebk3-ellipsis" id="loginname"><?php echo $_truename;?></span></div>
              </div>
              <div class="loginInfo-opra" id="divSetting" style="display: ">
                <span id="usersetting"><a href="edit.php">设置</a></span>&nbsp;
                <span id="accountmanagment"><a href="edit.php">修改密码</a></span>&nbsp;</div>
              <i id="newTag" class="ebk3-ico ebk3-ico-header-rmd-tag" style="background: #ff6600; border-radius:20px; text-align:center;"><a href="message.php"><?php echo $_message;?></a></i>
            </li>
            <li class="header-account-infoItem header-helpCenter">
              <span id="logout"><a href="logout.php">[退出]</a></span></li>
          </ul>
        </div>
        <div class="header-hoteInfo">
          <h5 class="hoteInfo-name">
            <a class="ebk3-simpleBtn" id="aHotelName"  target="_blank">
              <span id="lblHotelName" style="margin-top: 14px;display: block;"><?php echo $_company;?></span></a>
          </h5>
        </div>
      </div>
      <div class="ebk3-main-header-container">
        <div class="ebk3-main-header-nav">
          <div class="header-nav-list-container">
            <div class="header-nav-list">
              <span id="divMenu">
                <div class="header-nav-item" data-categary="Index2">
                  <a class="header-nav-fa" href="index.php" id="index">首页</a></div>
                <div class="header-nav-item" data-categary="/OrderList">
                  <a class="header-nav-fa" href="trade.php?action=index" id="dingdan">订单处理</a></div>
                <div class="header-nav-item" data-categary="RoomStatus">
                  <a class="header-nav-fa" href="fangtai.php" id="fangtai">房态维护</a></div>
                <div class="header-nav-item" data-categary="audit">
                  <a class="header-nav-fa" href="fangjia.php" id="fangjia">房价维护</a></div>
                <!-- <div class="header-nav-item" data-categary="propertyinfo">
                  <a class="header-nav-fa" href="edit.php" id="jiudian">酒店维护</a></div> -->
                <div class="header-nav-item" data-categary="GBK">
                  <a class="header-nav-fa" href="my.php?mid=16" id="fangxing">房型维护</a></div>
                <div class="header-nav-item" data-categary="GBK">
                  <a class="header-nav-fa" href="shenhe.php" id="shenhe">住店审核</a></div>
                <div class="header-nav-item" data-categary="GBK">
                  <a class="header-nav-fa" href="caiwu.php" id="caiwu">财务管理</a></div>
                
              </span>
            </div>
          </div>
        </div>
      </div>
</div>