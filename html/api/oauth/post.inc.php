<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
defined('IN_DESTOON') or exit('Access Denied');
isset($auth) or exit;
$d = decrypt($auth, DT_KEY.'SYNC');
strpos($d, '-') !== false or exit;
$t = explode('-', $d);
$moduleid = intval($t[0]);
$moduleid > 4 or exit;
isset($MODULE[$moduleid]) or exit;
$itemid = intval($t[1]);
$itemid > 0 or exit;
$item = $db->get_one("SELECT title,thumb,introduce,linkurl,addtime,status FROM ".get_table($moduleid)." WHERE itemid=$itemid");
$item or exit;
$item['status'] == 3 or exit;
$DT_TIME - $item['addtime'] < 30 or exit;
$title = $item['title'];
$introduce = $item['introduce'];
$thumb = str_replace('.thumb.', '.middle.', $item['thumb']);
$linkurl = strpos($item['linkurl'], '://') !== false ? $item['linkurl'] : $MODULE[$moduleid]['linkurl'].$item['linkurl'];
$content = ob_template('weibo', 'chip');
$content = convert($content, DT_CHARSET, 'UTF-8');
?>