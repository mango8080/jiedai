<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
require '../../../common.inc.php';
$itemid = intval(get_cookie('trade_id'));
if($itemid) {
	$r = $db->get_one("SELECT mid,mallid FROM {$DT_PRE}mall_order WHERE itemid=$itemid");
	if($r) dheader(DT_PATH.'api/redirect.php?mid='.$r['mid'].'&itemid='.$r['mallid']);
} 
dheader(isset($MODULE[16]) ? $MODULE[16]['linkurl'] : DT_PATH);
?>