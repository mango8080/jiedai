<?php
defined('IN_DESTOON') or exit('Access Denied');
$time = $today_endtime - 90*86400;
$db->query("DELETE FROM {$DT_PRE}mail_log WHERE addtime<$time");
?>