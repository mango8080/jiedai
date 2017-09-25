<?php
/*
	用户登录数据库操作api
*/
 require '../common.inc.php';
// token验证
// if ($token != md5(md5('HaNShanLing'))) {
// 	exit('Access Denied');
// }

switch ($action) {
	case 'user':
		$user=getUser($f,$v);
		exit(json_encode($user));
		break;
	case 'upuserlog':
		$user=upuserlog($userid,$ip);
		exit();
		break;
	case 'userinfo':
		$user=apiuserinfo($username);
		exit(json_encode($user));
		break;	
	case 'content':
		$content=getUserContent($userid);
		exit(json_encode($content));
		break;
	case 'bindoath':
		exit(bindoath($username, $addtime,$itemid ,$site));
		break;
	case 'bindweixin':
		exit(bindweixin($username, $addtime,$openid));
		break;	
	case 'logout':
		exit(logout($userid));
		break;
	case 'brand':
		$brand_str=json_encode(brandlist());
		exit($brand_str);
		break;
	case 'upsome':
		exit(json_encode(upsome($table,$sets,$wheres)));
		break;
	case 'getcat':
		$r=getcat($cd);
		exit(json_encode($r));
		break;
	case 'uponline':
		exit(uponline($cd));
		break;	
	case 'getone':
		$r=apigetone($condition);
		exit(json_encode($r));
		break;
	case 'checkbuy':
		$r=array();
		$c=getsome('company','username',$username,'jiameng,apigroup');
		if ($c['jiameng']==1){
			$r=getsome($table,$f,$v,$fields);
		}else{
			$fangxingstatus=true;
			if ($c['apigroup']=='jinjiang'){
				$fangxingstatus=jjcheckroom($jjurl,$jjuser,$jjpass,$jjiata,$hotelid,$intime,$days,$roomtype,$v);
			}

			if(!$fangxingstatus){
				//不能预定
			}else{
				$r=getsome($table,$f,$v,$fields);
			}
		}
		exit(json_encode($r));
		break;
	default:

		$r=getsome($table,$f,$v,$fields);
		exit(json_encode($r));
		break;

}
// 取得用户信息
function getUser($f,$v,$fields=''){
	global $db, $DT_TIME, $DT_PRE;
	if (!$fields) $fields='*';
	$r = $db->get_one("SELECT $fields FROM {$DT_PRE}member WHERE `$f`='$v' and groupid=5");
	return $r;
 }
 // 更新用户登录次数
 function upuserlog($userid,$ip){
 	global $db, $DT_TIME, $DT_PRE;
 	$db->query("UPDATE {$DT_PRE}member SET loginip='$ip',logintime=$DT_TIME,logintimes=logintimes+1 WHERE userid=$userid");
 	return true;
 }
 // 确认用户信息
 function apiuserinfo($username){
 	global $db, $DT_TIME, $DT_PRE;
 	$user = $db->get_one("SELECT * FROM {$DT_PRE}member m, {$DT_PRE}company c WHERE m.username=c.username AND m.username='$username'");
 	return $user;
 }
 // 用户的详细信 
 function getUserContent($userid){
 	global $db, $DT_TIME, $DT_PRE;
 	$r = $db->get_one("SELECT content FROM {$DT_PRE}company_data WHERE userid=$userid");
 	return $r;
 }
 function bindoath($username, $addtime,$itemid ,$site){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$db->query("UPDATE {$DT_PRE}oauth SET username='' WHERE username='$username' AND site='$site'");
	$db->query("UPDATE {$DT_PRE}oauth SET username='$username',addtime='$addtime' WHERE itemid=$itemid");
	return true;
}
function bindweixin($username, $addtime,$openid){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$db->query("UPDATE {$DT_PRE}weixin_user SET username='' WHERE username='$username'");
	$db->query("UPDATE {$DT_PRE}weixin_user SET username='$username',edittime='$addtime' WHERE openid='$openid'");
	return true;
}
// 退出在线状态
function logout($userid){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$db->query("DELETE FROM {$DT_PRE}online WHERE userid=$userid");
	return true;
}
// 品牌列表
function brandlist(){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$brand = array();
	$brands=$db->query("SELECT * FROM {$DT_PRE}brand");
	while ($b=$db->fetch_array($brands)) {
		$brand[]=$b;
	}
	return $brand;
}
// 通用数据库查询
function getsome($table,$f,$v,$fields=''){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	if (!$fields) $fields='*';
	$r = $db->get_one("SELECT $fields FROM {$DT_PRE}{$table} WHERE `$f`='$v'");
	return $r;

}
// 通用更新操作
function upsome($table,$sets,$wheres){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$db->query("UPDATE {$table} SET $sets WHERE $wheres");
	return true;
}
// 取得分类
function getcat($catid) {
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$catid = intval($catid);
	$r = array();
	if ($catid) {		 
		$r=$db->get_one("SELECT * FROM {$DT_PRE}category WHERE catid=$catid");	
	}
	return $r;
}
// 更新在线状态
function uponline($_userid,$_username,$moduleid,$_online){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	$db->query("REPLACE INTO {$DT_PRE}online (userid,username,ip,moduleid,online,lasttime) VALUES ('$_userid','$_username','$DT_IP','$moduleid','$_online','$DT_TIME')");
	return true;
}
// 取得用户酒店完整信息
function apigetone($condition){
	global $db, $DT_TIME, $DT_PRE,$DT_IP;
	return $db->get_one("SELECT * FROM {$DT_PRE}member m,{$DT_PRE}company c WHERE m.userid=c.userid AND $condition");

}