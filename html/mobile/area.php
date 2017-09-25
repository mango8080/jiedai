<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
require 'common.inc.php';
if($moduleid < 4) $moduleid = 4;
$AREA = cache_read('area.php');
$pid = isset($pid) ? intval($pid) : 0;
$back_link = $pid ? 'area.php?moduleid='.$moduleid.'&pid='.$AREA[$pid]['parentid'] : mobileurl($moduleid);
$lists = array();
foreach($AREA as $a) {
	if($a['parentid'] == $pid) $lists[] = $a;
}
$head_title = $MOD['name'].$DT['seo_delimiter'].$head_title;
include template('area', 'mobile');
if(DT_CHARSET != 'UTF-8') toutf8();
?>