<?php
require '../../../common.inc.php';
$charge_title = '';
if($action == 'ajax') {
	$itemid or exit('ko');
} else {
	echo $auth = isset($auth) ? decrypt($auth, DT_KEY.'JSAPI') : '';
	die;
	$auth or dheader($MODULE[2]['linkurl'].'charge.php?action=record');
	$t = explode('|', $auth);
	$itemid = $orderid = intval($t[0]);
	($itemid && $t[2] == $DT_IP) or dheader($MODULE[2]['linkurl'].'charge.php?action=record');
	$charge_title = $t[1];
}

$r = $db->get_one("SELECT * FROM {$DT_PRE}finance_charge WHERE itemid=$itemid");
if($action == 'ajax') {
	if($r && $r['status'] == 3) exit('ok');
	exit('ko');
}
if(!$r || !$_username || $r['username'] != $_username || $r['status'] != 0 || $r['bank'] != 'weixin') dheader($MODULE[2]['linkurl'].'charge.php?action=record');
$bank = 'weixin';
$PAY = cache_read('pay.php');

$PAY[$bank]['enable'] or dheader($MODULE[2]['linkurl'].'charge.php?action=record');
function make_sign($arr, $key) {
	ksort($arr);
	$str = '';
	foreach($arr as $k=>$v) {
		if($v) $str .= $k.'='.$v.'&';
	}
	$str .= 'key='.trim("4ae0a166b93b1c60c131e319c7137168");
	return strtoupper(md5($str));
}
function make_xml($arr) {
	$str = '<xml>';
	foreach($arr as $k=>$v) {
		if(is_numeric($v)) {
			$str .= '<'.$k.'>'.$v.'</'.$k.'>';
		} else {
			$str .= '<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
		}
	}
	$str .= '</xml>';
	return $str;
}
$charge = $r['amount'] + $r['fee'];
$total_fee = $charge*100;
$post = array();
$post['appid'] = $PAY[$bank]['appid'];
$post['mch_id'] = $PAY[$bank]['partnerid'];
$post['nonce_str'] = md5(md5($itemid.$PAY[$bank]['keycode'].$total_fee));
$post['body'] = $charge_title ? $charge_title : '用户('.$_username.')充值(流水号:'.$orderid.')';
$post['body'] = convert($post['body'], DT_CHARSET, 'UTF-8');
$post['out_trade_no'] = $itemid;
$post['total_fee'] = $total_fee;
$post['spbill_create_ip'] = $DT_IP;
$post['notify_url'] = DT_PATH.($PAY[$bank]['notify'] ? $PAY[$bank]['notify'] : 'notify.php');
$post['trade_type'] = 'JSAPI';
$post['product_id'] = $itemid;
$post['openid'] = $t[3];
$post['sign'] = make_sign($post, $PAY[$bank]['keycode']);
$rec = dcurl('https://api.mch.weixin.qq.com/pay/unifiedorder', make_xml($post));
//var_dump($rec);exit;
if(strpos($rec, 'code_url') !== false) {
	if(function_exists('libxml_disable_entity_loader')) libxml_disable_entity_loader(true);
	$x = simplexml_load_string($rec, 'SimpleXMLElement', LIBXML_NOCDATA);
} else {
	if(strpos($rec, 'return_msg') !== false) {
		if(function_exists('libxml_disable_entity_loader')) libxml_disable_entity_loader(true);
		$x = simplexml_load_string($rec, 'SimpleXMLElement', LIBXML_NOCDATA);
		exit($x->return_msg);
	} else {
		exit('Can Not Connect weixin');
		
	}
}

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信支付<?php echo $DT['seo_delimiter'];?><?php echo $DT['sitename'];?></title>
	<style>
	* {word-break:break-all;font-family:"Segoe UI","Lucida Grande",Helvetica,Arial,Verdana,"Microsoft YaHei";}
	body {margin:0;font-size:14px;color:#333333;background:#EFEFF4;-webkit-user-select:none;}
	</style>
</head>
<body>
	<div style="width:100%;text-align:center;">
		<div style="line-height:20px;font-weight:bold;margin-top:30px;">微信支付</div>
		<div style="line-height:20px;font-weight:bold;"><span style="font-size:18px;"><?php echo $DT['money_sign'];?></span><span style="font-size:22px;"><?php echo str_replace('.', '</span><span style="font-size:16px;">.', strpos($charge, '.') === false ? $charge.'.00' : $charge);?></span></div>
		<img src="<?php echo DT_PATH;?>api/qrcode.png.php?auth=<?php echo encrypt($x->code_url, DT_KEY.'QRCODE');?>" style="width:180px;height:180px;margin:10px 0;"/>
		<div style="padding:0 16px;font-size:16px;color:#555555;line-height:32px;">		
		<?php
		if($DT_TOUCH) {
			echo $DT_MOB['browser'] == 'weixin' ? '请长按上面的二维码<br/>选择识别图中二维码' : '请使用微信扫描二维码完成支付<br/><a href="http://app.idc580.cn/scan/" rel="external" style="color:#2E7DC6;text-decoration:none;">如何扫描？</a>';
		} else {
			echo '请打开手机微信<br/>扫一扫上面的二维码';
		}
		?>
		</div>
		<div style="padding:0 16px;font-size:16px;margin-top:20px;">
		<a href="<?php echo $MODULE[2]['linkurl'];?>charge.php" style="color:#2E7DC6;text-decoration:none;">已经支付</a>
		&nbsp;&nbsp;
		<a href="<?php echo $MODULE[2]['linkurl'];?>charge.php?action=record" style="color:#2E7DC6;text-decoration:none;">取消支付</a>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
	<script type="text/javascript">
	var interval = window.setInterval(
		function() {
			$.get('?action=ajax&itemid=<?php echo $itemid;?>', function(data) {
				if(data == 'ok') {
					clearInterval(interval);
					window.location.href = '<?php echo $MODULE[2]['linkurl'];?>charge.php';
				}
			});
		}, 
	3000);
	</script>
</body>
</html>