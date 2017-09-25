<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/mhotel/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/module/mhotel/member.class.php';
if (!$_userid) {
	dheader('login.php');
}
$do = new member;
$session = new dsession();
$do->userid = $_userid;
$do->username = $_username;
$user = $do->get_one();

if($user['step']!=1) exit('非法进入');

$FD = $MFD = cache_read('fields-member.php');
$CFD = cache_read('fields-company.php');
isset($post_fields) or $post_fields = array();
if($MFD || $CFD) require DT_ROOT.'/include/fields.func.php';
$GROUP = cache_read('group.php');
if($submit) {
	$post = daddslashes($post);
	$member_fields = array('company','passport','sound','email','msn','qq','ali','skype','gender','truename','mobile','department','career','groupid','areaid', 'edittime','black','bank','banktype','branch','account','vemail','vmobile','vbank','vtruename','vcompany','vtrade','trade','support','inviter','cardcode','step');
	$company_fields = array('company','type','areaid', 'catid','catids','business','mode','regyear','regunit','capital','size','address','postcode','telephone','fax','mail','homepage','sell','buy','introduce','thumb','keyword','linkurl','groupid','domain','icp','validated','validator','validtime','skin','template','policies','totalrooms','starrating','longitude','latitude');
	$member_sql = $company_sql = '';

	foreach($post as $k=>$v) {
			if(in_array($k, $member_fields)) $member_sql .= ",$k='$v'";
			if(in_array($k, $company_fields)) $company_sql .= ",$k='".str_replace(DT_PATH, '', $v)."'";
		}
	$member_sql = substr($member_sql, 1);
    $company_sql = substr($company_sql, 1);
    $db->query("UPDATE {$DT_PRE}member SET $member_sql WHERE userid=$_userid");
    $db->query("UPDATE {$DT_PRE}company SET $company_sql WHERE userid=$_userid");
    $db->query("UPDATE {$DT_PRE}company_data SET content='$post[content]' WHERE userid=$_userid");
	$company=$post['company'];
	$thumb = str_replace(DT_PATH, '',$thumb1);
	$thumb1 = str_replace(DT_PATH, '',$thumb2);
	$thumb2 = str_replace(DT_PATH, '',$thumb3);
	$thumb3 = str_replace(DT_PATH, '',$thumb4);
	$v=$db->query("INSERT INTO {$DT_PRE}validate (type,username,ip,addtime,status,editor,edittime,title,thumb,thumb1,thumb2,thumb3) VALUES ('company','$_username','$DT_IP','$DT_TIME','2','system','$DT_TIME','$company','$thumb','$thumb1','$thumb2','$thumb3')");
	message('酒店资料提交成功','reghotel3.php');
	// message('酒店资料提交成功','reghotel3.php?auth='.encrypt($post['username']));
} else {

	$COM_TYPE = explode('|', $MOD['com_type']);
	$COM_SIZE = explode('|', $MOD['com_size']);
	$COM_MODE = explode('|', $MOD['com_mode']);
	$MONEY_UNIT = explode('|', $MOD['money_unit']);
	$mode_check = dcheckbox($COM_MODE, 'post[mode][]', '', 'onclick="check_mode(this);"', 0);
	if($auth) {
		$username = decrypt($auth);
		$user = userinfo($username, 0);
		if(!$user) {
			
			return message('账号有误');
		}
		$_username=$user['username'];
		$_userid=$user['userid'];
		$company=$db->get_one("SELECT company FROM {$DT_PRE}company WHERE username='$username' ");
		
	}

	if (!$_username) dheader('login.php');

	include template('reghotel2', $module);
}
?>