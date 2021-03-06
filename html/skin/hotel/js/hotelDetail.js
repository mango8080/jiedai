$(function () {
    //var isForegin = true;

    //var hotelCMap = null;
    //if (isForegin) {
    //    hotelCMap = hotelBingMap;
    //}
    //else {
    //    hotelCMap = hotelMap;
    //}

    //tab事件
    //bindTabEvents();
    //setHotelInfoTab();

    //paddingleft util
    String.prototype.PadHelper = function (totalWidth, paddingChar, isRightPadded) {

        if (this.length < totalWidth) {
            var paddingString = new String();
            for (i = 1; i <= (totalWidth - this.length) ; i++) {
                paddingString += paddingChar;
            }

            if (isRightPadded) {
                return (this + paddingString);
            } else {
                return (paddingString + this);
            }
        } else {
            return this;
        }
    }
    String.prototype.PadLeft = function (totalWidth, paddingChar) {
        if (paddingChar != null) {
            return this.PadHelper(totalWidth, paddingChar, false);
        } else {
            return this.PadHelper(totalWidth, ' ', false);
        }
    }
    //like Hotel
    var likeHotelIndex = 0;
    if ($("#likehotelData").length > 0 && $("#likehotelData").val().length > 0) {
        var likeHotelData = JSON.parse($("#likehotelData").val().replace(/\'/g, "\""));
        var pageNum = likeHotelData.pageNum;
        var hotelData = likeHotelData.data;
        if (pageNum != undefined && pageNum > 0) {
            $("#refresh_appriori").bind("click", function () {
                if ((++likeHotelIndex) >= pageNum) likeHotelIndex = 0;
                $("#guessulike-container div").remove();
                var content = $("#like-hotel-template").tmpl(hotelData[likeHotelIndex]);
                $(content[0]).addClass("first_unit");
                $("#guessulike-container").html(content);
                //$("#guessulike-container")
                $(".col-5-1[name='appriori'] a").click(function () {
                    var today = new Date();
                    var bdtime = "" + today.getFullYear() + (today.getMonth() + 1).toString().PadLeft(2, '0') + today.getDate().toString().PadLeft(2, '0') + today.getHours();
                    window.open($(this).data("hotelurl") + "&bd_lid=" + $(this).data("index") + "&bd_time=" + bdtime);
                });
            });
        }
        $(".col-5-1[name='appriori'] a").click(function () {
            var today = new Date();
            var bdtime = "" + today.getFullYear() + (today.getMonth() + 1).toString().PadLeft(2, '0') + today.getDate().toString().PadLeft(2, '0') + today.getHours();
            window.open($(this).data("hotelurl") + "&bd_lid=" + $(this).data("index") + "&bd_time=" + bdtime);
        });
    }
    var hotelsSelect = $(".first_row_box .lg");
    if (hotelsSelect != null && hotelsSelect.length > 0) {
        bodyclick = document.getElementsByTagName('body').item(0);
        rSelects();
        bodyclick.onclick = function () {
            for (i = 0; i < selects.length; i++) {
                document.getElementById('select_info_' + selects[i].name).className = 'tag_select';
                document.getElementById('options_' + selects[i].name).style.display = 'none';
            }
        }

        //星级酒店语言切换
        $('#options_language li').unbind('click');
        $('#options_language li').on('click', function () {
            $("#languageSelect").val("1");
            $('form').submit();
        });
    }

    //取消政策鼠标效果
    $(".cancel .ptips").hover(function () {
        $(this).find(".cancel_tip").toggle();
    });

    //图片滚动效果
    var picNum = $(".smallimg .list li").length;
    var picWidth = $(".smallimg .list li").outerWidth(true);
    var picN = 0;
    $(".smallimg .list").width(picNum * picWidth);
    $('.btnLeft').css({ cursor: 'auto', opacity: "0.3" });
    if (picNum < 4) {
        $('.bIcon').css({ cursor: 'auto', opacity: "0.3" });
    }
    $('.btnRight').click(function () {
        if (picNum < 4 || picN >= picNum - 4) {
            return false;
        }
        picN++;
        $(".smallimg .list").animate({ left: '-=' + picWidth + 'px' }, 'fast');
        picSlide();
    });
    $('.btnLeft').click(function () {
        if (picN <= 0) {
            return false;
        }
        picN--;
        $(".smallimg .list").animate({ left: '+=' + picWidth + 'px' }, 'fast');
        picSlide();
    });
    function picSlide() {
        if (picN >= picNum - 4) {
            $('.btnRight').css({ cursor: 'auto', opacity: "0.3" });
        }
        else if (picN > 0 && picN <= picNum - 4) {
            $('.bIcon').css({ cursor: 'pointer', opacity: "1" });
        }
        else if (picN <= 0) {
            $('.btnLeft').css({ cursor: 'auto', opacity: "0.3" });
        }
    }
    $(".slideimg .smallimg li").css({ opacity: 0.5 });
    $(".slideimg .smallimg li").eq(0).css({ opacity: 1 });
    $(".smallimg li").click(function () {
        var tabs = $(this).parents().children("li");
        var panels = $(this).parents(".slideimg").find(".bigimg");
        var index = $.inArray(this, tabs);
        tabs.removeClass("on").css({ opacity: 0.5 }).eq(index).addClass("on").css({ opacity: 1 });
        panels.hide().eq(index).show();
        picN == index;
    });

    $(".login_check").bind("click", function () {
        memberCheckBox();
    });

    window.setTimeout(function () {
        if ($(document).scrollTop() > 137) {
            $(".exploring_num").css("position", "absolute");
            $(".exploring_num").css("top", $(document).scrollTop() + 40);
            if ($(window).width() > 1200) {
                $(".exploring_num").css("left", 1063 + ($(window).width() - 1200) / 2);
            } else {
                $(".exploring_num").css("left", 1063);
            }
        }
        $(".exploring_num").fadeIn(300, null);
        window.setTimeout("$('.exploring_num').fadeOut(300, null)", 5000);
    }, 2000);

    $(".toggle").bind("click", function () {
        if ($(this).attr("class").indexOf("expanded") < 0) {
            $(this).addClass("expanded");
            $(this).parent().parent().next().show();
            if ($("body.en").length == 1) {
                $(this).html("▲&nbsp;Close room details");
            } else if ($("body.ja").length == 1) {
                $(this).html("▲&nbsp;お部屋の詳細をクローズ");
            } else {
                $(this).html("▲&nbsp;收起房间详情");
            }
        } else {
            $(this).removeClass("expanded");
            if ($("body.en").length == 1) {
                $(this).html("▼&nbsp;See room details");
            } else if ($("body.ja").length == 1) {
                $(this).html("▼&nbsp;お部屋の詳細をごらんになる");
            } else {
                $(this).html("▼&nbsp;查看房间详情");
            }
            $(this).parent().parent().next().hide();
        }
    });

    //修改信息事件
    $(".edit_btn").bind("click", function () {
        $(".checkIn_show_box").hide();
        $(".checkIn_edit_box").show();
    });

    //取消按钮事件
    $(".cancel_btn").bind("click", function () {
        $(".checkIn_edit_box").hide();
        $(".checkIn_show_box").show();
    });

    //日历效果
    bindDatePickers();


    //查看大地图按钮事件
    $(".map_see").bind("click", function () {
        if (initCriteria != null && initCriteria.lng != null && initCriteria.lng != '' && initCriteria.lat != null && initCriteria.lat != '') {
            createBigMapBox('1');
            //hotelMap.showSingleHotelOnBigMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, 'big-map-box');
            hotelCMap.showSingleHotelOnBigMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, 'big-map-box');
        }
    });


    getHotelMap(initCriteria);
    //点击商圈、交通、机场名弹出地图蒙层
    $(".circumference_box .name").bind("click", function () {
        if (initCriteria != null && initCriteria.lng != null && initCriteria.lng != '' && initCriteria.lat != null && initCriteria.lat != '') {
            createBigMapBox('1');
            if ($('#big-map-box').data('map-initialized') != '1') {
                //hotelMap.showSingleHotelOnBigMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, 'big-map-box');
                hotelCMap.showSingleHotelOnBigMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, 'big-map-box');
            }

            var tolng = initCriteria.lng;
            var tolat = initCriteria.lat;
            var $this = $(this);
            var fromlng = $this.data('lng');
            var fromlat = $this.data('lat');
            if (tolng != null && tolat != '' && fromlng != null && fromlat != '') {
                //hotelMap.showWalkRouteOnBigMap(fromlng.toString(), fromlat.toString(), tolng.toString(), tolat.toString());
                hotelCMap.showWalkRouteOnBigMap(fromlng.toString(), fromlat.toString(), tolng.toString(), tolat.toString());
            }
        }
    });

    $('.circumference_box .each_unit').each(function () {
        var $this = $(this);
        var tolng = initCriteria.lng;
        var tolat = initCriteria.lat;
        var $info = $this.find(".name");
        var fromlng = $info.data('lng');
        var fromlat = $info.data('lat');
        var dist = $this.find(".distance");
        if (!isNaN(fromlng) && !isNaN(fromlat)) {
            //hotelMap.queryWalkDistance(tolng, tolat, fromlng, fromlat, function (walkTime) {
            //    if (walkTime != null && walkTime != '') {
            //        var minutes = parseInt(walkTime.minutes) + parseInt(walkTime.hours) * 60;
            //        dist.text(dist.text().replace('$WalkTime', minutes));
            //        dist.show();
            //    }
            //    else {
            //        dist.hide();
            //    }
            //});

            hotelCMap.queryWalkDistance(tolng, tolat, fromlng, fromlat, function (walkTime) {
                if (walkTime != null && walkTime != '') {
                    var minutes = parseInt(walkTime.minutes) + parseInt(walkTime.hours) * 60;
                    dist.text(dist.text().replace('$WalkTime', minutes));
                    dist.show();
                }
                else {
                    dist.hide();
                }
            });
        }
        else {
            dist.hide();
        }
    });

    window.setRoomPlanEffect = function ($parent) {
        $parent.find(".bottom_dashed_line").unbind('hover');
        $parent.find(".bottom_dashed_line").hover(function () {
            var $this = $(this);
            $this.find(".tit_box").css("top", $this.offset().top - $this.find(".tit_box").height() - 20 - 6);
            $this.find(".tit_box").css("left", $this.offset().left - 40);
            $this.find(".board_arrow_icon").css("top", $this.find(".tit_box").height() + 13);
            $this.find(".tit_box").toggle();
        });

        //连续入住
        $parent.find(".btn_all").unbind('click');
        $parent.find(".btn_all").click(function () { $(this).parent().find(".all_main").show(); });
        $parent.find(".all_day .close").unbind('click');
        $parent.find(".all_day .close").click(function () { $(this).parents(".all_main").hide(); });
        $(".tit span").unbind('hover');
        $(".tit span").hover(function () {
            $(this).find(".tit_box").css("top", $(this).offset().top - $(this).find(".tit_box").height() - 22);
            $(this).find(".tit_box").css("left", $(this).offset().left - 25);
            $(this).find(".board_arrow_icon").css("top", $(this).find(".tit_box").height() + 13);
            $(this).find(".tit_box").toggle();
        });

        //担保政策鼠标效果
        $(".cancel .ptips").hover(function () {
            if (!$(this).hasClass('no_ptips')) {
                $(this).find(".cancel_tip").show();
            }

        }, function () {
            $(this).find(".cancel_tip").hide();
        });

        //收费弹出层
        $(".has-internet").unbind('hover');
        $(".has-internet").hover(function () {
            $(this).find(".pay-internet-text").toggle();
        });

        ////气泡提示
        //$parent.find('.ptips').popTip({
        //    texttip: 'jjui_poptext',
        //    width: '252',
        //    maxwidth: 252,
        //    left: 12,
        //    positionleft: 30
        //});
        $parent.find(".promotion .gift").popTip({
            texttip: 'jjui_poptext',
            width: '252',
            maxwidth: 252,
            left: 0,
            positionleft: 30
        });

        //专享价鼠标效果
        $parent.find(".login_before").unbind('hover');
        $parent.find(".login_before").hover(function () {
            $(this).find(".login_tip").toggle();
        });
    }
    setRoomPlanEffect($(document));

    $('.checkIn_edit_box .check_priice_btn').bind('click', function () {
        $(".checkIn_edit_box").hide();
        $(".checkIn_show_box").show();
        //$('.hotel_room_info_box').html('');
        $(".room_info").each(function (index, element) {
            $(element).remove();
        });
        //$(".room_tab").html('');
        $(".room_tab li").each(function (index, element) {
            if (index != 0) {
                $(element).remove();
            }
        });
        $(".date_text").eq(0).html($('.checkIn_edit_box .dateCheckIn').val());
        $(".date_text").eq(1).html($('.checkIn_edit_box .dateCheckOut').val());
        $(".date_text").eq(2).html($('.checkIn_edit_box .promoCode').val());
        initCriteria.checkInDate = $('.checkIn_edit_box .dateCheckIn').val();
        initCriteria.checkoutDate = $('.checkIn_edit_box .dateCheckOut').val();
        initCriteria.promoCode = $('.checkIn_edit_box .promoCode').val();
        QueryRooms(initCriteria.hotelId);
    });
    var $mini = $('.base_side .right_map');

    QueryRooms(initCriteria.hotelId);


    $('.line-under').hover(function () {
        $('.scan-code-tip').show();
    }, function () {
        $('.scan-code-tip').hide();
    })

});

function getDate() {
    var start = initCriteria.checkInDate;
    var end = initCriteria.checkoutDate;
    var strSeparator = "-"; //日期分隔符
    var oDate1;
    var oDate2;
    var iDays;
    oDate1 = start.split(strSeparator);
    oDate2 = end.split(strSeparator);
    var strDateS;
    var strDateE;
    strDateS = new Date(oDate1[0] + "-" + oDate1[1] + "-" + oDate1[2]);
    strDateE = new Date(oDate2[0] + "-" + oDate2[1] + "-" + oDate2[2]);
    //FOR IE8
    if (isNaN(strDateS) || isNaN(strDateE)) {

        strDateS = new Date(oDate1[0], oDate1[1] - 1, oDate1[2]);
        strDateE = new Date(oDate2[0], oDate2[1] - 1, oDate2[2]);
    }

    iDays = parseInt(Math.abs(strDateS - strDateE) / 1000 / 60 / 60 / 24);//把相差的毫秒数转换为天数 
    return iDays;
}

function setRoomCheckInOutDate($parent, isPreBooking, bookingDays) {

    var checkInDate = getTimeByDateStr($('.dateCheckIn').val());
    if (isPreBooking) {
        checkInDate = checkInDate + bookingDays * 24 * 60 * 60 * 1000;
    }

    var today = new Date(checkInDate);
    $parent.find(".book_date_checkIn").datepicker({
        minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
        maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 90),
        numberOfMonths: 2,
        changeMonth: false,
        changeYear: false,
        beforeShow: function () {
            var click_input_dom_left = $(this).offset().left
            setTimeout(
                function () {
                    $('#ui-datepicker-div').css("z-index", 162);
                    $('#ui-datepicker-div').css("left", (click_input_dom_left - 279));
                }
            );
        },
        onSelect: function (dateText, inst) {
            //console.log($(this).parent().next().find(".book_date_checkOut"));
            var checkOutDateControl = $(this).parent().next().find(".book_date_checkOut");
            var $isPreBooking = checkOutDateControl.data("isPreBooking");
            var $bookingDays = checkOutDateControl.data("bookingDays");
            var IntervalDate = 1;
            if ($isPreBooking == "0") {
                IntervalDate = $bookingDays;
            }
            $(this).parent().next().find(".book_date_checkOut").datepicker('option', 'minDate', new Date(getTimeByDateStr(dateText) + IntervalDate * 24 * 60 * 60 * 1000));
            $(this).parent().next().find(".book_date_checkOut").datepicker('option', 'maxDate', new Date(getTimeByDateStr(dateText) + 14 * 24 * 60 * 60 * 1000));
            var next_day = new Date(getTimeByDateStr(dateText) + IntervalDate * 24 * 60 * 60 * 1000);
            var next_month = (parseInt(next_day.getMonth()) + 1).toString();
            if (next_month.length == 1) {
                next_month = "0" + next_month;
            }
            var next_date = (next_day.getDate()).toString();
            if (next_date.length == 1) {
                next_date = "0" + next_date;
            }
            $(this).parent().next().find(".book_date_checkOut").val(next_day.getFullYear() + "-" + next_month + "-" + next_date);
        }
    });

    var tmw_month = (parseInt(today.getMonth()) + 1).toString();
    if (tmw_month.length == 1) {
        tmw_month = "0" + tmw_month;
    }
    var tmw_date = (today.getDate()).toString();
    if (tmw_date.length == 1) {
        tmw_date = "0" + tmw_date;
    }

    var checkoutDays = 1;
    if (!isPreBooking) {
        checkoutDays = bookingDays;
    }

    var tomorrow = new Date(getTimeByDateStr(today.getFullYear() + "-" + tmw_month + "-" + tmw_date) + checkoutDays * 24 * 60 * 60 * 1000);
    var maxCheckOutDate = new Date(getTimeByDateStr(today.getFullYear() + "-" + tmw_month + "-" + tmw_date) + 14 * 24 * 60 * 60 * 1000);

    $parent.find(".book_date_checkOut").datepicker({
        minDate: tomorrow,
        maxDate: maxCheckOutDate,
        numberOfMonths: 2,
        changeMonth: false,
        changeYear: false,
        beforeShow: function () {
            var click_input_dom_left = $(this).offset().left
            setTimeout(
                function () {
                    $('#ui-datepicker-div').css("z-index", 162);
                    $('#ui-datepicker-div').css("left", (click_input_dom_left - 279));
                }
            );
        }
    });

    var checkInVal = '';
    var checkOutVal = '';

    var monthVal1 = parseInt(today.getMonth()) + 1;
    if (monthVal1 < 10) {
        monthVal1 = '0' + monthVal1;
    }
    var dateVal1 = (today.getDate()).toString();
    if (dateVal1.length == 1) {
        dateVal1 = "0" + dateVal1;
    }
    checkInVal = today.getFullYear() + "-" + (monthVal1) + "-" + dateVal1;

    var monthVal2 = parseInt(tomorrow.getMonth()) + 1;
    if (monthVal2 < 10) {
        monthVal2 = '0' + monthVal2;
    }
    var dateVal2 = (tomorrow.getDate()).toString();
    if (dateVal2.length == 1) {
        dateVal2 = "0" + dateVal2;
    }
    checkOutVal = tomorrow.getFullYear() + "-" + (monthVal2) + "-" + dateVal2;

    $parent.find(".book_date_checkIn").val(checkInVal);
    $parent.find(".book_date_checkOut").val(checkOutVal);
}

function createBigMapBox(model) {
    if (model != undefined && model != null && model == '1') {
        if ($(".wrapper .big_map_box").length == 0) {
            var big_map_box = "<div class='mybg clearfix'></div>"
                                + "<div class='big_map_box clearfix'>"
                                    + "<div class='head_box'><a class='close_btn'></a></div>"
                                    + "<div id='big-map-box' style='width:100%; height:100%;'></div>"
                                + "</div>";
            $(".wrapper").append(big_map_box);
            $(".mybg").css("height", $(".wrapper").height());
            setBigMapSize();
        }
        else {
            $(".mybg").show();
            $(".big_map_box").show();
            setBigMapSize();
        }
        document.documentElement.style.overflow = "hidden";

        $(".close_btn").bind("click", function () {
            $(".mybg").hide();
            $(".big_map_box").hide();
            document.documentElement.style.overflow = "";
        });
    }
    else {
        var big_map_box = "<div class='mybg clearfix'></div>"
                            + "<div class='big_map_box clearfix'>"
                                + "<div class='head_box'><a class='close_btn'></a></div>"
                                + "<div id='big-map-box' style='width:100%; height:100%;'></div>"
                            + "</div>";
        $(".wrapper").append(big_map_box);
        $(".mybg").css("height", $(".wrapper").height());
        setBigMapSize();
        document.documentElement.style.overflow = "hidden";

        $(".close_btn").bind("click", function () {
            $(".mybg").remove();
            $(".big_map_box").remove();
            document.documentElement.style.overflow = "";
        });
    }
}

function setBigMapSize() {
    var st = $(document).scrollTop();
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();
    if (windowHeight > 700) {
        $(".big_map_box").css("height", (windowHeight - 202));
        //$(".big_map_box img").css("height", (windowHeight - 202 - 28));
        $(".big_map_box").css("top", 100 + st);
    } else if (windowHeight > 500 && windowHeight <= 700) {
        $(".big_map_box").css("top", (windowHeight - 500) / 2 + st);
    } else {
        $(".big_map_box").css("top", 0 + st);
    }
    if (windowWidth > 1000) {
        $(".big_map_box").css("width", (windowWidth - 202));
        //$(".big_map_box img").css("width", (windowWidth - 202));
    } else if (windowWidth > 800 && windowWidth <= 1000) {
        $(".big_map_box").css("left", (windowWidth - 800) / 2);
    } else {
        $(".big_map_box").css("left", 0);
    }
}

function QueryRooms(hotelId) {

    var $hotelItem = $('.hotel_item_' + hotelId);

    $('.loading_icon').show();

    var param = {};

    param.channel = initCriteria.channel;

    param.checkInSDate = initCriteria.checkInDate;
    param.checkoutSDate = initCriteria.checkoutDate;

    param.hotelId = hotelId;
    param.jjCode = $hotelItem.data('jjcode');
    param.memberCardType = initCriteria.memberCardType;
    param.promotionCode = initCriteria.promotionCode;
    param.language = initCriteria.lang;
    param.rateCodes = initCriteria.rateCode;

    //判断是否企业客户
    if (initCriteria.agreementCode != null && initCriteria.agreementCode != "") {
        param.enterpriseCustomerCode = initCriteria.agreementCode;
    }

    hotelCMap.ShowSingleHotelOnMiniMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, "mini_map_box");
    var self = this;
    $.ajax({
        type: 'POST',
        url: "/service/queryHotelDayPrice",
        dataType: 'JSON',
        data: param,
        cache: false,
        success: function (responseData) {
            $('.loading_icon').hide();
            var resp = JSON.parse(responseData);
            var $mini = $('.base_side .right_map');
            if ($mini.length > 0) {
                //hotelMap.ShowSingleHotelOnMiniMap(initCriteria.hotelId, initCriteria.lng, initCriteria.lat, initCriteria.lang, "mini_map_box");
            }

            bindRoomInfo(resp, $hotelItem);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.loading_icon').hide();
            //console.log("Error:", errorThrown);
        }
    });
}


function bindRoomInfo(rooms, $hotelItem) {
    if (rooms != undefined && rooms != null) {
        if (rooms.rateInfos != undefined && rooms.rateInfos != null && rooms.rateInfos != undefined && rooms.rateInfos.length > 0) {
            var sortedRateInfos = new Array();
            var foundRIndexs = new Array();
            $(rbtNameData).each(function () {
                var rbt = this;
                for (var i = 0; i < rooms.rateInfos.length; i++) {
                    if (rbt.text == rooms.rateInfos[i].PromotionType) {
                        rooms.rateInfos[i].iconClass = rbt.cssClass;
                        sortedRateInfos.push(rooms.rateInfos[i]);
                        foundRIndexs.push(i);
                    }
                }
            });
            for (var i = 0; i < rooms.rateInfos.length; i++) {
                var count = 0;
                for (var j = 0; j < foundRIndexs.length; j++) {
                    if (foundRIndexs[j] == i) {
                        count++;
                    }
                }
                if (count == 0) {
                    sortedRateInfos.push(rooms.rateInfos[i]);
                }
            }
            rooms.rateInfos = sortedRateInfos;
        }

        $(rooms.rateInfos).each(function () {

            $hotelItem.find('.room_tab').append("<li class=\"\"><a class=\"" + this.iconClass + "\" title=" + this.PromotionType + "></a>" + this.PromotionType + "</li>");
        });

        bindRoomPlans(rooms, $hotelItem, rooms.roomInfos, 1, true)

        $(rooms.rateInfos).each(function () {
            bindRoomPlans(rooms, $hotelItem, this.roomInfos, 2, false)
        });
        $(".room_tab li").hover(function () {
            if ($(this).hasClass("selected") == false) {
                $(this).find("a").addClass($(this).find("a").attr("class") + "_hover");
                //$(this).css("color", "#1d7ad9");
            }
        }, function () {
            if ($(this).hasClass("selected") == false) {
                if ($(this).find("a").length > 0) {
                    $(this).find("a").removeClass($(this).find("a").attr("class").split(" ")[1]);
                    //$(this).css("color", "#777");
                }
            }
        });

        //房型tab select事件
        $(".room_tab li").bind("click", function () {
            if ($(this).hasClass("selected") == false) {
                var selected_node = $(".room_tab li.selected");
                selected_node.removeClass("selected");
                if (selected_node.find("a").length > 0) {
                    selected_node.find("a").removeClass(selected_node.find("a").attr("class").split(" ")[1]);
                    //selected_node.css("color", "#777");
                }
                $(this).addClass("selected");
                if ($(this).find("a").length > 0) {
                    $(this).find("a").removeClass($(this).find("a").attr("class").split(" ")[1]);
                    $(this).find("a").addClass($(this).find("a").attr("class") + "_selected");
                }
                //$(this).css("color", "#fff");

                var tabs = $(this).parent().children("li");
                var panels = $(this).parents(".hotel_room_info_box").find(".room_info");
                var index = $.inArray(this, tabs);
                panels.hide().eq(index).show();
            }
        });
        //}
    }

    // 详情页楼层——锚点插件
    $(".line_info").tabAnchor({
        tabTitle: 'info_floor', //tab锚点标题头部class
        tabTitlePlace: 'floor_fill_box', //tab锚点标题头部占位class
        tabMain: 'unit_floor', //tab锚点内容class
        tabSingel: 'unit_content', //tab锚点内容class
        tabStyle: 0, //0代表头部横向在内容中，1代表纵向在左右两侧
        tabFixedTopPosition: 0, //这个值代表tab锚点标题浮动的top位置
        tabFixedLeftPosition: 0, //这个值代表tab锚点标题浮动的left位置
        tabhide: 1000, //最小隐藏宽度
        relativeLeft: 'line_info',
        rec_origin: true
    });

}

function bindRoomPlans(rooms, $hotelItem, roomInfos, bindMode, showRate) {
    //----------------------------------------
    //bindMode: 1: bind the first tab [all-room-plans], 2: bind the [rate-plans] from the second tab
    //----------------------------------------

    //All room container
    //var allRoomIndex = 0;
    var $allRateRoomInfo = $('#room-info-template').tmpl(this);

    var $allRateRoomTRs = null;
    if ($hotelItem.find('.room_list').length > 0) {
        $hotelItem.find('.room_list').append($allRateRoomInfo);
    }
    else {
        $hotelItem.parent().find('.room_list').append($allRateRoomInfo);
    }

    if (roomInfos != null && roomInfos != undefined && roomInfos.length > 0) {

        //$hotelItem.find('.no-room-data').remove();

        //var ButtonIndex = 0;
        $(roomInfos).each(function () {
            if (this.plans.length > 0) {
                for (i = 0; i < this.plans.length; i++) {
                    if (this.plans[i].hotelGiftInfos.length > 0) {

                        var contents = SetGiftContent(this.plans[i].hotelGiftInfos);

                        if (contents.length > 0) {
                            this.plans[i].GiftContent = contents;
                            var reg = new RegExp("'txt", "g");
                            var arr = contents.match(reg);
                            if (arr.length > 0) {
                                this.plans[i].packageNum = arr.length;
                                this.plans[i].GiftStyle = "";
                            }
                            else {
                                this.plans[i].packageNum = 0;
                                this.plans[i].GiftStyle = "display:none";
                            }
                        }
                        else {
                            this.plans[i].packageNum = 0;
                            this.plans[i].GiftStyle = "display:none";
                        }

                    } else {
                        this.plans[i].GiftStyle = "display:none";

                    }
                    //if (this.plans[i].PromotionType == "JJINN_TJ" || this.plans[i].PromotionType == "JJINN_BY" || this.plans[i].PromotionType == "JJINN_BJ") {
                    //    this.plans[i].trTJ = "tejia";
                    //    this.plans[i].spanTJ = "gift1";
                    //    this.plans[i].nameTJ = "";
                    //    this.plans[i].GiftStyle = "";
                    //} else {
                    //    this.plans[i].trTJ = "";
                    //    this.plans[i].spanTJ = "gift";
                    //    this.plans[i].nameTJ = "name rate-brief-info";
                    //    this.plans[i].GiftStyle = "display:none;";
                    //}
                    if (CheckPromotionRateCode(this.plans[i].RateCode)) {
                        this.plans[i].trTJ = "tejia";
                        this.plans[i].spanTJ = "gift1";
                        this.plans[i].nameTJ = "";
                        this.plans[i].GiftStyle = "";
                    } else {
                        this.plans[i].trTJ = "";
                        this.plans[i].spanTJ = "gift";
                        this.plans[i].nameTJ = "name rate-brief-info";
                        this.plans[i].GiftStyle = "display:none;";
                    }
                }
            }
            var roomPlans = $('#room-plans-template').tmpl(this);



            if (bindMode == 1) {
                if (roomPlans.find('.room_type_info ul').length > 0) {
                    roomPlans.find('.room_type_info').html(showHotelRoomInfo(this));
                }
                else {
                    roomPlans.find('.room_prop_info_box').html(showHotelRoomInfo(this));
                }

                roomPlans.find('.rate-brief-info').remove();
                roomPlans.find('.room-brief-info').show();
            }
            else {
                roomPlans.find('.room-brief-info').remove();
                roomPlans.find('.rate-brief-info').show();
            }
            if ($allRateRoomTRs == null) {
                $allRateRoomTRs = $allRateRoomInfo.find('tbody');
            }
            $allRateRoomTRs = $allRateRoomTRs.append(roomPlans);

            var $tr = null;
            //if (roomPlans[2].className == "room_detail") $tr = $(roomPlans[2]);
            if ($(roomPlans[2]).hasClass("room_detail")) {
                $tr = $(roomPlans[2]);
            }
            else {
                $tr = $(roomPlans[0]);
            }

            //var planIndex = 0;
            $(this.plans).each(function () {
                var btnType = this.ButtonType;
                var btnmsg = this.ButtonMessage;

                var self = this;
                //房态
                if (this.HotelCalendarInfos.length > 0) {
                    var inventory = this.HotelCalendarInfos[0].inventory;
                    $(roomStatusNameData).each(function () {
                        if (this.minValue == "" && (inventory <= this.maxValue || (btnType == "ASH" && btnmsg == "满房"))) {
                            self.roomStatusText = this.text;
                            self.roomStatusClass = this.cssClass;
                            return false;
                        } else if (this.maxValue == "" && inventory > this.minValue) {
                            self.roomStatusText = this.text;
                            self.roomStatusClass = this.cssClass;
                            return false;
                        } else if (inventory > this.minValue && inventory <= this.maxValue) {
                            self.roomStatusText = this.text;
                            self.roomStatusClass = this.cssClass;
                            return false;
                        }
                    });
                }

                //marketPrice
                if (self.marketPrice != "- -") {
                    self.marketPrice = $("#currencyType").val() + self.marketPrice;
                    self.marketPriceCss = "store_price";
                } else {
                    self.marketPriceCss = "no_store_price";
                }

                //


                //data-breakfast
                this.Breakfast = '';
                $(breakfastNameData).each(function () {
                    if (this.key == self.BreakFastCount) {
                        self.Breakfast = this.text;
                    }
                });



                this.PriceInAll = this.Price * getDate();
                this.ScoreInAll = this.Score * getDate();
                if (this.PriceInAll <= 0) {
                    this.PriceInAll = '';
                }
                if (this.ScoreInAll <= 0) {
                    this.ScoreInAll = '';
                }

                var planItem = $('#plan-item-template').tmpl(this);

                if (initCriteria.brands == "BESTAY") {
                    $('.policy .ptips').remove();
                    planItem.find(".policy").html("<span class=\"policy-word\">" + guaranteePoliciesNameData[5].text + "</span>");
                }

                if (bindMode == 1) {
                    //rate name
                    if (this.RateDes != null && this.RateDes != undefined && this.RateDes != '') {
                        planItem.find('.promotion a').remove();
                    }
                    else {
                        planItem.find('.promotion .ptips').remove();
                    }

                    //gift
                    if (this.hotelGiftInfos.length > 0) {
                        planItem.find('.promotion .gift').show().attr('style', '');
                    }

                    planItem.find('.promotion .room-brief-info').remove();
                    planItem.find('.promotion .rate-brief-info').each(function () {
                        var $this = $(this);
                        if ($this.hasClass('gift') == false) {
                            $this.show().attr('style', '');
                        }
                    });
                }
                else {
                    if (planItem.find('.room_type_info ul').length > 0) {
                        planItem.find('.room_type_info ul').html(this.RateDes.replace('●', ''));
                    }
                    else {
                        planItem.find('.room_prop_info_box ul').html(this.RateDes.replace('●', ''));
                    }
                    planItem.find('.promotion .rate-brief-info').remove();
                    planItem.find('.promotion .room-brief-info').each(function () {
                        var $this = $(this);
                        if ($this.hasClass('gift') == false) {
                            $this.show().attr('style', '');
                        }
                    })
                }
                //internet
                if (this.IsInternet == true) {
                    planItem.find('.no-internet').remove();
                    planItem.find('.has-internet').empty();
                }
                else if (this.IsInternet == false) {
                    planItem.find('.no-internet').remove();
                    planItem.find('.has-free-internet').remove();
                }
                else {
                    planItem.find('.has-internet').empty();
                    planItem.find('.has-free-internet').remove();
                }

                //GuaranteePolicy
                if (this.GuaranteePolicyDes != null && this.GuaranteePolicyDes != undefined && this.GuaranteePolicyDes.length > 0) {
                    planItem.find('.policy .policy-word').remove();
                }
                else {
                    planItem.find('.cancel .ptips .cancel_tip').remove();
                }





                //all day price
                var hasPriceCount = 0;
                $(this.HotelCalendarInfos).each(function () {
                    if ((this.cash != '' && this.cash != '0.0') || (this.score != '' && this.score != '0.0')) {
                        hasPriceCount++;
                    }
                });
                //房态
                if (hasPriceCount >= 1) {


                    var $allDaysPriceBody = planItem.find('.all-days-price tbody');
                    var allDaysLen = this.HotelCalendarInfos.length;
                    if (this.HotelCalendarInfos.length > 0) {
                        var ADSP = { D1T: '', D1P: '', D1S: '', D2T: '', D2P: '', D2S: '', D3T: '', D3P: '', D3S: '', D4T: '', D4P: '', D4S: '', D5T: '', D5P: '', D5S: '', D6T: '', D6P: '', D6S: '', D7T: '', D7P: '', D7S: '' };
                        var ADSPTml = true;
                        for (var i = 0; i < allDaysLen; i++) {
                            var calInf = this.HotelCalendarInfos[i];

                            setPlaninfoDate(calInf, rooms, (i % 7) + 1, ADSP);

                            if (i % 7 == 0) {
                                ADSP.D1T = calInf.day;
                                ADSP.D1P = calInf.cash;
                                ADSP.D1S = calInf.score;
                                ADSPTml = true
                            }
                            else if (i % 7 == 1) {
                                ADSP.D2T = calInf.day;
                                ADSP.D2P = calInf.cash;
                                ADSP.D2S = calInf.score;
                            }
                            else if (i % 7 == 2) {
                                ADSP.D3T = calInf.day;
                                ADSP.D3P = calInf.cash;
                                ADSP.D3S = calInf.score;
                            }
                            else if (i % 7 == 3) {
                                ADSP.D4T = calInf.day;
                                ADSP.D4P = calInf.cash;
                                ADSP.D4S = calInf.score;
                            }
                            else if (i % 7 == 4) {
                                ADSP.D5T = calInf.day;
                                ADSP.D5P = calInf.cash;
                                ADSP.D5S = calInf.score;
                            }
                            else if (i % 7 == 5) {
                                ADSP.D6T = calInf.day;
                                ADSP.D6P = calInf.cash;
                                ADSP.D6S = calInf.score;
                            }
                            else if (i % 7 == 6) {
                                ADSP.D7T = calInf.day;
                                ADSP.D7P = calInf.cash;
                                ADSP.D7S = calInf.score;

                                if (ADSPTml == true) {
                                    ADSPTml = false;
                                    $allDaysPriceBody.append($('#days-price-template').tmpl(ADSP));
                                    var $tbDate = $allDaysPriceBody.find('.date td');
                                    var $tbPrice = $allDaysPriceBody.find('.price td');

                                    ADSP.D1T = ''; ADSP.D2T = ''; ADSP.D3T = ''; ADSP.D4T = ''; ADSP.D5T = ''; ADSP.D6T = ''; ADSP.D7T = '';
                                    ADSP.D1P = ''; ADSP.D2P = ''; ADSP.D3P = ''; ADSP.D4P = ''; ADSP.D5P = ''; ADSP.D6P = ''; ADSP.D7P = '';
                                    ADSP.D1S = ''; ADSP.D2S = ''; ADSP.D3S = ''; ADSP.D4S = ''; ADSP.D5S = ''; ADSP.D6S = ''; ADSP.D7S = '';
                                    for (var j1 = 0; j1 < 7; j1++)
                                    {
                                        ADSP["D" + (j1 + 1) + "cashtxt"] = '';
                                        ADSP["D" + (j1 + 1) + "scoretxt"] = '';
                                        ADSP["D" + (j1 + 1) + "plancashcounttxt"] = '';
                                        ADSP["D" + (j1 + 1) + "planscorecounttxt"] = '';
                                        ADSP["D" + (j1 + 1) + "plancountstyletxt"] = '';
                                    }
                                }
                            }
                        }
                        if (ADSPTml == true) {
                            $allDaysPriceBody.append($('#days-price-template').tmpl(ADSP));
                        }
                        if (planItem.find('.all-days-price tbody tr').length > 0) {

                            planItem.find('.all-days-price tbody .days-cash-val').each(function () {
                                var cashVal = $(this).text();
                                if (cashVal.length > 0 && cashVal != "0" && cashVal != "0.0") {
                                    $(this).parent().show().attr('style', '');
                                }
                            });
                            planItem.find('.all-days-price tbody .days-score-val').each(function () {
                                var scoreVal = $(this).text();
                                if (scoreVal.length > 0 && scoreVal != "0" && scoreVal != "0.0") {
                                    $(this).parent().show().attr('style', '');
                                }
                            });

                            planItem.find('.all-days-price').show();

                            planItem.find('.price-only').remove();
                        }
                        else {
                            planItem.find('.all-days-price').remove();
                        }
                    }
                }

                //has no score
                if (this.Score == "" || this.Score == "0.0") {
                    planItem.find('.price-has-score').remove();
                    planItem.find('.price .price-plus').remove();
                    planItem.find('.total_price .price-plus').remove();
                }

                //has no price
                if (this.Price == "" || this.Price == "0.0") {
                    planItem.find('.price .price-symbol').remove();
                    planItem.find('.price .price-plus').remove();
                    planItem.find('.price .price-has-price').remove();
                    planItem.find('.total_price .price-symbol').remove();
                    planItem.find('.total_price .price-plus').remove();
                    planItem.find('.total_price .price-has-price').remove();
                }

                var btnMessage = '';
                if (this.ButtonMessage != null && this.ButtonMessage != '') {
                    btnMessage = this.ButtonMessage;
                }

                if (this.ButtonType == "ASH") {
                    var notBook = planItem.find('.btn_buy');
                    planItem.find('.btn_buy').addClass('unbtn')
                        .attr('disabled', 'disabled')
                        .attr('title', btnMessage)
                        .show()
                        .attr('style', '');
                    var ja, en, ch;
                    switch (this.ButtonMessageType) {
                        case "CHECKIN_OUT_OF_RATE_DATE":
                            ja = "フル";
                            en = "Time-limited";
                            ch = "限时预订";
                            break;
                        case "MEMBER_LEVEL_NOT_FIT_RATE":
                            ja = "アップグレード";
                            en = "Upgrade";
                            ch = "升级";
                            break;
                        default:
                            ja = "フル";
                            en = "Full";
                            ch = "订完";
                            break;
                    }
                    var lang = $("html").attr("lang");
                    if (lang.toUpperCase() == "EN") {
                        notBook.html(en);
                    } else if (lang.toUpperCase() == "JA") {
                        notBook.html(ja);
                    } else {
                        notBook.html(ch);
                    }
                    //notBook.html(notBook.attr("data-notBooking"));

                    planItem.find('.all_day').remove();
                    planItem.find('.login-btn-container').remove();
                    planItem.find('.upgrade-btn-container').remove();
                }
                else if (this.ButtonType == "BOOKING") {
                    var $btn = planItem.find('td.btn>.btn_buy');
                    if (this.Score > 0) {
                        $btn.addClass('btn2');
                    }

                    $btn.show().attr('style', '');

                    if ($btn.length > 0) {
                        var newOrderUrl = $('#new-order-url-template').tmpl({
                            hotelId: initCriteria.hotelId
                            , planId: this.PlanId
                            , checkInDate: initCriteria.checkInDate
                            , checkOutDate: initCriteria.checkoutDate
                            , score: this.Score
                            , rateCode: this.RateCode
                            , JjCode: this.JjCode
                            , PromotionType: this.PromotionType
                        });
                        $btn[0].href = newOrderUrl.text();
                    }

                    planItem.find('.all_day').remove();
                    planItem.find('.login-btn-container').remove();
                    planItem.find('.upgrade-btn-container').remove();
                }
                else if (this.ButtonType == "CHECK") {
                    planItem.find('.all_day')
                        .show()
                        .attr('style', '');

                    var btnMessageType = this.ButtonMessageType;
                    var preDays = parseInt(this.ButtonMessageAttr);

                    planItem.find(".all_main .txt b.col").text(btnMessage);

                    if (isNaN(preDays)) {
                        preDays = 1;
                    }

                    var isPreBooking = "1";
                    if (btnMessageType == "CONTINUATION_NOT_FIX_LIMIT_DAYS") {
                        //连续入住
                        isPreBooking = "0";
                        setRoomCheckInOutDate(planItem, false, preDays);
                    }
                    else if (btnMessageType == "BEFORE_RESV_PRICE") {
                        //提前预定
                        isPreBooking = "1";
                        setRoomCheckInOutDate(planItem, true, preDays);
                    }
                    var checkOutControl = planItem.find(".book_date_checkOut");
                    checkOutControl.data("isPreBooking", isPreBooking);
                    checkOutControl.data("bookingDays", preDays);

                    planItem.find(".btn_all").click(function () {
                        $(this).parent().find(".all_main").show();
                    });
                    planItem.find(".close").click(function () {
                        $(this).parents(".all_main").hide();
                    });

                    var $allDayBookingBtn = planItem.find('.all_day .btn_book').on('click', function () {
                        var $thisParent = $(this).parent();

                        var newCheckInDate = $thisParent.find('input.book_date_checkIn').val();
                        var newCheckOutDate = $thisParent.find('input.book_date_checkOut').val()
                        if (newCheckInDate != '' && newCheckOutDate != '') {
                            var $parentTD = $(this).parents('td.btn');

                            this.href = $('#new-order-url-template').tmpl({
                                hotelId: initCriteria.hotelId
                                , planId: $parentTD.data('plan-id')
                                , checkInDate: newCheckInDate
                                , checkOutDate: newCheckOutDate
                                , score: $parentTD.data('plan-score')
                                , rateCode: $parentTD.data('plan-rate-code')
                                , JjCode: this.JjCode
                                , PromotionType: this.PromotionType
                            }).text();
                        }
                    });

                    planItem.find('td>.btn_buy').remove();
                    planItem.find('.login-btn-container').remove();
                    planItem.find('.upgrade-btn-container').remove();
                }
                else if (this.ButtonType == "LOGIN") {
                    planItem.find('.login-btn-container')
                        .show()
                        .attr('style', '');

                    planItem.find('.btn_buy').remove();
                    planItem.find('.upgrade-btn-container').remove();
                    planItem.find('.all_day').remove();
                    if (this.Score != "") {
                        //hide price
                        planItem.find('.price .price-only').remove();
                        planItem.find('.total_price .price-only').remove();
                        planItem.find('.all-days-price').remove();
                        planItem.find('.login_before').show();
                        if (btnMessage != "") planItem.find('.login_before .login_tip').html(btnMessage);
                        planItem.find('.login_before').on('click', function () {
                            fastLogin(initCriteria.langName);
                        });
                    }
                    //show and goto login panel
                    planItem.find('.login-btn-container a').on('click', function () {
                        //$("#login_box").show();
                        ////为页面添加锁屏样式
                        //$(".wrapper").addClass("wrapper_locked");
                        //$("#holder").css("z-index", 1);
                        //$(".jinjian_top_bar").addClass("wrapper_locked");
                        //textWaterMarkEvents("login_username", $("#login_username").attr("data-watermark"), "#dedede", "#777");
                        //passwordWaterMarkEvents("login_password", "#dedede", "#777");
                        //$('#login_username').focus();
                        fastLogin(initCriteria.langName);
                    });

                    planItem.find('.login-btn-container a').attr('title', btnMessage);

                }
                else if (this.ButtonType == "UPGRADE" || this.ButtonType == "UPGRADE_GOLD" || this.ButtonType == "UPGRADE_PLATINUM") {
                    planItem.find('.upgrade-btn-container')
                        .show()
                        .attr('style', 'login_before');

                    planItem.find('.login-btn-container').remove();
                    planItem.find('.all_day').remove();
                    //planitem.ButtonMessage = this.roomInfos[i].plans[a].ButtonMessage;
                    //upgrade link
                    var upgradeBtn = planItem.find('.upgrade-btn-container a');
                    upgradeBtn.attr('title', btnMessage);
                    if (this.ButtonType == "UPGRADE_PLATINUM" && upgradeBtn.length == 1) {
                        upgradeBtn[0].href = upgradeBtn.data('gold');
                        upgradeBtn.data('gold', '');
                        upgradeBtn.attr('title', btnMessage);
                    }
                }

                $tr = $tr.after(planItem);
                $tr = planItem;

            });

            if (this.CheckInDate == null || this.CheckInDate == undefined || this.CheckInDate == '') {
                roomPlans.find('.rate-checkin-date').remove();
            }

            roomPlans.find('.toggle').bind("click", function () {
                if ($(this).attr("class").indexOf("expanded") < 0) {
                    $(this).addClass("expanded");
                    $(this).parent().parent().next().show();
                    if ($("body.en").length == 1) {
                        $(this).html("▲&nbsp;Close room details");
                    } else if ($("body.ja").length == 1) {
                        $(this).html("▲&nbsp;お部屋の詳細をクローズ");
                    } else {
                        $(this).html("▲&nbsp;收起房间详情");
                    }
                } else {
                    $(this).removeClass("expanded");
                    if ($("body.en").length == 1) {
                        $(this).html("▼&nbsp;See room details");
                    } else if ($("body.ja").length == 1) {
                        $(this).html("▼&nbsp;お部屋の詳細をごらんになる");
                    } else {
                        $(this).html("▼&nbsp;查看房间详情");
                    }
                    $(this).parent().parent().next().hide();
                }
            });
        });


        setRoomPlanEffect($hotelItem);

        if (showRate) {
            $allRateRoomInfo.show();
        }
        else {
            $allRateRoomInfo.hide();
        }

    }
    else {

        if (showRate) {
            $allRateRoomInfo.show();
        }
        $hotelItem.find('.toggle').remove();
    }
}

function setPlaninfoDate(calInf, planitem, index, targetObj) {
    var indexstring = "D" + index;
    if (calInf.cash || calInf.score) {
        if (calInf.inventory == 0) {
            targetObj[indexstring + "cashtxt"] = "满房";
            targetObj[indexstring + "scoretxt"] = "";
        }
        else if (calInf.inventory < 5) {
            if (calInf.cash) {
                //targetObj[indexstring + "plancashcounttxt"] = "(少)";
                targetObj[indexstring + "cashtxt"] = planitem.CurrencyType + calInf.cash;
                targetObj[indexstring + "plancashcounttxt"] = "(少)";
            }
            else {
                targetObj[indexstring + "scoretxt"] = calInf.score + $("#scoretxt").val();
                targetObj[indexstring + "planscorecounttxt"] = "(少)";
            }
            targetObj[indexstring + "plancountstyletxt"] = "style=color:#D70000";
        }
        else {
            if (calInf.cash) {
                targetObj[indexstring + "cashtxt"] = planitem.CurrencyType + calInf.cash;
            }
            if (calInf.score) {
                targetObj[indexstring + "scoretxt"] = calInf.score + $("#scoretxt").val();
            }
        }
    }
    else {
        targetObj[indexstring + "cashtxt"] = "";
        targetObj[indexstring + "scoretxt"] = "";
        targetObj[indexstring + "plancountstyletxt"] = "";
        targetObj[indexstring + "planscorecounttxt"] = "";
        targetObj[indexstring + "plancashcounttxt"] = "";
        targetObj[indexstring + "LL"] = "style=display:none";
    }
}


function gotoCommentTab() {
    var hotelInfoTabs = $(".hotel_other_info_box .tab_title_box").children();
    hotelInfoTabs.each(function () {
        if ($(this).attr("content_id") == "comment" && $(this).css("display") != "none") {
            $(this).click();
        }
    });
    location.href = "#hotel_intro_info";
}

function setHotelInfoTab() {
    var anchorText = window.location.hash;
    var hotelInfoTabs = $(".hotel_other_info_box .tab_title_box").children();
    if (anchorText == "#hotel_intro_info") {
        hotelInfoTabs.each(function () {
            if ($(this).attr("content_id") == "comment" && $(this).css("display") != "none") {
                $(this).click();
            }
        });
    }
    else {
        for (var i = 0; i < hotelInfoTabs.length; i++) {
            if ($(hotelInfoTabs[i]).css("display") != "none") {
                $(hotelInfoTabs[i]).click();
                break;
            }
        }
    }
}

//设置礼包名和礼包信息
function SetGiftContent(hotelGiftInfos) {
    var giftContent = "";
    for (var b = 0; b < hotelGiftInfos.length; b++) {
        var giftStartDate = new Date(parseInt(hotelGiftInfos[b].startDate));
        var giftEndDate = new Date(parseInt(hotelGiftInfos[b].endDate));
        var isShow = GiftIsShow(giftStartDate, giftEndDate);
        if (!isShow)
            continue;
        //礼包最多显示2个
        if (b > 1)
            break;

        giftContent += "'title" + (b + 1) + "':'" + hotelGiftInfos[b].name + "',";
        if (hotelGiftInfos[b].content != null && hotelGiftInfos[b].content != undefined && hotelGiftInfos[b].content != "") {
            giftContent += "'txt" + (b + 1) + "':'" + replaceEscape(hotelGiftInfos[b].content).replace("\\n", ",") + "',";
        }
        else {
            giftContent += "'txt" + (b + 1) + "':'" + replaceEscape(hotelGiftInfos[b].remark).replace("\\n", ",") + "',";
        }
        giftContent += "'time" + (b + 1) + "':'";

        if (hotelGiftInfos[b].startDate != null && hotelGiftInfos[b].startDate != undefined) {
            giftContent += "•&nbsp;开始时间：" + new Date(parseInt(hotelGiftInfos[b].startDate)).format("yyyy-MM-dd") + "<br>";
        }
        if (hotelGiftInfos[b].endDate != null && hotelGiftInfos[b].endDate != undefined) {
            giftContent += "•&nbsp;结束时间：" + new Date(parseInt(hotelGiftInfos[b].endDate)).format("yyyy-MM-dd") + "<br>";
        }
        if (hotelGiftInfos[b].weeks != null && hotelGiftInfos[b].weeks != undefined) {
            giftContent += "•&nbsp;有效星期：星期" + hotelGiftInfos[b].weeks;
        }
        giftContent += "'";
        if (b < hotelGiftInfos.length - 1) {
            giftContent += ",";
        }
    }
    return giftContent;
}

//根据入住日期判断，礼包是否需要显示，true:显示，false:不显示
function GiftIsShow(giftStartDate, giftEndDate) {
    var dateCheckIn = new Date($(".dateCheckIn").val());
    var dateCheckOutTemp = new Date($(".dateCheckOut").val());
    var dateCheckOut = new Date(dateCheckOutTemp.getFullYear(), dateCheckOutTemp.getMonth(), dateCheckOutTemp.getDate() - 1);
    if ((giftStartDate <= dateCheckIn && dateCheckIn <= giftEndDate) || (giftStartDate <= dateCheckOut && dateCheckOut <= giftEndDate)) {
        return true;
    }
    else {
        return false;
    }
}

var escapeable = /["\\\x00-\x1f\x7f-\x9f]/g,
    meta = {
        '\b': '\\b',
        '\t': '\\t',
        '\n': '\\n',
        '\f': '\\f',
        '\r': '\\r',
        '"': '\\"',
        '\\': '\\\\'
    };


var replaceEscape = function (string) {
    if (string.match(escapeable)) {
        return '"' + string.replace(escapeable, function (a) {
            var c = meta[a];
            if (typeof c === 'string') {
                return c;
            }
            c = a.charCodeAt();
            return '\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
        }) + '"';
    }
    return string;
}

//时间戳转年月日
Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S": this.getMilliseconds()

    };
    if (/(y+)/.test(format) || /(Y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;


};
//房型介绍20160505
function showHotelRoomInfo(roominfo) {
    var strHtml = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"line-height:26px\"><tbody>";
    var tdList = [];
    if (roominfo.Area != "") {
        if (roominfo.BedWidth == "") tdList.push("<td width=\"25%\">床型:" + roominfo.BedType + "</td>");
        else tdList.push("<td width=\"25%\">床型:" + roominfo.BedType + "（" + roominfo.BedWidth + "）</td>");
    }
    if (roominfo.Area != "") tdList.push("<td width=\"25%\">面积：" + roominfo.Area + "</td>");
    if (roominfo.Floor != "") tdList.push("<td width=\"25%\">楼层：" + roominfo.Floor + "</td>");
    if (roominfo.IsExtraBed != "") tdList.push("<td width=\"25%\">" + roominfo.IsExtraBed + "</td>");
    if (roominfo.Rollway != "0" && roominfo.Rollway != "") tdList.push("<td width=\"25%\">可加床数量：" + roominfo.Rollway + "</td>");
    if (roominfo.IsWindows != "") tdList.push("<td width=\"25%\">" + roominfo.IsWindows + "</td>");
    if (roominfo.IsInternet != "") tdList.push("<td width=\"25%\">" + roominfo.IsInternet + "</td>");
    if (roominfo.IsNonSmokingRoom != "") tdList.push("<td width=\"25%\">" + roominfo.IsNonSmokingRoom + "</td>");
    for (var i = 0; i < tdList.length; i++) {
        if ((i + 1) % 4 == 1) strHtml += "<tr>";
        strHtml += tdList[i];
        if ((i + 1) % 4 == 0) strHtml += "</tr>";
        else if (i + 1 == tdList.length) strHtml += "</tr>";
    }
    strHtml += "</tbody></table>";
    if (roominfo.Description != "<li>其他：</li>") strHtml += roominfo.Description.replace('●', '').replace('li', 'p').replace('其他事项：', '');
    return strHtml;
}

//20160520显示酒店logo
$(function () {
    //显示酒店不同类型标识ICON
    $('.hotel-level-icon img').hover(function () {
        var text = $(this).attr('data-tip');
        $('.hotel-level-tip').text(text).show();
    }, function () {
        $('.hotel-level-tip').text('').hide();
    });
});