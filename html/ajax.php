<?php
/*
	[Hotel System] Copyright (c) 2008-2016 www.idc580.cn
	
*/
require 'common.inc.php';
if($DT_BOT) dhttp(403);
if($action != 'mobile') {
	check_referer() or exit;
}
require DT_ROOT.'/include/post.func.php';
(isset($job) && check_name($job)) or $job = '';
@include DT_ROOT.'/api/ajax/'.$action.'.inc.php';
?>