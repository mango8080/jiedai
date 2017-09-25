$(function(){
	 var query = false;
	 $("#minus").click(function(event) {
	     var num=parseInt($(".rooms").text())
	     $(".rooms").text(((num<=1?2:num)-1)+"间");
	     $('input[name=roomNum]').val((num<=1?2:num)-1);
	 });
	 $("#plus").click(function(event) {
	    var num=parseInt($(".rooms").text());
	    if(num == 3){
	    	num = 3;
	    	$(".rooms").text(num+"间"); 
	    }else{
	    	$(".rooms").text((num+1)+"间");
	    	$('input[name=roomNum]').val(num+1);
	    }
	 });
	 $('#SearchGo').on('click',function(){
		 var reg=new RegExp("/","g"); //创建正则RegExp对象 
		 var curLat = $('input[name=curLat]').val(),
			curLong = $('input[name=curLong]').val(),
			cityLat = $('input[name=cityLat]').val(),
			cityLong = $('input[name=cityLong]').val(),
			beginDate = $('#dtp_input2').val(),
			endDate = $('#dtp_input3').val(),
			cityName = $('input[name=cityName]').val(),
			text = $('.text').text();
		 if(text == '请选择城市'){
			 alert('请先选择城市');
			 return false;
		 }
		 beginDate = beginDate.replace(reg,'-');
		 endDate = endDate.replace(reg,'-');
		 $('input[name=beginDate]').val(beginDate);
		 $('input[name=endDate]').val(endDate);
		 if(cityName == ''){
			 alert('请先选择城市');
			 return false;
		 }
		 if(cityLat == '' || cityLong == ''){
			 $('.city_select li').each(function(){
					var compareCity = $(this).text();
					if(compareCity == cityName){
						console.log($(this).attr('location'));
						var location = $(this).attr('location').split(',');
						$('input[name=cityName]').val(compareCity);
						$('input[name=cityLat]').val(location[1]);
						$('input[name=cityLong]').val(location[0]);
					}
			 });
		 }
		console.log();
		 $('#speedSearch').submit();
	 });
});