<?php
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
    array('信息支付', '?moduleid='.$moduleid.'&file='.$file),
    array('统计报表', '?moduleid='.$moduleid.'&file='.$file.'&action=stats'),
);
$table = $DT_PRE.'finance_pay';
$MODULE[-9]['name'] = '简历';
$MODULE[-9]['islink'] = 0;
$MODULE[-9]['linkurl'] = $MODULE[9]['linkurl'];
switch($action) {
	case 'stats':
		$year = isset($year) ? intval($year) : date('Y', $DT_TIME);
		$year or $year = date('Y', $DT_TIME);
		$month = isset($month) ? intval($month) : date('n', $DT_TIME);
		$chart_data = '';
		$T1 = $T2 = 0;
		if($month) {
			$L = date('t', strtotime($year.'-'.$month.'-01'));
			for($i = 1; $i <= $L; $i++) {
				if($i > 1) $chart_data .= '\n';
				$chart_data .= $i;
				$F = strtotime($year.'-'.$month.'-'.$i.' 00:00:00');
				$T = strtotime($year.'-'.$month.'-'.$i.' 23:59:59');
				$t = $db->get_one("SELECT SUM(`fee`) AS num FROM {$table} WHERE paytime>=$F AND paytime<=$T AND currency='money'");
				$num = $t['num'] ? dround($t['num']) : 0;
				$chart_data .= ';'.$num;
				$T1 += $num;
				$t = $db->get_one("SELECT SUM(`fee`) AS num FROM {$table} WHERE paytime>=$F AND paytime<=$T AND currency='credit'");
				$num = $t['num'] ? intval($t['num']) : 0;
				$chart_data .= ';'.$num;
				$T2 += $num;
			}
			$title = $year.'年'.$month.'月用户支付统计报表';
		} else {
			for($i = 1; $i < 13; $i++) {
				if($i > 1) $chart_data .= '\n';
				$chart_data .= $i;
				$F = strtotime($year.'-'.$i.'-01 00:00:00');
				$T = strtotime($year.'-'.$i.'-'.date('t', $F).' 23:59:59');
				$t = $db->get_one("SELECT SUM(`fee`) AS num FROM {$table} WHERE paytime>=$F AND paytime<=$T AND currency='money'");
				$num = $t['num'] ? dround($t['num']) : 0;
				$chart_data .= ';'.$num;
				$T1 += $num;
				$t = $db->get_one("SELECT SUM(`fee`) AS num FROM {$table} WHERE paytime>=$F AND paytime<=$T AND currency='credit'");
				$num = $t['num'] ? intval($t['num']) : 0;
				$chart_data .= ';'.$num;
				$T2 += $num;
			}
			$title = $year.'年用户支付统计报表';
		}
		include tpl('pay_stats', $module);
	break;
	case 'delete':
		$itemid or msg('未选择记录');
		$pids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$db->query("DELETE FROM {$table} WHERE pid IN ($pids)");
		dmsg('删除成功', $forward);
	break;
	default:
		$sfields = array('按条件', '标题', '用户名', '金额', 'IP');
		$dfields = array('title', 'title', 'fee', 'ip');
		$sorder  = array('排序方式', '金额降序', '金额升序', '时间降序', '时间升序');
		$dorder  = array('pid DESC', 'fee DESC', 'fee ASC', 'paytime DESC', 'paytime ASC');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		isset($username) or $username = '';
		isset($pid) or $pid = '';
		isset($fromtime) or $fromtime = '';
		isset($totime) or $totime = '';
		isset($dfromtime) or $dfromtime = '';
		isset($dtotime) or $dtotime = '';
		isset($currency) or $currency = '';
		isset($minamount) or $minamount = '';
		isset($maxamount) or $maxamount = '';
		isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$module_select = module_select('mid', '模块', $mid);
		$order_select = dselect($sorder, 'order', '', $order);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($fromtime) $condition .= " AND paytime>".(strtotime($fromtime.' 00:00:00'));
		if($totime) $condition .= " AND paytime<".(strtotime($totime.' 23:59:59'));
		if($mid) $condition .= " AND moduleid=$mid";
		if($currency) $condition .= " AND currency='$currency'";
		if($username) $condition .= " AND username='$username'";
		if($itemid) $condition .= " AND itemid=$itemid";
		if($minamount != '') $condition .= " AND fee>=$minamount";
		if($maxamount != '') $condition .= " AND fee<=$maxamount";
		if($pid) $condition .= " AND pid=$pid";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);	
		$lists = array();
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		$fee = 0;
		while($r = $db->fetch_array($result)) {
			$r['paytime'] = timetodate($r['paytime'], 5);
			$fee += $r['fee'];
			$lists[] = $r;
		}
		include tpl('pay', $module);
	break;
}
?>