<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
$moduleid = 2;
require 'common.inc.php';
require DT_ROOT.'/include/post.func.php';
	$_userid or dheader('login.php?forward='.urlencode('my.php?action='.$action));

$t_name="my";
if($action == 'back') {
	$t = explode('.php', $DT_REF);
	$r = basename($t[0]);
	if($r.'.php' == $DT['file_my']) {
		$action = 'info';
	} else {
		if(in_array($r, array('trade', 'group', 'record', 'charge', 'deposit', 'cash', 'credit', 'address'))) {
			$action = 'trade';
		} else if(in_array($r, array('home', 'style', 'news', 'page', 'honor', 'link'))) {
			$action = 'home';
		} else {
			$action = 'member';
		}
	}
}
if($action == 'member') {
	$user = $db->get_one("SELECT deposit FROM {$DT_PRE}member WHERE userid=$_userid");
	$head_name = $L['my_member'];
} elseif($action == 'info') {	
	$u = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE userid=$_userid");
	$head_name = $L['my_info'];	
	$t_name="myinfo";
} elseif($action == 'infoacc') {	
	$sql="Update {$DT_PRE}member Set truename='{$name}',mobile='{$phone}',jingzhong='{$jingzhong}',danwei='{$danwei}',gender='{$gender}',cardcode='{$cardcode}' WHERE userid={$_userid}";	
	if ($db->query($sql)){		
		echo json_encode(array('stat'=>1));	
	}else{		
		echo json_encode(array('stat'=>0,'msg'=>"修改个人信息失败"));	
	}		
	exit();
} elseif ($action == 'cpass'){	
	$t_name="changepassword";
} elseif($action == 'cpassacc') {	
	$u = $db->get_one("SELECT password,passsalt FROM {$DT_PRE}member WHERE userid=$_userid");	
	$passsalt=$u['passsalt'];	
	if ($u['password']!=dpassword($oldPassword,$passsalt)){		
		echo json_encode(array('stat'=>0,'msg'=>"原密码不正确"));		
		exit();	
	}	
	$sql="Update {$DT_PRE}member Set password='".dpassword($newPassword,$passsalt)."' WHERE userid={$_userid}";	
	if ($db->query($sql)){		
		echo json_encode(array('stat'=>1));	
	}else{		
		echo json_encode(array('stat'=>0,'msg'=>"修改密码失败"));	
	}	
	exit();
} elseif($action == 'trade') {	
	$u = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE userid=$_userid");
	
	$head_name = $L['trade'];	
	$t_name="trade";
	$shangxian=$u['username'];
	$orders=$db->query("SELECT * FROM {$DT_PRE}member WHERE shangxian='$shangxian'");
	
	while ($r=$db->fetch_array($orders)) {
		$order[]=$r;
		
	}

}  else {
	$c = $db->get_one("Select count(*) as num From {$DT_PRE}message Where status=3 and isread=0 and touser='$_username'");
	$_newmes=$c['num'];
	$head_name = $L['my_title'];
}
$head_title = $MOD['name'].$DT['seo_delimiter'].$head_title;
$foot = 'my';
include template($t_name, 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>