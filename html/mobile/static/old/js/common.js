//跳到上一个页面
 function f_return(){
     window.location.href='javascript:history.go(-1)';
 }

 //计算天数差的函数，通用  
 function  DateDiff(sDate1,  sDate2){    //sDate1和sDate2是2006-12-18格式  
     var  aDate,  oDate1,  oDate2,  iDays  
     aDate  =  sDate1.split("-")  
     oDate1  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])    //转换为12-18-2006格式  
     aDate  =  sDate2.split("-")  
     oDate2  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])  
     iDays  =  parseInt(Math.abs(oDate1  -  oDate2)  /  1000  /  60  /  60  /24)    //把相差的毫秒数转换为天数  
     return  iDays  
 }

function sendRemotePost(url,data,callBack){
    $.ajax({
        url : global + url,
        type : "post",
        cache : false,
        data : data,
        dataType : "json",
        success :callBack
    });
}

function is_weiXin(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        return true;
    } else {
        return false;
    }
}

function alertMessage(fieldName) {
    jAlert(fieldName+'不能为空');
}