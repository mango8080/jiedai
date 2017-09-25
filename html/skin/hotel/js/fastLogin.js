function fastLogin(lang) {
    memberFastLoginBox(lang);
    $("#exist_login_username").focus();
    $("#exist_member_login_btn").click(function (event) {
        event.preventDefault();
        var param = {};
        param.username = $("#exist_login_username").val();
        param.password = $("#exist_login_password").val();
        param.oneMonth = $(".login_info_box .avoid_login_box .check_btn").val() == "checked";

        var nameIsEmpty = "用户名不能为空";
        if (lang == 'en' || lang == "ja-JP") {
            nameIsEmpty = 'Username can not be empty';
        }
        var pwdIsEmpty = "密码不能为空";
        if (lang == 'en' || lang == "ja-JP") {
            pwdIsEmpty = "Password can not be empty";
        }
        if (param.username == null || param.username == "" || param.username == "注册邮箱/手机号码" || param.username == "Email/Mobile") {
            $(".login_info_box .alarm_text").html(nameIsEmpty);
            $(".login_info_box .alarm_text").css("visibility", "visible");
            return;
        }

        if (param.password == null || param.password == '') {
            $(".login_info_box .alarm_text").html(pwdIsEmpty);
            $(".login_info_box .alarm_text").css("visibility", "visible");
            return;
        }

        if (!checkValidateCode("loginBox_validateCode")) {
            $("#login_info_box .alarm_text").css("visibility", "visible");
            $("#login_info_box .alarm_text").html("验证码错误");
            return;
        }


        $(".login_info_box .alarm_text").html('');
        $(".login_info_box .alarm_text").css("visibility", "hidden");
        
        var data = "usr=" + param.username + "&pwd=" + StringUtil.base64encode(param.password) + "&oneMonth=" + param.oneMonth + "&callback=?" + "&code=" + $("#loginBox_validateCode").val();
        $.ajax({
            type: 'POST',
            url: "/Handlers/SsoLoginHandler.ashx",
            dataType: "jsonp",
            jsonp: "callback",
            data: data,
            cache: false,
            async: false,
            success: function (result) {
                if (result == null) {
                    return;
                }
                if (result.Success) {
                    $(".login_info_box .alarm_text").css("visibility", "hidden");
                    if (result.url != null && result.url.length > 0) {
                        //Save ImageURL to cookie
                        $.cookie("imageUrl", result.url);
                    }
                    //Write Cookie for authed
                    if (result.token != null) {
                        //console.log("token", result.token);
                        $.cookie("$authCookieName$", result.token, { expires: 1 });
                    }
                    if (result.id != null) {
                        //console.log("memberId", result.id);
                        $.cookie("memberId", result.id, { expires: 1 });
                    }

                    location.reload();
                }
                else {
                    if (lang == "en"||lang=="EN") {                        
                        if (result.code != null && result.code == "101") {
                            $(".login_info_box .alarm_text").html("Verification code error, please try again");
                        }
                        else {
                            $(".login_info_box .alarm_text").html("UserName or password error");
                        }
                    }
                    else {
                        if (result.code != null && result.code == "101") {
                            $(".login_info_box .alarm_text").html(result.message);                            
                        }
                        else if (result.code != null && result.code == "301") {//修改密码 
                            if ($("#exist_login_username").val().trim().length > 0 || $("#exist_login_password").val().trim().length > 0)
                            {
                                $("#exist_login_username").val("");
                                $("#exist_login_password").val("");
                            }
                            $(".popup_close_btn").click();
                            ImprovePassword();
                        }
                        else {
                            $(".login_info_box .alarm_text").html("用户名或密码错误");
                        } 
                    }
                    ChangeCodeImg("loginBox_ImageCheck");
                    $("#loginBox_validateCode").val("");
                    $(".login_info_box .alarm_text").css("visibility", "visible");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
}

//用户快速登录弹框
function memberFastLoginBox(lang) {
    clearPopupLayer();
    var popup_title = "若您已是我们的J-Club用户，欢迎回来！";
    var user_name_text = "注册邮箱/手机号码";
    var password_text = "登录密码";
    var alarm_init_text = "用户名或密码错误";
    var avoid_login_text = "一个月内免登录";
    var login_text = "登录"
    var validateCode_text = "验证码";
    var validateCode_title = "点击更换验证码图片";
    var forgetPwdUrl = $("#forgetPwd").attr("href");
    var forgetPwdTxt = "忘记密码";
    if (lang == "en" || lang == "ja-JP" || lang == "EN" || lang == "JA") {//语言判定
        popup_title = "Login ";
        user_name_text = "Email/Mobile";
        password_text = "Password";
        alarm_init_text = "wrong user name";
        avoid_login_text = "Remeber me in 1 month";
        forgetPwdTxt = "Forgot Password"
        login_text = "Login";
        validateCode_text = "Code";
        validateCode_title = "Click Replace verification code image";
    }
    var memberPopupCheckbox = $.layer({
        type: 1,
        title: false,
        area: ['476px', '297px'],
        border: [4, 0.6, '#000'], //去掉默认边框
        shade: [0.4, '#000'], //去掉遮罩
        closeBtn: [0, false], //去掉默认关闭按钮
        shift: 'left', //从左动画弹出
        page: {
            html: "<div class='member_login_auto_box'>"
                        + "<div class='popup_title_box clearfix'>"
                            + "<div class='popup_title_text'>" + popup_title + "</div>"
                            + "<div class='popup_close_btn'></div>"
                        + "</div>"
                        + "<div class='login_info_box'>"
                            + "<input id='exist_login_username' type='text' value='" + user_name_text + "' />"
                            + "<div class='exist_login_password_box clearfix'>"
                                + "<input id='exist_login_password' type='password' class='login_password' />"
                                + "<label>" + password_text + "</label>"
                            + "</div>"
                            + "<div class='num_validate_box clearfix'>"
						        + "<input id='loginBox_validateCode'  data-watermark='" + validateCode_text + "' value='" + validateCode_text + "' type='text' name='loginBox_validateCode' class='num_validate_input'><img id='loginBox_ImageCheck' src='' width='63' height='29' class='num_validate_pic' title='" + validateCode_title + "' alt=''  onclick=\"ChangeCodeImg('loginBox_ImageCheck')\"/>"
                                + "<img id='loginBox_aImageCheck'  class='num_validate_icon' onclick=\"ChangeCodeImg('loginBox_ImageCheck')\" src='/themes/hotels/images/num_validate_icon.png'/>"
                            + "</div>"
                            + "<div class='avoid_login_box' style='padding:10px 0 5px 20px'>"
                            + "<a class='pop_horizantal' target='_blank' href='" + forgetPwdUrl + "'>" + forgetPwdTxt + "</a>"
                                + "<div id='' class='check_btn horizantal' value='unchecked'></div>"
                                + "<div class='horizantal'>" + avoid_login_text + "</div>"
                            + "</div>"
                            + "<div class='alarm_text' style='padding:5px 0 0px 20px'>" + alarm_init_text + "</div>"
                            + "<div id='exist_member_login_btn' class='yahei'>" + login_text + "</div>"
                        + "</div>"
                  + "</div>"
        }
    });
    //重定位弹出框水平位置
    $(".member_login_auto_box").parent().parent().parent().parent().css("margin-left", "-238px");
    //透明边框
    $(".xubox_border").css({ "width": 484, "height": 306 });
    //input光标移入移出样式效果
    $("input, textarea").focusin(function () { $(this).addClass("enter_input_border"); });
    $("input, textarea").focusout(function () { $(this).removeClass("enter_input_border"); });
    //check按钮事件
    bindCheckBtnEvents();
    textWaterMarkEvents("exist_login_username", user_name_text, "#dedede", "#777");//绑定用户名输入框事件
    passwordWaterMarkEvents("exist_login_password", "#dedede", "#777");//绑定密码输入框事件
    textWaterMarkEvents("loginBox_validateCode", $("#loginBox_validateCode").attr("data-watermark"), "#dedede", "#777");//绑定验证码输入框事件
    //绑定关闭按钮事件
    $('.member_login_auto_box .popup_close_btn').on('click', function () {
        layer.close(memberPopupCheckbox);
    });
    ChangeCodeImg("loginBox_ImageCheck");
}

//check按钮事件
function bindCheckBtnEvents() {
    $(".check_btn").bind("click", function () {
        var check_value = $(this).attr("value");
        if (check_value == "unchecked") {
            $(this).attr("value", "checked");
            $(this).addClass("checked");
        } else {
            $(this).attr("value", "unchecked");
            $(this).removeClass("checked");
        }
    });
}