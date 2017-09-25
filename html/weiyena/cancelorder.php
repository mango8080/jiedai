<?php
/*
	Copy by aaron qq:59693566
*/
require '../common.inc.php';
$order=$db->query("SELECT * FROM `{$DT_PRE}mall_order` WHERE `isconfirm` = 1 and status=1");
while($r = $db->fetch_array($order)) {
	if (($DT_TIME-$r['addtime'])>600) {
				$db->query("DELETE FROM {$DT_PRE}mall_order WHERE itemid=".$r['itemid']);
				$db->query("DELETE FROM {$DT_PRE}voucher_order WHERE orderid=".$r['itemid']);
				$db->query("DELETE FROM {$DT_PRE}mall_comment WHERE orderid=".$r['itemid']);
				$db->query("DELETE FROM {$DT_PRE}mall_stat WHERE orderid=".$r['itemid']);

				$db->query("update {$DT_PRE}mall set amount=(amount+".$r['number'].") WHERE itemid=".$r['mallid']);
				
	}
	
}
message('未付款订单撤销完成');
