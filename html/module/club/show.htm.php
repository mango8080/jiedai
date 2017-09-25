<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3) return false;
extract($item);
$CAT = get_cat($catid);
$GRP = get_group($gid);
$GRP['managers'] = $GRP['manager'] ? explode('|', $GRP['manager']) : array();
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);
if($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require_once DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$fileurl = $linkurl;
$linkurl = $MOD['linkurl'].$linkurl;
$admin = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if($fee) {
	$description = get_description($content, $MOD['pre_view']);
	$user_status = 4;
} else {
	$user_status = 3;
}
$F = explode('|', $MOD['floor']);
$pages = '';
$pagesize = $MOD['reply_pagesize'];
if($page == 1) {
	$items = $db->count($table.'_reply', "tid=$itemid AND status=3");
	if($items != $reply) {
		$item['reply'] = $reply = $items;
		$db->query("UPDATE {$table} SET reply=$reply WHERE itemid=$itemid");
	}
} else {
	$items = $reply;
}
$total = max(ceil($items/$pagesize), 1);
if(isset($fid) && isset($num) && $fid > 0) {
	$page = $fid;
	$topage = $fid + $num - 1;
	$total = $topage < $total ? $topage : $total;
}
$template = $item['template'] ? $item['template'] : ($GRP['show_template'] ? $GRP['show_template'] : 'show');
for(; $page <= $total; $page++) {
	$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid&page=$page";
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
	$filename = $total == 1 ? DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl : DT_ROOT.'/'.$MOD['moduledir'].'/'.itemurl($item, $page);
	$replys = array();
	if($items) {
		$offset = ($page-1)*$pagesize;
		$pages = pages($items, $page, $pagesize, $MOD['linkurl'].itemurl($item, '{destoon_page}'));
		$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
		$pages = pages($items, $page, $pagesize, $MOD['linkurl'].itemurl($item, '{destoon_page}'));
		$result = $db->query("SELECT * FROM {$table}_reply WHERE tid=$itemid AND status=3 ORDER BY itemid ASC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['fname'] = isset($F[$floor]) ? $F[$floor] : '';
			$r['floor'] = ++$floor;
			if($r['fid'] != $r['floor']) $db->query("UPDATE {$table}_reply SET fid='$r[floor]' WHERE itemid='$r[itemid]'");
			$replys[] = $r;
		}
	}
	$seo_file = 'show';
	include DT_ROOT.'/include/seo.inc.php';
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	if($DT['pcharset']) $filename = convert($filename, DT_CHARSET, $DT['pcharset']);
	file_put($filename, $data);
	if($page == 1 && $total > 1) {
		$indexname = DT_ROOT.'/'.$MOD['moduledir'].'/'.itemurl($item, 0);
		if($DT['pcharset']) $indexname = convert($indexname, DT_CHARSET, $DT['pcharset']);
		file_copy($filename, $indexname);
	}
}
return true;
?>