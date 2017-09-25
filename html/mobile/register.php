<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
$moduleid = 2;

require 'common.inc.php';
require DT_ROOT.'/module/'.$module.'/common.inc.php';
!$_userid or dheader('my.php?reload='.$DT_TIME);
$MOD['enable_register'] or mobile_msg($L['register_msg_close']);
if($MOD['iptimeout']) {
	$timeout = $DT_TIME - $MOD['iptimeout']*3600;
	$r = $db->get_one("SELECT userid FROM {$DT_PRE}member WHERE regip='$DT_IP' AND regtime>'$timeout'");
	if($r) mobile_msg(lang($L['register_msg_ip'], array($MOD['iptimeout'])));
}

require DT_ROOT.'/include/post.func.php';
$session = new dsession();
$GROUP = cache_read('group.php');
if($MOD['question_register']) $MOD['captcha_register'] = 1;
if(!$DT['sms']) {
	$MOD['welcome_sms'] = 0;
	$MOD['mobilecode_register'] = 0;
}
if($DT['mail_type'] == 'close') {
	if($MOD['checkuser'] == 2) $MOD['checkuser'] = 1;
	$MOD['welcome_email'] = 0;
	$MOD['emailcode_register'] = 0;
}
$verify_type = '';
$need_check = 0;
if($MOD['mobilecode_register']) {
	$verify_type = 'mobile';
	$need_check = 1;
} else if($MOD['emailcode_register'] || $MOD['checkuser'] == 2) {
	$verify_type = 'email';
	$need_check = 1;
} else if($MOD['checkuser'] == 1) {
	$need_check = 1;
}

switch($action) {
	case 'detail':
		(isset($GROUP[$itemid]) && $GROUP[$itemid]['vip'] == 0 && $GROUP[$itemid]['reg'] == 1) or mobile_msg($L['register_group'], 'register.php?reload='.$DT_TIME);
		$back_link = '?reload='.$DT_TIME;
		$head_name = $GROUP[$itemid]['groupname'];
	break;
	case 'agreement':
		ob_start();
		include template('agreement', $module);
		$data = ob_get_contents();
		ob_clean();
		$t1 = explode('body>', $data);
		$t2 = trim(substr($t1[1], 0, -2));
		echo $t2;
		if(DT_CHARSET != 'UTF-8') toutf8();
		exit;
	break;
	case 'success':
		(isset($_SESSION['m_name']) && check_name($_SESSION['m_name'])) or mobile_msg($L['msg_error']);
		if($verify_type == 'mobile') {
			$head_name = $L['register_mobile_title'];
		} else if($verify_type == 'email') {
			$head_name = $L['register_email_title'];
		} else {
			$username = $_SESSION['m_name'];
			unset($_SESSION['m_name']);
			if($need_check) {
				mobile_msg($L['register_check'], 'index.php?reload='.$DT_TIME);
			} else {
				require DT_ROOT.'/module/member/member.class.php';
				$do = new member;
				$user = $do->login($username, '', 0, true);
				if($user) {
					$post = $user;
					$post['password'] = $_SESSION['m_pass'];
					if($MOD['welcome_sms'] && is_mobile($post['mobile'])) {
						$message = lang('sms->wel_reg', array($post['truename'], $DT['sitename'], $post['username'], $post['password']));
						$message = strip_sms($message);
						send_sms($post['mobile'], $message);
					}
					if($MOD['welcome_message'] || $MOD['welcome_email']) {
						$title = $L['register_msg_welcome'];
						$content = ob_template('welcome', 'mail');
						if($MOD['welcome_message']) send_message($username, $title, $content);
						if($MOD['welcome_email'] && $DT['mail_type'] != 'close') send_mail($post['email'], $title, $content);
					}
					unset($_SESSION['m_name']);
					unset($_SESSION['m_pass']);
				}
				mobile_msg($L['register_success'], 'my.php?reload='.$DT_TIME);
			}
		}
		$back_link = 'javascript:Dback(\'my.php\');';
	break;
	case 'send':			
		$t = $db->get_one("SELECT username FROM {$DT_PRE}member WHERE mobile='$mobile' AND regid=5");			
		if ($t){				
			echo json_encode(array('stat'=>"此手机号已经注册"));				
			exit();			
		}			
		if($_SESSION['mobile_time'] && (($DT_TIME - $_SESSION['mobile_time']) < 180)){				
			echo json_encode(array('stat'=>"操作太频繁"));				
			exit();			
		}
			$mobilecode = random(6, '0123456789');
			$_SESSION['mobile'] = $mobile;
			$_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode.'|RM');
			$_SESSION['mobile_time'] = $DT_TIME;
			$sms = new Sms();
			$sms_note='{"code":"'.$mobilecode.'"}';
			$status = $sms->send_sms($mobile, $sms_note, 'SMS_34845340');
			if ($status){
				echo json_encode(array('stat'=>"发送成功"));
			}else{
				echo json_encode(array('stat'=>$sms->error));
			}
			//$content = lang('sms->sms_code', array($mobilecode, $MOD['auth_days']*10)).$DT['sms_sign'];
			//$re=send_sms($mobile, $content);			
			
			exit();
		
	break;
	case 'verify':
		(isset($_SESSION['m_name']) && check_name($_SESSION['m_name'])) or exit('ko');
		$username = $_SESSION['m_name'];
		isset($code) or $code = '';
		preg_match("/^[0-9]{6}$/", $code) or exit('ko');
		$t = $db->get_one("SELECT email,mobile,groupid,regid FROM {$DT_PRE}member WHERE username='$username'");
		$t or exit('ko');
		$t['groupid'] == 4 or exit('ko');
		if($verify_type == 'mobile') {
			$_SESSION['mobile_code'] == md5($t['mobile'].'|'.$code.'|RM') or exit('ko');
		} else if($verify_type == 'email') {
			$_SESSION['email_code'] == md5($t['email'].'|'.$code.'|RE') or exit('ko');
		}
		$db->query("UPDATE {$DT_PRE}member SET groupid='$t[regid]',".($verify_type == 'mobile' ? 'vmobile' : 'vemail')."=1 WHERE username='$username'");
		$db->query("UPDATE {$DT_PRE}company SET groupid='$t[regid]' WHERE username='$username'");
		require DT_ROOT.'/module/member/member.class.php';
		$do = new member;
		$user = $do->login($username, '', 0, true);
		if($user) {
			$post = $user;
			$post['password'] = $_SESSION['m_pass'];
			if($MOD['welcome_sms'] && is_mobile($post['mobile'])) {
				$message = lang('sms->wel_reg', array($post['truename'], $DT['sitename'], $post['username'], $post['password']));
				$message = strip_sms($message);
				send_sms($post['mobile'], $message);
			}
			if($MOD['welcome_message'] || $MOD['welcome_email']) {
				$title = $L['register_msg_welcome'];
				$content = ob_template('welcome', 'mail');
				if($MOD['welcome_message']) send_message($username, $title, $content);
				if($MOD['welcome_email'] && $DT['mail_type'] != 'close') send_mail($post['email'], $title, $content);
			}
			session_destroy();
		}
		exit('ok');
	break;
	case 'post':
	   
	
		//if ($_SESSION['mobile_code'] == md5($mobile.'|'.$verify_code.'|RM')){					}else{			echo json_encode(array('stat'=>0,'msg'=>"验证码不正确"));			exit();		}
		$post['jinghao'] = input_trim($jinghao);
		$post['mobile'] = isset($mobile) ? input_trim($mobile) : '';
		
		//先判断是否重复
		//$member=$db->get_one("Select userid From destoon_member Where regid=5 and (username='{$jinghao}' or jinghao='{$jinghao}' or mobile='{$mobile}' or cardcode='$cardcode')");
		//if (!empty($member)){
		//	echo json_encode(array('stat'=>0,'msg'=>"此用户已存在"));
		//	exit;
		//}

		$post['username'] = input_trim($jinghao);//"m".rand(1000,6000).substr($mobile, -4,4);
		$post['password'] = isset($password) ? input_trim($password) : '';
			
		$post['truename'] = isset($truename) ? convert(input_trim($truename), 'UTF-8', DT_CHARSET) : '';
		$post['danwei'] = isset($danwei) ? convert(input_trim($danwei), 'UTF-8', DT_CHARSET) : '';
		
		
		$post['passport'] = $post['username'];
		$post['cpassword'] = $post['password'];
		$post['shangxian'] = $shangxian;
		$RG = array();
		$post['groupid'] = 5;
		$post['regid'] = 5;
		$post['gender'] = isset($gender) ? input_trim($gender) : '';;
		
		$post['cardcode'] = isset($cardcode) ? convert(input_trim($cardcode), 'UTF-8', DT_CHARSET) : '';
		$post['content'] = $post['introduce'] = $post['thumb'] = $post['banner'] = $post['catid'] = $post['catids'] = '';
		$post['edittime'] = 0;		$post['email'] = isset($email) ? input_trim($email) : '';	
	
		require DT_ROOT.'/module/member/member.class.php';
		
		$do = new member;
		//$do1=$do->add($post);
		//echo json_encode(array('stat'=>0,'msg'=>$do1));exit;
		if($do->add($post)) {
			$_SESSION['m_name'] = $post['username'];
			$_SESSION['m_pass'] = $post['password'];			
			echo json_encode(array('stat'=>1));
		} else {
			echo json_encode(array('stat'=>0,'msg'=>"注册失败"));
		}		exit;
	break;
	default:
		$back_link = 'login.php';
		$head_name = $L['register_title'];
	break;
}
$head_title = $head_name.$DT['seo_delimiter'].$head_title;
$foot = '';
include template('register', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>