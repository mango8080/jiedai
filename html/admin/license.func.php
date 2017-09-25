<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
defined('DT_ADMIN') or exit('Access Denied');
function edition($k = -1) {
	$E = array();
	$E[0] = DT_DOMAIN;
	$E[1] = '&#20010;&#20154;&#29256;';
	return $k >= 0 ? $E[$k] : $E;
}
?>