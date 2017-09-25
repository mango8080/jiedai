<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="mobileephone=no" name="format-detection">
<meta content="address=no" name="format-detection">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<title>借款申请</title>
<link type="text/css" rel="stylesheet" href="static/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="static/css/bootstrap-datetimepicker.min.css">
<link type="text/css" rel="stylesheet" href="static/css/base.css">
<link type="text/css" rel="stylesheet" href="static/css/default.css">
<link type="text/css" rel="stylesheet" href="static/css/iocn.css">
<link type="text/css" rel="stylesheet" href="static/css/index.css">
<link type="text/css" rel="stylesheet" href="static/dialog/ui-dialog.css" />
<link type="text/css" rel="stylesheet" href="static/style/weui.min.css" />
<style type="text/css">
.arrowdown::after{ border-right: 2px solid #b5975a; border-top: 2px solid #b5975a; content: ""; display: block; width:8px; height:8px; margin: -5px 0 0 -20px; position: absolute; left: 100%; top: 45%; transform: rotate(135deg); }
.room_show{width: 90%;background: #fff;position:fixed;z-index:9999;top: 18%;left: 5%; padding:0 5%;}
.room_show h3{font-size:20px; color:#1b1b1b; font-weight:normal;}
.room_show img{display:inline-block; width:100%;}
.room_show p{font-size:14px; color: #666;}
/* .room_list .list{padding: 0 15px;} */
.room_list .list .title{line-height:30px; font-size: 18px; color: #333;}
.room_list .list .title span{font-size: 12px; color: #999;}
/* .room_list .list .box{margin: 10px 0 20px;} */
.room_list .list .box .row{line-height:64px; border-bottom: 1px solid #e3e3e3;background-color:#F6F6F6}
.room_list .list .box .row>div{padding: 0;}
.room_list .list .box .jg{font-size: 14px; color: #ff3b30;}
.room_list .list .box .jg em{font-size:20px;}
.room_list .list .box .jg1{color:#a2a2a2; text-decoration:line-through;}
.room_list .list .box .sf{font-size: 14px; color: #fea831;}
.room_list .list .box .kyq{display: inline-block; /* width: 45px; */ height: 20px; line-height:20px; font-size:12px; font-style:italic; text-align:center; color:#ff5f56;}
.room_list .list .box .yh{font-size: 14px; color: #a0a0a0;}
.room_list .list .box .btn_yd{display: inline-block; float:right; width: 56px; height: 30px; margin-top:15px; line-height: 30px; font-size:14px; text-align: center; border-radius:15px; color: #fff; background-color: rgba(255, 99, 76, 1);margin-right:15px;}
.room_list .list .box .btn_mf{display: inline-block; float:right; width: 56px; height: 30px; margin-top:15px; line-height: 30px; font-size:14px; text-align: center; border-radius:15px; color: #fff; margin-right:15px;background-color: #c2c0c1;}
.room_list .list .box .container-fluid{display:none}
.room_list .list .box .title{height:74px;border-bottom:1px solid #D4D4D4}
.container-fluid .row .col-xs-9{text-indent:15px;}
.namePart,.pricePart{float:left;height:100%;overflow:hidden}
.namePart{width:68%;text-indent:10px;}
.pricePart{width:32%;line-height:74px;}
.pricePart p{font-size:10px;color:#999;float:right;margin-right:15px;}
.pricePart p em{color:#000000}
.box .title .pricePart p span{color:#FF3B30;font-size:20px;}
.box .title .pricePart p img{margin-left:10px;}
.namePart p{font-size:16px;color:#333;line-height:1.5;margin-top:15px}
.namePart p:nth-child(2){font-size:12px;color:#999999;margin-top:5px;}
.pricePart p.jiage2{color:#000000;display:none;font-size:10px;}
.box .title .pricePart p.jiage2 span{color: #ff3b30;font-size: 10px;text-decoration: line-through;}
.box .title .pricePart p.jiage2 span em{color:#ff3b30;text-decoration: line-through;font-size: 10px;}
.room_list .list .box .sf{
position: absolute;
    right: 14px;
    bottom: -19px;
    width: 56px;
    font-size: 10px;
    line-height: 16px;
    text-align: center;
    color: #ff7901;}
/* 详情卡片 */
.infoCard{position:fixed;width:90%;background-color:#fff;height:340px;border-radius:6px;z-index:999;left:5%;top:10%;text-align:center;overflow:hidden;display:none;overflow-y: auto;}
.infoCard h4{font-size:15px;color:#333333;line-height:normal;margin-top:20px;}
.infoCard .btn_guanbi{padding:8px;}
.infoCard .hotelPic{width:90%;display:block;height:200px;margin:15px auto;}
.infoCard .row{font-size:13px;color:#333333;text-align:center;height: 25px;width: 90%;margin: 0 auto;}
.infoCard .row .small{font-size:12px;color:#999;}
.infoCard .toBook{height:44px;line-height:44px;width:90%;margin:0 auto;color:#fff;background-color:#FF634C;font-size:15px;border-radius:22px;display:block;margin-top:15px;}
#comment{height:500px;}
</style>
</head>
<body>
<header class="clearfix" style="position:fixed;top:0;width:100%;background:#FFF;z-index:99">
<a onclick="history.go(-1)" class="back"><img src="static/images/back.png" height="14" /></a>
<h1 class="f-16 b" style="font-size:16px;">选择借款</h1>

</header>
<div class="room_list">
<div class="top">
<div class="touchslider">
    <div class="touchslider-viewport">
    
    
    </div>
    <div class="touchslider-nav">
    <div class="sonpic">
    <a class="touchslider-nav-item touchslider-nav-item-current"></a>
    
        </div>
    </div>
</div>
        <p class="d_title"><?php echo $company;?></p>
       
    </div>

<div class="list">
<?php if(is_array($malls)) { foreach($malls as $m => $fx) { ?>
<div class="box clearfix">
<div class="title">
<div class="namePart" style="padding-left: 8px;">

<div style="float: left;">
<p><?php echo $fx['title'];?></p>

</div>

    </div>
<div class="pricePart">
<a href="purchase.php?moduleid=16&itemid=<?php echo $fx['itemid'];?>&beginDate=<?php echo $beginDate;?>&endDate=<?php echo $endDate;?>&roomNum=<?php echo ceil($fx['hiprice']);?>" class="btn_yd">
          <p class="jiage1"><em>申请</em></p> 
         <p class="jiage2"> <em>申请</em></p>
 </a>
    </div>
</div>

<div class="container-fluid ">

</div>

</div>
<?php } } ?>
</div>
</div>
<!-- 详情卡片 -->
<div class="mask" style="display:none;opacity: 0.99;">
<header class="clearfix">
<a href="javascript:goClose();" class="back"><img src="static/images/back.png" height="14" /></a>
<h1 class="f-16 b" style="font-size:16px;">地图位置</h1>
</header>
<div id="container" style="width:100%;height:100%;border:1px solid #ccc;"></div>
</div>
<script type="text/javascript" src="static/script/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="static/script/bootstrap.min.js"></script>
<script type="text/javascript" src="static/script/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="static/script/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript" src="static/script/moment.min.js"></script>
<script type="text/javascript" src="static/script/moment-zh-cn.js"></script>
<script type="text/javascript" src="static/script/date.js" ></script>
<!-- <script type="text/javascript" src="static/script/jquery.touchslider.js"></script> -->
<script type="text/javascript" src="static/script/select_controls_jinjiang.js"></script>
<script type='text/javascript' src='static/dialog/dialog-min.js'></script>
<script type="text/javascript">
/*$(document).ready(function(){
   var screenWidth = $("body").width();
   var responseH = 480 * screenWidth / 640 *0.8;
   $(".touchslider-viewport").css("height",responseH);
});
$(function(){

$(".touchslider-nav").css("margin-left",-$(".touchslider-nav a").length*$(".touchslider-nav a").width())
$(".touchslider-item img").css('width',$(document.body).width());
    $(".touchslider").touchSlider({mouseTouch: true,autoplay: true});
    
});*/
function init_map() {
  //设置地图中心点
  var myLatlng = new qq.maps.LatLng($('#curLat').val(),$('#curLong').val());
  //定义工厂模式函数
  var myOptions = {
    zoom: 20,
    center: myLatlng,
    content:'文本标注'
  }
  //获取dom元素添加地图信息
  var map = new qq.maps.Map(document.getElementById("container"), myOptions);
  var marker = new qq.maps.Marker({
    position: myLatlng,
    map: map
});
  var label = new qq.maps.Label({
        position: myLatlng,
        map: map,
        content:$("#companyname").val()
    });
  $(".mask").show();
}
//如果是微信浏览器，点击酒店地址显示地图
    var ua = navigator.userAgent.toLowerCase();
    function navigate(){
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
      var script = document.createElement("script");
      script.type = "text/javascript";
      script.src = "http://map.qq.com/api/js?v=2.exp&key=V6IBZ-J5NRF-5NIJE-JX227-FCSDE-IYB26&libraries=convertor&callback=init_map";
      document.body.appendChild(script);
}else{
navigateWithMap();
}
    }
    
/* 点击显示详细内容 */
$(".box").on("click",".pricePart",function(){
var that = this;
var content = $(this).parent().siblings(".container-fluid ");
if(content.is(":hidden")){
$(this).find(".jiage2").show();
$(this).find(".jiage1").hide();
content.slideDown();
$(that).find("img").css("transform","rotate(180deg)");
}else{
$(this).find(".jiage2").hide();
$(this).find(".jiage1").show();
content.slideUp();
$(that).find("img").css("transform","rotate(0deg)");
}
})
$(".list .container-fluid").eq(0).show();
/*$(".list .title").eq(0).find("img").css("transform","rotate(180deg)")*/
$(".list .title").eq(0).find(".jiage2").show();
$(".list .title").eq(0).find(".jiage1").hide();
/* 点击显示房间详细内容 */
$("#openComment").on("click",function(){
if ($("#commentcount").val()>0){
$("#comment").show();
$(".mask").show();
}

});
$(".btn_guanbi").on("click",function(){
$(".infoCard").hide();
$(".mask").hide();
});
function goBack(){ 
var referrer = document.referrer;
var url = window.location.href;
//alert(url);
if(referrer == null || referrer ==''){
//从微信访问进来，没有上一个页面时，默认返回到首页
window.location.href="static//index.htm";
}else{
/* window.history.back(); */

window.history.back();

}
}
function goClose(){
$(".infoCard").hide();
$(".mask").hide();
}
</script>
<script type="text/javascript">
    
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
pushHistory(); 
window.addEventListener("popstate", function(e) {
var test=localStorage.com;
location.href=test;
}, false); 
function pushHistory() { 
    var state = { title: "title", url: "#" }; 
    window.history.pushState(state, "title", "#"); 
} 
localStorage.hom = location.href;
}
</script>
<script type="text/javascript">
var marker = null;
var info = null;
var map = null;
var geocoder =  null;
var url = window.location.href;
var cur_Lat;
var cur_Long;
function translatePoint(position){ 
cur_Lat = position.coords.latitude; //纬度
cur_Long = position.coords.longitude; //经度
}
function init() {
navigator.geolocation.getCurrentPosition(translatePoint); 
}
function loadScript() {
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "http://map.qq.com/api/js?v=2.exp&key=V6IBZ-J5NRF-5NIJE-JX227-FCSDE-IYB26&libraries=convertor&callback=init";
document.body.appendChild(script);
}
loadScript();
function navigateWithMap(){
    var ua = navigator.userAgent.toLowerCase();
    if (/iphone|ipad|ipod/.test(ua)) {
        window.WebViewJavascriptBridge.getLatLngElatitude(<?php echo $COM['longitude'];?>,<?php echo $COM['latitude'];?>); 
    }else{
        window.AndroidWebView.getLatLng(cur_Long,cur_Lat,"开始位置",<?php echo $COM['longitude'];?>,<?php echo $COM['latitude'];?>,"结束位置");
        
    }
    return ;
}
</script>
<div style="height: 60px;"></div>
 <?php include template('footer', 'mobile');?>
</body>
</html>
