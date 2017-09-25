<?php defined('IN_DESTOON') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="telephone=no" name="format-detection">
<meta content="address=no" name="format-detection">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<title>申请信息</title>
<link type="text/css" rel="stylesheet"  href="static/css/bootstrap.min.css">
<!-- <link  type="text/css" rel="stylesheet" href="static/css1/bootstrap-datetimepicker.min.css"> -->
<link type="text/css" rel="stylesheet"  href="static/css/base.css">
<link type="text/css" rel="stylesheet"  href="static/css/default.css">
<link type="text/css" rel="stylesheet"  href="static/css/iocn.css">
<script type="text/javascript" src="static/script/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="static/script/bootstrap.min.js"></script>
<script type="text/javascript" src="static/script/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="static/script/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="static/script/time.js" ></script>
<script type="text/javascript" src="static/script/zepto.min.js"></script>
<script type="text/javascript" src="static/script/src/touch.js"></script>
<style type="text/css">
.coupons2,.select_date{position:fixed;  left:0; right:0;  top:0; bottom:0; width:100%; height:100%; overflow:hidden;  z-index:99;  background-color:#fff;  }
select.ui-select,select.ui-select option{direction: rtl;}
.book_info .info_list>.row .room_name{font-size:14px;}
.book_info .info_list>.row .xinxi{font-size:14px;}
 .bottom_box {
    display: block;
    width: 90%;
    height: 45px;
    margin: 0 auto;
    color: #fff;
    border-radius: 23px;
    background-color: rgba(255, 99, 76, 1);
}
 .bottom_box div.col-xs-6 {
    padding: 0;
}
.bottom_box div.col-xs-6:nth-child(1){
    margin-top:11px;
    border-right:1px solid #fff;
    font-size:12px;
    text-align:center;
}
.bottom_box div.col-xs-6:nth-child(2) a{
    font-size:18px;
}
select.ui-select, select.ui-select option{font-size:14px !important}
</style>
</head>
<body>
<link rel="stylesheet" href="static/dialog/ui-dialog.css" />
<!-- <script src="static/script/jquery-1.11.2.min.js"></script> -->
<script type='text/javascript' src='static/dialog/dialog-min.js'></script>
<script type="text/javascript">
//jquery和tap冲突的解决方式
/*$.noConflict();*/
//自定义弹出框，dialog
function jAlert(content){
var d = dialog({
    title: '提示',
    content: content,
    okValue: '确定',
    ok: function () {
    }
});
d.showModal();
}
//提示后，点击确定跳转
function jAlert2(content,redictUrl){
var d = dialog({
    title: '提示',
    content: content,
    okValue: '确定',
    ok: function () {
    window.location.href = redictUrl;
    }
});
d.showModal();
}
//转菊花的加载效果
jQuery(function() {
var d = dialog( {
zIndex : 87
});
jQuery(document).ajaxStart(function() {
d.showModal();
});
jQuery(document).ajaxComplete(function() {
d.close();
});
});
</script>
<script type="text/javascript">
window.onload=function(){
var _width=document.documentElement.clientWidth;
document.body.style.width=_width+'px';
}
function goBack(){
var referrer = document.referrer;
var url = window.location.href;
//alert(url);
if(referrer == null || referrer ==''){
//从微信访问进来，没有上一个页面时，默认返回到首页
window.location.href="/index.htm";
}else{
/* window.history.back(); */

window.history.back();

}
}
</script>
<header class="clearfix" style="position:fixed;top:0;width:100%;background:#FFF;z-index:99">
<a onclick="history.go(-1)" class="back"><img src="static/images/back.png" height="14" /></a>
<h1 class="f-16 b" style="font-size:16px;">填写信息</h1>
<a href="../mobile" class="home"><img src="static/images/home.png" height="21px"/></a>
</header>
<form id ="submitForm" action="" method="post"> 
<section class="ui-box">
<div class="book_info">
<div class="top">
    <p><?php echo $t['company'];?></p>
    </div>
<?php if($roomNum==6) { ?>
<div class="container-fluid info_list">
    <div class="row">
    <div class="col-xs-4">
    <p class="l_title">姓名</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="name" value="" placeholder="请填写正确姓名">
    </div>
    </div>
    <div class="row">
    <div class="col-xs-4">
    <p class="l_title">手机号码</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="mobile" value="<?php echo $u['mobile'];?>" placeholder="请填写正确手机号码">
    </div>
    </div>
    <div class="row">
    <div class="col-xs-4">
    <p class="l_title">银行卡号</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="yhkh" value="" placeholder="请填写正确银行卡号">
    </div>
    </div>

        <div class="row">
                <div class="col-xs-4">
                    <p class="l_title">申请金额</p>
                </div>
                <div class="col-xs-8" >
                    <input id="note" name="tixian" class="h90"  placeholder="申请金额">
                    </input>
                </div>
            </div>
       <div class="row">
            <div class="col-xs-4" style="width:100%">
                申请金额应为100的倍数，最低提现金额100元，请用户仔细核实自己的提成是否足够
            </div>
          
        </div>

    </div>


<?php } else { ?>

    <div class="container-fluid info_list">
    <div class="row">
    <div class="col-xs-4">
    <p class="l_title">姓名</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="name" value="" placeholder="请填写正确姓名">
    </div>
    </div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">年龄</p>
</div>
<div class="col-xs-8">
<input class="xinxi" type="text" name="nianling" value="" placeholder="请填写正确年龄">
</div>
</div>
    
    <!--<div class="row">
    <div class="col-xs-4">
    <p class="l_title">房间数</p>
    </div>
    <div class="col-xs-8">
                <div class="rooms_mp">
                    <div id="minus"><img alt="" src="static/images/minus.png" height="25"></div>
                    <div class="room_number"><?php echo $roomNum;?></div>
                    <div id="plus"><img alt="" src="static/images/plus.png" height="25"></div>
                </div>
            </div>
    </div>-->
    <div class="row">
    <div class="col-xs-4">
    <p class="l_title">手机号码</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="mobile" value="<?php echo $u['mobile'];?>" placeholder="请填写正确手机号码">
    </div>
    </div>
    
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">年收入/万</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="nianshouru" value="" placeholder="请填写正确年收入">
    </div>
    </div>
<?php if($roomNum==2) { ?>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">企业名称</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="danweiname" value="" placeholder="请填写正确单位名称">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">企业所在地</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="qiyedizhi" value="" placeholder="请填写正确企业所在地">
    </div>
    </div>
 <div class="row">
            <div class="col-xs-4">
                <p class="l_title">国税</p>
            </div>
            <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="guoshui" value="shi" />
否<input type="radio" checked="checked" name="guoshui" value="fou" />
</div>
            </div>
           </div>
           <div class="row">
            <div class="col-xs-4">
                <p class="l_title">地税</p>
            </div>
           <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="dishui" value="shi" />
否<input type="radio" checked="checked" name="dishui" value="fou" />
</div>
            </div>
           </div>
   <div class="row">
            <div class="col-xs-4">
                <p class="l_title">POS流水</p>
            </div>
           <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="pos" value="shi" />
否<input type="radio" checked="checked" name="pos" value="fou" />
</div>
            </div>
           </div>
<?php } else if($roomNum==3) { ?>
<div class="row">
<div class="col-xs-4">
<p class="l_title">信用卡账单邮箱：</p>
</div>

</div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">邮箱帐号</p>
</div>
<div class="col-xs-8">
<input class="xinxi" type="text" name="youxiang" value="" placeholder="如有多个请用空格间隔">
</div>
</div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">邮箱密码</p>
</div>
<div class="col-xs-8">
<input class="xinxi" type="text" name="yxmima" value="" placeholder="与帐号对应使用空格间隔即可">
</div>
</div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">信用卡查询网银：</p>
</div>

</div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">查询网银登录账号</p>
</div>
<div class="col-xs-8">
<input class="xinxi" type="text" name="xykzh" value="" placeholder="如有多个请用空格间隔">
</div>
</div>
<div class="row">
<div class="col-xs-4">
<p class="l_title">查询密码</p>
</div>
<div class="col-xs-8">
<input class="xinxi" type="text" name="xykmima" value="" placeholder="与帐号对应使用空格间隔即可">
</div>
</div>
<?php } else if($roomNum==5) { ?>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">车牌号</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="car" value="" placeholder="请填写正确车牌号">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">车龄</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="carnj" value="" placeholder="请填写购买多少年">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">汽车品牌型号</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="carxh" value="" placeholder="请填写汽车品牌型号">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">购车价格</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="carprice" value="" placeholder="请填写购车价格">
    </div>
    </div>
<div class="row">
           
            <div class="col-xs-4">
                <p class="l_title">按揭车/全款车</p>
            </div>
            <div class="col-xs-8">
                <span id="invoice" style="float:right;width: 100%;text-align: right;padding-right: 10px;">
                    <span id="invoice1" style="font-size: 11px;border:1px solid #ddd;padding: 4px 0;">
                        <span id="need" style="cursor: pointer;padding: 3px;border-radius: 0 5px 5px 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <span id="unneed" style="color: #FFF;background:#ddd;padding: 3px;border-radius: 5px 0 0 5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </span>
                </span>
            </div>
            <div id="dian_piao" style="display: none;">
                
                <input class="xinxi" type="text" name="yhke" id="invoice_tt" placeholder="请输入月还款额">
                <input class="xinxi" type="text" name="yhqs" placeholder="请输入已还期数">
               </div>
        </div>
<?php } else if($roomNum==4) { ?>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">房产所在位置</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="home" value="" placeholder="请填写房屋位置">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">房龄</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="carnj" value="" placeholder="请填写购买多少年">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">房产面积</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="homedx" value="" placeholder="请填写房屋大小/平方">
    </div>
    </div>
<div class="row">
    <div class="col-xs-4">
    <p class="l_title">房产总价</p>
    </div>
    <div class="col-xs-8">
    <input class="xinxi" type="text" name="carprice" value="" placeholder="请填写房屋价格">
    </div>
    </div>
<div class="row">
           
            <div class="col-xs-4">
                <p class="l_title">按揭房/全款房</p>
            </div>
            <div class="col-xs-8">
                <span id="invoice" style="float:right;width: 100%;text-align: right;padding-right: 10px;">
                    <span id="invoice1" style="font-size: 11px;border:1px solid #ddd;padding: 4px 0;">
                        <span id="need" style="cursor: pointer;padding: 3px;border-radius: 0 5px 5px 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <span id="unneed" style="color: #FFF;background:#ddd;padding: 3px;border-radius: 5px 0 0 5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </span>
                </span>
            </div>
            <div id="dian_piao" style="display: none;">
                
                <input class="xinxi" type="text" name="yhke" id="invoice_tt" placeholder="请输入月还款额">
                <input class="xinxi" type="text" name="yhqs" placeholder="请输入已还期数">
               </div>
        </div>
<?php } else { ?>
         <div class="row">
            <div class="col-xs-4">
                <p class="l_title">月缴公积金</p>
            </div>
            <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="gjj" value="shi" />
否<input type="radio" checked="checked" name="gjj" value="fou" />
</div>
            </div>
           </div>
           <div class="row">
            <div class="col-xs-4">
                <p class="l_title">银行代发工资</p>
            </div>
           <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="yhdf" value="shi" />
否<input type="radio" checked="checked" name="yhdf" value="fou" />
</div>
            </div>
           </div>
          <div class="row">
            <div class="col-xs-4">
                <p class="l_title">月缴社保</p>
            </div>
            <div class="col-xs-8">
   <div class="xuanze" style="margin-left:120px;">
                是<input type="radio" checked="checked" name="shebao" value="shi" />
否<input type="radio" checked="checked" name="shebao" value="fou" />
</div>
            </div>
        </div>
<?php } ?>
        <div class="row">
                <div class="col-xs-4">
                    <p class="l_title">用户留言</p>
                </div>
                <div class="col-xs-8" style="text-align:right";>
                    <input id="note" name="snote" class="h90" style="border:none;text-align: right;" placeholder="留言...">
                    </input>
                </div>
            </div>
       <!-- <div class="row">
            <div class="col-xs-4" style="width:28%">
                <p class="l_title">特色方服务</p>
            </div>
            <div class="col-xs-8 quan"  style="width:70%;line-height:50px">
               
             
            </div>
        </div>-->

    </div>
 <?php } ?>
    <p id="tips"></p>
    
   <!--  <a href="javascript:void(0)" id="submit" class="btn btn_default" role="button" style="width:100%; margin-top: 20px;">提 交</a> -->
    <div style="height:44px;width:90%;color"></div>
    <div class="bottom_box">
        <div class="col-xs-6">
             
        </div>
<div class="col-xs-6">
<a href="javascript:void(0)" id="submit" class="btn btn_default" role="button" style="width:auto;">提 交</a>
</div>
</div>
</div>
<div class="mingxi_info" id="note_info" style="display:none;">
<a class="btn_guanbi"><img alt="" src="static/images/guanbi.png" height="20"></a>
<dl>
<dt>电子券使用说明</dt>
<dd class="clearfix">
<span style="width:100%;text-align:left;"></span>
</dd>
</dl>
</div>
<div class="mingxi_info" id="mingxi_info" style="display:none;">
<a class="btn_guanbi"><img alt="" src="static/images/guanbi.png" height="20"></a>
<dl>
<dt>房价明细</dt>
<dd class="clearfix">
<span>日期</span>
<span>&nbsp;&nbsp;</span>
<span><?php echo $t['title'];?></span>
</dd>
</dl>
<p>
<span class="right">应付金额：<em><span class="realPrice"></span></em></span>
</p>
</div>
<div class="hotel_search select_date" style="display: none;">
<header>
<a class="back_dlrq"><img alt="" src="static/images/back.png" height="14"></a>
<h1 style="font-size: 17px;">修改抵离日期</h1>
<a href="/index.htm" class="home"><img src="static/images/home.png" height="21px"></a>
</header>
<ul class="search_list">
<li id="checkInDate" class="arrow date input-group" data-date-format="dd MM yyyy" data-link-format="yyyy-mm-dd" data-date=""  data-link-field="dtp_input2">
            <input id="dtp_input2" readonly="readonly"/>
            <span id="checkInweek">（今天）</span>
            <span class="b_2" >入住</span>
        </li>
        <li id="checkOutDate" class="arrow date input-group" data-date-format="dd MM yyyy" data-link-format="yyyy-mm-dd" data-date=""  data-link-field="dtp_input3">
            <input id="dtp_input3" readonly="readonly"/>
            <span id="checkOutweek">（明天）</span>
            <span class="b_2">离店</span>
            <span id="godays">（共1晚）</span>
        </li>
</ul>
<div style="padding: 20px 15px">
<a id="btnSelectDate" class="btn btn_default">确 认</a>
</div>
</div>
<div class="mask" style="display:none;"></div>
</section>
<!-- 电子券 -->
<input type="hidden" name="username" value="<?php echo $u['username'];?>" />
<input type="hidden" name="beginDate" value="<?php echo $beginDate;?>" />
<input type="hidden" name="endDate" value="<?php echo $endDate;?>" />
<input type="hidden" name="itemid" value="<?php echo $t['itemid'];?>" />
<input type="hidden" name="hongbao" value="<?php echo $zhekouhou;?>" />
<input type="hidden" name="ratePlanId" value="DISG37" />
<input type="hidden" name="roomNum" value="<?php echo $roomNum;?>"/>
<input type="hidden" name="hotelName" value="<?php echo $t['company'];?>"/>
<input type="hidden" name="roomName" value="<?php echo $t['title'];?>"/>
<input type="hidden" name="priceTotal" value=""/>
<input type="hidden" name="maxNum" value="<?php echo $t['amount'];?>"/>
<input type="hidden" name="coupons" value=""/>
<input type="hidden" name="couponsnum" value=""/>
<input type="hidden" name="couponsPrice" value="0"/>
<input type="hidden" name="ok" value="token" />
<input type="hidden" id="snote" value="<?php echo $DT['voucher_dis'];?>" />
</form>
<script type="text/javascript">
$(function(){


$("input[type=text]").select();
var coupons="";
var couponsPrice=0;
var couponsNum="";
var flag = true;
var count = 1;
var danjia=0;
    var RoomStatus='N';
//选择房间数
var reg=/^1[34578][0-9]\d{8}$/;
     function verifyOrder(){
    $('#submit').text('正在确认中');
 $('#submit').attr('disabled','disabled');
  
 $.ajax({
url:'verifyOrder.php',
data:changeURLArg($('#submitForm').serialize(),'roomNum',$('input[name=roomNum]').val()),
dataType:'json',
            async: false,
success:function(data){

                RoomStatus=data.result.orderInfo.RoomStatus;

danjia=data.result.orderInfo.totalPrice;
if(data.stat != 1){
jAlert(data.msg);
$('#submit').text(data.msg);
return false;
}

                $("#danjia").text("￥"+danjia);
$('.bottom').show();
$('#tips').text(data.result.tips);
if(data.result.orderInfo.hbPrice>0){
$('.realPrice').text("￥"+(data.result.orderInfo.totalPrice+couponsPrice+data.result.orderInfo.hbPrice)+"元");
}else{
$('.realPrice').text("￥"+(data.result.orderInfo.totalPrice+couponsPrice)+"元");
}
$('input[name=priceTotal]').val(data.result.orderInfo.totalPrice+couponsPrice);
$('input[name=maxNum]').val(data.result.orderInfo.amount);

var roomInfo = data.result.orderInfo.priceDetail,
roomNum = $('input[name=roomNum]').val();
//房价明细
$('#mingxi_info dl dd:gt(0)').remove();
for(var i=0;i<roomInfo.length;i++){
moddile = '<span style="wdith:100%;font-size: 0.8em;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
right="￥"+roomInfo[i].Price+"*"+roomNum+"间";
$('#mingxi_info dl').append('<dd class="clearfix"><span>'+roomInfo[i].left+'</span>'+moddile+'<span class="roomPrice">'+right+'</span></dd>');
}
$("input[name=userCoupon]").each(function(){
    if ($(this).is(":checked")) {
    right="￥"+$(this).data("price")+"*"+$("#count_"+$(this).data("id")).val()+"张";
    $('#mingxi_info dl').append('<dd class="clearfix"><span>'+$(this).data("title")+'</span>'+moddile+'<span class="roomPrice">'+right+'</span></dd>');
    }
     });
                if (RoomStatus=='A'){
                    $('#submit').text('提交');
                    $('#submit').removeAttr('disabled');
                }else{
                    $('#submit').text('房满');
                }
count = 1;
}
});
     }
     function calcoupons(){
    couponsPrice=0;
    couponsNum="";
     coupons="";
     aa="";
    $("input[name=userCoupon]").each(function(){
    if ($(this).is(":checked")) {
    coupons+=$(this).data("id")+",";
    couponsNum+=$("#count_"+$(this).data("id")).val()+",";
    couponsPrice+=parseFloat($(this).data("price"))*parseInt($("#count_"+$(this).data("id")).val());
    if (aa==""){
    aa=$(this).data("title");
    }else{
    aa+=","+$(this).data("title");
    }
    }
     });
     $('input[name=couponsPrice]').val(couponsPrice);
     $('input[name=coupons]').val(coupons);
     $('input[name=couponsnum]').val(couponsNum);
     
     verifyOrder();
    }
     calcoupons();
     verifyOrder();
     /*setTimeout(function(){
         $("#danjia").text("￥"+danjia);
     },500);*/
     
     
     $('.select_showdown').change(function(){
     var checkInDate = '';//入住日期
     var checkInTime = $(this).val();
     $('input[name=checkInDate]').val(checkInDate+' '+ checkInTime);
     });
     /*$('#usequan').on('tap click', function(e) {
     if ($("#spanquan").is(":hidden")) {
     $("#spanquan").show();
     }else{
     $("#spanquan").hide();
     }
     });*/
     $("#need").on('tap click',function(){
        if($("#cash").is(":checked")){
            jAlert("到店付款发票请向酒店前台索取");
        }else{
             $("#dian_piao").show();
             $("#select_piao").show();
             $("#unneed").css({
             "color":"#000",
                 "background":"#FFF",
                 "cursor": "pointer"
             });
             $("#invoice1").css("border-color","rgba(255, 99, 76, 1)")
             $("#need").css({
                 "color":"#FFF",
                 "background":"rgba(255, 99, 76, 1)",
                 "cursor": "default"
             });
        }
     });
        
      $("#unneed").on('tap click',function(){
         $("#dian_piao").hide();
         $("#select_piao").hide();
         $("#zhi_piao").hide();
         $("#need").css({
             "color":"#000",
             "background":"#FFF",
             "cursor": "pointer"
         });
        $("#invoice1").css("border-color","#ddd")
         $("#unneed").css({
             "color":"#FFF",
             "background":"#ddd",
             "cursor": "default"
         });
      });
     
     
     $('#submit').on('tap click', function(e) {
 if( $.trim($("input[name='name']").val()) == '' ){//判断宾客姓名是否为空
 jAlert("姓名不能为空！");
 return false;
 }
 if(!reg.test($.trim($("input[name='mobile']").val()))){//判断宾客姓名是否为空
 jAlert("联系电话格式不正确！");
 return false;
 }
 
     if(count ==1 ){
            count++;
            var param = $('#submitForm').serialize();
            var url = "purchase.php?" + param + "&moduleid=16";
           console.log(url);
  
            $.getJSON(url,function(result){
 //alert(result.msg);
                if(result.stat == 1){
                    /*var ua = navigator.userAgent.toLowerCase();
                                        if (/iphone|ipad|ipod/.test(ua)) {
                                            getPush();  
                                        }else{
                                            window.AndroidWebView.getPush();
                    }*/
                    jAlert2("提交成功，即将转到个人申请页面","myorder.php");
                }else {
                   
                    jAlert(result.msg);
                    console.log(result);
                    console.log(result.stat);
                }
            });
        }
 
 });
     $('.mingxi').click(function(){
    scrolltop=$(document).scrollTop();
    if (scrolltop<=0) scrolltop=$('html,body').scrollTop();
    nowtop= ($(window).height() - $('#mingxi_info').outerHeight())/2+scrolltop;
    /*nowleft=($(window).width() - $('#mingxi_info').width())/2+$(document).scrollLeft()-30; */
    $('#mingxi_info').css({top: nowtop});
     $('#mingxi_info,.mask').show();
     })     
    $('.btn_guanbi').click(function(){
    $('.mingxi_info,.mask').hide();
    })
    $('.xiugai').on("click",function(){
$(".select_date").show();
})
$('.back_dlrq').on("click",function(){
$(".select_date").hide();
})
$('#btnSelectDate').on("click",function(){
        var checkUrl=changeURLArg(window.location.href,'roomNum',$('input[name=roomNum]').val());
var checkInDateUrl = changeURLArg(checkUrl,'beginDate',$('#dtp_input2').val());//替换起始时间
   var checkOutDateUrl =changeURLArg(checkInDateUrl,'endDate',$('#dtp_input3').val());//替换结束时间 
   window.location.href= checkOutDateUrl;
})
    $("#minus").click(function(event) {
        var num=parseInt($(".room_number").text())-1;
        
        if(num<1){
             num=1;
             return false;
        }
        
        $(".room_number").text(num);
        $(".number").text(num);
        $('input[name=roomNum]').val(num);
        verifyOrder();
     });
     $("#plus").click(function(event) {  
        var num=parseInt($(".room_number").text())+1;
       
        var maxNum = $('input[name=maxNum]').val();
        //if(num > maxNum){
        //num = maxNum;
        //return false;
       // }
       /*
        if(num > 3){
        num = 3;
        return false;
        }*/
        $(".room_number").text(num);
        $(".number").text(num);
        $('input[name=roomNum]').val(num);
        verifyOrder();
     });
     
     $("#xuyao").on('tap click',function(){
        if ($("#cash").is(":checked")) {
            jAlert("到店付款不能购买电子券")
        }else{
         $("#spanquan").show();
         $("#kuang").css("border-color","rgba(255, 99, 76, 1)")
         $("#buxuyao").css({
         "color":"#000",
             "background":"#FFF",
             "cursor": "pointer"
         });
         $("#xuyao").css({
             "color":"#FFF",
             "background":"rgba(255, 99, 76, 1)",
             "cursor": "default"
         });
         }
      });
       /*var $res=$('<div class="row">'
          +'<div class="col-xs-4" style="width:100%">'
            +'<span id="spanquan">'
            +'<?php if(is_array($coupcats)) { foreach($coupcats as $ct => $ctv) { ?>'
              +'<dl>'
                +'<dt><?php echo $ctv;?></dt>'
                +'<dd><?php if(is_array($coup)) { foreach($coup as $k => $v) { ?> <?php if($v['typeid']==$ct) { ?>'
                  +'<input type="checkbox" name="userCoupon" data-id="<?php echo $v['itemid'];?>"'
                   +'data-price="<?php echo $v['price'];?>" data-stock="<?php echo $v['amount'];?>"' 
                   +'data-title="<?php echo $v['title'];?>" id="chk_<?php echo $v['itemid'];?>"><?php echo $v['title'];?>'
                  +'<span style="margin: 0 10px;float:right;">'
                    +'<img class="reduce" src="static/images/minus.png" height="25" '
                    +'data-id="<?php echo $v['itemid'];?>" id="reduce_<?php echo $v['itemid'];?>">'
                    +'<input type="hidden" name="couponcount[]" id="count_<?php echo $v['itemid'];?>" value="0" />'
                    +'<span id="spancount_<?php echo $v['itemid'];?>" style="padding:0 10px;">0</span>'
                    +'<img class="add" src="static/images/plus.png" height="25"'
                     +'data-id="<?php echo $v['itemid'];?>" id="add_<?php echo $v['itemid'];?>">'
                     +'<?php echo $v['price'];?>元</span><?php } ?>
 <?php } } ?></dd></dl><?php } } ?></span>'
          +'</div>'
        +'</div>'
        );
      var $div=$("<div style='position:absolute;z-index:999;background-color:#FFF;padding:15px;padding-right:0;'></div>");
      var $mask=$("<div style='background-color:#ccc;opacity:0.9;filter: alpha(opacity=90); position:absolute; left:0;top:0;z-index:99;'></div>");
      var $wid=$(window).width();
      var $hei=$(window).height();
      var lef=($wid-270)/2+"px";
      $("#xuyao").on('tap click',function(){
          $("#buxuyao").css({
            "color":"#000",
              "background":"#FFF",
              "cursor": "pointer"
          });
          $("#xuyao").css({
              "color":"#FFF",
              "background":"rgba(255, 99, 76, 1)",
              "cursor": "default"
          });
          $("#kuang").css("border-color","rgba(255, 99, 76, 1)")
          var $scro=$(document).scrollTop();
          var to=$scro+100+"px";
          $mask.css({
            "width":$wid,
            "height":$(document).height()
          });
          $div.css({
            "left":lef,
            "top":to
          });
          $('body').append($mask);
            $($div).append($res);
            $('body').append($div);
          $mask.on("click",function(){
            $(this).remove();
            $div.remove();
            $("#kuang").css("border-color","#ddd");
            $("#xuyao").css({
                "color":"#000",
                "background":"#FFF",
                "cursor": "pointer"
            });
            $("#buxuyao").css({
                "color":"#FFF",
                "background":"#ddd",
                "cursor": "default"
            });
          });*/
          $("#spanquan").on("click","input",function(){
             if ($("input[data-id]").is(":checked")) {
                 $("#cash").prop('checked',false);
                 $("#bao").prop('checked',true);
                 $("#cash").attr('disabled', 'disabled');
                 calcoupons();
             }else{
                 $("#cash").removeAttr('disabled');
                 var ba=$(this).data("id");
                 $("#spancount_"+ba).html("1");
                 $("#count_"+ba).val("1");
                 calcoupons();
             }
          });
            $(".reduce").click(function(event){
             cid=$(this).data("id");
             if ($("#chk_"+cid).is(":checked")){
                 if ($("#count_"+cid).val()==0){
                     return false;
                 }else{
                     bb=parseInt($("#count_"+cid).val())-1;
                     $("#count_"+cid).val(bb);
                     $("#spancount_"+cid).html(bb);
                 }
             }
             calcoupons();
            });
            $(".add").click(function(event){
             cid=$(this).data("id");
             if ($("#chk_"+cid).is(":checked")){
                if (parseInt($("#chk_"+cid).data("maxamount"))>parseInt($("#chk_"+cid).data("stock"))){
                    maxamount=parseInt($("#chk_"+cid).data("stock"));
                }else{
                    maxamount=parseInt($("#chk_"+cid).data("maxamount"));
                }
                 if ($("#count_"+cid).val()>=maxamount){
                     return false;
                 }else{
                     bb=parseInt($("#count_"+cid).val())+1;
                     $("#count_"+cid).val(bb);
                     $("#spancount_"+cid).html(bb);
                 }
             }
             calcoupons();
            });
          
       });
      $("#buxuyao").on('tap click',function(){
         $("#spanquan").hide();
         $("#kuang").css("border-color","#ddd")
         $("#xuyao").css({
             "color":"#000",
             "background":"#FFF",
             "cursor": "pointer"
         });
         $("#buxuyao").css({
             "color":"#FFF",
             "background":"#ddd",
             "cursor": "default"
         });
         /*$("input[name=userCoupon]").each(function(){
          $(this).removeAttr("checked");
          $("#count_"+$(this).data("id")).val(1);
          $("#count_"+$(this).data("id")).attr("disabled","disabled");
  });
          calcoupons();*/
      });
    
     
     /*$("input[name='userCoupon']").click(function(event){
        console.log('0');
     $("input[name='userCoupon']").each(function(){
                console.log(1);
    if ($(this).is(":checked")) {
    $("#count_"+$(this).data("id")).removeAttr("disabled");
                    console.log(11);
    }else{
    $("#count_"+$(this).data("id")).attr("disabled","disabled");
                    var cid=$(this).data("id");
                    $("#spancount_"+cid).html("0");
                    console.log(22);
    }
    });
      calcoupons();
     });*/
    
     
      $(".quannote").on('tap click',function(){
         cid=$(this).data("id");
         enddate=$("#chk_"+cid).data("enddate");
         addnote=$("#snote").val()+'<div>4.滴滴快车券购买后，不可退款</div>';
         $('#note_info dl dd span').html(addnote);
        scrolltop=$(document).scrollTop();
        if (scrolltop<=0) scrolltop=$('html,body').scrollTop();
        nowtop= ($(window).height() - $('#note_info').outerHeight())/2+scrolltop;
        /*nowleft=($(window).width() - $('#note_info').width())/2+$(document).scrollLeft()-30; */
        $('#note_info').css({top: nowtop});
        $('#note_info,.mask').show();
      });
     
     $("input[name='couponcount[]']").bind("input propertychange",function(){
     calcoupons();
 /*});*/
});
//替换URL链接中的某个参数 
function changeURLArg(url,arg,arg_val){ 
    var pattern=arg+'=([^&]*)'; 
    var replaceText=arg+'='+arg_val; 
    if(url.match(pattern)){ 
        var tmp='/('+ arg+'=)([^&]*)/gi'; 
        tmp=url.replace(eval(tmp),replaceText); 
        return tmp; 
    }else{ 
        if(url.match('[\?]')){ 
            return url+'&'+replaceText; 
        }else{ 
            return url+'?'+replaceText; 
        } 
    } 
    return url+'\n'+arg+'\n'+arg_val; 
} 
</script>
<script type="text/javascript">
    
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        pushHistory(); 
        window.addEventListener("popstate", function(e) {
        var test=localStorage.hom;
        location.href=test;
        }, false); 
        function pushHistory() { 
            var state = { title: "title", url: "#" }; 
            window.history.pushState(state, "title", "#"); 
        } 
        localStorage.pur = location.href;
    }
</script>
<script type="text/javascript">
    $("#zhi").click(function(){
        $("#zhi_piao").show();
        $("input[name='invoice_email']").hide();
    })
    $("#dian").click(function(){
        $("#dian_piao,input[name='invoice_email']").show();
        $("#zhi_piao").hide();
    })
    $("select[name='arrivetime']").click(function(){
        if($("#cash").is(":checked")){
            $(this).find($("option[value='18:00']")).attr("selected",true).siblings().remove();
            jAlert("到店付款最晚到店时间为18:00，如果不能及时到店请与客服联系");
            $(this).attr("disabled","disabled"); 
        }
    })
    $("#bao").click(function(){
        $("select[name='arrivetime']").removeAttr("disabled").empty().append('<option value="16:00">16:00</option><option value="17:00">17:00</option><option value="18:00">18:00</option><option value="19:00">19:00</option><option value="20:00">20:00</option><option value="21:00">21:00</option><option value="22:00">22:00</option><option value="23:00">23:00</option>');
    })
</script>
<div style="height: 36px;"></div>
 <?php include template('footer', 'mobile');?>
</body>
</html>