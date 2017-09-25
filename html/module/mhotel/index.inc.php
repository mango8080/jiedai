<?php 
defined('IN_DESTOON') or exit('Access Denied');
echo $_userid;
if(!$_userid) dheader('login.php');

require DT_ROOT.'/module/mhotel/common.inc.php';
if($action == 'logout' && $admin_user) {
	set_cookie('admin_user', '');
	dmsg($L['index_msg_logout'], $MODULE[2]['linkurl']);
}
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
require MD_ROOT.'/member.class.php';
require DT_ROOT.'/include/post.func.php';
// 重要通知
$tongzhi=$db->query("SELECT * FROM {$DT_PRE}announce WHERE typeid=3 ORDER by itemid desc limit 10");
while($r = $db->fetch_array($tongzhi)) {
	$tz[]=$r;
}
// 未处理订单
$neworder=$db->get_one("SELECT * FROM {$DT_PRE}mall_order WHERE seller='$_username' and access=0 ORDER by itemid desc");
$do = new member;
if($submit) {
	if(word_count($note) > 5000) message($L['index_msg_note_limit']);
	$note = '<?php exit;?>'.dhtmlspecialchars(stripslashes($note));
	file_put(DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php', $note);
	dmsg($L['op_update_success'], $MODULE[2]['linkurl']);
} else {
	$head_title = '';
	$do->userid = $_userid;
	$user = $do->get_one();
	extract($user);
	$expired = $totime && $totime < $DT_TIME ? true : false;
	$havedays = $expired ? 0 : ceil(($totime-$DT_TIME)/86400);

	$sys = array();
	$i = 0;
	$result = $db->query("SELECT itemid,title,addtime,groupids FROM {$DT_PRE}message WHERE groupids<>'' ORDER BY itemid DESC", 'CACHE');
	while($r = $db->fetch_array($result)) {
		$groupids = explode(',', $r['groupids']);
		if(!in_array($_groupid, $groupids)) continue;
		if($i > 2) continue;
		$i++;
		$sys[] = $r;
	}
	$note = DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php';
	$note = file_get($note);
	if($note) {
		$note = substr($note, 13);
	} else {
		$note = $MOD['usernote'];
	}
	// $trade = $db->count("{$DT_PRE}mall_order", "seller='$_username' AND status=0");
	// $t = explode('.', $_money);
	// $my_money = $t[0].'<span>.'.$t[1].'</span>';
	/*
	统计 今日订单，今日入住订单
	*/
	$intime=strtotime(date('Y-m-d'));
	$outtime=strtotime(date('Y-m-d'))+86400;
	$todayorder= $db->count("{$DT_PRE}mall_order", "seller='$_username' AND intime <= $intime and outtime >= $outtime");
	$todayorderin= $db->count("{$DT_PRE}mall_order", "seller='$_username' AND intime <= $intime and outtime >= $outtime and status=4");

	include template('hotel_index', $module);
}
?>