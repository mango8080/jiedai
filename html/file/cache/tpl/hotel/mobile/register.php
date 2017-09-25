<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>注册</title>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<link rel="stylesheet" href="static/style/weui.min.css">
<link rel="stylesheet" href="static/style/index.min.css">
    <script type="text/javascript" src="static/script/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
    <script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
    <!-- <script type="text/javascript" src="static/script/jquery.mobile.custom.min.js"></script> -->
<!-- <script type="text/javascript" src="static/script/TouchSlide.1.1.js"></script> -->
    <!-- <script type="text/javascript" src="static/script/common.js"></script> -->
    <!-- <script type="text/javascript" src="static/script/zepto.plug-in.js"></script> -->
    <!-- <script type="text/javascript" src="static/script/fix.js"></script> -->
    <style>
        .rigister_address select{height:30px;text-align: center;}
    </style>
    <link rel="stylesheet" href="static/dialog/ui-dialog.css" />
    <script type='text/javascript' src='static/dialog/dialog-min.js'></script>
    <script type="text/javascript">
    //jquery和tap冲突的解决方式
   /* $.noConflict();*/
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
</head>
<body>
<div class="head">
<a onclick="history.go(-1)"><img src="static/style/back.png" width="22" height="14"  alt=""/></a>
  <div>注册</div>
    <a href="../mobile/"><img src="static/style/home.png" width="22" height="21"  alt=""/></a>
</div>
<div class="weui-cells weui-cells_form">
<div class="weui-cell rigister_name">
        注册完成后才能进行借款申请
    </div>
    <div class="weui-cell rigister_name">
        <input type="text" name="jinghao" class="weui-input" id="jinghao" value="<?php echo $u['jinghao'];?>" placeholder="请输入用户名(用户名必须为英文或数字)">
    </div>
    <div class="weui-cell rigister_gender" >
        <input type="radio" name="gender" value="1" checked="checked"/> 先生&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="gender" value="2" /> 女士
    </div>
 
    <div class="weui-cell weui-cell_vcode rigister_tel">
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel" placeholder="请输入手机号" id="phone">
        </div>
        <div class="weui-cell__ft">
            <a href="javascript:;" class="weui-vcode-btn" id="btn" >请输入正确号码</a>
        </div>
    </div>
  
    <div class="weui-cell rigister_p">
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="请输入密码" id="passwd">
        </div>
    </div>
    <div class="weui-cell rigister_p">
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="确认密码" id="passwdqr">
        </div>
    </div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">注册</a>
    </div>
</div>
<script>
function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
var url="";
var count = 120;
var timer=0;
var shangxian=GetQueryString("shangxian");
$(function(){

$('#showTooltips').bind('touchstart click', function(){
var obj = $("#jinghao").val(); 
if(/.*[\u4e00-\u9fa5]+.*$/.test(obj)) 
{ 
alert("用户名不能含有汉字！"); 
return false; 
} 
        if($("#truename").val()==""){
            jAlert("请输入姓名");
            return false;
        }
        if($("#jinghao").val()==""){
            jAlert("请输入警号");
            return false;
        }
        if($("#cardcode").val()==""){
            jAlert("请输入身份证号");
            return false;
        }
if ($('#phone').val()==""){
    jAlert("请先输入手机号");
    return false;
    }

if ($('#passwd').val()==""){
    jAlert("请输入登录密码");
    return false;
    }
        if ($('#passwdqr').val()==""){
            jAlert("请输入确认密码");
            return false;
        }
        if($('#passwd').val()!=$('#passwdqr').val()){
            jAlert("两次输入密码不一致");
            return false;
        }

url="register.php?action=post&mobile="+$('#phone').val()+"&password="+$('#passwd').val()+"&truename="+$('#truename').val()+"&gender="+$("[name='gender']").val()+"&jinghao="+$('#jinghao').val()+"&danwei="+$('#danwei').val()+"&cardcode="+$('#cardcode').val()+"&shangxian="+shangxian;
console.log(url);
$.getJSON(url,function(result){
if(result.stat == 1){
resultStr = "注册成功，请登录您的帐号";
jAlert2(resultStr,'login.php');
/*window.location.href='login.php';*/
} else {
            jAlert(result.msg);
        }
});

})
});
</script>
</body>
</html>
