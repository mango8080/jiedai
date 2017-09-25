// JavaScript Document
$(function () {

    ////select模拟
    //if ($(".select .selBox").length > 0) {
    //    $(".select .selBox").each(function () {
    //        var valTxt = $(this).find("li.sel").html();
    //        var valTtm = "<span class='valTxt'>" + valTxt + "</span>";
    //        var num = $(this).parents(".select").find(".valTxt");
    //        if (num.length == 0) {
    //            $(this).before(valTtm);
    //        } else {
    //            num.html($(this).find("li.sel").html());
    //        }
    //    });
    //    $(".select .valTxt").click(function () {
    //        $(".select .selBox").hide();
    //        $(this).parents(".select").find(".selBox").slideToggle();
    //    });
    //    $(".select li").click(function () {
    //        var txt = $(this).html();
    //        $(this).parents(".select").find(".valTxt").html(txt);
    //        $(this).addClass("sel").siblings().removeClass("sel");
    //        $(this).parents(".select").find(".selBox").hide();
    //    });
    //    $(document).bind("click", function (e) {
    //        var target = $(e.target);
    //        if (target.closest(".select").length == 0) {
    //            $(".selBox").hide();
    //        }
    //    });
    //}
    //海外酒店城市
    if ($(".select .abroadCity").length > 0) {
        $(".select .abroadCity").each(function () {
            $(this).focus(function () {
                $(this).parent().find(".selBox").show();
            });
            $(".select li").click(function () {
                var txt = $(this).html();
                $(this).parents(".select").find(".abroadCity").val(txt);
                $(this).parents(".select").find("label.tipTxt").hide();
                $(this).addClass("sel").siblings().removeClass("sel");
                $(this).parents(".select").find(".selBox").hide();
            });
            $(document).bind("click", function (e) {
                var target = $(e.target);
                if (target.closest(".select").length == 0) {
                    $(".selBox").hide();
                }
            });
        });

    }

    //获取当前日期的毫秒数
    function getTimeByDateStr(dateStr) {
        var year = parseInt(dateStr.substring(0, 4));
        var month = parseInt(dateStr.substring(5, 7), 10) - 1;
        var day = parseInt(dateStr.substring(8, 10), 10);
        return new Date(year, month, day).getTime();
    }

    //文本框水印
    function inputTipText() {
        $("input[class*=inputText]").each(function () {
            var valTxt = $(this).attr("title");
            var htm = "<label class='tipTxt'>" + valTxt + "</label>"
            $(this).after(htm);
            $(this).keyup(function () { ($(this).val() == "") ? $(this).next().show() : $(this).next().hide(); });
            if ($(this).val() == "") {
                $(this).next().show();
            } else {
                $(this).next().hide();
            }
            $(".tipTxt").click(function () {
                $(this).prev().focus();
            });
        });
    }
    inputTipText();

    //分类切换
    if ($(".tabs").length > 0) {
        $(".tabs span").click(function () {
            var tabs = $(this).parents().children("span");
            var panels = $(this).parents(".tabBox").find(".tabMain");
            var more = $(this).parents(".tabBox").find(".more");
            var index = $.inArray(this, tabs);
            tabs.removeClass("on").eq(index).addClass("on");
            panels.hide().eq(index).show();
            more.hide().eq(index).show();
        });
    }

    //图片幻灯片
    if ($(".slidebox").length > 0) {
        $('.slidebox').imageSlide({
            imgShow: '.fouce span',
            trigger: '.slidebox ul li',
            activeClass: 'active'
        });
    }

    //城市选择器
    if ($("#cityInfo").length > 0) {
        var test = new Vcity.CitySelector({ input: 'cityInfo' });
    }

    //关键字提示效果
    if ($(".kw_input").length > 0) {
        $('.kw_input').citySelect({});
    }

    //checkbox美化
    if ($(".chklist").length > 0) {
        $(".chklist").hcheckbox();
    }

    //搜索框
    if ($(".attr").length > 0) {
        $(".attr a").click(function () {
            $(this).parents(".attr").find(".first").removeClass("first_on");
            $(this).toggleClass("on");
        });
        $(".attr .first").click(function () {
            $(this).addClass("first_on");
            $(this).parent().find("a").removeClass("on");
        });

        $(".lineInfo a").click(function () {
            $(this).addClass("on").siblings().removeClass("on");
        });
    }

    //日历效果
    if ($(".dateCheckIn").length > 0) {
        var today = new Date();
        $(".dateCheckIn").datepicker({
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
            maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 90),
            numberOfMonths: 2,
            changeMonth: false,
            changeYear: false,
            beforeShow: function () {
                setTimeout(
                    function () {
                        $('#ui-datepicker-div').css("z-index", 15);
                    }
                );
            },
            onSelect: function (dateText, inst) {
                var next_day = new Date(getTimeByDateStr(dateText) + 1 * 24 * 60 * 60 * 1000);
                var next_month = (parseInt(next_day.getMonth()) + 1).toString();
                if (next_month.length == 1) {
                    next_month = "0" + next_month;
                }
                var next_date = (next_day.getDate()).toString();
                if (next_date.length == 1) {
                    next_date = "0" + next_date;
                }
                $(".dateCheckOut").datepicker('option', 'minDate', new Date(getTimeByDateStr(dateText) + 1 * 24 * 60 * 60 * 1000));
                $(".dateCheckOut").datepicker('option', 'maxDate', new Date(getTimeByDateStr(dateText) + 14 * 24 * 60 * 60 * 1000));
                $(".dateCheckOut").val(next_day.getFullYear() + "-" + next_month + "-" + next_date);
                $(".dateCheckIn").attr("title", $(".dateCheckIn").val());
            }
        });


        var check_out_date = null;//最小时间（范围）
        var check_in_date = null;//入住时间
        var check_out_max_date = null;//最大时间（范围）
        if ($(".dateCheckIn").val() != "") {
            check_in_date = $(".dateCheckIn").val();
        }
        if (check_in_date == null) {
            check_out_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
        } else {
            check_out_date = new Date(getTimeByDateStr(check_in_date) + 1 * 24 * 60 * 60 * 1000);
            check_out_max_date = new Date(getTimeByDateStr(check_in_date) + 14 * 24 * 60 * 60 * 1000);
        }
        $(".dateCheckOut").datepicker({
            minDate: check_out_date,
            maxDate: check_out_max_date,
            numberOfMonths: 2,
            changeMonth: false,
            changeYear: false,
            regional: "ZH",
            beforeShow: function () {
                setTimeout(
                    function () {
                        $('#ui-datepicker-div').css("z-index", 15);
                    }
                );
            },
            onSelect: function (dateText, inst) { $(".dateCheckOut").attr("title", $(".dateCheckOut").val()); }
        });
        $.datepicker.setDefaults($.datepicker.regional["ZH"]);


    }






    if ($(".room_info").length > 0) {
        $(".room a").click(function () {
            $(this).parents("tr").next(".clicked").toggleClass("hidden");
        });

        $(".room_info .price b").hover(function () {
            var left = $(this).offset().left - 25;
            var top = $(this).offset().top + 28;
            $(".priceTip").css({ left: left, top: top });
            $(".priceTip").show();
        }, function () {
            $(".priceTip").hide();
        });
    }

    if ($(".listmain").length > 0) {
        //地图展开收起
        $(".map_unfold").toggle(function () {
            $(this).parents(".listmain").addClass("listmain_dev");
            $(".float_side").removeClass("fs_box");
            $(".float_side").removeClass("fixedtop2");
            $(".tool_box2 .checkbox").removeClass("checked");
            $(this).html("展开地图");
            scroll();
        }, function () {
            $(this).parents(".listmain").removeClass("listmain_dev");
            $(".float_side").addClass("fs_box");
            $(".tool_box2 .checkbox").addClass("checked");
            $(this).html("收起地图");
            scroll();
        });
        $(".tool_box2 .checkbox").toggle(function () {
            $(this).removeClass("checked");
            $(".float_side").removeClass("fs_box");
            $(".float_side").removeClass("fixedtop2");
        }, function () {
            $(this).addClass("checked");
            $(".float_side").addClass("fs_box");
        });

        //滚动悬浮
        function scroll() {
            var f2 = $(".float_side").offset().top;
            $(window).scroll(function () {
                var st = $(document).scrollTop();
                if (st > f2) {
                    $('.base_wrap_dev .fs_box').addClass("fixedtop2");
                } else {
                    $('.base_wrap_dev .fs_box').removeClass("fixedtop2");
                }
            });
        }
        scroll();
    }

    if ($(".sm2").length > 0) {
        $(".sm2 .map_unfold").click(function () {
            $(this).toggleClass("map_fold");
            $(".side_map .map_box").toggle();
        });
    }

    $(".avoid_login_box .check_btn").click(function () {
        $(this).toggleClass("checked");
    });
    $(".loginbox").hover(function () {
        $("#login_box").fadeIn();
    }, function () {
        $("#login_box").fadeOut();
    });


    if ($(".syqInfo").length > 0) {
        $(".search_form .syqInfo .more").click(function () {
            $(".syqInfo").toggleClass("hauto");
        });
    }


});

if ($(".summary").length > 0) {
    var sheight = $(".summary").height();
    if (sheight > 98) {
        $(".summary").addClass("h96");
    } else {
        $(".summary").removeClass("h96")
    }
    $(".summary .icon").click(function () {
        $(this).parent().toggleClass("hauto");
    });
}



