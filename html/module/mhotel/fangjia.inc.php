<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
require DT_ROOT.'/include/post.func.php';
include load('order.lang');

$table = $DT_PRE.'mall';
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
if($submit) {
	$itemid or message();
	$td = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$td or message('没有此房型');
	$moreprice=daddslashes($post);
	$mprice = array();
	$hiprice=$td['hiprice'];
	// 不设定时间段的调价
	// foreach ($moreprice as $key => $value) {
	// 	$mprice[$key]=floatval($value)>$hiprice ? $hiprice : floatval($value);
	// }
	
	

		foreach ($moreprice as $key => $value) {

				if ($td['shifromdate']<=strtotime($key) && strtotime($key)<=$td['shitodate']) {
					
					$mprice[$key]=floatval($value)>$td['shiprice'] ? $td['shiprice'] : floatval($value);
					
				}else{
					$mprice[$key]=floatval($value)>$td['hiprice'] ? $td['hiprice'] : floatval($value);
				}
			}

	$mprice=serialize($mprice);
	$db->query("UPDATE {$table} set moreprice='$mprice' WHERE itemid=".$itemid);
	dmsg('房价更新成功', $forward);
} else {
	$condition=" username='$_username' and status=3";
	$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");

	while($r = $db->fetch_array($result)) {
		
		$lists[] = $r;
	}
	
}
include template('hotel_fangjia', $module);
?>