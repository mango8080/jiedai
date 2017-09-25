// JavaScript Document
var val = [];
$.fn.extend({
	
	verificationCode : function(prcUrl, captureEle){
		
		//this : $('#imgCheck')
		
		
		var This = this;
		var urlPath ='';

		
		urlPath = "url('" + prcUrl + "')";

		$(this).find(".imgCap").css({"background-image":urlPath});
		$(this).find('dd.imgCap').click(function(e){
			e.preventDefault();
			var index = This.find('dd').index($(this)),
				m = parseInt( captureEle.eq(index).val() ),
				_m = m>0 ? (m + 1) : 1,
				x,y,
				arr = [];
            if($.browser.msie && ( parseInt($.browser.version) < 9 ) && !$.support.style ? true : false){
				arr[0] = $(this).css("background-position-x");
				arr[1] = $(this).css("background-position-y");
			}else{
				arr = $.trim( $(this).css("background-position").replace(/\s{2,}/ig, "")).split(" ");
	
			}
	
			x = parseInt( arr[0].replace("px", "") ),
			y = parseInt( arr[1].replace("px", "") );
			y = y-64 > -256 ? (y-64):0;
			$(this).css({
				"background-position": x + 'px ' + y + 'px'
			});
            captureEle.eq(index).val(_m);
			return false;
		});
        //循环数组赋值
		for(var i = 0; i <captureEle.length; i++){
			val[i] = captureEle.eq(i).val();
		}
		return val;
	}
	
});


