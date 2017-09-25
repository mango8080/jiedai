var lang_val = $("#lang").attr("value");//获取当前页面语言版本
document.write("<script src='/themes/NewInns/js/multilingual-datepicker.js' type='text/javascript'></script>");
function navigation(){
	//星级酒店修改icon
	if ($(".wrapper").length > 0){
		if($(".wrapper").attr("class").indexOf("jinjiang_star_hotel") > -1){
			$("head").append("<link id='jinjianghotels_icon' rel='shortcut icon' href='/themes/hotels/images/jinjianghotels.jpg' type='image/x-icon' />");
		}
	}
    //ie6升级提示
	ieSixVerify();
	//input光标移入移出修改样式、修改title值
	$("input, textarea").focusin(function(){$(this).addClass("enter_input_border");});
	$("input, textarea").focusout(function(){
		$(this).removeClass("enter_input_border");
		$(this).attr("title", $(this).val());
		//if($(this).attr("class").indexOf("inputText") == -1){
//			$(this).attr("title", $(this).val());
//		}
	});
	//check按钮事件
	bindCheckBtnEvents();
	//顶部导航logo折叠隐藏
	$("#top_nav").find("a").hover(function(){
		  $(this).find("span").show();
		},function(){
		  $(this).find("span").hide();	
		});
	//二级导航最后一个元素消除距离
	$(".main_nav_erji").find("a:last").addClass("a_last");
	
	//登录框和已登录框弹出层
	var timer=null;
	$("#top_nav_main").find(".login").mouseover(function(){
		 clearTimeout(timer);												 
		 $("#login_box").show();
		 textWaterMarkEvents("login_username", $("#login_username").attr("data-watermark"), "#dedede", "#777");//绑定用户名输入框事件
         passwordWaterMarkEvents("login_password", "#dedede", "#777");//绑定密码输入框事件
         textWaterMarkEvents("header_validateCode", $("#header_validateCode").attr("data-watermark"), "#dedede", "#777");//绑定验证码输入框事件
         if ($("#validateCodeEmail").length > 0)
         {
            textWaterMarkEvents("validateCodeEmail", $("#validateCodeEmail").attr("data-watermark"), "#dedede", "#777");//绑定验证码输入框事件
         }
         
		 //为页面添加锁屏样式
		$(".wrapper").addClass("wrapper_locked");
		$("#holder").css("z-index", 1);
		$(".jinjian_top_bar").addClass("wrapper_locked");
	});
	$("#top_nav_main").find(".login").mouseout(function(){
		 timer=setTimeout(function(){$("#login_box").hide();},500);
		 
		 $("#login_username").blur();//解绑用户名输入框事件
		 $("#login_password").blur();//解绑密码输入框事件
		 $("#header_validateCode").blur();
		 //为页面删除锁屏样式
		 $(".wrapper").removeClass("wrapper_locked");
         $("#holder").css("z-index", 20);
         $(".jinjian_top_bar").removeClass("wrapper_locked");
	});
	$("#top_nav_main").find(".logined").mouseover(function(){
		 clearTimeout(timer);												 
		 $("#login_box").show();
	});
	$("#top_nav_main").find(".logined").mouseout(function(){
		 timer=setTimeout(function(){$("#login_box").hide();},500);
	});
	$("#login_box").mouseover(function(){
		 clearTimeout(timer);							   
		 $(this).show();
	});
	$("#login_box").mouseout(function(){
		 timer=setTimeout(function(){$("#login_box").hide();},500);
	});


    //mouse enter回车按键登录事件
	$('#login_username, #login_password,#header_validateCode').keydown(function (e) {
	    if (e.keyCode == 13) {
	        if ($('#loginLink').length > 0) {
	            $('#loginLink').click();
	        }
	        else if ($('.login_btn').length == 1) {
	            $('.login_btn').click();
	        }
	    }
	});

	if($(".orderPage").length==0)bindDatePickers();

}

//IE6验证
function ieSixVerify(){
	var isIE6 = $.browser.msie && ( parseInt($.browser.version) < 7 ) && !$.support.style ? true : false;
	//IE6提示
	if(isIE6) {
		var $warning = $('<div style="width:100%;line-height:40px;position:absolute;top:0;left:0;z-index:99999;text-align:center;font-size:14px;color:#000;"><div style="background:#FFa;">您正在使用 Internet Explorer 6，在本页面的显示效果可能有差异。建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 8</a> </div></div>').appendTo('body');
		setTimeout(function(){$warning.fadeOut(500,function(){$(this).remove()})},6000);
	}
}
//用户快速登录弹框
function memberCheckBox() {
    clearPopupLayer();
    var popup_title = "您已是我们的J-Club用户，欢迎回来！";
    var user_name_text = "注册邮箱/手机号码";
    var password_text = "登录密码";
    var alarm_init_text = "用户名或密码错误";
    var avoid_login_text = "一个月内免登录";
    var login_text = "登录"
    var forgetPwdUrl = $("#forgetPwd").attr("href");
    var forgetPwdTxt = "忘记密码";
    var lang_val = $("#contextLanguage").val();
    if (lang_val == "en" || lang_val == "ja-JP") {//语言判定
        popup_title = "Login ";
        user_name_text = "Email/Mobile";
        password_text = "Password";
        alarm_init_text = "wrong user name";
        avoid_login_text = "Remeber me in 1 month";
        forgetPwdTxt = "Forgot Password"
        login_text = "Login";
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
                            + "<div class='avoid_login_box'>"
                            + "<a class='pop_horizantal' target='_blank' href='" + forgetPwdUrl + "'>" + forgetPwdTxt + "</a>"
                                + "<div id='' class='check_btn horizantal' value='unchecked'></div>"
                                + "<div class='horizantal'>" + avoid_login_text + "</div>"
                            + "</div>"
                            + "<div class='alarm_text'>" + alarm_init_text + "</div>"
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
    //绑定关闭按钮事件
    $('.member_login_auto_box .popup_close_btn').on('click', function () {
        layer.close(memberPopupCheckbox);
    });
}
//文本输入框水印事件。参数：inputId（文本输入框ID）；initialVal（初始值）；initialColor（初始色）；focusColor（键入色）。
function textWaterMarkEvents(inputId, initialVal, initialColor, focusColor){
	if ($("#" + inputId).val() != initialVal && $("#" + inputId).val().replace(/(^\s*)|(\s*$)/g, "")!=""){//判定现有值是否为初始值或为空
		$("#" + inputId).css("color", focusColor);
	} else if($("#" + inputId).val().replace(/(^\s*)|(\s*$)/g, "")==""){
		$("#" + inputId).css("color", initialColor);
		$("#" + inputId).val(initialVal);
	}
	$("#" + inputId).bind("focusin",function(){//光标移入事件
		$(this).css("color", focusColor);
		if ($(this).val() == initialVal){
			$(this).val("");
		}
	});
	$("#" + inputId).bind("focusout",function(){//光标移出事件
		if ($(this).val().replace(/(^\s*)|(\s*$)/g, "")==""){
			$(this).css("color", initialColor);
			$(this).val(initialVal);
		}
	});
}
//密码输入框水印事件。参数：inputId（密码输入框ID）；initialColor（初始色）；focusColor（键入色）。调用此方法需使用特定html结构
function passwordWaterMarkEvents(inputId, initialColor, focusColor){
	if ($("#" + inputId).val().replace(/(^\s*)|(\s*$)/g, "")!=""){//判定现有值不为空
		$("#" + inputId).parent().find("label").hide();//隐藏水印
	} else if ($("#" + inputId).val().replace(/(^\s*)|(\s*$)/g, "")==""){
		$("#" + inputId).parent().find("label").show();
	}
	$("#" + inputId).bind("focusin",function(){//光标移入事件
		$(this).css("color", focusColor);
		if ($(this).val().replace(/(^\s*)|(\s*$)/g, "")==""){
			$(this).parent().find("label").hide();
		}
	});
	$("#" + inputId).bind("focusout",function(){//光标移出事件
		if ($(this).val().replace(/(^\s*)|(\s*$)/g, "")==""){
			$(this).css("color", "#dedede");
			$(this).parent().find("label").show();
		}
	});
	$("#" + inputId).parent().find("label").bind("click", function(){//水印点击事件
		$(this).hide();
		$("#" + inputId).focus();
	})
}
//文本框水印
function inputTipText(){   
	$("input[class*=inputText]").each(function(){  
		var valTxt = $(this).attr("title");
		var htm = "<label class='tipTxt'>" + valTxt +"</label>"
		$(this).after(htm);
		$(this).keyup(function(){
			if($(this).val()==""){
				$(this).next().show();
			} else {
				$(this).next().hide();
			}
		}); 
		if($(this).val()==""){
			$(this).next().show();
		}else{
			$(this).next().hide();
		}
		$(".tipTxt").click(function(){
			$(this).prev().focus();					
		});
		$(this).focusin(function(){
			$(this).next().hide();
		});
		$(this).focusout(function(){
			if($(this).val()==""){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
		});
	});  
} 
//绑定日历控件，添加联动效果
function bindDatePickers() {
    var today = new Date();//系统当天时间Date对象
    //var today = stringToDate($("#server_time_date").val());//将服务器时间转为Date对象
    $(".dateCheckIn").datepicker({
        minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
        maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 90),
        numberOfMonths: 2,
        changeMonth: false,
        changeYear: false,
        regional: lang_val,//中英日
        beforeShow: function () {
            setTimeout(
				function () {
				    $('#ui-datepicker-div').css("z-index", 9999);//为弹出层赋最高层级
				}
			);
        },
        onSelect: function (dateText, inst) {
            var next_day = new Date(getTimeByDateStr(dateText) + 1 * 24 * 60 * 60 * 1000);//所选时间的下一天
            var next_month = (parseInt(next_day.getMonth()) + 1).toString();//所选时间的下一天的月份
            if (next_month.length == 1) {
                next_month = "0" + next_month;
            }
            var next_date = (next_day.getDate()).toString();//所选时间的下一天的日期
            if (next_date.length == 1) {
                next_date = "0" + next_date;
            }
            $(".dateCheckOut").datepicker('option', 'minDate', new Date(getTimeByDateStr(dateText) + 1 * 24 * 60 * 60 * 1000));//最小离店日期为入住日期加1天
            $(".dateCheckOut").datepicker('option', 'maxDate', new Date(getTimeByDateStr(dateText) + 14 * 24 * 60 * 60 * 1000));//最大离店日期为入住日期加14天
            $(".dateCheckOut").val(next_day.getFullYear() + "-" + next_month + "-" + next_date);//为离店日期赋值（即为入住日期加1天）
            $(".dateCheckIn").attr("title", $(".dateCheckIn").val());
        }
    });
    var check_out_date = null;
    var check_in_date = null;
    var check_out_max_date = null;
    if ($(".amap_maps").length >= 1 || $(".map_unfold").length >= 1) {
        check_in_date = initCriteria.checkin;
    } else {
        check_in_date = $(".dateCheckIn").val();
    }
    if (check_in_date == null) {//判定入住日期是否为空
        check_out_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
    } else {
        check_out_date = new Date(getTimeByDateStr(check_in_date) + 1 * 24 * 60 * 60 * 1000);//最小离店日期为入住日期加1天
        check_out_max_date = new Date(getTimeByDateStr(check_in_date) + 14 * 24 * 60 * 60 * 1000);//最大离店日期为入住日期加14天
    }
    $(".dateCheckOut").datepicker({
        minDate: check_out_date,
        maxDate: check_out_max_date,
        numberOfMonths: 2,
        changeMonth: false,
        changeYear: false,
        regional: lang_val,
        beforeShow: function () {
            setTimeout(
				function () {
				    $('#ui-datepicker-div').css("z-index", 9999);
				}
			);
        },
        onSelect: function (dateText, inst) { $(".dateCheckOut").attr("title", $(".dateCheckOut").val()); }
    });
    $.datepicker.setDefaults($.datepicker.regional[lang_val]);
}

function sureBox() {
    var surePopupBox = $.layer({
        type: 1,
        title: false,
        area: ['476px', '200px'],
        border: [0], //去掉默认边框
        shade: [0.4, '#000'], //去掉遮罩
        closeBtn: [0, false], //去掉默认关闭按钮
        shift: 'left', //从左动画弹出
        page: {
            html: "<div class='com_pop_box'>"
                        + "<div class='popup_title_box clearfix'>"
                            + "<div class='popup_title_text'>确认</div>"
                            + "<div class='popup_close_btn'></div>"
                        + "</div>"
                        + "<div class='pop_mian_box'>"
                            + "<p>我们将根据您提供的联系人及入住人信息进行保险购买，请确认。</p>"
                        + "</div>"
                        + "<div class='pop_bottom_box'>"
                            + "<div class='pop_sure_area'>"
                                + "<a class='sure_btn' href='javascript:;'>确定</a><a class='cancel_link' href='javascript:;'>返回</a>"
                            + "</div>"
                        + "</div>"
                  + "</div>"
        }
    });
    
    $('.popup_close_btn,.cancel_link,.sure_btn').on('click', function () {
        layer.close(surePopupBox);
    });
}

//绑定旅游、租车日历控件，添加联动效果(dateCheckInId:起始日期；dateCheckOutId：结束日期。)
function bindTravelAndRentalDatePickers(dateCheckInId, dateCheckOutId){
	var today = stringToDate($("#server_time").val());//将服务器时间转为Date对象
	//console.log(today);
	//console.log(new Date());
	if (dateCheckOutId == "endDate"){//判定是否为租车日期录入框
		today = new Date(today.getFullYear(), today.getMonth(), today.getDate()+2);//租车开始时间至少提前48小时
	} else {
		today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
	}
	$("#" + dateCheckInId).datepicker({
	    minDate: today,
		numberOfMonths: 2,
		changeMonth: false,
		changeYear: false,
		beforeShow: function () {
			setTimeout(
				function () {
					$('#ui-datepicker-div').css("z-index", 9999);
				}
			);
		},
		onSelect:function(dateText, inst){
			var next_day = new Date(getTimeByDateStr(dateText)+1*24*60*60*1000);//所选时间的下一天
			if (dateCheckOutId == "endDate"){next_day = new Date(getTimeByDateStr(dateText));}//若为租车日期录入框，结束日期可以等于开始日期
			var next_month = (parseInt(next_day.getMonth())+1).toString();//所选时间的下一天的月份
			if (next_month.length == 1){
				next_month = "0" + next_month;
			}
			var next_date = (next_day.getDate()).toString();//所选时间的下一天的日期
			if (next_date.length == 1){
				next_date = "0" + next_date;
			}
			if (dateCheckOutId == "travel_check_out"){//判定是否为旅游日期录入框
				$("#" + dateCheckOutId).datepicker('option','minDate',new Date(getTimeByDateStr(dateText)+1*24*60*60*1000));//为旅游返程日期赋最小值（即为出发日期加1天））
				if ($("#" + dateCheckOutId).val().trim() == null || $("#" + dateCheckOutId).val().trim() == ""){$("#" + dateCheckOutId).val("YYYY-MM-DD");}//若录入框为空，赋水印
				$("#" + dateCheckInId).css("color", "#333");
				$("#" + dateCheckInId).attr("title", $("#" + dateCheckInId).val());
			} else if (dateCheckOutId == "endDate"){//判定是否为租车日期录入框
				$("#" + dateCheckOutId).datepicker('option','minDate',new Date(getTimeByDateStr(dateText)));//为租车结束时间赋最小值
				$("#" + dateCheckOutId).val(next_day.getFullYear() + "-" + next_month + "-" + next_date);//为租车结束时间赋值（即为开始日期）
				rentCarTimeLimit(dateCheckInId,dateText);//刷新开始日期、结束日期联动时间下拉框数据源
			}
			$("#" + dateCheckInId).attr("title", $("#" + dateCheckInId).val());
			$("#" + dateCheckOutId).attr("title", $("#" + dateCheckOutId).val());
		}
	});
	var check_out_date = null;
	var check_in_date = null;
	if($(".amap_maps").length >= 1 || $(".map_unfold").length >= 1){
	    check_in_date = initCriteria.checkin;
	} else {
		check_in_date = $("#" + dateCheckInId).val();
	}
	
	if (check_in_date == null || check_in_date == ""){
		if (dateCheckOutId == "endDate"){
			check_out_date = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		} else {
			check_out_date = new Date(today.getFullYear(), today.getMonth(), today.getDate()+1);
		}
	} else {
		if (dateCheckOutId == "travel_check_out"){
			if (check_in_date == "YYYY-MM-DD"){
				check_out_date = new Date(today.getFullYear(), today.getMonth(), today.getDate()+1);
			} else {
				check_out_date = new Date(getTimeByDateStr(check_in_date)+1*24*60*60*1000);
			}
		} else{
			check_out_date = new Date(getTimeByDateStr(check_in_date)+1*24*60*60*1000);
		}
		if (dateCheckOutId == "endDate"){check_out_date = new Date(getTimeByDateStr(check_in_date));}
	}
	$("#" + dateCheckOutId).datepicker({
		minDate: check_out_date,
		numberOfMonths: 2,
		changeMonth: false,
		changeYear: false,
		beforeShow: function () {
			setTimeout(
				function () {
					$('#ui-datepicker-div').css("z-index", 9999);
				}
			);
		},
		onSelect:function(dateText, inst){
			$("#" + dateCheckOutId).css("color", "#333");
			$("#" + dateCheckOutId).attr("title", $("#" + dateCheckOutId).val());
			if (dateCheckOutId == "endDate"){rentCarTimeLimit(dateCheckOutId,dateText);}//若为租车日历控件，刷新开始日期、结束日期联动时间下拉框数据源
		}
	});
}
//绑定独立日期控件规则
function bindIndependentDatePicker(id, rule){
	var today = new Date();
	today = new Date(today.getFullYear(), today.getMonth(), today.getDate()+rule);
	$("#" + id).datepicker({
	    minDate: today,
	    maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 90),
		numberOfMonths: 2,
		changeMonth: false,
		changeYear: false,
		beforeShow: function () {
			setTimeout(
				function () {
					$('#ui-datepicker-div').css("z-index", 9999);
				}
			);
		},
		onSelect:function(dateText, inst){
			$("#" + id).attr("title", $("#" + id).val());
			rentCarTimeLimit(id,dateText);//刷新开始日期、结束日期联动时间下拉框数据源
		}
	});
}
//刷新开始日期、结束日期联动时间下拉框数据源
function rentCarTimeLimit(id,dateText){
	var server_date = getTimeByDateStr($("#server_time").val().split(" ")[0]);
	var seloected_date = getTimeByDateStr(dateText);
	var interval_days = (seloected_date - server_date)/(24*60*60*1000);
	var time_val = $("#server_time").val().split(" ")[1];
	var hour_val = time_val.split(":")[0];
	var min_val = time_val.split(":")[1];
	var new_resource = "";
	if (interval_days == 2){
		if (min_val >= 30){
			hour_val = parseInt(hour_val) + 1;
			new_resource = loopTimeArray(hour_val);
		} else {
			new_resource = loopTimeHalfArray(hour_val);
		}
		
		var end_date_new_resource = "";
		if (id == "startDate"){
			end_date_new_resource = new_resource.substring(6);
			appendSelectIntoHtml("endDate",end_date_new_resource);
		}
		if (id == "endDate"){
			var start_time_value = $("#startDate").next().find(".CRselectValue").html();
			if (parseInt(start_time_value.split(":")[1]) >= 30){
				end_date_new_resource = loopTimeArray(parseInt(start_time_value.split(":")[0]) + 1);
			} else {
				end_date_new_resource = loopTimeHalfArray(parseInt(start_time_value.split(":")[0]));
			}
			appendSelectIntoHtml("endDate",end_date_new_resource);
		} else {
			appendSelectIntoHtml(id,new_resource);
		}
	} else {
		new_resource = loopTimeArray(0);
		if (id == "startDate"){
			appendSelectIntoHtml("endDate",new_resource);
		}
		appendSelectIntoHtml(id,new_resource);
	}
	
}
//循环时间下拉框array准点
function loopTimeArray(startHour){
	var new_resource = "";
	for ( var i = startHour; i < 24; i++){
		if (i < 10){
			new_resource = new_resource + "0" + i + ":00,0" + i + ":30,";
		} else {
			new_resource = new_resource + i + ":00," + i + ":30,";
		}
	}
	return new_resource;
}
//循环时间下拉框array半点
function loopTimeHalfArray(startHour){
	var new_resource = "";
	for ( var i = startHour; i < 24; i++){
		if (i < 10){
			new_resource = new_resource + "0" + i + ":30,0" + (i+1) + ":00,";
		} else if (i == 23){
			new_resource = new_resource + i + ":30,";
		} else {
			new_resource = new_resource + i + ":30," + (parseInt(i)+1) + ":00,";
		}
	}
	return new_resource
}
//重新加载select中list源
function reloadSelectionResource(dataResource,id){
	var data_resource_arr = dataResource.split(",");
	var select_id = "";
	if (id == "startDate"){
		select_id = "car_rent_check_in_time_selection";
	} else if (id == "endDate"){
		select_id = "common_car_rent_check_in_time_selection";
	} else if (id == "TransportTime"){
		select_id = "common_car_rent_check_out_time_selection";
	}
	var new_dom = "<select name='car_rent_check_in_time_selection' id='" + select_id + "'>";
	for ( var i = 0; i < data_resource_arr.length-1; i++){
		new_dom += "<option value='" + i + "'>" + data_resource_arr[i] + "</option>"
	}
	new_dom += "</select>"
	return new_dom;
}
//将节点插入页面
function appendSelectIntoHtml(id,new_resource){
	$("#" + id).next().remove();
	$("#" + id).parent().append(reloadSelectionResource(new_resource,id));
	var select_id = "";
	if (id == "startDate"){
		select_id = "car_rent_check_in_time_selection";
	} else if (id == "endDate"){
		select_id = "common_car_rent_check_in_time_selection";
	} else if (id == "TransportTime"){
		select_id = "common_car_rent_check_out_time_selection";
	}
	$("#" + select_id).CRselectBox();
	$(".CRselectBoxItem").hover(function(){
		$(this).css("background-color", "#333");
		$(this).find("a").css("color", "#fff");
	}, function(){
		$(this).css("background-color", "#fff");
		$(this).find("a").css("color", "#333");
	});
}
//获取当前日期的毫秒数
function getTimeByDateStr(dateStr){
    var year = parseInt(dateStr.substring(0,4));
    var month = parseInt(dateStr.substring(5,7),10)-1;
    var day = parseInt(dateStr.substring(8,10),10);
    return new Date(year, month, day).getTime();
}
//添加旅游2级导航
function appendTravelSecondNavigation(travel_brand_dom){
	var second_navigation_dom = "<div class='second_nav_box'>"
									+ "<div class='second_nav_content_box'>"
										+ "<div class='" + travel_brand_dom + "'>"
											+ "<ul>"
												+ "<li id='travrl_home' class='second_nav_li_unit unit_selected'>旅游首页</li>"
												+ "<li id='aboard_travel' class='second_nav_li_unit'>出境游</li>"
												+ "<li id='cruise_island' class='second_nav_li_unit'>邮轮/海岛</li>"
												+ "<li id='domestic_travel' class='second_nav_li_unit'>国内游</li>"
												+ "<li id='around_travel' class='second_nav_li_unit'>周边游</li>"
												+ "<li id='free_travel' class='second_nav_li_unit'>自由行</li>"
												+ "<li id='visa' class='second_nav_li_unit'>签证</li>"
												+ "<li id='custom_make' class='second_nav_li_unit'>定制游</li>"
											+ "<ul>"
										+ "</div>"
									+ "</div>"
								+ "</div>";
	$(".header").after(second_navigation_dom);
	secondNavListClickEvents();
}
//添加租车2级导航
function appendRentAutomobileSecondNavigation(rent_brand_dom){
	var second_navigation_dom = "<div class='second_nav_box'>"
									+ "<div class='second_nav_content_box'>"
										+ "<div class='" + rent_brand_dom + "'>"
											+ "<ul>"
												+ "<li id='chauffeur_drive' class='second_nav_li_unit unit_selected'>代驾租车</li>"
												+ "<li id='self_drive' class='second_nav_li_unit'>自驾租车</li>"
											+ "<ul>"
										+ "</div>"
									+ "</div>"
								+ "</div>";
	$(".header").after(second_navigation_dom);
	secondNavListClickEvents();
}
//2级导航li切换样式
function secondNavListClickEvents(){
	$(".second_nav_li_unit").bind("click", function(){
		$(".unit_selected").removeClass("unit_selected");
		$(this).addClass("unit_selected");
	});
}
//生成input自动补全框
function createInputAutoCompleteDom(){
	var input_auto_complet_dom = "<ul id='input_auto_complete_box'></ul>";
	$("body").append(input_auto_complet_dom);
}
//为input自动补全框添加内容、确定位置、添加选择事件(inputId:输入框的id;autoCompleteContent:自动补全内容)
function addAutoCompleteContent(inputId, autoCompleteContent, onItemSelected){
	$("#input_auto_complete_box li").remove();
	$("#input_auto_complete_box").append(autoCompleteContent);
	$("#input_auto_complete_box").css("top", ($("#" + inputId).offset().top + 26));
	$("#input_auto_complete_box").css("left", ($("#" + inputId).offset().left));
	$("#input_auto_complete_box").show();
	$("#" + inputId).blur(function(){
		$("#input_auto_complete_box").hide();
	});
	$("#input_auto_complete_box li").bind("mousedown",function(){
		$("#" + inputId).val($(this).find("b").text());
		$("#input_auto_complete_box").hide();

		if (onItemSelected != null && onItemSelected != undefined) {
		    onItemSelected(this, inputId);
		}
	});
}
//动态添加滚动条方法
function addScrollBar(parentId, contentId, contentHeight){
	$("#scrollBox_" + parentId).remove();
	$("#" + contentId).css("top", 0);
	if ($("#" + contentId).height() > contentHeight){
		new addScroll(parentId, contentId, 'scrollDiv');
		$("#scrollBox_" + parentId).hide();
		$("#" + parentId).mouseover(function(){
			$("#scrollBox_" + parentId).show(); 
		}).mouseout(function () { 
			$("#scrollBox_" + parentId).hide();
		});
	}
}
//添加固定滚动条方法
function addFixedScrollBar(parentId,contentId ){
	new addScroll(parentId, contentId, 'scrollDiv');
	$("#scrollBox_" + parentId).hide(); 
	$("#" + parentId).mouseover(function () { 
		$("#scrollBox_" + parentId).show(); 
	}).mouseout(function () { 
		$("#scrollBox_" + parentId).hide(); 
	}); 
}
//等待弹框
function loadWaitingPopup(){
	var loadWaitingPopupBox = $.layer({
		type: 1,
		title: false,
		area: ['274px', '106px'],
		border: [4, 0.6, '#000', true], //去掉默认边框
		shade: [0.4, '#000'], //去掉遮罩
		closeBtn: [0, false], //去掉默认关闭按钮
		shift: 'left', //从左动画弹出
		page: {
		    html: "<div class=\"load_waiting_icon\"><span>正在为您加载页面...</span></div>"
		}
	});
	//重定位弹出框水平位置
	$(".xubox_layer").css("margin-left", "-40px");
	$(".xubox_layer").css("top", "50%");

	if ($("html").attr("lang") == "en") {
	    $(".load_waiting_icon").find("span").html("loading...");
	}
	if ($("html").attr("lang") == "ja-JP") {
	    $(".load_waiting_icon").find("span").html("loading...");
	}


	//透明边框
	//$(".xubox_border").css({"width" : 88 , "height" : 88 });
	//绑定关闭事件
 	return loadWaitingPopupBox;
}
//错误提示弹框
function errorAlertPopup(highLightText, errorText){
	var error_alert_popup = $.layer({
		type: 1,
		title: false,
		area: ['348px', '190px'],
		border: [4, 0.6, '#000', true], //去掉默认边框
		shade: [0.4, '#000'], //去掉遮罩
		closeBtn: [0, false], //去掉默认关闭按钮
		shift: 'left', //从左动画弹出
		page: {
				html: "<div class='error_alert_box clearfix'>"
							+ "<div class='head_box clearfix'><div class='caution_head_text'>锦江国际提示</div><a class='close_btn'></a></div>"
							+ "<div class='caution_content_box'>"
								+ "<div class='alarm_text yahei'>" + highLightText + "</div>"
								+ "<span class='caution_text'>" + errorText + "</span>"
							+ "</div>"
							+ "<div class='confirm_btn clearfix'>确定</div>"
						+"</div>"
		}
	});
	
	//重定位弹出框水平位置
	$(".error_alert_box").parent().parent().parent().parent().css("margin-left", "-349px");
	//透明边框
	$(".xubox_border").css({"width" : 356 , "height" : 198 });
	//绑定关闭按钮事件
	$('.error_alert_box .close_btn,.error_alert_box .confirm_btn').bind('click', function(){
		layer.close(error_alert_popup);
	});
}
//初始化时，为input赋title值
function valueInputTitle() {
    var input_doms = $("input");
    for (var i = 0; i < input_doms.length; i++) {
        if ($($("input")[i]).attr("type") == "text") {
            if ($($("input")[i]).val().trim() != null || $($("input")[i]).val().trim() != "") {
                $($("input")[i]).attr("title", $($("input")[i]).val().trim());
            }
        }
    }
}
//清除已有弹出层
function clearPopupLayer(){
	$(".xubox_shade").remove();
	$(".xubox_layer").remove();
}
//check按钮事件
function bindCheckBtnEvents(){
	$(".check_btn").bind("click",function(){
		var check_value = $(this).attr("value");
		if (check_value == "unchecked"){
			$(this).attr("value", "checked");
			$(this).addClass("checked");
		} else {
			$(this).attr("value", "unchecked");
			$(this).removeClass("checked");
		}
	});
}	
//字符串时间转date对象
function stringToDate(timeString){
	var year = timeString.substring(0,4);
	var month = timeString.substring(5,7);
	var day = timeString.substring(8,10);
	var hour = timeString.substring(11,13);
	var minute = timeString.substring(14,16);
	var second = timeString.substring(17,19);
	return new Date(year,parseInt(month - 1),day,hour,minute,second);
}


