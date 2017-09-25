<?php 
defined('IN_DESTOON') or exit('Access Denied');

require DT_ROOT.'/module/mall/common.inc.php';
if (!$_userid) {
	dheader('login.php');
}
$step=$db->get_one("SELECT step FROM destoon_member WHERE userid='$_userid'");
if($step['step']!=2) exit('非法进入');
$moduleid=$mid=16;
$table='destoon_mall';
require DT_ROOT.'/include/post.func.php';
include load('mall.lang');
include load('my.lang');
require DT_ROOT.'/module/mall/mall.class.php';
$do = new mall($moduleid);
$do->table=$table;
$do->table_data='destoon_mall_data';
$sql = $_userid ? "username='$_username'" : "ip='$DT_IP'";
if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}
if(check_group($_groupid, $MOD['group_refresh'])) $MOD['credit_refresh'] = 0;
switch($action) {
	case 'add':
		
		if($submit) {
			if($fee_add && $fee_add > ($fee_currency == 'money' ? $_money : $_credit)) dalert($L['balance_lack']);
			if($need_password && !is_payword($_username, $password)) dalert($L['error_payword']);

			if(!$_userid) {
				if(strlen($post['company']) < 4) dalert($L['type_company']);
				if($AREA) {
					if(!isset($AREA[$post['areaid']])) dalert($L['type_area']);
				} else {
					if(!$post['areaid']) dalert($L['type_area']);
				}
				if(strlen($post['truename']) < 4) dalert($L['type_truename']);
				if(strlen($post['mobile']) < 7) dalert($L['type_mobile']);
			}

			if($MG['add_limit']) {
				$last = $db->get_one("SELECT addtime FROM destoon_mall WHERE $sql ORDER BY itemid DESC");
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
				$post['style'] = $post['template'] = $post['note'] = $post['filepath'] = '';
				// if(!$IMVIP && $MG['uploadpt']) $post['thumb1'] = $post['thumb2'] = '';
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = 2;
				$post['hits'] = 0;
				$post['username'] = $_username;
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($could_elite && isset($elite) && $post['thumb'] && $_credit > $MOD['credit_elite']) {
					$post['level'] = 1;
					credit_add($_username, -$MOD['credit_elite']);
					credit_record($_username, -$MOD['credit_elite'], 'system', lang($L['credit_record_elite'], array($MOD['name'])), $post['title']);
				}
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
				
				$msg = $post['status'] == 2 ? $L['success_check'] : $L['success_add'];
				$js = '';
				if(isset($post['sync_sina']) && $post['sync_sina']) $js .= sync_weibo('sina', $moduleid, $do->itemid);
				if(isset($post['sync_qq']) && $post['sync_qq']) $js .= sync_weibo('qq', $moduleid, $do->itemid);
				if($_userid) {
					set_cookie('dmsg', $msg);
					$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&status='.$post['status'];
					$msg = '';
				} else {
					$forward = $MODULE[2]['linkurl'].$DT['file_my'].'?mid='.$mid.'&action=add';
				}
				$forward='reghotel3.php';
				$js .= 'window.onload=function(){parent.window.location="'.$forward.'";}';
				dalert($msg, '', $js);
			} else {
				dalert($do->errmsg, '', ($need_captcha ? reload_captcha() : '').($need_question ? reload_question() : ''));
			}
		} else {
			
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$item = $do->get_one();

		if(!$item || $item['username'] != $_username) message();

		// if($MG['edit_limit'] < 0) message($L['edit_refuse']);
		// if($MG['edit_limit'] && $DT_TIME - $item['addtime'] > $MG['edit_limit']*86400) message(lang($L['edit_limit'], array($MG['edit_limit'])));

		if($submit) {
			if($do->pass($post)) {
				$CAT = get_cat($post['catid']);
				if(!$CAT || !check_group($_groupid, $CAT['group_add'])) dalert(lang($L['group_add'], array($CAT['catname'])));
				$post['addtime'] = timetodate($item['addtime']);
				$post['level'] = $item['level'];
				$post['fee'] = $item['fee'];
				$post['style'] = addslashes($item['style']);
				$post['template'] = addslashes($item['template']);
				$post['filepath'] = addslashes($item['filepath']);
				$post['note'] = addslashes($item['note']);
				// if(!$IMVIP && $MG['uploadpt']) {
				// 	$post['thumb1'] = $item['thumb1'];
				// 	$post['thumb2'] = $item['thumb2'];
				// }
				$need_check =  $MOD['check_add'] == 2 ? $MG['check'] : $MOD['check_add'];
				$post['status'] = get_status($item['status'], $need_check);
				$post['hits'] = $item['hits'];
				$post['username'] = $_username;
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
			if($step) {
				extract(unserialize($step));
				$a2 > 0 or $a2 = '';
				$a3 > 0 or $a3 = '';
				$p2 > 0 or $p2 = '';
				$p3 > 0 or $p3 = '';
			} else {
				$a1 = 1;
				$p1 = $item['price'];
				$a2 = $a3 = $p2 = $p3 = '';
			}
			$mycatid_select = type_select('mall-'.$_userid, 0, 'post[mycatid]', $L['type_default'], $mycatid);
		}
	break;
	case 'delete':

		// $MG['delete'] or message();
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
	case 'refresh':
		$MG['refresh_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
		$itemid or message($L['select_goods']);
		$itemids = $itemid;
		$s = $f = 0;
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username,edittime FROM {$table} WHERE itemid=$itemid");
			$could_refresh = $item && $item['username'] == $_username;
			if($could_refresh && $MG['refresh_limit'] && $DT_TIME - $item['edittime'] < $MG['refresh_limit']) $could_refresh = false;
			if($could_refresh && $MOD['credit_refresh'] && $MOD['credit_refresh'] > $_credit) $could_refresh = false;
			if($could_refresh) {
				$do->refresh($itemid);
				$s++;
				if($MOD['credit_refresh']) $_credit = $_credit - $MOD['credit_refresh'];
			} else {
				$f++;
			}			
		}
		if($MOD['credit_refresh'] && $s) {
			$credit = $s*$MOD['credit_refresh'];
			credit_add($_username, -$credit);
			credit_record($_username, -$credit, 'system', lang($L['credit_record_refresh'], array($MOD['name'])), lang($L['refresh_total'], array($s)));
		}
		$msg = lang($L['refresh_success'], array($s));
		if($f) $msg = $msg.' '.lang($L['refresh_fail'], array($f));
		dmsg($msg, $forward);
	break;
	case 'onsale':
		$itemid or message($L['select_goods']);
		$itemids = $itemid;
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username FROM {$table} WHERE itemid=$itemid");
			if($item && $item['username'] == $_username) $do->onsale($itemid);		
		}
		dmsg($L['success_onsale'], $forward);
	break;
	case 'unsale':
		$itemid or message($L['select_goods']);
		$itemids = $itemid;
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $db->get_one("SELECT username FROM {$table} WHERE itemid=$itemid");
			if($item && $item['username'] == $_username) $do->unsale($itemid);		
		}
		dmsg($L['success_unsale'], $forward);
	break;
	case 'relate_del':
		$itemid or message($L['select_goods']);
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or message($L['select_goods']);
		$id = isset($id) ? intval($id) : 0;
		$id or message($L['select_goods']);
		$do->itemid = $id;
		$A = $do->get_one();
		$do->relate_del($M, $A);
		dmsg($L['success_delete'], '?mid='.$mid.'&itemid='.$itemid.'&action=relate');
	break;
	case 'relate_add':
		$relate_name = isset($relate_name) ? dhtmlspecialchars(trim($relate_name)) : '';
		$relate_name or message($L['mall_relate_name'] );
		$itemid or message($L['select_goods']);
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or message($L['select_goods']);
		$id = isset($id) ? intval($id) : 0;
		$id or message($L['select_goods']);
		$do->itemid = $id;
		$A = $do->get_one();
		($A && $A['status'] == 3 && $A['username'] == $M['username']) or message($L['select_goods']);
		if($itemid != $id) $do->relate_add($M, $A, $relate_name);
		dmsg($L['success_add'], '?mid='.$mid.'&itemid='.$itemid.'&action=relate');
	break;
	case 'relate':
		$itemid or message($L['select_goods']);
		$do->itemid = $itemid;
		$M = $do->get_one();
		($M && $M['status'] == 3) or message($L['select_goods']);
		if($submit) {
			$relate_name = isset($relate_name) ? dhtmlspecialchars(trim($relate_name)) : '';
			$relate_name or message($L['mall_relate_name'] );
			$do->relate($M, $post, $relate_name);
			dmsg($L['success_update'], '?mid='.$mid.'&itemid='.$itemid.'&action=relate');
		} else {
			$lists = $do->relate_list($M);
		}
	break;
	default:
		$pagesize = 8;
		$offset = ($page-1)*$pagesize;
		$sorder  = $L['mall_orderby'];
		$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'price DESC', 'price DESC', 'orders DESC', 'orders ASC', 'sales DESC', 'sales ASC', 'amount DESC', 'amount ASC', 'comments DESC', 'comments ASC', 'hits DESC', 'hits ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(1, 2, 3, 4)) or $status = 3;
		$mycatid = isset($mycatid) ? ($mycatid === '' ? -1 : intval($mycatid)) : -1;
		$minprice = isset($minprice) ? dround($minprice) : '';
		$minprice or $minprice = '';
		$maxprice = isset($maxprice) ? dround($maxprice) : '';
		$maxprice or $maxprice = '';
		$minorders = isset($minorders) ? intval($minorders) : '';
		$minorders or $minorders = '';
		$maxorders = isset($maxorders) ? intval($maxorders) : '';
		$maxorders or $maxorders = '';
		$minsales = isset($minsales) ? intval($minsales) : '';
		$minsales or $minsales = '';
		$maxsales = isset($maxsales) ? intval($maxsales) : '';
		$maxsales or $maxsales = '';
		$minamount = isset($minamount) ? intval($minamount) : '';
		$minamount or $minamount = '';
		$maxamount = isset($maxamount) ? intval($maxamount) : '';
		$maxamount or $maxamount = '';
		$mincomments = isset($mincomments) ? intval($mincomments) : '';
		$mincomments or $mincomments = '';
		$maxcomments = isset($maxcomments) ? intval($maxcomments) : '';
		$maxcomments or $maxcomments = '';
		$mycat_select = type_select('mall-'.$_userid, 0, 'mycatid', $L['type_default'], $mycatid, '', $L['type_my']);
		$order_select  = dselect($sorder, 'order', '', $order);

		$condition = "username='$_username' ";
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($mycatid >= 0) $condition .= " AND mycatid IN (".type_child($mycatid, $MTYPE).")";
		if($minprice)  $condition .= " AND price>=$minprice";
		if($maxprice)  $condition .= " AND price<=$maxprice";
		if($minorders)  $condition .= " AND orders>=$minorders";
		if($maxorders)  $condition .= " AND orders<=$maxorders";
		if($minsales)  $condition .= " AND sales>=$minsales";
		if($maxsales)  $condition .= " AND sales<=$maxsales";
		if($minamount)  $condition .= " AND amount>=$minamount";
		if($maxamount)  $condition .= " AND amount<=$maxamount";
		if($mincomments)  $condition .= " AND comments>=$mincomments";
		if($maxcomments)  $condition .= " AND comments<=$maxcomments";

		$timetype = strpos($MOD['order'], 'add') !== false ? 'add' : '';
		$lists = $do->get_list($condition, 'edittime DESC');
		foreach($lists as $k=>$v) {
			$lists[$k]['mycat'] = $v['mycatid'] && isset($MTYPE[$v['mycatid']]) ? set_style($MTYPE[$v['mycatid']]['typename'], $MTYPE[$v['mycatid']]['style']) : $L['type_default'];
		}
		
	break;
}

include template('reghotel3', $module);

?>