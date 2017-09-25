<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
require DT_ROOT.'/include/post.func.php';
switch (get_cookie('step')) {
	case '1':
		message('','reghotel2.php');
		break;
	case '2':
		message('','reghotel3.php');
		break;
	case '3':
		message('','reghotel4.php');
		break;
	
}
include load('order.lang');
$_status = $L['trade_status'];
$dstatus = $L['trade_dstatus'];
$_send_status = $L['send_status'];
$dsend_status = $L['send_dstatus'];
$step = isset($step) ? trim($step) : '';
$timenow = timetodate($DT_TIME, 3);
$memberurl = $MOD['linkurl'];
$myurl = userurl($_username);
$table = $DT_PRE.'mall_order';
$STARS = $L['star_type'];
if($action == 'shenhe') {
	$itemid or message();
	$td = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$td or message($L['trade_msg_null']);
	if($td['buyer'] != $_username && $td['seller'] != $_username) message($L['trade_msg_deny']);
	$newouttime=$itemid.'touttime';
	
	$touttime = datetotime($post[$newouttime]);

	if ($zhudian==4) {
		$db->query("UPDATE {$table} SET status=4,zhudian=4,roomnum='$roomnum' WHERE itemid=$itemid");
	}elseif ($zhudian==10) {
		//  如果离店，需要将房间数量加上空出的房间数量
		$number=$td['number'];
		$db->query("UPDATE {$table} SET status=10,is_shenhe=1,zhudian=10,roomnum='$roomnum',touttime='$touttime' WHERE itemid=$itemid");
		// $db->query("UPDATE destoon_mall set amount=amount+$number WHERE itemid=".$td['mallid']);
	}
	
	
	dmsg('审核成功', $forward);
} else {
	// 显示已经确认的订单
	$sfields = $L['trade_sfields'];
	$dfields = array('title', 'title ', 'amount', 'fee', 'fee_name', 'buyer', 'buyer_name', 'buyer_address', 'buyer_postcode', 'buyer_mobile', 'buyer_phone', 'send_type', 'send_no', 'note','is_shenhe','zhudian');
	$mallid = isset($mallid) ? intval($mallid) : 0;
	$cod = isset($cod) ? intval($cod) : 0;
	$nav = isset($nav) ? intval($nav) : -1;
	// (isset($buyer) && check_name($buyer)) or $buyer = '';
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	$status = isset($status) && isset($dstatus[$status]) ? intval($status) : '';
	$fields_select = dselect($sfields, 'fields', '', $fields);
	$status_select = dselect($dstatus, 'status', $L['status'], $status, '', 1, '', 1);
	$condition = "seller='$_username' AND access=1";
	if($is_shenhe) $condition="seller='$_username' AND access=1 AND is_shenhe=$is_shenhe";
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
	
	
	if($buyer) $condition .= " AND buyer_name='$buyer'";

	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
	$pages = pages($r['num'], $page, $pagesize);
	$orders = $r['num'];
	$lists = array();
	$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	
	while($r = $db->fetch_array($result)) {
		
		$r['dstatus'] = $_status[$r['status']];
		
		$lists[] = $r;
	}
	
	$head_title = $L['trade_title'];
}
include template('hotel_shenhe', $module);
?>