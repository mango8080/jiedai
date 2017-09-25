<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
require 'common.inc.php';
if($moduleid < 4) $moduleid = 4;
$pid = isset($pid) ? intval($pid) : 0;
if($pid) {
	$P = get_cat($pid);
	$back_link = 'category.php?moduleid='.$moduleid.'&pid='.$P['parentid'];
} else {
	$back_link = mobileurl($moduleid);
}
$lists = get_maincat($pid, $moduleid);
$head_title = $MOD['name'].$DT['seo_delimiter'].$head_title;
include template('category', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>