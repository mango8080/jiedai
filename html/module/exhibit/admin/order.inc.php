<?php
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
    array($MOD['name'].'管理', '?moduleid='.$moduleid),
    array('报名管理', '?moduleid='.$moduleid.'&file='.$file),
);
$id = isset($id) && $id ? intval($id) : '';
switch($action) {
	case 'show':
		$itemid or msg('未指定记录');
		$item = $db->get_one("SELECT * FROM {$table_order} WHERE itemid=$itemid");
		$item or msg('记录不存在');
		$item['linkurl'] = DT_PATH.'api/redirect.php?mid='.$moduleid.'&itemid='.$item['id'];
		$item['addtime'] = timetodate($item['addtime'], 6);
		include tpl('order_show', $module);
	break;
	case 'delete':
		$itemid or msg('未选择记录');
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		$db->query("DELETE FROM {$table_order} WHERE itemid IN ($itemids)");
		dmsg('删除成功', $forward);
	break;
	default:
		$sfields = array('按条件', '展会名称', '发布人', '用户', '公司', '姓名', '地址', '邮编', '手机', '邮件', 'QQ', '备注');
		$dfields = array('title', 'title', 'user', 'username', 'company', 'truename', 'address', 'postcode', 'mobile', 'email', 'qq', 'content');
		$sorder  = array('排序方式', '报名时间降序', '报名时间升序', '报名人数降序', '报名人数升序');
		$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC', 'amount DESC', 'amount ASC');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$itemid or $itemid = '';
		isset($amounts) or $amounts = '';
		isset($fromtime) or $fromtime = '';
		isset($totime) or $totime = '';
		isset($minamount) or $minamount = '';
		isset($maxamount) or $maxamount = '';
		isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$order_select = dselect($sorder, 'order', '', $order);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($fromtime) $condition .= " AND addtime>".(strtotime($fromtime.' 00:00:00'));
		if($totime) $condition .= " AND addtime<".(strtotime($totime.' 23:59:59'));
		if($itemid) $condition .= " AND itemid=$itemid";
		if($id) $condition .= " AND id=$id";
		if($minamount != '') $condition .= " AND amount>=$minamount";
		if($maxamount != '') $condition .= " AND amount<=$maxamount";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table_order} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);	
		$lists = array();
		$result = $db->query("SELECT * FROM {$table_order} WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['linkurl'] = DT_PATH.'api/redirect.php?mid='.$moduleid.'&itemid='.$r['id'];
			$r['addtime'] = timetodate($r['addtime'], 5);
			$lists[] = $r;
		}
		include tpl('order', $module);
	break;
}
?>