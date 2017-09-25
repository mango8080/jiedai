<?php 
require 'config.inc.php';
require '../common.inc.php';
if ($itemid) {
	$order=$db->get_one("SELECT * FROM `{$DT_PRE}mall_order` WHERE `itemid` = ".$itemid);
	if (jjcancelorder($jjorderurl,$jjuser,$jjpass,$order['hotelid'] ,$order['confnum'])) {
		$db->query("DELETE FROM {$DT_PRE}mall_order WHERE itemid=".$order['itemid']);
		$db->query("DELETE FROM {$DT_PRE}voucher_order WHERE orderid=".$order['itemid']);
		$db->query("DELETE FROM {$DT_PRE}mall_comment WHERE orderid=".$order['itemid']);
		$db->query("DELETE FROM {$DT_PRE}mall_stat WHERE orderid=".$order['itemid']);

		$db->query("update {$DT_PRE}mall set amount=(amount+".$order['number'].") WHERE itemid=".$order['mallid']);
		return '订单已取消';
	}else{
		return '订单取消失败，稍后重试'
	}
	
}else{
	return '参数错误';
}
?>