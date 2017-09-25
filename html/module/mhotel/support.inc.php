<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
$r = $db->get_one("SELECT support FROM {$DT_PRE}member WHERE userid=$_userid");
$r['support'] or message($L['support_error_1']);
$user = userinfo($r['support']);
$user or message($L['support_error_2']);
$head_title = $L['support_title'];
include template('hotel_support', $module);
?>