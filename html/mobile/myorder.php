<?php
require 'common.inc.php';
include load('order.lang');
$_userid or dheader('login.php?forward='.urlencode('my.php?action='.$action));
$orderstatus = $L['trade_dstatus'];
//echo  $_username;exit;
if($action) {
	$_userid or dheader('login.php?forward='.urlencode('my.php?action='.$action));
}
if($action == 'getinvoice') {
	$invoice=$db->get_one("SELECT fapiao,fapiao_email,fapiao_number,fapiao_item,fapiao_type,fapiao_address FROM `destoon_mall_order` WHERE buyer='$_username' and itemid={$itemid}");
	if (empty($invoice)){
		echo json_encode(array('stat' => $itemid, 'msg' => "获取订单发票失败"));
	}else{
		echo json_encode(array('stat' => 1, 'msg' => $invoice));
	}
	
	exit();
}
if($action == 'updateinvoice') {
	$db->query("Update destoon_mall_order Set fapiao='{$invoice}',fapiao_email='{$invoice_email}',fapiao_number='{$invoice_number}',fapiao_item='{$invoice_item}',fapiao_type='{$invoice_type}',fapiao_address='{$invoice_address}' WHERE buyer='$_username' and itemid={$itemid}");
	
	echo json_encode(array('stat' => 1, 'msg' => '发票更新成功'));
	exit();
}
if ($_username) {
	//先处理过期的订单
	//$db->query("Update destoon_mall_order Set status=11 Where a.buyer='$_username' and status=1 and TIMESTAMPDIFF(MINUTE,FROM_UNIXTIME(updatetime,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s'))>10");
	//echo $_username;exit;
	$orders=$db->query("SELECT * FROM destoon_mall_order Where username='$_username' order by itemid desc");
	while ($r=$db->fetch_array($orders)) {
		$order[]=$r;
	}
}


include template('order', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>