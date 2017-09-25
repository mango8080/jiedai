$(function(){
	//筛选
	$(".filter-btn ul li:first-child").click(function(){
		$(".filter-btn ul li:last-child").removeClass("on").removeClass("sx").removeClass("jx");
		$(this).addClass("on").siblings().removeClass("on");
	})

	$(".filter-btn ul li:last-child").click(function(){
		$(".filter-btn ul li:first-child").removeClass("on").removeClass("sx").removeClass("jx");
		$(this).addClass("on").siblings().removeClass("on");
		if($(this).hasClass("sx")){
			$(this).removeClass("sx").addClass("jx");
		}else if($(this).hasClass("jx")){
			$(this).removeClass("jx").addClass("sx");
		}else{
			if(orderSequenceForPrice == "desc"){
				$(this).addClass("jx");
			} else {
				$(this).addClass("sx");
			}
		}
	})
	
	//酒店查询
	$(".hotel-serch ul li").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
		var flag = $(".cx").hasClass("on");
		if(flag == true){
			$(".input-cont4").show();
			$(".colle").hide();	
			$(".btn").show();
		}else{
			$(".input-cont4").hide();
			$(".colle").show();	
			$(".btn").hide();	
		}
	})
	
	//酒店详情
	$(".room-list ul").click(function(){
		$(".room-list ul").children(".user-list").slideUp();
		if($($(this).children(".user-list")[0]).css("display")=='none'){
			$(this).children(".user-list").slideDown();
		}
	})
	//选择城市
	$(".select-titles").prev().attr("style","border:none");
	
	//点击收藏
	$(".collection").click(function(){
		var srcval = $(this).children("img").attr("src");
		if(srcval === "../hotel/collection_icon.png"){
			$(this).children("img").attr("src","../hotel/collection_icon1.png");
			return;	
		}else{
			$(this).children("img").attr("src","../hotel/collection_icon.png");
			return;
		}
	})
})