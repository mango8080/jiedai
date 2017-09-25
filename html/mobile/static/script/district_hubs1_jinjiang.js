$(function(){
	var sta = true;
	var selCount=-1;
	var isFind=false;
	var appendContent = function(array,id){
		if(id != 'traffic_line'){
			//$('#'+id+' ul').append('<li>不限</li>');
			console.log('#'+id+' ul');
			for(var i=0;i<array.length;i++){
				$('#'+id+' ul').append('<li location="'+array[i].location+'" dat-type="'+array[i].stype+'">'+array[i].name+'</li>');
			}
		}else{
			//$('#traffic_line .list_one').append('<li class="null"><a>不限</a></li>');
			for(var i=0;i<array.length;i++){
				$('#traffic_line .list_one').append('<li><a href="#dt'+i+'">'+array[i].name+'</a></li>');
				var subItem = array[i].items,
				 	subContent = '';
				for(var j=0;j<subItem.length;j++){
					subContent = subContent+'<li location="'+subItem[j].location+'" class="station">'+subItem[j].itemName+'</li>';
				}
				$('#traffic_line').append('<div id="dt'+i+'"><ul>'+subContent+'</ul></div>');
				$('#traffic_line .list_one>li>a:eq(1)').addClass('active');
				$('#traffic_line>div:eq(0)').show().siblings('div').hide();
			}
		}
		$('#'+id).attr('show','T');
		$('.nav.nav-tabs').find('a[aria-controls='+id+']').parent().attr('show','T');
		
	}
	function districtShow(){
    	$('.districtlist_search').hide().empty();
    	//$('.title_tab.active').show();
    	$('.del').hide();
		$('.cancel').remove();
		$('#districtSearch').val('');
		$('#districtSearch').removeAttr('style');
    }
	function districtHide(){
    	$('#districtSearch').css('width','70%');
    	$('#districtSearch').after('<a class="cancel">确认</a>');
    	$('.districtlist_search').show().empty();
    	$('.title_tab.active').hide();
		$('.cancel').click(function(){
			//districtShow();
			//sta = true;
			var url = window.location.href;
			
			//$(".back").click();
			var keyWord = $("#districtSearch2").val();
			/*$('#district span').text(keyWord);
			$("#keyword").val(keyWord);*/
			if(keyWord==""){
				window.location.href = changeURLArg(url,"wd","");
				$('#district span').text("关键字/位置/酒店名");
				$("#keyword").val("");
			}else{
				window.location.href = changeURLArg(url,"wd",keyWord);
				if($(".districtlist_search p").text()=="无查询结果"){
					$('#district span').text("关键字/位置/酒店名");
					$("#keyword").val("");
				}else{
					$('#district span').text(keyWord);
					$("#keyword").val(keyWord);
				}
	        }
        });
    }
	function cleanSearch(){
    	$('#districtSearch').val('');
    	$('.districtlist_search').empty();
		$('.del').hide();
	}
	 
	var selectPio = function(obj){
		var placeName = obj.text();
		var url = window.location.href;
		if(obj.text() == '不限'){
			window.location.href = changeURLArg(url,"wd","");
			
		}else{
			/*var location = obj.attr('location');
			location = location.split(',');
			url = changeURLArg(url,"lat",location[0]);
			url = changeURLArg(url,"lng",location[1]);
			*/
			url = changeURLArg(url,"wd",placeName);
			url = changeURLArg(url,"wtype",obj.attr('dat-type'));
			window.location.href =url;
		}
	}
	var cityFlag = '';//获取pio标记城市
	$('#districtPage .title_top a').click(function(){
		$(this).addClass('active').siblings('a').removeClass('active');
		$('.title_tab').eq($(this).index()).show().siblings('.title_tab').hide();
	});
	$('#shaiXuan').click(function(){
		var cityName = localStorage.city;
		if (!cityName){
			cityName = localStorage.curcity;
		}
		if(cityName == cityFlag  && cityFlag != ''){//判断选择城市和标记城市是否一致，不一致则重新获取城市pio
			$('#searchPage,#hotelPage').hide();
			$('#districtPage').show();
			districtShow();
			return false;
		}
		if(cityName != ''){
			/*$('.city_select li').each(function(){
				var compareCity = $(this).text();
				if(compareCity == cityName){
					cityFlag = cityName;
					$('input[name=cityName]').val(compareCity);
					return false;
				}
			});*/
		}else{
			alert('请先选择城市');
			return false;
		}
		$('.tab-content>.tab-pane>div>ul>li').remove();
		$('#traffic_line ul li').remove();
		$('#traffic_line>div').remove();
		$.ajax({
			url:'getCityPioHubs.php',
			data:{cityName:cityName},
			dataType:'json',
			success:function(data){
				if(data.stat != '1'){
					alert(data.msg);
					return false;
				}
				var result = data.result;
				console.log(result.length);
				for(var i=0;i<result.length;i++){
					var title = result[i].title,
						array = result[i].results;
					if(title == '交通枢纽'){
						appendContent(array,'traffic_hub');
					}else if(title == '交通沿线'){
						appendContent(array,'traffic_line');
					}else if(title == '品牌'){
						appendContent(array,'bussiness');
					}else if(title == '星级'){
						appendContent(array,'spot');
					}else if(title == '行政区'){
						appendContent(array,'area');
					}
				}
				$('.tab-content>.tab-pane>div>ul>li').click(function(){
					 selectPio($(this));
				});
				$('.tab-content>.tab-pane>ul>li').click(function(){
					if($(this).text() == '不限' || $(this).find('a').text() == '不限'){						
						$('#districtPage').hide();
						$('.paixu.clearfix').hide();
						$('#searchPage,#hotelPage').show();
						return false;
					}else{
						$(this).addClass('active');
						$(this).parent().find('a').removeClass('active');
						$(this).find('a').addClass('active');
						$('#traffic_line>div[id='+$(this).find('a').attr('href').substring(1)+']').show().siblings('div').hide();
					}
				});
			}
		});
		/*$('#searchPage,#hotelPage').hide();*/
		$('#districtPage').show();
		$('.paixu.clearfix').hide();
		$('.nav.nav-tabs>li>a:eq(0)').click();
	})
	
	$('.list_one li a').click(function(){
		$(this).addClass('active').parent('li').siblings('li').children('a').removeClass('active');
		var heef = $(this).attr("href");
		//heef =heef.substring(1,heef.length)
		$(heef).show().siblings('div').hide();
	})
	
	$('.del').click(function(){
    	cleanSearch();
    });
	$(".js_clear").click(function(){
		$('#district span').text('关键字/位置/酒店名');
		$('#wd').val("");
		$('input[name=wtype]').val("");
		$(".hotel-keyword-filter").find("li").remove();
   		$(".district_history").hide();
   		selCount=-1;
    });
	
	$('#page_back,.back').click(function(){
		$('#districtPage').hide();
		$('#searchPage,#hotelPage').show();
		districtShow();
		sta = true;
	});
	$('#districtSearch').bind('focus', function (){
    	districtHide();
    	cleanSearch();
    });
	
	 $('#districtSearch').bind('input', function (){
    	var key = $(this).val().trim();
    	var cityName = localStorage.city;
    	$("#districtSearch2").val($("#districtSearch").val());
    	if(key != ''){
    		$('.del').show();
    		$.ajax({
    			url: "/queryCityPioListHubs1.htm",
    			data:{key:key,cityName:cityName},
    		    type: "post",
    			dataType: "json",    
    		    success: function(data){
    		    	$('.districtlist_search').empty();
    		    	if(data.stat != 1){
    			    	$('.districtlist_search').append('<p>无查询结果</p>');
    		    		return false;
    		    	}
    		    	var array = data.result;
    			    for(var i=0;i<array.length;i++){//循环添加城市信息
        			    $('.districtlist_search').append('<p location="'+array[i].location+'">'+array[i].name+'</p>');
    			    }
    			    $('.districtlist_search p').click(function(){
    			    	 selectPio($(this));
    			    	 districtShow();
    			    });
    		    }
    		});
    	}else{
    		cleanSearch();
    	}
    });
	 function GetRequest() {
			var url = location.search;
			var theRequest = new Object();
			if (url.indexOf("?") != -1) {
				var str = url.substr(1);
				strs = str.split("&");
				for (var i = 0; i < strs.length; i++) {
					theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
				}
			}
			return theRequest;
		}
})