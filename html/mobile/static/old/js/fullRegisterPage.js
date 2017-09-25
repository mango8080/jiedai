/**
 * Created by sam on 14-3-26.
 */

var returnUrl = '';
function verfyPassword(password) {
	var gz = "^[0-9a-zA-Z]{6,12}$";
	var vdt = new RegExp(gz);
	if (!vdt.test(password)) {
		return false;
	}
	return true;
}
function validate(form,hzgs){
   if(form.mobile.value == ''){
       alertMessage('手机号');
       return false;
   }
//    var isMobile=/^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/;
    if(form.mobile.value.length!=11){
        jAlert('手机号格式有误，请重新输入！');
        return false;
    }
    var captcha = $("#captcha:visible").get(0);
	var cap = $("#captcha").val();
	if(captcha !== undefined){
		if(cap == ""){
			jAlert("请输入验证码");
			return;
		}
	}
    if(form.signCode.value == ''){
        jAlert('请输入手机动态码');
        return false;
    }
   if(form.password.value == ''){
       alertMessage('密码');
       return false;
   }
   if(!verfyPassword(form.password.value)){
	   jAlert('密码由6-12位字符，由字母或数字组成');
       return false;
   }
   if(form.rePass.value != form.password.value){
       jAlert('两次密码输入不一致');
       return false;
   }
   if(!form.fullName.value){
       alertMessage('用户名');
       return false;
   }
   if (hzgs != "") {
	   var cardNo = form.airLineCardNo.value;
	   if (!cardNo) {
		   alertMessage('合作伙伴卡号');
	       return false;
	   }
	   if(cardNo.length!=12 || isNaN(cardNo)){
		   jAlert('合作伙伴卡号输入有误');
	       return false;
	   }
   }
   //if(!form.email.value){
   //    alertMessage('邮箱');
   //    return false;
   //}
   if(!form.certificateType.value){
       alertMessage('证件类型');
       return false;
   }

   if(!form.certificateNo.value){
       alertMessage('证件号');
       return false;
   }
  
    return true;
}

function f_toShowRegInfo() {
    $(".dialog-bg").show();
    $("#info_dialog").show();
}

function alertMessage(fieldName) {
    jAlert(fieldName+'不能为空');
}
function sendRegCode(){
    var mobile = $("#mobile").val();
    if(mobile == ""){
        jAlert("请输入手机号");return;
    }
    if(mobile.length != 11 || isNaN(mobile)){
        jAlert("手机号格式有误，请重新输入");return;
    }
    var pswd = $("#pswd").val();
    if(pswd == ""){
        jAlert("密码不能为空");return;
    }
    var repswd = $("#repswd").val();
    if(repswd == ""){
        jAlert("确认密码不能为空");return;
    }
    if(pswd != repswd){
        jAlert("两次输入的密码不一致");return;
    }
    var captcha = $("#captcha:visible").get(0);
    var cap = $("#captcha").val();
    if(captcha !== undefined){
        if(cap == ""){
            jAlert("请输入验证码");
            return;
        }
    }
    $.ajax({
        url:global+"/member/verifyPhone",
        dataType:"json",
        data:{"phone":$("#mobile").val()},
        type:"post",
        success:function(data){
            var msg = data.msg;
            if(msg == "true"){
                jAlert("手机号已被注册");
                wechatChangeValidate();
            } else if (msg == "false") {
                f_getRegisteredCode();// 发送验证码
            } else {
                jAlert("服务器繁忙，请稍后再试");
            }
        }
    });
}
//执行登入操作
function f_doLogin() {
	 ga('send', 'event','用户登入页面', '用户登入', '登录按钮');
	var loginName = $("#loginName").val();
	var pswd = $("#pswd").val();
	var returnUrl = $("#returnUrl").val();
	if (loginName != "" && pswd != "") {
		$.ajax({
			url : global + "/member/doLoginMember",
			type : "post",
			cache : false,
			data : {
				"loginName" : loginName,
				"pswd" : pswd,
				"returnUrl" : returnUrl
			},
			dataType : "json",
			success : function(data) {
				var rememberMe = localStorage.rememberMe;
				if (rememberMe == "true") {
					localStorage.loginName = loginName;
				} else {
					localStorage.loginName = "";
				}
				var autoLogin = localStorage.autoLogin;
				if (data.success) {
					if(data.token){
						window.location.replace(data.xzUrl);
					}else{
						location.href =  global + data.returnUrl;
					}
				} else {
					jAlert(data.message);
				}
			}
		});
	} else {
		jAlert("用户名或密码不能为空。");
	}
}
function f_doReg() {
	ga('send', 'event','用户注册页面', '快速用户注册成功跳转登录', '同意并注册按钮');
	var mobile = $("#mobile").val();
	var pswd = $("#pswd").val();
	var repswd = $("#repswd").val();
	var signCode = $("#signCode").val();
	var hotelChannel = $("#hotelChannel").val();// 酒店注册渠道
	if (mobile == "") {
		jAlert("请输入手机号码");return;
	}
	if (pswd == "") {
		jAlert("请输入密码");return;
	}
	if(!verfyPassword(pswd)){
		jAlert('密码由6-12位字符，由字母或数字组成');return;
	}
	if (pswd != repswd) {
		jAlert("两次输入的密码不一致");return;
	}
	if(signCode == ""){
		jAlert("请输入手机动态码");return;
	}
    openLoading();
	$.ajax({
		url : global + "/member/doRegister",
		type : "post",
		cache : false,
		data : $("#regForm").serialize(),
		dataType : "json",
		success : function(data) {
            closeLoading();
            if(data.success){
            	if (data.message == "") {
            	    window.location.href=global+"/member/toFullRegSuccess?bindStatus=false";
				} else {
					jAlert(data.message,'信息提示', function(r) {
					    window.location.href=global+"/member/toFullRegSuccess?bindStatus=false";
					});
				}
            } else {
        		jAlert(data.message);
            }
		}
	});
}

//注册,获取验证码
function f_getRegisteredCode(){
 var telephone = $("#mobile").val();
 if(telephone == ""){
     jAlert("请输入手机号");return;
 }
 if(telephone.length != 11 || isNaN(telephone)){
     jAlert("手机号格式有误，请重新输入");return;
 }
	var captcha = $("#captcha:visible").get(0);
	var cap = $("#captcha").val();
	if(captcha !== undefined){
		if(cap == ""){
			jAlert("请输入验证码");
			return;
		}
	}
 $.ajax({
     url : global + "/member/getRegisteredCodeByPhone",
     type : "post",
     cache : false,
     data : {
         "telephone" : telephone,
			"captcha":cap
     },
     dataType : "json",
     success : function(data) {
         if (data.success) {
             secondCounter(60);return;
         } else {
             jAlert(data.message);
				wechatChangeValidate();
				return;

         }
     }
 });
}
function secondCounter(defSec) {
    $("#timeCount").text(defSec-- + "秒后重新发送");
    $("#signCodeBtn").hide();
    $("#timeCount").show();
    if (defSec < 0) {
        $("#signCodeBtn").show();
        $("#timeCount").hide();
    }else {
        window.setTimeout(function(){secondCounter(defSec)}, 1000);
    }
}


/***
 * 验证码是否有效
 * @param form
 */
function checkCode(hzgs){
    var form = document.forms[0];
    if (!validate(form,hzgs)) {
        return;
    }
    $.ajax({
        url : global + "/member/checkPhoneByCode",
        type : "post",
        cache : false,
        data : {
            "telephone" : form.mobile.value,
            "signCode":form.signCode.value
        },
        dataType : "json",
        success : function(data) {
                if (data.success==true) {
                    submitReg(hzgs);
                }else{
                    jAlert(data.message);
                    return;
                }
        }
    });
}
function submitReg(hzgs) {
	    var form = document.forms[0];
	    if (!validate(form,hzgs)) {
	        return;
	    }

        if(hzgs == ""){
		    var data = {
				"openId" : form.openId.value,
				"serviceId" : form.serviceId.value,
				"fullName" : form.fullName.value,
                "validateCode":form.signCode.value,
				"password" : form.password.value,
				"mobile" : form.mobile.value,
				"email" : form.email.value,
				"certificateType" : form.certificateType.value,
				"certificateNo" : form.certificateNo.value,
				"operation" : form.operation.value,
				"hotelChannel" : form.hotelChannel.value,
				"isWeiXin" : form.isWeiXin.value,
                "returnUrl" :returnUrl,
                "cardId" :form.cardId.value,
                "ticket" :form.ticket.value
			};
	    } else {
		    var data = {
				"openId" : form.openId.value,
				"serviceId" : form.serviceId.value,
				"fullName" : form.fullName.value,
                "validateCode":form.signCode.value,
				"password" : form.password.value,
				"mobile" : form.mobile.value,
				"email" : form.email.value,
				"certificateType" : form.certificateType.value,
				"certificateNo" : form.certificateNo.value,
				"operation" : form.operation.value,
				"hotelChannel" : form.hotelChannel.value,
				"airLineCompany" : form.airLineCompany.value,
				"airLineCardNo" : form.airLineCardNo.value,
				"isWeiXin" : form.isWeiXin.value,
                "returnUrl" :returnUrl,
                "cardId" :form.cardId.value,
                "ticket" :form.ticket.value
			};
	    }
	    openLoading();
	    
    sendRemotePost('/member/fullRegister',data,registerCallBack);
}

function registerCallBack(data){
    closeLoading();
    if(data.regStatus){
        var url = '/member/toFullRegSuccess?bindStatus='+data.bindStatus+'&key='+data.key;

        if(data.bindStatus){

            if(data.sendPointsStatus){
                url+='&operation='+$("#id_hid_operation").val();
            }
        }
        var airlineCompany = $("#airLineCompany").val();
        if(airlineCompany != '' && airlineCompany != undefined){
            url+='&registChannel='+airlineCompany;
        }
   
        if(returnUrl!=''){
            if(data.jjecpc){
                window.location.href=global+data.retUrl;
            }

            if(data.xzSign){
                window.location.href=data.returnUrl;
                return false;
            }

            if(data.welfareSign){
                window.location.href=data.returnUrl;
                return false;
            }
            if(data.memberCardSign){
                activateMemberCard(data)
            }

            else{
                window.location.href=global + returnUrl;
            }
        }else{
            if(data.TVResult){
                window.location.href=data.returnUrl;
            }else{window.location.href=global + url;}

        }
    }else{
        jAlert(data.message);
    }
}


function activateMemberCard(data){
    $.ajax({
        url : global + "/memberCard/toWechatRegisterActivityCard",
        type : "post",
        cache : false,
        data : {
            "cardId" :data.cardId,
            "openId":data.openId,
            "mobile":data.mobile,
            "pswd":data.pswd
        },
        dataType : "json",
        success : function(data) {

            if("40056"==data.message){
                jAlert("用户号错误！");
            }if("ok"==data.message){
                jAlert("用户卡激活成功！");
                wx.closeWindow();
            }

        }
    });

}