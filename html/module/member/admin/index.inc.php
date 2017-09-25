<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/member.class.php';
$do = new member;
$menus = array (
    array('添加用户', '?moduleid='.$moduleid.'&action=add'),
    array('用户列表', '?moduleid='.$moduleid),
    array('审核用户', '?moduleid='.$moduleid.'&action=check'),
    // array('用户升级', '?moduleid='.$moduleid.'&file=grade&action=check'),
    array('联系用户', '?moduleid='.$moduleid.'&file=contact'),
    array('公司列表', '?moduleid=4'),
    array(VIP.'列表', '?moduleid=4&file=vip'),
);
isset($userid) or $userid = 0;
if(in_array($action, array('add', 'edit'))) {
	$MFD = cache_read('fields-member.php');
	$CFD = cache_read('fields-company.php');
	isset($post_fields) or $post_fields = array();
	if($MFD || $CFD) require DT_ROOT.'/include/fields.func.php';
}

if($_catids || $_areaids) {
	if(isset($userid)) $itemid = $userid;
	if(isset($member['areaid'])) $post['areaid'] = $member['areaid'];
	require DT_ROOT.'/admin/admin_check.inc.php';
}

if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '公司名', '用户名', '昵称','姓名', '手机号码', '部门', '职位', 'Email',  '登录IP', '客服专员', '开户银行', '银行帐号', $DT['trade_nm'], '推荐人', '备注');
	$dfields = array('username', 'company', 'username', 'passport', 'truename', 'mobile', 'department', 'career', 'email',  'loginip', 'support', 'bank', 'account', 'trade', 'inviter', 'note');
	$sorder  = array('结果排序方式', '注册时间降序', '注册时间升序', '修改时间降序', '修改时间升序', '登录时间降序', '登录时间升序', '登录次数降序', '登录次数升序', '账户'.$DT['money_name'].'降序', '账户'.$DT['money_name'].'升序', '用户'.$DT['credit_name'].'降序', '用户'.$DT['credit_name'].'升序', '短信余额降序', '短信余额升序');
	$dorder  = array('userid DESC', 'regtime DESC', 'regtime ASC', 'edittime DESC', 'edittime ASC', 'logintime DESC', 'logintime ASC', 'logintimes DESC', 'logintimes ASC', 'money DESC', 'money ASC', 'credit DESC', 'credit ASC', 'sms DESC', 'sms ASC');
	$sgender = array('性别', '先生' , '女士');
	$savatar = array('头像', '已上传' , '未上传');
	$sprofile = array('资料', '已完善' , '未完善');
	$semail = array('邮件', '已认证' , '未认证');
	$smobile = array('手机', '已认证' , '未认证');
	$struename = array('实名', '已认证' , '未认证');
	$sbank = array('银行', '已认证' , '未认证');
	$scompany = array('公司', '已认证' , '未认证');
	$strade = array($DT['trade_nm'], '已认证' , '未认证');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$groupid = isset($groupid) ? intval($groupid) : 0;
	$gender = isset($gender) ? intval($gender) : 0;
	$avatar = isset($avatar) ? intval($avatar) : 0;
	$uid = isset($uid) ? intval($uid) : '';
	$username = isset($username) ? trim($username) : '';
	$passport = isset($passport) ? trim($passport) : '';
	$vprofile = isset($vprofile) ? intval($vprofile) : 0;
	$vemail = isset($vemail) ? intval($vemail) : 0;
	$vmobile = isset($vmobile) ? intval($vmobile) : 0;
	$vtruename = isset($vtruename) ? intval($vtruename) : 0;
	$vbank = isset($vbank) ? intval($vbank) : 0;
	$vcompany = isset($vcompany) ? intval($vcompany) : 0;
	$vtrade = isset($vtrade) ? intval($vtrade) : 0;
	isset($fromtime) or $fromtime = '';
	isset($totime) or $totime = '';
	isset($timetype) or $timetype = 'regtime';
	$minmoney = isset($minmoney) ? intval($minmoney) : '';
	$maxmoney = isset($maxmoney) ? intval($maxmoney) : '';
	$mincredit = isset($mincredit) ? intval($mincredit) : '';
	$maxcredit = isset($maxcredit) ? intval($maxcredit) : '';
	$minsms = isset($minsms) ? intval($minsms) : '';
	$maxsms = isset($maxsms) ? intval($maxsms) : '';
	$mindeposit = isset($mindeposit) ? intval($mindeposit) : '';
	$maxdeposit = isset($maxdeposit) ? intval($maxdeposit) : '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);
	$gender_select = dselect($sgender, 'gender', '', $gender);
	$avatar_select = dselect($savatar, 'avatar', '', $avatar);
	$group_select = group_select('groupid', '用户组', $groupid);
	$vprofile_select = dselect($sprofile, 'vprofile', '', $vprofile);
	$vemail_select = dselect($semail, 'vemail', '', $vemail);
	$vmobile_select = dselect($smobile, 'vmobile', '', $vmobile);
	$vtruename_select = dselect($struename, 'vtruename', '', $vtruename);
	$vbank_select = dselect($sbank, 'vbank', '', $vbank);
	$vcompany_select = dselect($scompany, 'vcompany', '', $vcompany);
	$vtrade_select = $DT['trade_nm'] ? dselect($strade, 'vtrade', '', $vtrade) : '';

	$condition = $action ? 'groupid=4' : 'groupid!=4';//
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($gender) $condition .= " AND gender=$gender";
	if($avatar) $condition .= $avatar == 1 ? " AND avatar=1" : " AND avatar=0";
	if($groupid) $condition .= " AND groupid=$groupid";
	if($uid) $condition .= " AND userid=$uid";
	if($username) $condition .= " AND username='$username'";
	if($passport) $condition .= " AND passport='$passport'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($vprofile) $condition .= $vprofile == 1 ? " AND edittime>0" : " AND edittime=0";
	if($vemail) $condition .= $vemail == 1 ? " AND vemail>0" : " AND vemail=0";
	if($vmobile) $condition .= $vmobile == 1 ? " AND vmobile>0" : " AND vmobile=0";
	if($vtruename) $condition .= $vtruename == 1 ? " AND vtruename>0" : " AND vtruename=0";
	if($vbank) $condition .= $vbank == 1 ? " AND vbank>0" : " AND vbank=0";
	if($vcompany) $condition .= $vcompany == 1 ? " AND vcompany>0" : " AND vcompany=0";
	if($vtrade) $condition .= $vtrade == 1 ? " AND vtrade>0" : " AND vtrade=0";
	if($fromtime) $condition .= " AND $timetype>".(strtotime($fromtime.' 00:00:00'));
	if($totime) $condition .= " AND $timetype<".(strtotime($totime.' 23:59:59'));
	if($minmoney) $condition .= " AND money>=$minmoney";
	if($maxmoney) $condition .= " AND money<=$maxmoney";
	if($mincredit) $condition .= " AND credit>=$mincredit";
	if($maxcredit) $condition .= " AND credit<=$maxcredit";
	if($minsms) $condition .= " AND sms>=$minsms";
	if($maxsms) $condition .= " AND sms<=$maxsms";
	if($mindeposit) $condition .= " AND deposit>=$mindeposit";
	if($maxdeposit) $condition .= " AND deposit<=$maxdeposit";
}
if(in_array($action, array('add', 'edit'))) {
	$COM_TYPE = explode('|', $MOD['com_type']);
	$COM_SIZE = explode('|', $MOD['com_size']);
	$COM_MODE = explode('|', $MOD['com_mode']);
	$MONEY_UNIT = explode('|', $MOD['money_unit']);
	$BANKS = explode('|', trim($MOD['cash_banks']));
}

switch($action) {
	case 'add':
	// message('暂不支持后台添加');
		if($submit) {
			$member['groupid'] = $member['regid'];
			if($member['groupid'] == 5) $member['company'] = $member['truename'];
			$member['passport'] = $member['passport'] ? $member['passport'] : $member['username'];
			$member['edittime'] = $member['edittime'] ? $DT_TIME : 0;
			$member['inviter'] = $member['username'];
			if($MFD) fields_check($post_fields, $MFD);
			if($CFD) fields_check($post_fields, $CFD);
			if($do->add($member)) {
				if($MFD) fields_update($post_fields, $do->table_member, $do->userid, 'userid', $MFD);
				if($CFD) fields_update($post_fields, $do->table_company, $do->userid, 'userid', $CFD);
				if($MOD['welcome_sms'] && $DT['sms'] && is_mobile($member['mobile'])) {
					$message = lang('sms->wel_reg', array($member['truename'], $DT['sitename'], $member['username'], $member['password']));
					$message = strip_sms($message);
					send_sms($member['mobile'], $message);
				}
				if($MOD['welcome_message'] || $MOD['welcome_email']) {
					$post = $member;
					$username = $member['username'];
					$email = $member['email'];
					$title = $L['register_msg_welcome'];
					$content = ob_template('welcome', 'mail');
					if($MOD['welcome_message']) send_message($username, $title, $content);
					if($MOD['welcome_email'] && $DT['mail_type'] != 'close') send_mail($email, $title, $content);
				}
				dmsg('添加成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			include tpl('member_add', $module);
		}
	break;
	case 'edit':
	
		$userid or msg();
		$do->userid = $userid;
		$user = $do->get_one();
	
		if(!$_founder && $userid != $_userid && $user['groupid'] == 1) msg('您无权修改其他管理员资料');
		if($submit) {
	
			if($userid == $_userid && $member['password']) msg('系统检查到您要修改密码，正在进入密码修改界面...', '?action=password', 3);
			$member['passport'] = $user['passport'];
			$member['edittime'] = $member['edittime'] ? $DT_TIME : 0;
			$member['validtime'] = $member['validtime'] ? strtotime($member['validtime']) : 0;
			if($userid == 1 || $userid == $CFG['founderid']) $member['groupid'] = 1;
			if($MFD) fields_check($post_fields, $MFD);
			if($CFD) fields_check($post_fields, $CFD);
			$status = 0;
			if($gid != $member['groupid']) {
				$groupid = $member['groupid'];
				if($groupid == 1) {
					$status = 1;
					$member['groupid'] = $gid;
				} else if($GROUP[$groupid]['vip']) {
					$status = 2;
					$member['groupid'] = $gid;
				}
			}
			
			if($do->edit($member)) {
				
				if($MFD) fields_update($post_fields, $do->table_member, $do->userid, 'userid', $MFD);
				if($CFD) fields_update($post_fields, $do->table_company, $do->userid, 'userid', $CFD);
				if($status == 1) msg('用户资料修改成功，如果需要添加管理员，请进入管理员管理...', '?file=admin&action=add&username='.$username, 5);
				if($status == 2) msg('用户资料修改成功，如果需要添加'.VIP.'用户，请进入'.VIP.'管理...', '?moduleid=4&file=vip&action=add&username='.$username, 5);
				dmsg('用户资料修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			
			extract($user);
			$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
			
			
				
			$t = $db->get_one("SELECT * FROM {$content_table} WHERE userid=$userid");
		
			if($t) {
				$content = $t['content'];
			} else {
				$content = '';
				$db->query("INSERT INTO {$content_table} (userid,content) VALUES ('$userid','')");
			}
			$cates = $catid ? explode(',', substr($catid, 1, -1)) : array();
			$validtime = $validtime ? timetodate($validtime, 3) : '';
			include tpl('member_edit', $module);
		}
	break;
	case 'show':
		if(isset($mobile)) {
			$r = $db->get_one("SELECT username FROM {$table} WHERE mobile='$mobile'");
			if($r) $username = $r['username'];
		}
		if(isset($email)) {
			$r = $db->get_one("SELECT username FROM {$table} WHERE email='$email'");
			if($r) $username = $r['username'];
		}
		$username = isset($username) ? $username : '';
		($userid || $username) or msg('用户不存在');
		if($userid) $do->userid = $userid;
		$user = $do->get_one($username);
		$user or msg('用户不存在');
		if(!$_founder && $userid != $_userid && $user['groupid'] == 1) msg('您无权查看其他管理员资料');
		extract($user);
		// 用户的资质认证,借款类型
		if ($regid==6) {
			$fangxing = array();
			$renzheng = $db->get_one("SELECT * FROM `destoon_validate` WHERE username='$username' AND type='company'");
			$mall=$db->query("SELECT * FROM `destoon_mall` WHERE username='$username'");
			while ($rs=$db->fetch_array($mall)) {
				$fangxing[]=$rs;
			}
		}
		
		include tpl('member_show', $module);
	break;
	case 'delete':
		$userid or msg('请选择用户');
		$db->halt = 0;
		if(!$_founder) {
			if(is_array($userid)) {
				foreach($userid as $uid) {
					$do->userid = $uid;
					$user = $do->get_one();
					if($user['groupid'] == 1) dalert('您无权删除管理员', '?file=logout');
				}
			} else {
				$do->userid = $userid;
				$user = $do->get_one();
				if($user['groupid'] == 1) dalert('您无权删除管理员', '?file=logout');
			}
		}
		if($do->delete($userid)) {
			dmsg('删除成功', $forward);
		} else {
			msg($do->errmsg);
		}
	break;
	case 'move':
		$userid or msg('请选择用户');
		$gid = isset($groupids) ? $groupids : $groupid;
		if($gid == 1) msg('操作失败！&nbsp;如果需要添加管理员<br/><a href="?file=admin&action=add">请点这里进入管理员管理...</a>');
		if($GROUP[$gid]['vip']) msg('操作失败！&nbsp;如果需要添加'.VIP.'用户<br/><a href="?moduleid=4&file=vip&action=add">请点这里进入'.VIP.'管理...</a>');
		$do->move($userid, $gid);
		dmsg('移动成功', $forward);
	break;
	case 'check':
		if($userid) {
			if(is_array($userid)) {
				$userids = $userid;
			} else {
				$userids[0] = $userid;
			}
			foreach($userids as $userid) {
				$do->userid = $userid;
				$member = $do->get_one();
				$groupid = $member['regid'];
				$db->query("UPDATE {$DT_PRE}member SET groupid=$groupid,step=0 WHERE userid=$userid");
				$db->query("UPDATE {$DT_PRE}company SET groupid=$groupid WHERE userid=$userid");
				if($MOD['welcome_message'] || $MOD['welcome_email']) {
					$username = $member['username'];
					$email = $member['email'];
					$title = $L['register_msg_welcome'];
					$content = ob_template('welcome', 'mail');
					if($MOD['welcome_message']) send_message($username, $title, $content);
					if($MOD['welcome_email'] && $DT['mail_type'] != 'close') send_mail($email, $title, $content);
				}
				if ($groupid==5){//审核通过发短信
					$sms = new Sms();
					$mobile=$member['mobile'];
					$sms_note='{"name":"'.$member['truename'].'","regdate":"'.date("Y-m-d",$member['regtime']).'"}';
					$status = $sms->send_sms($mobile, $sms_note, 'SMS_34980188');
				}
			}
			dmsg('审核成功', $forward);
		} else {
			$members = $do->get_list($condition, $dorder[$order]);
			include tpl('member_check', $module);
		}
	break;
	case 'rename':
		$cusername or message('当前用户名不能为空');
		$nusername or message('用户名不能为空');
		$user = $do->get_one($cusername);
		$user or message('当前用户名不存在');
		$userid = $user['userid'];
		if(!$_founder && $cusername != $_username) {
			if($user['groupid'] == 1) msg('您无权修改其他管理员用户名');
		}
		if($do->rename($cusername, $nusername)) {
			if(!$user['domain']) {
				$linkurl = userurl($nusername);
				$db->query("UPDATE {$DT_PRE}company SET linkurl='$linkurl' WHERE userid=$userid");
			}
			dmsg('修改成功', $forward);
		} else {
			msg($do->errmsg);
		}
	break;
	case 'passport':
		$cpassport or message('当前用户昵称不能为空');
		$npassport or message('用户昵称不能为空');
		$user = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE passport='$cpassport'");
		$user or message('当前用户昵称不存在');
		$userid = $user['userid'];
		if(!$_founder && $user['username'] != $_username) {
			if($user['groupid'] == 1) msg('您无权修改其他管理员昵称');
		}
		if($do->edit_passport($cpassport, $npassport, $user['username'])) {
			dmsg('修改成功', $forward);
		} else {
			msg($do->errmsg);
		}
	break;
	case 'login':
		if($userid) {
			if($_userid == $userid) msg('', $MODULE[2]['linkurl']);
			if(!$_founder) {
				$do->userid = $userid;
				$user = $do->get_one();
				if($user['groupid'] == 1) msg('您无权登入其他管理员用户中心');
				if($_admin > 1 && $user['support'] && $user['support'] != $_username) msg('您无权登入该用户的用户中心');
			}
			$auth = encrypt($userid.'|'.$_username, DT_KEY.'ADMIN');
			set_cookie('admin_user', $auth);
			msg('授权成功，正在转入用户商务中心...', $MODULE[2]['linkurl'].'?reload='.$DT_TIME);
		} else {
			msg();
		}
	break;
	case 'unlock':
		$ip or msg('请填写需要解锁的IP');
		$ipfile = DT_CACHE.'/ban/'.$ip.'.php';
		if(is_file($ipfile)) {
			cache_delete($ip.'.php', 'ban');
			msg('IP:'.$ip.' 已经成功解除锁定', $forward);
		} else {
			msg('IP:'.$ip.' 未被系统锁定');
		}
	break;
	case 'note_add':
		$userid or msg('请选择用户');
		$note = str_replace(array('|', '-'), array('/', '_'), strip_tags(trim($note)));
		strlen($note) > 3 or msg('请填写备注内容');
		$do->userid = $userid;
		$member = $do->get_one();
		$member or msg('用户不存在');
		if($member['note']) {
			$note = timetodate($DT_TIME, 5)."|".$_username."|".$note."\n--------------------\n".addslashes($member['note']);
		} else {
			$note = timetodate($DT_TIME, 5)."|".$_username."|".$note;
		}
		$db->query("UPDATE {$table} SET note='$note' WHERE userid=$userid");
		dmsg('追加成功', '?moduleid='.$moduleid.'&action=show&userid='.$userid);
	break;
	case 'note_edit':
		$_admin == 1 or msg();
		$userid or msg('请选择用户');
		$do->userid = $userid;
		$member = $do->get_one();
		$member or msg('用户不存在');
		$note = strip_tags($note);
		$db->query("UPDATE {$table} SET note='$note' WHERE userid=$userid");
		dmsg('修改成功', '?moduleid='.$moduleid.'&action=show&userid='.$userid);
	break;
	default:
		$members = $do->get_list($condition, $dorder[$order]);
		include tpl('member', $module);
	break;
}
?>