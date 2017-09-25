<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/mhotel/common.inc.php';
require MD_ROOT.'/member.class.php';
$do = new member;
$do->logout();
$session = new dsession();
session_destroy();

$action = 'logout';
$api_msg = $api_url = '';
if($MOD['passport']) {
	include DT_ROOT.'/api/'.$MOD['passport'].'.inc.php';
	if($api_url) $forward = $api_url;
}
$forward = '/mhotel/login.php';
#if($MOD['sso']) include DT_ROOT.'/api/sso.inc.php';
if($api_msg) message($api_msg, $forward, -1);
message($api_msg, $forward);
?>