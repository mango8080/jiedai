<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
$thumb = isset($thumb) ? intval($thumb) : 0;
$vip = isset($vip) ? intval($vip) : 0;
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$sfields = array($L['by_auto'], $L['by_title'], $L['by_content'], $L['by_introduce']);
$dfields = array('keyword', 'title', 'content', 'introduce');
$sorder  = array($L['order'], $L['order_auto']);
$dorder  = array($MOD['order'], '');
if(!$MOD['fulltext']) unset($sfields[2], $dfields[2]);
isset($fields) && isset($dfields[$fields]) or $fields = 0;
isset($order) && isset($dorder[$order]) or $order = 0;
$category_select = ajax_category_select('catid', $L['all_category'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$order_select  = dselect($sorder, 'order', '', $order);
$tags = array();
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message(lang($L['word_limit'], array($DT['min_kw'], $DT['max_kw'])), $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($DT['search_limit'])), $MOD['linkurl'].'search.php');
			set_cookie('last_search', $DT_TIME);
		}
	}

	$pptsql = '';
	if($CP) {
		require DT_ROOT.'/include/property.func.php';
		$PPT = property_condition($catid);
		foreach($PPT as $k=>$v) {
			$PPT[$k]['select'] = '';
			$oid = $v['oid'];
			$tmp = 'ppt_'.$oid;
			if(isset($$tmp)) {
				$PPT[$k]['select'] = $tmp = $$tmp;
				if($tmp && in_array($tmp, $v['options'])) {
					$tmp = 'O'.$oid.':'.$tmp.';';
					$pptsql .= " AND pptword LIKE '%$tmp%'";
				}
			}
		}
	}
	$fds = $MOD['fields'];
	$condition = '';
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	if($thumb) $condition .= " AND thumb<>''";
	if($vip) $condition .= " AND vip>0";
	if($typeid != 99) $condition .= " AND typeid=$typeid";
	if($fromtime) $condition .= " AND edittime>=$fromtime";
	if($totime) $condition .= " AND edittime<=$totime";
	if($dfields[$fields] == 'content') {
		if($keyword && $MOD['fulltext'] == 1) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		$condition = str_replace('AND ', 'AND i.', $condition);
		$condition = str_replace('i.content', 'd.content', $condition);
		$condition = "i.status=3 AND i.itemid=d.itemid".$condition;
		if($keyword && $MOD['fulltext'] == 2) $condition .= " AND MATCH(`content`) AGAINST('$kw'".(preg_match("/[+-<>()~*]/", $kw) ? ' IN BOOLEAN MODE' : '').")";
		$table = $table.' i,'.$table_data.' d';
		$fds = 'i.'.str_replace(',', ',i.', $fds);
	} else {
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($pptsql) $condition .= $pptsql;//PPT
		$condition = "status=3".$condition;
	}
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$items = $db->count($table, $condition, $DT['cache_search']);
	$pages = pages($items, $page, $pagesize);
	if($items) {
		$order = $dorder[$order] ? " ORDER BY $dorder[$order]" : '';
		$result = $db->query("SELECT $fds FROM {$table} WHERE {$condition}{$order} LIMIT {$offset},{$pagesize}", $DT['cache_search'] && $page == 1 ? 'CACHE' : '', $DT['cache_search']);
		if($kw) {
			$replacef = explode(' ', $kw);
			$replacet = array_map('highlight', $replacef);
		}
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = DT_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			if($kw) $r['title'] = str_replace($replacef, $replacet, $r['title']);
			if($kw) $r['introduce'] = str_replace($replacef, $replacet, $r['introduce']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$tags[] = $r;
		}
		$db->free_result($result);
		if($page == 1 && $kw) keyword($kw, $items, $moduleid);
	}
}
$showpage = 1;
$datetype = 5;
$width = 250;
$height = 180;
$cols = 3;
$target = '_blank';
$seo_file = 'search';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].($kw ? 'index.php?moduleid='.$moduleid.'&kw='.encrypt($kw, DT_KEY.'KW') : 'search.php?action=mod'.$moduleid);
include template('search', $module);
?>