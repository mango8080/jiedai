//Microsoft.Maps.loadModule('Microsoft.Maps.Directions');

var hotelBingMap = {
    directionsManager: null,
    directionsManagerForCal: null,
    beforeRouteSelectorRenderEventObj: null,
    bingMapKey: "AuWFe1k9AVOqhEGHjnQrjIPQ9sCI_FLWQI9N7BQJmluQsVseF1CST6zBCDa15Vzm",
    lang:null,
    addBeforeRouteSelectorRenderEvent: function () {
        //if (!hotelBingMap.directionsManager) { createDirectionsManager(); }
        hotelBingMap.directionsManager.resetDirections();
        if (hotelBingMap.beforeRouteSelectorRenderEventObj) {
            Microsoft.Maps.Events.removeHandler(hotelBingMap.beforeRouteSelectorRenderEventObj);
            hotelBingMap.beforeRouteSelectorRenderEventObj = null;
        }
        hotelBingMap.beforeRouteSelectorRenderEventObj = Microsoft.Maps.Events.addHandler(hotelBingMap.directionsManager, 'beforeRouteSelectorRender', function (arg) { arg.handled = false; arg.containerElement.innerHTML = '<div style=background-color:#FFCCCC>Choice ' + (arg.routeIndex + 1) + '</div>'; });

    },
    //initBigMapDiv: function () {
    //    var jqObj = $("#mini_map_box");
    //    var calculdiv = $("<div id='tempforcalculdiv' style='display:none;'></div>").appendTo(jqObj);
    //    var tempele = document.getElementById("tempforcalculdiv");
    //    hotelBingMap.mapObj1 = new Microsoft.Maps.Map(tempele, {
    //        credentials: "AuWFe1k9AVOqhEGHjnQrjIPQ9sCI_FLWQI9N7BQJmluQsVseF1CST6zBCDa15Vzm", center: new
    //                Microsoft.Maps.Location(31.220731, 121.462918), zoom: 9, enableSearchLogo: false, showDashboard: false
    //    });
    //    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', {
    //        callback: function () {
    //            // Initialize the DirectionsManager
    //            hotelBingMap.directionsManagerForCal = new Microsoft.Maps.Directions.DirectionsManager(hotelBingMap.mapObj1);
    //            //hotelBingMap.addBeforeRouteSelectorRenderEvent();
    //        }
    //    });
    //},
    initMapDiv: function (context, mapDivId) {

        var elemap = document.getElementById(mapDivId);
        hotelBingMap.mapObj = new Microsoft.Maps.Map(elemap, {
            credentials: hotelBingMap.bingMapKey, center: new
                    Microsoft.Maps.Location(context.centerPoint.Latitude, context.centerPoint.Longitude), zoom: 14, enableSearchLogo: false, showDashboard: false, width: elemap.clientWidth, height: elemap.clientHeight, enableClickableLogo: false
        });

        //var jqObj = $("#" + mapDivId);
        //var calculdiv = $("<div id='tempforcalculdiv' style='display:none;'></div>").appendTo(jqObj);
        //var tempele = document.getElementById("tempforcalculdiv");
        //hotelBingMap.mapObj1 = new Microsoft.Maps.Map(tempele, {
        //    credentials: "AuWFe1k9AVOqhEGHjnQrjIPQ9sCI_FLWQI9N7BQJmluQsVseF1CST6zBCDa15Vzm", center: new
        //            Microsoft.Maps.Location(31.220731, 121.462918), zoom: 9, enableSearchLogo: false, showDashboard: false, width: elemap.clientWidth, height: elemap.clientHeight
        //});
        //if (!hotelBingMap.directionsManagerForCal) {
        //    hotelBingMap.initBigMapDiv();
        //}
        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', {
            callback: function () {
                // Initialize the DirectionsManager
                hotelBingMap.directionsManager = new Microsoft.Maps.Directions.DirectionsManager(hotelBingMap.mapObj);
                hotelBingMap.addBeforeRouteSelectorRenderEvent();

                    

                //hotelBingMap.directionsManagerForCal = new Microsoft.Maps.Directions.DirectionsManager(hotelBingMap.mapObj1);
                //hotelBingMap.addBeforeRouteSelectorRenderEvent();
            }
        });

        hotelBingMap.setLang(context.lang);

    }
    , currentLines: []
    , allMarkers: []
    , setLang: function (lang) {
        if (lang === 'cn' || lang === 'CN'
            || lang === 'zh' || lang === 'ZH'
            || lang === 'zh-cn' || lang === 'ZH-CN' || lang === 'zh-CN'
            || lang === 'zh_cn' || lang === 'ZH_CN' || lang === 'zh_CN') {
            //hotelBingMap.mapObj.setLang("zh_cn");
            hotelBingMap.mapObj.lang = 'zh-cn';
        }
        else {
            //hotelBingMap.mapObj.setLang("en");
            hotelBingMap.mapObj.lang = 'en-us';
        }
    }
    , createMarkerContent: function (hotelInfo, lang) {
        if (lang != undefined && lang != null && lang.toString() != 'ZH') {
            hotelInfo.HotelShortName = '';
        }
        var $hotelItem = $('#map-item-template').tmpl(hotelInfo);
        return $hotelItem;
    }
    , showSingleMarkerOnMap: function (hotelInfo, context, isRememberMarker) {

        if (context != null && context.centerPoint != null && context.centerPoint != undefined
            && context.centerPoint.Longitude != null && context.centerPoint.Longitude != undefined && context.centerPoint.Longitude != ''
            && context.centerPoint.Latitude != null && context.centerPoint.Latitude != undefined && context.centerPoint.Latitude != '') {
            //hotelBingMap.mapObj.setZoomAndCenter(14, new AMap.LngLat(context.centerPoint.Longitude, context.centerPoint.Latitude));
            hotelBingMap.mapObj.setView({ zoom: 14, center: new Microsoft.Maps.Location(context.centerPoint.Latitude, context.centerPoint.Longitude) })
        }

        var singleHotelData = hotelInfo;

        if (singleHotelData != null && singleHotelData.Longitude != '' && singleHotelData.Longitude > 0
                && singleHotelData.Latitude != '' && singleHotelData.Latitude > 0) {

            //var hotelPoint = new AMap.LngLat(singleHotelData.Longitude, singleHotelData.Latitude);
            var hotelPoint = new Microsoft.Maps.Location(singleHotelData.Latitude, singleHotelData.Longitude);
            singleHotelData.HotelIndex = '';
            var markerContent = hotelBingMap.createMarkerContent(singleHotelData);
            var marker = new Microsoft.Maps.Pushpin(hotelPoint, { htmlContent: markerContent.html() });
            //marker.setHtmlContent(markerContent.html());
            hotelBingMap.mapObj.entities.push(marker);
            //marker.setMap(hotelBingMap.mapObj);
            if (isRememberMarker == true) {
                hotelBingMap.allMarkers.push(marker);
            }

        }
        //hotelBingMap.mapObj.setFitView();
        return "1";
    }
    , showSingleHotelOnMap: function (hotelInfo, context, mapDivId, isRememberMarker) {
        hotelBingMap.initMapDiv(context, mapDivId);
        return hotelBingMap.showSingleMarkerOnMap(hotelInfo, context, isRememberMarker);
    }
    , ShowSingleHotelOnMiniMap: function (index, lng, lat, pageLang, mapDivId) {
        var curIndex = $('#' + mapDivId).data('hotel-id');
        if (curIndex == null || curIndex == undefined || curIndex == '' || curIndex != index) {
            var flag = hotelBingMap.showSingleHotelOnMap(
                    {
                        HotelIndex: index.toString()
                        , Longitude: lng.toString()
                        , Latitude: lat.toString()
                    }
                    , {
                        lang: pageLang
                        , centerPoint: { Longitude: lng, Latitude: lat }
                    }
                    ,
                    mapDivId
                    , false
                );
            if (flag == 1) $('#' + mapDivId).data("hotel-id", index);
        }
    }
    , showSingleHotelOnBigMap: function (index, lng, lat, pageLang, mapDivId) {

        hotelBingMap.clearStartEndPoints();
        hotelBingMap.clearCurrentLines();
        hotelBingMap.clearCurrentMarkers();

        var curIndex = $('#' + mapDivId).data('map-initialized');
        if (curIndex == null || curIndex == undefined || curIndex == '' || curIndex != '1') {
            var flag = hotelBingMap.showSingleHotelOnMap(
                    {
                        HotelIndex: index.toString()
                        , Longitude: lng.toString()
                        , Latitude: lat.toString()
                    }
                    , {
                        lang: pageLang
                        , centerPoint: { Longitude: lng, Latitude: lat }
                    }
                    ,
                    mapDivId
                    , true
                );
            if (flag == 1) $('#' + mapDivId).data('map-initialized', '1');
        }
        else {
            hotelBingMap.showSingleMarkerOnMap(
            {
                HotelIndex: index.toString()
                    , Longitude: lng.toString()
                        , Latitude: lat.toString()
            }
                    , {
                        lang: pageLang
                        , centerPoint: { Longitude: lng, Latitude: lat }
                    }
                    , true
                    );
        }
    }
    , _startMarker: null
    , _endMarker: null
    , clearStartEndPoints: function () {
        if (hotelBingMap._startMarker != null) {
            hotelBingMap._startMarker.setMap(null);
            hotelBingMap._startMarker = null;
        }
        if (hotelBingMap._endMarker != null) {
            hotelBingMap._endMarker.setMap(null);
            hotelBingMap._endMarker = null;
        }
    }
     , clearCurrentLines: function () {
         if (hotelBingMap.currentLines != null && hotelBingMap.currentLines.length > 0) {
             $(hotelBingMap.currentLines).each(function () {
                 if (this.hide != undefined) {
                     this.hide();
                     this.setMap(null);
                 }
             });
             hotelBingMap.currentLines = [];
         }
     }
    , clearCurrentMarkers: function () {
        if (hotelBingMap.allMarkers != null && hotelBingMap.allMarkers.length > 0) {
            $(hotelBingMap.allMarkers).each(function () {
                this.setMap(null);
            });
            hotelBingMap.allMarkers = [];
        }
    }
    //绘制步行导航路线
    , walkingDrawLine: function (steps, start_xy, end_xy) {

        hotelBingMap.clearStartEndPoints();
        hotelBingMap.clearCurrentLines();
        hotelBingMap.clearCurrentMarkers();

        //起点、终点图标
        var sicon = new AMap.Icon({
            image: "/themes/hotels/sprite/poi.png",
            size: new AMap.Size(44, 44),
            imageOffset: new AMap.Pixel(-334, -180)
        });
        var startmarker = new AMap.Marker({
            icon: sicon, //复杂图标
            visible: true,
            position: start_xy,
            map: hotelBingMap.mapObj,
            offset: {
                x: -16,
                y: -40
            }
        });
        hotelBingMap._startMarker = startmarker;
        var eicon = new AMap.Icon({
            image: "/themes/hotels/sprite/poi.png",
            size: new AMap.Size(44, 44),
            imageOffset: new AMap.Pixel(-334, -134)
        });
        var endmarker = new AMap.Marker({
            icon: eicon, //复杂图标
            visible: true,
            position: end_xy,
            map: hotelBingMap.mapObj,
            offset: {
                x: -16,
                y: -40
            }
        });
        hotelBingMap._endMarker = endmarker;
        //起点到路线的起点 路线的终点到终点 绘制无道路部分
        var extra_path1 = new Array();
        extra_path1.push(start_xy);
        extra_path1.push(steps[0].path[0]);
        var extra_line1 = new AMap.Polyline({
            map: hotelBingMap.mapObj,
            path: extra_path1,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeStyle: "dashed",
            strokeDasharray: [10, 5]
        });

        hotelBingMap.currentLines.push(extra_line1);

        var extra_path2 = new Array();
        var path_xy = steps[(steps.length - 1)].path;
        extra_path2.push(end_xy);
        extra_path2.push(path_xy[(path_xy.length - 1)]);
        var extra_line2 = new AMap.Polyline({
            map: hotelBingMap.mapObj,
            path: extra_path2,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeStyle: "dashed",
            strokeDasharray: [10, 5]
        });

        hotelBingMap.currentLines.push(extra_path2);

        var drawpath = new Array();
        for (var s = 0; s < steps.length; s++) {
            var plength = steps[s].path.length;
            for (var p = 0; p < plength; p++) {
                drawpath.push(steps[s].path[p]);
            }
        }
        var polyline = new AMap.Polyline({
            map: hotelBingMap.mapObj,
            path: drawpath,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeDasharray: [10, 5]
        });

        hotelBingMap.currentLines.push(polyline);

        hotelBingMap.mapObj.setFitView();
    }
    , showWalkRouteOnBigMap: function (fromLng, fromLat, toLng, toLat) {

        hotelBingMap.directionsManager.resetDirections();
        hotelBingMap.directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.walking });
        var from = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(fromLat, fromLng) });
        hotelBingMap.directionsManager.addWaypoint(from);
        var to = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(toLat, toLng) });
        hotelBingMap.directionsManager.addWaypoint(to);
        hotelBingMap.directionsManager.calculateDirections();
        //var MWalk;
        //AMap.service(["AMap.Walking"], function () {
        //    MWalk = new AMap.Walking(); //构造路线导航类 
        //    //根据起终点坐标规划步行路线
        //    var start_xy = new AMap.LngLat(fromLng, fromLat);
        //    var end_xy = new AMap.LngLat(toLng, toLat);
        //    MWalk.search(start_xy, end_xy, function (status, result) {
        //        if (status === 'complete') {

        //            var routeS = result.routes;
        //            if (routeS != undefined && routeS != null && routeS.length > 0) {

        //                hotelBingMap.walkingDrawLine(routeS[0].steps, start_xy, end_xy);
        //            }
        //        }
        //    });
        //});
    }
    , secondsToTime: function (secs) {
        var secVal = 0;
        if (secs == undefined || secs == null) {
            secVal = 0;
        }
        else {
            secVal = parseInt(secs);
        }
        var hrs = (secVal - secVal % 3600) / 3600;
        var secVal = secVal % 3600;

        var mins = (secVal - secVal % 60) / 60;
        var secVal = secVal % 60;

        if (secVal > 0) {
            mins = mins + 1;
        }

        return { hours: hrs, minutes: mins };
    }
    //距离，米换算为千米
    , getDistance: function (len) {
        if (len <= 1000) {
            var s = len;
            return s + "米";
        } else {
            var s = Math.round(len / 1000);
            return "约" + s + "公里";
        }
    }
    , queryWalkDistance: function (fromLng, fromLat, toLng, toLat, showWalkTimeHandler) {

        var start = fromLat+','+fromLng;
        var end = toLat + ',' + toLng;

        var routeRequest = 'http://dev.virtualearth.net/REST/v1/Routes/Walking?wp.0=' + start + '&wp.1=' + end + '&key=' + hotelBingMap.bingMapKey;
        $.ajax({
            type: "get",
            async: false,
            url: routeRequest,
            dataType: "jsonp",
            jsonp: "jsonp",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
           // jsonpCallback: "RouteCallback",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名，也可以写"?"，jQuery会自动为你处理数据
            success: function (json) {
                //json.resourceSets[0].resources[0].travelDistance
                //json.resourceSets[0].resources[0].travelDuration
                if (json.resourceSets && json.resourceSets.length > 0) {
                    if(json.resourceSets[0].resources && json.resourceSets[0].resources.length > 0) {
                        var secTime = hotelBingMap.secondsToTime(json.resourceSets[0].resources[0].travelDuration);
                        if (showWalkTimeHandler != undefined && showWalkTimeHandler != null) {
                            showWalkTimeHandler(secTime);
                        }
                    }
                }
            },
            error: function (e) {
                //alert('fail');
                console.log(e);
            }
        }).always(function (data) {
            //console.log(data);
            //alert(data);
            //callback(data.responseText);
        });

        //hotelBingMap.showSingleHotelOnMap(
        //            {
        //                HotelIndex: '0'
        //                , Longitude: '0'
        //                , Latitude: '0'
        //            }
        //            , {
        //                lang: null
        //                , centerPoint: { Longitude: '0', Latitude: '0' }
        //            }
        //            ,
        //            'big-map-box'
        //            , true
        //        );

        //if (!hotelBingMap.directionsManagerForCal) {
        //    hotelBingMap.initBigMapDiv();
        //}
        //var from = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(fromLat, fromLng) });
        //var to = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(toLat, toLng) });
        //Microsoft.Maps.Events.addHandler(hotelBingMap.directionsManager, 'directionsUpdated', function (e) {
        //    if (e.routeSummary && e.routeSummary.length > 0) {
        //        var secTime = hotelBingMap.secondsToTime(e.routeSummary[0].time);
        //        if (showWalkTimeHandler != undefined && showWalkTimeHandler != null) {
        //            showWalkTimeHandler(secTime);
        //        }
        //    }
        //});
        //hotelBingMap.directionsManager.calculateDirections();
        //var MWalk;
        //AMap.service(["AMap.Walking"], function () {
        //    MWalk = new AMap.Walking(); //构造路线导航类 
        //    //根据起终点坐标规划步行路线
        //    var start_xy = new AMap.LngLat(fromLng, fromLat);
        //    var end_xy = new AMap.LngLat(toLng, toLat);
        //    MWalk.search(start_xy, end_xy, function (status, result) {
        //        if (status === 'complete') {
        //            var routeS = result.routes;
        //            if (routeS != undefined && routeS != null && routeS.length > 0) {
        //                var secTime = hotelBingMap.secondsToTime(routeS[0].time);
        //                if (showWalkTimeHandler != undefined && showWalkTimeHandler != null) {
        //                    showWalkTimeHandler(secTime);
        //                }
        //            }
        //            else {
        //                showWalkTimeHandler('');//, '');
        //            }
        //        }
        //        else {
        //            showWalkTimeHandler('');//, '');
        //        }
        //    });
        //});
    }
}