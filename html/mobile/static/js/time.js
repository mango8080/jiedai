//日期格式化扩展
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function getDateDiff(date1,date2){
    var arr1=date1.split('-');
	var arr2=date2.split('-');
	var d1=new Date(arr1[0],arr1[1]-1,arr1[2]);//时间传入月份减一
	var d2=new Date(arr2[0],arr2[1]-1,arr2[2]);//时间传入月份减一
	return Math.floor((d1.getTime()-d2.getTime())/(1000*3600*24));
}

function addDate(date,days){ 
	var d=new Date(date); 
	d.setDate(d.getDate()+days); 
	var m=d.getMonth()+1;
	return d.getFullYear()+"-"+(m<10?"0"+m:m)+"-"+(d.getDate()<10?"0"+d.getDate():d.getDate()); 
}

$(function(){
    var today=new Date().Format("yyyy-MM-dd");

    var localcheckInDate = localStorage.getItem('checkInDate');
    var localcheckOutDate = localStorage.getItem('checkOutDate');
    if(GetQueryString('checkInDate') != null && GetQueryString('checkOutDate') != null){
    	$("#dtp_input2").val(GetQueryString('checkInDate'));
    	$("#dtp_input3").val(GetQueryString('checkOutDate'))
    	var localDay = GetQueryString('checkInDate');
    }else{
    	if(localcheckInDate == null || getDateDiff(localcheckInDate,today)<0){
        	$("#dtp_input2").val(today)
        	if(localcheckOutDate == null || getDateDiff(localcheckOutDate,addDate(today,1))<0){
            	$("#dtp_input3").val(addDate(today,1))
            }else{
            	$("#dtp_input3").val(localcheckOutDate)
            }
        	var localDay = today;
        }else{
        	$("#dtp_input2").val(localcheckInDate)
        	if(localcheckOutDate == null || getDateDiff(localcheckOutDate,addDate(today,1))<0){
            	$("#dtp_input3").val(addDate(localcheckOutDate,1))
            }else{
            	$("#dtp_input3").val(localcheckOutDate)
            }
        	var localDay = localcheckInDate;
        }
    }
    
    function checkWeek(){
        if(getDateDiff($("#dtp_input2").val(),today)==0){
        	$("#checkInweek").text("（今天）");
        }else if(getDateDiff($("#dtp_input2").val(),today)==1){
        	$("#checkInweek").text("（明天）");
        }else{
        	$('#checkInweek').text("（周"+ "一二三四五六日".charAt(new Date(addDate($("#dtp_input2").val(),-1)).getDay())+"）");
        }
        /*else if(getDateDiff($("#dtp_input2").val(),today)==2){
    		$("#checkInweek").text("（后天）")
    	}*/
        /*if(getDateDiff($("#dtp_input3").val(),today)==1){
        	$("#checkOutweek").text("（明天）");
        }else if(getDateDiff($("#dtp_input3").val(),today)==2){
        	$("#checkOutweek").text("（后天）")
        }else{
        	$('#checkOutweek').text("（周"+ "一二三四五六日".charAt(new Date(addDate($("#dtp_input3").val(),-1)).getDay())+"）");
        }*/
        $('#checkOutweek').text("（周"+ "一二三四五六日".charAt(new Date(addDate($("#dtp_input3").val(),-1)).getDay())+"）");
        $('#godays').text('（共'+getDateDiff($("#dtp_input3").val(),$("#dtp_input2").val())+'晚）')
    }
    checkWeek()
    function changeGday(){
        checkWeek()
        //将选择的信息存储在本地localStorage
  		localStorage.setItem('checkInDate',$("#dtp_input2").val());
        localStorage.setItem('checkOutDate',$("#dtp_input3").val());
    }    
    $('#checkInDate').datetimepicker({
    	format:'yyyy-mm-dd',
        language:  'zh-CN',
        showMeridian: true,
        autoclose: true,
        pickTime: true,
        weekStart: 0,
        todayBtn: true,        
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,      
        startDate:new Date(),
        endDate:addDate(today,359)
    }).on('changeDate', function(ev){
    	$('#checkInDate').datetimepicker('hide');
    	var starttime=$('#dtp_input2').val();
    	if(starttime >= $('#dtp_input3').val()){
    		$('#dtp_input3').val(addDate(starttime,1))
    	}   	
    	$('#checkOutDate').datetimepicker('setStartDate',addDate(starttime,1))
    	changeGday()
    })
    
   	$('#checkOutDate').datetimepicker({
   		format:'yyyy-mm-dd',
   		language:  'zh-CN',
   		showMeridian: true,
   		autoclose: true,
   		pickTime: true,
   		weekStart: 0,
   		todayBtn: true,        
   		todayHighlight: 1,
   		startView: 2,
   		minView: 2,
   		forceParse: 0,
   		pickerPosition: 'bottom-left',
   		startDate:addDate(localDay,1),
   		endDate:addDate(today,360)
   	}).on('changeDate', function(ev){
   		$('#checkOutDate').datetimepicker('hide');
   		changeGday()
   	})
})
//采用正则表达式获取地址栏参数
function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}