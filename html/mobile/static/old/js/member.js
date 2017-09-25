//JavaScript Document
$(function() {
	var nums = 0;
	$(".room-nums ul li").click(function() {
		nums = $(".room-nums ul li label").html();
		var index = $(this).index();
		var flag = $(this).val();
		var point = $("#point").val();
		var need = $("#need_jf").val();
		if (nums >= 0) {
			if (index == 2) {
				if((parseInt(need*nums)+parseInt(need))>point){
					$(".room-nums ul li").eq(2).removeClass("on");
				} else{
					if((parseInt(need*nums)+parseInt(need*2))>point){
						$(".room-nums ul li").eq(2).removeClass("on");
					}
					nums++;		
					$(".room-nums ul li label").html(nums);
					calcPoint(nums);
					$(".room-nums ul li").first().addClass("on");
				}
			}
			if (index == 0) {
				if (nums >= 2) {
					nums--;
				}
				$(".room-nums ul li label").html(nums);
				calcPoint(nums);
				if (nums <= 1) {
					$(".room-nums ul li").first().removeClass("on");
				}
				if((parseInt(need*nums)+parseInt(need))<=point){
					$(".room-nums ul li").eq(2).addClass("on");
				}
			}
		}
	});

	$(".tab-btn ul li").click(function() {
		$(this).addClass("on").siblings().removeClass("on");
		var index = $(this).index();
		if (index == 0) {
			$(".jjlxj").show().siblings().hide();
		} else {
			$(".jjzx").show().siblings().hide();
		}
		$(".btns-cont ul li").eq(index).show().siblings().hide();
	})

	$(".pwd-mode ul li").click(function() {
		$(this).toggleClass("on");
		var rememberMe = $("#rememberMe").hasClass("on");
		var autoLogin = $("#autoLogin").hasClass("on");
		localStorage.rememberMe = rememberMe;
		localStorage.autoLogin = autoLogin;
	});

	$(".btn-detail li").click(function() {
		$(this).addClass("on").siblings().removeClass("on");
		var index = $(this).index();
		if (index == 0) {
			$(".hy").parent().show();
			$(".hy").parent().siblings().hide();
		}
		if (index == 1) {
			$(".yhq").parent().show();
			$(".yhq").parent().siblings().hide();
		}
		if (index == 2) {
			$(".grxx").parent().show();
			$(".grxx").parent().siblings().hide();
		}
	})

	// 用户升级弹框
	$(".close").click(function() {
		$(this).parents(".dialog-cont").hide();
		$(".dialog-bg").hide();
	})
	/*$(".footer-btns div").click(function() {
		if(this.innerHTML != '免费升级'){
			$(this).parents(".dialog-cont").hide();
			$(".dialog-bg").hide();
		}
	})*/
	$(".jh").click(function() {
		$(".dialog-bg").show();
		$("#update_dialog").show();
	});
});
function init_loginview() {
	var rememberMe = localStorage.rememberMe;
	var autoLogin = localStorage.autoLogin;
	var loginName = localStorage.loginName;
	if (rememberMe === undefined) {
		rememberMe = "true";
	}
	if (loginName === undefined || loginName == 'null') {
		loginName = "";
	}
	if (autoLogin === undefined) {
		autoLogin = "true";
	}
	if (rememberMe == "true") {
		$("#rememberMe").addClass("on")
	} else {
		$("#rememberMe").removeClass("on")
	}
	if (autoLogin == "true") {
		$("#autoLogin").addClass("on")
	} else {
		$("#autoLogin").removeClass("on")
	}
	$("#loginName").val(loginName);
	localStorage.rememberMe = rememberMe;
	localStorage.autoLogin = autoLogin;
	localStorage.loginName = loginName;
}

function calcPoint(num) {
	var need = $("#need_jf").val();
	$("#need_jf").next().html(num * need);
}

function cancel_update(dom) {
	$(dom).parents(".dialog-cont").hide();
	$(".dialog-bg").hide();
}

function f_toShowRegInfo() {
	$(".dialog-bg").show();
	$("#info_dialog").show();
}

function view_update() {
	$("#confirm_dialog").hide();
	$("#update_dialog").show();
}

function f_toCueponList() {
	location.href = global + "/member/toCueponList";
}

function f_toCueponInfo(couponId) {
	location.href = global + "/member/toCueponInfo?couponId=" + couponId;
}

function f_toVipCenter(tag) {
	var p = "";
	if (tag !== undefined) {
		if (tag != null) {
			if (tag != "") {
				p = "?t=" + tag;
			}
		}
	}
	location.href = global + "/member/toVipCenter" + p;
}

// 跳转到自主激活页面
function f_toActivate() {
	window.location.href = global + "/member/toActivation";
}

// 跳转到忘记密码页面
function f_toforgotPwd() {
	window.location.href = global + "/member/toForgotPwd";
}

// 跳转到·页面
function f_toRegister() {
	window.location.href = global + "/member/toRegister";
}

function f_toRegisterWithUrl(returnUrl){
    if(returnUrl !=''){
        window.location.href = global + "/member/toFullRegister?returnUrl="+returnUrl;
    }else{
        window.location.href = global + "/member/toRegister";
    }
}

function f_toLoginWithUrl(returnUrl) {
    if(returnUrl !=''){
	    window.location.href = global + "/member/toLogin?returnUrl="+returnUrl;
    }else{
        window.location.href = global + "/member/toLogin";
    }
}

function f_toLogin() {
        window.location.href = global + "/member/toLogin";
}

function f_toLogout() {
	$(".dialog-bg").show();
	$("#logout_dialog").show();
}
function f_doLogout() {
	ga('send', 'event','用户中心页面', '注销', '确认注销按钮');
	//location.href = global + "/member/toLoginout";
    location.href = global + "/otherController/toUnBindingWeChat";
}
function isWeixin() {
	var ua = navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == "micromessenger") {
		return true;
	} else {
		return false;
	}
}

function f_toIndex() {
	if (!isWeixin()) {
		location.href = global + "/index/toIndex";
	} else {
		location.href = global + "/hotel/toHotelSearch";
	}
}

function f_torepsw() {
	location.href = global + "/member/toRePsw";
}

function f_toPointHis() {
	location.href = global + "/member/toPointHis";
}

function f_toBenifitCard() {
	location.href = global + "/member/toBenifitCard";
}

function f_toEditProfilePage(flag) {
	if (flag) {
		$(".dialog-bg").show();
		$("#confirm_dialog").show();
	} else {
		location.href = global + "/member/toEditProfilePage";
	}
}

function f_toOrderList() {
	location.href = global + "/order/toList";
}

function f_toCardRights() {
	location.href = global + "/member/toCardRights";
}

function f_toViewList(parVale) {
	location.href = global + "/member/toListCuepon?parVale=" + parVale;
}

// 执行登入操作
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

function f_doUpRegistMember(dom) {
	ga('send', 'event','用户中心页面', '免费升级', '免费升级按钮');
	var name = $("#name").val();
	var certificateType = $("#certificateType").val();
	var certificateNo = $("#certificateNo").val();
	if (name != "" && certificateNo != "") {
		if(certificateType == 'ID'){
			var valid = isCardNo(certificateNo);
			if(!valid){
				jAlert("请填写正确的证件号码");
				return false;
			}
		}
		$("#top_index").show();
		$(dom).attr("onclick","").css({"background-color":"#dcdcdc"}).html("请稍等...");
		$.ajax({
			url : global + "/member/upRegistMember",
			type : "post",
			cache : false,
			data : {
				"name" : name,
				"certificateType" : certificateType,
				"certificateNo" : certificateNo
			},
			dataType : "json",
			success : function(data) {
				jAlert(data.message);
				if (data.success) {
					f_toVipCenter('1');
				}
				$("#top_index").hide();
				$(dom).attr("onclick","javascript:f_doUpRegistMember(this)").html("免费升级").css({"background-color":"rgb(81, 162, 238)"});
			}
		});
	} else {
		jAlert("请填写姓名及证件号码");
	}
}
//自助激活
function f_activation() {
	ga('send', 'event','锦江之星用户卡自助激活页面', '自助激活', '激活按钮');
	var fullName = $("#fullName").val();
	var identityType = $("#identityType").val();
	var identityNo = $("#identityNo").val();
	if(fullName==''){
		jAlert("请输入姓名");
		return;
	}
	if(identityNo==''){
		jAlert("请选择证件类型");
		return;
	}
	$.ajax({
			url : global + "/member/doActivation",
			type : "post",
			cache : false,
			data : {
				"fullName" : fullName,
				"identityType" : identityType,
				"identityNo" : identityNo
			},
			dataType : "json",
			success : function(data) {
				//以激活的
				if(data.status=='-2'){
					jAlert(data.message);
				}
				//激活失败
				if(data.status=='-1'){
					jAlert(data.message);
				}
				//不存在
				if(data.status=='0'){
					jAlert(data.message);
				}
				//有手机号
				if(data.status=='1'){
					f_toActivationSucceed(data.mobile,"");
				}
				//有邮箱
				if(data.status=='2'){
					f_toActivationSucceed("",data.email);
				}
				//没有手机号与邮箱
				if(data.status=='3'){
					f_toActivationMobile(fullName,identityType,identityNo);
				}
			}
	});
}


//激活成功页面
function f_toActivationSucceed(mobile,email) {
	location.href = global + "/member/toActivationSucceed?mobile="+mobile+"&email="+email;
}
//激活从新绑定手机号页面
function f_toActivationMobile(fullName,identityType,identityNo){
	location.href = global + "/member/toActivationMobile?fullName="+fullName+"&identityType="+identityType+"&identityNo="+identityNo;
}

function f_doModify() {
	ga('send', 'event','编辑个人资料页面', '修改个人资料', '提交按钮');
	var phone = $("#phone").val();
	var email = $("#email").val();
	if (phone != "" && email != "") {
		$.ajax({
			url : global + "/member/modifyBasicInfo",
			type : "post",
			cache : false,
			data : {
				"phone" : phone,
				"email" : email
			},
			dataType : "json",
			success : function(data) {
				jAlert(data.message);
				if (data.success) {
					f_toVipCenter('3');
				}
			}
		});
	} else {
		jAlert("请输入手机号及邮箱");
	}
}



// 忘记密码,获取验证码
function f_getValidateCode(){
	var telephone = $("#telephone").val();
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
		url : global + "/member/getValidateCodeByPhone",
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




//绑定解绑,获取验证码
function f_getWechatValidateCode(){
    var telephone = $("#telephone").val();
    var type = $("#type").val();
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
        url : global + "/member/getWechatValidateCodeByPhone",
        type : "post",
        cache : false,
        data : {
            "telephone" : telephone,
            "type":type,
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

// 忘记密码,找回密码
function f_recoverPassword(){
	var telephone = $("#telephone").val();
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
	var signCode = $("#signCode").val();
	if(signCode == ""){
		jAlert("请输入手机动态码");return;
	}
	var pswd = $("#pswd").val();
	if(pswd == ""){
		jAlert("密码不能为空");return;
	}
	if (!verfyPassword(pswd)) {
		jAlert('密码由6-12位字符，由字母或数字组成');return;
	}
	var repswd = $("#repswd").val();
	if(repswd == ""){
		jAlert("确认密码不能为空");return;
	}
	if(pswd != repswd){
		jAlert("两次输入的密码不一致");return;
	}
	openLoading();
	$.ajax({
		url : global + "/member/recoverPassword",
		type : "post",
		cache : false,
		data : {
			"telephone" : telephone,
			"signCode" : signCode,
			"pswd" : pswd
		},
		dataType : "json",
		success : function(data) {
			closeLoading();
			if (data.success) {
				jAlert('密码更新成功','提示', function(r) {
					window.location.href = global + "/member/toLogin";return;
				});
			} else {
				jAlert(data.message);
				return;
			}
		}
	});
}

function f_doRetrievePwd() {
	ga('send', 'event','找回密码页面', '找回密码', '发送动态码按钮');
	var telephone = $("#telephone").val();
	if(telephone == ""){
		jAlert("请输入手机号");return;
	}
	if(telephone.length != 11 || isNaN(telephone)){ 
		jAlert("手机号格式有误，请重新输入");return;
	}
	$.ajax({
		url : global + "/member/doRetrievePwd",
		type : "post",
		cache : false,
		data : {
			"telephone" : telephone
		},
		dataType : "json",
		success : function(data) {
			if (data.success) {
				secondCounter(60);return;
			} else {
				jAlert(data.message);return;
			}
		}
	});
}

function f_doUpdatePwd(){
	var telephone = $("#telephone").val();
	if(telephone == ""){
		jAlert("请输入手机号");return;
	}
	if(telephone.length != 11 || isNaN(telephone)){ 
		jAlert("手机号格式有误，请重新输入");return;
	}
	var signCode = $("#signCode").val();
	if(signCode == ""){
		jAlert("请输入验证码");return;
	}
	var pswd = $("#pswd").val();
	if(pswd == ""){
		jAlert("密码不能为空");return;
	}
	if (!verfyPassword(pswd)) {
		jAlert('密码由6-12位字符，由字母或数字组成');return;
	}
	var repswd = $("#repswd").val();
	if(repswd == ""){
		jAlert("确认密码不能为空");return;
	}
	if(pswd != repswd){
		jAlert("两次输入的密码不一致");return;
	}
	openLoading();
	$.ajax({
		url : global + "/member/doUpdatePwd",
		type : "post",
		cache : false,
		data : {
			"telephone" : telephone,
			"signCode" : signCode,
			"pswd" : pswd
		},
		dataType : "json",
		success : function(data) {
			closeLoading();
			if (data.success) {
				jAlert('密码更新成功','提示', function(r) {
					window.location.href = global + "/member/toLogin";return;
				});
			} else {
				jAlert(data.message);return;
			}
		}
	});
}

function changeValidate(){
	$("#validateCode").attr("src", global + "/member/captcha?abc=" + Math.random());
}



function checkCode(){
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
	$.ajax({
		url : global + "/member/checkPhoneByCode",
		type : "post",
		cache : false,
		data : {
			"telephone" : mobile,
			"signCode":signCode
		},
		dataType : "json",
		success : function(data) {
			if (data.success==true) {
				f_doReg();
			}else{
				jAlert(data.message);
				return;
			}
		}
	});
}
function f_doReg() {

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
                    f_doLogin();
				} else {
					jAlert(data.message,'信息提示', function(r) {
                        f_doLogin();
					});
				}
            } else {
        		jAlert(data.message);

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

function f_dorepsw() {
	ga('send', 'event','修改密码页面', '修改密码', '提交按钮');
	var oldPassword = $("#oldPassword").val();
	var newPassword = $("#newPassword").val();
	var renewPassword = $("#renewPassword").val();
	if(!verfyPassword(newPassword)){
		jAlert('密码由6-12位字符，由字母或数字组成');return;
	}
	if(renewPassword != newPassword){
		jAlert("两次输入的新密码不一致");return;
	}
	$.ajax({
		url : global + "/member/doRePsw",
		type : "post",
		cache : false,
		data : {
			"oldPassword" : oldPassword,
			"newPassword" : newPassword
		},
		dataType : "json",
		success : function(data) {
			jAlert(data.message,'提示', function(r) {
				if (data.success) {
					//f_toVipCenter('3');
                    location.href = global + "/member/toMemberCard";
				}
			});
		}
	});
}

function f_doExchange() {
	ga('send', 'event','积分兑换页面', '积分兑换', '兑换按钮');
	var productId = $("#productId").val();
	var issueCount = $("#issueCount").html();
	var point = $("#point").val();
	var need = $("#need_jf").val();
	if(point == "" || point < need){
		jAlert("您当前积分不足，无法兑换优惠券");return;
	}
	if (productId != "" && issueCount != "") {
		$.ajax({
			url : global + "/member/doExchange",
			type : "post",
			cache : false,
			data : {
				"productId" : productId,
				"issueCount" : issueCount
			},
			dataType : "json",
			beforeSend:function(){
			    openLoading();
			},
			success : function(data) {
				jAlert(data.message);
				if (data.success) {
					f_toVipCenter('1');
				}
			},
			complete:function(){
			    closeLoading();
			}
		});
	}
}

//用户卡反转-暂废
var n = 180;
var iID;
function startTrafrom(){
	n=n+2;
	if(n<361){
		if(n==182){
			$(".card-on-txt").html("<br><br>&nbsp; &nbsp;<br><br>&nbsp; &nbsp;");
		}
		if(n==270){
			var src = $(".xk-a").children("img").attr("src");
			if(!src){
				return;
			}
			if(!$(".xk-a").hasClass("xk-b")){
				$(".xk-a").addClass("xk-b");
				if(src.indexOf("_1.png")>0){
					$(".xk-a").children("img").attr('src',src.replace("_1.png","_2.png"));
				}
			}else{
				$(".xk-a").removeClass("xk-b");
				if(src.indexOf("_2.png")>0){
					$(".xk-a").children("img").attr('src',src.replace("_2.png","_1.png"));
				}
			}
		}
		var flag = window.orientation;
		if(flag ==0 || flag == 180){
			$(".xk-a img").css({"-webkit-transform":"rotateX(" + n+ "deg)"});
		}else{
			$(".xk-a img").css({"-webkit-transform":"rotate(90deg) rotateX(" + n+ "deg)"});
		}
	}else{
		n=180;
		clearInterval(iID);
		$(".xk-a .close").show();
		var flag = window.orientation;
		if(flag ==0 || flag == 180){
			$(".xk-a img").css({"-webkit-transform":"rotateX(0deg)"});
		}else{
			$(".xk-a img").css({"-webkit-transform":"rotate(90deg)"});
		}
		if(!$(".xk-a").hasClass("xk-b")){
			$(".card-on-txt").html(cardText);
		}
	}
}
$(function(){
	$(".dh-card").click(function(){
		$(".xk-a").show();
		$(".card-on-txt").html(cardText);
		$(".xk-a .close").show();
		var cardA = $(".dh-card").clone();
		$(".xk-a").append(cardA);
		var src = $(".xk-a").children("img").attr("src");
		if(src.indexOf("_1.png")>0||src.indexOf("_2.png")>0){

		}else{
			//src=src.replace(".png","_1.png");
			$(".xk-a").children("img").attr('src',src);
		}
		$(".xk-a .dh-card").animate({
			"position":'absolute',
			'right':'0px',
			'top':'0px'
		});
		$(".xk-a img").css({"width":"380px"});
		$(".xk-a img").css({"transform":"rotate(-90deg)","-ms-transform":"rotate(-90deg)","-o-transform":"rotate(-90deg)","-webkit-transform":"rotate(-90deg)","margin":"55px auto","-moz-transform":"rotate(-90deg)"});
		var left = document.body.clientWidth/2+100+"px";
		$(".xk-a .close").css({"top":"83px","left":left});
		//window_change(window.orientation);
	});

	$(".xk-a .close").click(function(){
		  $(".xk-a").children("img").remove();
		  $(".xk-a .close").hide();
		  $(".xk-a").removeClass("xk-b");
		  $(".xk-a").hide();
	});

	$("body").delegate(".xk-a img","click",function(){
		 $(".xk-a").children("img").remove();
		 $(".xk-a .close").hide();
		 $(".xk-a").removeClass("xk-b");
		 $(".xk-a").hide();
		//$(".xk-a .close").hide();
		//clearInterval(iID);
		//iID=setInterval('startTrafrom()',1);
	});
});

function verfyPassword(password) {
	var gz = "^[0-9a-zA-Z]{6,12}$";
	var vdt = new RegExp(gz);
	if (!vdt.test(password)) {
		return false;
	}
	return true;
}