$(function () {
    //礼包气泡
    $(".libao .gift").popTip({
        texttip: 'jjui_poptext',
        width: '252',
        maxwidth: 252,
        left: 0,
        positionleft: 232
    });
    //发票信息
    if ($("#orderType").val() == "SCOREandMONEY") {
        $(".invoiceCase").show();
    }
    $('.line-under').hover(function () {
        $('.scan-code-tip').show();
    }, function () {
        $('.scan-code-tip').hide();
    });
    //取消险选择
    $(".safeTable").find(".safeTableMain").click(function () {
        $(this).toggleClass("safeChecked");
        //不选择取消险
        if ($(this).hasClass("safeChecked") == false) {
            $("#safeMoney").hide();
            if ($("#orderType").val() != "SCOREandMONEY") {
                $(".invoiceCase").hide();
            }
            $(".tipText").eq(1).hide();
            $(".tipText").eq(0).hide();

            if (nd_order.paymenting) {
                if (!$("#PAYMENTING").hasClass("radio")) $("#PAYMENTING").addClass("radio");
                $("#PAYMENTING").bind("click", function () {
                    orderMemberUtil.PaymentClick(this);
                });
                $(".invoiceCase").hide();
            }

        } else {
            //选择取消险
            $("#safeMoney").show();
            //$(".invoiceCase").show();选择取消险，不再显示发票信息 2016-07-05
            $(".ruzhuName").slideDown();
            $(".ruzhuBox .tip").addClass("tip_on");
            if ($("input[name='chinese_name_1']").eq(0).val().trim().length > 0) {
                $(".tipText").eq(1).show();
            }
            else {
                $(".tipText").eq(1).hide();
                $(".tipText").eq(0).show();
            }

            //if (!$(".ruzhuBox .tip").hasClass("tip_on")) $(".ruzhuBox .tip").click();

            if ($("#PAYMENTING").hasClass("on")) {
                $(".payway li.radio").eq(1).click();
            }
        }

        nd_order.UpdateCoupon();

    });



    /*
	Author: stan gao;
	Date: 2015-10-29;
	Descript: 水印控件。
	使用说明：参数设置初始颜色和输入文字颜色
	*/

    (function oWaterMarkEvents(initialColor, focusColor) {//initialColor:初始色值；focusColor：输入后色值。

        $("input").each(function () {//遍历input标签
            if (undefined != $(this).attr("waterPrintText")) {//判定input是否需要水印
                if ($(this).attr("type") == "text") {//判定是否为文本输入框
                    oTextWaterMarkEvents($(this), initialColor, focusColor);
                } else if ($(this).attr("type") == "password") {//判定是否为密码输入框
                    oPasswordWaterMarkEvents($(this), initialColor, focusColor);
                }
            }
        });
        $("textarea").each(function () {//遍历textarea标签
            if (undefined != $(this).attr("waterPrintText")) {//判定textarea是否需要水印
                oTextareaWaterMarkEvents($(this), initialColor, focusColor);
            }
        });
    })("#dedede", "#777")//参数设置初始颜色和输入文字颜色


    $(".invoice b").click(function () {
        $(this).toggleClass("on");
        $(".invoiceBox").slideToggle();
    });
    //if ($("#orderType").val() != "SCOREandMONEY") $(".invoice").hide();
    //if ($("#PromotionType").val() == "JJINN_TJ" || $("#PromotionType").val() == "JJINN_BY" || $("#PromotionType").val() == "JJINN_BJ") {
    //    $(".special_room").show();
    //}
    if (!CanUseCoupon($("#PromotionType").val())) {
        $(".special_room").show();
    }
    //98元房时
    if ($("#PromotionType").val() == "JJINN_98") {
        //“入住人信息与联系人相同”，复选框不可点
        $(".ruzhuBox .tip").addClass("tip_noClick");
        //下拉框不可点
        $(".yhjBox span").eq(1).unbind("click");
        //下拉框底色变灰
        $(".yhjBox .sel").eq(0).css("background-color", "#ededed");
    }

    //房间数与入住姓名;98元房时，不可点
    if ($(".ruzhuBox").length > 0 && $("#PromotionType").val() != "JJINN_98") {
        $(".ruzhuBox .tip").click(function () {
            $(this).toggleClass("tip_on");
            $(".nameBox .w168").toggleClass("cyInput");

            if ($(".safeTable").find(".safeTableMain").hasClass("safeChecked") == false || $("input[name='chinese_name_1']").eq(0).val().trim().length > 0) {
                $(".tipText").eq(0).hide();
            }
            else {
                $(".tipText").eq(0).show();
                $(".tipText").eq(1).hide();
            }
            $(this).parents(".ruzhuBox").find(".ruzhuName").slideToggle();

        });
        $(".s2 .selBox li").click(function () {
            var num = $(this).attr("title");
            if (num == 2) {
                $(".ruzhuName .nameList").hide();
                $(".ruzhuName .nameList").eq(0).show();
                $(".ruzhuName .nameList").eq(1).show();
                $(".ruzhuName .nameList").eq(1).find(".cyInput").attr("data-rule", 'required;chinesename;');
                $(".nums").html("2");
            } else if (num == 3) {
                $(".ruzhuName .nameList").show();
                $(".ruzhuName .nameList").eq(2).find(".cyInput").attr("data-rule", 'required;chinesename;');
                $(".ruzhuName .nameList").eq(1).find(".cyInput").attr("data-rule", 'required;chinesename;');
                $(".nums").html("3");
            } else {
                $(".ruzhuName .nameList").hide().eq(0).show();
                $(".ruzhuName .nameList").find(".other").removeAttr("data-rule");
                $(".nums").html("1");

            }
            nd_order.updateOrderPrice();

        });
    }

    $(".smoke b").click(function () {
        $(this).toggleClass("on");
    });


    //右框滚动悬浮
    if ($(".orderinfo").length > 0) {
        $(window).scroll(function () {
            var st = $(document).scrollTop();
            var top = $(".top_nav").height() + 31;
            if ($.browser.msie && $.browser.version <= 7) {
                var pageHeight = $(document).outerHeight(true) - $(".orderinfo").outerHeight(true) - 298;
            } else {
                var pageHeight = $(document).outerHeight(true) - $(".orderinfo").outerHeight(true) - 248;
            }

            if (st > top) {
                $('.orderinfo').addClass("fixedside");
            } else {
                $('.orderinfo').removeClass("fixedside");
            }
            if (st > pageHeight) {
                if ($.browser.msie && $.browser.version <= 7) {
                    $('.orderinfo').css({ position: "relative", top: pageHeight - 91 })
                } else {
                    $('.orderinfo').css({ position: "relative", top: pageHeight - 95 })
                }

            } else {
                $('.orderinfo').css({ position: "", top: "" })
            }
        });
    }

    //取消险选择
    if ($(".safeBox").length > 0) {
        $(".safeBox .safeTip .tipCheck").click(function () {
            $(this).toggleClass("tipChecked");
        });
    }


    //取消险费用事件
    $(".tipCheck").bind("click", function () {
        //var original_sum = parseInt($("#tipCheck").text());//原有总金额
        //var cancel_insurance_fee = parseInt($(".insurance_price_text b").text());//取消险金额
        //var reception_payment_fee = parseInt($(".pay_requirement .reception_payment").text().substring(1));//原前台支付金额

        if ($(".tipCheck").attr("class").indexOf("tipChecked") > 0) {
            $("#safePrice").show();
            if (!$(".ruzhuBox .tip").hasClass("tip_on")) $(".ruzhuBox .tip").click();
            if ($("#PAYMENTING").hasClass("on")) {

                $(".payway li.radio").eq(1).click();

            }
            $(".invoice").show();
            //总金额,前台支付联动
            //$(".pay_requirement .reception_payment").text("￥" + (reception_payment_fee + cancel_insurance_fee));
            //$(".sum_fee_text").text(original_sum + cancel_insurance_fee);
        } else {
            $("#safePrice").hide();

            //总金额前台支付联动
            //$(".pay_requirement .reception_payment").text("￥" + (reception_payment_fee - cancel_insurance_fee));
            //$(".sum_fee_text").text(original_sum - cancel_insurance_fee);
            if (nd_order.paymenting) {
                if (!$("#PAYMENTING").hasClass("radio")) $("#PAYMENTING").addClass("radio");
                $("#PAYMENTING").bind("click", function () {
                    orderMemberUtil.PaymentClick(this);
                });
                $(".invoice").hide();

            }

        }
        nd_order.UpdateCoupon();

    });

    var innerHtml = $(".insurance_inner").html();//add

    //取消险说明弹框
    $("#A1").bind("click", function () {
        $(".insurance_inner").remove();//add
        insuranceExplanationBox(innerHtml);//add
        //滚动条样式 
        new addScroll('insuranceBox', 'insuranceContent', 'scrollDiv');
        $("#scrollBox_insuranceBox").hide();
        $("#insuranceBox").mouseover(function () {
            $("#scrollBox_insuranceBox").show();
        }).mouseout(function () {
            $("#scrollBox_insuranceBox").hide();
        });
    })

    function inns98() {
        var inns98PopupBox = $.layer({
            type: 1,
            title: false,
            area: ['400px', '196px'],
            border: [0], //去掉默认边框
            shade: [0.4, '#000'], //去掉遮罩
            closeBtn: [0, false], //去掉默认关闭按钮
            shift: 'left', //从左动画弹出
            page: {
                html: "<div class='insurance_popup_box'>"
						  + "<div class='popup_title_box clearfix' style='height:22px'>"
						      + "<div class='popup_title_text' style='color: #333;float: left;font-family: microsoft yahei;font-size: 16px;font-weight: normal;'>锦江旅行家提示</div>"
							  + "<div class='popup_close_btn'></div>"
						  + "</div>"
						  + "<div>"
									+ "<p style=\"font-size: 14px; font-family: microsoft yahei; padding: 40px 30px; height: 70px;text-align:center;\">您还未具备预订98元特价房的权益,<br>暂时无法预订98元特价房.</p>"
									+ "<div><a href='http://www.jinjianginns.com/' target='_blank' style='width: 64px; height: 24px; color: rgb(255, 255, 255); line-height: 24px; display: block; background: rgb(35, 124, 214) none repeat scroll 0% 0%; text-align: center; margin-top: -46px; float: right; margin-right: 162px;'>返回首页</a></div>"
								  + "</div>"
					  + "</div>"
            }
        });

        $(".insurance_popup_box").parent().parent().parent().parent().css("margin-left", "-349px");
        $(".insurance_popup_box").parent().parent().parent().parent().css({ "margin-top": "-98px", "top": "50%" });

        $('.insurance_popup_box .popup_close_btn').on('click', function () {
            layer.close(inns98PopupBox);
        });
    }


    //取消险弹出层
    function insuranceExplanationBox(innerHtml) {
        var insuranceExplanationPopupBox = $.layer({
            type: 1,
            title: false,
            area: ['698px', '400px'],
            border: [0], //去掉默认边框
            shade: [0.4, '#000'], //去掉遮罩
            closeBtn: [0, false], //去掉默认关闭按钮
            shift: 'left', //从左动画弹出
            page: {
                html: innerHtml
            }
        });

        $(".insurance_popup_box").parent().parent().parent().parent().css("margin-left", "-349px");

        $('.insurance_popup_box .popup_close_btn').on('click', function () {
            layer.close(insuranceExplanationPopupBox);
        });
    }


    //$(".payway li.radio").click(function () {
    //    orderMemberUtil.PaymentClick(this);
    //});
    $(".payway li.radio").live("click", function () {
        orderMemberUtil.PaymentClick(this);
    });

    //$(".btnBox .tk").click(function () {
    //    $(this).toggleClass("tk_on");
    //    $(this).parent().find(".unsure").toggleClass("sure");
    //    if ($(this).hasClass("tk_on") && $(".tipbox").eq(0).is(":hidden")) {
    //        $(".btnBox").find(".notice_tip").css("display","none"); 
    //        $("#submit").bind('click', function () {
    //            orderMemberUtil.bindSubmitBtnClick();
    //        });
    //    } else{
    //        $("#submit").unbind("click");
    //        $(".btnBox").find(".unsure").click(function () {
    //            //if (!$(this).hasClass("sure")) {
    //            //    $(".btnBox").find(".notice_tip").css("display", "block");
    //            //} else {
    //            //    $(".btnBox").find(".notice_tip").css("display", "none");
    //            //}
    //        });
    //    }

    //});
    //$(".btnBox").find(".unsure").click(function () {
    //    //if(!$(this).hasClass("sure")){
    //    //    $(".btnBox").find(".notice_tip").css("display","block");
    //    //}else{
    //    //    $(".btnBox").find(".notice_tip").css("display","none");
    //    //}
    //});

    $(".btnBox .tk").click(function () {
        $(this).toggleClass("tk_on");
        $(".btnBox").find(".notice_tip").css("display", "none");
    });

    window.submitOrderForbtn = function () {
        if ($("#has98").val() == "False" && $("#PromotionType").val() == "JJINN_98") inns98();
        else orderMemberUtil.bindSubmitBtnClick();
    }

    $(".btnBox").find(".unsure").click(window.submitOrderForbtn);

    $("#imgValidate").bind("click", function () {
        orderMemberUtil.validateCode();
    });
    //点击验证码链接
    $("#newOrderChangeImage").bind("click", function () {
        orderMemberUtil.validateCode();

    });



    orderMemberUtil.validateCode();

    $(".tipInfo .btn a").eq(0).click(function () {




        $(this).hide();
        $(this).next().show();
        $(".tipInfo .txt").css({ width: "238px" }).removeClass("hidde");
    });
    $(".tipInfo .btn a").eq(1).click(function () {
        $(this).hide();
        $(this).prev().show();
        $(".tipInfo .txt").css({ width: "155px" }).addClass("hidde");
    });


    //手机选择
    $(".phoneBox .tabsInfo li").click(function () {
        var num = $(this).attr("title");
        if (num == "china") {
            $(".phoneBox .tt").show();
            $(".hw").hide();
            $(".gn").show();
            $(".phoneBox .gn").attr("data-rule", 'required;mobile;');
            $(".phoneBox .msg-box").show();
        } else {
            $(".phoneBox .tt").hide();
            $(".gn").hide();
            $(".hw").show();
            $(".phoneBox .gn").removeAttr("data-rule");
            $(".phoneBox .msg-box").hide();
        }
    });



    if ($(".hidneeddialog").val() == "F") {
        $(".hidneeddialog").val("T");
        jjDialog(".cashPage");
    }

    if ($(".cashPage").length > 0) {
        //jjDialog(".cashPage");
        //$(".cardBtn a").click(function(){
        //		jjDialog(".cardPage");	
        //});
    }

    //礼包
    if ($(".libao").length > 0) {
        var lbHeight = $(".libao .txt").height();
        if (lbHeight > 42) {
            $(".libao .txt").css({ height: "42px" });
        } else {
            $(".libao .txt").css({ height: "auto" });
            $(".libao .icon a").hide();
        }

        $(".libao .icon a").eq(0).click(function () {
            $(this).hide();
            $(this).next().show();
            $(".libao .txt").css({ height: "auto" });
        });
        $(".libao .icon a").eq(1).click(function () {
            $(this).hide();
            $(this).prev().show();
            $(".libao .txt").css({ height: "42" });
        });
    }

    //检查优惠码
    $("#coupon_input_unit ").bind("focusout", function () {
        var couponInput = $(this);
        var code = couponInput.val();
        if ($.trim(code) != "") {
            var param = {
                bookingChannel: "Website",
                bookingModule: "JJINN",
                onlinePay: true,
                orderAmount: $("#price").attr("price"),
                payAmount: $("#price").attr("price"),
                useEvent: "BOOKING",
                promotionCodes: code
            };

            $.ajax({
                type: 'POST',
                url: "/service/pomoCodeValidate",
                dataType: 'JSON',
                data: param,
                cache: false,
                success: function (responseData) {
                    var result = JSON.parse(responseData);
                    if (result.canUse) {
                        couponInput.parent().removeClass("yh_wrong");
                        if (!couponInput.parent().hasClass("yh_right")) couponInput.parent().addClass("yh_right");
                        var coupon = result.result[0];
                        couponInput.attr("data-amount", coupon.couponAmount);
                        couponInput.attr("data-name", coupon.couponRuleName);
                        couponInput.attr("data-code", coupon.promotionCode);
                    } else {
                        if (!couponInput.parent().hasClass("yh_wrong")) couponInput.parent().addClass("yh_wrong");
                        couponInput.attr("data-amount", 0);
                    }
                    nd_order.UpdateCoupon();

                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        } else {
            couponInput.parent().removeClass("yh_wrong");
        }
    });

    $("#coupon_input_unit ").bind("focusin", function () {
        var couponInput = $(this);
        couponInput.parent().removeClass("yh_wrong");

    });

    //滚动条样式
    //new addScrollBar('mainBox', 'content', 'scrollDiv');
    new addScroll('mainBox', 'content', 'scrollDiv');
    $("#scrollBox").hide();
    $("#mainBox").mouseover(function () {
        $("#scrollBox").show();
    }).mouseout(function () {
        $("#scrollBox").hide();
    });

    $("#email_address").bind("focusout", function () {
        orderMemberUtil.validateEmailOrPhone("email_address", true);
        isAllNull();
    });
    $("#cellphone_num").bind("focusout", function () {
        orderMemberUtil.validateEmailOrPhone("cellphone_num", true);
        isAllNull();
    });

    orderMemberUtil.bindCouponClick($("#select_info_coupon_type li"));

    //常用联系人
    $(".nameBox .cyInput").live("focus", function () {
        if ($(".changyong").find("a").length > 0) $(".changyong").show();
    }).blur(function () {
        setTimeout(function () {
            $(".changyong").hide();
        }, 200);
    });
    $(".nameBox .changyong p a").click(function () {
        $(".nameBox .w168").removeClass("n-invalid").val($(this).html());
        $(".nameBox").find(".msg-wrap").removeClass("n-error");
        $(".nameBox").find(".msg-wrap").addClass("n-ok");
        $(".nameBox").find(".n-msg").text("");
        $(".nameBox").find(".n-msg").hide();
    });
    //常用联系人2
    $(".nameList .cyInput").live("focus", function () {
        if ($(".changyong").find("a").length > 0) $(this).parents(".nameList").find(".changyong").show();
    }).blur(function () {
        setTimeout(function () {
            $(".changyong").hide();
        }, 200);
    });

    $(".nameList .changyong p a").click(function () {
        $(this).parents(".nameList").find(".w168").removeClass("n-invalid").val($(this).html());
        $(this).parents(".nameList").find(".msg-wrap").removeClass("n-error");
        $(this).parents(".nameList").find(".msg-wrap").addClass("n-ok");
        $(this).parents(".nameList").find(".n-msg").text("");
        $(this).parents(".nameList").find(".n-msg").hide();
    });

    //发票选择
    $(".ibTab span").click(function () {
        var tabs = $(this).parents(".ibTab").find("span");
        var index = $.inArray(this, tabs);
        tabs.removeClass("on").eq(index).addClass("on");
        if (index == 0) {
            $(".invoiceBox .title").hide();
        } else {
            $(".invoiceBox .title").show();
        }
    });

    nd_order.updateOrderPrice();
    InsuranceIsHide();

    if ($(".Insurance").is(":hidden")) {
        $(".titbox").eq(3).children(".col").html("03");
        $(".titbox").eq(4).children(".col").html("04");
    }
    else {
        $(".titbox").eq(3).children(".col").html("04");
        $(".titbox").eq(4).children(".col").html("05");
    }
});

function getCoupons() {
    var isHidden = $("#coupon_input_unit").is(":hidden") || $("#select_info_num").is(":hidden");
    if ($("#select_info_num").attr("amount") > 0 || $("#coupon_input_unit").attr("coupons") || $("#select_info_coupon_type li[title^='98元']").length > 0) {
        var coupons = $("#select_info_coupon_type").attr("coupons");
        var type = $("#select_info_coupon_type").attr("type");
        var num = $("#PromotionType").val() == "JJINN_98" ? "1" : $("#select_info_num li.sel").attr("title");
        var couponList = "";
        arr = coupons.split(",");
        if (type == "JEC") {
            for (var i = 0; i < num; i++) {
                var add = (i == 0 ? "" : ",") + arr[i];
                couponList += add + "|JEC|1";
            }
        } else if (type == "JJINN") {
            couponList = arr[0] + "|JJINN|" + num;
        }
        if ($("#coupon_input_unit").data("code")) {
            var add = (i == 0 ? "" : ",") + $("#coupon_input_unit").data("code") + "|" + $("#coupon_input_unit").data("name") + "|" + type + "|1";
            couponList += add;
        }
        return couponList;
    } else {
        $("#select_info_coupon_type").attr("type", "");
        return ""
    };
}
var isSubmit = false;
var orderMemberUtil = {

    //If User is not logged in, that will call beenRegister & simpleLogin
    beenRegistering: false,

    mcMemberCode: "",
    memberName: "",
    cardNo: "",
    cardType: "",
    load_waiting_popup: null,
    guestInput: null,
    beenRegister: function () {
        var param = {
            phone: $(".phoneBox").find("li.sel").attr("title") == "china" ? $('#cellphone_num').val() : "",
            email: $('#email_address').val(),
            memType: "TmpMem",
            registChannel: "Website",
            userName: $('#contacter_input').val()
        };
        if (orderMemberUtil.beenRegistering == false) {
            orderMemberUtil.beenRegistering = true;
            orderMemberUtil.load_waiting_popup = loadWaitingPopup();

            $.ajax({
                type: 'POST',
                url: "/service/beenRegister",
                dataType: 'JSON',
                data: param,
                cache: false,
                success: function (responseData) {
                    var result = JSON.parse(responseData);
                    //console.log(result);
                    if (result.Success && result.mcMemberCode != null && result.mcMemberCode.length > 0) {
                        orderMemberUtil.mcMemberCode = result.mcMemberCode;
                        //console.log("been Register result", result);
                        //do login
                        orderMemberUtil.simpleLogin();
                        $("#hidMemberCode").val(orderMemberUtil.mcMemberCode);
                        $("#hidMemberCardNo").val(orderMemberUtil.cardNo)
                        $("#hidMemberCardType").val(orderMemberUtil.cardType);
                        $("#hidMemberName").val(orderMemberUtil.memberName);
                    }
                    else {
                        orderMemberUtil.beenRegistering = false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log("Error:", errorThrown);
                }
            });
        }
    },
    isNeedReload: function () {
        return ($("#hidMemberCode").val() == null || $("#hidMemberCode").val() == "") && ($.cookie("memberId") != null && $.cookie("memberId") != "undefined");
    }
    ,
    bindSubmitBtnClick: function () {
        if (isSubmit) return;

        if (orderMemberUtil.isNeedReload()) {
            window.location.reload();
            return;
        }

        var code = $("#coupon_input_unit").val();
        var couponInput = $("#coupon_input_unit");

        var validateCode = true;
        if ($.trim(code) != "" && $("#hidBrand").val() == "JJHOTEL") {
            var param = {
                bookingChannel: "Website",
                bookingModule: "JJINN",
                onlinePay: true,
                orderAmount: $("#price").attr("price"),
                payAmount: $("#price").attr("price"),
                useEvent: "BOOKING",
                promotionCodes: code
            };

            $.ajax({
                type: 'POST',
                url: "/service/pomoCodeValidate",
                dataType: 'JSON',
                data: param,
                cache: false,
                success: function (responseData) {
                    var result = JSON.parse(responseData);
                    if (result.canUse) {
                        couponInput.parent().removeClass("yh_wrong");
                        if (!couponInput.parent().hasClass("yh_right")) couponInput.parent().addClass("yh_right");
                        var coupon = result.result[0];
                        couponInput.attr("data-amount", coupon.couponAmount);
                        couponInput.attr("data-name", coupon.couponRuleName);
                        couponInput.attr("data-code", coupon.promotionCode);
                    } else {
                        if (!couponInput.parent().hasClass("yh_wrong")) couponInput.parent().addClass("yh_wrong");
                        couponInput.attr("data-amount", 0);
                    }
                    nd_order.UpdateCoupon();

                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });

        } else {
            couponInput.parent().removeClass("yh_wrong");

        }
        if ($("#submit").hasClass("unsure") && $(".payway li.on").length > 0) {
            var flag = false;
            var validateInputs = $(".orderPage").find("input:visible").not(".hasDatepicker");
            validateInputs.each(function () {

                $(this).focus();
                $(this).blur();

            });
            isAllNull();
            flag = validateCode && $(".orderPage").find("input:visible.n-invalid").length == 0 && orderMemberUtil.validateEmailOrPhone("email_address", false) && orderMemberUtil.validateEmailOrPhone("cellphone_num", false) && $(".ruzhuError:visible").length == 0;


            if ($(".verification_code_box").length > 0) {
                var param = {
                    "code": $(".verification_code_input").val(),
                    "opt": 'fbcode'
                }
                $.ajax({
                    type: 'POST',
                    url: "/Handlers/RegisterHelpHandler.ashx",
                    dataType: 'text',
                    data: param,
                    cache: false,
                    success: function (data) {
                        if (data == "0") {
                            if (!$(".verification_code_box").hasClass("yh_wrong")) $(".verification_code_box").addClass("yh_wrong");
                            var error_alarm_text = "";
                            if ($("html").attr("lang") == "en") {
                                error_alarm_text = "Please enter the correct verification code";
                            } else if ($("html").attr("lang") == "ja-JP") {
                                error_alarm_text = "検証番号を正しく入力してください’";
                            } else {
                                error_alarm_text = "请输入准确的验证码";
                            }
                            $(".verification_code_box .right").hide();
                            $(".verification_code_box .wrong").html(error_alarm_text);
                            $(".verification_code_box .wrong").show();
                            orderMemberUtil.validateCode();
                        } else {
                            if (!$(".verification_code_box").hasClass("yh_right")) $(".verification_code_box").addClass("yh_right").removeClass("yh_wrong");
                            $(".verification_code_box .right").show();
                            $(".verification_code_box .wrong").hide();
                            if (flag) {
                                if ($(".safeTip .tipCheck:visible").length > 0 && $(".safeTip .tipCheck").hasClass("tipChecked")) {
                                    sureBox();//确认弹出框
                                    $('.sure_btn').on('click', function () {
                                        var isLoggedIn = ($.cookie("memberId") != null && $.cookie("memberId") != "undefined");
                                        if (!$(".btnBox .tk").hasClass("tk_on")) {
                                            $(".btnBox").find(".notice_tip").css("display", "block");
                                        } else {
                                            $(".btnBox").find(".notice_tip").css("display", "none");
                                            if (!isLoggedIn && $("#ECId").val() == "") {
                                                orderMemberUtil.beenRegister();
                                                return;
                                            } else {
                                                orderMemberUtil.submitOrder();
                                            }
                                        }
                                    });

                                } else {
                                    var isLoggedIn = ($.cookie("memberId") != null && $.cookie("memberId") != "undefined");
                                    if (!$(".btnBox .tk").hasClass("tk_on")) {
                                        $(".btnBox").find(".notice_tip").css("display", "block");
                                    } else {
                                        $(".btnBox").find(".notice_tip").css("display", "none");
                                        if (!isLoggedIn && $("#ECId").val() == "") {
                                            orderMemberUtil.beenRegister();
                                            return;
                                        } else {
                                            orderMemberUtil.submitOrder();
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                if (flag) {
                    if ($(".safeTip .tipCheck:visible").length > 0 && $(".safeTip .tipCheck").hasClass("tipChecked")) {
                        sureBox();//确认弹出框
                        $('.sure_btn').on('click', function () {
                            var isLoggedIn = ($.cookie("memberId") != null && $.cookie("memberId") != "undefined");
                            if (!$(".btnBox .tk").hasClass("tk_on")) {
                                $(".btnBox").find(".notice_tip").css("display", "block");
                            } else {
                                $(".btnBox").find(".notice_tip").css("display", "none");
                                if (!isLoggedIn && $("#ECId").val() == "") {
                                    orderMemberUtil.beenRegister();
                                    return;

                                } else {
                                    orderMemberUtil.submitOrder();
                                }
                            }
                        });
                    } else {
                        var isLoggedIn = ($.cookie("memberId") != null && $.cookie("memberId") != "undefined");
                        if (!$(".btnBox .tk").hasClass("tk_on")) {
                            $(".btnBox").find(".notice_tip").css("display", "block");
                        } else {
                            $(".btnBox").find(".notice_tip").css("display", "none");
                            if (!isLoggedIn && $("#ECId").val() == "") {
                                orderMemberUtil.beenRegister();
                                return;

                            } else {
                                orderMemberUtil.submitOrder();
                            }
                        }
                    }
                } else {
                    if (!flag) {
                        $(".orderPage").find(".n-invalid,.ruzhuError:visible").eq(0).focus();
                    }

                }

            }
        }
    },
    bindCouponClick: function (obj) {
        obj.click(function () {

            var coupons = $(this).attr("coupons");
            var amount = $(this).attr("amount");
            var count = $(this).attr("count");
            var type = $(this).attr("type");
            var prepaid = $("#prepaid").attr("data-prepaid") - 1;
            var orderPrice = parseInt($("#price").attr("price")) - 1;
            if ($("#GUARANTEE").hasClass("on") && $("#hidBrand").val() == "JJHOTEL") orderPrice = prepaid;
            if (orderPrice < 0) orderPrice = 0;
            var num = $(".s2 .selBox li.sel").attr("title");
            if ((amount + "") != "undefined" && amount != "0") {
                var ceilNum = Math.floor(orderPrice / parseInt(amount));
                if (ceilNum < count) count = ceilNum;
                $("#select_info_coupon_type").attr("coupons", coupons);
                $("#select_info_coupon_type").attr("type", type);
                $("#select_info_num").attr("amount", amount);
                $("#select_info_num li").remove();
                $("<li title=\"" + 1 + "\" amount=\"" + amount + "\">1</li>").appendTo("#select_info_num");
                for (var j = 2; j <= count; j++) {
                    $("<li title=\"" + j + "\" class=\"open\"  amount=\"" + amount + "\">" + j + "</li>").appendTo("#select_info_num");
                }

                var txt = $(this).html();
                $(this).parents(".select").find(".valTxt").html(txt);
                $(this).addClass("sel").siblings().removeClass("sel");
                $(this).parents(".select").find(".selBox").hide();
                $(".yhjBox .yh").eq(1).show();
            } else {
                var txt = $(this).html();
                $(this).parents(".select").find(".valTxt").html(txt);
                $(this).addClass("sel").siblings().removeClass("sel");
                $(this).parents(".select").find(".selBox").hide();
                $("#select_info_num").attr("amount", 0);
                $("#select_info_num").attr("firstamount", "0");
                $("#select_info_num li").remove();
                $("<li class=\"sel\" amount=\"0\">无</li>").appendTo("#select_info_num");
                $(".yhjBox .yh").eq(1).hide();
            }
            $("#select_info_num li").click(function () {
                if ($(this).attr("amount") == "0") {
                    $("#select_info_num").attr("amount", "0");
                    $("#select_info_num").attr("firstamount", "0");
                }
                else {
                    var num = $(".s2 .selBox li.sel").attr("title");
                    num = Math.min(parseInt(num), $(this).attr("title"));
                    $("#select_info_num").attr("amount", $(this).attr("amount") * $(this).attr("title"));
                    $("#select_info_num").attr("firstamount", $(this).attr("amount") * num);

                }
                var txt = $(this).html();
                $(this).parents(".select").find(".valTxt").html(txt);
                $(this).addClass("sel").siblings().removeClass("sel");
                $(this).parents(".select").find(".selBox").hide();
                nd_order.UpdateCoupon();
            });
            $("#select_info_num li").eq(0).click();


        });
    },
    dropDownCoupons: function (type) {
        var length = 0;
        var valTxt = $("#select_info_coupon_type").parent().find(".valTxt");
        if (type == "JJINN") length = $("#select_info_coupon_type li[type='JJINN']").length;
        else length = $("#select_info_coupon_type li").length;
        if (length > 0) {
            $(".yhjBox .yh").eq(1).show();
            var first = $("#select_info_coupon_type li").eq(0);
            first.attr("title", $("#selectCouponText").val());
            first.html($("#selectCouponText").val());
            valTxt.click(function () {
                $(".select .selBox").hide();
                $(this).parents(".select").find(".selBox").slideToggle();
            });
        }
        else {
            var first = $("#select_info_coupon_type li").eq(0);
            first.attr("title", $("#nonCouponText").val());
            first.html($("#nonCouponText").val());
            valTxt.html($("#nonCouponText").val());
            valTxt.unbind("click");
            $(".yhjBox .yh").eq(1).hide();
        }
    },
    ChangeCoupons: function (type) {
        if (type == "JJINN") {
            $("#select_info_coupon_type li[type='JEC']").hide();
            orderMemberUtil.dropDownCoupons(type);
            $("#select_info_coupon_type li").eq(0).click();
            nd_order.UpdateCoupon();
        }
        if (type == "JEC") {
            $("#select_info_coupon_type li[type='JEC']").show();
            orderMemberUtil.dropDownCoupons(type);
            $("#select_info_coupon_type li").eq(0).click();
            nd_order.UpdateCoupon();
        }
    },
    simpleLogin: function () {
        var data = "memberCode=" + orderMemberUtil.mcMemberCode + "&callback=?"

        $.ajax({
            type: "get",
            url: $("#hidLoginUrl").val(),
            dataType: "jsonp",
            jsonp: "callback",
            data: data,
            success: function (result) {

                //console.log("new member Id", orderMemberUtil.mcMemberCode);
                //console.log("simple login result", result);

                if (result != null && result.Success) {
                    if (result.id != null && result.id.length > 0) {
                        //console.log("memberId", result.id);
                        $.cookie("memberId", result.id, { expires: 1 })
                    }
                    if (result.cdsId != null && result.cdsId.length > 0) {
                        $("#cdsId").val(result.cdsId);
                    }
                    //console.log("cardNo", result.cardNo);
                    //console.log("cardType", result.cardType);
                    orderMemberUtil.cardNo = result.cardNo;
                    orderMemberUtil.cardType = result.cardType;
                    orderMemberUtil.memberName = result.memberName;
                    orderMemberUtil.submitOrder();
                    //TODO: Continue submit order
                } else {
                    orderMemberUtil.beenRegistering = false;
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log("Login Error:", textStatus, errorThrown);
            }
        });
    },

    submitOrder: function () {
        var latestArrvialTime = $("#select_info_time").find("li[class='sel']").attr("endtime");
        var param = {
            language: $('#contextLanguage').val(),
            adultNum: $('#adultNum').val(),
            jjOrderType: $(".payway li.on").attr("id"),
            cntEmail: $('#email_address').val(),
            cntMobil: $(".phoneBox").find("li.sel").attr("title") == "china" ? $('#cellphone_num').val() : $('#cellphone_num1').val(),
            cntPhone: $('#phone_num').val(),
            cntName: $('#contacter_input').val(),
            mebCardNo: $('#hidMemberCardNo').val(),
            mcMemberCode: $('#hidMemberCode').val(),
            mebName: $('#hidMemberName').val(),
            mebCardType: $('#hidMemberCardType').val(),
            planId: $('#planId').val(),
            checkin: $(".yudingbox").find('input.dateCheckIn').val(),      //"2015-01-22",
            checkout: $(".yudingbox").find('input.dateCheckOut').val(),
            roomNum: $('.roomNum').find("li[class='sel']").attr("title"),
            latestArrvialTime: latestArrvialTime,
            isNeedCancelInsurance: $(".Insurance").is(":visible") && $(".safeTable").find(".safeTableMain").hasClass("safeChecked"),
            specialNeeds: orderMemberUtil.getSpeicalNeeds(),
            remark: $('#memo_textarea').val(),
            guests: orderMemberUtil.getGuestsValue(),        //"Mike|&|Jack|&|Elen|&|Doris"
            isNeedInvoice: $(".invoiceBox:visible").length > 0 ? $('.invoice b').hasClass('on') : "",
            invoiceTitle: $(".invoiceBox:visible").length > 0 ? $('.invoice_title').val() == "" ? "个人" : $('.invoice_title').val() : "个人",
            invoiceType: $(".invoiceBox:visible").length > 0 ? $('.invoice_content .valTxt').html() : "",
            invoiceConsignee: $(".invoiceBox:visible").length > 0 ? $('#invoice_contact_name').val() : "",
            invoicetxtPhone: $(".invoiceBox:visible").length > 0 ? $('#invoice_contact_mobile').val() : "",
            invoiceMailAddress: $(".invoiceBox:visible").length > 0 ? $('#detailed_adivress_input').val() : "",   //$('.province_input').val()
            invoiceProvince: $(".invoiceBox:visible").length > 0 ? $('.province_input').val() : "",
            invoiceCity: $(".invoiceBox:visible").length > 0 ? $('.city_input').val() : "",
            invoiceZipCode: $(".invoiceBox:visible").length > 0 ? $('#invoice_contact_zipcode').val() : "",
            isNeedInsure: $('.insurance_content_box').hasClass('checked'),
            coupons: getCoupons(),
            couponAmount: $("#coupon").data("coupon"),
            orderOrigin: $('#onlineAdQunar').val(),
            channleCode: $('#channelCodeHide').val(),
            enterpriseCustomerCode: $("#ECcode").val(),
            enterpriseCustomerId: $("#ECId").val(),
            cdsId: $("#cdsId").val(),
            orderSourceCode: $("#hidSid").val()
        };

        try {
            var bigDataObj = {
                page: 'new order'
                , data: {
                    hotelId: $("#hotelId").val()
                    , planId: $('#planId').val()
                    , checkInDate: $(".yudingbox").find('input.dateCheckIn').val()
                    , checkOutDate: $(".yudingbox").find('input.dateCheckOut').val()
                    , roomName: $("#RoomName").val()
                    , roomNum: $('.roomNum').find("li[class='sel']").attr("title")
                    , rateCode: $("#rateCode").val()
                    , contactEmail: $('#email_address').val()					//联系人邮件
                    , contactMobile: $('#cellphone_num').val()					//联系人手机
                    , contactPhone: $(".phoneBox").find("li.sel").attr("title") == "china" ? $('#cellphone_num').val() : $('#cellphone_num1').val()					//联系人电话
                    , contactName: $('#contacter_input').val()					//联系人姓名
                    , guests: $("#adultNum").val()	//因为现在页面没有adultNum、入住人数，可以从这里获取入住人数或者adultNum
                    , htmlRemark: $('#memo_textarea').val()				//用户特殊需求与备注
                    , couponType: $(".yhjBox").find(".valTxt").eq(0).html()				//优惠券
                    , couponNum: $(".yhjBox").find(".valTxt").eq(1).html()					//优惠券数量
                    , couponID: $("#coupon_input_unit").val()						//优惠码
                    , arrivalTime: latestArrvialTime
                }
            };

            $('#big-data-json').val(JSON.stringify(bigDataObj));
            bigdataPageView.postData();

        }
        catch (ex) { }
        if (orderMemberUtil.load_waiting_popup == null) orderMemberUtil.load_waiting_popup = loadWaitingPopup();

        this.AddContact(param);
        $.ajax({
            type: 'POST',
            url: "/service/bookHotel",
            dataType: 'JSON',
            data: param,
            cache: false,
            success: function (responseData) {
                var result = JSON.parse(responseData);
                if (result.Success) {

                    var orderCode = result.OrderNo;
                    if (!!orderCode) {
                        var hotelcode = $("#HotelCodeHide").val();
                        var channelCode = $("#channelCode").val();
                        var channelSite = $("#channelSiteHide").val();
                        var currencyType = $("#currencyType").val();
                        if (param.jjOrderType == "PAYMENTING") window.location.href = '/OrderSucceed?orderNo=' + orderCode + '&hotelcode=' + hotelcode + '&channelCode=' + channelCode + '&channelSite=' + channelSite;
                        else window.location.href = '/Payment?orderNo=' + orderCode + '&hotelcode=' + hotelcode + '&channelCode=' + channelCode + '&channelSite=' + channelSite + '&currencyType=' + currencyType;
                    }
                    else {
                        $.cookie('errMsg', result.Message);
                        window.location.href = '/OrderFail';
                    }

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                window.setTimeout(function () {
                    layer.close(orderMemberUtil.load_waiting_popup);
                }, 2000);
            }
        });

    },
    AddContact: function (param) {
        $.ajax({
            type: 'POST',
            url: "/service/AddContact",
            dataType: 'JSON',
            data: param,
            cache: false,
            success: function (responseData) {
                //console.log()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                window.setTimeout(function () {
                    layer.close(orderMemberUtil.load_waiting_popup);
                }, 2000);
            }
        });
    },
    getGuestsValue: function () {
        var value = "";
        var roomNo = parseInt($('.roomNum').find("li[class='sel']").attr("title"));

        if ($('.tip_on').size() == 1) {

            var guestsList = $('.nameList  input.cyInput');
            if (guestsList.length > 0) {
                for (var i = 0; i < roomNo; i++) {
                    var c = (i === 0) ? '' : '|&|';
                    value += c + guestsList[i].value;
                }
            }
        } else {
            if (roomNo == 1) {
                value = $('#contacter_input').val();
            }
            else {
                for (var i = 0; i < roomNo; i++) {
                    var c = (i === 0) ? '' : '|&|';
                    //value += c + $('#contacter_input').val() + (i + 1);
                    if (i == 0)
                    {
                        value = $('#contacter_input').val();
                    }
                    else
                    {

                        value += c + $('#contacter_input').val() + i;
                    }
                    
                }
            }
        }

        return value;
    },
    getSpeicalNeeds: function () {
        var value = "";
        var needlist = $(".ruzhuName .nameList:visible");
        for (var i = 0; i < $(".ruzhuName .nameList:visible").length; i++) {
            var c = i == 0 ? "" : ",";
            value += c + $(".smoke b").html();
        }
        return value;
    },
    validatePayType: function () {
        //if (($("#PAYMENTING").hasClass("on") || $("#orderType").val() == "SCOREandMONEY" || $("#orderType").val() == "SCORE") && $("#hidBrand").val()) {
        //$(".yh .sel").hide();
        //$(".yh .selectNone").show();
        nd_order.UpdateCoupon();
        //} else {
        //$(".yh .sel").show();
        //$(".yh .selectNone").hide();
        //nd_order.UpdateCoupon();
        //}
    },
    validateCode: function () {
        $("#imgValidate").attr("src", $("#imgValidate").length > 0 ? "/Handlers/CodeImage.aspx?" + rand(10000000) : "");
    },
    disableCouponsForBoTao: function () {
        //铂涛酒店，不能使用优惠券
        //if ($("#hidHotelBrand").val() == "PLATENO")
        //if ($("#hidHotelBrand").val() == "JJINN")
        if ($("#hidHotelBrand").val() == "PLATENO")
        {
            $(".yhjBox span").eq(1).html("无可用优惠券");
            //下拉框不可点
            $(".yhjBox span").eq(1).unbind("click");

            $("#coupon_input_unit").attr("disabled",true); 
        }
    },
    BindCoupons: function () {
        var valTxt = $("#select_info_coupon_type").parent().find(".valTxt");
        //if ($("#hidMemberCode").val() == "" || $("#PromotionType").val() == "JJINN_TJ" || $("#PromotionType").val() == "JJINN_BY" || $("#PromotionType").val() == "JJINN_BJ") {
        //    valTxt.unbind("click");
        //    isSubmit = false;
        //    return;
        //}
        if ($("#hidMemberCode").val() == "" || !CanUseCoupon($("#PromotionType").val())) {
            valTxt.unbind("click");
            isSubmit = false;
            return;
        }
        var paramJEC = {
            bookingChannel: "Website",
            bookingModule: $("#hidBrand").val() == "JJHOTEL" ? "JREZ" : "JJINN",
            memberCode: $("#hidMemberCode").val(),
            numRoomNights: $("#nights").val(),
            onlinePay: "true"
        };
        var paramJJINN = {
            endTime: $(".yudingbox").find('input.dateCheckOut').val(),
            startTime: $(".yudingbox").find('input.dateCheckIn').val(),
            language: $("#contextLanguage").val().toLowerCase() == "zh-cn" ? "ch" : "en",
            mcCode: $("#hidMemberCode").val(),
            rmTypeId: $("#roomCode").val(),
            unitId: $("#hotelCode").val(),
            ruleTypes: "",//将DEDUCE改为空，可查询全部查询类型的优惠券
            roomNum: $('.roomNum').find("li[class='sel']").attr("title")
        }
        if ($("#GUARANTEE").hasClass("on")) {
            paramJEC.payAmount = $("#prepaid").attr("data-prepaid");

        } else {
            paramJEC.payAmount = $("#price").attr("price");
        }
        var arr = [];
        $.ajax({
            type: 'POST',
            url: "service/couponRuleInfo",
            dataType: 'JSON',
            data: paramJEC,
            cache: false,
            success: function (responseData) {
                var result = JSON.parse(responseData);
                for (var i = 0; i < result.results.length; i++) {
                    var coupon = result.results[i];
                    var ele = {
                        name: $("#contextLanguage").val().toLowerCase() == "zh-cn" ? coupon.couponRuleName : (coupon.couponRuleEnName == "" ? "en_" + coupon.couponRuleName : coupon.couponRuleEnName),
                        count: coupon.couponMaxNum,
                        amount: coupon.couponAmount,
                        ruleId: coupon.ruleID,
                        type: "JEC",
                    };
                    var coupons = "";
                    for (var j = 0; j < coupon.couponCode.length; j++) {
                        coupons += (j == 0 ? "" : ",") + coupon.couponCode[j] + "|" + coupon.couponRuleName;
                    }
                    ele.coupons = coupons;
                    arr.push(ele);

                }
                if ($("#hidBrand").val() != "JJHOTEL") {
                    $.ajax({
                        type: 'POST',
                        url: "service/usableCoupon",
                        dataType: 'JSON',
                        data: paramJJINN,
                        async: false,
                        cache: false,
                        success: function (responseData) {
                            var result = JSON.parse(responseData);
                            for (var i = 0; i < result.couponList.length; i++) {
                                var coupon = result.couponList[i];

                                var ele = {
                                    name: coupon.ruleName,
                                    count: coupon.num,
                                    amount: coupon.amount,
                                    ruleId: coupon.ruleId,
                                    type: "JJINN"
                                };
                                var coupons = "";
                                for (var j = 0; j < result.couponList.length; j++) {
                                    coupons += (j == 0 ? "" : ",") + coupon.ruleId + "|" + coupon.ruleName;
                                }
                                ele.coupons = coupons;
                                if ($("#PromotionType").val() != "JJINN_98" && ele.name.indexOf("98元") >= 0)
                                    continue;
                                else
                                    arr.push(ele);

                            }


                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            isSubmit = false;
                        }
                    });
                }

                if ($("#PromotionType").val() != "JJINN_98" && $("#select_info_coupon_type li[title^='98元']").length > 0) {
                    $("#select_info_coupon_type li[title^='98元']").remove();
                }

                if (arr.length > 0) {
                    $("#select_info_coupon_type li").remove();

                    valTxt.unbind("click");
                    $("<li class=\"sel\" title='" + $("#selectCouponText").val() + "' amount='0' count='0'>" + $("#selectCouponText").val() + "</li>").appendTo("#select_info_coupon_type");
                    $("#coupon-data-template").tmpl(arr).appendTo("#select_info_coupon_type");

                    if ($("#PromotionType").val() == "JJINN_98") {
                        var $li98 = $("#select_info_coupon_type li[title^='98元']");
                        if ($("#select_info_coupon_type li").length > 0 && $li98.length > 0) {
                            //默认选择98元优惠券
                            $("#select_info_coupon_type").attr({ coupons: $li98.attr("coupons"), type: "JJINN" });
                            $(".yhjBox span").eq(1).html($li98.html());
                        }
                        else {
                            $(".yhjBox span").eq(1).html("无可用优惠券");
                        }
                        //下拉框不可点
                        $(".yhjBox span").eq(1).unbind("click");
                    }
                    else {
                        orderMemberUtil.bindCouponClick($("#select_info_coupon_type li"));
                        if ($("#PAYMENTING").hasClass("on")) orderMemberUtil.ChangeCoupons("JJINN");
                        else orderMemberUtil.ChangeCoupons("JEC");
                    }
                }
                isSubmit = false;
                //铂涛酒店能使用优惠券
                orderMemberUtil.disableCouponsForBoTao();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                isSubmit = false;
            }
        });



    },
    PaymentClick: function (obj) {
        isSubmit = true;
        if (!nd_order.arrivalMsg && $("#hidBrand").val().toLowerCase() == "jjhotel") $("#arriveTimetipMsg").hide();
        $(obj).addClass("on").siblings().removeClass("on");
        var num = $(obj).index(".payway li");
        if (num == 1) {
            //$(".yh .sel").show();
            //$(".yh .selectNone").hide();
            $(".firstNight").show();
        } else {

            //$(".yh .sel").hide();
            //$(".yh .selectNone").show();
            $(".firstNight").hide();
            $(".yh .tip").hide();
        }
        $("#cancel").html($(obj).attr("data-cancel"));
        $("#guarantee").html($(obj).attr("data-guarantee"));
        $("#gift").html($(obj).attr("data-gift"));
        if ($(".safeTable .safeChecked:visible").length > 0 && $(".safeTable .safeTableMain").hasClass("safeChecked")) {
            if ($("#PAYMENTING").hasClass("on")) $(".safeTableMain").click()
        }
        orderMemberUtil.BindCoupons();
    },
    validateEmailOrPhone: function (emailorphoneId, flag) {
        var emailorphone = $("#" + emailorphoneId).val();
        var flag1 = false;
        var isLoggedIn = $.cookie("memberId") != null;
        if (!isLoggedIn && $.trim(emailorphone) != "" && $("#ECId").val() == "") {
            var emailorphoneparam = {
                emailOrPhone: emailorphone
            }
            $.ajax({
                type: 'POST',
                url: "/services/validateActivationMember",
                dataType: 'JSON',
                data: emailorphoneparam,
                cache: false,
                async: false,
                success: function (responseData) {
                    var resultData = JSON.parse(responseData);
                    if (resultData.existFlag) {
                        flag1 = false;
                        if (!orderMemberUtil.beenRegistering) memberCheckBox(); $("#exist_login_password").focus(); //生成快速登录弹框
                        if ($("#exist_login_username").val() != emailorphone) $("#exist_login_username").val(emailorphone);//为用户名输入框赋值
                        $("#exist_login_username").css("color", "#777");//修改用户名输入框样式
                        $("#exist_member_login_btn").click(function (event) {
                            event.preventDefault();
                            if (!checkValidateCode("validationCode", null, null)) {
                                if ($("#contextLanguage").val().toLowerCase() == "zh-cn") $(".login_info_box .alarm_text").html("验证码错误");
                                else $(".login_info_box .alarm_text").html("validation code error");
                                $(".login_info_box .alarm_text").css("visibility", "visible");
                                return;
                            }
                            var param = {};
                            param.username = $("#exist_login_username").val();
                            param.password = $("#exist_login_password").val();
                            param.oneMonth = $(".login_info_box .avoid_login_box .check_btn").val() === "checked";
                            var data = "usr=" + param.username + "&pwd=" + StringUtil.base64encode(param.password) + "&oneMonth=" + param.oneMonth + "&callback=?&code=" + $("#validationCode").val();
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
                                        if (result.code == 101) {
                                            if ($("#contextLanguage").val().toLowerCase() == "zh-cn") {
                                                $(".login_info_box .alarm_text").html("验证码错误");
                                            }
                                            else {
                                                $(".login_info_box .alarm_text").html("validation code error");
                                            }
                                        }
                                        else if (result.code == 301) {
                                            $("#exist_login_username").val("");
                                            $("#exist_login_password").val("");
                                            $('.member_login_auto_box .popup_close_btn').click();
                                            ImprovePassword();
                                        }
                                        else {
                                            if ($("#contextLanguage").val().toLowerCase() == "zh-cn") {
                                                $(".login_info_box .alarm_text").html("用户名或密码错误");
                                            }
                                            else {
                                                $(".login_info_box .alarm_text").html("Login Failed");
                                            }
                                        }
                                        $(".login_info_box .alarm_text").css("visibility", "visible");
                                        ChangeCodeImg("ImageCheck");
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {

                                }
                            });
                        });


                    } else {

                        flag1 = true;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });


        } else {

            flag1 = true;

        }

        return flag1;
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
        area: ['476px', '341px'],
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
                            + "<input id='validationCode' class='num_validate_input' type='text' value='输入验证码'>"
                            + "<img id='ImageCheck' class='num_validate_pic' src='' width='63' height='29'>"
                            + "<img id='aImageCheck' class='num_validate_icon' src='/themes/hotels/images/num_validate_icon.png'>"
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
    $("#aImageCheck").click(function () {
        ChangeCodeImg("ImageCheck");
        $("#validationCode").focus();
    })
    $("#ImageCheck").click(function () {
        ChangeCodeImg("ImageCheck");
        $("#validationCode").focus();
    })
    ChangeCodeImg("ImageCheck");
    //重定位弹出框水平位置
    $(".member_login_auto_box").parent().parent().parent().parent().css("margin-left", "-238px");
    //透明边框
    $(".xubox_border").css({ "width": 484, "height": 350 });
    //input光标移入移出样式效果
    $("input, textarea").focusin(function () { $(this).addClass("enter_input_border"); });
    $("input, textarea").focusout(function () { $(this).removeClass("enter_input_border"); });
    //check按钮事件
    bindCheckBtnEvents();
    textWaterMarkEvents("exist_login_username", user_name_text, "#dedede", "#777");//绑定用户名输入框事件
    passwordWaterMarkEvents("exist_login_password", "#dedede", "#777");//绑定密码输入框事件
    textWaterMarkEvents("validationCode", "输入验证码", "#dedede", "#777");
    //绑定关闭按钮事件
    $('.member_login_auto_box .popup_close_btn').on('click', function () {
        layer.close(memberPopupCheckbox);
    });
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


var rndtoday = new Date();
var rndseed = rndtoday.getTime();

function rnd() {
    rndseed = (rndseed * 9301 + 49297) % 233280;
    return rndseed / (233280.0);
};
function RegularUrl(url, key, value) {
    var fragPos = url.lastIndexOf("#");
    var fragment = "";
    if (fragPos > -1) {
        fragment = url.substring(fragPos);
        url = url.substring(0, fragPos);
    }
    var querystart = url.indexOf("?");
    if (querystart < 0) {
        url += "?" + key + "=" + value;
    }
    else if (querystart == url.length - 1) {
        url += key + "=" + value;
    }
    else {
        var Re = new RegExp(key + "=[^\\s&#]*", "gi");
        if (Re.test(url))
            url = url.replace(Re, key + "=" + value);
        else
            url += "&" + key + "=" + value;
    }
    return url + fragment;
}
function rand(number) {
    return Math.ceil(rnd() * number);
};

//手机邮箱判断方法
function isAllNull() {
    var errorTop = 0;
    if ($("#cellphone_num").val() == "" && $("#email_address").val() == "") {//判断手机邮箱是否同时为空
        $(".ruzhuError").show();
        errorTop = $(".ruzhuError").offset().top;
        $(document).scrollTop(errorTop);
        return false;
    } else {
        $(".ruzhuError").hide();
        return true;
    }
}

/*
Author: stan gao;
Date: 2015-10-29;
Descript: 水印控件。
使用说明：参数设置初始颜色和输入文字颜色
*/

//文本输入框水印事件。参数：inputDom（文本输入框节点）；initialColor（初始色）；focusColor（键入色
function oTextWaterMarkEvents(inputDom, initialColor, focusColor) {
    if (inputDom.val() != inputDom.attr("waterPrintText") && inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//现有值不为初始值或空
        inputDom.css("color", focusColor);//输入框使用输入后色值
    } else {//现有值为空
        inputDom.css("color", initialColor);//输入框使用初始色值
        inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值
        if (inputDom.val() == inputDom.attr("waterPrintText")) {//输入框值为水印值
            inputDom.val("");//清空输入框
        }
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (!inputDom.hasClass("validate_input")) {
            if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//输入框值为空
                inputDom.css("color", initialColor);//输入框使用初始色值
                inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值
            }
        }
    });
}
//密码输入框水印事件。参数：inputDom（密码输入框节点）；initialColor（初始色）；focusColor（键入色）。调用此方法需使用特定html结构
function oPasswordWaterMarkEvents(inputDom, initialColor, focusColor) {
    //为密码水印标签定位
    var passWapHtml = '<div class = "password_box"></div>';
    inputDom.wrap(passWapHtml);
    inputDom.parent().append("<label>" + inputDom.attr("waterPrintText") + "</label>")
    inputDom.parent().find("label").css("left", inputDom.css("padding-left"));//为密码水印标签赋left值inputDom.outerWidth(true)
    inputDom.parent().find("label").css("color", initialColor);//为密码水印颜色设置为默认颜色
    inputDom.parent().find("label").css("top", (parseInt(inputDom.css("padding-top"))));
    if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//判定现有值不为空
        inputDom.parent().find("label").hide();//隐藏水印
    } else if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//判定现有值为空
        inputDom.parent().find("label").show();//显示水印
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值//输入框使用输入后色值
        inputDom.parent().find("label").hide();//隐藏水印
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//判定现有值为空
            inputDom.css("color", initialColor);//输入框使用初始色值
            inputDom.parent().find("label").show();//显示水印
        }
    });
    inputDom.parent().find("label").bind("click", function () {//水印点击事件
        $(this).hide();//隐藏水印
        inputDom.parent().find("input").focus();//输入框获取焦点
    });
}
//多行文本输入框textarea水印事件。参数：inputDom（文本输入框节点）；initialColor（初始色）；focusColor（键入色
function oTextareaWaterMarkEvents(inputDom, initialColor, focusColor) {
    inputDom.val(inputDom.attr("waterPrintText"));
    if (inputDom.val() != inputDom.attr("waterPrintText") && inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//现有值不为初始值或空
        inputDom.css("color", focusColor);//输入框使用输入后色值
    } else {//现有值为空
        inputDom.css("color", initialColor);//输入框使用初始色值
        inputDom.html(inputDom.attr("waterPrintText"));//输入框赋水印值
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值
        if (inputDom.val() == inputDom.attr("waterPrintText")) {//输入框值为水印值
            inputDom.val("");//清空输入框
        }
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (inputDom.val() == inputDom.attr("waterPrintText") || inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//输入框值为空
            inputDom.css("color", initialColor);//输入框使用初始色值
            inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值	
        }
    });
}

/*
Author: stan gao;
Date: 2015-10-29;
Descript: 水印控件。
使用说明：参数设置初始颜色和输入文字颜色
*/

//文本输入框水印事件。参数：inputDom（文本输入框节点）；initialColor（初始色）；focusColor（键入色
function oTextWaterMarkEvents(inputDom, initialColor, focusColor) {
    if (inputDom.val() != inputDom.attr("waterPrintText") && inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//现有值不为初始值或空
        inputDom.css("color", focusColor);//输入框使用输入后色值
    } else {//现有值为空
        inputDom.css("color", initialColor);//输入框使用初始色值
        inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值
        if (inputDom.val() == inputDom.attr("waterPrintText")) {//输入框值为水印值
            inputDom.val("");//清空输入框
        }
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (!inputDom.hasClass("validate_input")) {
            if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//输入框值为空
                inputDom.css("color", initialColor);//输入框使用初始色值
                inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值
            }
        }
    });
}
//密码输入框水印事件。参数：inputDom（密码输入框节点）；initialColor（初始色）；focusColor（键入色）。调用此方法需使用特定html结构
function oPasswordWaterMarkEvents(inputDom, initialColor, focusColor) {
    //为密码水印标签定位
    var passWapHtml = '<div class = "password_box"></div>';
    inputDom.wrap(passWapHtml);
    inputDom.parent().append("<label>" + inputDom.attr("waterPrintText") + "</label>")
    inputDom.parent().find("label").css("left", inputDom.css("padding-left"));//为密码水印标签赋left值inputDom.outerWidth(true)
    inputDom.parent().find("label").css("color", initialColor);//为密码水印颜色设置为默认颜色
    inputDom.parent().find("label").css("top", (parseInt(inputDom.css("padding-top"))));
    if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//判定现有值不为空
        inputDom.parent().find("label").hide();//隐藏水印
    } else if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//判定现有值为空
        inputDom.parent().find("label").show();//显示水印
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值//输入框使用输入后色值
        inputDom.parent().find("label").hide();//隐藏水印
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//判定现有值为空
            inputDom.css("color", initialColor);//输入框使用初始色值
            inputDom.parent().find("label").show();//显示水印
        }
    });
    inputDom.parent().find("label").bind("click", function () {//水印点击事件
        $(this).hide();//隐藏水印
        inputDom.parent().find("input").focus();//输入框获取焦点
    });
}
//多行文本输入框textarea水印事件。参数：inputDom（文本输入框节点）；initialColor（初始色）；focusColor（键入色
function oTextareaWaterMarkEvents(inputDom, initialColor, focusColor) {
    inputDom.val(inputDom.attr("waterPrintText"));
    if (inputDom.val() != inputDom.attr("waterPrintText") && inputDom.val().replace(/(^\s*)|(\s*$)/g, "") != "") {//现有值不为初始值或空
        inputDom.css("color", focusColor);//输入框使用输入后色值
    } else {//现有值为空
        inputDom.css("color", initialColor);//输入框使用初始色值
        inputDom.html(inputDom.attr("waterPrintText"));//输入框赋水印值
    }
    inputDom.bind("focusin", function () {//光标移入事件
        inputDom.css("color", focusColor);//输入框使用输入后色值
        if (inputDom.val() == inputDom.attr("waterPrintText")) {//输入框值为水印值
            inputDom.val("");//清空输入框
        }
    });
    inputDom.bind("focusout", function () {//光标移出事件
        if (inputDom.val() == inputDom.attr("waterPrintText") || inputDom.val().replace(/(^\s*)|(\s*$)/g, "") == "") {//输入框值为空
            inputDom.css("color", initialColor);//输入框使用初始色值
            inputDom.val(inputDom.attr("waterPrintText"));//输入框赋水印值	
        }
    });
}

//隐藏取消险
function InsuranceIsHide() {
    $(".tipText").eq(1).hide();

    if ($("#contextLanguage").val().toLowerCase() == "zh-cn" && ($("#onlineAdQunar").val() == "JJHOTELS_WWW" || $("#onlineAdQunar").val() == "TERRACE")) {
        //取消险展示
        if ($("#orderType").val() == "MONEY" && $('#hotelCode').val() != "1396") $(".Insurance").show();
        else {
            $(".Insurance").hide();
        }
    }

}

function CanUseCoupon(promotionType) {
    var useFlg = true;
    $(promontionTypeData).each(function () {
        if (this.value == promotionType && this.useCoupon != "1") {
            useFlg = false;
            return useFlg;
        }
    });
    return useFlg;
}

