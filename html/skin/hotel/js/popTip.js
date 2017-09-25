/*
time://2013-3-15
texttip:弹出框  一般情况下不变
width:弹出的宽度
height:弹出的高度 可为空
left:弹出偏移量
positionleft：小图标（三角）左右偏移量
*/

jQuery.fn.popTip = function (params) {
    var p = params || {
        texttip: 'jjui_poptext',
        width: 300,
        maxwidth: 350,
        left: 0,
        positionleft: 50
    };
    var _width = p.width;
    var _height = p.height;
    var _left = p.left;
    var _positionleft = p.positionleft;
    var _maxwidth = p.maxwidth;
    var htm = '<div id="jjui_poptext" style="position:absolute; display:none; color:#666;z-index:999;">' +
				'<div style="border:1px solid #e7e7e7;box-shadow:#e7e7e7 0px 0px 5px; margin-top:-2px; position:absolute;bottom: -100%;font-size:12px;background:#fff;width:auto;">' +
					'<div class="jjui_cornu" style="background:url(http://Static1.ejinjiang.com/themes/NewInns/list/images/cornu.png) no-repeat left 1px;-left:100px; height:8px; line-height:8px; width:100%;z-index:1; position:absolute; bottom:-7px;left:0"></div>' +
					'<div class="jjui_content clearfix" style=" padding:10px;">' +
					'</div>' +
					'<p class="jjui_bottom" style="color:#06a1ea;text-align:right;padding:0 6px 6px;display:none;"><a target="_blank" href="#" style="color:#06a1ea;">查看该品牌所有线路</a>&nbsp;&nbsp;</p>' +

				'</div>' +
			'</div>'
    if (!$("#" + p.texttip).attr('id')) {
        $('body').append(htm);
    }
    $(this).hover(function () {
        var datadase = $(this).attr('data-params');
        var k = eval('(' + datadase + ')');
        var h = $(this).height();
        var wPackage = 1;
        var beginTop = $(this).offset().top - 10;
        var This = this;
        var template = {
            title_txt: '<div class="pop_package" style="float:left;"><h3 style="font-size:12px;color:#1d7ad9; padding-bottom:6px; border-bottom:1px solid #ececec;">' + k.options.content.title1 + '</h3><p style="line-height:21px;display:block;padding-top:4px;color:#777777;">' + k.options.content.txt1 + '</p>' + '<p style="line-height:21px;display:block;padding-top:6px;color:#777777;">' + k.options.content.time1 + '</p></div>',
            txt: '<p>' + k.options.content.txt1 + '</p>',
            time: '<p>' + k.options.content.time1 + '</p>'
        }
        for (var i = 1; i < k.options.packageNum; i++) {
            template[k.options.template] += '<div class="pop_package" style="float:left;"><h3 style="font-size:12px;color:#1d7ad9; padding-bottom:6px; border-bottom:1px solid #ececec;">' + k.options.content.title2 + '</h3><p style="line-height:21px;display:block;padding-top:4px;color:#777777;">' + k.options.content.txt2 + '</p>' + '<p style="line-height:21px;display:block;padding-top:6px;color:#777777;">' + k.options.content.time2 + '</p></div>';
        }
        _width = p.width * k.options.packageNum;//宽度*礼包个数
        _maxwidth = p.maxwidth * k.options.packageNum;//宽度*礼包个数
        wPackage = (1 / k.options.packageNum) * _width - (k.options.packageNum - 1) * 5 + "px";
        if (!k.options.content.href) { $("#" + p.texttip).find('a').hide(); }
        else { $("#" + p.texttip).find('a').text(k.options.content.thref).show().attr('href', k.options.content.href); }
        $("#" + p.texttip).find('div.jjui_cornu').css({ 'background-position': _positionleft + 'px 1px' });
        $("#" + p.texttip).find('div.jjui_content').html(template[k.options.template]).css({ 'width': _width, '_width': _maxwidth, 'height': _height, 'max-width': _maxwidth });
        $(".pop_package").css({ 'width': wPackage });
        $(".pop_package").eq(1).css({ 'margin-left': '10px' });
        $("#" + p.texttip).css({ 'left': $(this).offset().left - _positionleft + _left, 'top': $(this).offset().top - 10 }).show();

        //if($(".fixedside").length > 0){
        //				 $(window).scroll(function () {
        //						 var st = $(document).scrollTop();
        //						 var libaoHeight = beginTop + st -$(".top_nav").height() - 31;
        //						 console.log(libaoHeight);
        //						 //console.log(libaoHeight);
        //						 $("#"+ p.texttip).css({'left':$(This).offset().left-_positionleft+_left,'top':libaoHeight}).show();
        //						 
        //					  
        //				 })
        //				  	
        //			}else{
        //				 $("#"+ p.texttip).css({'left':$(This).offset().left-_positionleft+_left,'top':$(This).offset().top-10}).show();	
        //			}

    }, function () {
        $("#" + p.texttip).hide();
    });
    $("#" + p.texttip).hover(function () {
        $("#" + p.texttip).show();
    }, function () {
        $("#" + p.texttip).hide();
    });

};
