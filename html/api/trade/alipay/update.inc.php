<?php
/*
	[Hotel System] Copyright (c) 2008-2015 www.idc580.cn
	
*/
defined('IN_DESTOON') or exit('Access Denied');
if(in_array($step, array('refund', 'add_time', 'receive_goods', 'get_pay', 'send_goods'))) {
	dheader('https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo='.$td['trade_no']);
} else {
	include DT_ROOT.'/api/trade/'.$DT['trade'].'/config.inc.php';
	$aliapy_config['seller_email'] = $seller['trade'];
	include DT_ROOT.'/api/trade/'.$DT['trade'].'/'.$api.'/pay.inc.php';
}
?>