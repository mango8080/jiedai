<?php
/*
	用户注册数据库操作api
*/
require '../common.inc.php';
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }

switch ($action) {
	case 'add':
		exit(json_encode(add($member)));
		break;
	case 'sendms':
		exit(json_encode(sendms($mobile,$message)));
		break;
	default:
		# code...
		break;
}


function add($member){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
		$member_fields = array('username','company','passport', 'password','payword','email','sound','gender','truename','mobile','msn','qq','ali','skype','department','career','groupid','regid','areaid','edittime','inviter','passsalt', 'paysalt','cardcode','danwei','jingzhong','jinghao');
		$company_fields = array('username','groupid','company','type','catid','catids','areaid', 'mode','capital','regunit','size','regyear','sell','buy','business','telephone','fax','mail','address','postcode','homepage','introduce','thumb','keyword','linkurl','policies','totalrooms','starrating','jiameng','hiprice','shiprice','shifromtime','shitotime');
		$member_sqlk = $member_sqlv = $company_sqlk = $company_sqlv = '';
		foreach($member as $k=>$v) {
			
			if(in_array($k, $member_fields)) {$member_sqlk .= ','.$k; $member_sqlv .= ",'$v'";}
			if(in_array($k, $company_fields)) {$company_sqlk .= ','.$k; $company_sqlv .= ",'$v'";}
		}
		
        $member_sqlk = substr($member_sqlk, 1);
        $member_sqlv = substr($member_sqlv, 1);
        $company_sqlk = substr($company_sqlk, 1);
        $company_sqlv = substr($company_sqlv, 1);
        $db->query("INSERT INTO {$DT_PRE}member ($member_sqlk,regip,regtime,loginip,logintime)  VALUES ($member_sqlv,'$DT_IP','$DT_TIME','$DT_IP','$DT_TIME')");
        $userid = $db->insert_id();
		if(!$userid) return 0;
		$member['userid'] = $userid;
		$username = $member['username'];
	    $db->query("INSERT INTO {$DT_PRE}company (userid, $company_sqlk) VALUES ('$userid', $company_sqlv)");
	    $db->query("INSERT INTO {$DT_PRE}company_data (userid, content) VALUES ('$userid', '$member[content]')");
		return $userid;
}

//send mobile message
function sendms($mobile,$message){
	return '1';
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	return send_sms($mobile,$message);
}





