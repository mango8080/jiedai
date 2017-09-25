<?php
require 'common.inc.php';
include load('order.lang');
$orderstatus = $L['trade_dstatus'];
$_userid or dheader('login.php?forward='.urlencode('my.php?action='.$action));
if ($itemid) {
	$order=$db->get_one("SELECT * FROM destoon_mall_order where itemid=$itemid");
}
if ($action=="cancel" || $action=="cancel_11"){
	if (empty($itemid)) {
		echo json_encode(array('stat'=>0,"msg"=>"参数错误"));
		exit();	
	}
	
	$apigroup=$order['apigroup'];
	if (!empty($apigroup)){
		switch ($apigroup) {
			case 'jinjiang':
				$res=jjcancelorder($jjorderurl,$jjuser,$jjpass,$order['hotelid2'],$order['outconfnum']);
				if (!$res){
					echo json_encode(array('stat'=>0,"msg"=>"取消订单失败"));
					exit();	
				}
				break;
			case 'hanting':
				$ett = new Ett();
				$res=$ett->cancelorder($order['hotelid2'],$order['outconfnum']);
				if ($res!='ok'){
					echo json_encode(array('stat'=>0,"msg"=>"取消订单失败"));
					exit();	
				}
				break;	
			default:
					
				break;
		}
	}
	if ($action=="cancel_11"){
		$status=11;
	}else{
		if ($order['status']==2){
			$status=5;
		}else{
			$status=8;
		}
	}
	//解锁券
	$db->query("UPDATE {$DT_PRE}sell_dianzijuan SET state=0,orderid=0 WHERE state=3 and orderid={$itemid}");
	$sql="Update destoon_mall_order Set status={$status} Where itemid='$itemid'";
	if ($db->query($sql)){
		echo json_encode(array('stat'=>1));
	}else{
		echo json_encode(array('stat'=>0,"msg"=>"操作失败，请重试"));
	}
	exit();
}
if ($itemid) {
	$quan=$db->query("SELECT a.*,b.title,b.price,b.unit,a.number*b.price as amount FROM `destoon_voucher_order` as a left join `destoon_sell_23`as b on a.voucherid=b.itemid where a.orderid= ".$itemid);
	while ($r = $db->fetch_array($quan)) {
		$quanlist[] =$r;
	}
}

include template('orderdetail', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>