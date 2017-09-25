//时间对比
function duibi(a, b) {
    var arr = a.split("-");
    var starttime = new Date(arr[0], arr[1], arr[2]);
    var starttimes = starttime.getTime();
    var arrs = b.split("-");
    var lktime = new Date(arrs[0], arrs[1], arrs[2]);
    var lktimes = lktime.getTime();
    if (starttimes >= lktimes) {
        return false;
    }
    else{
        return true;
    }
}

//通过时间获取星期
function getWeek(day){
	var week; 
	if(day.getDay()==0)  week="周日" 
	if(day.getDay()==1)  week="周一" 
	if(day.getDay()==2)  week="周二" 
	if(day.getDay()==3)  week="周三" 
	if(day.getDay()==4)  week="周四" 
	if(day.getDay()==5)  week="周五" 
	if(day.getDay()==6)  week="周六" 
	return week;
	
}

//传入时间格式化
function getNowFormatDate(day){ 
	var Year = 0; 
	var Month = 0; 
	var Day = 0; 
	var CurrentDate = ""; 
	Year= day.getFullYear();
	Month= day.getMonth()+1; 
	Day = day.getDate(); 
	CurrentDate += Year + "-"; 
	if (Month >= 10 ){ 
		CurrentDate += Month + "-"; 
	}else { 
		CurrentDate += "0" + Month + "-"; 
	} 
	if (Day >= 10 ){ 
		CurrentDate += Day ; 
	}else{ 
		CurrentDate += "0" + Day ; 
	} 
	return CurrentDate; 
} 

//获取相隔n天的时间 
function GetDateStr(AddDayCount) {
    var dd = new Date();
    dd.setDate(dd.getDate()+AddDayCount);
    var y = dd.getFullYear();
    var m = dd.getMonth()+1;
    var d = dd.getDate();
    if(m>=10){
    	m=m;
    }else{
    	m='0'+m;
    }
    if(d>=10){
    	d=d;
    }else{
    	d='0'+d;
    }
    return y+"-"+m+"-"+d;
}

//获取某一天相隔n天的时间 
function GetDateStrs(date,AddDayCount) {
    var dd = new Date(date);
    dd.setDate(dd.getDate()+AddDayCount);
    var y = dd.getFullYear();
    var m = dd.getMonth()+1;
    var d = dd.getDate();
    if(m>=10){
    	m=m;
    }else{
    	m='0'+m;
    }
    if(d>=10){
    	d=d;
    }else{
    	d='0'+d;
    }
    return y+"-"+m+"-"+d;
}