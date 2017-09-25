<?php
/*
	取得华住所有酒店列表
*/ 
require '../common.inc.php';
$apiurl="http://ett.huazhu.com:8086/AgentService.asmx?wsdl";
$sAgentID="VCENTCRM1016527815";
$sAuthCode="A16146A8-0CF3-4605-93E2-A23C83D8C7EF";
try{
	$client = new SoapClient($apiurl);
}catch(Exception $e){
	print $e->getMessage();
	exit();
}
$count=0;
$startDate=date("Y-m-d H:i:s");
$perpage=300;
if (empty($page)) $page=1;
$offset=($page-1)*$perpage;
echo "更新开始-".date("Y-m-d H:i:s");
//echo str_repeat(" ", 128);
$today=date('Y-m-d');
$tomorrow=date('Y-m-d',strtotime('+1 day'));
set_time_limit(0);
$hotels=$db->query("select * from destoon_company where apigroup='hanting'");

while ($company=$db->fetch_array($hotels)) {	
	$hotelid=$company['hotelid'];
	$hotelResult = $client->__call('QueryRoomPriceOneHotel',array(array('sAgentID'=>$sAgentID,'sAuthCode'=>$sAuthCode,'sHotelID'=>$hotelid,'dCheckIn'=>$today,'dCheckOut'=>$tomorrow)));
	$response=json_decode($hotelResult->QueryRoomPriceOneHotelResult,true);
	if ($response['ResultCode']==0){
		if ($response['ResponseCode']!=1){//没价格,暂时关闭
			$db->query("Update destoon_company Set hotelstatus='inactive',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='hanting'");
		}else{
			$havePrice=0;
			$lowPrice=100000;
			foreach ($response['ResultContent'] as $k => $v) {
				$roomType= $v['RoomType'];
				$price=$v['Price'];
				$havePrice=$havePrice || floatval($price);
				if (floatval($price)<$lowPrice) $lowPrice=floatval($price);
				
				$db->query("Update destoon_mall Set price={$price} WHERE hotelid='{$hotelid}' and roomtype='{$roomType}'");
				
			}
			if (empty($havePrice)){//所有房型都没价格,暂时关闭
				$tmpSet="hotelstatus='inactive'";
			}else{
				$tmpSet="lowprice={$lowPrice}";
			}
			$db->query("Update destoon_company Set {$tmpSet},edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='hanting'");
		}
	}else{//没房型,关闭
		$db->query("Update destoon_company Set hotelstatus='close',edit_time='".date("Y-m-d H:i:s")."' WHERE hotelid='{$hotelid}' and apigroup='hanting'");
	}
	$count++;
	//echo date("Y-m-d H:i:s");
	//ob_flush();
	//flush();
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('hanting','price','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
echo "更新酒店房型价格信息完成-".date("Y-m-d H:i:s");

//exit();
?>