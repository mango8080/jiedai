<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
if($action == 'answer') {
	$itemid or dheader($MOD['linkurl']);
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	$item['status'] > 2 or dheader($MOD['linkurl']);
	include load('misc.lang');
	$linkurl = $MOD['linkurl'].$item['linkurl'];
	/*
	$aid = isset($aid) ? intval($aid) : 0;
	$aser = $aid ? $db->get_one("SELECT * FROM {$table}_answer WHERE itemid=$aid AND status=3") : array();
	if($aser && $aser['qid'] != $itemid) exit;
	$could_admin = $could_addition = $could_close = $_username && $_username == $item['username'];
	if($item['process'] > 1) $could_addition = $could_close = false;
	$could_answer = false;
	*/
	$could_answer = check_group($_groupid, $MOD['group_answer']);
	if($item['process'] != 1 || ($_username && $_username == $item['username'])) $could_answer = false;
	$need_captcha = $MOD['captcha_answer'] == 2 ? $MG['captcha'] : $MOD['captcha_answer'];
	$need_question = $MOD['question_answer'] == 2 ? $MG['question'] : $MOD['question_answer'];
	if($could_answer && !$MOD['answer_repeat']) {
		if($_username) {
			$r = $db->get_one("SELECT itemid FROM {$table}_answer WHERE username='$_username' AND qid=$itemid");
		} else {
			$r = $db->get_one("SELECT itemid FROM {$table}_answer WHERE ip='$DT_IP' AND qid=$itemid AND addtime>$DT_TIME-86400");
		}
		if($r) $could_answer = false;
	}
	$could_answer or dheader($linkurl);
	if($submit) {
		$msg = captcha($captcha, $need_captcha, true);
		if($msg) dalert($msg);
		$msg = question($answer, $need_question, true);
		if($msg) dalert($msg);
		$content = stripslashes(trim($content));
		if(!$content) dalert($L['type_answer']);
		$content = save_local($content);
		if($MOD['clear_alink']) $content = clear_link($content);
		if($MOD['save_remotepic']) $content = save_remote($content);
		$content = dsafe($content);
		$content = addslashes($content);
		clear_upload($content);
		$url = dhtmlspecialchars(trim($url));	
		$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_answer'];
		$status = get_status(3, $need_check);
		$hidden = isset($hidden) ? 1 : 0;
		$expert = 0;
		if($_username) {
			$t = $db->get_one("SELECT itemid FROM {$table}_expert WHERE username='$_username'");
			if($t) {
				$expert = 1;
				$db->query("UPDATE {$table}_expert SET answer=answer+1 WHERE username='$_username'");
			}
		}
		$db->query("INSERT INTO {$table}_answer (qid,linkurl,content,username,expert,addtime,ip,status,hidden) VALUES ('$itemid','$url','$content','$_username','$expert','$DT_TIME','$DT_IP','$status','$hidden')");
		if($MOD['credit_answer'] && $_username && $status == 3) {
			$could_credit = true;
			if($MOD['credit_maxanswer'] > 0) {					
				$r = $db->get_one("SELECT SUM(amount) AS total FROM {$DT_PRE}finance_credit WHERE username='$_username' AND addtime>$DT_TIME-86400  AND reason='".$L['answer_question']."'");
				if($r['total'] > $MOD['credit_maxanswer']) $could_credit = false;
			}
			if($could_credit) {
				credit_add($_username, $MOD['credit_answer']);
				credit_record($_username, $MOD['credit_answer'], 'system', $L['answer_question'], 'ID:'.$itemid);
			}
		}
		if($MOD['answer_message'] && $item['username']) {
			send_message($item['username'], lang($L['answer_msg_title'], array(dsubstr($item['title'], 20, '...'))), lang($L['answer_msg_content'], array($item['title'], stripslashes($content), $linkurl)));
		}
		dalert($status == 3 ? $L['answer_success'] : $L['answer_check'], '', 'parent.window.location="'.$linkurl.'";');
	} else {
		$head_title = $L['answer_title'];
		include template('my_'.$module, 'member');
	}
	exit;
}
$MG['know_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
include load($module.'.lang');
include load('my.lang');
require MD_ROOT.'/know.class.php';
$do = new know($moduleid);
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
	$limit_free = $MG['know_limit'] > $limit_used ? $MG['know_limit'] - $limit_used : 0;
}
switch($action) {
	case 'add':
		if($MG['know_limit'] && $limit_used >= $MG['know_limit']) dalert(lang($L['info_limit'], array($MG[$MOD['module'].'_limit'], $limit_used)), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
		if($MG['day_limit']) {
			$today = $today_endtime - 86400;
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $sql AND addtime>$today");
			if($r && $r['num'] >= $MG['day_limit']) dalert(lang($L['day_limit'], array($MG['day_limit'])), $_userid ? $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid : $MODULE[2]['linkurl'].$DT['file_my']);
		}

		if($MG['know_free_limit'] >= 0) {
			$fee_add = ($MOD['fee_add'] && (!$MOD['fee_mode'] || !$MG['fee_mode']) && $limit_used >= $MG['know_free_limit'] && $_userid) ? dround($MOD['fee_add']) : 0;
		} else {
			$fee_add = 0;
		}
		$fee_currency = $MOD['fee_currency'];
		$fee_unit = $fee_currency == 'money' ? $DT['money_unit'] : $DT['credit_unit'];
		$need_password = $fee_add && $fee_currency == 'money';
		$need_captcha = $MOD['captcha_add'] == 2 ? $MG['captcha'] : $MOD['captcha_add'];
		$need_question = $MOD['question_add'] == 2 ? $MG['question'] : $MOD['question_add'];
		$could_color = check_group($_groupid, $MOD['group_color']) && $MOD['credit_color'] && $_userid;

		if($submit) {
			$post['credit'] = abs(intval($post['credit']));
			if($post['credit'] && $post['credit'] > $_credit) dalert($L['balance_lack']);
			if(isset($post['hidden']) && $post['credit'] + $MOD['credit_hidden'] > $_credit) dalert($L['balance_lack']);
			if($fee_add && $fee_add > ($fee_currency == 'money' ? $_money : $_credit)) dalert($L['balance_lack']);
			if($need_password && !is_payword($_username, $password)) dalert($L['error_payword']);
			if($MG['add_limit']) {
				$last = $db->get_one("SELECT addtime FROM {$table} WHERE $sql ORDER BY itemid DESC");
				if($last && $DT_TIME - $last['addtime'] < $MG['add_limit']) dalert(lang($L['add_limit'], array($MG['add_limit'])));
			}
			$msg = captcha($captcha, $need_captcha, true);
			if($msg) dalert($msg);
			$msg = question($answer, $need_question, true);
			if($msg) dalert($msg);
			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				if(!$CAT || !check_group($_groupid, $CAT['group_add'])) dalert(lang($L['group_add'], array($CAT['catname'])));
				$post['addtime'] = $post['level'] = $post['fee'] = 0;
				$post['style'] = $post['template'] = $post['note'] = $post['thumb'] = $post['filepath'] = '';
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status(3, $need_check);
				$post['hits'] = 0;
				$post['username'] = $_username;
				$post['areaid'] = $cityid;
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($could_color && $color && $_credit > $MOD['credit_color']) {
					$post['style'] = $color;
					credit_add($_username, -$MOD['credit_color']);
					credit_record($_username, -$MOD['credit_color'], 'system', $L['title_color'], '['.$MOD['name'].']'.$post['title']);
				}
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

				if($post['credit']) {
					credit_add($_username, -$post['credit']);
					credit_record($_username, -$post['credit'], 'system', lang($L['credit_record_reward'], array($MOD['name'])), 'ID:'.$do->itemid);
				}

				if(isset($post['hidden']) && $MOD['credit_hidden']) {
					credit_add($_username, -$MOD['credit_hidden']);
					credit_record($_username, -$MOD['credit_hidden'], 'system', lang($L['credit_record_hidden'], array($MOD['name'])), 'ID:'.$do->itemid);
				}

				if($post['ask'] && check_name($post['ask'])) {
					$db->query("UPDATE {$table}_expert SET ask=ask+1 WHERE username='$post[ask]'");
					$touser = $post['ask'];
					$title = lang($L['know_new_title'], array($post['title']));
					$question = $post['title'];
					$itemid = $do->itemid;
					$content = ob_template('ask', 'mail');
					send_message($touser, $title, $content);
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
			foreach($do->fields as $v) {
				$$v = '';
			}
			$content = '';
			$cid = isset($cid) ? intval($cid) : 0;
			if($cid) $catid = $cid;
			$catid = intval($catid);
			$askto = isset($askto) ? trim($askto) : '';
			if(check_name($askto)) $ask = $askto;
			$areaid = $cityid;
			if($kw) $title = $kw;
			$item = array();
		}
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
$head_title = lang($L['module_manage'], array($MOD['name']));
include template('my_'.$module, 'member');
?>