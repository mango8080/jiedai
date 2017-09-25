

/* *
 * 全局空间 Vcity
 * */
var Vcity = {};
var last;
var cityDistrict = {};
cityDistrict.fulldisname = "";
cityDistrict.clearFullDisname = function () {
    cityDistrict.fulldisname = "";
}
/* *
 * 静态方法集
 * @name _m
 * */
Vcity._m = {
    /* 选择元素 */
    $: function (arg, context) {
        var tagAll, n, eles = [], i, sub = arg.substring(1);
        context = context || document;
        if (typeof arg == 'string') {
            switch (arg.charAt(0)) {
                case '#':
                    return document.getElementById(sub);
                    break;
                case '.':
                    if (context.getElementsByClassName) return context.getElementsByClassName(sub);
                    tagAll = Vcity._m.$('*', context);
                    n = tagAll.length;
                    for (i = 0; i < n; i++) {
                        if (tagAll[i].className.indexOf(sub) > -1) eles.push(tagAll[i]);
                    }
                    return eles;
                    break;
                default:
                    return context.getElementsByTagName(arg);
                    break;
            }
        }
    },

    /* 绑定事件 */
    on: function (node, type, handler) {
        node.addEventListener ? node.addEventListener(type, handler, false) : node.attachEvent('on' + type, handler);
    },

    /* 获取事件 */
    getEvent: function (event) {
        return event || window.event;
    },

    /* 获取事件目标 */
    getTarget: function (event) {
        return event.target || event.srcElement;
    },

    /* 获取元素位置 */
    getPos: function (node) {
        var scrollx = document.documentElement.scrollLeft || document.body.scrollLeft,
            scrollt = document.documentElement.scrollTop || document.body.scrollTop;
        var pos = node.getBoundingClientRect();
        return { top: pos.top + scrollt, right: pos.right + scrollx, bottom: pos.bottom + scrollt, left: pos.left + scrollx }
    },

    /* 添加样式名 */
    addClass: function (c, node) {
        if (!node) return;
        node.className = Vcity._m.hasClass(c, node) ? node.className : node.className + ' ' + c;
    },

    /* 移除样式名 */
    removeClass: function (c, node) {
        var reg = new RegExp("(^|\\s+)" + c + "(\\s+|$)", "g");
        if (!Vcity._m.hasClass(c, node)) return;
        node.className = reg.test(node.className) ? node.className.replace(reg, '') : node.className;
    },

    /* 是否含有CLASS */
    hasClass: function (c, node) {
        if (!node || !node.className) return false;
        return node.className.indexOf(c) > -1;
    },

    /* 阻止冒泡 */
    stopPropagation: function (event) {
        event = event || window.event;
        event.stopPropagation ? event.stopPropagation() : event.cancelBubble = true;
    },
    /* 去除两端空格 */
    trim: function (str) {
        return str.replace(/^\s+|\s+$/g, '');
    },
    /* 去除所有空格 */
    trimAll: function (str) {
        if (str) {
            return str.replace(/\s+/g, '').replace('\'', '');
        }
        else {
            return "";
        }
    }
};

/* 所有城市数据,可以按照格式自行添加（北京|beijing|bj），前16条为热门城市 */

//Vcity.allCity = ['北京|beijing|bj','上海|shanghai|sh', '重庆|chongqing|cq',  '深圳|shenzhen|sz', '广州|guangzhou|gz', '杭州|hangzhou|hz',
//    '南京|nanjing|nj', '苏州|shuzhou|sz', '天津|tianjin|tj', '成都|chengdu|cd', '南昌|nanchang|nc', '三亚|sanya|sy','青岛|qingdao|qd',
//    '厦门|xiamen|xm', '西安|xian|xa','长沙|changsha|cs','合肥|hefei|hf','西藏|xizang|xz', '内蒙古|neimenggu|nmg', '安庆|anqing|aq', '阿泰勒|ataile|atl', '安康|ankang|ak',
//    '阿克苏|akesu|aks', '包头|baotou|bt', '北海|beihai|bh', '百色|baise|bs','保山|baoshan|bs', '长治|changzhi|cz', '长春|changchun|cc', '常州|changzhou|cz', '昌都|changdu|cd',
//    '朝阳|chaoyang|cy', '常德|changde|cd', '长白山|changbaishan|cbs', '赤峰|chifeng|cf', '大同|datong|dt', '大连|dalian|dl', '达县|daxian|dx', '东营|dongying|dy', '大庆|daqing|dq', '丹东|dandong|dd',
//    '大理|dali|dl', '敦煌|dunhuang|dh', '鄂尔多斯|eerduosi|eeds', '恩施|enshi|es', '福州|fuzhou|fz', '阜阳|fuyang|fy', '贵阳|guiyang|gy',
//    '桂林|guilin|gl', '广元|guangyuan|gy', '格尔木|geermu|gem', '呼和浩特|huhehaote|hhht', '哈密|hami|hm',
//    '黑河|heihe|hh', '海拉尔|hailaer|hle', '哈尔滨|haerbin|heb', '海口|haikou|hk', '黄山|huangshan|hs', '邯郸|handan|hd',
//    '汉中|hanzhong|hz', '和田|hetian|ht', '晋江|jinjiang|jj', '锦州|jinzhou|jz', '景德镇|jingdezhen|jdz',
//    '嘉峪关|jiayuguan|jyg', '井冈山|jinggangshan|jgs', '济宁|jining|jn', '九江|jiujiang|jj', '佳木斯|jiamusi|jms', '济南|jinan|jn',
//    '喀什|kashi|ks', '昆明|kunming|km', '康定|kangding|kd', '克拉玛依|kelamayi|klmy', '库尔勒|kuerle|kel', '库车|kuche|kc', '兰州|lanzhou|lz',
//    '洛阳|luoyang|ly', '丽江|lijiang|lj', '林芝|linzhi|lz', '柳州|liuzhou|lz', '泸州|luzhou|lz', '连云港|lianyungang|lyg', '黎平|liping|lp',
//    '连成|liancheng|lc', '拉萨|lasa|ls', '临沧|lincang|lc', '临沂|linyi|ly', '芒市|mangshi|ms', '牡丹江|mudanjiang|mdj', '满洲里|manzhouli|mzl', '绵阳|mianyang|my',
//    '梅县|meixian|mx', '漠河|mohe|mh', '南充|nanchong|nc', '南宁|nanning|nn', '南阳|nanyang|ny', '南通|nantong|nt', '那拉提|nalati|nlt',
//    '宁波|ningbo|nb', '攀枝花|panzhihua|pzh', '衢州|quzhou|qz', '秦皇岛|qinhuangdao|qhd', '庆阳|qingyang|qy', '齐齐哈尔|qiqihaer|qqhe',
//    '石家庄|shijiazhuang|sjz',  '沈阳|shenyang|sy', '思茅|simao|sm', '铜仁|tongren|tr', '塔城|tacheng|tc', '腾冲|tengchong|tc', '台州|taizhou|tz',
//    '通辽|tongliao|tl', '太原|taiyuan|ty', '威海|weihai|wh', '梧州|wuzhou|wz', '文山|wenshan|ws', '无锡|wuxi|wx', '潍坊|weifang|wf', '武夷山|wuyishan|wys', '乌兰浩特|wulanhaote|wlht',
//    '温州|wenzhou|wz', '乌鲁木齐|wulumuqi|wlmq', '万州|wanzhou|wz', '乌海|wuhai|wh', '兴义|xingyi|xy', '西昌|xichang|xc',  '襄樊|xiangfan|xf',
//    '西宁|xining|xn', '锡林浩特|xilinhaote|xlht', '西双版纳|xishuangbanna|xsbn', '徐州|xuzhou|xz', '义乌|yiwu|yw', '永州|yongzhou|yz', '榆林|yulin|yl', '延安|yanan|ya', '运城|yuncheng|yc',
//    '烟台|yantai|yt', '银川|yinchuan|yc', '宜昌|yichang|yc', '宜宾|yibin|yb', '盐城|yancheng|yc', '延吉|yanji|yj', '玉树|yushu|ys', '伊宁|yining|yn', '珠海|zhuhai|zh', '昭通|zhaotong|zt',
//    '张家界|zhangjiajie|zjj', '舟山|zhoushan|zs', '郑州|zhengzhou|zz', '中卫|zhongwei|zw', '芷江|zhijiang|zj', '湛江|zhanjiang|zj'];


Vcity.allCity = null;




/* *
 * 格式化城市数组为对象oCity，按照a-h,i-p,q-z,hot热门城市分组：
 * {HOT:{hot:[]},ABCDEFGH:{a:[1,2,3],b:[1,2,3]},IJKLMNOP:{i:[1.2.3],j:[1,2,3]},QRSTUVWXYZ:{}}
 * */




(function () {
    var hostname = window.location.hostname;
    var brand;
    var currentlang = $("#contextLanguage").val();
    if (currentlang == "en") {
        if (hostname.indexOf("metropolohotels") >= 0 || hostname.indexOf("metropolo") >= 0) {
            //都城
            Vcity.hotCity_2 = ['ShangHai', 'Guangzhou', 'HeFei', 'ShenYang', 'ShiJiaZhuang', 'WuHan', 'ZhengZhou', 'TaiYuan', 'XiAn'];
        }
        else if (hostname.indexOf("jinguanginns") >= 0 || hostname.indexOf("goldmet") >= 0) {
            //金广
            Vcity.hotCity_2 = ['ShangHai', 'TaiYuan', 'ShenZhen', 'BeiJing', 'GuanZhou', 'DongGuan', 'SuZhou', 'ChengDu', 'FoShan'];
        }
        else if (hostname.indexOf("bestay") >= 0) {
            //百时
            Vcity.hotCity_2 = ['ShangHai', 'BeiJing', 'NanJing', 'SuZhou', 'ShiJiaZhuang', 'ChangZhou', 'WuHan', 'NingBo'];
        }
        else {
            //锦江之星
            Vcity.hotCity_2 = ['ShangHai', 'BeiJing', 'NanJing', 'SuZhou', 'WuHan', 'XiAn', 'TianJin', 'XiaMen', 'HangZhou', 'ChengDu', 'GuangZhou', 'ShenZhen', 'ShenYang', 'WuXi', 'QingDao', 'ZhengZhou', 'ZhongQing', 'SanYa', 'HaErBin', 'TaiYuan'];
        }

        /* 正则表达式 筛选中文城市名、拼音、首字母 */
        Vcity.regEx = /^([a-zA-Z]+)\|(\w+)\|(\w)\w*$/i;
        Vcity.regExChiese = /(>(.*?)[a-zA-Z](<)+)/;

        Vcity.otherCity_3 = ['Manila'];
    } else if (currentlang == "ja-JP") {

        if (hostname.indexOf("metropolohotels") >= 0 || hostname.indexOf("metropolo") >= 0) {
            //都城
            Vcity.hotCity_2 = ['上海', '广州', '合肥', '沈阳', '石家庄', '武汉', '郑州', '太原', '西安'];
        }
        else if (hostname.indexOf("jinguanginns") >= 0 || hostname.indexOf("goldmet") >= 0) {
            //金广
            Vcity.hotCity_2 = ['上海', '北京', '苏州', '西安', '南京', '天津', '无锡', '青岛', '沈阳', '武汉', '厦门', '郑州', '济南', '杭州', '宁波', '大连'];
        }
        else if (hostname.indexOf("bestay") >= 0) {
            //百时
            Vcity.hotCity_2 = ['上海', '北京', '南京', '苏州', '石家庄', '常州', '武汉', '宁波'];
        }
        else {
            //锦江之星
            Vcity.hotCity_2 = ['上海', '北京', '南京', '苏州', '武汉', '西安', '天津', '厦门', '杭州', '成都', '广州', 'シンセン', '沈阳', '无锡', '青岛', '郑州', '重庆', '三亚', 'ハルビン', '太原'];
        }

        /* 正则表达式 筛选中文城市名、拼音、首字母 */
        Vcity.otherCity_3 = ['マニラ'];
        Vcity.regEx = /^([^\x00-\xff]+)\|(\w+)\|(\w)\w*$/i;
        Vcity.regExChiese = /([^\x00-\xff]+)/;
    } else {
        if (hostname.indexOf("metropolohotels") >= 0 || hostname.indexOf("metropolo") >= 0) {
            //都城
            Vcity.hotCity_2 = ['上海', '广州', '合肥', '沈阳', '石家庄', '武汉', '郑州', '太原', '西安'];
        }
        else if (hostname.indexOf("jinguanginns") >= 0 || hostname.indexOf("goldmet") >= 0) {
            //金广
            Vcity.hotCity_2 = ['上海', '太原', '深圳', '北京', '广州', '东莞', '苏州', '成都', '佛山'];
        }
        else if (hostname.indexOf("bestay") >= 0) {
            //百时
            Vcity.hotCity_2 = ['上海', '北京', '南京', '苏州', '石家庄', '常州', '武汉', '宁波'];
        }
        else {
            //锦江之星
            Vcity.hotCity_2 = ['上海', '北京', '南京', '苏州', '武汉', '西安', '天津', '厦门', '杭州', '成都', '广州', '深圳', '沈阳', '无锡', '青岛', '郑州', '重庆', '三亚', '哈尔滨', '太原'];
        }
        Vcity.otherCity_3 = ['马尼拉'];

        Vcity.regEx = /^([\u4E00-\u9FA5\uf900-\ufa2d]+)\|(\w+)\|(\w)\w*$/i;
        Vcity.regExChiese = /([\u4E00-\u9FA5\uf900-\ufa2d]+)/;
    }

    /* 城市HTML模板 */
    if (currentlang == "en") {
        //英文字段
        Vcity._template = [
            //'<p class="tip">Support Chinese/English/simplified Pinyin input</p>',
            '<b class="close"></b>',
            '<ul>',
            '<li class="on">TOP</li>',
            '<li>ABCDE</li>',
            '<li>FGHIJ</li>',
            '<li>KLMNO</li>',
            '<li>PQRST</li>',
            '<li>UVWXYZ</li>',
           // '<li>abroad</li>',
            '</ul>'
        ];
    } else if (currentlang == "ja-JP") {
        //日文字段
        Vcity._template = [
            //'<p class="tip">支持中文/英文/简拼输入</p>',
            '<b class="close"></b>',
            '<ul>',
            '<li class="on">TOP</li>',
            '<li>ABCDE</li>',
            '<li>FGHIJ</li>',
            '<li>KLMNO</li>',
            '<li>PQRST</li>',
            '<li>UVWXYZ</li>',
            //'<li>海外</li>',
            '</ul>'
        ];
    } else {
        Vcity._template = [
            '<p class="tip">支持中文/英文/简拼输入</p>',
            '<b class="close"></b>',
            '<ul>',
            '<li class="on">热门城市</li>',
            '<li>ABCDE</li>',
            '<li>FGHIJ</li>',
            '<li>KLMNO</li>',
            '<li>PQRST</li>',
            '<li>UVWXYZ</li>',
           // '<li>海外</li>',
            '</ul>'
        ];
    }

    //var citys = Vcity.allCity, match, letter,
    //    regEx = Vcity.regEx,
    //    reg2 = /^[a-e]$/i, reg3 = /^[f-j]$/i, reg4 = /^[k-o]$/i, reg5 = /^[p-t]$/i, reg6 = /^[u-z]$/i;
    //if (!Vcity.oCity) {
    //    Vcity.oCity = {hot:{},ABCDE:{}, FGHIJ:{}, KLMNO:{}, PQRST:{}, UVWXYZ:{}};
    //    //console.log(citys.length);
    //    for (var i = 0, n = citys.length; i < n; i++) {
    //        match = regEx.exec(citys[i]);
    //        letter = match[3].toUpperCase();
    //        if (reg2.test(letter)) {
    //            if (!Vcity.oCity.ABCDE[letter]) 
    //			    Vcity.oCity.ABCDE[letter] = [];
    //                Vcity.oCity.ABCDE[letter].push(match[1]);
    //        } else if (reg3.test(letter)) {
    //            if (!Vcity.oCity.FGHIJ[letter])
    //		        Vcity.oCity.FGHIJ[letter] = [];
    //                Vcity.oCity.FGHIJ[letter].push(match[1]);
    //        } else if (reg4.test(letter)) {
    //            	if (!Vcity.oCity.KLMNO[letter]) 
    //				Vcity.oCity.KLMNO[letter] = [];
    //            	Vcity.oCity.KLMNO[letter].push(match[1]);
    //        }else if (reg5.test(letter)) {
    //            	if (!Vcity.oCity.PQRST[letter]) 
    //				Vcity.oCity.PQRST[letter] = [];
    //            	Vcity.oCity.PQRST[letter].push(match[1]);
    //        }else if (reg6.test(letter)) {
    //            if (!Vcity.oCity.UVWXYZ[letter]) 
    //				Vcity.oCity.UVWXYZ[letter] = [];
    //            	Vcity.oCity.UVWXYZ[letter].push(match[1]);
    //        }
    //        /* 热门城市 前16条 */
    //        if(i<Vcity.hotCity_2.length){
    //            if(!Vcity.oCity.hot['hot']) Vcity.oCity.hot['hot'] = [];
    //            Vcity.oCity.hot['hot'].push(Vcity.hotCity_2[i]);
    //        }
    //    }
    //}
})();

$("#se").click(function () {

});

/* *
 * 城市控件构造函数
 * @CitySelector
 * */



Vcity.CitySelector = function () {
    this.initialize.apply(this, arguments);
};

Vcity.CitySelector.prototype = {

    constructor: Vcity.CitySelector,

    /* 初始化 */

    initialize: function (options) {
        var input = options.input;
        this.input = Vcity._m.$('#' + input);
        this.inputEvent();
    },

    getAllCity: function () {
        if (!Vcity.allCity) {
            var linkageWord;
            var hostname = window.location.hostname;
            if (hostname.indexOf("metropolohotels") >= 0 || hostname.indexOf("metropolo") >= 0) {
                //都城
                linkageWord = "JJDC";
            }
            else if (hostname.indexOf("jinguanginns") >= 0 || hostname.indexOf("goldmet") >= 0) {
                //金广
                linkageWord = "JG";
            }
            else if (hostname.indexOf("bestay") >= 0) {
                //百时
                linkageWord = "BESTAY";
            }
            else {
                linkageWord = "JJINN";
            }
            var param = {
                "language": $("#contextLanguage").val(),
                "linkageWord": linkageWord
            }
            var that = this;
            $.ajax({
                type: 'POST',
                url: '/service/queryEsCity',
                dataType: 'json',
                data: param,
                async: false,
                cache: false,
                success: function (data) {
                    var result = JSON.parse(data);
                    //console.log(result);
                    if (result.Success) {

                        that.createModelForAllCity(result);
                        that.initAllCity();
                        that.createCity();

                    }
                }
            });
        }
    },

    createModelForAllCity: function (result) {
        var arr = result.List;
        var temp = [];
        var currentlang = $("#contextLanguage").val();
        if (currentlang == "en") {
            for (var i = 0; i < arr.length; i++) {

                //str = '<li><b class="cityname">' + arr[i].nameValueEN + '</b><b class="cityspell">' + arr[i].nameValueEN + '</b></li>';

                str = Vcity._m.trimAll(arr[i].nameValueEN) + '|' + Vcity._m.trimAll(arr[i].firstLetterEN) + '|' + Vcity._m.trimAll(arr[i].firstLetterEN);

                temp.push(str);
            }
        } else if (currentlang == "ja-JP") {
            for (var i = 0; i < arr.length; i++) {

                //str = '<li><b class="cityname">' + arr[i].nameValueJA + '</b><b class="cityspell">' + arr[i].nameValueEN + '</b></li>';
                str = Vcity._m.trimAll(arr[i].nameValueJA) + '|' + Vcity._m.trimAll(arr[i].firstLetterJA) + '|' + Vcity._m.trimAll(arr[i].firstLetterJA);
                temp.push(str);
            }
        } else {
            for (var i = 0; i < arr.length; i++) {

                //str = '<li><b class="cityname">' + arr[i].nameValueZH + '</b><b class="cityspell">' + arr[i].nameValueEN + '</b></li>';
                str = Vcity._m.trimAll(arr[i].nameValueZH) + '|' + Vcity._m.trimAll(arr[i].firstLetterZH) + '|' + Vcity._m.trimAll(arr[i].firstLetterZH);
                temp.push(str);
            }
        }
        Vcity.allCity = temp;
    },

    initAllCity: function () {
        var citys = Vcity.allCity, match, letter,
        regEx = Vcity.regEx,
        reg2 = /^[a-e]$/i, reg3 = /^[f-j]$/i, reg4 = /^[k-o]$/i, reg5 = /^[p-t]$/i, reg6 = /^[u-z]$/i;
        if (!Vcity.oCity) {
            Vcity.oCity = { hot: {}, ABCDE: {}, FGHIJ: {}, KLMNO: {}, PQRST: {}, UVWXYZ: {}, other: {} };
            //console.log(citys.length);
            for (var i = 0, n = citys.length; i < n; i++) {
                match = regEx.exec(citys[i]);
                //if (!match)
                //{
                //    console.log(citys[i]);
                //}
                if (match) {
                    letter = match[3].toUpperCase();
                    if (reg2.test(letter)) {
                        if (!Vcity.oCity.ABCDE[letter])
                            Vcity.oCity.ABCDE[letter] = [];
                        Vcity.oCity.ABCDE[letter].push(match[1]);
                    } else if (reg3.test(letter)) {
                        if (!Vcity.oCity.FGHIJ[letter])
                            Vcity.oCity.FGHIJ[letter] = [];
                        Vcity.oCity.FGHIJ[letter].push(match[1]);
                    } else if (reg4.test(letter)) {
                        if (!Vcity.oCity.KLMNO[letter])
                            Vcity.oCity.KLMNO[letter] = [];
                        Vcity.oCity.KLMNO[letter].push(match[1]);
                    } else if (reg5.test(letter)) {
                        if (!Vcity.oCity.PQRST[letter])
                            Vcity.oCity.PQRST[letter] = [];
                        Vcity.oCity.PQRST[letter].push(match[1]);
                    } else if (reg6.test(letter)) {
                        if (!Vcity.oCity.UVWXYZ[letter])
                            Vcity.oCity.UVWXYZ[letter] = [];
                        Vcity.oCity.UVWXYZ[letter].push(match[1]);
                    }
                }
                /* 热门城市 前16条 */
                if (i < Vcity.hotCity_2.length) {
                    if (!Vcity.oCity.hot['hot']) Vcity.oCity.hot['hot'] = [];
                    Vcity.oCity.hot['hot'].push(Vcity.hotCity_2[i]);
                }
                if (i < Vcity.otherCity_3.length) {
                    if (!Vcity.oCity.other['other']) Vcity.oCity.other['other'] = [];
                    Vcity.oCity.other['other'].push(Vcity.otherCity_3[i]);
                }
            }
        }
    },

    /* *
     * @createWarp
     * 创建城市BOX HTML 框架
     * */

    createWarp: function () {
        this.getAllCity();
    },

    createCity: function () {
        var inputPos = Vcity._m.getPos(this.input);
        var div = this.rootDiv = document.createElement('div');
        $(".city_box").append(div);
        var that = this;

        // 设置DIV阻止冒泡
        Vcity._m.on(this.rootDiv, 'click', function (event) {
            Vcity._m.stopPropagation(event);
            cityDistrict.clearFullDisname();
        });

        // 设置点击文档隐藏弹出的城市选择框
        Vcity._m.on(document, 'click', function (event) {
            event = Vcity._m.getEvent(event);
            var target = Vcity._m.getTarget(event);
            if (target == that.input) return false;
            //console.log(target.className);
            if (that.cityBox) Vcity._m.addClass('hide', that.cityBox);
            if (that.div) Vcity._m.addClass('hide', that.div);
            if (that.myIframe) Vcity._m.addClass('hide', that.myIframe);
        });
        div.className = 'citySelector';
        div.style.position = 'absolute';
        div.style.zIndex = 9999;
        $(".citySelector").css("float", "left");
        if ($(".hotel_screen").length > 0) {
            var star_hotel_tool_bar_height = 0;
            if ($(".wrapper").attr("class").indexOf("jinjiang_star_hotel") > 0) {
                star_hotel_tool_bar_height = 104;
            }
            var search_bar = $(".search_bar").offset().top;
            var st = $(document).scrollTop();
            if ($(window).height() < 540 + star_hotel_tool_bar_height && $(window).height() > 189 + star_hotel_tool_bar_height) {
                if (st < 580 - $(window).height()) {
                    $('body,html').animate({ scrollTop: st + 450 }, 300);
                }
            } else if (search_bar == 461) {
                if ($(window).height() - 461 < 308) {
                    $('body,html').animate({ scrollTop: st + 450 }, 300);
                }
            }
        }


        // 判断是否IE6，如果是IE6需要添加iframe才能遮住SELECT框
        var isIe = (document.all) ? true : false;
        var isIE6 = this.isIE6 = isIe && !window.XMLHttpRequest;
        if (isIE6) {
            var myIframe = this.myIframe = document.createElement('iframe');
            myIframe.frameborder = '0';
            myIframe.src = 'about:blank';
            myIframe.style.position = 'absolute';
            myIframe.style.zIndex = '-1';
            this.rootDiv.appendChild(this.myIframe);
        }

        var childdiv = this.cityBox = document.createElement('div');
        childdiv.className = 'cityBox';
        childdiv.id = 'cityBox';
        childdiv.innerHTML = Vcity._template.join('');
        var hotCity = this.hotCity = document.createElement('div');
        hotCity.className = 'hotCity';
        childdiv.appendChild(hotCity);
        div.appendChild(childdiv);
        this.createHotCity();
        $(".cityBox .close").click(function () { Vcity._m.addClass('hide', that.cityBox); });
    },

    /* *
     * @createHotCity
     * TAB下面DIV：hot,a-h,i-p,q-z 分类HTML生成，DOM操作
     * {HOT:{hot:[]},ABCDEFGH:{a:[1,2,3],b:[1,2,3]},IJKLMNOP:{},QRSTUVWXYZ:{}}
     **/

    createHotCity: function () {
        var odiv, odl, odt, odd, odda = [], str, key, ckey, sortKey, regEx = Vcity.regEx,
            oCity = Vcity.oCity;
        for (key in oCity) {
            odiv = this[key] = document.createElement('div');
            // 先设置全部隐藏hide
            odiv.className = key + ' ' + 'cityTab hide';
            sortKey = [];
            for (ckey in oCity[key]) {
                sortKey.push(ckey);
                // ckey按照ABCDEDG顺序排序
                sortKey.sort();
            }
            for (var j = 0, k = sortKey.length; j < k; j++) {
                odl = document.createElement('dl');
                odt = document.createElement('dt');
                odd = document.createElement('dd');
                odt.innerHTML = sortKey[j] == 'hot' ? '&nbsp;' : sortKey[j];
                odt.innerHTML = sortKey[j] == 'other' ? '&nbsp;' : sortKey[j];
                odda = [];
                for (var i = 0, n = oCity[key][sortKey[j]].length; i < n; i++) {
                    //str = '<a href="javascript:">' + oCity[key][sortKey[j]][i] + '</a>';
                    //odda.push(str);
                    var temp = oCity[key][sortKey[j]][i];
                    if (temp.length > 4) {
                        str = '<a title="' + temp + '" href="javascript:">' + temp.substring(0, 3) + "..." + '</a>';
                        odda.push(str);
                    }
                    else {
                        str = '<a href="javascript:">' + oCity[key][sortKey[j]][i] + '</a>';
                        odda.push(str);
                    }
                }
                odd.innerHTML = odda.join('');
                odl.appendChild(odt);
                odl.appendChild(odd);
                odiv.appendChild(odl);
            }

            // 移除热门城市的隐藏CSS
            Vcity._m.removeClass('hide', this.hot);
            this.hotCity.appendChild(odiv);
        }

        if ($("#rent_filter").length > 0) {
            document.body.appendChild(this.rootDiv);
            $(this.rootDiv).css("position", "absolute");
            $(this.rootDiv).css("top", $("#" + this.input.id).offset().top + 35);
            $(this.rootDiv).css("left", $("#" + this.input.id).offset().left);
        }
        /* IE6 */
        this.changeIframe();

        this.tabChange();
        this.linkEvent();

    },

    /* *
     *  tab按字母顺序切换
     *  @ tabChange
     * */

    tabChange: function () {
        var lis = Vcity._m.$('li', this.cityBox);
        var divs = Vcity._m.$('div', this.hotCity);
        var that = this;
        for (var i = 0, n = lis.length; i < n; i++) {
            lis[i].index = i;
            lis[i].onclick = function () {
                for (var j = 0; j < n; j++) {
                    Vcity._m.removeClass('on', lis[j]);
                    Vcity._m.addClass('hide', divs[j]);
                }
                Vcity._m.addClass('on', this);
                Vcity._m.removeClass('hide', divs[this.index]);
                /* IE6 改变TAB的时候 改变Iframe 大小*/
                that.changeIframe();
            };
        }
    },

    /* *
     * 城市LINK事件
     *  @linkEvent
     * */

    linkEvent: function () {
        var links = Vcity._m.$('a', this.hotCity);
        var that = this;
        for (var i = 0, n = links.length; i < n; i++) {
            links[i].onclick = function () {
                var tempvalue = "";
                if ($(this).attr("title")) {

                    tempvalue = $(this).attr("title");
                }
                else {
                    tempvalue = this.innerHTML;
                }
                that.input.value = tempvalue;
                Vcity._m.addClass('hide', that.cityBox);
                $('.kw').find('.kw_input').attr('value', "");
                $('.kw').find('.kw_input').next().show();
                /* 点击城市名的时候隐藏myIframe */
                Vcity._m.addClass('hide', that.myIframe);

                that.input.title = tempvalue;
            }
        }
    },

    /* *
     * INPUT城市输入框事件
     * @inputEvent
     * */

    inputEvent: function () {
        var that = this;
        Vcity._m.on(this.input, 'click', function (event) {
            event = event || window.event;
            if (!that.cityBox) {
                that.createWarp();
            } else if (!!that.cityBox && Vcity._m.hasClass('hide', that.cityBox)) {
                // slideul 不存在或者 slideul存在但是是隐藏的时候 两者不能共存
                if (!that.div || (that.div && Vcity._m.hasClass('hide', that.div))) {
                    Vcity._m.removeClass('hide', that.cityBox);

                    /* IE6 移除iframe 的hide 样式 */
                    //alert('click');
                    Vcity._m.removeClass('hide', that.myIframe);
                    if ($(".hotel_screen").length > 0) {
                        var search_bar = $(".search_bar").offset().top;
                        var st = $(document).scrollTop();
                        if ($(".hotel_screen").length > 0) {
                            var search_bar = $(".search_bar").offset().top;
                            var st = $(document).scrollTop();
                            if ($(window).height() < 540 && $(window).height() > 189 && search_bar != 461) {
                                if (st < 580 - $(window).height()) {
                                    $('body,html').animate({ scrollTop: st + 450 }, 300);
                                }
                            } else if ($(window).height() < 540 && $(window).height() > 189 && search_bar == 461) {
                                if ($(window).height() - 461 < 308 && $(window).height() > 260 && st != 454) {
                                    $('body,html').animate({ scrollTop: 400 }, 300);
                                }
                            }
                        }
                    }
                    that.changeIframe();
                }
            }
        });
        //Vcity._m.on(this.input, 'focus', function () {
        //    that.input.select();
        //    if (that.input.value == '') that.input.value = '上海';
        //});
        //Vcity._m.on(this.input, 'blur', function () {
        //    if (that.input.value == '') that.input.value = '上海';
        //});
        Vcity._m.on(this.input, 'keyup', function (event) {
            event = event || window.event;
            var keycode = event.keyCode;
            Vcity._m.addClass('hide', that.cityBox);
            that.createUl();

            /* 移除iframe 的hide 样式 */
            Vcity._m.removeClass('hide', that.myIframe);

            // 下拉菜单显示的时候捕捉按键事件
            if (that.div && !Vcity._m.hasClass('hide', that.div) && !that.isEmpty) {
                that.KeyboardEvent(event, keycode);
            }
            cityDistrict.fulldisname = "";
        });
    },

    /* *
     * 生成下拉选择列表
     * @ createUl
     * */
    createUl: function () {
        //console.log('createUL');
        var str;
        var oCityHtml;
        var value = Vcity._m.trim(this.input.value);
        // 当value不等于空的时候执行
        if (value !== '') {
            //var reg = new RegExp("^" + value + "|\\|" + value, 'gi');

            // for (var i = 0, n = Vcity.allCity.length; i < n; i++) {
            //     if (reg.test(Vcity.allCity[i])) {
            //         var match = Vcity.regEx.exec(Vcity.allCity[i]);
            //         if (searchResult.length !== 0) {
            //             str = '<li><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
            //         } else {
            //             str = '<li class="on"><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
            //         }
            //         searchResult.push(str);
            //     }
            // }
            var param = {
                "language": $("#contextLanguage").val(),
                "linkageWord": value
            }
            var that = this;

            $.ajax({
                type: 'POST',
                url: '/service/QueryEsDistrict',
                dataType: 'json',
                data: param,
                async: false,
                cache: false,
                success: function (data) {
                    var result = JSON.parse(data);
                    //console.log(result);
                    if (result && result.Success && result.List && result.List.length > 0) {
                        var oCityHtml = that.createSearchCityStr(result);
                        oCityHtml = that.createSearchHotelKeywordStr(result, oCityHtml);
                        
                        var str = "";
                        that.createSearchCityUI(str, oCityHtml, result, value);

                    }
                    else {
                        //var oCityHtml = that.createSearchCityStr(result);
                        //var str = that.createSearchHotelStr(result);
                        that.createSearchCityUI("", "", result, value);
                        //var param = {
                        //    city: "",
                        //    word: value,
                        //    language: $("#contextLanguage").val()
                        //    //language: 'zh-CN' //TODO: temp haard code
                        //};
                        //$.ajax({
                        //    type: 'POST',
                        //    url: "/service/queryEsKeyword",
                        //    dataType: 'JSON',
                        //    data: param,
                        //    cache: false,
                        //    async: false,
                        //    success: function (responseData) {
                        //        var result = JSON.parse(responseData);

                        //        var myhtml = "";
                        //        if (result != undefined && result != null && result.keywords != undefined && result.keywords != null) {
                        //            var len = result.keywords.length;

                        //            var keywordsSTR = that.createSearchKeywordStr(result);

                        //            that.createSearchCityUI(keywordsSTR, "", result, value);


                        //        }
                        //    },
                        //    error: function (jqXHR, textStatus, errorThrown) {
                        //        //console.log("Error:", errorThrown);
                        //    }
                        //});
                    }
                }
            });



        } else {
            Vcity._m.addClass('hide', this.div);
            Vcity._m.removeClass('hide', this.cityBox);

            Vcity._m.removeClass('hide', this.myIframe);

            this.changeIframe();
        }
        $('.citySelector').find('.cityslide').find('li').eq(0).addClass('on');

        $(".cityslide").find(".cityslide_adress").hover(function () {
            $('.citySelector').find('.cityslide').find('li').eq(0).removeClass('on');
        }, function () {

        });
    },
    createSearchCityStr: function (model) {

        var count = 7;
        //if (model.List.length < 7) {
        count = model.List.length;
        //}

        var oCityHtml = "";
        var currentlang = $("#contextLanguage").val();

        if (currentlang == "en") {
            oCityHtml += '<span class="cityslide_head">City</span>';
            for (var i = 0; i < count; i++) {
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;">' + this.getCityString(model.List[i].countyNameValueEN, model.List[i].cityNameValueEN, model.List[i].provinceNameValueEN) + '</a></div>';
            }
        } else if (currentlang == "ja-JP") {
            oCityHtml += '<span class="cityslide_head">都市</span>';
            for (var i = 0; i < count; i++) {
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;">' + this.getCityString(model.List[i].countyNameValueJA, model.List[i].cityNameValueJA, model.List[i].provinceNameValueJA) + '</a></div>';
            }
        } else {

            oCityHtml += '<span class="cityslide_head">城市</span>';

            for (var i = 0; i < count; i++) {
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;">' + this.getCityString(model.List[i].countyNameValueZH, model.List[i].cityNameValueZH, model.List[i].provinceNameValueZH) + '</a></div>';
            }
        }
        return oCityHtml;
    },
    createSearchHotelKeywordStr: function (model, oCityHtml) {

        var count = 7;
        //if (model.List.length < 7) {
        count = model.Keywords.length;
        //}

        var currentlang = $("#contextLanguage").val();

        if (currentlang == "en") {
            oCityHtml += '<span class="cityslide_head">Hotel</span>';
            for (var i = 0; i < count; i++) {
                var destination = model.Keywords[i].destinationValueEN;
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;" data-destination="' + destination + '">' + model.Keywords[i].keywordValueZH + '</a></div>';
            }
        } else if (currentlang == "ja-JP") {
            oCityHtml += '<span class="cityslide_head">ホテル</span>';
            for (var i = 0; i < count; i++) {
                var destination = model.Keywords[i].destinationValueJP;
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;" data-destination="' + destination + '">' + model.Keywords[i].keywordValueZH + '</a></div>';
            }
        } else {

            oCityHtml += '<span class="cityslide_head">酒店</span>';
            for (var i = 0; i < count; i++) {
                var destination = model.Keywords[i].destinationValueZH;
                oCityHtml += '<div class="cityslide_adress" style="border-bottom: medium none;"><a href="javascript:;" data-destination="' + destination + '">' + model.Keywords[i].keywordValueZH + '</a></div>';
            }
        }
        return oCityHtml;
    },
    getCityString: function (county, city, province) {
        var str = "";
        if (county && county != "") {
            str = county;
        }
        if (city && city != "") {
            if (str != "") {
                str += "," + city;
            }
            else {
                str = city;
            }
        }
        if (province && province != "") {
            if (str != "") {
                str += "," + province;
            }
            else {
                str = province;
            }
        }
        return str;
    },
    getFirstString: function (citySTR) {
        var cityArr = citySTR.split(",");
        if (cityArr.length > 0) {
            return cityArr[0];
        }
        else {
            return "";
        }
    },
    getSecondString: function (citySTR) {
        var cityArr = citySTR.split(",");
        if (cityArr.length > 1) {
            return cityArr[1];
        }
        else {
            return "";
        }
    },
    //createUl: function () {
    //    //console.log('createUL');
    //    var str;
    //    var oCityHtml;
    //    var value = Vcity._m.trim(this.input.value);
    //    // 当value不等于空的时候执行
    //    if (value !== '') {
    //        //var reg = new RegExp("^" + value + "|\\|" + value, 'gi');

    //        // for (var i = 0, n = Vcity.allCity.length; i < n; i++) {
    //        //     if (reg.test(Vcity.allCity[i])) {
    //        //         var match = Vcity.regEx.exec(Vcity.allCity[i]);
    //        //         if (searchResult.length !== 0) {
    //        //             str = '<li><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
    //        //         } else {
    //        //             str = '<li class="on"><b class="cityname">' + match[1] + '</b><b class="cityspell">' + match[2] + '</b></li>';
    //        //         }
    //        //         searchResult.push(str);
    //        //     }
    //        // }
    //        var param = {
    //            "language": $("#contextLanguage").val(),
    //            "linkageWord": value
    //        }
    //        var that = this;

    //        $.ajax({
    //            type: 'POST',
    //            url: '/service/queryEsCity',
    //            dataType: 'json',
    //            data: param,
    //            async: false,
    //            cache: false,
    //            success: function (data) {
    //                var result = JSON.parse(data);
    //                //console.log(result);
    //                if (result && result.Success && result.List && result.List.length > 0 && result.HotelList && result.HotelList.length > 0) {
    //                    var oCityHtml = that.createSearchCityStr(result);
    //                    var str = that.createSearchHotelStr(result);
    //                    that.createSearchCityUI(str, oCityHtml, result, value);

    //                }
    //                else if (result && result.Success && result.List && result.List.length > 0 && result.HotelList && result.HotelList.length == 0) {
    //                    var oCityHtml = that.createSearchCityStr(result);
    //                    var str = "";
    //                    that.createSearchCityUI(str, oCityHtml, result, value);

    //                }
    //                else if (result && result.Success && result.List && result.List.length == 0 && result.HotelList && result.HotelList.length > 0) {
    //                    var array = new Array();
    //                    for (var i = 0; i < result.HotelList.length; i++) {
    //                        if ($.inArray(result.HotelList[i].cityNameValueZH, array) < 0) {
    //                            result.List.push({ "nameValueEN": result.HotelList[i].cityNameValueEN, "nameValueJA": result.HotelList[i].cityNameValueJA, "nameValueZH": result.HotelList[i].cityNameValueZH, "latitude": "", "longitude": "", "simpleSpell": "" })
    //                            array.push(result.HotelList[i].cityNameValueZH);
    //                        }
    //                    }
    //                    var oCityHtml = that.createSearchCityStr(result);
    //                    var str = that.createSearchHotelStr(result);
    //                    that.createSearchCityUI(str, oCityHtml, result, value);
    //                    //var city = {"nameValueEN":"shangrao","nameValueJA":"上饒","nameValueZH":"上饶","latitude":"","longitude":"","simpleSpell":""};
    //                }
    //                else {
    //                    //var oCityHtml = that.createSearchCityStr(result);
    //                    //var str = that.createSearchHotelStr(result);
    //                    that.createSearchCityUI("", "", result, value);
    //                    //var param = {
    //                    //    city: "",
    //                    //    word: value,
    //                    //    language: $("#contextLanguage").val()
    //                    //    //language: 'zh-CN' //TODO: temp haard code
    //                    //};
    //                    //$.ajax({
    //                    //    type: 'POST',
    //                    //    url: "/service/queryEsKeyword",
    //                    //    dataType: 'JSON',
    //                    //    data: param,
    //                    //    cache: false,
    //                    //    async: false,
    //                    //    success: function (responseData) {
    //                    //        var result = JSON.parse(responseData);

    //                    //        var myhtml = "";
    //                    //        if (result != undefined && result != null && result.keywords != undefined && result.keywords != null) {
    //                    //            var len = result.keywords.length;

    //                    //            var keywordsSTR = that.createSearchKeywordStr(result);

    //                    //            that.createSearchCityUI(keywordsSTR, "", result, value);


    //                    //        }
    //                    //    },
    //                    //    error: function (jqXHR, textStatus, errorThrown) {
    //                    //        //console.log("Error:", errorThrown);
    //                    //    }
    //                    //});
    //                }
    //            }
    //        });



    //    } else {
    //        Vcity._m.addClass('hide', this.div);
    //        Vcity._m.removeClass('hide', this.cityBox);

    //        Vcity._m.removeClass('hide', this.myIframe);

    //        this.changeIframe();
    //    }
    //    $('.citySelector').find('.cityslide').find('li').eq(0).addClass('on');
    //    $(".cityslide").find(".cityslide_adress").hover(function () {
    //        $('.citySelector').find('.cityslide').find('li').eq(0).removeClass('on');
    //    }, function () {

    //    });
    //},
    createSearchCityUI: function (str, oCityHtml, model, value) {
        var searchResult = [];
        //判断是否是城市
        if (oCityHtml && oCityHtml != "" && str && str != "") {
            str = oCityHtml + str;
        }
        else if (oCityHtml && oCityHtml != "") {
            str = oCityHtml;
        }
        //判断数据是否有结果
        if (str && str != "") {
            searchResult.push(str);
        }

        this.isEmpty = false;
        // 如果搜索数据为空
        if (searchResult.length == 0) {
            this.isEmpty = true;

            str = '<div class="empty">对不起，没有找到数据 "<em>' + value + '</em>"</div>';
            searchResult.push(str);
        }
        // 如果slideul不存在则添加ul
        if (!this.div) {
            var div = this.div = document.createElement('div');
            div.className = 'cityslide';
            this.rootDiv && this.rootDiv.appendChild(div);
            // 记录按键次数，方向键
            this.count = 0;
        } else if (this.div && Vcity._m.hasClass('hide', this.div)) {
            this.count = 0;
            Vcity._m.removeClass('hide', this.div);
        }
        this.div.innerHTML = searchResult.join('');
        //第一个li赋值选中on

        /* IE6 */
        this.changeIframe();

        // 绑定Li事件
        this.liEvent();
        this.cityEvent();
    },
    //createSearchCityStr: function (model) {

    //    var count = 7;
    //    //if (model.List.length < 7) {
    //    count = model.List.length;
    //    //}

    //    var oCityHtml = "";
    //    var currentlang = $("#contextLanguage").val();

    //    if (currentlang == "en") {
    //        oCityHtml = '<span class="cityslide_head">City</span>';
    //        for (var i = 0; i < count; i++) {
    //            oCityHtml += '<div class="cityslide_adress"><a href="javascript:;">' + model.List[i].nameValueEN + '</a><a  href="javascript:;" class="city_letter">' + model.List[i].nameValueEN + '</a></div>';
    //        }
    //    } else if (currentlang == "ja-JP") {
    //        oCityHtml = '<span class="cityslide_head">都市</span>';
    //        for (var i = 0; i < count; i++) {
    //            oCityHtml += '<div class="cityslide_adress"><a href="javascript:;">' + model.List[i].nameValueJA + '</a><a  href="javascript:;" class="city_letter">' + model.List[i].nameValueEN + '</a></div>';
    //        }
    //    } else {
    //        oCityHtml = '<span class="cityslide_head">城市</span>';
    //        for (var i = 0; i < count; i++) {

    //            oCityHtml += '<div class="cityslide_adress"><a href="javascript:;">' + model.List[i].nameValueZH + '</a><a  href="javascript:;" class="city_letter">' + model.List[i].nameValueEN + '</a></div>';
    //        }
    //    }
    //    return oCityHtml;
    //},
    createSearchHotelStr: function (model) {

        var str = "";
        var count = 7;
        if (model.HotelList.length < 7) {
            count = model.HotelList.length;
        }

        var currentlang = $("#contextLanguage").val();

        if (currentlang == "en") {
            str = '<span class="cityslide_head">Hotel</span><ul class="cityslide_hotel">';
            for (var i = 0; i < count; i++) {

                str += '<li><b class="cityslide_hotel_name">' + model.HotelList[i].hotelNameValueEN + '</b><b class="cityslide_hotel_adress">' + model.HotelList[i].cityNameValueEN + '</b></li>';
            }
        } else if (currentlang == "ja-JP") {
            str = '<span class="cityslide_head">ホテル</span><ul class="cityslide_hotel">';
            for (var i = 0; i < count; i++) {


                str += '<li><b class="cityslide_hotel_name">' + model.HotelList[i].hotelNameValueJA + '</b><b class="cityslide_hotel_adress">' + model.HotelList[i].cityNameValueJA + '</b></li>';
            }
        } else {
            str = '<span class="cityslide_head">酒店</span><ul class="cityslide_hotel">';
            for (var i = 0; i < count; i++) {

                str += '<li><b class="cityslide_hotel_name">' + model.HotelList[i].hotelNameValueZH + '</b><b class="cityslide_hotel_adress">' + model.HotelList[i].cityNameValueZH + '</b></li>';
            }
        }
        str += '</ul>';
        return str;
    },
    createSearchKeywordStr: function (model) {

        var str = "";
        var count = 7;

        if (model.keywords.length < 7) {
            count = model.keywords.length;
        }
        if (count > 0) {

            var currentlang = $("#contextLanguage").val();

            if (currentlang == "en") {
                str = '<span class="cityslide_head">Hotel</span><ul class="cityslide_hotel">';
                for (var i = 0; i < count; i++) {
                    var namevalue = "";
                    if (model.keywords[i].nameValueEN && model.keywords[i].nameValueEN != "null") {
                        namevalue = model.keywords[i].nameValueEN
                    }

                    str += '<li><b class="cityslide_hotel_name">' + model.keywords[i].KeyWordName + '</b><b class="cityslide_hotel_adress">' + namevalue + '</b></li>';
                }
            } else if (currentlang == "ja-JP") {
                str = '<span class="cityslide_head">ホテル</span><ul class="cityslide_hotel">';
                for (var i = 0; i < count; i++) {
                    var namevalue = "";
                    if (model.keywords[i].nameValueJA && model.keywords[i].nameValueJA != "null") {
                        namevalue = model.keywords[i].nameValueJA
                    }

                    str += '<li><b class="cityslide_hotel_name">' + model.keywords[i].KeyWordName + '</b><b class="cityslide_hotel_adress">' + namevalue + '</b></li>';
                }
            } else {
                str = '<span class="cityslide_head">酒店</span><ul class="cityslide_hotel">';
                for (var i = 0; i < count; i++) {
                    var namevalue = "";
                    if (model.keywords[i].nameValueZH && model.keywords[i].nameValueZH != "null") {
                        namevalue = model.keywords[i].nameValueZH
                    }
                    str += '<li><b class="cityslide_hotel_name">' + model.keywords[i].KeyWordName + '</b><b class="cityslide_hotel_adress">' + namevalue + '</b></li>';
                }
            }
            str += '</ul>';
        }
        return str;
    },
    /* IE6的改变遮罩SELECT 的 IFRAME尺寸大小 */
    changeIframe: function () {
        if (!this.isIE6) return;
        this.myIframe.style.width = this.rootDiv.offsetWidth + 'px';
        this.myIframe.style.height = this.rootDiv.offsetHeight + 'px';
    },

    /* *
     * 特定键盘事件，上、下、Enter键
     * @ KeyboardEvent
     * */

    KeyboardEvent: function (event, keycode) {
        var lis = Vcity._m.$('li', this.div);
        var len = lis.length;
        switch (keycode) {
            case 40: //向下箭头↓
                this.count++;
                if (this.count > len - 1) this.count = 0;
                for (var i = 0; i < len; i++) {
                    Vcity._m.removeClass('on', lis[i]);
                }
                Vcity._m.addClass('on', lis[this.count]);

                break;
            case 38: //向上箭头↑
                this.count--;
                if (this.count < 0) this.count = len - 1;
                for (i = 0; i < len; i++) {
                    Vcity._m.removeClass('on', lis[i]);
                }
                Vcity._m.addClass('on', lis[this.count]);
                break;
            case 13: // enter键
                this.input.value = $('.citySelector').find('.cityslide li').eq(this.count).find('b')[1].innerHTML;
                //关键字框赋值酒店名称
                $('.kw').find('.kw_input').attr('value', $('.citySelector').find('.cityslide li').eq(this.count).find('b')[0].innerHTML);
                $('.kw').find('.kw_input').next().hide();

                Vcity._m.addClass('hide', this.div);
                Vcity._m.addClass('hide', this.div);
                /* IE6 */
                Vcity._m.addClass('hide', this.myIframe);
                break;
            default:
                break;
        }
    },

    /* *
     * 下拉列表的li事件
     * @ liEvent
     * */

    liEvent: function () {
        var that = this;
        var lis = Vcity._m.$('li', that.div);
        //console.log(lis[1]);
        for (var i = 0, n = lis.length; i < n; i++) {
            var liobj = lis[i];
            (function (lio) {
                Vcity._m.on(lio, 'click', function (event) {
                    event = Vcity._m.getEvent(event);
                    var target = Vcity._m.getTarget(event);
                    //that.input.value = Vcity.regExChiese.exec(target.innerHTML)[0];

                    //that.input.value = $(this).find('b')[1].innerHTML;
                    that.input.value = $(lio).find('b')[1].innerHTML;
                    //$(this).find('b:eq(1)').html()
                    Vcity._m.addClass('hide', that.div);
                    //关键字框赋值酒店名称
                    //$('.kw').find('.kw_input').attr('value', $(this).find('b')[0].innerHTML);
                    $('.kw').find('.kw_input').attr('value', $(lio).find('b')[0].innerHTML);
                    $('.kw').find('.kw_input').next().hide();

                    /* IE6 下拉菜单点击事件 */
                    Vcity._m.addClass('hide', that.myIframe);
                });
            })(liobj);

            Vcity._m.on(lis[i], 'mouseover', function (event) {
                event = Vcity._m.getEvent(event);
                var target = Vcity._m.getTarget(event);
                Vcity._m.addClass('on', target);
            });
            Vcity._m.on(lis[i], 'mouseout', function (event) {
                event = Vcity._m.getEvent(event);
                var target = Vcity._m.getTarget(event);
                Vcity._m.removeClass('on', target);
            })
        }
    },

    cityEvent: function () {
        var that = this;
        var lis = Vcity._m.$('.cityslide_adress', that.div);
        //console.log(lis[1]);
        if (lis && lis.length > 0) {
            for (var i = 0, n = lis.length; i < n; i++) {

                var liobj = lis[i];
                (function (lio) {
                    Vcity._m.on(lio, 'click', function (event) {
                        event = Vcity._m.getEvent(event);
                        var target = Vcity._m.getTarget(event);
                        //that.input.value = Vcity.regExChiese.exec(target.innerHTML)[0];
                        if ($(lio).find('a').eq(0).data("destination") != undefined) {
                            that.input.value = that.getSecondString($(lio).find('a').eq(0).data("destination"));
                            cityDistrict.fulldisname = $(lio).find('a').eq(0).data("destination");
                            $('.kw').find('.kw_input').attr('value', $(lio).find('a').eq(0).html());
                            $('.kw').find('.kw_input').next().hide();
                            if (window.GroupHomeSearch != undefined) {
                                GroupHomeSearch();
                            } else if (window.HomeSearch != undefined) {
                                HomeSearch();
                            } else if ($(".btn_search").length > 0) {
                                $(".btn_search").click();
                            };
                        } else {
                            that.input.value = that.getFirstString($(lio).find('a').eq(0).html());
                            cityDistrict.fulldisname = $(lio).find('a').eq(0).html();
                            $('.kw').find('.kw_input').attr('value', "");
                            $('.kw').find('.kw_input').next().show();

                        }
                        Vcity._m.addClass('hide', that.div);
                        //关键字框赋值酒店名称
                        //$('.kw').find('.kw_input').attr('value', $(this).find('b')[0].innerHTML);
                        //$('.kw').find('.kw_input').next().hide();

                        /* IE6 下拉菜单点击事件 */
                        Vcity._m.addClass('hide', that.myIframe);
                        Vcity._m.stopPropagation(event);
                    });
                })(liobj);


                //Vcity._m.on(lis[i], 'mouseover', function (event) {
                //    event = Vcity._m.getEvent(event);
                //    var target = Vcity._m.getTarget(event);
                //    Vcity._m.addClass('on', target);
                //});
                //Vcity._m.on(lis[i], 'mouseout', function (event) {
                //    event = Vcity._m.getEvent(event);
                //    var target = Vcity._m.getTarget(event);
                //    Vcity._m.removeClass('on', target);
                //})
            }
        }
    }
};