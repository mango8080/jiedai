<?php
/*
	消息数据库操作api
*/
require '../common.inc.php';
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }

switch ($action) {
	case 'getmsg':
		$msgs=apigetmsg($wheres,$orderby);
		exit(json_encode($msgs));
		break;
	
	default:

		break;

}
// 取得消息
function apigetmsg($wheres,$orderby){
	global $db, $DT_TIME, $DT_PRE;
	$msgs = array();
	$wheres=dstripslashes($wheres);
	$result = $db->query("SELECT * FROM {$DT_PRE}message WHERE $wheres ORDER BY $orderby DESC");
	while($r = $db->fetch_array($result)) {
		$msgs[] = $r;
	}
	return $msgs;
}

