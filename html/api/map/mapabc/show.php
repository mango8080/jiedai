<?php
require '../../../common.inc.php';
include DT_ROOT.'/api/map/mapabc/config.inc.php';
$map = isset($map) ? $map : $map_mid;
// preg_match("/^[0-9\.\,]{17,21}$/", $map) or $map = $map_mid;
$company = isset($company) ? trim(strip_tags($company)) : '';
$address = isset($address) ? trim(strip_tags($address)) : '';
($company && $address) or exit;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title></title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <style type="text/css">
        .info-title {
            color: white;
            font-size: 14px;
            background-color:blue;
            line-height: 26px;
            padding: 0px 0 0 6px;
            font-weight: lighter;
            letter-spacing: 1px
        }
        .info-content {
            font: 12px Helvetica, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', Arial;
            padding: 4px;
            color: #666666;
            line-height: 23px;
        }
        .info-content img {
            float: left;
            margin: 3px;
        }
    </style>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=<?php echo $map_key; ?>&plugin=AMap.AdvancedInfoWindow"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="container"></div>

<script type="text/javascript">
	var lnglat = [<?php echo $map ?>];
    var map = new AMap.Map('container', {
        resizeEnable: true,
        center: lnglat,
		zoom: 15
    });
    var marker = new AMap.Marker({
        position: lnglat
    });
    marker.setMap(map);

    var content='<div class="info-title">高德地图</div><div class="info-content">' +
            '<img src="http://webapi.amap.com/images/amap.jpg">' +
            '高德是中国领先的数字地图内容、导航和位置服务解决方案提供商。<br/>' +
            '<a target="_blank" href = "http://mobile.amap.com/">点击下载高德地图</a></div>';
    
</script>
</body>
</html>