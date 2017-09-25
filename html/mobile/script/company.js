$(function(){
	var sortClick = true;
    $('.box_paixu a').each(function(){
    	if(GetQueryString($(this).attr('sortord')) == $(this).attr('sort')){
    		$(this).addClass('on');
    	}else{
    		$(this).removeClass('on');
    	}
    }).click(function(){
    	if(!$(this).is('.on')){
    		var url = window.location.href;
    		sortClick == false;
    		$(this).addClass('on').siblings().removeClass('on');
    		if($(this).attr('sortord') == 'orderDistance'){
    			url = changeURLArg(url,'orderPrice','');
    		}else if($(this).attr('sortord') == 'orderPrice'){
    			url = changeURLArg(url,'orderDistance','');
    		}
    		window.location.href = changeURLArg(url,$(this).attr('sortord'),$(this).attr('sort'));
    	}
	})
	$('#btnPx,#paiXuMask').on('click',function(){
		$('#paiXuMask').fadeToggle();
		$('.box_paixu').slideToggle();
	});

	var windowHeight=$(window).height();
	var documentHeight;
	var scrollHeight;
	var counter = 0;
	var num = 10;
	var pageStart = 0;
	var pageEnd = 0;
	var address=window.location.href.replace('mod4', "mod15");
	$(window).scroll(function(){
		scrollHeight=$(window).scrollTop();
		documentHeight=$(document).height();
		if (documentHeight==windowHeight+scrollHeight) {
			$.ajax({
			     type: 'POST',
			     url:address,
			     dataType:"json",
			    success: function(data){
			    	var result = '';
			    	counter++;
			    	pageEnd = num * counter;
			    	pageStart = pageEnd - num;
			    	if(pageStart <= data.totalRecords){
			    		for(var i = pageStart; i < pageEnd; i++){
			    		    result += "<div>"+data.data[i].company+"</div>"+"哈哈哈";
			    		    if((i + 1) >= data.totalRecords){
			    		        break;
			    		        $(window).unbind("scroll");
			    		    }
			    		}
			    		$("#insert").append(result);
			    	}
					console.log(data.status);
			    }
			});
		}
	});
	
});
//采用正则表达式获取地址栏参数
function GetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
}
//替换URL链接中的某个参数 
function changeURLArg(url,arg,arg_val){ 
    var pattern=arg+'=([^&]*)'; 
    var replaceText=arg+'='+arg_val; 
    if(url.match(pattern)){ 
        var tmp='/('+ arg+'=)([^&]*)/gi'; 
        tmp=url.replace(eval(tmp),replaceText); 
        return tmp; 
    }else{ 
        if(url.match('[\?]')){ 
            return url+'&'+replaceText; 
        }else{ 
            return url+'?'+replaceText; 
        } 
    } 
    return url+'\n'+arg+'\n'+arg_val; 
} 