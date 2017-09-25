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

					subContent = subContent+'<li location="'+subItem[j].location+'" class="station" dat-type="'+subItem[j].stype+'">'+subItem[j].itemName+'</li>';

				}

				$('#traffic_line').append('<div id="dt'+i+'"><ul>'+subContent+'</ul></div>');

				$('#traffic_line .list_one>li>a:eq(1)').addClass('active');

				$('#traffic_line>div:eq(0)').show().siblings('div').hide();

			}

		}

		/*$('#'+id).attr('show','T');

		$('.nav.nav-tabs').find('a[aria-controls='+id+']').parent().attr('show','T');*/

		

	}

	function districtShow(){

    	$('.districtlist_search').hide().empty();

    	

    	$('.del').hide();

		$('.cancel').remove();

		$('#districtSearch').val('');

		$('#districtSearch').removeAttr('style');

    }

	function districtHide(){

    	/*$('#districtSearch').css('width','70%');

    	$('#districtSearch').after('<a class="cancel">确认</a>');
*/
    	$('.districtlist_search').show();//.empty();

    	/*$('.title_tab.active').hide();*/

		$('.cancel').click(function(){

			//districtShow();

			//sta = true;

			var url = window.location.href;

			//$(".back").click();

			var keyWord = $("#districtSearch2").val();

			/*$('#district span').text(keyWord);

			$("#keyword").val(keyWord);*/

			if(keyWord==""){

				$('#district span').text("关键字/位置/酒店名");

				$("#keyword").val("");

				$('#wd').val("");

				$('input[name=wtype]').val("");

			}else{

				if($(".districtlist_search p").text()=="无查询结果"){

					$('#district span').text("关键字/位置/酒店名");

					$("#keyword").val("");

				}else{

					$('#district span').text(keyWord);

					$("#keyword").val(keyWord);

				}

	        }

			

			$(".hotel-keyword-filter").find("li").remove();

	   		$(".district_history").hide();

	   		

			$('#districtPage').hide();

			$('#searchPage,#hotelPage').show();

        });

    }

	function cleanSearch(){

    	$('#districtSearch').val('');

    	$('.districtlist_search').empty();

		$('.del').hide();

	}

	 

	var selectPio = function(obj){

		var placeName = obj.text();

		if(obj.text() == '不限'){

			$('#districtPage').hide();

			$('.paixu.clearfix').hide();

			$('#searchPage,#hotelPage').show();

			$('#district span').text('关键字/位置/酒店名');

			$('input[name=from]').val('2');

			$('#wd').val("");

			$('input[name=wtype]').val("");

			return false;

		}else{

			//添加到已选标签

			//先判断

			isFind=false;

			strSel="";

			strSelID="";

			$(".hotel-keyword-filter").find("li").each(function () {

				strSel+=$(this).data("id")+"/";

				strSelID+=$(this).data("catid")+"/";

				if ($(this).data("id")==placeName){

					isFind=true;

				}

			});

			if (!isFind){

				selCount++;

		   		var strHis='<li data-idx="'+selCount+'" data-catid="'+obj.attr('dat-type')+'" data-key="history" data-id="'+placeName+'" class="js_kw_cell_item">'+placeName+'</li>';

		   		$(".hotel-keyword-filter").append(strHis);

		   		$(".district_history").show();

				

		   		strSel+=placeName;

		   		strSelID+=obj.attr('dat-type');

				$('#district span').text(strSel);

				var location = obj.attr('location');

				location = location.split(',');

				$('input[name=lat]').val(location[0]);

				$('input[name=lng]').val(location[1]);

				$('input[name=from]').val('1');

				$('#wd').val(strSel);

				$('input[name=wtype]').val(strSelID);

				

				$('input[name=from]').val('1');

				var record = {'location':obj.attr('location'),'name':strSel};

		   		//将选择的信息存储在本地localStorage

		   		//localStorage.setItem('district',JSON.stringify(record));

			}

			

	   		

		}

	}

	var cityFlag = '';//获取pio标记城市

	

	$('#district').click(function(){		

		//console.log(${param.city});

		var cityName = $('input[name=cityName]').val();

		console.log(cityName+','+cityFlag);

		if(cityName == cityFlag  && cityFlag != ''){//判断选择城市和标记城市是否一致，不一致则重新获取城市pio

			$('#searchPage,#hotelPage').hide();

			$('#districtPage').show();

			districtShow();

			return false;

		}

		if(cityName != ''){

			$('.city_select li').each(function(){

				var compareCity = $(this).text();

				if(compareCity == cityName){

					cityFlag = cityName;

					$('input[name=cityName]').val(compareCity);

					return false;

				}

			});

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

		$('#searchPage,#hotelPage').hide();

		$('#districtPage').show();

		$('.paixu.clearfix').hide();
		$('.tab-content').show();

		/*$('.nav.nav-tabs>li>a:eq(0)').click();*/

	})

	

	$('.list_one li a').click(function(){

		$(this).addClass('active').parent('li').siblings('li').children('a').removeClass('active');

		var heef = $(this).attr("href");

		$(heef).show().siblings('div').hide();

	})

	

	$('.del').click(function(){
		$('.districtlist_search').hide().empty();
		$('.tab-content').show();
		$("#districtSearch2").val('');
    	cleanSearch();

    });

	$("#SelOK").click(function(){
		/*
		var keyWord = $("#districtSearch2").val();
		if(keyWord==""){

		}else{
			$('#district span').text(keyWord);

			$("#keyword").val(keyWord);

	    }
	    */
	    $("#districtSearch2").val('');

		$('#districtPage').hide();

		$('#searchPage,#hotelPage').show();

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

    	//cleanSearch();

    });
	/*
	 *原生Ajax没有乱弹问题
	 */
	function getAjax(){
		var XHR=null;  
		if (window.XMLHttpRequest) {  
			// 非IE内核  
			XHR = new XMLHttpRequest();  
		} else if (window.ActiveXObject) {  
			// IE内核,这里早期IE的版本写法不同,具体可以查询下  
			XHR = new ActiveXObject("Microsoft.XMLHTTP");  
		} else {  
			XHR = null;  
		}
		return XHR
	}

	 $('#districtSearch').bind('input propertychange', function (){
		
    	var key = $(this).val().trim();

    	var cityName = $('input[name=cityName]').val();

    	$("#districtSearch2").val($("#districtSearch").val());

    	$('#wd').val($("#districtSearch").val());

		$('input[name=wtype]').val("9");

    	if(key != ''){
    		$('.tab-content').hide();
    		$('.del').show();
/*
    		$.ajax({
    			url: "http://restapi.amap.com/v3/place/text?key=b9027e66cc7674b52d5f022b62613a21&output=json&types=130501&city="+cityName+"&keywords="+key,
    		    type: "get",
    			dataType: "json",
    		    success: function(data){
    		    	$('.districtlist_search').empty();
    		    	if(data.count <= 0){
    			    	$('.districtlist_search').append('<p>无查询结果</p>');
    		    		return false;
    		    	}
    		    	var array = data.pois;
    		    	
    			    for(var i=0;i<array.length;i++){  //循环添加城市信息
        			    $('.districtlist_search').append('<p location="'+array[i].location+'">'+array[i].name+'</p>');
    			    }
    			    $('.districtlist_search p').click(function(){
    			    	$('#district span').text($(this).text());
    			    	$('#wd').val($(this).text());
    					var location = $(this).attr('location');
    					location = location.split(',');
    					$('input[name=lng]').val(location[0]);
    					$('input[name=lat]').val(location[1]);    					
    					$('input[name=wtype]').val("10");
    			    	$("#districtSearch2").val('');
    			    	//selectPio($(this));
    			    	districtShow();
    			    	$('.districtlist_search').hide();

    					$('#districtPage').hide();

    					$('#searchPage,#hotelPage').show();
    			    });
    		    }
    		});
*/
			/****************************/
			var XHR = getAjax();
			if(XHR){  
				XHR.open("GET", "http://restapi.amap.com/v3/place/text?key=ffa33e4d7d5afdf77cec1d632f649bfd&output=json&types=130501&city="+cityName+"&keywords="+key);  
			  
				XHR.onreadystatechange = function () {  
					// readyState值说明  
					// 0,初始化,XHR对象已经创建,还未执行open  
					// 1,载入,已经调用open方法,但是还没发送请求  
					// 2,载入完成,请求已经发送完成  
					// 3,交互,可以接收到部分数据  
			  
					// status值说明  
					// 200:成功  
					// 404:没有发现文件、查询或URl  
					// 500:服务器产生内部错误  
					if (XHR.readyState == 4 && XHR.status == 200) {  
					$('.districtlist_search').show();
						// 这里可以对返回的内容做处理  
						// 一般会返回JSON或XML数据格式  
					var res = XHR.responseText;
					var data = JSON.parse(res);
					//console.log(data);
					$('.districtlist_search').empty();
    		    	if(data.count <= 0){
    			    	$('.districtlist_search').append('<p>无查询结果</p>');
    		    		return false;
    		    	}
    		    	var array = data.pois;
    		    	
    			    for(var i=0;i<array.length;i++){  //循环添加城市信息
        			    $('.districtlist_search').append('<p location="'+array[i].location+'">'+array[i].name+'</p>');
    			    }
    			    $('.districtlist_search p').click(function(){
    			    	$('#district span').text($(this).text());
    			    	$('#wd').val($(this).text());
    					var location = $(this).attr('location');
    					location = location.split(',');
    					$('input[name=lng]').val(location[0]);
    					$('input[name=lat]').val(location[1]);    					
    					$('input[name=wtype]').val("10");
    			    	$("#districtSearch2").val('');
    			    	//selectPio($(this));
    			    	districtShow();
    			    	$('.districtlist_search').hide();

    					$('#districtPage').hide();

    					$('#searchPage,#hotelPage').show();
    			    });
						// 主动释放,JS本身也会回收的  
						XHR = null;  
					}  
				};  
				XHR.send();  
			}  
			/****************************/
    	}else{
    		$('.districtlist_search').hide();
    		$('.tab-content').show();
    		cleanSearch();
    	}

    });

})