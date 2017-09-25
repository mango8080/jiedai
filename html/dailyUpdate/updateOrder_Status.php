<?php
/*
	获取订单状态
*/ 
require '../common.inc.php';
set_time_limit(0);
$startDate=date("Y-m-d H:i:s");
$count=0;
$ett = new Ett();
$orders=$db->query("select a.itemid,a.outconfnum,a.status,b.apigroup from destoon_mall_order as a Inner Join destoon_company as b On a.seller=b.username where a.status in (2,4,7) and b.apigroup<>'' and a.outconfnum<>''");
while ($order=$db->fetch_array($orders)) {
	$apigroup=$order['apigroup'];
	$itemid=$order['itemid'];
	$confnum=$order['outconfnum'];
	$oldstatus=$order['status'];
	$status=999;
	switch ($apigroup) {
		case 'jinjiang':
			$res=jjorderstatus($jjorderurl,$jjuser,$jjpass,$jjiata,$confnum);
			if ($res!='failed'){
				if (intval($res)==5) $status=8;//预定未到
				if (intval($res)==7) $status=4;//已入住
				if (intval($res)==8) $status=10;//已离店
				if (intval($res)==9) $status=9;//酒店取消
			}
			break;
		case 'hanting':
			$res=$ett->orderstatus($confnum);
			if ($res!='failed'){
				if ($res=="N") $status=8;//预定未到
				if ($res=="I") $status=4;//已入住
				if ($res=="O") $status=10;//已离店
				if ($res=="X") $status=9;//酒店取消
			}
			break;	
		default:
			
			break;
	}
	if ($status!=999){
		$db->query("Update destoon_mall_order Set status={$status} Where itemid='{$itemid}'");
	}
	$count++;
}
$endDate=date("Y-m-d H:i:s");
$strSQL="Insert Into destoon_trans_log(apigroup,trans_type,trans_num,startdate,enddate) Values('','order','{$count}','{$startDate}','{$endDate}')";
$db->query($strSQL);
//echo "更新订单信息完成-".date("Y-m-d H:i:s");
?>