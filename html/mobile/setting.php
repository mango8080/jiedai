<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
require 'common.inc.php';
$file = DT_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/mobile.php';
$local = get_cookie('mobile_setting');
$MOB_MOD = array();
foreach($MOB_MODULE as $m) {
	$MOB_MOD[$m['moduleid']] = $m;
}
if($action == 'sync') {
	isset($id) or $id = '';
	if($id == 'clear') {
		if($_userid) file_del($file);
		set_cookie('mobile_setting', '');
		exit('ok');
	} else {
		$ids = '';
		foreach(explode(',', $id) as $mid) {
			$mid = intval($mid);
			if(isset($MOB_MOD[$mid])) $ids .= ','.$mid;
		}
		if($ids) $ids = substr($ids, 1);
		if(substr_count($ids, ',') > 1) {
			if($_userid) file_put($file, $ids);
			set_cookie('mobile_setting', $ids, $DT_TIME + 30*86400);
			exit('ok');
		}
	}
	exit('ko');
}
if($_userid) {
	$data = file_get($file);
	$data or $data = $local;
} else {
	$data = $local;
}
if($data) {
	$my_str = $rm_str = '';
	foreach(explode(',', $data) as $id) {
		if(isset($MOB_MOD[$id])) $my_str .= ','.$id;
	}
	if($my_str) $my_str = substr($my_str, 1);
	$my_arr = explode(',', $my_str);
	if(count($my_arr) > 1) {
		foreach($MOB_MODULE as $m) {
			if(!in_array($m['moduleid'], $my_arr)) $rm_str .= ','.$m['moduleid'];
		}
		if($rm_str) $rm_str = substr($rm_str, 1);
		$rm_arr = $rm_str ? explode(',', $rm_str) : array();
	} else {
		if($_userid) file_del($file);
		set_cookie('mobile_setting', '');
		$my_str = $rm_str = '';
		foreach($MOB_MODULE as $m) {
			$my_str .= ','.$m['moduleid'];
		}
		if($my_str) $my_str = substr($my_str, 1);
		$my_arr = explode(',', $my_str);
		$rm_arr = array();
	}
} else {
	$my_str = $rm_str = '';
	foreach($MOB_MODULE as $m) {
		$my_str .= ','.$m['moduleid'];
	}
	if($my_str) $my_str = substr($my_str, 1);
	$my_arr = explode(',', $my_str);
	$rm_arr = array();
}
$head_name = $L['setting_title'];
$head_title = $head_name.$DT['seo_delimiter'].$head_title;
$foot = '';
include template('setting', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>