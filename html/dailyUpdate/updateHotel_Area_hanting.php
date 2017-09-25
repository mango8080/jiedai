<?php
/*
	取得所有酒店列表
*/ 
require '../common.inc.php';
$count=0;
$startDate=date("Y-m-d H:i:s");
$perpage=3500;
if (empty($page)) $page=1;
$offset=($page-1)*$perpage;
echo "更新开始-".date("Y-m-d H:i:s");

set_time_limit(0);
$hotels=$db->query("select * from destoon_company where apigroup='hanting' and districtname='' Limit {$offset},{$perpage}");

while ($company=$db->fetch_array($hotels)) {
	$lnslat="";
	$areaid=0;
	$areaname="";
	$hotelid=$company['hotelid'];
	$url = 'http://restapi.amap.com/v3/assistant/coordinate/convert?key=b9027e66cc7674b52d5f022b62613a21&coordsys=gps&output=json&locations='.$company['longitude'].','.$company['latitude'];
	$ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
    $result = curl_exec ( $ch );
    curl_close ( $ch );
    $result = json_decode ( $result, true );
    if ($result['status']==1){
    	$lnslat=$result['locations'];
    }
	if (!empty($lnslat)){
		$url='http://restapi.amap.com/v3/geocode/regeo?key=b9027e66cc7674b52d5f022b62613a21&radius=1000&output=json&location='.$lnslat;
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        $result = json_decode ( $result, true );
        if ($result['status']==1){
        	$areaname=$result['regeocode']['addressComponent']['district'];
        	$areaid= areatoareaid_new($result['regeocode']['addressComponent']['city'],$areaname);
			if ($areaid==0){
				$areaid= areatoareaid($areaname);
			}
        }
	}
	//if ($areaid!=0){
		$db->query("Update destoon_company Set districtname='{$areaname}',areaid='{$areaid}',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='hanting'");
	//}	
	$count++;
	//echo date("Y-m-d H:i:s");
	//ob_flush();
	//flush();
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('hanting','area','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
echo "更新酒店房型位置信息完成-".date("Y-m-d H:i:s");

//exit();
?>