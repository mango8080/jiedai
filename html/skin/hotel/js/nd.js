nd_order = {
    preArrivealTime: "",
    paymenting: false,
    arrivalMsg: false,
    latestArrvialTime: "",
    latestArrvialTimeRange:"",
    UpdateCoupon: function () {
        if ($("#orderType").val() == "MONEY") {
            var couponAmount1 = $(".yh .select").is(":hidden") ? 0 : $("#coupon_input_unit").attr("data-amount");
            var orderPrice = $("#price").attr("price");
            var couponAmount2 = $(".yh .select").is(":hidden") ? 0 : $("#select_info_num").attr("amount");
            var couponAmount3 = ($("#GUARANTEE").hasClass("on") && $("#select_info_coupon_type").attr("type") == "JJINN") ? $("#select_info_num").attr("firstamount") : $("#select_info_num").attr("amount");
            var couponAmount = parseInt(couponAmount1) + parseInt(couponAmount2);
            var couponAmountPre = parseInt(couponAmount1) + parseInt(couponAmount3);
            var total = parseInt(orderPrice) - couponAmount;
            total = total < 0 ? 0 : total;
            var prepaid = $("#prepaid").attr("data-prepaid");
            prepaid = prepaid - couponAmountPre;
            prepaid = prepaid < 0 ? 0 : prepaid;
            var safeMoney = 0;
            //添加判断逻辑 origin不是铂涛（PLATENO）的才会做取消险判断
            if ($("#contextLanguage").val().toLowerCase() == "zh-cn" && ($("#onlineAdQunar").val() == "JJHOTELS_WWW" || $("#onlineAdQunar").val() == "TERRACE")) {

                //取消险开始
                if ($("#select_info_coupon_type").attr("type") != "JJINN" && ($("#GUARANTEE").hasClass("radio") || $("#PREPAYMENT").hasClass("radio"))) {
                    $(".Insurance").show();
                    $("#safePrice").show();
                    $(".titbox").eq(3).children(".col").html("04");
                    $(".titbox").eq(4).children(".col").html("05");
                }
                else {
                    $(".Insurance").hide();
                    $("#safePrice").hide();
                    $(".titbox").eq(3).children(".col").html("03");
                    $(".titbox").eq(4).children(".col").html("04");
                }
                if ($("#PREPAYMENT").hasClass("on")) {
                    safeMoney = Math.round(total * 0.05);
                } else {
                    safeMoney = Math.round(prepaid * 0.05);
                }
                if (safeMoney == 0) {
                    $("#safePrice").hide();
                    $(".Insurance").hide();
                    $(".titbox").eq(3).children(".col").html("03");
                    $(".titbox").eq(4).children(".col").html("04");
                }
                $("#safe").html(safeMoney);
                $("#safe").data("safe", safeMoney);
                $(".safePrice b").html(safeMoney);
                if ($(".safeTable").find(".safeTableMain").hasClass("safeChecked") == false) safeMoney = 0;

                //添加判断逻辑 origin（PLATENO）的不显示取消险
                if ($("#hidHotelBrand").val() == "PLATENO") {

                    $(".Insurance").hide();
                    $("#safePrice").hide();
                    $(".titbox").eq(3).children(".col").html("03");
                    $(".titbox").eq(4).children(".col").html("04");
                }
            }
            //取消险结束
            $("#price").html(total + safeMoney);
            $("#prepaid").html(prepaid + safeMoney);
            var remain = total - prepaid;
            remain = remain < 0 ? 0 : remain;
            $("#remain").html(remain);
            $("#remain").attr("data-remain", remain);
            $("#coupon").attr("data-coupon", couponAmount);
            if (couponAmount == 0) {
                $("#couponbox").hide();
            }
            else {
                $("#coupon").html(couponAmount);
                $("#couponbox").show();

            }

        }
    },
    updateOrderPrice: function () {
        Array.prototype.contains = function (item) {
            return RegExp("(^|,)" + item.toString() + "($|,)").test(this);
        };
        Date.prototype.diff = function (date) {
            return (this.getTime() - date.getTime()) / (24 * 60 * 60 * 1000);
        }
        var guestValue = $.cookie("guestValue");
        var roomNum = 1;
        if (guestValue != null) roomNum = guestValue.split("|&|").length;
        else roomNum = $('.roomNum').find("li[class='sel']").attr("title");
        var sdate = $(".yudingbox").find('input.dateCheckIn').val();
        var edate = $(".yudingbox").find('input.dateCheckOut').val();
        var hotelId = $('#hotelCode').val();
        var lang = $('#contextLanguage').val();
        var planId = $('#planId').val();
        var nightNum = $('#nights').val();
        var adultNum = $('#adultNum').val();
        var param = {
            startDate: sdate,
            endDate: edate,
            language: $("#contextLanguage").val(),
            nights: new Date(getTimeByDateStr(edate)).diff(new Date(getTimeByDateStr(sdate))),
            planId: planId,
            hotelCode: hotelId,
            roomNum: roomNum,
            adultNum: adultNum,
            cardType: $("#hidMemberCardType").val(),
            memberCode: $("#hidMemberCode").val(),
            ecCode: $("#ECcode").val(),
            latestArrvialTime: nd_order.latestArrvialTime
        };
        //console.log('----------------------------------------------' + roomNum);
        $.ajax({
            type: 'POST',
            url: "/service/hotelRealPrice",
            dataType: 'JSON',
            data: param,
            cache: false,
            success: function (responseData) {
                var result = JSON.parse(responseData);
                var arr = [];
                if (roomNum == "") roomNum = 1;
                nd_order.preArrivealTime = result.preArrivealTime;
                var data = result.dayPriceAvailableDtos;
                var isCanOrder = true;
                for (var i = 0; i < data.length; i++) {
                    if ((data[i].settingStatus != "A" || data[i].dayStatus == "CLOSE") && data[i].closeReason != "") {
                        $(".tipbox").eq(0).html(data[i].closeReason);
                        $(".tipbox").eq(0).show();
                        //$("#submit").unbind("click");
                        $(".unsure").removeClass("sure");
                        $(".Insurance").hide();
                        $(".titbox").eq(3).children(".col").html("03");
                        $(".titbox").eq(4).children(".col").html("04");
                        isCanOrder = false;
                        break;
                    } else $(".tipbox").eq(0).hide();

                }

                if (isCanOrder) {
                    //如果可以定
                    //$("#submit").removeAttr("disabled");
                    $("#submit").unbind("click");
                    $("#submit").click(window.submitOrderForbtn);
                }
                else {
                    //如果不能定
                    //$("#submit").attr('disabled', "true");
                    $("#submit").unbind("click");
                }

                $(".roomTable .item").remove();
                $("#day-price-template").tmpl(data).appendTo(".roomTable");
                var gcps = new Array();
                $(".payway li").each(function () {
                    gcps.push($(this).attr("id"));
                    $(this).attr("class", "radio");
                });
                var gcpMap = result.gcpMap;
                if ($("#hidHotelBrand").val().toLowerCase() != "jjhotel" && gcpMap.length > 0) $("#arriveTimetipMsg").show();
                else $("#arriveTimetipMsg").hide();

                var keys = new Array();
                nd_order.paymenting = false;
                for (var i = 0; i < gcpMap.length; i++) {
                    row = gcpMap[i];
                    var key = row.Key + "";
                    if (hotelId == "1396" && (key == "GUARANTEE" || key == "PREPAYMENT")) continue;

                    if (key == "PAYMENTING") nd_order.paymenting = true;
                    $("#" + key).attr("data-cancel", row.cancelPolicy);
                    $("#" + key).attr("data-guarantee", row.guaranteePolicy);
                    keys.push(key);
                }
                for (var j = 0; j < gcps.length; j++) {
                    if (!keys.contains(gcps[j])) {
                        $("#" + gcps[j]).attr("class", "");
                    }
                }
                var dateCheckIn = $(".yudingbox").find('input.dateCheckIn').val();
                if (dateCheckIn == $("#hidToday").val() & nd_order.preArrivealTime != "") {
                    var nowTime = $("#select_info_time").find("li[class='sel']").attr("endtime");
                    var flag = nowTime > nd_order.preArrivealTime;
                    if (flag) {
                        $("#PAYMENTING").attr("class", "");
                    }
                }

                
                var orderType = $(".payway li[class='on']").attr("id");
                var price = 0;
                var roomAmount = 0;
                var roomAmountScore = 0;
                var tax = 0;
                var scoreTax = 0;
                //console.log($("#orderType").val());
                switch ($("#orderType").val()) {
                    case "MONEY":
                        roomAmount = result.prePaymentPrepaidAmount.roomAmount;
                        tax = result.Amount.TotalChargePrice + result.Amount.TotalTaxPrice;
                        price = result.totalPrice;
                        //console.log("-------price--------" + price);
                        $("#total").html(roomAmount);
                        $("#price").html(price);
                        $("#price").attr("price", price);
                        //couponSelect();
                        break;
                    case "SCORE":
                        roomAmount = result.prePaymentPrepaidAmount.roomAmount;
                        price = result.totalPrice;
                        scoreTax = result.Amount.TotalChargePrice + result.Amount.TotalTaxPrice;
                        $("#roomAmountArea").hide();
                        $("#roomAmountScore").html(roomAmount);
                        $("#totalAmountScore").html(price);
                        $("#total").hide();
                        $("#totalPlus").hide();
                        $("#roomPlus").hide();
                        $("#totalArea").hide();
                        $(".dollar_notation_text").hide();
                        $("#roomAmountScoreArea").show();
                        $("#totalScoreArea").show();
                        break;
                    case "SCOREandMONEY":
                        roomAmountScore = result.prePaymentPrepaidAmount.roomAmount;
                        roomAmount = result.prePaymentPrepaidAmount.roomPlusAmount;
                        price = result.PlusAmount.TotalPrice;
                        var scorePrice = result.totalPrice;
                        tax = result.PlusAmount.TotalChargePrice + result.PlusAmount.TotalTaxPrice;
                        scoreTax = result.Amount.TotalChargePrice + result.Amount.TotalTaxPrice;
                        $("#total").html(roomAmount);
                        $("#totalAmountScore").html(scorePrice);
                        $("#roomAmountScore").html(roomAmountScore);
                        $("#price").html(price);
                        $("#price").attr("price", price);
                        // couponUnselect();
                        $("#roomAmountScoreArea").show();
                        $("#totalScoreArea").show();
                        break;
                }
                var prepaid = result.guaranteePrepaidAmount.totalPrepaidAmount;
                var coupon = $("#coupon").attr("data-coupon");

                $("#tax").html(tax);

                if (scoreTax != 0) {
                    $("#taxScoreArea").show();
                    if (tax == 0) {
                        $("#taxPlus").hide();
                        $("#tax").hide();
                        $("#taxUnit").hide();
                    }
                    else {
                        $("#taxPlus").show();
                        $("#tax").show();
                        $("#taxUnit").show();
                    }
                    $("#taxScore").html(scoreTax);
                } else $("#taxScoreArea").hide();
                $("#prepaid").html("¥" + prepaid + "，");
                $("#prepaid").attr("data-prepaid", prepaid);
                $("#remain").html("¥" + (price - prepaid));
                $("#remain").attr("data-remain", (price - prepaid));
                if (orderType == "GUARANTEE") {
                    $(".pay_requirement").show();
                }
                else {
                    $(".pay_requirement").hide();
                }
                nd_order.UpdateCoupon();
                $(".payway li.radio").eq(0).click();
                //orderMemberUtil.bindContacts();
                //orderMemberUtil.bindHideContacts();
                var data = "";
                if (dateCheckIn == $("#hidToday").val()) {
                    data = $("#hitTodayTimeRange").val();


                } else {
                    data = $("#hidTimeRange").val();
                }
                $("#select_info_time li").remove();
                data = eval(data);
                if (data.length > 0) {

                    for (var j = 0; j < data.length; j++) {
                        if (j == 0 & data.length < 8) {
                            $("<li  endtime=\"" + data[j].end + "\" class=\"sel\">" + data[j].range + "</li>").appendTo("#select_info_time");
                            if (nd_order.latestArrvialTimeRange != "") {
                                $("#select_info_time").parent().find(".valTxt").html(nd_order.latestArrvialTimeRange);
                            }
                            else {
                                $("#select_info_time").parent().find(".valTxt").html(data[j].range);
                            }
                        }
                        else if (j == data.length - 8 & data.length >= 8) {
                            //$(this).parents(".select").find(".valTxt").html(txt);
                            //$(this).addClass("sel").siblings().removeClass("sel");
                            //$(this).parents(".select").find(".selBox").hide();
                            $("<li  endtime=\"" + data[j].end + "\" class=\"sel\">" + data[j].range + "</li>").appendTo("#select_info_time");
                            if (nd_order.latestArrvialTimeRange != "") {
                                $("#select_info_time").parent().find(".valTxt").html(nd_order.latestArrvialTimeRange);
                            }
                            else {
                                $("#select_info_time").parent().find(".valTxt").html(data[j].range);
                            }
                        } else {
                            $("<li  endtime=\"" + data[j].end + "\">" + data[j].range + "</li>").appendTo("#select_info_time");
                        }
                    }
                    $("#select_info_time li").click(function () {
                        $(this).parents(".select").find(".valTxt").html($(this).html());
                        $(this).addClass("sel").siblings().removeClass("sel");
                        $(this).parents(".select").find(".selBox").hide();
                        nd_order.latestArrvialTime = $("#select_info_time li.sel").attr("endtime");//2016-06-21 添加最晚到店时间
                        nd_order.latestArrvialTimeRange = $("#select_info_time li.sel").html();
                        if (nd_order.preArrivealTime != "") {
                            var nowTime = $("#select_info_time li.sel").attr("endtime");
                            var flag = nowTime > nd_order.preArrivealTime;
                            if (flag) {
                                $("#arriveTimetipMsg").html($("#PAYMENTING").attr("tipmsg"));
                                $("#arriveTimetipMsg").show();
                                nd_order.arrivalMsg = true;
                                //if ($("#PAYMENTING").hasClass("on")) {//无论是否选中都要把现付设置为不可选
                                    $("#PAYMENTING").attr("class", "");
                                    $("#PAYMENTING").unbind("click");
                                    $(".payway li.radio").eq(0).click();

                                //}
                                nd_order.arrivalMsg = false;
                            } else {
                                if ($("#hidBrand").val().toLowerCase() == "jjhotel") $("#arriveTimetipMsg").hide();
                                if (nd_order.paymenting) {
                                    if (!$("#PAYMENTING").hasClass("radio")) $("#PAYMENTING").addClass("radio");
                                    $("#PAYMENTING").bind("click", function () {
                                        orderMemberUtil.PaymentClick(this);
                                    });
                                    $(".payway li.radio").eq(0).click();

                                }
                            }
                        }
                        orderMemberUtil.validatePayType();
                        nd_order.updateOrderPrice();
                    });
                }
                //城市建设税
                if (result.buildTaxText) {
                    $("#taxfre").html("<em>" + result.buildTaxText + "</em>");
                }
                else {
                    $("#taxfre").html("");
                }
                //console.log(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log("Error:", errorThrown);
            }
        });
    },
    //获取优惠券码
    getPromotionCodes: function () {

    }
}

//$(function () {
//    valueInputTitle();
//});