/**
 * Sdate v1.0.0
 * By zhuxianjie
 */
(function(window,undefined){
	var weekArray=new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
	var getDayOfWeek =function(riqi) {
		var arys1= new Array();      
	    arys1=riqi.split('-');     //日期为输入日期，格式为 2013-3-10
	    var ssdate=new Date(arys1[0],parseInt(arys1[1]-1),arys1[2]);   
	    var week = weekArray[ssdate.getDay()];
	    return week;
	}
	Sdate=function(id,cfg){
		this.oSelect=document.getElementById(id);
		this.cfg=cfg||this._default;
		
		if(document.getElementById('checkInDate')){
			var checkInDate =  document.getElementById('checkInDate').value;
			if(checkInDate!=null&&checkInDate!="")
				this.cfg.startDate = checkInDate;
		}
		
		if(this.oSelect.tagName!=='SELECT'){
			alert("参数配置错误");
		}else{
			this.setNowDate();
		}
	}
	
	Sdate.fn=Sdate.prototype={
		version:'1.0.0',            //版本
		_default: {
			startDate:new Date(), //开始日期 默认当天
			days:30,            //默认30天
			fn:function() {}
		},
		setNowDate:function(){  //设置日期
			startDate=this.cfg.startDate||this._default.startDate;
			days=this.cfg.days||this._default.days;
			var arrDate=this.processDate(startDate);
			for(var i=0;i<days;i++){
				var elem=document.createElement("option");
				elem.innerHTML=arrDate[i]+getDayOfWeek(arrDate[i]);
				elem.value=arrDate[i];
				try{
					if(arrDate[i] == document.getElementById("checkInDateHidden").value){
						elem.selected="selected";
					}
				}catch (e) 
				{
				}
				
				this.oSelect.appendChild(elem);
			}
			if(this.cfg.fn){
				this.cfg.fn();	
			}
		},	
		processDate:function(oDate){            //处理日期
			if(typeof oDate =='object'){
				oDate=oDate.getFullYear()+'-'+(oDate.getMonth()+1)+'-'+oDate.getDate();
			}
			if(oDate.indexOf('-')!=-1||oDate.indexOf('/')!=-1){
				if(oDate.split('-').length>oDate.split('/').length){
					var arr=oDate.split('-');
					var format='-';	
				}else{
					var arr=oDate.split('/');
					var format='/';	
				}
			}
			var year=arr[0];
			var month=arr[1]-1<10?'0'+(arr[1]-1):arr[1]-1;
			var day=arr[2]<10?'0'+arr[2]:arr[2];
			var result=[];
			var len=this.cfg.days||this._default.days
			for(var i=0;i<len;i++){
				var newDate=new Date(new Date(year,month,day).valueOf() + i * 24 * 60 * 60 * 1000);
				var newYear=newDate.getFullYear();
				var newMonth=newDate.getMonth()+1<10?'0'+(newDate.getMonth()+1):newDate.getMonth()+1;
				var newDay=newDate.getDate()<10?'0'+newDate.getDate():newDate.getDate();
				result[i]=newYear+format+newMonth+format+newDay;
			}
			return result;
		}
		
	}
	window.Sdate=Sdate;	
})(window)