<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
$MG['cash'] or dalert(lang('message->without_permission_and_upgrade'), 'goback');
require DT_ROOT.'/include/post.func.php';
$member = $db->get_one("SELECT company,truename,vbank,money,bank,banktype,branch,account FROM {$DT_PRE}member WHERE userid=$_userid");
$BANKS = explode('|', trim($MOD['cash_banks']));
switch($action) {
	
	case 'shenqing':

		if ($itemid) {
			$db->query("UPDATE destoon_zhangdan SET status=2 WHERE username='$_username'");
		}
		dmsg('申请成功', '?action=index');
	break;
	
	default:
		$cashs=array();
		$rs=$db->query("SELECT * FROM destoon_zhangdan WHERE username='$_username'");
		while ($r=$db->fetch_array($rs)) {
			$cashs[]=$r;
		}

	break;
}
include template('hotel_caiwu', $module);
?>