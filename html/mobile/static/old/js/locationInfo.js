var mapObj,toolBar,locationInfo,city='上海',MGeocoder,cityLngLat;

//创建地图图层
var mapDiv=document.createElement("div");
mapDiv.id="iCenter";
document.body.appendChild(mapDiv);

//初始化地图对象，加载地图  
mapObj = new AMap.Map("iCenter");

//地图中添加地图操作ToolBar插件  
mapObj.plugin(["AMap.ToolBar"],function(){        
    toolBar = new AMap.ToolBar(); //设置地位标记为自定义标记  
    mapObj.addControl(toolBar);  
    toolBar.hide()  
    AMap.event.addListener(toolBar,'location',function callback(e){ 
    	locationInfo = e.lnglat;  
        showCityInfo();
    },this);
    toolBar.doLocation();
});

//隐藏地图div
document.getElementById("iCenter").style.display="none";

//获取城市信息
function showCityInfo(){
	  //加载地理编码插件  
    mapObj.plugin(["AMap.Geocoder"], function() {          
        MGeocoder = new AMap.Geocoder({   
            radius: 1000,  
            extensions: "all"  
        });  
        //返回地理编码结果   
        AMap.event.addListener(MGeocoder, "complete", function(data){
        	if(data.regeocode){
        		if(data.regeocode.addressComponent.city==''){
	        		city=data.regeocode.addressComponent.province;
	        	}else{
	        		city=data.regeocode.addressComponent.city;
	        	}
        		getCityLngLat(city)
            	if(city.substr(city.length-1,1)=='市' ){
            		city=city.substr(0,city.length-1)
            	}
        	}else if(data.geocodes){
        		cityLngLat={
        				lng:data.geocodes[0].location.lng,
        				lat:data.geocodes[0].location.lat
        		}
        	}
        	
        },this);   
        //逆地理编码
        MGeocoder.getAddress(locationInfo);   
       
    });  
}

function getCityLngLat(city){
	 MGeocoder.getLocation(city);
}
