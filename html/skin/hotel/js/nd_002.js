var hotelBingMap = {
    directionsManager: null,
    beforeRouteSelectorRenderEventObj: null,
    city: null,
    bingMapKey: "AuWFe1k9AVOqhEGHjnQrjIPQ9sCI_FLWQI9N7BQJmluQsVseF1CST6zBCDa15Vzm",
    lang: null,
    addBeforeRouteSelectorRenderEvent: function () {
        //if (!hotelBingMap.directionsManager) { createDirectionsManager(); }
        hotelBingMap.directionsManager.resetDirections();
        if (hotelBingMap.beforeRouteSelectorRenderEventObj) {
            Microsoft.Maps.Events.removeHandler(hotelBingMap.beforeRouteSelectorRenderEventObj);
            hotelBingMap.beforeRouteSelectorRenderEventObj = null;
        }
        hotelBingMap.beforeRouteSelectorRenderEventObj = Microsoft.Maps.Events.addHandler(hotelBingMap.directionsManager, 'beforeRouteSelectorRender', function (arg) { arg.handled = false; arg.containerElement.innerHTML = '<div style=background-color:#FFCCCC>Choice ' + (arg.routeIndex + 1) + '</div>'; });

    },

    initMapDiv: function (context, mapDivId, hotelInfos) {
        var elemap = document.getElementById(mapDivId);

        var isSetMap = false;




        if (hotelInfos && hotelInfos.length > 0) {
            for (var i = 0; i < hotelInfos.length; i++) {
                if (hotelInfos[i].Latitude != '' && hotelInfos[i].Latitude.length > 0
               && hotelInfos[i].Longitude != '' && hotelInfos[i].Longitude.length > 0) {
                    hotelBingMap.mapObj = new Microsoft.Maps.Map(elemap, {
                        credentials: hotelBingMap.bingMapKey, center: new
                                Microsoft.Maps.Location(hotelInfos[i].Latitude, hotelInfos[i].Longitude), zoom: 9, enableSearchLogo: false, showDashboard: false, width: elemap.clientWidth, height: elemap.clientHeight, enableClickableLogo: false
                    });
                    isSetMap = true;
                    break;
                }

            }
        }

        if (!isSetMap) {
            hotelBingMap.mapObj = new Microsoft.Maps.Map(elemap, {
                credentials: hotelBingMap.bingMapKey, center: new
                        Microsoft.Maps.Location(31.220731, 121.462918), zoom: 9, enableSearchLogo: false, showDashboard: false, width: elemap.clientWidth, height: elemap.clientHeight, enableClickableLogo: false
            });
        }

        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', {
            callback: function () {
                // Initialize the DirectionsManager
                hotelBingMap.directionsManager = new Microsoft.Maps.Directions.DirectionsManager(hotelBingMap.mapObj);
                hotelBingMap.addBeforeRouteSelectorRenderEvent();
            }
        });

        hotelBingMap.setLang(context.lang);

    }
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
        if (lang != undefined && lang.toString() != 'ZH') {
            hotelInfo.HotelShortName = '';
        }
        var $hotelItem = $('#map-item-template').tmpl(hotelInfo);
        return $hotelItem;
    }
    , showSingleMarkerOnMap: function (hotelInfo, context) {

        if (context != null && context.centerPoint != null && context.centerPoint != undefined
            && context.centerPoint.Longitude != null && context.centerPoint.Longitude != undefined && context.centerPoint.Longitude != ''
            && context.centerPoint.Latitude != null && context.centerPoint.Latitude != undefined && context.centerPoint.Latitude != '') {
            //hotelBingMap.mapObj.setZoomAndCenter(14, new AMap.LngLat(context.centerPoint.Longitude, context.centerPoint.Latitude));
            hotelBingMap.mapObj.setView({ zoom: 14, center: new Microsoft.Maps.Location(context.centerPoint.Latitude, context.centerPoint.Longitude) })
        }
        //Microsoft.Maps.Location(coord.latitude, coord.longitude); }
        var singleHotelData = hotelInfo;
        //console.log(singleHotelData);
        if (singleHotelData != null && singleHotelData.Longitude != '' && singleHotelData.Longitude > 0
                && singleHotelData.Latitude != '' && singleHotelData.Latitude > 0) {

            var hotelPoint = new Microsoft.Maps.Location(singleHotelData.Latitude, singleHotelData.Longitude);
            //singleHotelData.HotelIndex = '';
            var markerContent = hotelBingMap.createMarkerContent(singleHotelData);
            //markerContent.css("cursor", "progress");
            var marker = new Microsoft.Maps.Infobox(hotelPoint);
            marker.setHtmlContent(markerContent.html());
            marker.hotelId = singleHotelData.HotelId;
            marker.jjcode = singleHotelData.JjCode;
            //var marker = new AMap.Marker({
            //    //icon: markerIconPath,
            //    content: markerContent.html(),
            //    position: hotelPoint
            //});

            //marker.setMap(hotelBingMap.mapObj);
            hotelBingMap.mapObj.entities.push(marker);
            //添加跳转页面事件 HotelIndex: index.toString()
            Microsoft.Maps.Events.addHandler(marker, 'click', function (e) {
                location.href = "HotelDetail?hotelid=" + e.target.hotelId + "&checkInDate=" + $("#dateCheckIn").val() + "&checkOutDate=" + $("#dateCheckOut").val() + "&jjCode=" + e.target.jjcode + "&pomoCode=" + $("#inputPromotionCode").val();
            });
            //AMap.event.addListener(marker, 'click', function () {
            //    location.href = "HotelDetail?hotelid=" + singleHotelData.HotelId + "&checkInDate=" + $("#dateCheckIn").val() + "&checkOutDate=" + $("#dateCheckOut").val() + "&jjCode=" + singleHotelData.JjCode + "&pomoCode=" + $("#inputPromotionCode").val();
            //});
        }
        //hotelBingMap.mapObj.setFitView();
        return "1";
    }
    , showSingleHotelOnMap: function (hotelInfo, context, mapDivId) {
        hotelBingMap.initMapDiv(context, mapDivId);
        return hotelBingMap.showSingleMarkerOnMap(hotelInfo, context);
        //return hotelMap.createMarkerContent(hotelInfo,context);
    }
    , ShowSingleHotelOnMiniMap: function (index, lng, lat, pageLang, hid, jjcode, mapDivId) {
        //随滚动变化酒店地图点
        var curIndex = $('#' + mapDivId).data('hotel-id');
        if (curIndex == null || curIndex == undefined || curIndex == '' || curIndex != index) {
            var flag = hotelBingMap.showSingleHotelOnMap(
                    {
                        HotelIndex: index.toString()
                        , Longitude: lng.toString()
                        , Latitude: lat.toString()
                        , HotelId: hid.toString()
                        , JjCode: jjcode.toString()
                    }
                    , {
                        lang: pageLang
                        , centerPoint: { Longitude: lng, Latitude: lat }
                    }
                    ,
                    mapDivId
                );
            if (flag == 1) $('#' + mapDivId).data("hotel-id", index);
        }
    }, showPointOnMap: function (hotelInfos, context, selectIndex) {

        if (context.centerPoint != null && context.centerPoint != undefined
            && context.centerPoint.Longitude != null && context.centerPoint.Longitude != undefined && context.centerPoint.Longitude != ''
            && context.centerPoint.Latitude != null && context.centerPoint.Latitude != undefined && context.centerPoint.Latitude != '') {
            //hotelBingMap.mapObj.setZoomAndCenter(14, new AMap.LngLat(context.centerPoint.Longitude, context.centerPoint.Latitude));
            hotelBingMap.mapObj.setView({ zoom: 14, center: new Microsoft.Maps.Location(context.centerPoint.Latitude, context.centerPoint.Longitude) })
        }
        else {
            hotelBingMap.mapObj.setView({ zoom: 14 });
        }
        var hotelCount = hotelInfos.length;
        for (var i = 0; i < hotelCount; i++) {

            var singleHotelData = hotelInfos[i];

            if (singleHotelData.Longitude != '' && singleHotelData.Longitude.length > 0
                && singleHotelData.Latitude != '' && singleHotelData.Latitude.length > 0) {

                var hotelPoint = new Microsoft.Maps.Location(singleHotelData.Latitude, singleHotelData.Longitude);
                if (selectIndex != null && i == selectIndex) {
                    //var markerContent = hotelMap.createMarkerHighlightContent(singleHotelData);
                    //var marker = new AMap.Marker({
                    //    //icon: markerIconPath,
                    //    content: markerContent.html(),
                    //    position: hotelPoint,
                    //    zIndex:1000
                    //});

                    ////hotelMap.showInfoWindow(singleHotelData.Longitude, singleHotelData.Latitude, markerContent.html());

                    //marker.setMap(hotelMap.mapObj);

                    //AMap.event.addListener(marker, 'click', function (result) {
                    //    var hotelIndex = removeHTMLTag(result.target.$c.content);
                    //    var hoteldata = hotelInfos[(parseInt(hotelIndex) - 1)];
                    //    location.href = "HotelDetail?hotelid=" + hoteldata.hotelId + "&checkInDate=" + $("#dateCheckIn").val() + "&checkOutDate=" + $("#dateCheckOut").val() + "&jjCode=" + hoteldata.jjcode + "&pomoCode=" + $("#inputPromotionCode").val();
                    //});
                } else {
                    //var markerContent = hotelBingMap.createMarkerContent(singleHotelData);
                    //var marker = new AMap.Marker({
                    //    //icon: markerIconPath,
                    //    content: markerContent.html(),
                    //    position: hotelPoint
                    //});



                    ////hotelMap.showInfoWindow(singleHotelData.Longitude, singleHotelData.Latitude, markerContent.html());

                    //marker.setMap(hotelBingMap.mapObj);


                    //var hotelPoint = new Microsoft.Maps.Location(singleHotelData.Longitude, singleHotelData.Latitude);
                    //singleHotelData.HotelIndex = '';
                    var markerContent = hotelBingMap.createMarkerContent(singleHotelData);
                    //markerContent.css("cursor", "pointer");
                    //var marker = new Microsoft.Maps.Infobox(hotelPoint);
                    var marker = new Microsoft.Maps.Pushpin(hotelPoint, { htmlContent: "<div style='cursor:pointer'>" + markerContent.html() + "</div>" });
                    ;
                    //var marker = new AMap.Marker({
                    //    //icon: markerIconPath,
                    //    content: markerContent.html(),
                    //    position: hotelPoint
                    //});

                    //marker.setMap(hotelBingMap.mapObj);
                    hotelBingMap.mapObj.entities.push(marker);
                    //$(markerContent.html()).css("cursor", "pointer");
                    //marker.setHtmlContent("<div style='cursor:pointer'>"+markerContent.html()+"</div>")
                    Microsoft.Maps.Events.addHandler(marker, 'click', function (result) {
                        var hotelIndex = removeHTMLTag(result.target._htmlContent);
                        var hoteldata = hotelInfos[(parseInt(hotelIndex) - 1)];
                        location.href = "HotelDetail?hotelid=" + hoteldata.hotelId + "&checkInDate=" + $("#dateCheckIn").val() + "&checkOutDate=" + $("#dateCheckOut").val() + "&jjCode=" + hoteldata.jjcode + "&pomoCode=" + $("#inputPromotionCode").val();
                    });

                    //AMap.event.addListener(marker, 'click', function (result) {
                    //    var hotelIndex = removeHTMLTag(result.target.$c.content);
                    //    var hoteldata = hotelInfos[(parseInt(hotelIndex) - 1)];
                    //    location.href = "HotelDetail?hotelid=" + hoteldata.hotelId + "&checkInDate=" + $("#dateCheckIn").val() + "&checkOutDate=" + $("#dateCheckOut").val() + "&jjCode=" + hoteldata.jjcode + "&pomoCode=" + $("#inputPromotionCode").val();
                    //});
                }
            }
        }

        //hotelBingMap.mapObj.setFitView();

    }
    , ShowHotelOnMiniMap: function (hotelInfos, context, mapDivId) {
        //所有酒店一次加载
        hotelBingMap.initMapDiv(context, mapDivId, hotelInfos);
        return hotelBingMap.showPointOnMap(hotelInfos, context);
    }

    , showWalkRouteOnBigMap: function (fromLng, fromLat, toLng, toLat) {



        alert("showWalkRouteOnBigMap");
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
    , showSingleHotelOnBigMap: function ( lng, lat) {
        var $rightMap = $('.big_map_box #big-map-box');
        if ($rightMap.length > 0) {

            hotelBingMap.ShowHotelOnMiniMap(
                [{
                    HotelIndex: ''//alway show 1
                    , Longitude: lng.toString()
                    , Latitude: lat.toString()
                     , lng: lng.toString()
                    , lat: lat.toString()
                }]
                , {
                    lang: initCriteria.lang
                }
                ,
                "big-map-box"
            );
        }
    }
    , queryWalkDistance: function (fromLng, fromLat, toLng, toLat, showWalkTimeHandler) {

        var start = fromLat + ',' + fromLng;
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
                    if (json.resourceSets[0].resources && json.resourceSets[0].resources.length > 0) {
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
    }
}

