<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="telephone=no" name="format-detection">
<meta content="address=no" name="format-detection">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<title>修改密码</title>
<link type="text/css" rel="stylesheet"  href="static/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"  href="static/css/base.css">
<link type="text/css" rel="stylesheet"  href="static/css/default.css">
<link type="text/css" rel="stylesheet"  href="static/css/iocn.css">
<script type="text/javascript" src="static/script/zepto.min.js"></script>
<script type="text/javascript">
function beforeSubmitPoint(usingPsw, newPsw, confirmPsw) {
var resultStr = '';
if(usingPsw=='' || newPsw=='' || confirmPsw==''){
resultStr = '信息填写不全！';
}else if(newPsw != confirmPsw) {
resultStr = '两次密码不一致!';
}else if(newPsw.length<6){
resultStr="密码不符合安全规范，请确保密码不少于6位字符.";
}else{
var param = $('#submitFrom').serialize();
var url = "my.php?" + param + "&action=cpassacc";
$.getJSON(url,function(result){
if(result.stat == 1){
resultStr = "密码修改成功，即将刷新您的个人信息页面";
jAlert2(resultStr,'login.php');
/*window.location.href='login.php';*/
}else {
jAlert(result.msg);
}
});
}
if(resultStr != '') {
jAlert(resultStr);
}
}
$(function(){
$('#submit').bind('touchstart click', function(){
var usingPsw = $('#using_psw').val();
var newPsw = $('#new_psw').val();
var confirmPsw = $('#confirm_psw').val();
beforeSubmitPoint($.trim(usingPsw), $.trim(newPsw), $.trim(confirmPsw));
})
})
</script>
</head>
<body>
<!-- 引用JS文件：弹出 -->
<!-- Dependencies -->
<link rel="stylesheet" href="static/dialog/ui-dialog.css" />
<script src="static/script/jquery-1.11.2.min.js"></script>
<script type='text/javascript' src='static/dialog/dialog-min.js'></script>
<script type="text/javascript">
//jquery和tap冲突的解决方式
$.noConflict();
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
<h1 class="f-16 b" style="font-size:16px;">修改密码</h1>
<a href="../mobile" class="home"><img src="static/images/home.png" height="21px"/></a>
</header>
<div class="change_password p_t_50">
<form id="submitFrom" method="post"> 
    <div class="box_password">
        <img src="static/images/password.png" width="28" alt="">
        <input type="password" name="oldPassword" class="form-control password" id="using_psw" placeholder="输入旧密码">
    </div>
    <div class="box_captcha">
        <img src="static/images/password.png" width="28" alt="">
        <input type="password" name="newPassword" class="form-control captcha" id="new_psw" placeholder="输入新密码">
    </div>
    <div class="box_captcha">
        <img src="static/images/password.png" width="28" alt="">
        <input type="password" name="newPassword2" class="form-control captcha" id="confirm_psw" placeholder="确认新密码">
    </div>
    </form>
    <a class="btn btn_default" id="submit" style="width: 90%;">提 交</a>    
</div>
</body>
</html>