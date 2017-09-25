<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
$user = userinfo($_username);
extract($user);
$expired = $totime && $totime < $DT_TIME ? true : false;
$havedays = $expired ? 0 : ceil(($totime-$DT_TIME)/86400);
$head_title = $L['profile_title'];
include template('hotel_profile', $module);
?>