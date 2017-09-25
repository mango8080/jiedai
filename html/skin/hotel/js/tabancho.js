/*
Author: stan gao;
Date: 2015-12-22;
Descript: tab锚点插件。
*/
//绑定tab锚点事件
jQuery.fn.tabAnchor= function(settings){
	
	settings = jQuery.extend({
					tabTitle: 'tab_anchor_title_box',//tab锚点标题头部class
					tabTitlePlace :'tab_anchor_fill_box',//tab锚点标题头部占位class
					tabMain :'tab_anchor_content_box',//tab锚点内容class
					tabSingel :'tab_anchor_unit',//tab锚点内容class
					tabStyle : 1 ,//0代表头部横向在内容中，1代表纵向在左右两侧
					tabFixedTopPosition : 0 , //这个值代表tab锚点标题浮动的top位置
					tabFixedLeftPosition: 0 , //这个值代表tab锚点标题浮动的left位置
					tabhide : 1000 , //最小隐藏宽度
					relativeLeft: 'className',//Left相对元素
					rec_origin: false,//是否记录原点
					max_range:99999999999 //最大滚动值
				}, settings);
	
	$("."+settings.tabTitle).find("li").first().addClass("selected");//为第一个title添加选中样式
	$("."+settings.tabTitle).find("li").bind("click", function(){//为每一个title绑定点击事件
		var that = $(this);
		//根据点击的title滚动页面。$("#" + $(this).attr("anchor_id")).offset().top为选中内容框的top值，$("."+settings.tabTitle).height(为该tab框title节点；100为动画延时时间；function为动画效果结束后的回调函数
		if(settings.tabStyle == '0'){
			$("html,body").animate({scrollTop:$("#" + $(this).attr("anchor_id")).offset().top - $("."+settings.tabTitle).height()},100, null, function(){
				that.parent().find(".selected").removeClass("selected");//移除所有选中的title样式
				that.addClass("selected");//为点击的title添加选中样式
			});
		}else if(settings.tabStyle == '1'){
			$("html,body").animate({scrollTop:$("#" + $(this).attr("anchor_id")).offset().top -50},100, null, function(){
				that.parent().find(".selected").removeClass("selected");//移除所有选中的title样式
				that.addClass("selected");//为点击的title添加选中样式
			});
		}
		
	});
	var this_tab_anthor_title_position = $("."+settings.tabTitle).css("position");//获取title框原先position值
	var this_tab_anthor_title_position_left = $("."+settings.tabTitle).css("left");//获取title框原先position值left
	var this_tab_anthor_title_position_top = $("."+settings.tabTitle).css("top");//获取title框原先position值left
	var this_tab_anthor_title_top = $("."+settings.tabTitle).offset().top;//获取title框的top值
	var this_tab_anthor_title_left = $("."+settings.tabTitle).offset().left;//获取title框的left值
	var this_tab_anchor_content_top = $("."+settings.tabMain).offset().top//获取tab框的top值
	var this_tab_anchor_content_bottom = $("."+settings.tabMain).offset().top + $("."+settings.tabMain).height();//获取tab框底部的top值
	var this_tab_anthor_title_width = $("."+settings.tabTitle).width();//获取title框的宽度
	var this_tab_anthor_content_width = $("."+settings.tabSingel).width();//获取tab框的宽度
	var this_tab_anthor_content_margin = parseInt($("."+settings.tabSingel).css('marginLeft'))/2;//获取tab框的宽度
	var this_tab_anthor_title_fixed_margin = 0;
	var windowHeight = $(window).height();
	// 是否为原点
	var whether_origin = null;

	this_tab_anthor_title_fixed_margin = -12 - this_tab_anthor_content_width/2 - this_tab_anthor_title_width + this_tab_anthor_content_margin;
	$(window).scroll(function(){//绑定滚动事件
		tabScroll();
	});
	$(window).resize(function(){//绑定滚动事件
		tabTitlesShow();
		tabScroll();
	});
	function tabTitlesShow(){
		if($(window).width() < settings.tabhide){
			$("."+settings.tabTitle).hide();
		}else{
			$("."+settings.tabTitle).show();
		}
	}
	//显示隐藏方法执行
	tabTitlesShow();
	
	//锚点滚动方法
	function tabScroll(){
		var st = $(document).scrollTop();//获取滚动条高度
		var beginScorll = parseInt((windowHeight - $("."+settings.tabTitle).height())/2);
		var showHeight = parseInt(windowHeight/3);
		    showHeight = showHeight < 300 ? showHeight : 300; 
		//最小宽度时隐藏	
		if (st > this_tab_anthor_title_top && st < this_tab_anchor_content_bottom && settings.tabStyle == '0'){//判定滚动条是否在tab框之间滚动
			$("."+settings.tabTitlePlace).show();//显示title框的填充框
			$("."+settings.tabTitle).css({"position" : "fixed", "top" : settings.tabFixedTopPosition, "left" : settings.tabFixedLeftPosition });//title框跟随浮动
			// 以下新增判断内功能为：相对某物体定位
			if(settings.relativeLeft){	
				var reLeft = $("."+settings.relativeLeft).offset().left;
				$("."+settings.tabTitle).css({"position" : "fixed", "top" : settings.tabFixedTopPosition, "left" : reLeft });//title框跟随浮动
			}
			if(settings.rec_origin){
				whether_origin = false;
			}
			// 新增功能结束，作者：小武

			var selected_title_num = 0;//被选title的个数
			for (var i = 0; i < $("."+settings.tabSingel).length; i++){//循环tab内容单元节点
				if (st >= ($($("."+settings.tabSingel)[i]).offset().top - $("."+settings.tabTitle).outerHeight(true))){//若滚动条所在位置大于（该tab内容单元top-tab标题框的高度-1）
					selected_title_num = i;
				} else {
					break;
				}
			}
			$("."+settings.tabTitle).find(".selected").removeClass("selected");//移除所有title选中样式
			$($("."+settings.tabTitle).find("li")[selected_title_num]).addClass("selected");//为对应title添加选中样式
		} else if(st < settings.max_range && st > this_tab_anchor_content_top && st < this_tab_anchor_content_bottom && settings.tabStyle == '1'){
			//$("."+settings.tabTitlePlace).show();//显示title框的填充框
			$("."+settings.tabTitle).css({"position" : "fixed","margin-left":this_tab_anthor_title_fixed_margin});//title框跟随浮动
			$("."+settings.tabTitle).addClass("float_left_fixed");
			$("."+settings.tabTitle).stop().animate({"top":beginScorll},200);
			var selected_title_num = 0;//被选title的个数
			for (var i = 0; i < $("."+settings.tabSingel).length; i++){//循环tab内容单元节点
				if (st >= ($($("."+settings.tabSingel)[i]).offset().top - showHeight)){//若滚动条所在位置大于（该tab内容单元top-tab标题框的高度-1）
					selected_title_num = i;
				} else {
					break;
				}
			}
			$("."+settings.tabTitle).find(".selected").removeClass("selected");//移除所有title选中样式
			$($("."+settings.tabTitle).find("li")[selected_title_num]).addClass("selected");//为对应title添加选中样式
		} else {
			$("."+settings.tabTitlePlace).hide();//隐藏title框的填充框
			$("."+settings.tabTitle).css({"position" : this_tab_anthor_title_position,"margin-left":0});//title框固定
			$("."+settings.tabTitle).removeClass("float_left_fixed");
			$("."+settings.tabTitle).stop().animate({"top":this_tab_anthor_title_position_top},200);
			if(settings.rec_origin){
				whether_origin = true;
			}
		}
		// 详情页立即预定，作者：小武
		if(settings.rec_origin){	
			if(!whether_origin && $(".back_booknow").length){
				$(".back_booknow").css("display","block");
			}else{
				$(".back_booknow").css("display","none");
			}
		}
	}
	//tabScroll默认执行一次
	tabScroll();

}

