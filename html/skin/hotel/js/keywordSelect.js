// JavaScript Document
$.fn.citySelect = function (values) {
    //var cityHtml = '<div class="kerword_box">' +
    //    '<p class="clearfix"><span class="hot_head">热门地标</span><br /><a href="javascript:;">人民广场</a><a href="javascript:;">陆家嘴</a><a href="javascript:;">世博园</a><a href="javascript:;">自贸区</a></p>' +
    //    '<p>交通枢纽<br /><a href="javascript:;">上海火车站</a><a href="javascript:;">虹桥火车站</a><a href="javascript:;">上海南站</a><a href="javascript:;">浦东机场</a><a href="javascript:;">虹桥机场</a><a href="javascript:;">一号线</a><a href="javascript:;">磁悬浮</a><a href="javascript:;">长途汽车站</a>' +
    //    '</p><p class="last">热门商圈<br /><a href="javascript:;">宝山万达</a><a href="javascript:;">五角场</a><a href="javascript:;">淮海路</a><a href="javascript:;">徐家汇</a><a href="javascript:;">大世界</a><a href="javascript:;">正大广场</a>' +
    //    '</p></div><div class="word_slide"><a href="javascript:;"><b class="cityname">上海</b><b class="cityspell">shanghai</b></a><a href="javascript:;"><b class="cityname">北京</b><b class="cityspell">shanghai</b></a>' +
    //    '</div>';
    var cityHtml = '<div class="kerword_box"></div>';
    var key = "";
    var keyWord = "";
    function getCitylist() {
        return $('.kerword_box');
    }
    function getHidebox() {
        return $('.kerword_box,.kw .tipTxt');
    }
    $(this).focus(function () {
        if ($(this).val() == "") {
            $(this).next().show();
            $('.kerword_box').hide();
        } else {
            $(this).next().hide();
            $('.kerword_box').show();
        }

        getCitylist().size() > 0 ? '' : $('.kw').append(cityHtml);
        var pos = $(this).offset();
        $('.kerword_box').hide();

        $('.kerword_box a').click(function () {
            alert(2);
            var val = $(this).html();
            $('.kw_input').val(val);
            getHidebox().hide();
        });
        $('.kerword_box a').click(function () {
            alert(3);
            var val = $(this).find(".cityname").html();
            $('.kw_input').val(val);
            getHidebox().hide();
        });
    }).blur(function () {
        //$(this).next().show();
    });

    $(this).bind('input propertychange', function () {
        //console.log('test');
        var inputVal = $(".kw_input").val();
        var CityInputVal = $(".city_input").val();
        if (keyWord != inputVal) {
            keyWord = inputVal;
            if (key != "" && key != undefined) {
                key = "";
                $('.kerword_box').hide();

            } else {
                $('.kerword_box').html("");
                if (inputVal != '') {
                    setTimeout(function () {

                        if (inputVal == $(".kw_input").val()) {
                            var param = {
                                city: CityInputVal,
                                word: inputVal,
                                language: $("#contextLanguage").val()
                                //language: 'zh-CN' //TODO: temp haard code
                            };
                            $('.kw_input').attr("data-type", "");
                            $.ajax({
                                type: 'POST',
                                url: "/service/queryEsKeyword",
                                dataType: 'JSON',
                                data: param,
                                cache: false,
                                success: function (responseData) {
                                    var result = JSON.parse(responseData);

                                    var myhtml = "";
                                    if (result != undefined && result != null && result.keywords != undefined && result.keywords != null) {
                                        var len = result.keywords.length;
                                        var HotelHtml = "";
                                        var HotelLen = 0;
                                        var LANDMARKHtml = "";
                                        var LANDMARKLen = 0;
                                        var MetroHtml = "";
                                        var MetroLen = 0;
                                        var AirHtml = "";
                                        var AirLen = 0;
                                        var ScenicHtml = "";
                                        var ScenicLen = 0;
                                        var HospitalHtml = "";
                                        var HospitalLen = 0;
                                        var SchoolHtml = "";
                                        var SchoolLen = 0;
                                        for (var i = 0; i < len; i++) {
                                            var word = result.keywords[i];
                                            var cityName = word.nameValueZH;
                                            var Hotel1 = "酒店";
                                            var LANDMARK = "地标商圈";
                                            var Metro = "轨道交通";
                                            var Air = "火车站飞机场";
                                            var Scenic = "景点";
                                            var Hospital = "医院";
                                            var School = "学校";

                                            if ($("#contextLanguage").val() == "en") {
                                                cityName = word.nameValueEN;
                                                Hotel1 = "Hotel";
                                                LANDMARK = "LANDMARK";
                                                Metro = "Metro";
                                                Air = "Air&Train";
                                                Scenic = "Scenic";
                                                Hospital = "Hospital";
                                                School = "School";
                                            }
                                            else if ($("#contextLanguage").val() == "ja-JP") {
                                                cityName = word.nameValueJA;
                                                Hotel1 = "ホテル";
                                                LANDMARK = "ランドマーク";
                                                Metro = "地下鉄";
                                                Air = "駅&空港";
                                                Scenic = "スポット";
                                                Hospital = "病院";
                                                School = "学校";
                                            }
                                            else {
                                                cityName = word.nameValueZH;
                                                Hotel1 = "酒店";
                                                LANDMARK = "地标商圈";
                                                Metro = "轨道交通";
                                                Air = "火车站飞机场";
                                                Scenic = "景点";
                                                Hospital = "医院";
                                                School = "学校";
                                            }
                                            //console.log(word);
                                            //myhtml += "<a href=\"javascript:;\"><b class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\">" + word.KeyWordName + "</b></a>";
                                            if (word.Type == "HOTELNAME") {//酒店名称
                                                if (++HotelLen <= 6) {
                                                    //HotelHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                    var openUrl = "/HotelSearch?queryWords=" + word.KeyWordName + "&cityName=" + cityName;
                                                    HotelHtml += "<a href=\"" + openUrl + "\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "LANDMARK" || word.Type == "BUSINESS")//商圈地标
                                            {
                                                if (++LANDMARKLen <= 4) {
                                                    LANDMARKHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "METRO") {//轨道交通
                                                if (++MetroLen <= 4) {
                                                    MetroHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "AIR" || word.Type == "TRAIN") {//火车站飞机场
                                                if (++AirLen <= 4) {
                                                    AirHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "SCENIC") {//景点
                                                if (++ScenicLen <= 2) {
                                                    ScenicHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "HOSPITAL") {//医院
                                                if (++HospitalLen <= 2) {
                                                    HospitalHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                            if (word.Type == "SCHOOL") {//学校
                                                if (++SchoolLen <= 2) {
                                                    SchoolHtml += "<a href=\"javascript:;\" class=\"cityname ellipsis\" data-kw-type=\"" + word.Type + "\" title=\"" + word.KeyWordName + "\" data-cityname='" + cityName + "'>" + word.KeyWordName + "</a>";
                                                }
                                            }
                                        }
                                        if (HotelHtml != "") {
                                            HotelHtml = "<p class=\"clearfix\"><span class=\"hot_head\">" + Hotel1 + "</span><br />" + HotelHtml + "</p>";
                                        }
                                        if (LANDMARKHtml != "") {
                                            LANDMARKHtml = "<p class=\"clearfix\">" + LANDMARK + "<br />" + LANDMARKHtml + "</p>";
                                        }
                                        if (MetroHtml != "") {
                                            MetroHtml = "<p class=\"clearfix\">" + Metro + "<br />" + MetroHtml + "</p>";
                                        }
                                        if (AirHtml != "") {
                                            AirHtml = "<p class=\"clearfix\">" + Air + "<br />" + AirHtml + "</p>";
                                        }
                                        if (ScenicHtml != "") {
                                            ScenicHtml = "<p class=\"clearfix\">" + Scenic + "<br />" + ScenicHtml + "</p>";
                                        }
                                        if (HospitalHtml != "") {
                                            HospitalHtml = "<p class=\"clearfix\">" + Hospital + "<br />" + HospitalHtml + "</p>";
                                        }
                                        if (SchoolHtml != "") {
                                            SchoolHtml = "<p class=\"clearfix\">" + School + "<br />" + SchoolHtml + "</p>";
                                        }
                                        myhtml += HotelHtml + LANDMARKHtml + MetroHtml + AirHtml + ScenicHtml + HospitalHtml + SchoolHtml;
                                        myhtml = $(myhtml);
                                        myhtml.last().addClass("last");
                                        if (len > 0) {
                                            $('.kerword_box').html(myhtml);
                                            $('.kerword_box a').each(function () {
                                                $(this).on('click', function () {
                                                    var val = $(this).text();
                                                    $('.kw .kw_input').val(val);
                                                    $(".city_input").val($(this).data("cityname"));
                                                    var type = $(this).find(".cityname").data("kw-type");
                                                    $('.kw_input').attr("data-type", type);
                                                    $('.kerword_box').hide();
                                                    if (cityDistrict && cityDistrict.fulldisname) {
                                                        cityDistrict.fulldisname = "";
                                                    }
                                                });
                                            });

                                        }
                                        else {
                                            if (inputVal == $(".kw_input").val()) {
                                                var msg = "";
                                                if ($("#contextLanguage").val().toLowerCase() == "zh-cn") {
                                                    msg = "对不起，没有找到数据 ";
                                                } else if ($("#contextLanguage").val().toLowerCase() == "en") {
                                                    msg = "Cannot find the information you want ";
                                                } else {
                                                    msg = "見つかりませんでした。";
                                                }
                                                $('.kerword_box').html("<ul class=\"cityslide\"><li class=\"empty ellipsis\" title='" + msg + "\"" + inputVal + "\"'>" + msg + "\"<em class=''>" + inputVal + "</em>\"</li></ul>");
                                            }
                                        }
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    //console.log("Error:", errorThrown);
                                }
                            });
                            $('.kerword_box').show();
                        }

                    }, 500);
                }
            }
        }
    });
   // $('.kerword_box').show();


    // 点击其他元素城市层消失
    $(document).bind('click', function (e) {
        var target = $(e.target);
        if (target.closest(".kw .tipTxt").length == 0 && target.closest(".kw_input").length == 0 && target.closest(".kerword_box").length == 0) {
            $(document).find(".kerword_box").remove();
        }
    });
    function inputTipText() {
        $("input[class*=kw_input]").each(function () {
            var valTxt = $(this).attr("title");
            var htm = "<label class='tipTxt'>" + valTxt + "</label>"
            $(this).after(htm);
            $(this).keyup(function () {


                if ($(this).val() == "") {
                    getHidebox().show();
                    $(".kerword_box").hide();
                } else {
                    getHidebox().hide();
                }
            });
            if (values = "") {
                getHidebox().hide();
                $('.kerword_box').hide();
            }
        });
        $(".kw .tipTxt").click(function () {
            $(".kw_input").focus();
            $(".kw .tipTxt").hide();
        });
        $(".kw_input").focus(function () {
            $(".kw .tipTxt").hide();
        });

    }
    inputTipText();

    var count = -1;
    function keywordKeyboardEvent(event, keycode) {
        var lis = $(".word_slide a");
        var len = lis.length;
        switch (keycode) {
            case 40: //向下箭头↓
                count++;
                if (count > len - 1) count = 0;
                $(".word_slide a").removeClass('on');
                $($(".word_slide a")[count]).addClass('on');
                break;
            case 38: //向上箭头↑
                count--;
                if (count < 0) count = len - 1;
                $(".word_slide a").removeClass('on');
                $($(".word_slide a")[count]).addClass('on');
                break;
            case 13: // enter键
                if (count != -1) {
                    $(".kw_input").html($($(".word_slide a")[count]).find(".cityname").html());
                    $(".kw_input").val($($(".word_slide a")[count]).find(".cityname").html());
                }
                $(".word_slide").hide();
                break;
            default:
                break;
        }
    }
    $(".kw_input").keyup(function (event) {
        event = event || window.event;
        var keycode = event.keyCode;
        keywordKeyboardEvent(event, keycode);
    });
}
