$(function () {
	var i=0;
	var clone=$(".banner .img li").first().clone();
	$(".banner .img ").append(clone);
	var size=$(".banner .img li").size();
	for(var j=0;j<size-1;j++){
		$(".banner .num").append("<li></li>");
	}
	$(".banner .num li").first().addClass("on");
	
	//自动轮播
	var t=setInterval(function(){
		i++;
		move();
	},2000)

	function move(){
		if(i==size){
			$(".banner .img").css({left:0});
			i=1;
		}
		if(i==-1){
			$(".banner .img").css({left:-(size-1)*900});
			i=size-2;
		}
		$(".banner .img").stop().animate({left:-i*900},500);
		if(i==size-1){
			$(".banner .num li").eq(0).addClass("on").siblings().removeClass("on");
		}else{
			$(".banner .num li").eq(i).addClass("on").siblings().removeClass("on");
		}
	}
})