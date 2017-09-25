<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/mhotel/common.inc.php';

if (!$_userid) {
	dheader('login.php');
}

$db->query("UPDATE destoon_member set step=3 WHERE userid=$_userid");
include template('reghotel4', $module);
?>