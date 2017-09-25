<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>提示信息</title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="static/style/weui.min.css">
<link rel="stylesheet" href="static/style/index.min.css">
</head>
<body>
    <div class="head">
    <a onclick="history.go(-1)"><img src="static/style/back.png" width="22" height="14"  alt=""/></a>
      <div>提醒</div>
        <a href="../mobile"><img src="static/style/home.png" width="22" height="21"  alt=""/></a>
    </div>
    <div class="container">
<div style="margin: 10px;padding: 10px;height: 120px;">
    <?php echo $msg;?>
    </div>
</div>
    <?php if($action=="show") { ?>
    <div class="orderdetailtime">
    <div id="clock"></div>
    <div class="tip" id="tips"><?php echo $title;?></div>
</div>
<div class="weui-panel__bd">
    <div class="weui-media-box weui-media-box_text">
        <p class="weui-media-box__desc"><?php echo $content;?></p>
    </div>
</div>
    <?php } else { ?>
    <div style="padding: 5px;">
    <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
    <ul>
    
    <li style="list-style: none;display: inline-block;width: 100%;"><span style="float:left;width:25px;"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/message_<?php echo $v['typeid'];?>.gif" width="16" height="16"/></span>
    <a href="message.php?action=show&itemid=<?php echo $v['itemid'];?>"><h2 class="weui-media-box__title" style="float:left;font-size: 15px;"><?php echo $v['title'];?></h2></a>
    <span style="float: right;font-size: 13px;color: #999;line-height: 2em;"><?php echo timetodate($v['addtime'],0);?></span>
    </li>
    
</ul>
<?php } } ?>
    </div>
    <?php } ?>
</body>
</html>
