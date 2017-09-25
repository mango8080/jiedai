<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/mhotel/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$head_title = $L['goto'];
$email = isset($email) && is_email($email) ? $email : '';
if($email) {
	$tmp = explode('@', $email);
	$url = str_replace('vip.', '', $tmp[1]);
	$url = 'http://mail.'.$url;
} else {
	if($action == 'register_success') {
		$url = '/mhotel/login.php'.'?auth='.$auth.'&forward='.urlencode($forward);
	} else {
		$url = 'http://';
	}
}
include template('hotel_goto', $module);
?>