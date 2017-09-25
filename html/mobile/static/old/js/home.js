var backhome=document.createElement("div");
$(backhome).addClass("back-home");
backhome.innerHTML="<div class='back-home-bg' style='z-index:-1'><div  class='back-home-img' onclick='javascript:f_toHome()'  style='position: absolute;top: 2px; z-index: 100000;display: inline-block;width: 45px;height: 43px;'></div></div>"
$(".wrap").append(backhome);
	$(".back-home").click(function(){
		var flag = $(this).children(".back-home-bg").hasClass("on");
		//console.log(flag);
		if(flag){
			$(this).children(".back-home-bg").removeClass("on");
			$(this).animate({left:'0px'});
		}else{
			$(this).children(".back-home-bg").addClass("on");
			$(this).animate({left:'55px'});
		}
	})
	$(".closes").click(function(){
		$(this).parent(".download-applink").hide();
	})
function f_toHome(){
	location.href = "../index/toIndex";
}

function isCardNo(card){
    var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    if(reg.test(card) === false){
        return false;
    }else{
    	return true;
    }
 }