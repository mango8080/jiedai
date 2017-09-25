<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
include load($module.'.lang');
include load('my.lang');
(isset($job) && check_name($job)) or $job = '';
if(in_array($job, array('group', 'reply', 'join', 'fans', 'manage'))) {
	require MD_ROOT.'/my_'.$job.'.inc.php';
} else {
	$job = '';
	$MG['club_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
	require MD_ROOT.'/club.class.php';
	$do = new club($moduleid);
	if(in_array($action, array('add', 'edit'))) {
		$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
		if($FD) require DT_ROOT.'/include/fields.func.php';
		isset($post_fields) or $post_fields = array();
		$CP = $MOD['cat_property'];
		if($CP) require DT_ROOT.'/include/property.func.php';
		isset($post_ppt) or $post_ppt = array();
	}
	$sql = $_userid ? "username='$_username'" : "ip='$DT_IP'";
	$limit_used = $limit_free = $need_password = $need_captcha = $need_question = $fee_add = 0;
	if(in_array($action, array('', 'add'))) {
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $sql AND status>1");
		$limit_used = $r['num'];
		$limit_free = $MG['club_limit'] > $limit_used ? $MG['club_limit'] - $limit_used : 0;
	}
	switch($action) {
		case 'add':
			$gid = isset($gid) ? intval($gid) : 0;
			$gid or message($L['my_choose_group'], $MOD['linkurl']);
			$GRP = get_group($gid);
			($GRP && $GRP['status'] == 3) or message($L['my_not_group']);
			if($MG['club_limit'] && $limit_used >= $MG['club_limit']) dalert(lang($L['info_limit'], array($MG[$MOD['module'].'_limit'], $limit_used)), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
			if($GRP['post_type'] && !is_fans($GRP)) {
				$action = 'post';
				$head_title = lang('message->without_permission');
				exit(include template('nofans', $module));
			}
			if($MG['day_limit']) {
				$today = $today_endtime - 86400;
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $sql AND addtime>$today");
				if($r && $r['num'] >= $MG['day_limit']) dalert(lang($L['day_limit'], array($MG['day_limit'])), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
			}

			if($MG['club_free_limit'] >= 0) {
				$fee_add = ($MOD['fee_add'] && (!$MOD['fee_mode'] || !$MG['fee_mode']) && $limit_used >= $MG['club_free_limit'] && $_userid) ? dround($MOD['fee_add']) : 0;
			} else {
				$fee_add = 0;
			}
			$fee_currency = $MOD['fee_currency'];
			$fee_unit = $fee_currency == 'money' ? $DT['money_unit'] : $DT['credit_unit'];
			$need_password = $fee_add && $fee_currency == 'money';
			$need_captcha = $MOD['captcha_add'] == 2 ? $MG['captcha'] : $MOD['captcha_add'];
			$need_question = $MOD['question_add'] == 2 ? $MG['question'] : $MOD['question_add'];

			if($submit) {
				if($fee_add && $fee_add > ($fee_currency == 'money' ? $_money : $_credit)) dalert($L['balance_lack']);
				if($need_password && !is_payword($_username, $password)) dalert($L['error_payword']);
				$msg = captcha($captcha, $need_captcha, true);
				if($msg) dalert($msg);
				$msg = question($answer, $need_question, true);
				if($msg) dalert($msg);
				$post['gid'] = $GRP['itemid'];
				$post['catid'] = $GRP['catid'];
				if($do->pass($post)) {
					$post['addtime'] = $post['level'] = $post['fee'] = 0;
					$post['style'] = $post['template'] = $post['note'] = $post['filepath'] = '';
					$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
					$post['status'] = get_status(3, $need_check);
					$post['hits'] = 0;
					$post['username'] = $_username;
					if($FD) fields_check($post_fields);
					if($CP) property_check($post_ppt);
					$do->add($post);
					if($FD) fields_update($post_fields, $table, $do->itemid);
					if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
					if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);
					if($fee_add) {
						if($fee_currency == 'money') {
							money_add($_username, -$fee_add);
							money_record($_username, -$fee_add, $L['in_site'], 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
						} else {
							credit_add($_username, -$fee_add);
							credit_record($_username, -$fee_add, 'system', lang($L['credit_record_add'], array($MOD['name'])), 'ID:'.$do->itemid);
						}
					}
					$js = '';
					if(isset($post['sync_sina']) && $post['sync_sina']) $js .= sync_weibo('sina', $moduleid, $do->itemid);
					if(isset($post['sync_qq']) && $post['sync_qq']) $js .= sync_weibo('qq', $moduleid, $do->itemid);
					if($post['status'] == 3) {
						$r = $db->get_one("SELECT linkurl FROM {$table} WHERE itemid=$do->itemid");
						$forward = $MOD['linkurl'].$r['linkurl'];
						$msg = '';
					} else {
						if($_userid) {
							set_cookie('dmsg', $msg);
							$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&status='.$post['status'];
							$msg = '';
						} else {
							$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&action=add';
							$msg = $L['success_check'];
						}
					}
					$js .= 'window.onload=function(){parent.window.location="'.$forward.'";}';
					dalert($msg, '', $js);
				} else {
					dalert($do->errmsg, '', ($need_captcha ? reload_captcha() : '').($need_question ? reload_question() : ''));
				}
			} else {
				$_gid = $gid;
				foreach($do->fields as $v) {
					$$v = '';
				}
				$gid = $_gid;
				$content = '';
				if($kw) $title = $kw;
				$item = array();
			}
		break;
		case 'edit':
			$itemid or message();
			$do->itemid = $itemid;
			$item = $do->get_one();
			if(!$item || $item['username'] != $_username) message();
			$gid = $item['gid'];
			$GRP = get_group($gid);

			if($MG['edit_limit'] < 0) message($L['edit_refuse']);
			if($MG['edit_limit'] && $DT_TIME - $item['addtime'] > $MG['edit_limit']*86400) message(lang($L['edit_limit'], array($MG['edit_limit'])));

			if($submit) {
				$post['gid'] = $GRP['itemid'];
				$post['catid'] = $GRP['catid'];
				if($do->pass($post)) {
					$post['addtime'] = timetodate($item['addtime']);
					$post['level'] = $item['level'];
					$post['fee'] = $item['fee'];
					$post['style'] = addslashes($item['style']);
					$post['template'] = addslashes($item['template']);
					$post['filepath'] = addslashes($item['filepath']);
					$post['note'] = addslashes($item['note']);
					$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
					$post['status'] = get_status($item['status'], $need_check);
					$post['hits'] = $item['hits'];
					$post['save_remotepic'] = $MOD['save_remotepic'] ? 1 : 0;
					$post['get_introduce'] = $MOD['get_introduce'] ? 1 : 0;
					$post['introduce_length'] = $MOD['introduce_length'] ? $MOD['introduce_length'] : 0;
					if($FD) fields_check($post_fields);
					if($CP) property_check($post_ppt);
					if($FD) fields_update($post_fields, $table, $do->itemid);
					if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
					$do->edit($post);
					set_cookie('dmsg', $L['success_edit']);
					dalert('', '', 'parent.window.location="'.$forward.'"');
				} else {
					dalert($do->errmsg);
				}
			} else {
				extract($item);
			}
		break;
		case 'delete':
			$MG['delete'] or message();
			$itemid or message();
			$itemids = is_array($itemid) ? $itemid : array($itemid);
			foreach($itemids as $itemid) {
				$do->itemid = $itemid;
				$item = $db->get_one("SELECT username FROM {$table} WHERE itemid=$itemid");
				if(!$item || $item['username'] != $_username) message();
				$do->recycle($itemid);
			}
			dmsg($L['success_delete'], $forward);
		break;
		default:
			$status = isset($status) ? intval($status) : 3;
			in_array($status, array(1, 2, 3)) or $status = 3;
			$condition = "username='$_username'";
			$condition .= " AND status=$status";
			if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
			if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
			$timetype = strpos($MOD['order'], 'edit') === false ? 'add' : '';
			$lists = $do->get_list($condition, $MOD['order']);
		break;
	}
	if($_userid) {
		$nums = array();
		for($i = 1; $i < 4; $i++) {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE username='$_username' AND status=$i");
			$nums[$i] = $r['num'];
		}
	}
	$head_title = $L['my_title'];
}
include template('my_'.$module, 'member');
?>