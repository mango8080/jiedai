var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array(
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
    52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
    -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
    15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
    -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
    41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);

//客户端Base64编码

String.prototype.startWith = function (s) {
    if (s == null || s == "" || typeof s === 'undefined' || this.length == 0 || s.length > this.length)
        return false;
    if (this.substr(0, s.length) == s)
        return true;
    else
        return false;
    return true;
};


String.prototype.isNullOrEmpty = function (s) {
    if (s == null || s == "" || typeof s === 'undefined' || this.length == 0 || s.length > this.length)
        return true;
    else
        return false;
};

var StringUtil = {

    base64encode: function (s) {
        var out, i, len;
        var c1, c2, c3;

        len = s.length;
        i = 0;
        out = "";
        while (i < len) {
            c1 = s.charCodeAt(i++) & 0xff;
            if (i == len) {
                out += base64EncodeChars.charAt(c1 >> 2);
                out += base64EncodeChars.charAt((c1 & 0x3) << 4);
                out += "==";
                break;
            }
            c2 = s.charCodeAt(i++);
            if (i == len) {
                out += base64EncodeChars.charAt(c1 >> 2);
                out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
                out += base64EncodeChars.charAt((c2 & 0xF) << 2);
                out += "=";
                break;
            }
            c3 = s.charCodeAt(i++);
            out += base64EncodeChars.charAt(c1 >> 2);
            out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
            out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
            out += base64EncodeChars.charAt(c3 & 0x3F);
        }
        return out;
    },

    utf16to8: function (str) {
        var out, i, len, c;

        out = "";
        len = str.length;
        for (i = 0; i < len; i++) {
            c = str.charCodeAt(i);
            if ((c >= 0x0001) && (c <= 0x007F)) {
                out += str.charAt(i);
            } else if (c > 0x07FF) {
                out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
                out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
            } else {
                out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
            }
        }
        return out;
    },

    utf8to16: function (str) {
        var out, i, len, c;
        var char2, char3;

        out = "";
        len = str.length;
        i = 0;
        while (i < len) {
            c = str.charCodeAt(i++);
            switch (c >> 4) {
                case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
                    // 0xxxxxxx
                    out += str.charAt(i - 1);
                    break;
                case 12: case 13:
                    // 110x xxxx   10xx xxxx
                    char2 = str.charCodeAt(i++);
                    out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
                    break;
                case 14:
                    // 1110 xxxx  10xx xxxx  10xx xxxx
                    char2 = str.charCodeAt(i++);
                    char3 = str.charCodeAt(i++);
                    out += String.fromCharCode(((c & 0x0F) << 12) |
                       ((char2 & 0x3F) << 6) |
                       ((char3 & 0x3F) << 0));
                    break;
            }
        }

        return out;
    },


    //客户端Base64解码
    base64decode: function (str) {
        var c1, c2, c3, c4;
        var i, len, out;

        len = str.length;
        i = 0;
        out = "";
        while (i < len) {
            /* c1 */
            do {
                c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
            } while (i < len && c1 == -1);
            if (c1 == -1)
                break;

            /* c2 */
            do {
                c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
            } while (i < len && c2 == -1);
            if (c2 == -1)
                break;

            out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

            /* c3 */
            do {
                c3 = str.charCodeAt(i++) & 0xff;
                if (c3 == 61)
                    return out;
                c3 = base64DecodeChars[c3];
            } while (i < len && c3 == -1);
            if (c3 == -1)
                break;

            out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

            /* c4 */
            do {
                c4 = str.charCodeAt(i++) & 0xff;
                if (c4 == 61)
                    return out;
                c4 = base64DecodeChars[c4];
            } while (i < len && c4 == -1);
            if (c4 == -1)
                break;
            out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
        }
        return out;
    }
}

var rndtoday = new Date();
var rndseed = rndtoday.getTime();

function rnd() {
    rndseed = (rndseed * 9301 + 49297) % 233280;
    return rndseed / (233280.0);
};

function rand(number) {
    return Math.ceil(rnd() * number);
};


function ChangeCodeImg(imgID) {
    var a = document.getElementById(imgID);
    a.src = "/Handlers/CodeImage.aspx?TypePara=login&" + rand(10000000);
}


function ImprovePassword()
{
    var gotoURL = $("#sitecommonForgotURL").val();
    var imgURL = $("#sitecommonImageDomain").val();
    var weakPasswordPopupWindow = "<div class='cover'>"
+ "<div class='cover_cont'>"
+    "<h3>温馨提示</h3>"
+ "<span><img src='" + imgURL + "/themes/common/img/tips.jpg' alt=''></span>"
+    "<p>系统检测到您的账户可能存在安全风险，为保护您的用户权益，请先修改登录密码，再进行后续操作，谢谢！</p>"
+    "<div class='update'>"
+        "<a href='#' title='' class='a1'>马上修改</a>"
+        "<a href='#' title='' class='a2'>稍后再说</a>"
+    "</div>"
+"</div></div>";
    var winobj = $(weakPasswordPopupWindow);
    $("body").append(winobj);
    winobj.css("display", "block");
    winobj.find('.a1').click(function () {
        //alert("a1");
        if (gotoURL.indexOf("http://") == -1)
        {
            gotoURL = "http://" + gotoURL;
        }
        //window.open(gotoURL + "?returnurl=" + encodeURIComponent("http://" + window.location.host));
        window.location.href = gotoURL + "?returnurl=" + encodeURIComponent("http://" + window.location.host);
        //location.reload();
    });
    winobj.find('.a2').click(function () {
        winobj.remove();
        //location.reload();
    });
}


function checkValidateCode(validateCode,succCallBack,errorCallBack) {
    if ($("#" + validateCode).val() == null || $("#" + validateCode).val() == "") {
        //$("#errorMsgEmailOrPhone").html(captchawrong);
        if (errorCallBack) {
            errorCallBack();
        }
        return false;
    }
    else {
        if (succCallBack)
        {
            succCallBack();
        }
        return true;
    }
    //loginData += "&code=" + $("#" + validateCode).val();
}

var citySelectorfunc = {};
citySelectorfunc.getFullCityQueryName = function () {
    var disname = "";
    if (cityDistrict && cityDistrict.fulldisname) {
        disname = cityDistrict.fulldisname;
        disname = disname.replace(/,/g, "|");
    }
    return disname;
}

function CheckPromotionRateCode(rateCode) {
    var hasFlg = false;
    $(promontionRateCodeData).each(function () {
        if (this.value == rateCode) {
            hasFlg = true;
            return hasFlg;
        }
    });
    return hasFlg;
}