<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/quote.class.php';
$do = new quote($moduleid);
$menus = array (
    array('添加'.$MOD['name'], '?moduleid='.$moduleid.'&action=add'),
    array($MOD['name'].'列表', '?moduleid='.$moduleid),
    array('审核'.$MOD['name'], '?moduleid='.$moduleid.'&action=check'),
    array('未通过'.$MOD['name'], '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
	$CP = $MOD['cat_property'];
	if($CP) require DT_ROOT.'/include/property.func.php';
	isset($post_ppt) or $post_ppt = array();
}

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

if(in_array($action, array('', 'check', 'reject', 'recycle'))) {
	$sfields = array('模糊', '标题', '产品名', '简介', '用户名', '编辑', 'IP', '文件路径', '内容模板');
	$dfields = array('keyword', 'title', 'tag', 'introduce', 'username', 'editor', 'ip', 'filepath', 'template');
	$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '更新时间降序', '更新时间升序', '浏览次数降序', '浏览次数升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'itemid DESC', 'itemid ASC');

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$level = isset($level) ? intval($level) : 0;

	isset($datetype) && in_array($datetype, array('edittime', 'addtime', 'totime')) or $datetype = 'addtime';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;

	$thumb = isset($thumb) ? intval($thumb) : 0;
	$guest = isset($guest) ? intval($guest) : 0;
	$itemid or $itemid = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$level_select = level_select('level', '级别', $level, 'all');
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($level) $condition .= $level > 9 ? " AND level>0" : " AND level=$level";
	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
	if($totime) $condition .= " AND `$datetype`<=$totime";
	if($thumb) $condition .= " AND thumb<>''";
	if($guest) $condition .= " AND username=''";
	if($itemid) $condition .= " AND itemid=$itemid";

	$timetype = strpos($dorder[$order], 'edit') === false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				$do->add($post);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				if($MOD['show_html'] && $post['status'] > 2) $do->tohtml($do->itemid);
				dmsg('添加成功', '?moduleid='.$moduleid.'&action='.$action.'&catid='.$post['catid']);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$item = array();
			$menuid = 0;
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			include tpl('edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($CP) property_check($post_ppt);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				if($CP) property_update($post_ppt, $moduleid, $post['catid'], $do->itemid);
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			$addtime = timetodate($addtime);
			$menuon = array('4', '3', '2', '1');
			$menuid = $menuon[$status];
			include tpl($action, $module);
		}
	break;
	case 'move':
		if($submit) {
			$fromids or msg('请填写来源ID');
			if($tocatid) {
				$db->query("UPDATE {$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				dmsg('移动成功', $forward);
			} else {
				msg('请选择目标分类');
			}
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			$menuid = 5;
			include tpl($action);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'tohtml':
		is_array($itemid) or msg('请选择'.$MOD['name']);
		$html_itemids = $itemid;
		foreach($html_itemids as $itemid) {
			tohtml('show', $module);
		}
		dmsg('生成成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择'.$MOD['name']);
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择'.$MOD['name']);
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择'.$MOD['name']);
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition, $dorder[$order]);
		$menuid = 4;
		include tpl('index', $module);
	break;
	case 'reject':
		if($itemid && !$psize) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition, $dorder[$order]);
			$menuid = 3;
			include tpl('index', $module);
		}
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include tpl('index', $module);
		}
	break;
	case 'price':
		$tag = convert(trim($tag), 'UTF-8', DT_CHARSET);
		$tag or exit;
		$P = $db->get_one("SELECT * FROM {$table}_product WHERE title LIKE '%$tag%'");
		$P or exit;
		$pid = $P['itemid'];
		$condition = "pid=$pid AND status=3";		
		if($day && is_date($day)) $condition .= " AND addtime>=".strtotime($day.' 00:00:00');
		$lists = array();
		$result = $db->query("SELECT * FROM {$table}_price WHERE $condition ORDER BY addtime DESC LIMIT 50");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		if($lists) {
			echo count($lists).'|*|';
			include template('quote', 'quote');
		}
	break;
	default:
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
		$menuid = 1;
		include tpl('index', $module);
	break;
}
?>