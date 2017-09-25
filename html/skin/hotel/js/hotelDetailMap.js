var hotelMap = {
    initMapDiv: function (context, mapDivId) {
        hotelMap.mapObj = new AMap.Map(mapDivId, {
            rotateEnable: true,
            dragEnable: true,
            zoomEnable: true,
            view: new AMap.View2D({
                center: new AMap.LngLat(121.462918, 31.220731),
                zoom: 13
            })
        });

        hotelMap.setLang(context.lang);

    }
    , currentLines: []
    , allMarkers: []
    , setLang: function (lang) {
        if (lang === 'cn' || lang === 'CN'
            || lang === 'zh' || lang === 'ZH'
            || lang === 'zh-cn' || lang === 'ZH-CN' || lang === 'zh-CN'
            || lang === 'zh_cn' || lang === 'ZH_CN' || lang === 'zh_CN') {
            hotelMap.mapObj.setLang("zh_cn");
        }
        else {
            hotelMap.mapObj.setLang("en");
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
            hotelMap.mapObj.setZoomAndCenter(14, new AMap.LngLat(context.centerPoint.Longitude, context.centerPoint.Latitude));
        }

        var singleHotelData = hotelInfo;

        if (singleHotelData != null && singleHotelData.Longitude != '' && singleHotelData.Longitude > 0
                && singleHotelData.Latitude != '' && singleHotelData.Latitude > 0) {

            var hotelPoint = new AMap.LngLat(singleHotelData.Longitude, singleHotelData.Latitude);
            singleHotelData.HotelIndex = '';
            var markerContent = hotelMap.createMarkerContent(singleHotelData);
            var marker = new AMap.Marker({
                //icon: markerIconPath,
                content: markerContent.html(),
                position: hotelPoint
            });

            marker.setMap(hotelMap.mapObj);
            if (isRememberMarker == true) {
                hotelMap.allMarkers.push(marker);
            }

        }
        hotelMap.mapObj.setFitView();
        return "1";
    }
    , showSingleHotelOnMap: function (hotelInfo, context, mapDivId, isRememberMarker) {
        hotelMap.initMapDiv(context, mapDivId);
        return hotelMap.showSingleMarkerOnMap(hotelInfo, context,isRememberMarker);
    }
    , ShowSingleHotelOnMiniMap: function (index, lng, lat, pageLang, mapDivId) {
        var curIndex = $('#' + mapDivId).data('hotel-id');
        if (curIndex == null || curIndex == undefined || curIndex == '' || curIndex != index) {
            var flag = hotelMap.showSingleHotelOnMap(
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
                    ,false
                );
            if (flag == 1) $('#' + mapDivId).data("hotel-id", index);
        }
    }
    , showSingleHotelOnBigMap: function (index, lng, lat, pageLang, mapDivId) {

        hotelMap.clearStartEndPoints();
        hotelMap.clearCurrentLines();
        hotelMap.clearCurrentMarkers();

        var curIndex = $('#' + mapDivId).data('map-initialized');
        if (curIndex == null || curIndex == undefined || curIndex == '' || curIndex != '1') {
            var flag = hotelMap.showSingleHotelOnMap(
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
                    ,true
                );
            if (flag == 1) $('#' + mapDivId).data('map-initialized', '1');
        }
        else {
            hotelMap.showSingleMarkerOnMap(
            {
                HotelIndex: index.toString()
                    , Longitude: lng.toString()
                        , Latitude: lat.toString()
                    }
                    , {
                        lang: pageLang
                        , centerPoint: { Longitude: lng, Latitude: lat }
                    }
                    ,true
                    );
        }
    }
    , _startMarker: null
    , _endMarker: null
    , clearStartEndPoints: function () {
        if (hotelMap._startMarker != null) {
            hotelMap._startMarker.setMap(null);
            hotelMap._startMarker = null;
        }
        if (hotelMap._endMarker != null) {
            hotelMap._endMarker.setMap(null);
            hotelMap._endMarker = null;
        }
    }
     , clearCurrentLines: function () {
         if (hotelMap.currentLines != null && hotelMap.currentLines.length > 0) {
             $(hotelMap.currentLines).each(function () {
                 if (this.hide != undefined) {
                     this.hide();
                     this.setMap(null);
                 }
             });
             hotelMap.currentLines = [];
         }
     }
    , clearCurrentMarkers: function () {
        if (hotelMap.allMarkers != null && hotelMap.allMarkers.length > 0) {
            $(hotelMap.allMarkers).each(function () {
                this.setMap(null);
            });
            hotelMap.allMarkers = [];
        }
    }
    //绘制步行导航路线
    , walkingDrawLine: function (steps, start_xy, end_xy) {

        hotelMap.clearStartEndPoints();
        hotelMap.clearCurrentLines();
        hotelMap.clearCurrentMarkers();

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
            map: hotelMap.mapObj,
            offset: {
                x: -16,
                y: -40
            }
        });
        hotelMap._startMarker = startmarker;
        var eicon = new AMap.Icon({
            image: "/themes/hotels/sprite/poi.png",
            size: new AMap.Size(44, 44),
            imageOffset: new AMap.Pixel(-334, -134)
        });
        var endmarker = new AMap.Marker({
            icon: eicon, //复杂图标
            visible: true,
            position: end_xy,
            map: hotelMap.mapObj,
            offset: {
                x: -16,
                y: -40
            }
        });
        hotelMap._endMarker = endmarker;
        //起点到路线的起点 路线的终点到终点 绘制无道路部分
        var extra_path1 = new Array();
        extra_path1.push(start_xy);
        extra_path1.push(steps[0].path[0]);
        var extra_line1 = new AMap.Polyline({
            map: hotelMap.mapObj,
            path: extra_path1,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeStyle: "dashed",
            strokeDasharray: [10, 5]
        });

        hotelMap.currentLines.push(extra_line1);

        var extra_path2 = new Array();
        var path_xy = steps[(steps.length - 1)].path;
        extra_path2.push(end_xy);
        extra_path2.push(path_xy[(path_xy.length - 1)]);
        var extra_line2 = new AMap.Polyline({
            map: hotelMap.mapObj,
            path: extra_path2,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeStyle: "dashed",
            strokeDasharray: [10, 5]
        });

        hotelMap.currentLines.push(extra_path2);

        var drawpath = new Array();
        for (var s = 0; s < steps.length; s++) {
            var plength = steps[s].path.length;
            for (var p = 0; p < plength; p++) {
                drawpath.push(steps[s].path[p]);
            }
        }
        var polyline = new AMap.Polyline({
            map: hotelMap.mapObj,
            path: drawpath,
            strokeColor: "#9400D3",
            strokeOpacity: 0.7,
            strokeWeight: 4,
            strokeDasharray: [10, 5]
        });

        hotelMap.currentLines.push(polyline);

        hotelMap.mapObj.setFitView();
    }
    , showWalkRouteOnBigMap: function (fromLng, fromLat, toLng, toLat) {
        var MWalk;
        AMap.service(["AMap.Walking"], function () {
            MWalk = new AMap.Walking(); //构造路线导航类 
            //根据起终点坐标规划步行路线
            var start_xy = new AMap.LngLat(fromLng, fromLat);
            var end_xy = new AMap.LngLat(toLng, toLat);
            MWalk.search(start_xy, end_xy, function (status, result) {
                if (status === 'complete') {

                    var routeS = result.routes;
                    if (routeS != undefined && routeS != null && routeS.length > 0) {

                        hotelMap.walkingDrawLine(routeS[0].steps, start_xy, end_xy);
                    }
                }
            });
        });
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
        var MWalk;
        AMap.service(["AMap.Walking"], function () {
            MWalk = new AMap.Walking(); //构造路线导航类 
            //根据起终点坐标规划步行路线
            var start_xy = new AMap.LngLat(fromLng, fromLat);
            var end_xy = new AMap.LngLat(toLng, toLat);
            MWalk.search(start_xy, end_xy, function (status, result) {
                if (status === 'complete') {
                    var routeS = result.routes;
                    if (routeS != undefined && routeS != null && routeS.length > 0) {
                        var secTime = hotelMap.secondsToTime(routeS[0].time);
                        if (showWalkTimeHandler != undefined && showWalkTimeHandler != null) {
                            showWalkTimeHandler(secTime);
                        }
                    }
                    else {
                        showWalkTimeHandler('');//, '');
                    }
                }
                else {
                    showWalkTimeHandler('');//, '');
                }
            });
        });
    }
}