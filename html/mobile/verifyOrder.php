<?php
require 'common.inc.php';

$roomId=$_REQUEST['itemid'];
$roomNum=$_REQUEST['roomNum'];
$beginDate=$_REQUEST['beginDate'];
$endDate=$_REQUEST['endDate'];
$hongbao=(int)$_REQUEST['hongbao']; 
$second1 = strtotime($beginDate);
$second2 = strtotime($endDate);



if ($second1 < $second2) {
    $days=($second2 - $second1) / 86400;
}else{
	$days=1;
}

$item = $db->get_one("SELECT a.*,b.apigroup FROM destoon_mall as a Left Join destoon_company as b On a.username=b.username WHERE a.itemid={$roomId}");
if (empty($item)){
	echo json_encode(array('stat'=>0, 'msg'=>"房型未发现"));
	exit();
}
$info=$date_array=array();
$totalprice=$price=0;
$RoomStatus='N';
if (empty($item['apigroup'])){//加盟
	$RoomStatus='A';
	$arrPrice=unserialize($item['moreprice']);
	
	for($day=0; $day<$days; $day++){
		$nowdate=date("Y-m-d",strtotime("+{$day} days",$second1));
		$date_array[$day]['left']=$nowdate;
		if (empty($arrPrice)){
			$price=$item['price'];
		}else{
			$price=$arrPrice[$nowdate];
			if (empty($price)) $price=$item['price'];
		}
		$date_array[$day]['Price']=$price;
		$date_array[$day]['Sum']=$price*$roomNum;
		$totalprice+=$price*$roomNum;
	}
}else{
	//取价格
	$hotelid=$item['hotelid'];

	/*$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$beginDate,$days,$item['roomtype'],$roomNum,1);*/
	switch ($item['apigroup']) {
		case 'jinjiang':
			$fangxingstatus=getonlineratemap($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$beginDate,$days,$item['roomtype'],$roomNum,1);
			break;
		case 'hanting':
			$objEtt = new Ett();
			$fangxingstatus=$objEtt->getonlineratemap($hotelid,$beginDate,$endDate,$item['roomtype']);
			break;
		default:
			break;
	}
	if (empty($fangxingstatus)){
		echo json_encode(array('stat'=>0, 'msg'=>"房型未发现"));
		exit();
	}
	$RoomStatus=$fangxingstatus['RoomStatus'];
	$day=0;
	$arrPrice=$fangxingstatus['RoomPrice'];
	foreach($arrPrice as $key=>$val){
		$date_array[$day]['left']=$val['date'];
		$price=$val['price'];
		$date_array[$day]['Price']=$price;
		$date_array[$day]['Sum']=$price*$roomNum;
		$totalprice+=$price*$roomNum;
		$day++;
	}
}

$info['tips']="";
$info['orderInfo']['RoomStatus']=$RoomStatus;
$info['orderInfo']['Price']=$item['price'];
$info['orderInfo']['hbPrice']=$hongbao;
$info['orderInfo']['totalPrice']=$totalprice;
$info['orderInfo']['amount']=$item['amount'];
$info['orderInfo']['priceDetail']=$date_array;
echo json_encode(array('stat'=>1, 'result'=>$info));
?>