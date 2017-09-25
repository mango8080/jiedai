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
	
	$('.in_date').text(moment($('#dtp_input2').val()).format('MM月DD日'));
	$('.out_date').text(moment($('#dtp_input3').val()).format('MM月DD日'));
    
    $('#checkInDate').datetimepicker({
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
        initialDate: $('#dtp_input2').val(),
        startDate:new Date(),
        endDate:addDate(today,359)
    }).on('changeDate', function(ev){
    	$('#checkInDate').datetimepicker('hide');
    	var starttime=$('#dtp_input2').val();
    	if(starttime >= $('#dtp_input3').val()){
    		$('#dtp_input3').val(addDate(starttime,1))
    	}
    	//将选择的信息存储在本地localStorage
  		localStorage.setItem('checkInDate',$("#dtp_input2").val());
        localStorage.setItem('checkOutDate',$("#dtp_input3").val());
    	$('#checkOutDate').datetimepicker('setStartDate',addDate(starttime,1))
	    var checkInDateUrl = changeURLArg(window.location.href,'beginDate',starttime);//替换起始时间
	    var newUrl =changeURLArg(checkInDateUrl,'endDate',$("#dtp_input3").val());//替换介绍时间
		window.location.href= newUrl;
    })
    $('#checkOutDate').datetimepicker({
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
       initialDate: $("#dtp_input3").val(),
       startDate:addDate($("#dtp_input2").val(),1),
       endDate:addDate(today,360)
   	}).on('changeDate', function(ev){
   		//将选择的信息存储在本地localStorage
  		localStorage.setItem('checkInDate',$("#dtp_input2").val());
        localStorage.setItem('checkOutDate',$("#dtp_input3").val());
   		var checkInDateUrl = changeURLArg(window.location.href,'beginDate',$("#dtp_input2").val());//替换起始时间
	    var newUrl =changeURLArg(checkInDateUrl,'endDate',$("#dtp_input3").val());//替换介绍时间
   		window.location.href=newUrl;
   	})
})
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