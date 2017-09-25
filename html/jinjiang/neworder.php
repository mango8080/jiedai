<?php
require '../common.inc.php';
// $url='https://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';

	// $order=$db->get_one("SELECT * FROM {$DT_PRE}mall_order WHERE itemid='14'");
	// 		$roomtype=$db->get_one("select roomtype,hotelid from {$DT_PRE}mall where itemid=".$order['mallid'] );
	// 		// 发送给锦江订单接口
	// 			$orderurl='https://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';
	// 			$order = array(
	// 					'order_code' => $order['ordercode'],
	// 					'order_inday' => timetodate($order['intime'],0),
	// 					'order_days' => $order['days'],
	// 					'order_price' => $order['price'],
	// 					'order_roomtype' => $roomtype['roomtype'],
	// 					'order_rateclass' => 'COR85',
	// 					'order_amount' => $order['amount'],
	// 					'order_truename' => $order['buyer_name'],
	// 					'order_mobile' => $order['buyer_mobile'],
	// 					'order_email' => $order['buyer_email'],
	// 					'order_note' => $order['note'],
	// 					'order_rooms' => $order['number'],
	// 					'order_arrivetime' => $order['arrivetime'],

	// 				 );

// $data= <<< XML
// <crsmessage createtime="" PropID="60853" user="ids_207_959177_xuzhouga" pass="959177xuzhou" msgtype="newresv" language="zh">
// 	<reservation>
// 		<outconfnum>20161026093113776831</outconfnum>
// 		<!--外部订单号-->
// 		<holdresv></holdresv>
// 		<!--holdresv=1表示订单需要支付，暂时锁定房量，如在30分钟内未完成解锁房量，CRS将自动取消该预订-->
// 		<isassure>4</isassure>
// 		<!--isassure=4,6 -->
// 		<bookedrates>
// 			<bookedrate>
// 				<date>2016-10-29</date>
// 				<rate>723.0</rate>
// 				<!--仅房价，与服务费和税金无关，必须与gercratemap和getonlineratemap响应的房价金额一致-->
// 				<excharge/>
// 				<!--加床费用，一般不用-->
// 				<currencycode>CNY</currencycode>
// 				<!--货币单位，使用ISO4217标准-->
// 			</bookedrate>
// 		</bookedrates>
// 		<staydetail>
// 			<date>2016-10-29</date>
// 			<nights>1</nights>
// 			<roomtype>BURA</roomtype>
// 			<rateclass>COR85</rateclass>
// 			<rooms>1</rooms>
// 			<promotioncode/>
// 			<!--促销代码，暂不使用-->
// 			<promotiondesc/>
// 			<adults>1</adults>
// 			<children/>
// 			<channel>Website</channel>
// 		</staydetail>
// 		<guestinfo>
// 			<firstname></firstname>
// 			<lastname>张建伟</lastname>
// 			<!--如无法拆分姓和名，请将客人统一传入lastname节点-->
// 			<phone>13877777777</phone>
// 			<mobile>13877777777</mobile>
// 			<email>mail@yourdomain.com</email>
// 			<street1></street1>
// 			<holdTime>16:00</holdTime>
// 			<!--客房保留时间，也是客人最晚到店时间-->
// 			<otherguest/>
// 		</guestinfo>
// 		<contactinfo>
// 			<name>张建伟</name>
// 			<phone>13877777777</phone>
// 			<mobile>13877777777</mobile>
// 			<email>mail@yourdomain.com</email>
// 			<fax/>
// 		</contactinfo>
// 		<paymentinfo>
// 			<payment>CASH</payment>
// 			<paymentstatus>0</paymentstatus>
// 			<!--paymentstatus=0 待支付-->
// 			<paymentamount></paymentamount>
// 			<!--支付金额-->
// 			<paymentsource/>
// 			<!--支付渠道-->
// 			<tradeno/>
// 			<!--交易编号-->
// 			<paidurl/>
// 			<!--第三方支付提交的url-->
// 			<returnurl/>
// 			<!--第三方支付返回的url-->
// 			<payresult/>
// 			<!--第三方返回的支付结果-->
// 		</paymentinfo>
// 		<remarks>
// 			<remark></remark>
// 		</remarks>
// 		<miscinfo>
// 			<maincontractedid/>
// 			<!--企业客户父帐户ID，使用于直销渠道-->
// 			<contractedid/>
// 			<!--企业客户ID，使用于直销渠道-->
// 			<companyno/>
// 			<!--协议公司编号-->
// 			<IATA>959177</IATA>
// 		</miscinfo>
// 		<tracelogid/>
// 		<!--对外跟踪编号-->
// 		<couponinfo>
// 			<coupon>
// 				<coupontype/>
// 				<!--优惠券类型-->
// 				<couponnum/>
// 				<!--优惠券编号-->
// 				<couponamount/>
// 				<!--优惠券面额-->
// 			</coupon>
// 			<couponcount/>
// 			<!--优惠券总数-->
// 			<coupontotalamount/>
// 			<!--优惠券总金额-->
// 		</couponinfo>
// 		<memberinfo>
// 			<guestid></guestid>
// 			<!--用户ID，使用于直销渠道-->
// 			<memberno></memberno>
// 			<!--用户卡号，使用于直销渠道-->
// 			<memberclass>SIL</memberclass>
// 			<!--用户等级，使用于直销渠道-->
// 		</memberinfo>
// 		<ccinfo>
// 			<ccexp/>
// 			<ccname/>
// 			<ccnum/>
// 			<cctype/>
// 			<cvv/>
// 		</ccinfo>
// 	</reservation>
// </crsmessage>
// XML;

				$order = array(
						'order_code' => '888889999999',
						'order_inday' => '2016-10-29',
						'order_days' => 1,
						'order_price' => 425.0,
						'order_roomtype' => 'DDSR',
						'order_rateclass' => 'COR85',
						'order_truename' => '令狐冲',
						'order_mobile' => '13388888888',
						'order_email' => 'ww@qq.com',
						'order_note' => '有窗户',
						'order_rooms' => 1,
						'order_arrivetime' => '17:00',

					 );
// $orderss=neworder($jjorderurl,$jjuser,$jjpass,$jjiata,'65001',$order);
// var_dump($orderss);exit;
function curlPost($url, $data = array(), $timeout = 30, $CA = true){   
 
    $cacert = 'hubs1.net.crt'; //CA根证书 
    $SSL = substr($url, 0, 8) == "https://" ? true : false; 
    $headers= array("Content-type: text/xml");
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2); 
    if ($SSL && $CA) { 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书 
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布） 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配 
    } else if ($SSL && !$CA) { 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名 
    } 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //避免data数据过长问题 
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode 
 
    $ret = curl_exec($ch); 
    //var_dump(curl_error($ch));  //查看报错信息 
 
    curl_close($ch); 
    return $ret;   
}  
// function curlPost($url, $data = array(), $timeout = 30, $CA = true){    
  
   
      
//     $ch = curl_init();  
//     $headers= array("Content-type: text/xml");
// 	curl_setopt ( $ch, CURLOPT_URL, $url );
// 	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers); 
//     curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);  

//      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

//     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0); // 使用自动跳转
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    
//     curl_setopt($ch, CURLOPT_POST, true);  
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
//     //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  
  
//     $ret = curl_exec($ch);  
//     var_dump(curl_error($ch));  //查看报错信息  
  
//     curl_close($ch);  
//     return $ret;    
// } 
// 订单
$data= <<< XML
<crsmessage createtime="" PropID="60875" user="$jjuser" pass="$jjpass" msgtype="newresv" language="zh">
	<reservation>
		<outconfnum>2011081500005118</outconfnum>
		<!--外部订单号-->
		<holdresv></holdresv>
		<!--holdresv=1表示订单需要支付，暂时锁定房量，如在30分钟内未完成解锁房量，CRS将自动取消该预订-->
		<isassure>4</isassure>
		<!--isassure=4,6 -->
		<bookedrates>
			<bookedrate>
				<date>2016-10-26</date>
				<rate>98.0</rate>
				<!--仅房价，与服务费和税金无关，必须与gercratemap和getonlineratemap响应的房价金额一致-->
				<excharge/>
				<!--加床费用，一般不用-->
				<currencycode>CNY</currencycode>
				<!--货币单位，使用ISO4217标准-->
			</bookedrate>
		</bookedrates>
		<staydetail>
			<date>2016-10-26</date>
			<nights>1</nights>
			<roomtype>OCQD</roomtype>
			<rateclass>COR85</rateclass>
			<rooms>1</rooms>
			<promotioncode/>
			<!--促销代码，暂不使用-->
			<promotiondesc/>
			<adults>1</adults>
			<children/>
			<channel>Website</channel>
		</staydetail>
		<guestinfo>
			<firstname></firstname>
			<lastname>预订</lastname>
			<!--如无法拆分姓和名，请将客人统一传入lastname节点-->
			<phone>13800000000</phone>
			<mobile>13800000000</mobile>
			<email> reservation.test@abc.com </email>
			<street1>北京西路1277号</street1>
			<holdTime>18:00</holdTime>
			<!--客房保留时间，也是客人最晚到店时间-->
			<otherguest/>
		</guestinfo>
		<contactinfo>
			<name>测试</name>
			<phone>13800000000</phone>
			<mobile>13800000000</mobile>
			<email>reservation.test@abc.com</email>
			<fax/>
		</contactinfo>
		<paymentinfo>
			<payment>CASH</payment>
			<paymentstatus>0</paymentstatus>
			<!--paymentstatus=0 待支付-->
			<paymentamount>888.0</paymentamount>
			<!--支付金额-->
			<paymentsource/>
			<!--支付渠道-->
			<tradeno/>
			<!--交易编号-->
			<paidurl/>
			<!--第三方支付提交的url-->
			<returnurl/>
			<!--第三方支付返回的url-->
			<payresult/>
			<!--第三方返回的支付结果-->
		</paymentinfo>
		<remarks>
			<remark>高楼层，无烟房，订单未支付</remark>
		</remarks>
		<miscinfo>
			<maincontractedid/>
			<!--企业客户父帐户ID，使用于直销渠道-->
			<contractedid/>
			<!--企业客户ID，使用于直销渠道-->
			<companyno/>
			<!--协议公司编号-->
			<IATA>959177</IATA>
		</miscinfo>
		<tracelogid/>
		<!--对外跟踪编号-->
		<couponinfo>
			<coupon>
				<coupontype/>
				<!--优惠券类型-->
				<couponnum/>
				<!--优惠券编号-->
				<couponamount/>
				<!--优惠券面额-->
			</coupon>
			<couponcount/>
			<!--优惠券总数-->
			<coupontotalamount/>
			<!--优惠券总金额-->
		</couponinfo>
		<memberinfo>
			<guestid></guestid>
			<!--用户ID，使用于直销渠道-->
			<memberno></memberno>
			<!--用户卡号，使用于直销渠道-->
			<memberclass>SIL</memberclass>
			<!--用户等级，使用于直销渠道-->
		</memberinfo>
		<ccinfo>
			<ccexp/>
			<ccname/>
			<ccnum/>
			<cctype/>
			<cvv/>
		</ccinfo>
	</reservation>
</crsmessage>
XML;
// 图片
// $data= <<< XML
// <crsmessage PropID="65001" user="$jjuser" pass="$jjpass" msgtype="getimage"> 
// </crsmessage>
// XML;
$today=date('Y-m-d');
// 实时房价
// $data= <<< XML
// <crsmessage PropID="65001" user="$jjuser" pass="$jjpass" msgtype="getonlineratemap" nolog="1">
// 	<options cascade="true"/>
// 	<staydetail>
// 		<date>$today</date>
// 		<nights>1</nights>
// 		<roomtype>BURA</roomtype>
// 		<rateclass>BAR</rateclass>
// 		<rooms>1</rooms>
// 		<adults>1</adults>
// 		<filter>0</filter>
// 		<channel>Website</channel>
// 	</staydetail>
// <iata>959177</iata>
// </crsmessage>
// XML;

// $data= <<< XML
// <crsmessage PropID="66027" user="$jjuser" pass="$jjpass" msgtype="getcratemap" nolog="1">
// 	<options cascade="true"/>
// 	<staydetail>
// 		<date>2016-10-09</date>
// 		<nights>1</nights>
// 		<roomtype>BURA</roomtype>
// 		<rateclass></rateclass>
// 		<rooms>1</rooms>
// 		<adults>1</adults>
// 		<children/>
// 		<filter>0</filter>
// 		<channel>Website</channel>
// 	</staydetail>
// 	<iata>959177</iata>
// </crsmessage>
// XML;
$url='https://taxmltest.hubs1.net/servlet/SwitchReceiveServlet';

// $prices=getprice($url,$jjuser,$jjpass,'959177','66027','2016-10-13',1,'BURA');

// $response = curlxml($url,$data);
// var_dump($response);exit;
// $ch = curl_init ();
// $headers= array("Content-type: text/xml");
// curl_setopt ( $ch, CURLOPT_URL, $url );
// curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers);
// // curl_setopt ( $ch, CURLOPT_HEADER, TRUE);    //表示需要response header
// // curl_setopt ( $ch, CURLOPT_NOBODY, FALSE);  //表示需要response body
// curl_setopt ( $ch, CURLOPT_POST, 1 );//采用post
// curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
// curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
// curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, FALSE);
// curl_setopt ( $ch, CURLOPT_AUTOREFERER, TRUE);
// curl_setopt ( $ch, CURLOPT_TIMEOUT, 120);
// $response=curl_exec ( $ch );
// if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
// $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
// $header = substr($response, 0, $headerSize);
// $body = substr($response, $headerSize);
// $res = json_decode($body); // 解析回来的数组

// }
// curl_close ( $ch );

$response = curlPost($url,$data,$timeout = 30, $CA = true);
$xml  =  simplexml_load_string ( $response );
$r=object2array($xml);
var_dump($response);
// $thumb='';
// $caption='商务房A';
// foreach ($r["gallerys"] as $key => $value) {
	
// 	foreach ($value["gallery"] as $k => $v) {
// 		if ($v['caption']==$caption) {
// 			$thumb=$v['imageUrl'].'|';
// 			echo $v['imageUrl'];
// 		}
		
// 	}
// }

