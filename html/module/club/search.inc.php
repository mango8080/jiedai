<?php 
defined('IN_DESTOON') or exit('Access Denied');
if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$group_search = $action == 'resume' ? $MOD['group_search_resume'] : $MOD['group_search'];
if(!check_group($_groupid, $group_search)) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
include load('search.lang');
$CP = $MOD['cat_property'] && $catid && $CAT['property'];
(isset($username) && check_name($username)) or $username = '';
$thumb = isset($thumb) ? intval($thumb) : 0;
$level = isset($level) ? intval($level) : 0;
if(!$areaid && $cityid && strpos($DT_URL, 'areaid') === false) {
	$areaid = $cityid;
	$ARE = $AREA[$cityid];
}
$areaid = isset($areaid) ? intval($areaid) : 0;
$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && is_date($todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$category_select = ajax_category_select('catid', $L['all_category'], $catid, $moduleid);
$area_select = ajax_area_select('areaid', $L['all_area'], $areaid);
$tags = array();
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
if($DT_QST) {
	if($kw) {
		if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) message(lang($L['word_limit'], array($DT['min_kw'], $DT['max_kw'])), $MOD['linkurl'].'search.php');
		if($DT['search_limit'] && $page == 1) {
			if(($DT_TIME - $DT['search_limit']) < get_cookie('last_search')) message(lang($L['time_limit'], array($DT['search_limit'])), $MOD['linkurl'].'search.php');
			set_cookie('last_search', $DT_TIME);
		}
		$replacef = explode(' ', $kw);
		$replacet = array_map('highlight', $replacef);
	}
	if($action == 'group') {
		$condition = 'status=3';
		if($keyword) $condition .= " AND title LIKE '%$keyword%'";
		if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		$items = $db->count($table.'_group', $condition, $DT['cache_search']);
		$pages = pages($items, $page, $pagesize);
		if($items) {
			$result = $db->query("SELECT * FROM {$table}_group WHERE {$condition} ORDER BY itemid DESC LIMIT {$offset},{$pagesize}", $DT['cache_search'] && $page == 1 ? 'CACHE' : '', $DT['cache_search']);
			while($r = $db->fetch_array($result)) {
				$r['adddate'] = timetodate($r['addtime'], 5);
				if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = DT_SKIN.'image/lazy.gif" original="'.$r['thumb'];
				$r['alt'] = $r['title'];
				$r['title'] = set_style($r['title'], $r['style']);
				if($kw) $r['title'] = str_replace($replacef, $replacet, $r['title']);
				$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
				$r['introduce'] = dsubstr(dtrim($r['content']), 60, '...');
				$r['managers'] = $r['manager'] ? explode('|', $r['manager']) : array();
				$tags[] = $r;
			}
			$db->free_result($result);
		}
	} else if($action == 'reply') {
		$condition = 'status=3';
		if($keyword) $condition .= " AND content LIKE '%$keyword%'";
		if($username) $condition .= " AND passport='$username'";
		if($fromtime) $condition .= " AND addtime>=$fromtime";
		if($totime) $condition .= " AND addtime<=$totime";
		$items = $db->count($table.'_reply', $condition, $DT['cache_search']);
		$pages = pages($items, $page, $pagesize);
		if($items) {
			$result = $db->query("SELECT * FROM {$table}_reply WHERE {$condition} ORDER BY itemid DESC LIMIT {$offset},{$pagesize}", $DT['cache_search'] && $page == 1 ? 'CACHE' : '', $DT['cache_search']);
			while($r = $db->fetch_array($result)) {
				$r['adddate'] = timetodate($r['addtime'], 5);
				if(strpos($r['content'], '<hr class="club_break" />') !== false) $r['content'] = substr($r['content'], strpos($r['content'], '<hr class="club_break" />'));
				$r['title'] = get_intro($r['content'], 90);
				$r['alt'] = $r['title'];
				if($kw) $r['title'] = str_replace($replacef, $replacet, $r['title']);
				$r['linkurl'] = $MOD['linkurl'].'goto.php?itemid='.$r['itemid'];
				$tags[] = $r;
			}
			$db->free_result($result);
		}
	} else {
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
		$condition = 'status=3';
		if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		if($username) $condition .= " AND passport='$username'";
		if($fromtime) $condition .= " AND edittime>=$fromtime";
		if($totime) $condition .= " AND edittime<=$totime";

		if($pptsql) $condition .= $pptsql;//PPT		
		require MD_ROOT.'/club.class.php';
		$do = new club($moduleid);
		$tags = $do->get_list($condition, $MOD['order'], $DT['cache_search'] ? 'CACHE' : '');
		if($tags && $kw) {
			foreach($tags as $k=>$v) {
				$tags[$k]['title'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $v['title']);
			}
			if($page == 1) keyword($kw, $items, $moduleid);
		}
		$showpage = 1;
		$datetype = 5;
	}
}
$action or $action = 'post';
$seo_file = 'search';
include DT_ROOT.'/include/seo.inc.php';
if($EXT['mobile_enable']) {
	if($action == 'post') {
		$mgid = $tags ? $tags[0]['gid'] : 0;;
		$head_mobile = $EXT['mobile_url'].($kw ? 'index.php?moduleid='.$moduleid.'&catid='.$mgid.'&kw='.encrypt($kw, DT_KEY.'KW') : 'search.php?action=post'.$mgid);
	} else if($action == 'group') {
		$head_mobile = $EXT['mobile_url'].($kw ? 'index.php?moduleid='.$moduleid.'&kw='.encrypt($kw, DT_KEY.'KW') : 'search.php?action=mod'.$moduleid);
	}
}
include template('search', $module);
?>