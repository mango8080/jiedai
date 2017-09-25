<?php 
defined('IN_DESTOON') or exit('Access Denied');
login_hotel();
require DT_ROOT.'/module/mhotel/common.inc.php';
$viewport = 1;
$head_title = $action == 'add' ? $L['info_add'] : $L['info_manage'];
include template('hotel_my', $module);
?>