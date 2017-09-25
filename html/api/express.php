<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
$_COOKIE = array();
require '../common.inc.php';
function get_express_home($name) {
	$name = strtolower($name);
	if(strpos($name, '顺丰') !== false) return 'http://www.sf-express.com/cn/sc/';
	if(strpos($name, '申通') !== false) return 'http://www.sto.cn/';
	if(strpos($name, '圆通') !== false) return 'http://www.yto.net.cn/cn/index/index.html';
	if(strpos($name, '中通') !== false) return 'http://www.zto.cn/';
	if(strpos($name, '宅急送') !== false) return 'http://www.zjs.com.cn/';
	if(strpos($name, '韵达') !== false) return 'http://www.yundaex.com/';
	if(strpos($name, '天天') !== false) return 'http://www.ttkdex.com/';
	if(strpos($name, '如风达') !== false) return 'http://www.rufengda.com/';
	if(strpos($name, '汇通') !== false) return 'http://www.htky365.com/';
	if(strpos($name, '全峰') !== false) return 'http://www.qfkd.com.cn/';
	if(strpos($name, 'ems') !== false) return 'http://www.ems.com.cn/';
	return '';
}
function get_express_code($name) {
	#http://code.google.com/p/kuaidi-api/wiki/Open_API_Chaxun_URL
	$name = strtolower($name);
	if(strpos($name, '顺丰') !== false) return 'sf';
	if(strpos($name, '申通') !== false) return 'st';
	if(strpos($name, '圆通') !== false) return 'yt';
	if(strpos($name, '中通') !== false) return 'zt';
	if(strpos($name, '宅急送') !== false) return 'zjs';
	if(strpos($name, '韵达') !== false) return 'yd';
	if(strpos($name, '天天') !== false) return 'tt';
	if(strpos($name, '如风达') !== false) return 'rufengda';
	if(strpos($name, '汇通') !== false) return 'huitongkuaidi';
	if(strpos($name, '全峰') !== false) return 'quanfengkuaidi';
	if(strpos($name, 'ems') !== false) return 'ems';
	if(strpos($name, 'dhl') !== false) return 'dhl';
	if(strpos($name, 'ups') !== false) return 'ups';
	if(strpos($name, 'tnt') !== false) return 'tnt';
	if(strpos($name, 'fedex') !== false) return 'fedex';
	if(strpos($name, '联邦') !== false) return 'lianb';
	return '';
}
$e = isset($e) ? trim($e) : '';
$n = isset($n) ? trim($n) : '';
if($action == 'home') {
	if($e) {
		$u = get_express_home($e);
		if($u) dheader($u.'?no='.$n);
	}
	dheader('http://www.baidu.com/s?wd='.urlencode($e.' ').$n);
} else {
	if($e && $n) {
		$c = get_express_code($e);
		if($c) dheader('http://www.kuaidi100.com/chaxun?com='.$c.'&nu='.$n);
	}
	dheader('http://www.kuaidi100.com/?nu='.$n);
}
?>