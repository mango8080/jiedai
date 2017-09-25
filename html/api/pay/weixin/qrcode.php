<?php

//请传入订单号
//order_id
require_once $_SERVER["DOCUMENT_ROOT"].'/common.inc.php';
//var_dump($_GET);exit();
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';


$fin=$db->get_one("Select a.*,b.ordercode From {$DT_PRE}finance_charge  as a LEFT JOIN {$DT_PRE}mall_order as b on substring(a.reason,7)=b.itemid where a.itemid={$order_id}");
if ($fin){
	$total_money=$fin['amount']+$fin['fee'];
	if($fin['ordercode']){
         $ordercode = $fin['ordercode'];
	}else{
          $ordercode = WxPayConfig::MCHID.date("YmdHis");
	}
}else{
	echo"<script>alert('支付错误,请重试!');history.go(-1);</script>";
}



//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
//$input->SetBody("test");
$input->SetBody("房费");
$input->SetAttach("test");
$input->SetOut_trade_no($ordercode);
//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($total_money*100);//正式
//$input->SetTotal_fee(1);//测试用
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://{$_SERVER["HTTP_HOST"]}/api/pay/weixin/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				 if(res.err_msg == "get_brand_wcpay_request:ok"){
                   //alert(res.err_code+res.err_desc+res.err_msg);
                       window.location.href="../success.inc.php?charge_orderid=<?php echo $order_id; ?>&charge_money=<?php echo $total_money; ?>";
                   }else{
                       //返回跳转到订单详情页面
                       alert(支付失败);
                       window.location.href="http://www.anluze.com/mobile/myorder.php";
                         
                   }
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}

	
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	
	
	</script>
</head>
<body style="display: none;">
    <br/>
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px"><?php echo $total_money;?>元</span>钱</b></font><br/><br/>
	<div align="center">
		<button id="click_pay" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div>
</body>
<script type="text/javascript">
	document.getElementById('click_pay').click();
</script>
</html>