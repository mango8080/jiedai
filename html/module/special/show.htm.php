<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3 || $item['islink'] > 0) return false;
extract($item);
$CAT = get_cat($catid);
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($lazy) $content = img_lazy($content);

$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require_once DT_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}

$TYPE = array();
foreach(get_type('special-'.$itemid) as $v) {
	$v['linkurl'] = $MOD['linkurl'].rewrite('type.php?tid='.$v['typeid']);
	$TYPE[] = $v;
}
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$fileurl = $domain ? $filepath : $linkurl;
$linkurl = $MOD['linkurl'].$linkurl;
$user_status = 3;
$seo_file = 'show';
include DT_ROOT.'/include/seo.inc.php';
if($item['seo_title']) $seo_title = $item['seo_title'];
if($item['seo_keywords']) $head_keywords = $item['seo_keywords'];
if($item['seo_description']) $head_description = $item['seo_description'];
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
$filename = DT_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl;
if($DT['pcharset']) $filename = convert($filename, DT_CHARSET, $DT['pcharset']);
file_put($filename, $data);
return true;
?>