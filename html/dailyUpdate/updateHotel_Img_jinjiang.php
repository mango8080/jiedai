<?php
/*
	取得锦江之星所有酒店列表
*/ 
require '../common.inc.php';
echo "更新开始-".date("Y-m-d H:i:s");
$arr_flag=array('s','m','b');
$count=0;
$startDate=date("Y-m-d H:i:s");
set_time_limit(0);
$perpage=200;
if (empty($page)) $page=1;
$offset=($page-1)*$perpage;

$hotels=$db->query("select hotelid from destoon_company where hotelstatus='active' and apigroup='jinjiang' Limit {$offset},{$perpage}");

while ($company=$db->fetch_array($hotels)) {	
	$hotelid=$company['hotelid'];
$data= <<< XML
<crsmessage PropID="$hotelid" user="$jjuser" pass="$jjpass" msgtype="getimage"> 
</crsmessage>
XML;
	$response = curlxml($jjurl,$data);
	$xml  =  simplexml_load_string ( $response );
	$r=object2array($xml);
	if ($r["@attributes"]["result"]=='success') {
		$hotel_thumb_arr = array();
		$hotel_thumb=GrabImage(arrtostr($r["picture"]),'','file/upload/jj/');
		$SQL="Update destoon_company Set thumb='{$hotel_thumb}'";
		foreach ($r["coverimages"]['coverimage'] as $key => $value) {
	        $hotel_thumb_arr[] =GrabImage(arrtostr($value),'','file/upload/jj/');
	        $SQL.=",thumb_".$arr_flag[$key]."='".$hotel_thumb_arr[$key]."'";
	  	}
	  	$SQL.=" Where hotelid='{$hotelid}' and apigroup='jinjiang'";
	  	$db->query($SQL);
	  	$thumb=array();
	  	foreach ($r["gallerys"] as $key => $value) {
	  		$a=$value['@attributes']["width"];
		    foreach ($value["gallery"] as $k => $v) {
		    	if ($v['roomtype']!='') {
		    		$thumb[$v['roomtype']][$a] =GrabImage(arrtostr($v['imageUrl']),'','file/upload/jj/');
		    	}
		    }
		}
		foreach ($thumb as $key => $value) {
	      	$SQL="Update destoon_mall Set hotelid='{$hotelid}'";
	      	foreach ($value as $k => $v) {
	        	$sfilter="thumb";
	        	if ($k=="400") $sfilter="thumb1";
	        	if ($k=="640") $sfilter="thumb2";
	        	$SQL.=",{$sfilter}='{$v}'";
	      	}
	      	$SQL.=" Where hotelid='{$hotelid}' and roomtype='".$key."'";
	      	$db->query($SQL);
	    }
	}
	$count++;
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('jinjiang','img','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
echo "更新酒店图片信息完成-".date("Y-m-d H:i:s");

?>